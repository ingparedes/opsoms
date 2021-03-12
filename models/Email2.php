<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for email
 */
class Email2 extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $id_email;
    public $sender_userid;
    public $copy_sender;
    public $sujeto;
    public $mensaje;
    public $archivo;
    public $reciever_userid;
    public $tiempo;
    public $status;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'email2';
        $this->TableName = 'email';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`email`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id_email
        $this->id_email = new DbField('email2', 'email', 'x_id_email', 'id_email', '`id_email`', '`id_email`', 3, 11, -1, false, '`id_email`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id_email->IsAutoIncrement = true; // Autoincrement field
        $this->id_email->IsPrimaryKey = true; // Primary key field
        $this->id_email->Sortable = true; // Allow sort
        $this->id_email->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_email->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_email->Param, "CustomMsg");
        $this->Fields['id_email'] = &$this->id_email;

        // sender_userid
        $this->sender_userid = new DbField('email2', 'email', 'x_sender_userid', 'sender_userid', '`sender_userid`', '`sender_userid`', 200, 30, -1, false, '`EV__sender_userid`', true, true, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->sender_userid->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->sender_userid->Lookup = new Lookup('sender_userid', 'users', false, 'id_users', ["nombres","apellidos","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->sender_userid->Lookup = new Lookup('sender_userid', 'users', false, 'id_users', ["nombres","apellidos","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->sender_userid->Lookup = new Lookup('sender_userid', 'users', false, 'id_users', ["nombres","apellidos","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->sender_userid->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sender_userid->Param, "CustomMsg");
        $this->Fields['sender_userid'] = &$this->sender_userid;

        // copy_sender
        $this->copy_sender = new DbField('email2', 'email', 'x_copy_sender', 'copy_sender', '`copy_sender`', '`copy_sender`', 200, 30, -1, false, '`copy_sender`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->copy_sender->Sortable = true; // Allow sort
        $this->copy_sender->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->copy_sender->Param, "CustomMsg");
        $this->Fields['copy_sender'] = &$this->copy_sender;

        // sujeto
        $this->sujeto = new DbField('email2', 'email', 'x_sujeto', 'sujeto', '`sujeto`', '`sujeto`', 200, 120, -1, false, '`sujeto`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sujeto->Sortable = true; // Allow sort
        $this->sujeto->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sujeto->Param, "CustomMsg");
        $this->Fields['sujeto'] = &$this->sujeto;

        // mensaje
        $this->mensaje = new DbField('email2', 'email', 'x_mensaje', 'mensaje', '`mensaje`', '`mensaje`', 201, 65535, -1, false, '`mensaje`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->mensaje->Sortable = true; // Allow sort
        $this->mensaje->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->mensaje->Param, "CustomMsg");
        $this->Fields['mensaje'] = &$this->mensaje;

        // archivo
        $this->archivo = new DbField('email2', 'email', 'x_archivo', 'archivo', '`archivo`', '`archivo`', 200, 100, -1, true, '`archivo`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->archivo->Sortable = true; // Allow sort
        $this->archivo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->archivo->Param, "CustomMsg");
        $this->Fields['archivo'] = &$this->archivo;

        // reciever_userid
        $this->reciever_userid = new DbField('email2', 'email', 'x_reciever_userid', 'reciever_userid', '`reciever_userid`', '`reciever_userid`', 3, 11, -1, false, '`reciever_userid`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->reciever_userid->Sortable = true; // Allow sort
        $this->reciever_userid->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->reciever_userid->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->reciever_userid->Param, "CustomMsg");
        $this->Fields['reciever_userid'] = &$this->reciever_userid;

        // tiempo
        $this->tiempo = new DbField('email2', 'email', 'x_tiempo', 'tiempo', '`tiempo`', CastDateFieldForLike("`tiempo`", 9, "DB"), 135, 19, 9, false, '`tiempo`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tiempo->Sortable = true; // Allow sort
        $this->tiempo->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->tiempo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tiempo->Param, "CustomMsg");
        $this->Fields['tiempo'] = &$this->tiempo;

        // status
        $this->status = new DbField('email2', 'email', 'x_status', 'status', '`status`', '`status`', 3, 1, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->status->Sortable = true; // Allow sort
        $this->status->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Session ORDER BY for List page
    public function getSessionOrderByList()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY_LIST"));
    }

    public function setSessionOrderByList($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_ORDER_BY_LIST")] = $v;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`email`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlSelectList() // Select for List page
    {
        if ($this->SqlSelectList) {
            return $this->SqlSelectList;
        }
        global $CurrentLanguage;
        switch ($CurrentLanguage) {
            case "en":
                $from = "(SELECT *, (SELECT CONCAT(COALESCE(`nombres`, ''),'" . ValueSeparator(1, $this->sender_userid) . "',COALESCE(`apellidos`,'')) FROM `users` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id_users` = `email`.`sender_userid` LIMIT 1) AS `EV__sender_userid` FROM `email`)";
                break;
            case "es":
                $from = "(SELECT *, (SELECT CONCAT(COALESCE(`nombres`, ''),'" . ValueSeparator(1, $this->sender_userid) . "',COALESCE(`apellidos`,'')) FROM `users` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id_users` = `email`.`sender_userid` LIMIT 1) AS `EV__sender_userid` FROM `email`)";
                break;
            default:
                $from = "(SELECT *, (SELECT CONCAT(COALESCE(`nombres`, ''),'" . ValueSeparator(1, $this->sender_userid) . "',COALESCE(`apellidos`,'')) FROM `users` `TMP_LOOKUPTABLE` WHERE `TMP_LOOKUPTABLE`.`id_users` = `email`.`sender_userid` LIMIT 1) AS `EV__sender_userid` FROM `email`)";
                break;
        }
        return $from . " `TMP_TABLE`";
    }

    public function sqlSelectList() // For backward compatibility
    {
        return $this->getSqlSelectList();
    }

    public function setSqlSelectList($v)
    {
        $this->SqlSelectList = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        if ($this->useVirtualFields()) {
            $select = "*";
            $from = $this->getSqlSelectList();
            $sort = $this->UseSessionForListSql ? $this->getSessionOrderByList() : "";
        } else {
            $select = $this->getSqlSelect();
            $from = $this->getSqlFrom();
            $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        }
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = ($this->useVirtualFields()) ? $this->getSessionOrderByList() : $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Check if virtual fields is used in SQL
    protected function useVirtualFields()
    {
        $where = $this->UseSessionForListSql ? $this->getSessionWhere() : $this->CurrentFilter;
        $orderBy = $this->UseSessionForListSql ? $this->getSessionOrderByList() : "";
        if ($where != "") {
            $where = " " . str_replace(["(", ")"], ["", ""], $where) . " ";
        }
        if ($orderBy != "") {
            $orderBy = " " . str_replace(["(", ")"], ["", ""], $orderBy) . " ";
        }
        if (ContainsString($orderBy, " " . $this->sender_userid->VirtualExpression . " ")) {
            return true;
        }
        return false;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        if ($this->useVirtualFields()) {
            $sql = $this->buildSelectSql("*", $this->getSqlSelectList(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        } else {
            $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        }
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->id_email->setDbValue($conn->lastInsertId());
            $rs['id_email'] = $this->id_email->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('id_email', $rs)) {
                AddFilter($where, QuotedName('id_email', $this->Dbid) . '=' . QuotedValue($rs['id_email'], $this->id_email->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->id_email->DbValue = $row['id_email'];
        $this->sender_userid->DbValue = $row['sender_userid'];
        $this->copy_sender->DbValue = $row['copy_sender'];
        $this->sujeto->DbValue = $row['sujeto'];
        $this->mensaje->DbValue = $row['mensaje'];
        $this->archivo->Upload->DbValue = $row['archivo'];
        $this->reciever_userid->DbValue = $row['reciever_userid'];
        $this->tiempo->DbValue = $row['tiempo'];
        $this->status->DbValue = $row['status'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['archivo']) ? [] : [$row['archivo']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->archivo->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->archivo->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id_email` = @id_email@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id_email->CurrentValue : $this->id_email->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->id_email->CurrentValue = $keys[0];
            } else {
                $this->id_email->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id_email', $row) ? $row['id_email'] : null;
        } else {
            $val = $this->id_email->OldValue !== null ? $this->id_email->OldValue : $this->id_email->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id_email@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("Email2List");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "Email2View") {
            return $Language->phrase("View");
        } elseif ($pageName == "Email2Edit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "Email2Add") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "Email2View";
            case Config("API_ADD_ACTION"):
                return "Email2Add";
            case Config("API_EDIT_ACTION"):
                return "Email2Edit";
            case Config("API_DELETE_ACTION"):
                return "Email2Delete";
            case Config("API_LIST_ACTION"):
                return "Email2List";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "Email2List";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("Email2View", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("Email2View", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "Email2Add?" . $this->getUrlParm($parm);
        } else {
            $url = "Email2Add";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("Email2Edit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("Email2Add", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("Email2Delete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id_email:" . JsonEncode($this->id_email->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id_email->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id_email->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = "";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        return "";
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("id_email") ?? Route("id_email")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->id_email->CurrentValue = $key;
            } else {
                $this->id_email->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->id_email->setDbValue($row['id_email']);
        $this->sender_userid->setDbValue($row['sender_userid']);
        $this->copy_sender->setDbValue($row['copy_sender']);
        $this->sujeto->setDbValue($row['sujeto']);
        $this->mensaje->setDbValue($row['mensaje']);
        $this->archivo->Upload->DbValue = $row['archivo'];
        $this->reciever_userid->setDbValue($row['reciever_userid']);
        $this->tiempo->setDbValue($row['tiempo']);
        $this->status->setDbValue($row['status']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id_email

        // sender_userid

        // copy_sender

        // sujeto

        // mensaje

        // archivo

        // reciever_userid

        // tiempo

        // status

        // id_email
        $this->id_email->ViewValue = $this->id_email->CurrentValue;
        $this->id_email->ViewCustomAttributes = "";

        // sender_userid
        if ($this->sender_userid->VirtualValue != "") {
            $this->sender_userid->ViewValue = $this->sender_userid->VirtualValue;
        } else {
            $curVal = strval($this->sender_userid->CurrentValue);
            if ($curVal != "") {
                $this->sender_userid->ViewValue = $this->sender_userid->lookupCacheOption($curVal);
                if ($this->sender_userid->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`id_users`" . SearchString("=", trim($wrk), DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->sender_userid->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->sender_userid->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->sender_userid->Lookup->renderViewRow($row);
                            $this->sender_userid->ViewValue->add($this->sender_userid->displayValue($arwrk));
                        }
                    } else {
                        $this->sender_userid->ViewValue = $this->sender_userid->CurrentValue;
                    }
                }
            } else {
                $this->sender_userid->ViewValue = null;
            }
        }
        $this->sender_userid->ViewCustomAttributes = "";

        // copy_sender
        $this->copy_sender->ViewValue = $this->copy_sender->CurrentValue;
        $this->copy_sender->ViewCustomAttributes = "";

        // sujeto
        $this->sujeto->ViewValue = $this->sujeto->CurrentValue;
        $this->sujeto->ViewCustomAttributes = "";

        // mensaje
        $this->mensaje->ViewValue = $this->mensaje->CurrentValue;
        $this->mensaje->ViewCustomAttributes = "";

        // archivo
        if (!EmptyValue($this->archivo->Upload->DbValue)) {
            $this->archivo->ViewValue = $this->archivo->Upload->DbValue;
        } else {
            $this->archivo->ViewValue = "";
        }
        $this->archivo->ViewCustomAttributes = "";

        // reciever_userid
        $this->reciever_userid->ViewValue = $this->reciever_userid->CurrentValue;
        $this->reciever_userid->ViewValue = FormatNumber($this->reciever_userid->ViewValue, 0, -2, -2, -2);
        $this->reciever_userid->ViewCustomAttributes = "";

        // tiempo
        $this->tiempo->ViewValue = $this->tiempo->CurrentValue;
        $this->tiempo->ViewValue = FormatDateTime($this->tiempo->ViewValue, 9);
        $this->tiempo->ViewCustomAttributes = "";

        // status
        $this->status->ViewValue = $this->status->CurrentValue;
        $this->status->ViewValue = FormatNumber($this->status->ViewValue, 0, -2, -2, -2);
        $this->status->ViewCustomAttributes = "";

        // id_email
        $this->id_email->LinkCustomAttributes = "";
        $this->id_email->HrefValue = "";
        $this->id_email->TooltipValue = "";

        // sender_userid
        $this->sender_userid->LinkCustomAttributes = "";
        $this->sender_userid->HrefValue = "";
        $this->sender_userid->TooltipValue = "";

        // copy_sender
        $this->copy_sender->LinkCustomAttributes = "";
        $this->copy_sender->HrefValue = "";
        $this->copy_sender->TooltipValue = "";

        // sujeto
        $this->sujeto->LinkCustomAttributes = "";
        $this->sujeto->HrefValue = "";
        $this->sujeto->TooltipValue = "";

        // mensaje
        $this->mensaje->LinkCustomAttributes = "";
        $this->mensaje->HrefValue = "";
        $this->mensaje->TooltipValue = "";

        // archivo
        $this->archivo->LinkCustomAttributes = "";
        $this->archivo->HrefValue = "";
        $this->archivo->ExportHrefValue = $this->archivo->UploadPath . $this->archivo->Upload->DbValue;
        $this->archivo->TooltipValue = "";

        // reciever_userid
        $this->reciever_userid->LinkCustomAttributes = "";
        $this->reciever_userid->HrefValue = "";
        $this->reciever_userid->TooltipValue = "";

        // tiempo
        $this->tiempo->LinkCustomAttributes = "";
        $this->tiempo->HrefValue = "";
        $this->tiempo->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // id_email
        $this->id_email->EditAttrs["class"] = "form-control";
        $this->id_email->EditCustomAttributes = "";
        $this->id_email->EditValue = $this->id_email->CurrentValue;
        $this->id_email->ViewCustomAttributes = "";

        // sender_userid
        $this->sender_userid->EditCustomAttributes = "";
        $this->sender_userid->PlaceHolder = RemoveHtml($this->sender_userid->caption());

        // copy_sender
        $this->copy_sender->EditAttrs["class"] = "form-control";
        $this->copy_sender->EditCustomAttributes = "";
        if (!$this->copy_sender->Raw) {
            $this->copy_sender->CurrentValue = HtmlDecode($this->copy_sender->CurrentValue);
        }
        $this->copy_sender->EditValue = $this->copy_sender->CurrentValue;
        $this->copy_sender->PlaceHolder = RemoveHtml($this->copy_sender->caption());

        // sujeto
        $this->sujeto->EditAttrs["class"] = "form-control";
        $this->sujeto->EditCustomAttributes = "";
        if (!$this->sujeto->Raw) {
            $this->sujeto->CurrentValue = HtmlDecode($this->sujeto->CurrentValue);
        }
        $this->sujeto->EditValue = $this->sujeto->CurrentValue;
        $this->sujeto->PlaceHolder = RemoveHtml($this->sujeto->caption());

        // mensaje
        $this->mensaje->EditAttrs["class"] = "form-control";
        $this->mensaje->EditCustomAttributes = "";
        $this->mensaje->EditValue = $this->mensaje->CurrentValue;
        $this->mensaje->PlaceHolder = RemoveHtml($this->mensaje->caption());

        // archivo
        $this->archivo->EditAttrs["class"] = "form-control";
        $this->archivo->EditCustomAttributes = "";
        if (!EmptyValue($this->archivo->Upload->DbValue)) {
            $this->archivo->EditValue = $this->archivo->Upload->DbValue;
        } else {
            $this->archivo->EditValue = "";
        }
        if (!EmptyValue($this->archivo->CurrentValue)) {
            $this->archivo->Upload->FileName = $this->archivo->CurrentValue;
        }

        // reciever_userid
        $this->reciever_userid->EditAttrs["class"] = "form-control";
        $this->reciever_userid->EditCustomAttributes = "";
        $this->reciever_userid->EditValue = $this->reciever_userid->CurrentValue;
        $this->reciever_userid->PlaceHolder = RemoveHtml($this->reciever_userid->caption());

        // tiempo

        // status
        $this->status->EditAttrs["class"] = "form-control";
        $this->status->EditCustomAttributes = "";
        $this->status->EditValue = $this->status->CurrentValue;
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
            $this->id_email->Count++; // Increment count
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
            $this->id_email->CurrentValue = $this->id_email->Count;
            $this->id_email->ViewValue = $this->id_email->CurrentValue;
            $this->id_email->ViewCustomAttributes = "";
            $this->id_email->HrefValue = ""; // Clear href value

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->id_email);
                    $doc->exportCaption($this->sender_userid);
                    $doc->exportCaption($this->copy_sender);
                    $doc->exportCaption($this->sujeto);
                    $doc->exportCaption($this->mensaje);
                    $doc->exportCaption($this->archivo);
                    $doc->exportCaption($this->reciever_userid);
                    $doc->exportCaption($this->tiempo);
                    $doc->exportCaption($this->status);
                } else {
                    $doc->exportCaption($this->id_email);
                    $doc->exportCaption($this->sender_userid);
                    $doc->exportCaption($this->copy_sender);
                    $doc->exportCaption($this->sujeto);
                    $doc->exportCaption($this->mensaje);
                    $doc->exportCaption($this->archivo);
                    $doc->exportCaption($this->reciever_userid);
                    $doc->exportCaption($this->tiempo);
                    $doc->exportCaption($this->status);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->id_email);
                        $doc->exportField($this->sender_userid);
                        $doc->exportField($this->copy_sender);
                        $doc->exportField($this->sujeto);
                        $doc->exportField($this->mensaje);
                        $doc->exportField($this->archivo);
                        $doc->exportField($this->reciever_userid);
                        $doc->exportField($this->tiempo);
                        $doc->exportField($this->status);
                    } else {
                        $doc->exportField($this->id_email);
                        $doc->exportField($this->sender_userid);
                        $doc->exportField($this->copy_sender);
                        $doc->exportField($this->sujeto);
                        $doc->exportField($this->mensaje);
                        $doc->exportField($this->archivo);
                        $doc->exportField($this->reciever_userid);
                        $doc->exportField($this->tiempo);
                        $doc->exportField($this->status);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'archivo') {
            $fldName = "archivo";
            $fileNameFld = "archivo";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->id_email->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssoc($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DATATYPE_BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, 100, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower(@$pathinfo["extension"]);
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
