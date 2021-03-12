<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for escenario
 */
class Escenario extends DbTable
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
    public $icon_escenario;
    public $fechacreacion_escenario;
    public $nombre_escenario;
    public $tipo_evento;
    public $incidente;
    public $pais_escenario;
    public $zonahora_escenario;
    public $descripcion_escenario;
    public $fechaini_simulado;
    public $fechafin_simulado;
    public $fechaini_real;
    public $fechafinal_real;
    public $image_escenario;
    public $estado;
    public $entrar;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'escenario';
        $this->TableName = 'escenario';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`escenario`";
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
        $this->id_escenario = new DbField('escenario', 'escenario', 'x_id_escenario', 'id_escenario', '`id_escenario`', '`id_escenario`', 3, 11, -1, false, '`id_escenario`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id_escenario->IsAutoIncrement = true; // Autoincrement field
        $this->id_escenario->IsPrimaryKey = true; // Primary key field
        $this->id_escenario->IsForeignKey = true; // Foreign key field
        $this->id_escenario->Sortable = true; // Allow sort
        $this->id_escenario->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_escenario->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_escenario->Param, "CustomMsg");
        $this->Fields['id_escenario'] = &$this->id_escenario;

        // icon_escenario
        $this->icon_escenario = new DbField('escenario', 'escenario', 'x_icon_escenario', 'icon_escenario', '`icon_escenario`', '`icon_escenario`', 201, 65535, -1, false, '`icon_escenario`', false, false, false, 'IMAGE', 'HIDDEN');
        $this->icon_escenario->Sortable = true; // Allow sort
        $this->icon_escenario->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->icon_escenario->Param, "CustomMsg");
        $this->Fields['icon_escenario'] = &$this->icon_escenario;

        // fechacreacion_escenario
        $this->fechacreacion_escenario = new DbField('escenario', 'escenario', 'x_fechacreacion_escenario', 'fechacreacion_escenario', '`fechacreacion_escenario`', CastDateFieldForLike("`fechacreacion_escenario`", 9, "DB"), 135, 26, 9, false, '`fechacreacion_escenario`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fechacreacion_escenario->Sortable = true; // Allow sort
        $this->fechacreacion_escenario->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->fechacreacion_escenario->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fechacreacion_escenario->Param, "CustomMsg");
        $this->Fields['fechacreacion_escenario'] = &$this->fechacreacion_escenario;

        // nombre_escenario
        $this->nombre_escenario = new DbField('escenario', 'escenario', 'x_nombre_escenario', 'nombre_escenario', '`nombre_escenario`', '`nombre_escenario`', 200, 120, -1, false, '`nombre_escenario`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nombre_escenario->Required = true; // Required field
        $this->nombre_escenario->Sortable = true; // Allow sort
        $this->nombre_escenario->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nombre_escenario->Param, "CustomMsg");
        $this->Fields['nombre_escenario'] = &$this->nombre_escenario;

        // tipo_evento
        $this->tipo_evento = new DbField('escenario', 'escenario', 'x_tipo_evento', 'tipo_evento', '`tipo_evento`', '`tipo_evento`', 3, 2, -1, false, '`tipo_evento`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->tipo_evento->Required = true; // Required field
        $this->tipo_evento->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->tipo_evento->Lookup = new Lookup('tipo_evento', 'tipo', false, 'id_tipo', ["tipo_es","","",""], [], ["x_incidente"], [], [], [], [], '', '');
                break;
            case "es":
                $this->tipo_evento->Lookup = new Lookup('tipo_evento', 'tipo', false, 'id_tipo', ["tipo_es","","",""], [], ["x_incidente"], [], [], [], [], '', '');
                break;
            default:
                $this->tipo_evento->Lookup = new Lookup('tipo_evento', 'tipo', false, 'id_tipo', ["tipo_es","","",""], [], ["x_incidente"], [], [], [], [], '', '');
                break;
        }
        $this->tipo_evento->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->tipo_evento->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tipo_evento->Param, "CustomMsg");
        $this->Fields['tipo_evento'] = &$this->tipo_evento;

        // incidente
        $this->incidente = new DbField('escenario', 'escenario', 'x_incidente', 'incidente', '`incidente`', '`incidente`', 3, 2, -1, false, '`incidente`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->incidente->Required = true; // Required field
        $this->incidente->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->incidente->Lookup = new Lookup('incidente', 'incidente', false, 'id_incidente', ["incidente_es","","",""], ["x_tipo_evento"], [], ["id_tipo"], ["x_id_tipo"], [], [], '', '');
                break;
            case "es":
                $this->incidente->Lookup = new Lookup('incidente', 'incidente', false, 'id_incidente', ["incidente_es","","",""], ["x_tipo_evento"], [], ["id_tipo"], ["x_id_tipo"], [], [], '', '');
                break;
            default:
                $this->incidente->Lookup = new Lookup('incidente', 'incidente', false, 'id_incidente', ["incidente_es","","",""], ["x_tipo_evento"], [], ["id_tipo"], ["x_id_tipo"], [], [], '', '');
                break;
        }
        $this->incidente->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->incidente->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->incidente->Param, "CustomMsg");
        $this->Fields['incidente'] = &$this->incidente;

        // pais_escenario
        $this->pais_escenario = new DbField('escenario', 'escenario', 'x_pais_escenario', 'pais_escenario', '`pais_escenario`', '`pais_escenario`', 200, 10, -1, false, '`pais_escenario`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->pais_escenario->Required = true; // Required field
        $this->pais_escenario->Sortable = true; // Allow sort
        $this->pais_escenario->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->pais_escenario->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->pais_escenario->Lookup = new Lookup('pais_escenario', 'paisgmt', false, 'id_zone', ["nompais","timezone","gmt",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->pais_escenario->Lookup = new Lookup('pais_escenario', 'paisgmt', false, 'id_zone', ["nompais","timezone","gmt",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->pais_escenario->Lookup = new Lookup('pais_escenario', 'paisgmt', false, 'id_zone', ["nompais","timezone","gmt",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->pais_escenario->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pais_escenario->Param, "CustomMsg");
        $this->Fields['pais_escenario'] = &$this->pais_escenario;

        // zonahora_escenario
        $this->zonahora_escenario = new DbField('escenario', 'escenario', 'x_zonahora_escenario', 'zonahora_escenario', '`zonahora_escenario`', '`zonahora_escenario`', 200, 10, -1, false, '`zonahora_escenario`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->zonahora_escenario->Sortable = false; // Allow sort
        $this->zonahora_escenario->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->zonahora_escenario->Param, "CustomMsg");
        $this->Fields['zonahora_escenario'] = &$this->zonahora_escenario;

        // descripcion_escenario
        $this->descripcion_escenario = new DbField('escenario', 'escenario', 'x_descripcion_escenario', 'descripcion_escenario', '`descripcion_escenario`', '`descripcion_escenario`', 201, 65535, -1, false, '`descripcion_escenario`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->descripcion_escenario->Sortable = true; // Allow sort
        $this->descripcion_escenario->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->descripcion_escenario->Param, "CustomMsg");
        $this->Fields['descripcion_escenario'] = &$this->descripcion_escenario;

        // fechaini_simulado
        $this->fechaini_simulado = new DbField('escenario', 'escenario', 'x_fechaini_simulado', 'fechaini_simulado', '`fechaini_simulado`', CastDateFieldForLike("`fechaini_simulado`", 109, "DB"), 135, 26, 109, false, '`fechaini_simulado`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fechaini_simulado->Sortable = true; // Allow sort
        $this->fechaini_simulado->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->fechaini_simulado->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fechaini_simulado->Param, "CustomMsg");
        $this->Fields['fechaini_simulado'] = &$this->fechaini_simulado;

        // fechafin_simulado
        $this->fechafin_simulado = new DbField('escenario', 'escenario', 'x_fechafin_simulado', 'fechafin_simulado', '`fechafin_simulado`', CastDateFieldForLike("`fechafin_simulado`", 109, "DB"), 135, 26, 109, false, '`fechafin_simulado`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fechafin_simulado->Sortable = true; // Allow sort
        $this->fechafin_simulado->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->fechafin_simulado->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fechafin_simulado->Param, "CustomMsg");
        $this->Fields['fechafin_simulado'] = &$this->fechafin_simulado;

        // fechaini_real
        $this->fechaini_real = new DbField('escenario', 'escenario', 'x_fechaini_real', 'fechaini_real', '`fechaini_real`', CastDateFieldForLike("`fechaini_real`", 109, "DB"), 135, 26, 109, false, '`fechaini_real`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fechaini_real->Sortable = true; // Allow sort
        $this->fechaini_real->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->fechaini_real->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fechaini_real->Param, "CustomMsg");
        $this->Fields['fechaini_real'] = &$this->fechaini_real;

        // fechafinal_real
        $this->fechafinal_real = new DbField('escenario', 'escenario', 'x_fechafinal_real', 'fechafinal_real', '`fechafinal_real`', CastDateFieldForLike("`fechafinal_real`", 109, "DB"), 135, 26, 109, false, '`fechafinal_real`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fechafinal_real->Sortable = true; // Allow sort
        $this->fechafinal_real->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->fechafinal_real->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fechafinal_real->Param, "CustomMsg");
        $this->Fields['fechafinal_real'] = &$this->fechafinal_real;

        // image_escenario
        $this->image_escenario = new DbField('escenario', 'escenario', 'x_image_escenario', 'image_escenario', '`image_escenario`', '`image_escenario`', 201, 65535, -1, true, '`image_escenario`', false, false, false, 'IMAGE', 'FILE');
        $this->image_escenario->Sortable = true; // Allow sort
        $this->image_escenario->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->image_escenario->Param, "CustomMsg");
        $this->Fields['image_escenario'] = &$this->image_escenario;

        // estado
        $this->estado = new DbField('escenario', 'escenario', 'x_estado', 'estado', '`estado`', '`estado`', 200, 30, -1, false, '`estado`', false, false, false, 'FORMATTED TEXT', 'RADIO');
        $this->estado->Sortable = true; // Allow sort
        switch ($CurrentLanguage) {
            case "en":
                $this->estado->Lookup = new Lookup('estado', 'escenario', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->estado->Lookup = new Lookup('estado', 'escenario', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->estado->Lookup = new Lookup('estado', 'escenario', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->estado->OptionCount = 3;
        $this->estado->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->estado->Param, "CustomMsg");
        $this->Fields['estado'] = &$this->estado;

        // entrar
        $this->entrar = new DbField('escenario', 'escenario', 'x_entrar', 'entrar', 'id_escenario', 'id_escenario', 3, 11, -1, false, 'id_escenario', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->entrar->IsCustom = true; // Custom field
        $this->entrar->Sortable = true; // Allow sort
        $this->entrar->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->entrar->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->entrar->Param, "CustomMsg");
        $this->Fields['entrar'] = &$this->entrar;
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
        if ($this->getCurrentDetailTable() == "grupo") {
            $detailUrl = Container("grupo")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id_escenario", $this->id_escenario->CurrentValue);
        }
        if ($this->getCurrentDetailTable() == "tareas") {
            $detailUrl = Container("tareas")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id_escenario", $this->id_escenario->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "EscenarioList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`escenario`";
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
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*, id_escenario AS `entrar`");
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
            $this->id_escenario->setDbValue($conn->lastInsertId());
            $rs['id_escenario'] = $this->id_escenario->DbValue;
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
        // Cascade Update detail table 'grupo'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id_escenario']) && $rsold['id_escenario'] != $rs['id_escenario'])) { // Update detail field 'id_escenario'
            $cascadeUpdate = true;
            $rscascade['id_escenario'] = $rs['id_escenario'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("grupo")->loadRs("`id_escenario` = " . QuotedValue($rsold['id_escenario'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id_grupo';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("grupo")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("grupo")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("grupo")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

        // Cascade Update detail table 'tareas'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id_escenario']) && $rsold['id_escenario'] != $rs['id_escenario'])) { // Update detail field 'id_escenario'
            $cascadeUpdate = true;
            $rscascade['id_escenario'] = $rs['id_escenario'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("tareas")->loadRs("`id_escenario` = " . QuotedValue($rsold['id_escenario'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id_tarea';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("tareas")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("tareas")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("tareas")->rowUpdated($rsdtlold, $rsdtlnew);
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
            if (array_key_exists('id_escenario', $rs)) {
                AddFilter($where, QuotedName('id_escenario', $this->Dbid) . '=' . QuotedValue($rs['id_escenario'], $this->id_escenario->DataType, $this->Dbid));
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

        // Cascade delete detail table 'grupo'
        $dtlrows = Container("grupo")->loadRs("`id_escenario` = " . QuotedValue($rs['id_escenario'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("grupo")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("grupo")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("grupo")->rowDeleted($dtlrow);
            }
        }

        // Cascade delete detail table 'tareas'
        $dtlrows = Container("tareas")->loadRs("`id_escenario` = " . QuotedValue($rs['id_escenario'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("tareas")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("tareas")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("tareas")->rowDeleted($dtlrow);
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
        $this->icon_escenario->DbValue = $row['icon_escenario'];
        $this->fechacreacion_escenario->DbValue = $row['fechacreacion_escenario'];
        $this->nombre_escenario->DbValue = $row['nombre_escenario'];
        $this->tipo_evento->DbValue = $row['tipo_evento'];
        $this->incidente->DbValue = $row['incidente'];
        $this->pais_escenario->DbValue = $row['pais_escenario'];
        $this->zonahora_escenario->DbValue = $row['zonahora_escenario'];
        $this->descripcion_escenario->DbValue = $row['descripcion_escenario'];
        $this->fechaini_simulado->DbValue = $row['fechaini_simulado'];
        $this->fechafin_simulado->DbValue = $row['fechafin_simulado'];
        $this->fechaini_real->DbValue = $row['fechaini_real'];
        $this->fechafinal_real->DbValue = $row['fechafinal_real'];
        $this->image_escenario->Upload->DbValue = $row['image_escenario'];
        $this->estado->DbValue = $row['estado'];
        $this->entrar->DbValue = $row['entrar'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['image_escenario']) ? [] : [$row['image_escenario']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->image_escenario->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->image_escenario->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id_escenario` = @id_escenario@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id_escenario->CurrentValue : $this->id_escenario->OldValue;
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
                $this->id_escenario->CurrentValue = $keys[0];
            } else {
                $this->id_escenario->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id_escenario', $row) ? $row['id_escenario'] : null;
        } else {
            $val = $this->id_escenario->OldValue !== null ? $this->id_escenario->OldValue : $this->id_escenario->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id_escenario@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("EscenarioList");
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
        if ($pageName == "EscenarioView") {
            return $Language->phrase("View");
        } elseif ($pageName == "EscenarioEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "EscenarioAdd") {
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
                return "EscenarioView";
            case Config("API_ADD_ACTION"):
                return "EscenarioAdd";
            case Config("API_EDIT_ACTION"):
                return "EscenarioEdit";
            case Config("API_DELETE_ACTION"):
                return "EscenarioDelete";
            case Config("API_LIST_ACTION"):
                return "EscenarioList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "EscenarioList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("EscenarioView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("EscenarioView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "EscenarioAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "EscenarioAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("EscenarioEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("EscenarioEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
            $url = $this->keyUrl("EscenarioAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("EscenarioAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
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
        return $this->keyUrl("EscenarioDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id_escenario:" . JsonEncode($this->id_escenario->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id_escenario->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id_escenario->CurrentValue);
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
            if (($keyValue = Param("id_escenario") ?? Route("id_escenario")) !== null) {
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
                $this->id_escenario->CurrentValue = $key;
            } else {
                $this->id_escenario->OldValue = $key;
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
        $this->icon_escenario->setDbValue($row['icon_escenario']);
        $this->fechacreacion_escenario->setDbValue($row['fechacreacion_escenario']);
        $this->nombre_escenario->setDbValue($row['nombre_escenario']);
        $this->tipo_evento->setDbValue($row['tipo_evento']);
        $this->incidente->setDbValue($row['incidente']);
        $this->pais_escenario->setDbValue($row['pais_escenario']);
        $this->zonahora_escenario->setDbValue($row['zonahora_escenario']);
        $this->descripcion_escenario->setDbValue($row['descripcion_escenario']);
        $this->fechaini_simulado->setDbValue($row['fechaini_simulado']);
        $this->fechafin_simulado->setDbValue($row['fechafin_simulado']);
        $this->fechaini_real->setDbValue($row['fechaini_real']);
        $this->fechafinal_real->setDbValue($row['fechafinal_real']);
        $this->image_escenario->Upload->DbValue = $row['image_escenario'];
        $this->estado->setDbValue($row['estado']);
        $this->entrar->setDbValue($row['entrar']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id_escenario

        // icon_escenario

        // fechacreacion_escenario

        // nombre_escenario

        // tipo_evento

        // incidente

        // pais_escenario

        // zonahora_escenario
        $this->zonahora_escenario->CellCssStyle = "white-space: nowrap;";

        // descripcion_escenario

        // fechaini_simulado

        // fechafin_simulado

        // fechaini_real

        // fechafinal_real

        // image_escenario

        // estado

        // entrar

        // id_escenario
        $this->id_escenario->ViewValue = $this->id_escenario->CurrentValue;
        $this->id_escenario->ViewCustomAttributes = "";

        // icon_escenario
        $this->icon_escenario->ViewValue = $this->icon_escenario->CurrentValue;
        $this->icon_escenario->ViewCustomAttributes = "";

        // fechacreacion_escenario
        $this->fechacreacion_escenario->ViewValue = $this->fechacreacion_escenario->CurrentValue;
        $this->fechacreacion_escenario->ViewValue = FormatDateTime($this->fechacreacion_escenario->ViewValue, 9);
        $this->fechacreacion_escenario->ViewCustomAttributes = "";

        // nombre_escenario
        $this->nombre_escenario->ViewValue = $this->nombre_escenario->CurrentValue;
        $this->nombre_escenario->ViewCustomAttributes = "";

        // tipo_evento
        $curVal = strval($this->tipo_evento->CurrentValue);
        if ($curVal != "") {
            $this->tipo_evento->ViewValue = $this->tipo_evento->lookupCacheOption($curVal);
            if ($this->tipo_evento->ViewValue === null) { // Lookup from database
                $filterWrk = "`id_tipo`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->tipo_evento->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->tipo_evento->Lookup->renderViewRow($rswrk[0]);
                    $this->tipo_evento->ViewValue = $this->tipo_evento->displayValue($arwrk);
                } else {
                    $this->tipo_evento->ViewValue = $this->tipo_evento->CurrentValue;
                }
            }
        } else {
            $this->tipo_evento->ViewValue = null;
        }
        $this->tipo_evento->ViewCustomAttributes = "";

        // incidente
        $curVal = strval($this->incidente->CurrentValue);
        if ($curVal != "") {
            $this->incidente->ViewValue = $this->incidente->lookupCacheOption($curVal);
            if ($this->incidente->ViewValue === null) { // Lookup from database
                $filterWrk = "`id_incidente`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->incidente->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->incidente->Lookup->renderViewRow($rswrk[0]);
                    $this->incidente->ViewValue = $this->incidente->displayValue($arwrk);
                } else {
                    $this->incidente->ViewValue = $this->incidente->CurrentValue;
                }
            }
        } else {
            $this->incidente->ViewValue = null;
        }
        $this->incidente->ViewCustomAttributes = "";

        // pais_escenario
        $curVal = strval($this->pais_escenario->CurrentValue);
        if ($curVal != "") {
            $this->pais_escenario->ViewValue = $this->pais_escenario->lookupCacheOption($curVal);
            if ($this->pais_escenario->ViewValue === null) { // Lookup from database
                $filterWrk = "`id_zone`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->pais_escenario->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->pais_escenario->Lookup->renderViewRow($rswrk[0]);
                    $this->pais_escenario->ViewValue = $this->pais_escenario->displayValue($arwrk);
                } else {
                    $this->pais_escenario->ViewValue = $this->pais_escenario->CurrentValue;
                }
            }
        } else {
            $this->pais_escenario->ViewValue = null;
        }
        $this->pais_escenario->ViewCustomAttributes = "";

        // zonahora_escenario
        $this->zonahora_escenario->ViewValue = $this->zonahora_escenario->CurrentValue;
        $this->zonahora_escenario->ViewCustomAttributes = "";

        // descripcion_escenario
        $this->descripcion_escenario->ViewValue = $this->descripcion_escenario->CurrentValue;
        $this->descripcion_escenario->ViewCustomAttributes = "";

        // fechaini_simulado
        $this->fechaini_simulado->ViewValue = $this->fechaini_simulado->CurrentValue;
        $this->fechaini_simulado->ViewValue = FormatDateTime($this->fechaini_simulado->ViewValue, 109);
        $this->fechaini_simulado->ViewCustomAttributes = "";

        // fechafin_simulado
        $this->fechafin_simulado->ViewValue = $this->fechafin_simulado->CurrentValue;
        $this->fechafin_simulado->ViewValue = FormatDateTime($this->fechafin_simulado->ViewValue, 109);
        $this->fechafin_simulado->ViewCustomAttributes = "";

        // fechaini_real
        $this->fechaini_real->ViewValue = $this->fechaini_real->CurrentValue;
        $this->fechaini_real->ViewValue = FormatDateTime($this->fechaini_real->ViewValue, 109);
        $this->fechaini_real->ViewCustomAttributes = "";

        // fechafinal_real
        $this->fechafinal_real->ViewValue = $this->fechafinal_real->CurrentValue;
        $this->fechafinal_real->ViewValue = FormatDateTime($this->fechafinal_real->ViewValue, 109);
        $this->fechafinal_real->ViewCustomAttributes = "";

        // image_escenario
        if (!EmptyValue($this->image_escenario->Upload->DbValue)) {
            $this->image_escenario->ImageAlt = $this->image_escenario->alt();
            $this->image_escenario->ViewValue = $this->image_escenario->Upload->DbValue;
        } else {
            $this->image_escenario->ViewValue = "";
        }
        $this->image_escenario->ViewCustomAttributes = "";

        // estado
        if (strval($this->estado->CurrentValue) != "") {
            $this->estado->ViewValue = $this->estado->optionCaption($this->estado->CurrentValue);
        } else {
            $this->estado->ViewValue = null;
        }
        $this->estado->ViewCustomAttributes = "";

        // entrar
        $this->entrar->ViewValue = $this->entrar->CurrentValue;
        $this->entrar->ViewValue = FormatNumber($this->entrar->ViewValue, 0, -2, -2, -2);
        $this->entrar->ViewCustomAttributes = "";

        // id_escenario
        $this->id_escenario->LinkCustomAttributes = "";
        $this->id_escenario->HrefValue = "";
        $this->id_escenario->TooltipValue = "";

        // icon_escenario
        $this->icon_escenario->LinkCustomAttributes = "";
        $this->icon_escenario->HrefValue = "";
        $this->icon_escenario->TooltipValue = "";

        // fechacreacion_escenario
        $this->fechacreacion_escenario->LinkCustomAttributes = "";
        $this->fechacreacion_escenario->HrefValue = "";
        $this->fechacreacion_escenario->TooltipValue = "";

        // nombre_escenario
        $this->nombre_escenario->LinkCustomAttributes = "";
        $this->nombre_escenario->HrefValue = "";
        $this->nombre_escenario->TooltipValue = "";

        // tipo_evento
        $this->tipo_evento->LinkCustomAttributes = "";
        $this->tipo_evento->HrefValue = "";
        $this->tipo_evento->TooltipValue = "";

        // incidente
        $this->incidente->LinkCustomAttributes = "";
        $this->incidente->HrefValue = "";
        $this->incidente->TooltipValue = "";

        // pais_escenario
        $this->pais_escenario->LinkCustomAttributes = "";
        $this->pais_escenario->HrefValue = "";
        $this->pais_escenario->TooltipValue = "";

        // zonahora_escenario
        $this->zonahora_escenario->LinkCustomAttributes = "";
        $this->zonahora_escenario->HrefValue = "";
        $this->zonahora_escenario->TooltipValue = "";

        // descripcion_escenario
        $this->descripcion_escenario->LinkCustomAttributes = "";
        $this->descripcion_escenario->HrefValue = "";
        $this->descripcion_escenario->TooltipValue = "";

        // fechaini_simulado
        $this->fechaini_simulado->LinkCustomAttributes = "";
        $this->fechaini_simulado->HrefValue = "";
        $this->fechaini_simulado->TooltipValue = "";

        // fechafin_simulado
        $this->fechafin_simulado->LinkCustomAttributes = "";
        $this->fechafin_simulado->HrefValue = "";
        $this->fechafin_simulado->TooltipValue = "";

        // fechaini_real
        $this->fechaini_real->LinkCustomAttributes = "";
        $this->fechaini_real->HrefValue = "";
        $this->fechaini_real->TooltipValue = "";

        // fechafinal_real
        $this->fechafinal_real->LinkCustomAttributes = "";
        $this->fechafinal_real->HrefValue = "";
        $this->fechafinal_real->TooltipValue = "";

        // image_escenario
        $this->image_escenario->LinkCustomAttributes = "";
        if (!EmptyValue($this->image_escenario->Upload->DbValue)) {
            $this->image_escenario->HrefValue = GetFileUploadUrl($this->image_escenario, $this->image_escenario->htmlDecode($this->image_escenario->Upload->DbValue)); // Add prefix/suffix
            $this->image_escenario->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->image_escenario->HrefValue = FullUrl($this->image_escenario->HrefValue, "href");
            }
        } else {
            $this->image_escenario->HrefValue = "";
        }
        $this->image_escenario->ExportHrefValue = $this->image_escenario->UploadPath . $this->image_escenario->Upload->DbValue;
        $this->image_escenario->TooltipValue = "";
        if ($this->image_escenario->UseColorbox) {
            if (EmptyValue($this->image_escenario->TooltipValue)) {
                $this->image_escenario->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->image_escenario->LinkAttrs["data-rel"] = "escenario_x_image_escenario";
            $this->image_escenario->LinkAttrs->appendClass("ew-lightbox");
        }

        // estado
        $this->estado->LinkCustomAttributes = "";
        $this->estado->HrefValue = "";
        $this->estado->TooltipValue = "";

        // entrar
        $this->entrar->LinkCustomAttributes = "";
        $this->entrar->HrefValue = "";
        $this->entrar->TooltipValue = "";

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
        $this->id_escenario->EditValue = $this->id_escenario->CurrentValue;
        $this->id_escenario->ViewCustomAttributes = "";

        // icon_escenario
        $this->icon_escenario->EditAttrs["class"] = "form-control";
        $this->icon_escenario->EditCustomAttributes = "";

        // fechacreacion_escenario

        // nombre_escenario
        $this->nombre_escenario->EditAttrs["class"] = "form-control";
        $this->nombre_escenario->EditCustomAttributes = "";
        if (!$this->nombre_escenario->Raw) {
            $this->nombre_escenario->CurrentValue = HtmlDecode($this->nombre_escenario->CurrentValue);
        }
        $this->nombre_escenario->EditValue = $this->nombre_escenario->CurrentValue;
        $this->nombre_escenario->PlaceHolder = RemoveHtml($this->nombre_escenario->caption());

        // tipo_evento
        $this->tipo_evento->EditCustomAttributes = "";
        $this->tipo_evento->PlaceHolder = RemoveHtml($this->tipo_evento->caption());

        // incidente
        $this->incidente->EditCustomAttributes = "";
        $this->incidente->PlaceHolder = RemoveHtml($this->incidente->caption());

        // pais_escenario
        $this->pais_escenario->EditAttrs["class"] = "form-control";
        $this->pais_escenario->EditCustomAttributes = "";
        $this->pais_escenario->PlaceHolder = RemoveHtml($this->pais_escenario->caption());

        // zonahora_escenario
        $this->zonahora_escenario->EditAttrs["class"] = "form-control";
        $this->zonahora_escenario->EditCustomAttributes = "";
        if (!$this->zonahora_escenario->Raw) {
            $this->zonahora_escenario->CurrentValue = HtmlDecode($this->zonahora_escenario->CurrentValue);
        }
        $this->zonahora_escenario->EditValue = $this->zonahora_escenario->CurrentValue;
        $this->zonahora_escenario->PlaceHolder = RemoveHtml($this->zonahora_escenario->caption());

        // descripcion_escenario
        $this->descripcion_escenario->EditAttrs["class"] = "form-control";
        $this->descripcion_escenario->EditCustomAttributes = "";
        $this->descripcion_escenario->EditValue = $this->descripcion_escenario->CurrentValue;
        $this->descripcion_escenario->PlaceHolder = RemoveHtml($this->descripcion_escenario->caption());

        // fechaini_simulado
        $this->fechaini_simulado->EditAttrs["class"] = "form-control";
        $this->fechaini_simulado->EditCustomAttributes = "";
        $this->fechaini_simulado->EditValue = FormatDateTime($this->fechaini_simulado->CurrentValue, 109);
        $this->fechaini_simulado->PlaceHolder = RemoveHtml($this->fechaini_simulado->caption());

        // fechafin_simulado
        $this->fechafin_simulado->EditAttrs["class"] = "form-control";
        $this->fechafin_simulado->EditCustomAttributes = "";
        $this->fechafin_simulado->EditValue = FormatDateTime($this->fechafin_simulado->CurrentValue, 109);
        $this->fechafin_simulado->PlaceHolder = RemoveHtml($this->fechafin_simulado->caption());

        // fechaini_real
        $this->fechaini_real->EditAttrs["class"] = "form-control";
        $this->fechaini_real->EditCustomAttributes = "";
        $this->fechaini_real->EditValue = FormatDateTime($this->fechaini_real->CurrentValue, 109);
        $this->fechaini_real->PlaceHolder = RemoveHtml($this->fechaini_real->caption());

        // fechafinal_real
        $this->fechafinal_real->EditAttrs["class"] = "form-control";
        $this->fechafinal_real->EditCustomAttributes = "";
        $this->fechafinal_real->EditValue = FormatDateTime($this->fechafinal_real->CurrentValue, 109);
        $this->fechafinal_real->PlaceHolder = RemoveHtml($this->fechafinal_real->caption());

        // image_escenario
        $this->image_escenario->EditAttrs["class"] = "form-control";
        $this->image_escenario->EditCustomAttributes = "";
        if (!EmptyValue($this->image_escenario->Upload->DbValue)) {
            $this->image_escenario->ImageAlt = $this->image_escenario->alt();
            $this->image_escenario->EditValue = $this->image_escenario->Upload->DbValue;
        } else {
            $this->image_escenario->EditValue = "";
        }
        if (!EmptyValue($this->image_escenario->CurrentValue)) {
            $this->image_escenario->Upload->FileName = $this->image_escenario->CurrentValue;
        }

        // estado
        $this->estado->EditCustomAttributes = "";
        $this->estado->EditValue = $this->estado->options(false);
        $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

        // entrar
        $this->entrar->EditAttrs["class"] = "form-control";
        $this->entrar->EditCustomAttributes = "";
        $this->entrar->EditValue = $this->entrar->CurrentValue;
        $this->entrar->PlaceHolder = RemoveHtml($this->entrar->caption());

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
                    $doc->exportCaption($this->icon_escenario);
                    $doc->exportCaption($this->fechacreacion_escenario);
                    $doc->exportCaption($this->nombre_escenario);
                    $doc->exportCaption($this->tipo_evento);
                    $doc->exportCaption($this->incidente);
                    $doc->exportCaption($this->pais_escenario);
                    $doc->exportCaption($this->zonahora_escenario);
                    $doc->exportCaption($this->descripcion_escenario);
                    $doc->exportCaption($this->fechaini_simulado);
                    $doc->exportCaption($this->fechafin_simulado);
                    $doc->exportCaption($this->fechaini_real);
                    $doc->exportCaption($this->fechafinal_real);
                    $doc->exportCaption($this->image_escenario);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->entrar);
                } else {
                    $doc->exportCaption($this->id_escenario);
                    $doc->exportCaption($this->fechacreacion_escenario);
                    $doc->exportCaption($this->nombre_escenario);
                    $doc->exportCaption($this->tipo_evento);
                    $doc->exportCaption($this->incidente);
                    $doc->exportCaption($this->pais_escenario);
                    $doc->exportCaption($this->fechaini_simulado);
                    $doc->exportCaption($this->fechafin_simulado);
                    $doc->exportCaption($this->fechaini_real);
                    $doc->exportCaption($this->fechafinal_real);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->entrar);
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
                        $doc->exportField($this->icon_escenario);
                        $doc->exportField($this->fechacreacion_escenario);
                        $doc->exportField($this->nombre_escenario);
                        $doc->exportField($this->tipo_evento);
                        $doc->exportField($this->incidente);
                        $doc->exportField($this->pais_escenario);
                        $doc->exportField($this->zonahora_escenario);
                        $doc->exportField($this->descripcion_escenario);
                        $doc->exportField($this->fechaini_simulado);
                        $doc->exportField($this->fechafin_simulado);
                        $doc->exportField($this->fechaini_real);
                        $doc->exportField($this->fechafinal_real);
                        $doc->exportField($this->image_escenario);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->entrar);
                    } else {
                        $doc->exportField($this->id_escenario);
                        $doc->exportField($this->fechacreacion_escenario);
                        $doc->exportField($this->nombre_escenario);
                        $doc->exportField($this->tipo_evento);
                        $doc->exportField($this->incidente);
                        $doc->exportField($this->pais_escenario);
                        $doc->exportField($this->fechaini_simulado);
                        $doc->exportField($this->fechafin_simulado);
                        $doc->exportField($this->fechaini_real);
                        $doc->exportField($this->fechafinal_real);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->entrar);
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
        if ($fldparm == 'image_escenario') {
            $fldName = "image_escenario";
            $fileNameFld = "image_escenario";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->id_escenario->CurrentValue = $ar[0];
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
