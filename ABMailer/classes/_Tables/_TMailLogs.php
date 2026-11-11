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
 * @phpstan-type _T_TRABMailer_MailLogs array{
 *     Id: int,
 *     Mail__Id: int,
 *     DateTime: int,
 *     Error: int,
 *     Data: mixed,
 * }
 * @phpstan-type _T_TRABMailer_MailLogs_Insert array{
 *     Id: int|null,
 *     Mail__Id: int,
 *     DateTime: int,
 *     Error: int,
 *     Data: mixed,
 * }
 * @phpstan-type _T_TRABMailer_MailLogs_Update array{
 *     Id?: int|null,
 *     Mail__Id?: int,
 *     DateTime?: int,
 *     Error?: int,
 *     Data?: mixed,
 * }
 * @phpstan-type _T_TRABMailer_MailLogs_Variant array{
 *     Id: int,
 *     Mail__Id: int,
 *     DateTime: int,
 *     Error: int,
 *     Data: mixed,
 *     ...<string,mixed>}
 */
class _TMailLogs extends TTable {
    /**
     *
     * @param _T_TRABMailer_MailLogs $row
     * @return _T_TRABMailer_MailLogs
     */
    static public function AssertRow(array $row): array {
        return $row;
    }

    /**
     *
     * @param _T_TRABMailer_MailLogs_Insert $row
     * @return _T_TRABMailer_MailLogs_Insert
     */
    static public function AssertRow_Insert(array $row): array {
        return $row;
    }

    /**
     *
     * @param _T_TRABMailer_MailLogs_Update $row
     * @return _T_TRABMailer_MailLogs_Update
     */
    static public function AssertRow_Update(array $row): array {
        return $row;
    }

    /**
     *
     * @param list<_T_TRABMailer_MailLogs> $rows
     * @return list<_T_TRABMailer_MailLogs>
     */
    static public function AssertRows(array $rows): array {
        return $rows;
    }

    // /**
    //  *
    //  * @param array|null $row
    //  * @return _T_TRABMailer_MailLogs|null
    //  */
    // static public function CastRow(array|null $row): array|null {
    //     /* phpstan-ignore return.type */
    //     return $row;
    // }

    // /**
    //  *
    //  * @param array $rows
    //  * @return list<_T_TRABMailer_MailLogs>
    //  */
    // static public function CastRows(array $rows): array {
    //     return $rows;
    // }

    /**
     *
     * @param _T_TRABMailer_MailLogs_Variant $row
     * @return _T_TRABMailer_MailLogs
     */
    static public function RawRow(MDatabase $db, array $row): array {
        $table = new _TMailLogs($db);

        /* @phpstan-ignore return.type */
        return $table->stripRow($row);
    }


    public function __construct(MDatabase $db, $tablePrefix = 'abm_ml') {
        parent::__construct($db, 'ABMailer_MailLogs', $tablePrefix);

        $this->setColumns([
            'Id' => new Database\FLong(true), 
            'Mail__Id' => new Database\FLong(true), 
            'DateTime' => new Database\FTime(true), 
            'Error' => new Database\FLong(true), 
            'Data' => new Database\FText(true, 'medium'), 
        ]);
        $this->setPKs([ 'Id' ]);

        $this->setColumnParser_JSON("Data");

        HABTablesHelper::SetTableVFields($this);
    }

    /** 
     * @return _T_TRABMailer_MailLogs|null
     */
     #[Override]
    public function row_ByColumn(string $colName, mixed $colValue, 
            string $groupExtension = '', bool $forUpdate = false): array|null {
        /* @phpstan-ignore return.type */
        return parent::row_ByColumn($colName, $colValue, $groupExtension, $forUpdate);
    }

    /** 
     * @return _T_TRABMailer_MailLogs|null
     */
    #[Override]
    public function row_ByPKs(array $keys, string $groupExtension = '', 
            bool $forUpdate = false): array|null {
        /* @phpstan-ignore return.type */
        return parent::row_ByPKs($keys, $groupExtension, $forUpdate);
    }

    /** 
     * @return _T_TRABMailer_MailLogs|null
     */
    #[Override]
    public function row_Where(array $conditions = [], string $groupExtension = '',
            bool $forUpdate = false): array|null {
        /* @phpstan-ignore return.type */
        return parent::row_Where($conditions, $groupExtension, $forUpdate);
    }

    /** 
     * @return list<_T_TRABMailer_MailLogs>
     */
    #[Override]
    public function select_ByPKs(array $pks, string $groupExtension = ''): array {
        return parent::select_ByPKs($pks, $groupExtension);
    }

    /** 
     * @return list<_T_TRABMailer_MailLogs>
     */
    #[Override]
    public function select_Where(array $conditions = [], string $groupExtension = '',
            bool $tableOnly = false): array {
        return parent::select_Where($conditions, $groupExtension);
    }

    /** 
     * @return _T_TRABMailer_MailLogs
     */
    #[Override]
    public function stripRow_TableColumnsOnly(array $row): array {
        /* @phpstan-ignore return.type */
        return parent::stripRow_TableColumnsOnly($row);
    }
}
