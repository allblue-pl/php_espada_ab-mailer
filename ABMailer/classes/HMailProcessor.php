<?php namespace EC\ABMailer;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;
use EC\ABMailer\_Tables\_TMails;
use EC\Database\MDatabase;

class HMailProcessor {
    static public function Add(MDatabase $db, string $toMail, string $toName,
            array $data, int|null &$id = null): bool {
        touch(E\Path::Data("ABMailer", "hasMail"));

        $tMails = new _TMails($db);
        if (!$tMails->update([ _TMails::AssertRow_Insert([
            "Id" => null,
            "ToMail" => $toMail,
            "ToName" => $toName,
            "Data" => $data,
            "TryNr" => 0,
            "NextTry" => time() - 1,
            "Sent" => null,
                ]) ]))
            return false;

        $id = $tMails->getLastInsertedId();

        return true;
    }
}