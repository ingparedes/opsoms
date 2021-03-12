<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for grupo
 */
class Grupo extends DbTable
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
    public $id_escenario;
    public $id_grupo;
    public $imgen_grupo;
    public $nombre_grupo;
    public $descripcion_grupo;
    public $color;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'grupo';
        $this->TableName = 'grupo';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`grupo`";
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

        // id_escenario
        $this->id_escenario = new DbField('grupo', 'grupo', 'x_id_escenario', 'id_escenario', '`id_escenario`', '`id_escenario`', 3, 11, -1, false, '`id_escenario`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->id_escenario->IsForeignKey = true; // Foreign key field
        $this->id_escenario->Sortable = true; // Allow sort
        $this->id_escenario->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->id_escenario->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->id_escenario->Lookup = new Lookup('id_escenario', 'users', false, 'id_users', ["nombres","apellidos","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->id_escenario->Lookup = new Lookup('id_escenario', 'users', false, 'id_users', ["nombres","apellidos","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->id_escenario->Lookup = new Lookup('id_escenario', 'users', false, 'id_users', ["nombres","apellidos","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->id_escenario->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_escenario->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_escenario->Param, "CustomMsg");
        $this->Fields['id_escenario'] = &$this->id_escenario;

        // id_grupo
        $this->id_grupo = new DbField('grupo', 'grupo', 'x_id_grupo', 'id_grupo', '`id_grupo`', '`id_grupo`', 3, 11, -1, false, '`id_grupo`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id_grupo->IsAutoIncrement = true; // Autoincrement field
        $this->id_grupo->IsPrimaryKey = true; // Primary key field
        $this->id_grupo->IsForeignKey = true; // Foreign key field
        $this->id_grupo->Sortable = true; // Allow sort
        $this->id_grupo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_grupo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_grupo->Param, "CustomMsg");
        $this->Fields['id_grupo'] = &$this->id_grupo;

        // imgen_grupo
        $this->imgen_grupo = new DbField('grupo', 'grupo', 'x_imgen_grupo', 'imgen_grupo', '`imgen_grupo`', '`imgen_grupo`', 200, 30, -1, true, '`imgen_grupo`', false, false, false, 'IMAGE', 'FILE');
        $this->imgen_grupo->Sortable = true; // Allow sort
        $this->imgen_grupo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->imgen_grupo->Param, "CustomMsg");
        $this->Fields['imgen_grupo'] = &$this->imgen_grupo;

        // nombre_grupo
        $this->nombre_grupo = new DbField('grupo', 'grupo', 'x_nombre_grupo', 'nombre_grupo', '`nombre_grupo`', '`nombre_grupo`', 200, 30, -1, false, '`nombre_grupo`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nombre_grupo->Sortable = true; // Allow sort
        $this->nombre_grupo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nombre_grupo->Param, "CustomMsg");
        $this->Fields['nombre_grupo'] = &$this->nombre_grupo;

        // descripcion_grupo
        $this->descripcion_grupo = new DbField('grupo', 'grupo', 'x_descripcion_grupo', 'descripcion_grupo', '`descripcion_grupo`', '`descripcion_grupo`', 201, 65535, -1, false, '`descripcion_grupo`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->descripcion_grupo->Sortable = true; // Allow sort
        $this->descripcion_grupo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->descripcion_grupo->Param, "CustomMsg");
        $this->Fields['descripcion_grupo'] = &$this->descripcion_grupo;

        // color
        $this->color = new DbField('grupo', 'grupo', 'x_color', 'color', '`color`', '`color`', 200, 12, -1, false, '`color`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->color->Sortable = true; // Allow sort
        $this->color->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->color->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->color->Lookup = new Lookup('color', 'grupo', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->color->Lookup = new Lookup('color', 'grupo', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->color->Lookup = new Lookup('color', 'grupo', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->color->OptionCount = 2;
        $this->color->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->color->Param, "CustomMsg");
        $this->Fields['color'] = &$this->color;
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

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Session master WHERE clause
    public function getMasterFilter()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "escenario") {
            if ($this->id_escenario->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id_escenario`", $this->id_escenario->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Session detail WHERE clause
    public function getDetailFilter()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "escenario") {
            if ($this->id_escenario->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`id_escenario`", $this->id_escenario->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_escenario()
    {
        return "`id_escenario`=@id_escenario@";
    }
    // Detail filter
    public function sqlDetailFilter_escenario()
    {
        return "`id_escenario`=@id_escenario@";
    }

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE"));
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "subgrupo") {
            $detailUrl = Container("subgrupo")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id_grupo", $this->id_grupo->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "GrupoList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`grupo`";
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
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
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
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
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
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
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
            $this->id_grupo->setDbValue($conn->lastInsertId());
            $rs['id_grupo'] = $this->id_grupo->DbValue;
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
        // Cascade Update detail table 'subgrupo'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id_grupo']) && $rsold['id_grupo'] != $rs['id_grupo'])) { // Update detail field 'id_grupo'
            $cascadeUpdate = true;
            $rscascade['id_grupo'] = $rs['id_grupo'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("subgrupo")->loadRs("`id_grupo` = " . QuotedValue($rsold['id_grupo'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id_subgrupo';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("subgrupo")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("subgrupo")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("subgrupo")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

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
            if (array_key_exists('id_grupo', $rs)) {
                AddFilter($where, QuotedName('id_grupo', $this->Dbid) . '=' . QuotedValue($rs['id_grupo'], $this->id_grupo->DataType, $this->Dbid));
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

        // Cascade delete detail table 'subgrupo'
        $dtlrows = Container("subgrupo")->loadRs("`id_grupo` = " . QuotedValue($rs['id_grupo'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("subgrupo")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("subgrupo")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("subgrupo")->rowDeleted($dtlrow);
            }
        }
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
        $this->id_escenario->DbValue = $row['id_escenario'];
        $this->id_grupo->DbValue = $row['id_grupo'];
        $this->imgen_grupo->Upload->DbValue = $row['imgen_grupo'];
        $this->nombre_grupo->DbValue = $row['nombre_grupo'];
        $this->descripcion_grupo->DbValue = $row['descripcion_grupo'];
        $this->color->DbValue = $row['color'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['imgen_grupo']) ? [] : [$row['imgen_grupo']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->imgen_grupo->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->imgen_grupo->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id_grupo` = @id_grupo@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id_grupo->CurrentValue : $this->id_grupo->OldValue;
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
                $this->id_grupo->CurrentValue = $keys[0];
            } else {
                $this->id_grupo->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id_grupo', $row) ? $row['id_grupo'] : null;
        } else {
            $val = $this->id_grupo->OldValue !== null ? $this->id_grupo->OldValue : $this->id_grupo->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id_grupo@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("GrupoList");
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
        if ($pageName == "GrupoView") {
            return $Language->phrase("View");
        } elseif ($pageName == "GrupoEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "GrupoAdd") {
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
                return "GrupoView";
            case Config("API_ADD_ACTION"):
                return "GrupoAdd";
            case Config("API_EDIT_ACTION"):
                return "GrupoEdit";
            case Config("API_DELETE_ACTION"):
                return "GrupoDelete";
            case Config("API_LIST_ACTION"):
                return "GrupoList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "GrupoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("GrupoView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("GrupoView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "GrupoAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "GrupoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("GrupoEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("GrupoEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
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
        if ($parm != "") {
            $url = $this->keyUrl("GrupoAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("GrupoAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
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
        return $this->keyUrl("GrupoDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "escenario" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id_escenario", $this->id_escenario->CurrentValue ?? $this->id_escenario->getSessionValue());
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id_grupo:" . JsonEncode($this->id_grupo->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id_grupo->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id_grupo->CurrentValue);
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
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
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
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
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
            if (($keyValue = Param("id_grupo") ?? Route("id_grupo")) !== null) {
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
                $this->id_grupo->CurrentValue = $key;
            } else {
                $this->id_grupo->OldValue = $key;
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
        $this->id_escenario->setDbValue($row['id_escenario']);
        $this->id_grupo->setDbValue($row['id_grupo']);
        $this->imgen_grupo->Upload->DbValue = $row['imgen_grupo'];
        $this->nombre_grupo->setDbValue($row['nombre_grupo']);
        $this->descripcion_grupo->setDbValue($row['descripcion_grupo']);
        $this->color->setDbValue($row['color']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id_escenario

        // id_grupo

        // imgen_grupo

        // nombre_grupo

        // descripcion_grupo

        // color

        // id_escenario
        $curVal = strval($this->id_escenario->CurrentValue);
        if ($curVal != "") {
            $this->id_escenario->ViewValue = $this->id_escenario->lookupCacheOption($curVal);
            if ($this->id_escenario->ViewValue === null) { // Lookup from database
                $filterWrk = "`id_users`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $lookupFilter = function() {
                    return "perfil = '2'";
                };
                $lookupFilter = $lookupFilter->bindTo($this);
                $sqlWrk = $this->id_escenario->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->id_escenario->Lookup->renderViewRow($rswrk[0]);
                    $this->id_escenario->ViewValue = $this->id_escenario->displayValue($arwrk);
                } else {
                    $this->id_escenario->ViewValue = $this->id_escenario->CurrentValue;
                }
            }
        } else {
            $this->id_escenario->ViewValue = null;
        }
        $this->id_escenario->ViewCustomAttributes = "";

        // id_grupo
        $this->id_grupo->ViewValue = $this->id_grupo->CurrentValue;
        $this->id_grupo->ViewCustomAttributes = "mr-3 rounded-circle";

        // imgen_grupo
        if (!EmptyValue($this->imgen_grupo->Upload->DbValue)) {
            $this->imgen_grupo->ImageWidth = 50;
            $this->imgen_grupo->ImageHeight = 50;
            $this->imgen_grupo->ImageAlt = $this->imgen_grupo->alt();
            $this->imgen_grupo->ViewValue = $this->imgen_grupo->Upload->DbValue;
        } else {
            $this->imgen_grupo->ViewValue = "";
        }
        $this->imgen_grupo->ViewCustomAttributes = "";

        // nombre_grupo
        $this->nombre_grupo->ViewValue = $this->nombre_grupo->CurrentValue;
        $this->nombre_grupo->ViewCustomAttributes = "";

        // descripcion_grupo
        $this->descripcion_grupo->ViewValue = $this->descripcion_grupo->CurrentValue;
        $this->descripcion_grupo->ViewCustomAttributes = "";

        // color
        if (strval($this->color->CurrentValue) != "") {
            $this->color->ViewValue = $this->color->optionCaption($this->color->CurrentValue);
        } else {
            $this->color->ViewValue = null;
        }
        $this->color->ViewCustomAttributes = "";

        // id_escenario
        $this->id_escenario->LinkCustomAttributes = "";
        $this->id_escenario->HrefValue = "";
        $this->id_escenario->TooltipValue = "";

        // id_grupo
        $this->id_grupo->LinkCustomAttributes = "";
        $this->id_grupo->HrefValue = "";
        $this->id_grupo->TooltipValue = "";

        // imgen_grupo
        $this->imgen_grupo->LinkCustomAttributes = "";
        if (!EmptyValue($this->imgen_grupo->Upload->DbValue)) {
            $this->imgen_grupo->HrefValue = GetFileUploadUrl($this->imgen_grupo, $this->imgen_grupo->htmlDecode($this->imgen_grupo->Upload->DbValue)); // Add prefix/suffix
            $this->imgen_grupo->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->imgen_grupo->HrefValue = FullUrl($this->imgen_grupo->HrefValue, "href");
            }
        } else {
            $this->imgen_grupo->HrefValue = "";
        }
        $this->imgen_grupo->ExportHrefValue = $this->imgen_grupo->UploadPath . $this->imgen_grupo->Upload->DbValue;
        $this->imgen_grupo->TooltipValue = "";
        if ($this->imgen_grupo->UseColorbox) {
            if (EmptyValue($this->imgen_grupo->TooltipValue)) {
                $this->imgen_grupo->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->imgen_grupo->LinkAttrs["data-rel"] = "grupo_x_imgen_grupo";
            $this->imgen_grupo->LinkAttrs->appendClass("ew-lightbox");
        }

        // nombre_grupo
        $this->nombre_grupo->LinkCustomAttributes = "";
        $this->nombre_grupo->HrefValue = "";
        $this->nombre_grupo->TooltipValue = "";

        // descripcion_grupo
        $this->descripcion_grupo->LinkCustomAttributes = "";
        $this->descripcion_grupo->HrefValue = "";
        $this->descripcion_grupo->TooltipValue = "";

        // color
        $this->color->LinkCustomAttributes = "";
        $this->color->HrefValue = "";
        $this->color->TooltipValue = "";

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

        // id_escenario
        $this->id_escenario->EditAttrs["class"] = "form-control";
        $this->id_escenario->EditCustomAttributes = "";
        if ($this->id_escenario->getSessionValue() != "") {
            $this->id_escenario->CurrentValue = GetForeignKeyValue($this->id_escenario->getSessionValue());
            $curVal = strval($this->id_escenario->CurrentValue);
            if ($curVal != "") {
                $this->id_escenario->ViewValue = $this->id_escenario->lookupCacheOption($curVal);
                if ($this->id_escenario->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_users`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return "perfil = '2'";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->id_escenario->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->id_escenario->Lookup->renderViewRow($rswrk[0]);
                        $this->id_escenario->ViewValue = $this->id_escenario->displayValue($arwrk);
                    } else {
                        $this->id_escenario->ViewValue = $this->id_escenario->CurrentValue;
                    }
                }
            } else {
                $this->id_escenario->ViewValue = null;
            }
            $this->id_escenario->ViewCustomAttributes = "";
        } else {
            $this->id_escenario->PlaceHolder = RemoveHtml($this->id_escenario->caption());
        }

        // id_grupo
        $this->id_grupo->EditAttrs["class"] = "form-control";
        $this->id_grupo->EditCustomAttributes = "";
        $this->id_grupo->EditValue = $this->id_grupo->CurrentValue;
        $this->id_grupo->ViewCustomAttributes = "mr-3 rounded-circle";

        // imgen_grupo
        $this->imgen_grupo->EditAttrs["class"] = "form-control";
        $this->imgen_grupo->EditCustomAttributes = "";
        if (!EmptyValue($this->imgen_grupo->Upload->DbValue)) {
            $this->imgen_grupo->ImageWidth = 50;
            $this->imgen_grupo->ImageHeight = 50;
            $this->imgen_grupo->ImageAlt = $this->imgen_grupo->alt();
            $this->imgen_grupo->EditValue = $this->imgen_grupo->Upload->DbValue;
        } else {
            $this->imgen_grupo->EditValue = "";
        }
        if (!EmptyValue($this->imgen_grupo->CurrentValue)) {
            $this->imgen_grupo->Upload->FileName = $this->imgen_grupo->CurrentValue;
        }

        // nombre_grupo
        $this->nombre_grupo->EditAttrs["class"] = "form-control";
        $this->nombre_grupo->EditCustomAttributes = "";
        if (!$this->nombre_grupo->Raw) {
            $this->nombre_grupo->CurrentValue = HtmlDecode($this->nombre_grupo->CurrentValue);
        }
        $this->nombre_grupo->EditValue = $this->nombre_grupo->CurrentValue;
        $this->nombre_grupo->PlaceHolder = RemoveHtml($this->nombre_grupo->caption());

        // descripcion_grupo
        $this->descripcion_grupo->EditAttrs["class"] = "form-control";
        $this->descripcion_grupo->EditCustomAttributes = "";
        if (!$this->descripcion_grupo->Raw) {
            $this->descripcion_grupo->CurrentValue = HtmlDecode($this->descripcion_grupo->CurrentValue);
        }
        $this->descripcion_grupo->EditValue = $this->descripcion_grupo->CurrentValue;
        $this->descripcion_grupo->PlaceHolder = RemoveHtml($this->descripcion_grupo->caption());

        // color
        $this->color->EditAttrs["class"] = "form-control";
        $this->color->EditCustomAttributes = "";
        $this->color->EditValue = $this->color->options(true);
        $this->color->PlaceHolder = RemoveHtml($this->color->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
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
                    $doc->exportCaption($this->id_escenario);
                    $doc->exportCaption($this->id_grupo);
                    $doc->exportCaption($this->imgen_grupo);
                    $doc->exportCaption($this->nombre_grupo);
                    $doc->exportCaption($this->descripcion_grupo);
                    $doc->exportCaption($this->color);
                } else {
                    $doc->exportCaption($this->id_escenario);
                    $doc->exportCaption($this->id_grupo);
                    $doc->exportCaption($this->imgen_grupo);
                    $doc->exportCaption($this->nombre_grupo);
                    $doc->exportCaption($this->color);
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
                        $doc->exportField($this->id_escenario);
                        $doc->exportField($this->id_grupo);
                        $doc->exportField($this->imgen_grupo);
                        $doc->exportField($this->nombre_grupo);
                        $doc->exportField($this->descripcion_grupo);
                        $doc->exportField($this->color);
                    } else {
                        $doc->exportField($this->id_escenario);
                        $doc->exportField($this->id_grupo);
                        $doc->exportField($this->imgen_grupo);
                        $doc->exportField($this->nombre_grupo);
                        $doc->exportField($this->color);
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
        if ($fldparm == 'imgen_grupo') {
            $fldName = "imgen_grupo";
            $fileNameFld = "imgen_grupo";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->id_grupo->CurrentValue = $ar[0];
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
