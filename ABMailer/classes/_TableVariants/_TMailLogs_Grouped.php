<?php namespace EC\ABMailer\_TableVariants;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;
use EC\ABData\HABTablesHelper;
use EC\Database;
use EC\Database\MDatabase;
use EC\Database\TTable;
use EC\ABMailer\_Tables\_TMailLogs;
use Override;

/**
 *
 * @phpstan-type _T_TVRABMailer_MailLogs_Grouped array{
 *     Id: int,
 *     Mail__Id: int,
 *     DateTime: int,
 *     Error: int,
 *     Data: mixed,
 *     Mail_Id: int,
 *     Mail_ToMail: string,
 *     Mail_ToName: string,
 *     Mail_Data: mixed,
 *     Mail_TryNr: int,
 *     Mail_NextTry: int|null,
 *     Mail_Sent: int|null,
 * }
 */
abstract class _TMailLogs_Grouped extends _TMailLogs {
    /**
     *
     * @param _T_TVRABMailer_MailLogs_Grouped $row
     * @return _T_TVRABMailer_MailLogs_Grouped
     */
    static public function AssertRow(array $row): array {
        return $row;
    }

    /**
     *
     * @param list<_T_TVRABMailer_MailLogs_Grouped> $rows
     * @return list<_T_TVRABMailer_MailLogs_Grouped>
     */
    static public function AssertRows(array $rows): array {
        return $rows;
    }

    // /**
    //  *
    //  * @param array|null $row
    //  * @return _T_TVRABMailer_MailLogs_Grouped|null
    //  */
    // static public function CastRow(array|null $row): array|null {
    //     /* phpstan-ignore return.type */
    //     return $row;
    // }

    // /**
    //  *
    //  * @param array $rows
    //  * @return list<_T_TVRABMailer_MailLogs_Grouped>
    //  */
    // static public function CastRows(array $rows): array {
    //     return $rows;
    // }


    public function __construct(MDatabase $db, $tablePrefix = 'abm_ml') {
        parent::__construct($db, $tablePrefix);
    }

    /** 
     * @return _T_TVRABMailer_MailLogs_Grouped|null
     */
     #[Override]
    public function row_ByColumn(string $colName, mixed $colValue, 
            string $groupExtension = '', bool $forUpdate = false): array|null {
        /* @phpstan-ignore return.type */
        return parent::row_ByColumn($colName, $colValue, $groupExtension, $forUpdate);
    }

    /** 
     * @return _T_TVRABMailer_MailLogs_Grouped|null
     */
    #[Override]
    public function row_ByPKs(array $keys, string $groupExtension = '', 
            bool $forUpdate = false): array|null {
        /* @phpstan-ignore return.type */
        return parent::row_ByPKs($keys, $groupExtension, $forUpdate);
    }

    /** 
     * @return _T_TVRABMailer_MailLogs_Grouped|null
     */
    #[Override]
    public function row_Where(array $conditions = [], string $groupExtension = '',
            bool $forUpdate = false): array|null {
        /* @phpstan-ignore return.type */
        return parent::row_Where($conditions, $groupExtension, $forUpdate);
    }

    /** 
     * @return list<_T_TVRABMailer_MailLogs_Grouped>
     * @phpstan-ignore method.childReturnType
     */
    #[Override]
    public function select_ByPKs(array $pks, string $groupExtension = ''): array {
        /* @phpstan-ignore return.type */
        return parent::select_ByPKs($pks, $groupExtension);
    }

    /** 
     * @return list<_T_TVRABMailer_MailLogs_Grouped>
     * @phpstan-ignore method.childReturnType
     */
    #[Override]
    public function select_Where(array $conditions = [], string $groupExtension = '',
            bool $tableOnly = false): array {
        /* @phpstan-ignore return.type */
        return parent::select_Where($conditions, $groupExtension);
    }
}
