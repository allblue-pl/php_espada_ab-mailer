<?php namespace EC\ABMailer\_Tables;
defined('_ESPADA') or die(NO_ACCESS);

use E, EC;
use EC\ABData\HABTablesHelper;
use EC\Database;
use EC\Database\MDatabase;
use EC\Database\TTable;
use Override;

/**
 *
 * @phpstan-type _T_TRABMailer_Mails array{
 *     Id: int,
 *     ToMail: string,
 *     ToName: string,
 *     Data: mixed,
 *     TryNr: int,
 *     NextTry: int|null,
 *     Sent: int|null,
 * }
 * @phpstan-type _T_TRABMailer_Mails_Insert array{
 *     Id: int|null,
 *     ToMail: string,
 *     ToName: string,
 *     Data: mixed,
 *     TryNr: int,
 *     NextTry: int|null,
 *     Sent: int|null,
 * }
 * @phpstan-type _T_TRABMailer_Mails_Update array{
 *     Id?: int|null,
 *     ToMail?: string,
 *     ToName?: string,
 *     Data?: mixed,
 *     TryNr?: int,
 *     NextTry?: int|null,
 *     Sent?: int|null,
 * }
 * @phpstan-type _T_TRABMailer_Mails_Variant array{
 *     Id: int,
 *     ToMail: string,
 *     ToName: string,
 *     Data: mixed,
 *     TryNr: int,
 *     NextTry: int|null,
 *     Sent: int|null,
 *     ...<string,mixed>}
 */
class _TMails extends TTable {
    /**
     *
     * @param _T_TRABMailer_Mails $row
     * @return _T_TRABMailer_Mails
     */
    static public function AssertRow(array $row): array {
        return $row;
    }

    /**
     *
     * @param _T_TRABMailer_Mails_Insert $row
     * @return _T_TRABMailer_Mails_Insert
     */
    static public function AssertRow_Insert(array $row): array {
        return $row;
    }

    /**
     *
     * @param _T_TRABMailer_Mails_Update $row
     * @return _T_TRABMailer_Mails_Update
     */
    static public function AssertRow_Update(array $row): array {
        return $row;
    }

    /**
     *
     * @param list<_T_TRABMailer_Mails> $rows
     * @return list<_T_TRABMailer_Mails>
     */
    static public function AssertRows(array $rows): array {
        return $rows;
    }

    // /**
    //  *
    //  * @param array|null $row
    //  * @return _T_TRABMailer_Mails|null
    //  */
    // static public function CastRow(array|null $row): array|null {
    //     /* phpstan-ignore return.type */
    //     return $row;
    // }

    // /**
    //  *
    //  * @param array $rows
    //  * @return list<_T_TRABMailer_Mails>
    //  */
    // static public function CastRows(array $rows): array {
    //     return $rows;
    // }

    /**
     *
     * @param _T_TRABMailer_Mails_Variant $row
     * @return _T_TRABMailer_Mails
     */
    static public function RawRow(MDatabase $db, array $row): array {
        $table = new _TMails($db);

        /* @phpstan-ignore return.type */
        return $table->stripRow($row);
    }


    public function __construct(MDatabase $db, $tablePrefix = 'abm_m') {
        parent::__construct($db, 'ABMailer_Mails', $tablePrefix);

        $this->setColumns([
            'Id' => new Database\FLong(true), 
            'ToMail' => new Database\FString(true, 128), 
            'ToName' => new Database\FString(true, 128), 
            'Data' => new Database\FText(true, 'medium'), 
            'TryNr' => new Database\FInt(true, false), 
            'NextTry' => new Database\FTime(false), 
            'Sent' => new Database\FTime(false), 
        ]);
        $this->setPKs([ 'Id' ]);

        $this->setColumnParser_JSON("Data");

        HABTablesHelper::SetTableVFields($this);
    }

    /** 
     * @return _T_TRABMailer_Mails|null
     */
     #[Override]
    public function row_ByColumn(string $colName, mixed $colValue, 
            string $groupExtension = '', bool $forUpdate = false): array|null {
        /* @phpstan-ignore return.type */
        return parent::row_ByColumn($colName, $colValue, $groupExtension, $forUpdate);
    }

    /** 
     * @return _T_TRABMailer_Mails|null
     */
    #[Override]
    public function row_ByPKs(array $keys, string $groupExtension = '', 
            bool $forUpdate = false): array|null {
        /* @phpstan-ignore return.type */
        return parent::row_ByPKs($keys, $groupExtension, $forUpdate);
    }

    /** 
     * @return _T_TRABMailer_Mails|null
     */
    #[Override]
    public function row_Where(array $conditions = [], string $groupExtension = '',
            bool $forUpdate = false): array|null {
        /* @phpstan-ignore return.type */
        return parent::row_Where($conditions, $groupExtension, $forUpdate);
    }

    /** 
     * @return list<_T_TRABMailer_Mails>
     */
    #[Override]
    public function select_ByPKs(array $pks, string $groupExtension = ''): array {
        return parent::select_ByPKs($pks, $groupExtension);
    }

    /** 
     * @return list<_T_TRABMailer_Mails>
     */
    #[Override]
    public function select_Where(array $conditions = [], string $groupExtension = '',
            bool $tableOnly = false): array {
        return parent::select_Where($conditions, $groupExtension);
    }

    /** 
     * @return _T_TRABMailer_Mails
     */
    #[Override]
    public function stripRow_TableColumnsOnly(array $row): array {
        /* @phpstan-ignore return.type */
        return parent::stripRow_TableColumnsOnly($row);
    }
}
