<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for subgrupo
 */
class Subgrupo extends DbTable
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
    public $id_subgrupo;
    public $id_grupo;
    public $imagen_subgrupo;
    public $nombre_subgrupo;
    public $descripcion_subgrupo;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'subgrupo';
        $this->TableName = 'subgrupo';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`subgrupo`";
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
        $this->DetailView = true; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id_subgrupo
        $this->id_subgrupo = new DbField('subgrupo', 'subgrupo', 'x_id_subgrupo', 'id_subgrupo', '`id_subgrupo`', '`id_subgrupo`', 3, 11, -1, false, '`id_subgrupo`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id_subgrupo->IsAutoIncrement = true; // Autoincrement field
        $this->id_subgrupo->IsPrimaryKey = true; // Primary key field
        $this->id_subgrupo->Sortable = true; // Allow sort
        $this->id_subgrupo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_subgrupo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_subgrupo->Param, "CustomMsg");
        $this->Fields['id_subgrupo'] = &$this->id_subgrupo;

        // id_grupo
        $this->id_grupo = new DbField('subgrupo', 'subgrupo', 'x_id_grupo', 'id_grupo', '`id_grupo`', '`id_grupo`', 3, 11, -1, false, '`id_grupo`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->id_grupo->IsForeignKey = true; // Foreign key field
        $this->id_grupo->Sortable = true; // Allow sort
        $this->id_grupo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->id_grupo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->id_grupo->Lookup = new Lookup('id_grupo', 'grupo', false, 'id_grupo', ["nombre_grupo","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->id_grupo->Lookup = new Lookup('id_grupo', 'grupo', false, 'id_grupo', ["nombre_grupo","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->id_grupo->Lookup = new Lookup('id_grupo', 'grupo', false, 'id_grupo', ["nombre_grupo","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->id_grupo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_grupo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_grupo->Param, "CustomMsg");
        $this->Fields['id_grupo'] = &$this->id_grupo;

        // imagen_subgrupo
        $this->imagen_subgrupo = new DbField('subgrupo', 'subgrupo', 'x_imagen_subgrupo', 'imagen_subgrupo', '`imagen_subgrupo`', '`imagen_subgrupo`', 200, 100, -1, true, '`imagen_subgrupo`', false, false, false, 'IMAGE', 'FILE');
        $this->imagen_subgrupo->Sortable = true; // Allow sort
        $this->imagen_subgrupo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->imagen_subgrupo->Param, "CustomMsg");
        $this->Fields['imagen_subgrupo'] = &$this->imagen_subgrupo;

        // nombre_subgrupo
        $this->nombre_subgrupo = new DbField('subgrupo', 'subgrupo', 'x_nombre_subgrupo', 'nombre_subgrupo', '`nombre_subgrupo`', '`nombre_subgrupo`', 200, 30, -1, false, '`nombre_subgrupo`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nombre_subgrupo->Sortable = true; // Allow sort
        $this->nombre_subgrupo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nombre_subgrupo->Param, "CustomMsg");
        $this->Fields['nombre_subgrupo'] = &$this->nombre_subgrupo;

        // descripcion_subgrupo
        $this->descripcion_subgrupo = new DbField('subgrupo', 'subgrupo', 'x_descripcion_subgrupo', 'descripcion_subgrupo', '`descripcion_subgrupo`', '`descripcion_subgrupo`', 201, 65535, -1, false, '`descripcion_subgrupo`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->descripcion_subgrupo->Sortable = true; // Allow sort
        $this->descripcion_subgrupo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->descripcion_subgrupo->Param, "CustomMsg");
        $this->Fields['descripcion_subgrupo'] = &$this->descripcion_subgrupo;
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
        if ($this->getCurrentMasterTable() == "grupo") {
            if ($this->id_grupo->getSessionValue() != "") {
                $masterFilter .= "" . GetForeignKeySql("`id_grupo`", $this->id_grupo->getSessionValue(), DATATYPE_NUMBER, "DB");
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
        if ($this->getCurrentMasterTable() == "grupo") {
            if ($this->id_grupo->getSessionValue() != "") {
                $detailFilter .= "" . GetForeignKeySql("`id_grupo`", $this->id_grupo->getSessionValue(), DATATYPE_NUMBER, "DB");
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    // Master filter
    public function sqlMasterFilter_grupo()
    {
        return "`id_grupo`=@id_grupo@";
    }
    // Detail filter
    public function sqlDetailFilter_grupo()
    {
        return "`id_grupo`=@id_grupo@";
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`subgrupo`";
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
            $this->id_subgrupo->setDbValue($conn->lastInsertId());
            $rs['id_subgrupo'] = $this->id_subgrupo->DbValue;
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
            if (array_key_exists('id_subgrupo', $rs)) {
                AddFilter($where, QuotedName('id_subgrupo', $this->Dbid) . '=' . QuotedValue($rs['id_subgrupo'], $this->id_subgrupo->DataType, $this->Dbid));
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
        $this->id_subgrupo->DbValue = $row['id_subgrupo'];
        $this->id_grupo->DbValue = $row['id_grupo'];
        $this->imagen_subgrupo->Upload->DbValue = $row['imagen_subgrupo'];
        $this->nombre_subgrupo->DbValue = $row['nombre_subgrupo'];
        $this->descripcion_subgrupo->DbValue = $row['descripcion_subgrupo'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['imagen_subgrupo']) ? [] : [$row['imagen_subgrupo']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->imagen_subgrupo->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->imagen_subgrupo->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id_subgrupo` = @id_subgrupo@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id_subgrupo->CurrentValue : $this->id_subgrupo->OldValue;
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
                $this->id_subgrupo->CurrentValue = $keys[0];
            } else {
                $this->id_subgrupo->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id_subgrupo', $row) ? $row['id_subgrupo'] : null;
        } else {
            $val = $this->id_subgrupo->OldValue !== null ? $this->id_subgrupo->OldValue : $this->id_subgrupo->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id_subgrupo@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("SubgrupoList");
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
        if ($pageName == "SubgrupoView") {
            return $Language->phrase("View");
        } elseif ($pageName == "SubgrupoEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "SubgrupoAdd") {
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
                return "SubgrupoView";
            case Config("API_ADD_ACTION"):
                return "SubgrupoAdd";
            case Config("API_EDIT_ACTION"):
                return "SubgrupoEdit";
            case Config("API_DELETE_ACTION"):
                return "SubgrupoDelete";
            case Config("API_LIST_ACTION"):
                return "SubgrupoList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "SubgrupoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("SubgrupoView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("SubgrupoView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "SubgrupoAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "SubgrupoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("SubgrupoEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("SubgrupoAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("SubgrupoDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "grupo" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_id_grupo", $this->id_grupo->CurrentValue ?? $this->id_grupo->getSessionValue());
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id_subgrupo:" . JsonEncode($this->id_subgrupo->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id_subgrupo->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id_subgrupo->CurrentValue);
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
            if (($keyValue = Param("id_subgrupo") ?? Route("id_subgrupo")) !== null) {
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
                $this->id_subgrupo->CurrentValue = $key;
            } else {
                $this->id_subgrupo->OldValue = $key;
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
        $this->id_subgrupo->setDbValue($row['id_subgrupo']);
        $this->id_grupo->setDbValue($row['id_grupo']);
        $this->imagen_subgrupo->Upload->DbValue = $row['imagen_subgrupo'];
        $this->nombre_subgrupo->setDbValue($row['nombre_subgrupo']);
        $this->descripcion_subgrupo->setDbValue($row['descripcion_subgrupo']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id_subgrupo

        // id_grupo

        // imagen_subgrupo

        // nombre_subgrupo

        // descripcion_subgrupo

        // id_subgrupo
        $this->id_subgrupo->ViewValue = $this->id_subgrupo->CurrentValue;
        $this->id_subgrupo->ViewCustomAttributes = "";

        // id_grupo
        $curVal = strval($this->id_grupo->CurrentValue);
        if ($curVal != "") {
            $this->id_grupo->ViewValue = $this->id_grupo->lookupCacheOption($curVal);
            if ($this->id_grupo->ViewValue === null) { // Lookup from database
                $filterWrk = "`id_grupo`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->id_grupo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->id_grupo->Lookup->renderViewRow($rswrk[0]);
                    $this->id_grupo->ViewValue = $this->id_grupo->displayValue($arwrk);
                } else {
                    $this->id_grupo->ViewValue = $this->id_grupo->CurrentValue;
                }
            }
        } else {
            $this->id_grupo->ViewValue = null;
        }
        $this->id_grupo->ViewCustomAttributes = "";

        // imagen_subgrupo
        if (!EmptyValue($this->imagen_subgrupo->Upload->DbValue)) {
            $this->imagen_subgrupo->ImageWidth = 50;
            $this->imagen_subgrupo->ImageHeight = 50;
            $this->imagen_subgrupo->ImageAlt = $this->imagen_subgrupo->alt();
            $this->imagen_subgrupo->ViewValue = $this->imagen_subgrupo->Upload->DbValue;
        } else {
            $this->imagen_subgrupo->ViewValue = "";
        }
        $this->imagen_subgrupo->ViewCustomAttributes = "";

        // nombre_subgrupo
        $this->nombre_subgrupo->ViewValue = $this->nombre_subgrupo->CurrentValue;
        $this->nombre_subgrupo->ViewCustomAttributes = "";

        // descripcion_subgrupo
        $this->descripcion_subgrupo->ViewValue = $this->descripcion_subgrupo->CurrentValue;
        $this->descripcion_subgrupo->ViewCustomAttributes = "";

        // id_subgrupo
        $this->id_subgrupo->LinkCustomAttributes = "";
        $this->id_subgrupo->HrefValue = "";
        $this->id_subgrupo->TooltipValue = "";

        // id_grupo
        $this->id_grupo->LinkCustomAttributes = "";
        $this->id_grupo->HrefValue = "";
        $this->id_grupo->TooltipValue = "";

        // imagen_subgrupo
        $this->imagen_subgrupo->LinkCustomAttributes = "";
        if (!EmptyValue($this->imagen_subgrupo->Upload->DbValue)) {
            $this->imagen_subgrupo->HrefValue = GetFileUploadUrl($this->imagen_subgrupo, $this->imagen_subgrupo->htmlDecode($this->imagen_subgrupo->Upload->DbValue)); // Add prefix/suffix
            $this->imagen_subgrupo->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->imagen_subgrupo->HrefValue = FullUrl($this->imagen_subgrupo->HrefValue, "href");
            }
        } else {
            $this->imagen_subgrupo->HrefValue = "";
        }
        $this->imagen_subgrupo->ExportHrefValue = $this->imagen_subgrupo->UploadPath . $this->imagen_subgrupo->Upload->DbValue;
        $this->imagen_subgrupo->TooltipValue = "";
        if ($this->imagen_subgrupo->UseColorbox) {
            if (EmptyValue($this->imagen_subgrupo->TooltipValue)) {
                $this->imagen_subgrupo->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->imagen_subgrupo->LinkAttrs["data-rel"] = "subgrupo_x_imagen_subgrupo";
            $this->imagen_subgrupo->LinkAttrs->appendClass("ew-lightbox");
        }

        // nombre_subgrupo
        $this->nombre_subgrupo->LinkCustomAttributes = "";
        $this->nombre_subgrupo->HrefValue = "";
        $this->nombre_subgrupo->TooltipValue = "";

        // descripcion_subgrupo
        $this->descripcion_subgrupo->LinkCustomAttributes = "";
        $this->descripcion_subgrupo->HrefValue = "";
        $this->descripcion_subgrupo->TooltipValue = "";

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

        // id_subgrupo
        $this->id_subgrupo->EditAttrs["class"] = "form-control";
        $this->id_subgrupo->EditCustomAttributes = "";
        $this->id_subgrupo->EditValue = $this->id_subgrupo->CurrentValue;
        $this->id_subgrupo->ViewCustomAttributes = "";

        // id_grupo
        $this->id_grupo->EditAttrs["class"] = "form-control";
        $this->id_grupo->EditCustomAttributes = "";
        if ($this->id_grupo->getSessionValue() != "") {
            $this->id_grupo->CurrentValue = GetForeignKeyValue($this->id_grupo->getSessionValue());
            $curVal = strval($this->id_grupo->CurrentValue);
            if ($curVal != "") {
                $this->id_grupo->ViewValue = $this->id_grupo->lookupCacheOption($curVal);
                if ($this->id_grupo->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_grupo`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->id_grupo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->id_grupo->Lookup->renderViewRow($rswrk[0]);
                        $this->id_grupo->ViewValue = $this->id_grupo->displayValue($arwrk);
                    } else {
                        $this->id_grupo->ViewValue = $this->id_grupo->CurrentValue;
                    }
                }
            } else {
                $this->id_grupo->ViewValue = null;
            }
            $this->id_grupo->ViewCustomAttributes = "";
        } else {
            $this->id_grupo->PlaceHolder = RemoveHtml($this->id_grupo->caption());
        }

        // imagen_subgrupo
        $this->imagen_subgrupo->EditAttrs["class"] = "form-control";
        $this->imagen_subgrupo->EditCustomAttributes = "";
        if (!EmptyValue($this->imagen_subgrupo->Upload->DbValue)) {
            $this->imagen_subgrupo->ImageWidth = 50;
            $this->imagen_subgrupo->ImageHeight = 50;
            $this->imagen_subgrupo->ImageAlt = $this->imagen_subgrupo->alt();
            $this->imagen_subgrupo->EditValue = $this->imagen_subgrupo->Upload->DbValue;
        } else {
            $this->imagen_subgrupo->EditValue = "";
        }
        if (!EmptyValue($this->imagen_subgrupo->CurrentValue)) {
            $this->imagen_subgrupo->Upload->FileName = $this->imagen_subgrupo->CurrentValue;
        }

        // nombre_subgrupo
        $this->nombre_subgrupo->EditAttrs["class"] = "form-control";
        $this->nombre_subgrupo->EditCustomAttributes = "";
        if (!$this->nombre_subgrupo->Raw) {
            $this->nombre_subgrupo->CurrentValue = HtmlDecode($this->nombre_subgrupo->CurrentValue);
        }
        $this->nombre_subgrupo->EditValue = $this->nombre_subgrupo->CurrentValue;
        $this->nombre_subgrupo->PlaceHolder = RemoveHtml($this->nombre_subgrupo->caption());

        // descripcion_subgrupo
        $this->descripcion_subgrupo->EditAttrs["class"] = "form-control";
        $this->descripcion_subgrupo->EditCustomAttributes = "";
        $this->descripcion_subgrupo->EditValue = $this->descripcion_subgrupo->CurrentValue;
        $this->descripcion_subgrupo->PlaceHolder = RemoveHtml($this->descripcion_subgrupo->caption());

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
                    $doc->exportCaption($this->id_subgrupo);
                    $doc->exportCaption($this->id_grupo);
                    $doc->exportCaption($this->imagen_subgrupo);
                    $doc->exportCaption($this->nombre_subgrupo);
                    $doc->exportCaption($this->descripcion_subgrupo);
                } else {
                    $doc->exportCaption($this->id_subgrupo);
                    $doc->exportCaption($this->id_grupo);
                    $doc->exportCaption($this->imagen_subgrupo);
                    $doc->exportCaption($this->nombre_subgrupo);
                    $doc->exportCaption($this->descripcion_subgrupo);
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
                        $doc->exportField($this->id_subgrupo);
                        $doc->exportField($this->id_grupo);
                        $doc->exportField($this->imagen_subgrupo);
                        $doc->exportField($this->nombre_subgrupo);
                        $doc->exportField($this->descripcion_subgrupo);
                    } else {
                        $doc->exportField($this->id_subgrupo);
                        $doc->exportField($this->id_grupo);
                        $doc->exportField($this->imagen_subgrupo);
                        $doc->exportField($this->nombre_subgrupo);
                        $doc->exportField($this->descripcion_subgrupo);
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
        if ($fldparm == 'imagen_subgrupo') {
            $fldName = "imagen_subgrupo";
            $fileNameFld = "imagen_subgrupo";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->id_subgrupo->CurrentValue = $ar[0];
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
