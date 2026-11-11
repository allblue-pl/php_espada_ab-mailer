<?php namespace EC\ABMailer;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;
use EC\ABMailer\_Tables\_TMails;
use EC\ABMailer\_TableVariants\_TMailLogs_Grouped;
use EC\Database\MDatabase;

class TMailLogs_Grouped extends _TMailLogs_Grouped {
    public function __construct(MDatabase $db, $tablePrefix = 'abm_ml') {
        parent::__construct($db, $tablePrefix);

        $this->addColumns_Ref_All(new _TMails($db), "Mail_", [ "_Id" ]);

        $this->setJoin(
            " INNER JOIN ABMailer_Mails AS abm_m" .
            " ON abm_m._Id = abm_ml.Mail__Id"
        );

        $this->setGroupBy("abm_ml.Mail__Id");
    }
}