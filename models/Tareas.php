<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for tareas
 */
class Tareas extends DbTable
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
    public $id_tarea;
    public $id_escenario;
    public $id_grupo;
    public $titulo_tarea;
    public $descripcion_tarea;
    public $fechainireal_tarea;
    public $fechafin_tarea;
    public $fechainisimulado_tarea;
    public $fechafinsimulado_tarea;
    public $id_tarearelacion;
    public $archivo;
    public $id_subgrupo;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'tareas';
        $this->TableName = 'tareas';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`tareas`";
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

        // id_tarea
        $this->id_tarea = new DbField('tareas', 'tareas', 'x_id_tarea', 'id_tarea', '`id_tarea`', '`id_tarea`', 3, 11, -1, false, '`id_tarea`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id_tarea->IsAutoIncrement = true; // Autoincrement field
        $this->id_tarea->IsPrimaryKey = true; // Primary key field
        $this->id_tarea->IsForeignKey = true; // Foreign key field
        $this->id_tarea->Sortable = true; // Allow sort
        $this->id_tarea->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_tarea->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_tarea->Param, "CustomMsg");
        $this->Fields['id_tarea'] = &$this->id_tarea;

        // id_escenario
        $this->id_escenario = new DbField('tareas', 'tareas', 'x_id_escenario', 'id_escenario', '`id_escenario`', '`id_escenario`', 3, 11, -1, false, '`id_escenario`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->id_escenario->IsForeignKey = true; // Foreign key field
        $this->id_escenario->Sortable = true; // Allow sort
        $this->id_escenario->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_escenario->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_escenario->Param, "CustomMsg");
        $this->Fields['id_escenario'] = &$this->id_escenario;

        // id_grupo
        $this->id_grupo = new DbField('tareas', 'tareas', 'x_id_grupo', 'id_grupo', '`id_grupo`', '`id_grupo`', 3, 11, -1, false, '`id_grupo`', false, false, false, 'FORMATTED TEXT', 'SELECT');
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

        // titulo_tarea
        $this->titulo_tarea = new DbField('tareas', 'tareas', 'x_titulo_tarea', 'titulo_tarea', '`titulo_tarea`', '`titulo_tarea`', 200, 150, -1, false, '`titulo_tarea`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->titulo_tarea->Sortable = true; // Allow sort
        $this->titulo_tarea->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->titulo_tarea->Param, "CustomMsg");
        $this->Fields['titulo_tarea'] = &$this->titulo_tarea;

        // descripcion_tarea
        $this->descripcion_tarea = new DbField('tareas', 'tareas', 'x_descripcion_tarea', 'descripcion_tarea', '`descripcion_tarea`', '`descripcion_tarea`', 201, 65535, -1, false, '`descripcion_tarea`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->descripcion_tarea->Sortable = true; // Allow sort
        $this->descripcion_tarea->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->descripcion_tarea->Param, "CustomMsg");
        $this->Fields['descripcion_tarea'] = &$this->descripcion_tarea;

        // fechainireal_tarea
        $this->fechainireal_tarea = new DbField('tareas', 'tareas', 'x_fechainireal_tarea', 'fechainireal_tarea', '`fechainireal_tarea`', CastDateFieldForLike("`fechainireal_tarea`", 109, "DB"), 135, 26, 109, false, '`fechainireal_tarea`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fechainireal_tarea->Sortable = true; // Allow sort
        $this->fechainireal_tarea->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->fechainireal_tarea->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fechainireal_tarea->Param, "CustomMsg");
        $this->Fields['fechainireal_tarea'] = &$this->fechainireal_tarea;

        // fechafin_tarea
        $this->fechafin_tarea = new DbField('tareas', 'tareas', 'x_fechafin_tarea', 'fechafin_tarea', '`fechafin_tarea`', CastDateFieldForLike("`fechafin_tarea`", 109, "DB"), 135, 26, 109, false, '`fechafin_tarea`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fechafin_tarea->Sortable = true; // Allow sort
        $this->fechafin_tarea->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->fechafin_tarea->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fechafin_tarea->Param, "CustomMsg");
        $this->Fields['fechafin_tarea'] = &$this->fechafin_tarea;

        // fechainisimulado_tarea
        $this->fechainisimulado_tarea = new DbField('tareas', 'tareas', 'x_fechainisimulado_tarea', 'fechainisimulado_tarea', '`fechainisimulado_tarea`', CastDateFieldForLike("`fechainisimulado_tarea`", 109, "DB"), 135, 26, 109, false, '`fechainisimulado_tarea`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fechainisimulado_tarea->Sortable = true; // Allow sort
        $this->fechainisimulado_tarea->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->fechainisimulado_tarea->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fechainisimulado_tarea->Param, "CustomMsg");
        $this->Fields['fechainisimulado_tarea'] = &$this->fechainisimulado_tarea;

        // fechafinsimulado_tarea
        $this->fechafinsimulado_tarea = new DbField('tareas', 'tareas', 'x_fechafinsimulado_tarea', 'fechafinsimulado_tarea', '`fechafinsimulado_tarea`', CastDateFieldForLike("`fechafinsimulado_tarea`", 109, "DB"), 135, 26, 109, false, '`fechafinsimulado_tarea`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fechafinsimulado_tarea->Sortable = true; // Allow sort
        $this->fechafinsimulado_tarea->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->fechafinsimulado_tarea->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fechafinsimulado_tarea->Param, "CustomMsg");
        $this->Fields['fechafinsimulado_tarea'] = &$this->fechafinsimulado_tarea;

        // id_tarearelacion
        $this->id_tarearelacion = new DbField('tareas', 'tareas', 'x_id_tarearelacion', 'id_tarearelacion', '`id_tarearelacion`', '`id_tarearelacion`', 3, 11, -1, false, '`id_tarearelacion`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->id_tarearelacion->Sortable = true; // Allow sort
        $this->id_tarearelacion->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->id_tarearelacion->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->id_tarearelacion->Lookup = new Lookup('id_tarearelacion', 'tareas', false, 'id_tarea', ["id_grupo","titulo_tarea","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->id_tarearelacion->Lookup = new Lookup('id_tarearelacion', 'tareas', false, 'id_tarea', ["id_grupo","titulo_tarea","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->id_tarearelacion->Lookup = new Lookup('id_tarearelacion', 'tareas', false, 'id_tarea', ["id_grupo","titulo_tarea","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->id_tarearelacion->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_tarearelacion->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_tarearelacion->Param, "CustomMsg");
        $this->Fields['id_tarearelacion'] = &$this->id_tarearelacion;

        // archivo
        $this->archivo = new DbField('tareas', 'tareas', 'x_archivo', 'archivo', '`archivo`', '`archivo`', 200, 80, -1, true, '`archivo`', false, false, false, 'FORMATTED TEXT', 'FILE');
        $this->archivo->Sortable = true; // Allow sort
        $this->archivo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->archivo->Param, "CustomMsg");
        $this->Fields['archivo'] = &$this->archivo;

        // id_subgrupo
        $this->id_subgrupo = new DbField('tareas', 'tareas', 'x_id_subgrupo', 'id_subgrupo', '`id_subgrupo`', '`id_subgrupo`', 3, 11, -1, false, '`id_subgrupo`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->id_subgrupo->Sortable = true; // Allow sort
        $this->id_subgrupo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_subgrupo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_subgrupo->Param, "CustomMsg");
        $this->Fields['id_subgrupo'] = &$this->id_subgrupo;
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
        if ($this->getCurrentDetailTable() == "mensajes") {
            $detailUrl = Container("mensajes")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id_tarea", $this->id_tarea->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "TareasList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`tareas`";
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
            $this->id_tarea->setDbValue($conn->lastInsertId());
            $rs['id_tarea'] = $this->id_tarea->DbValue;
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
        // Cascade Update detail table 'mensajes'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id_tarea']) && $rsold['id_tarea'] != $rs['id_tarea'])) { // Update detail field 'id_tareas'
            $cascadeUpdate = true;
            $rscascade['id_tareas'] = $rs['id_tarea'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("mensajes")->loadRs("`id_tareas` = " . QuotedValue($rsold['id_tarea'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id_inyect';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("mensajes")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("mensajes")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("mensajes")->rowUpdated($rsdtlold, $rsdtlnew);
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
            if (array_key_exists('id_tarea', $rs)) {
                AddFilter($where, QuotedName('id_tarea', $this->Dbid) . '=' . QuotedValue($rs['id_tarea'], $this->id_tarea->DataType, $this->Dbid));
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

        // Cascade delete detail table 'mensajes'
        $dtlrows = Container("mensajes")->loadRs("`id_tareas` = " . QuotedValue($rs['id_tarea'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("mensajes")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("mensajes")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("mensajes")->rowDeleted($dtlrow);
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
        $this->id_tarea->DbValue = $row['id_tarea'];
        $this->id_escenario->DbValue = $row['id_escenario'];
        $this->id_grupo->DbValue = $row['id_grupo'];
        $this->titulo_tarea->DbValue = $row['titulo_tarea'];
        $this->descripcion_tarea->DbValue = $row['descripcion_tarea'];
        $this->fechainireal_tarea->DbValue = $row['fechainireal_tarea'];
        $this->fechafin_tarea->DbValue = $row['fechafin_tarea'];
        $this->fechainisimulado_tarea->DbValue = $row['fechainisimulado_tarea'];
        $this->fechafinsimulado_tarea->DbValue = $row['fechafinsimulado_tarea'];
        $this->id_tarearelacion->DbValue = $row['id_tarearelacion'];
        $this->archivo->Upload->DbValue = $row['archivo'];
        $this->id_subgrupo->DbValue = $row['id_subgrupo'];
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
        return "`id_tarea` = @id_tarea@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id_tarea->CurrentValue : $this->id_tarea->OldValue;
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
                $this->id_tarea->CurrentValue = $keys[0];
            } else {
                $this->id_tarea->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id_tarea', $row) ? $row['id_tarea'] : null;
        } else {
            $val = $this->id_tarea->OldValue !== null ? $this->id_tarea->OldValue : $this->id_tarea->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id_tarea@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("TareasList");
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
        if ($pageName == "TareasView") {
            return $Language->phrase("View");
        } elseif ($pageName == "TareasEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "TareasAdd") {
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
                return "TareasView";
            case Config("API_ADD_ACTION"):
                return "TareasAdd";
            case Config("API_EDIT_ACTION"):
                return "TareasEdit";
            case Config("API_DELETE_ACTION"):
                return "TareasDelete";
            case Config("API_LIST_ACTION"):
                return "TareasList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "TareasList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("TareasView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("TareasView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "TareasAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "TareasAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("TareasEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("TareasEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("TareasAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("TareasAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("TareasDelete", $this->getUrlParm());
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
        $json .= "id_tarea:" . JsonEncode($this->id_tarea->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id_tarea->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id_tarea->CurrentValue);
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
            if (($keyValue = Param("id_tarea") ?? Route("id_tarea")) !== null) {
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
                $this->id_tarea->CurrentValue = $key;
            } else {
                $this->id_tarea->OldValue = $key;
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
        $this->id_tarea->setDbValue($row['id_tarea']);
        $this->id_escenario->setDbValue($row['id_escenario']);
        $this->id_grupo->setDbValue($row['id_grupo']);
        $this->titulo_tarea->setDbValue($row['titulo_tarea']);
        $this->descripcion_tarea->setDbValue($row['descripcion_tarea']);
        $this->fechainireal_tarea->setDbValue($row['fechainireal_tarea']);
        $this->fechafin_tarea->setDbValue($row['fechafin_tarea']);
        $this->fechainisimulado_tarea->setDbValue($row['fechainisimulado_tarea']);
        $this->fechafinsimulado_tarea->setDbValue($row['fechafinsimulado_tarea']);
        $this->id_tarearelacion->setDbValue($row['id_tarearelacion']);
        $this->archivo->Upload->DbValue = $row['archivo'];
        $this->id_subgrupo->setDbValue($row['id_subgrupo']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id_tarea

        // id_escenario

        // id_grupo

        // titulo_tarea

        // descripcion_tarea

        // fechainireal_tarea

        // fechafin_tarea

        // fechainisimulado_tarea

        // fechafinsimulado_tarea

        // id_tarearelacion

        // archivo

        // id_subgrupo

        // id_tarea
        $this->id_tarea->ViewValue = $this->id_tarea->CurrentValue;
        $this->id_tarea->ViewCustomAttributes = "";

        // id_escenario
        $this->id_escenario->ViewValue = $this->id_escenario->CurrentValue;
        $this->id_escenario->ViewValue = FormatNumber($this->id_escenario->ViewValue, 0, -2, -2, -2);
        $this->id_escenario->ViewCustomAttributes = "";

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

        // titulo_tarea
        $this->titulo_tarea->ViewValue = $this->titulo_tarea->CurrentValue;
        $this->titulo_tarea->ViewCustomAttributes = "";

        // descripcion_tarea
        $this->descripcion_tarea->ViewValue = $this->descripcion_tarea->CurrentValue;
        $this->descripcion_tarea->ViewCustomAttributes = "";

        // fechainireal_tarea
        $this->fechainireal_tarea->ViewValue = $this->fechainireal_tarea->CurrentValue;
        $this->fechainireal_tarea->ViewValue = FormatDateTime($this->fechainireal_tarea->ViewValue, 109);
        $this->fechainireal_tarea->ViewCustomAttributes = "";

        // fechafin_tarea
        $this->fechafin_tarea->ViewValue = $this->fechafin_tarea->CurrentValue;
        $this->fechafin_tarea->ViewValue = FormatDateTime($this->fechafin_tarea->ViewValue, 109);
        $this->fechafin_tarea->ViewCustomAttributes = "";

        // fechainisimulado_tarea
        $this->fechainisimulado_tarea->ViewValue = $this->fechainisimulado_tarea->CurrentValue;
        $this->fechainisimulado_tarea->ViewValue = FormatDateTime($this->fechainisimulado_tarea->ViewValue, 109);
        $this->fechainisimulado_tarea->ViewCustomAttributes = "";

        // fechafinsimulado_tarea
        $this->fechafinsimulado_tarea->ViewValue = $this->fechafinsimulado_tarea->CurrentValue;
        $this->fechafinsimulado_tarea->ViewValue = FormatDateTime($this->fechafinsimulado_tarea->ViewValue, 109);
        $this->fechafinsimulado_tarea->ViewCustomAttributes = "";

        // id_tarearelacion
        $curVal = strval($this->id_tarearelacion->CurrentValue);
        if ($curVal != "") {
            $this->id_tarearelacion->ViewValue = $this->id_tarearelacion->lookupCacheOption($curVal);
            if ($this->id_tarearelacion->ViewValue === null) { // Lookup from database
                $filterWrk = "`id_tarea`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->id_tarearelacion->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->id_tarearelacion->Lookup->renderViewRow($rswrk[0]);
                    $this->id_tarearelacion->ViewValue = $this->id_tarearelacion->displayValue($arwrk);
                } else {
                    $this->id_tarearelacion->ViewValue = $this->id_tarearelacion->CurrentValue;
                }
            }
        } else {
            $this->id_tarearelacion->ViewValue = null;
        }
        $this->id_tarearelacion->ViewCustomAttributes = "";

        // archivo
        if (!EmptyValue($this->archivo->Upload->DbValue)) {
            $this->archivo->ViewValue = $this->archivo->Upload->DbValue;
        } else {
            $this->archivo->ViewValue = "";
        }
        $this->archivo->ViewCustomAttributes = "";

        // id_subgrupo
        $this->id_subgrupo->ViewValue = $this->id_subgrupo->CurrentValue;
        $this->id_subgrupo->ViewValue = FormatNumber($this->id_subgrupo->ViewValue, 0, -2, -2, -2);
        $this->id_subgrupo->ViewCustomAttributes = "";

        // id_tarea
        $this->id_tarea->LinkCustomAttributes = "";
        $this->id_tarea->HrefValue = "";
        $this->id_tarea->TooltipValue = "";

        // id_escenario
        $this->id_escenario->LinkCustomAttributes = "";
        $this->id_escenario->HrefValue = "";
        $this->id_escenario->TooltipValue = "";

        // id_grupo
        $this->id_grupo->LinkCustomAttributes = "";
        $this->id_grupo->HrefValue = "";
        $this->id_grupo->TooltipValue = "";

        // titulo_tarea
        $this->titulo_tarea->LinkCustomAttributes = "";
        $this->titulo_tarea->HrefValue = "";
        $this->titulo_tarea->TooltipValue = "";

        // descripcion_tarea
        $this->descripcion_tarea->LinkCustomAttributes = "";
        $this->descripcion_tarea->HrefValue = "";
        $this->descripcion_tarea->TooltipValue = "";

        // fechainireal_tarea
        $this->fechainireal_tarea->LinkCustomAttributes = "";
        $this->fechainireal_tarea->HrefValue = "";
        $this->fechainireal_tarea->TooltipValue = "";

        // fechafin_tarea
        $this->fechafin_tarea->LinkCustomAttributes = "";
        $this->fechafin_tarea->HrefValue = "";
        $this->fechafin_tarea->TooltipValue = "";

        // fechainisimulado_tarea
        $this->fechainisimulado_tarea->LinkCustomAttributes = "";
        $this->fechainisimulado_tarea->HrefValue = "";
        $this->fechainisimulado_tarea->TooltipValue = "";

        // fechafinsimulado_tarea
        $this->fechafinsimulado_tarea->LinkCustomAttributes = "";
        $this->fechafinsimulado_tarea->HrefValue = "";
        $this->fechafinsimulado_tarea->TooltipValue = "";

        // id_tarearelacion
        $this->id_tarearelacion->LinkCustomAttributes = "";
        $this->id_tarearelacion->HrefValue = "";
        $this->id_tarearelacion->TooltipValue = "";

        // archivo
        $this->archivo->LinkCustomAttributes = "";
        $this->archivo->HrefValue = "";
        $this->archivo->ExportHrefValue = $this->archivo->UploadPath . $this->archivo->Upload->DbValue;
        $this->archivo->TooltipValue = "";

        // id_subgrupo
        $this->id_subgrupo->LinkCustomAttributes = "";
        $this->id_subgrupo->HrefValue = "";
        $this->id_subgrupo->TooltipValue = "";

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

        // id_tarea
        $this->id_tarea->EditAttrs["class"] = "form-control";
        $this->id_tarea->EditCustomAttributes = "";
        $this->id_tarea->EditValue = $this->id_tarea->CurrentValue;
        $this->id_tarea->ViewCustomAttributes = "";

        // id_escenario
        $this->id_escenario->EditAttrs["class"] = "form-control";
        $this->id_escenario->EditCustomAttributes = "";
        if ($this->id_escenario->getSessionValue() != "") {
            $this->id_escenario->CurrentValue = GetForeignKeyValue($this->id_escenario->getSessionValue());
            $this->id_escenario->ViewValue = $this->id_escenario->CurrentValue;
            $this->id_escenario->ViewValue = FormatNumber($this->id_escenario->ViewValue, 0, -2, -2, -2);
            $this->id_escenario->ViewCustomAttributes = "";
        } else {
            $this->id_escenario->EditValue = $this->id_escenario->CurrentValue;
            $this->id_escenario->PlaceHolder = RemoveHtml($this->id_escenario->caption());
        }

        // id_grupo
        $this->id_grupo->EditAttrs["class"] = "form-control";
        $this->id_grupo->EditCustomAttributes = "";
        $this->id_grupo->PlaceHolder = RemoveHtml($this->id_grupo->caption());

        // titulo_tarea
        $this->titulo_tarea->EditAttrs["class"] = "form-control";
        $this->titulo_tarea->EditCustomAttributes = "";
        if (!$this->titulo_tarea->Raw) {
            $this->titulo_tarea->CurrentValue = HtmlDecode($this->titulo_tarea->CurrentValue);
        }
        $this->titulo_tarea->EditValue = $this->titulo_tarea->CurrentValue;
        $this->titulo_tarea->PlaceHolder = RemoveHtml($this->titulo_tarea->caption());

        // descripcion_tarea
        $this->descripcion_tarea->EditAttrs["class"] = "form-control";
        $this->descripcion_tarea->EditCustomAttributes = "";
        $this->descripcion_tarea->EditValue = $this->descripcion_tarea->CurrentValue;
        $this->descripcion_tarea->PlaceHolder = RemoveHtml($this->descripcion_tarea->caption());

        // fechainireal_tarea
        $this->fechainireal_tarea->EditAttrs["class"] = "form-control";
        $this->fechainireal_tarea->EditCustomAttributes = "";
        $this->fechainireal_tarea->EditValue = FormatDateTime($this->fechainireal_tarea->CurrentValue, 109);
        $this->fechainireal_tarea->PlaceHolder = RemoveHtml($this->fechainireal_tarea->caption());

        // fechafin_tarea
        $this->fechafin_tarea->EditAttrs["class"] = "form-control";
        $this->fechafin_tarea->EditCustomAttributes = "";
        $this->fechafin_tarea->EditValue = FormatDateTime($this->fechafin_tarea->CurrentValue, 109);
        $this->fechafin_tarea->PlaceHolder = RemoveHtml($this->fechafin_tarea->caption());

        // fechainisimulado_tarea
        $this->fechainisimulado_tarea->EditAttrs["class"] = "form-control";
        $this->fechainisimulado_tarea->EditCustomAttributes = "";
        $this->fechainisimulado_tarea->EditValue = FormatDateTime($this->fechainisimulado_tarea->CurrentValue, 109);
        $this->fechainisimulado_tarea->PlaceHolder = RemoveHtml($this->fechainisimulado_tarea->caption());

        // fechafinsimulado_tarea
        $this->fechafinsimulado_tarea->EditAttrs["class"] = "form-control";
        $this->fechafinsimulado_tarea->EditCustomAttributes = "";
        $this->fechafinsimulado_tarea->EditValue = FormatDateTime($this->fechafinsimulado_tarea->CurrentValue, 109);
        $this->fechafinsimulado_tarea->PlaceHolder = RemoveHtml($this->fechafinsimulado_tarea->caption());

        // id_tarearelacion
        $this->id_tarearelacion->EditAttrs["class"] = "form-control";
        $this->id_tarearelacion->EditCustomAttributes = "";
        $this->id_tarearelacion->PlaceHolder = RemoveHtml($this->id_tarearelacion->caption());

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

        // id_subgrupo
        $this->id_subgrupo->EditAttrs["class"] = "form-control";
        $this->id_subgrupo->EditCustomAttributes = "";
        $this->id_subgrupo->EditValue = $this->id_subgrupo->CurrentValue;
        $this->id_subgrupo->PlaceHolder = RemoveHtml($this->id_subgrupo->caption());

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
                    $doc->exportCaption($this->id_tarea);
                    $doc->exportCaption($this->id_escenario);
                    $doc->exportCaption($this->id_grupo);
                    $doc->exportCaption($this->titulo_tarea);
                    $doc->exportCaption($this->descripcion_tarea);
                    $doc->exportCaption($this->fechainireal_tarea);
                    $doc->exportCaption($this->fechafin_tarea);
                    $doc->exportCaption($this->fechainisimulado_tarea);
                    $doc->exportCaption($this->fechafinsimulado_tarea);
                    $doc->exportCaption($this->id_tarearelacion);
                    $doc->exportCaption($this->archivo);
                    $doc->exportCaption($this->id_subgrupo);
                } else {
                    $doc->exportCaption($this->id_tarea);
                    $doc->exportCaption($this->id_escenario);
                    $doc->exportCaption($this->id_grupo);
                    $doc->exportCaption($this->titulo_tarea);
                    $doc->exportCaption($this->fechainireal_tarea);
                    $doc->exportCaption($this->fechafin_tarea);
                    $doc->exportCaption($this->fechainisimulado_tarea);
                    $doc->exportCaption($this->fechafinsimulado_tarea);
                    $doc->exportCaption($this->id_tarearelacion);
                    $doc->exportCaption($this->archivo);
                    $doc->exportCaption($this->id_subgrupo);
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
                        $doc->exportField($this->id_tarea);
                        $doc->exportField($this->id_escenario);
                        $doc->exportField($this->id_grupo);
                        $doc->exportField($this->titulo_tarea);
                        $doc->exportField($this->descripcion_tarea);
                        $doc->exportField($this->fechainireal_tarea);
                        $doc->exportField($this->fechafin_tarea);
                        $doc->exportField($this->fechainisimulado_tarea);
                        $doc->exportField($this->fechafinsimulado_tarea);
                        $doc->exportField($this->id_tarearelacion);
                        $doc->exportField($this->archivo);
                        $doc->exportField($this->id_subgrupo);
                    } else {
                        $doc->exportField($this->id_tarea);
                        $doc->exportField($this->id_escenario);
                        $doc->exportField($this->id_grupo);
                        $doc->exportField($this->titulo_tarea);
                        $doc->exportField($this->fechainireal_tarea);
                        $doc->exportField($this->fechafin_tarea);
                        $doc->exportField($this->fechainisimulado_tarea);
                        $doc->exportField($this->fechafinsimulado_tarea);
                        $doc->exportField($this->id_tarearelacion);
                        $doc->exportField($this->archivo);
                        $doc->exportField($this->id_subgrupo);
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
            $this->id_tarea->CurrentValue = $ar[0];
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
