<?php namespace EC\ABMailer;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;
use EC\ABMailer\_Tables\_TLogs;
use EC\ABMailer\_Tables\_TMailLogs;
use EC\ABMailer\_Tables\_TMails;
use EC\Api\AApi;
use EC\Api\CArgs;
use EC\Api\CResult;
use EC\Api\SApi;
use EC\Api\SDBApi;
use EC\Config\HConfig;
use EC\Database\MDatabase;
use EC\Mailer\CMail;
use EC\Text\HText;
use Exception;
use Override;


/**
 * @phpstan-import-type _T_TRABMailer_Mails_Variant from EC\ABMailer\_Tables\_TMails
 */
class AMailer extends AApi {
    private CMailProcessor $mailProcessor;
    private MDatabase $db;

    public function __construct(SDBApi $site, array $args) {
        parent::__construct($site);

        if (!isset($args['mailProcessorClass']))
            throw new \Exception('No `mailProcessorClass` specified in api args.');

        $site->onLoad(function () {
            $args = E\Args::Uri_Extra();
            if (count($args) < 1)
                return;
            if ($args[0] !== "process-queue")
                return;

            if (!E\Path::Data_Exists("ABMailer", "hasMail")) {
                $result = CResult::Success();
                echo $result->getJSON();
                exit();
            }
        });

        $this->db = $site->getDB();

        $mailProcessor = new ($args["mailProcessorClass"])();
        if (!($mailProcessor instanceof CMailProcessor))
            throw new Exception("'mailProcessorClass' does not inherit from 'CMailProcessor'.");

        $this->mailProcessor = $mailProcessor;

        $this->action("process-mail", "action_ProcessMail", [
            "secret" => true,
            "id" => true,
        ]);
        $this->action("process-queue", "action_ProcessQueue", [
            "secret" => true,
        ]);
    }

    public function action_ProcessMail(CArgs $args): CResult {
        $id = (int)$args->get("id");

        $this->db->transaction_Start();

        $rMail = (new _TMails($this->db))->row_ByPKs([ $id ], "", true);
        if ($rMail === null) {
            $this->db->transaction_Finish(false);
            return CResult::Failure(HText::_("ABMailer:Errors_MailDoesNotExist", 
                    [ $id ]));
        }

        $mailError = null;
        $logData = null;

        try {
            $mailError = $this->mailProcessor->process($rMail["ToMail"], 
                    $rMail["ToName"], $rMail["Data"]);
        } catch (Exception $e) {
            $mailError = HText::_("ABMailer:Errors_Exception");
            $logData = [
                "errorMessage" => $e->getMessage(),
                "errorBacktrace" => $e->getTrace(),
            ];
        }

        if (!(new _TMails($this->db))->update([ _TMails::AssertRow_Update([
            "Id" => $rMail["Id"],
            "Sent" => $mailError === null ? time() : null,
            "NextTry" => null,
                ]) ])) {
            $this->db->transaction_Finish(false);
            return CResult::Failure(HText::_("ABMailer:Errors_CannotUpdateMailLogs"));
        }

        if (!(new _TMailLogs($this->db))->update([ _TMailLogs::AssertRow_Insert([
            "Id" => null,
            "DateTime" => time(),
            "Error" => $mailError,
            "Data" => $logData,
            "Mail__Id" => $id,
                ]) ])) {
            $this->db->transaction_Finish(false);
            return CResult::Failure(HText::_("ABMailer:Errors_CannotUpdateMailLogs"));
        }

        if (!$this->db->transaction_Finish(true))
            return CResult::Failure(HText::_("ABMailer:Errors_CannotCommit"));

        if ($mailError !== null)
            return CResult::Failure(HText::_("ABMailer:Errors_MailNotSent", 
                    [ $mailError ]));
        
        return CResult::Success();
    }

    public function action_ProcessQueue(CArgs $args): CResult {
        $this->db->transaction_Start();

        $mailsCount = HConfig::GetRequired("ABMailer", "mailsProcessorQueueCount");

        $tMails = new _TMails($this->db);

        $rMails = $tMails->select_Where([
            [ "NextTry", "<=", time() ],
        ], "ORDER BY Id LIMIT {$mailsCount}");

        if (count($rMails) < $mailsCount) {
            try {
                unlink(E\Path::Data("ABMailer", "hasMail"));
            } catch (Exception $e) {
                // Do nothing
            }
        }

        $rMails_Update = [];
        foreach ($rMails as $rMail) {
            $rMails_Update[] = _TMails::AssertRow_Update([
                "Id" => $rMail["Id"],
                "NextTry" => $this->getNextTry($rMail),
                "TryNr" => $rMail["TryNr"] + 1,
            ]);
        }
        if (!$tMails->update($rMails_Update)) {
            $this->db->transaction_Finish(false);
            return CResult::Failure("Cannot update mails before sending.");
        }
        if (!$this->db->transaction_Finish(true))
            return CResult::Failure("Cannot commit before sending.");

        $rMails_Update = [];
        $rLogs_Update = [];
        foreach ($rMails as $rMail) {
            $mailError = null;
            $logData = null;
            try {
                $mailError = $this->mailProcessor->process($rMail["ToMail"], 
                        $rMail["ToName"], $rMail["Data"]);
            } catch (Exception $e) {
                $mailError = HText::_("ABMailer:Errors_Exception");
                $logData = [
                    "errorMessage" => $e->getMessage(),
                    "errorBacktrace" => $e->getTrace(),
                ];
            }

            if ($mailError === null) {
                $rMails_Update[] = _TMails::AssertRow_Update([
                    "Id" => $rMail["Id"],
                    "Sent" => time(),
                ]);
            } else {
                $rLogs_Update[] = _TMailLogs::AssertRow_Insert([
                    "Id" => null,
                    "Data" => $logData,
                    "DateTime" => time(),
                    "Error" => $mailError,
                    "Mail__Id" => $rMail["Id"],
                ]);
            }
        }

        if (!$tMails->update($rMails_Update))
            CResult::Failure("Cannot update mails after sending.");

        if (!(new _TMailLogs($this->db))->update($rLogs_Update))
            CResult::Failure("Cannot update mail logs after sending.");
        
        return CResult::Success();
    }


    /**
     * @param _T_TRABMailer_Mails_Variant $rMail 
     * @return int|null
     */
    private function getNextTry(array $rMail): int|null {
        $tries = HConfig::GetRequired("ABMailer", "mailsProcessorQueueTries");

        return $rMail["TryNr"] >= count($tries) ? 
                null : (time() + $tries[$rMail["TryNr"]]);
    }
}