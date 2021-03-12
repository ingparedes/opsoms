<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for users
 */
class Users extends DbTable
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
    public $id_users;
    public $fecha;
    public $nombres;
    public $apellidos;
    public $grupo;
    public $subgrupo;
    public $perfil;
    public $_email;
    public $telefono;
    public $pais;
    public $pw;
    public $estado;
    public $excon_subgrupo;
    public $horario;
    public $limite;
    public $img_user;
    public $blocks;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'users';
        $this->TableName = 'users';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`users`";
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
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id_users
        $this->id_users = new DbField('users', 'users', 'x_id_users', 'id_users', '`id_users`', '`id_users`', 3, 11, -1, false, '`id_users`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id_users->IsAutoIncrement = true; // Autoincrement field
        $this->id_users->IsPrimaryKey = true; // Primary key field
        $this->id_users->Sortable = true; // Allow sort
        $this->id_users->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id_users->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id_users->Param, "CustomMsg");
        $this->Fields['id_users'] = &$this->id_users;

        // fecha
        $this->fecha = new DbField('users', 'users', 'x_fecha', 'fecha', '`fecha`', CastDateFieldForLike("`fecha`", 5, "DB"), 135, 19, 5, false, '`fecha`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->fecha->Sortable = true; // Allow sort
        $this->fecha->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateYMD"));
        $this->fecha->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->fecha->Param, "CustomMsg");
        $this->Fields['fecha'] = &$this->fecha;

        // nombres
        $this->nombres = new DbField('users', 'users', 'x_nombres', 'nombres', '`nombres`', '`nombres`', 200, 80, -1, false, '`nombres`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nombres->Sortable = true; // Allow sort
        $this->nombres->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nombres->Param, "CustomMsg");
        $this->Fields['nombres'] = &$this->nombres;

        // apellidos
        $this->apellidos = new DbField('users', 'users', 'x_apellidos', 'apellidos', '`apellidos`', '`apellidos`', 200, 90, -1, false, '`apellidos`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->apellidos->Sortable = true; // Allow sort
        $this->apellidos->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->apellidos->Param, "CustomMsg");
        $this->Fields['apellidos'] = &$this->apellidos;

        // grupo
        $this->grupo = new DbField('users', 'users', 'x_grupo', 'grupo', '`grupo`', '`grupo`', 19, 11, -1, false, '`grupo`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->grupo->Sortable = true; // Allow sort
        $this->grupo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->grupo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->grupo->Lookup = new Lookup('grupo', 'grupo', false, 'id_grupo', ["nombre_grupo","","",""], [], ["x_subgrupo"], [], [], [], [], '', '');
                break;
            case "es":
                $this->grupo->Lookup = new Lookup('grupo', 'grupo', false, 'id_grupo', ["nombre_grupo","","",""], [], ["x_subgrupo"], [], [], [], [], '', '');
                break;
            default:
                $this->grupo->Lookup = new Lookup('grupo', 'grupo', false, 'id_grupo', ["nombre_grupo","","",""], [], ["x_subgrupo"], [], [], [], [], '', '');
                break;
        }
        $this->grupo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->grupo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->grupo->Param, "CustomMsg");
        $this->Fields['grupo'] = &$this->grupo;

        // subgrupo
        $this->subgrupo = new DbField('users', 'users', 'x_subgrupo', 'subgrupo', '`subgrupo`', '`subgrupo`', 19, 11, -1, false, '`subgrupo`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->subgrupo->Sortable = true; // Allow sort
        $this->subgrupo->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->subgrupo->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->subgrupo->Lookup = new Lookup('subgrupo', 'subgrupo', false, 'id_subgrupo', ["nombre_subgrupo","","",""], ["x_grupo"], [], ["id_grupo"], ["x_id_grupo"], [], [], '', '');
                break;
            case "es":
                $this->subgrupo->Lookup = new Lookup('subgrupo', 'subgrupo', false, 'id_subgrupo', ["nombre_subgrupo","","",""], ["x_grupo"], [], ["id_grupo"], ["x_id_grupo"], [], [], '', '');
                break;
            default:
                $this->subgrupo->Lookup = new Lookup('subgrupo', 'subgrupo', false, 'id_subgrupo', ["nombre_subgrupo","","",""], ["x_grupo"], [], ["id_grupo"], ["x_id_grupo"], [], [], '', '');
                break;
        }
        $this->subgrupo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->subgrupo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->subgrupo->Param, "CustomMsg");
        $this->Fields['subgrupo'] = &$this->subgrupo;

        // perfil
        $this->perfil = new DbField('users', 'users', 'x_perfil', 'perfil', '`perfil`', '`perfil`', 3, 20, -1, false, '`perfil`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->perfil->Sortable = true; // Allow sort
        $this->perfil->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->perfil->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->perfil->Lookup = new Lookup('perfil', 'userlevels', false, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->perfil->Lookup = new Lookup('perfil', 'userlevels', false, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->perfil->Lookup = new Lookup('perfil', 'userlevels', false, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->perfil->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->perfil->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->perfil->Param, "CustomMsg");
        $this->Fields['perfil'] = &$this->perfil;

        // email
        $this->_email = new DbField('users', 'users', 'x__email', 'email', '`email`', '`email`', 200, 100, -1, false, '`email`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->_email->Required = true; // Required field
        $this->_email->Sortable = true; // Allow sort
        $this->_email->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->_email->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->_email->Param, "CustomMsg");
        $this->Fields['email'] = &$this->_email;

        // telefono
        $this->telefono = new DbField('users', 'users', 'x_telefono', 'telefono', '`telefono`', '`telefono`', 200, 50, -1, false, '`telefono`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->telefono->Sortable = true; // Allow sort
        $this->telefono->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->telefono->Param, "CustomMsg");
        $this->Fields['telefono'] = &$this->telefono;

        // pais
        $this->pais = new DbField('users', 'users', 'x_pais', 'pais', '`pais`', '`pais`', 200, 4, -1, false, '`pais`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->pais->Sortable = true; // Allow sort
        $this->pais->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->pais->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->pais->Lookup = new Lookup('pais', 'paisgmt', true, 'codpais', ["nompais","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->pais->Lookup = new Lookup('pais', 'paisgmt', true, 'codpais', ["nompais","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->pais->Lookup = new Lookup('pais', 'paisgmt', true, 'codpais', ["nompais","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->pais->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pais->Param, "CustomMsg");
        $this->Fields['pais'] = &$this->pais;

        // pw
        $this->pw = new DbField('users', 'users', 'x_pw', 'pw', '`pw`', '`pw`', 200, 30, -1, false, '`pw`', false, false, false, 'FORMATTED TEXT', 'PASSWORD');
        if (Config("ENCRYPTED_PASSWORD")) {
            $this->pw->Raw = true;
        }
        $this->pw->Required = true; // Required field
        $this->pw->Sortable = true; // Allow sort
        $this->pw->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pw->Param, "CustomMsg");
        $this->Fields['pw'] = &$this->pw;

        // estado
        $this->estado = new DbField('users', 'users', 'x_estado', 'estado', '`estado`', '`estado`', 200, 1, -1, false, '`estado`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->estado->Sortable = true; // Allow sort
        $this->estado->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->estado->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->estado->Lookup = new Lookup('estado', 'users', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            case "es":
                $this->estado->Lookup = new Lookup('estado', 'users', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->estado->Lookup = new Lookup('estado', 'users', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->estado->OptionCount = 2;
        $this->estado->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->estado->Param, "CustomMsg");
        $this->Fields['estado'] = &$this->estado;

        // excon_subgrupo
        $this->excon_subgrupo = new DbField('users', 'users', 'x_excon_subgrupo', 'excon_subgrupo', '`excon_subgrupo`', '`excon_subgrupo`', 3, 11, -1, false, '`excon_subgrupo`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->excon_subgrupo->Sortable = true; // Allow sort
        $this->excon_subgrupo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->excon_subgrupo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->excon_subgrupo->Param, "CustomMsg");
        $this->Fields['excon_subgrupo'] = &$this->excon_subgrupo;

        // horario
        $this->horario = new DbField('users', 'users', 'x_horario', 'horario', '`horario`', CastDateFieldForLike("`horario`", 0, "DB"), 135, 19, 0, false, '`horario`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->horario->Sortable = true; // Allow sort
        $this->horario->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->horario->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->horario->Param, "CustomMsg");
        $this->Fields['horario'] = &$this->horario;

        // limite
        $this->limite = new DbField('users', 'users', 'x_limite', 'limite', '`limite`', CastDateFieldForLike("`limite`", 0, "DB"), 135, 19, 0, false, '`limite`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->limite->Sortable = true; // Allow sort
        $this->limite->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->limite->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->limite->Param, "CustomMsg");
        $this->Fields['limite'] = &$this->limite;

        // img_user
        $this->img_user = new DbField('users', 'users', 'x_img_user', 'img_user', '`img_user`', '`img_user`', 200, 60, -1, true, '`img_user`', false, false, false, 'IMAGE', 'FILE');
        $this->img_user->Sortable = true; // Allow sort
        $this->img_user->ImageResize = true;
        $this->img_user->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->img_user->Param, "CustomMsg");
        $this->Fields['img_user'] = &$this->img_user;

        // blocks
        $this->blocks = new DbField('users', 'users', 'x_blocks', 'blocks', '`blocks`', '`blocks`', 200, 50, -1, false, '`blocks`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->blocks->Sortable = true; // Allow sort
        $this->blocks->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->blocks->Param, "CustomMsg");
        $this->Fields['blocks'] = &$this->blocks;
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

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`users`";
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
        global $Security;
        // Add User ID filter
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $filter = $this->addUserIDFilter($filter);
        }
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
            if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME")) {
                $value = Config("CASE_SENSITIVE_PASSWORD") ? EncryptPassword($value) : EncryptPassword(strtolower($value));
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
            $this->id_users->setDbValue($conn->lastInsertId());
            $rs['id_users'] = $this->id_users->DbValue;
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
            if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME")) {
                if ($value == $this->Fields[$name]->OldValue) { // No need to update hashed password if not changed
                    continue;
                }
                $value = Config("CASE_SENSITIVE_PASSWORD") ? EncryptPassword($value) : EncryptPassword(strtolower($value));
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
            if (array_key_exists('id_users', $rs)) {
                AddFilter($where, QuotedName('id_users', $this->Dbid) . '=' . QuotedValue($rs['id_users'], $this->id_users->DataType, $this->Dbid));
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
        $this->id_users->DbValue = $row['id_users'];
        $this->fecha->DbValue = $row['fecha'];
        $this->nombres->DbValue = $row['nombres'];
        $this->apellidos->DbValue = $row['apellidos'];
        $this->grupo->DbValue = $row['grupo'];
        $this->subgrupo->DbValue = $row['subgrupo'];
        $this->perfil->DbValue = $row['perfil'];
        $this->_email->DbValue = $row['email'];
        $this->telefono->DbValue = $row['telefono'];
        $this->pais->DbValue = $row['pais'];
        $this->pw->DbValue = $row['pw'];
        $this->estado->DbValue = $row['estado'];
        $this->excon_subgrupo->DbValue = $row['excon_subgrupo'];
        $this->horario->DbValue = $row['horario'];
        $this->limite->DbValue = $row['limite'];
        $this->img_user->Upload->DbValue = $row['img_user'];
        $this->blocks->DbValue = $row['blocks'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['img_user']) ? [] : [$row['img_user']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->img_user->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->img_user->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id_users` = @id_users@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id_users->CurrentValue : $this->id_users->OldValue;
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
                $this->id_users->CurrentValue = $keys[0];
            } else {
                $this->id_users->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id_users', $row) ? $row['id_users'] : null;
        } else {
            $val = $this->id_users->OldValue !== null ? $this->id_users->OldValue : $this->id_users->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id_users@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("UsersList");
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
        if ($pageName == "UsersView") {
            return $Language->phrase("View");
        } elseif ($pageName == "UsersEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "UsersAdd") {
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
                return "UsersView";
            case Config("API_ADD_ACTION"):
                return "UsersAdd";
            case Config("API_EDIT_ACTION"):
                return "UsersEdit";
            case Config("API_DELETE_ACTION"):
                return "UsersDelete";
            case Config("API_LIST_ACTION"):
                return "UsersList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "UsersList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("UsersView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("UsersView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "UsersAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "UsersAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("UsersEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("UsersAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("UsersDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id_users:" . JsonEncode($this->id_users->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id_users->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id_users->CurrentValue);
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
            if (($keyValue = Param("id_users") ?? Route("id_users")) !== null) {
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
                $this->id_users->CurrentValue = $key;
            } else {
                $this->id_users->OldValue = $key;
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
        $this->id_users->setDbValue($row['id_users']);
        $this->fecha->setDbValue($row['fecha']);
        $this->nombres->setDbValue($row['nombres']);
        $this->apellidos->setDbValue($row['apellidos']);
        $this->grupo->setDbValue($row['grupo']);
        $this->subgrupo->setDbValue($row['subgrupo']);
        $this->perfil->setDbValue($row['perfil']);
        $this->_email->setDbValue($row['email']);
        $this->telefono->setDbValue($row['telefono']);
        $this->pais->setDbValue($row['pais']);
        $this->pw->setDbValue($row['pw']);
        $this->estado->setDbValue($row['estado']);
        $this->excon_subgrupo->setDbValue($row['excon_subgrupo']);
        $this->horario->setDbValue($row['horario']);
        $this->limite->setDbValue($row['limite']);
        $this->img_user->Upload->DbValue = $row['img_user'];
        $this->blocks->setDbValue($row['blocks']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id_users

        // fecha

        // nombres

        // apellidos

        // grupo

        // subgrupo

        // perfil

        // email

        // telefono

        // pais

        // pw

        // estado

        // excon_subgrupo

        // horario

        // limite

        // img_user

        // blocks

        // id_users
        $this->id_users->ViewValue = $this->id_users->CurrentValue;
        $this->id_users->ViewCustomAttributes = "";

        // fecha
        $this->fecha->ViewValue = $this->fecha->CurrentValue;
        $this->fecha->ViewValue = FormatDateTime($this->fecha->ViewValue, 5);
        $this->fecha->ViewCustomAttributes = "";

        // nombres
        $this->nombres->ViewValue = $this->nombres->CurrentValue;
        $this->nombres->ViewCustomAttributes = "";

        // apellidos
        $this->apellidos->ViewValue = $this->apellidos->CurrentValue;
        $this->apellidos->ViewCustomAttributes = "";

        // grupo
        $curVal = strval($this->grupo->CurrentValue);
        if ($curVal != "") {
            $this->grupo->ViewValue = $this->grupo->lookupCacheOption($curVal);
            if ($this->grupo->ViewValue === null) { // Lookup from database
                $filterWrk = "`id_grupo`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->grupo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->grupo->Lookup->renderViewRow($rswrk[0]);
                    $this->grupo->ViewValue = $this->grupo->displayValue($arwrk);
                } else {
                    $this->grupo->ViewValue = $this->grupo->CurrentValue;
                }
            }
        } else {
            $this->grupo->ViewValue = null;
        }
        $this->grupo->ViewCustomAttributes = "";

        // subgrupo
        $curVal = strval($this->subgrupo->CurrentValue);
        if ($curVal != "") {
            $this->subgrupo->ViewValue = $this->subgrupo->lookupCacheOption($curVal);
            if ($this->subgrupo->ViewValue === null) { // Lookup from database
                $filterWrk = "`id_subgrupo`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->subgrupo->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->subgrupo->Lookup->renderViewRow($rswrk[0]);
                    $this->subgrupo->ViewValue = $this->subgrupo->displayValue($arwrk);
                } else {
                    $this->subgrupo->ViewValue = $this->subgrupo->CurrentValue;
                }
            }
        } else {
            $this->subgrupo->ViewValue = null;
        }
        $this->subgrupo->ViewCustomAttributes = "";

        // perfil
        if ($Security->canAdmin()) { // System admin
            $curVal = strval($this->perfil->CurrentValue);
            if ($curVal != "") {
                $this->perfil->ViewValue = $this->perfil->lookupCacheOption($curVal);
                if ($this->perfil->ViewValue === null) { // Lookup from database
                    $filterWrk = "`userlevelid`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->perfil->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->perfil->Lookup->renderViewRow($rswrk[0]);
                        $this->perfil->ViewValue = $this->perfil->displayValue($arwrk);
                    } else {
                        $this->perfil->ViewValue = $this->perfil->CurrentValue;
                    }
                }
            } else {
                $this->perfil->ViewValue = null;
            }
        } else {
            $this->perfil->ViewValue = $Language->phrase("PasswordMask");
        }
        $this->perfil->ViewCustomAttributes = "";

        // email
        $this->_email->ViewValue = $this->_email->CurrentValue;
        $this->_email->ViewCustomAttributes = "";

        // telefono
        $this->telefono->ViewValue = $this->telefono->CurrentValue;
        $this->telefono->ViewCustomAttributes = "";

        // pais
        $curVal = strval($this->pais->CurrentValue);
        if ($curVal != "") {
            $this->pais->ViewValue = $this->pais->lookupCacheOption($curVal);
            if ($this->pais->ViewValue === null) { // Lookup from database
                $filterWrk = "`codpais`" . SearchString("=", $curVal, DATATYPE_STRING, "");
                $sqlWrk = $this->pais->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->pais->Lookup->renderViewRow($rswrk[0]);
                    $this->pais->ViewValue = $this->pais->displayValue($arwrk);
                } else {
                    $this->pais->ViewValue = $this->pais->CurrentValue;
                }
            }
        } else {
            $this->pais->ViewValue = null;
        }
        $this->pais->ViewCustomAttributes = "";

        // pw
        $this->pw->ViewValue = $Language->phrase("PasswordMask");
        $this->pw->ViewCustomAttributes = "";

        // estado
        if (strval($this->estado->CurrentValue) != "") {
            $this->estado->ViewValue = $this->estado->optionCaption($this->estado->CurrentValue);
        } else {
            $this->estado->ViewValue = null;
        }
        $this->estado->ViewCustomAttributes = "";

        // excon_subgrupo
        $this->excon_subgrupo->ViewValue = $this->excon_subgrupo->CurrentValue;
        $this->excon_subgrupo->ViewValue = FormatNumber($this->excon_subgrupo->ViewValue, 0, -2, -2, -2);
        $this->excon_subgrupo->ViewCustomAttributes = "";

        // horario
        $this->horario->ViewValue = $this->horario->CurrentValue;
        $this->horario->ViewValue = FormatDateTime($this->horario->ViewValue, 0);
        $this->horario->ViewCustomAttributes = "";

        // limite
        $this->limite->ViewValue = $this->limite->CurrentValue;
        $this->limite->ViewValue = FormatDateTime($this->limite->ViewValue, 0);
        $this->limite->ViewCustomAttributes = "";

        // img_user
        if (!EmptyValue($this->img_user->Upload->DbValue)) {
            $this->img_user->ImageWidth = 50;
            $this->img_user->ImageHeight = 50;
            $this->img_user->ImageAlt = $this->img_user->alt();
            $this->img_user->ViewValue = $this->img_user->Upload->DbValue;
        } else {
            $this->img_user->ViewValue = "";
        }
        $this->img_user->ViewCustomAttributes = "";

        // blocks
        $this->blocks->ViewValue = $this->blocks->CurrentValue;
        $this->blocks->ViewCustomAttributes = "";

        // id_users
        $this->id_users->LinkCustomAttributes = "";
        $this->id_users->HrefValue = "";
        $this->id_users->TooltipValue = "";

        // fecha
        $this->fecha->LinkCustomAttributes = "";
        $this->fecha->HrefValue = "";
        $this->fecha->TooltipValue = "";

        // nombres
        $this->nombres->LinkCustomAttributes = "";
        $this->nombres->HrefValue = "";
        $this->nombres->TooltipValue = "";

        // apellidos
        $this->apellidos->LinkCustomAttributes = "";
        $this->apellidos->HrefValue = "";
        $this->apellidos->TooltipValue = "";

        // grupo
        $this->grupo->LinkCustomAttributes = "";
        $this->grupo->HrefValue = "";
        $this->grupo->TooltipValue = "";

        // subgrupo
        $this->subgrupo->LinkCustomAttributes = "";
        $this->subgrupo->HrefValue = "";
        $this->subgrupo->TooltipValue = "";

        // perfil
        $this->perfil->LinkCustomAttributes = "";
        $this->perfil->HrefValue = "";
        $this->perfil->TooltipValue = "";

        // email
        $this->_email->LinkCustomAttributes = "";
        $this->_email->HrefValue = "";
        $this->_email->TooltipValue = "";

        // telefono
        $this->telefono->LinkCustomAttributes = "";
        $this->telefono->HrefValue = "";
        $this->telefono->TooltipValue = "";

        // pais
        $this->pais->LinkCustomAttributes = "";
        $this->pais->HrefValue = "";
        $this->pais->TooltipValue = "";

        // pw
        $this->pw->LinkCustomAttributes = "";
        $this->pw->HrefValue = "";
        $this->pw->TooltipValue = "";

        // estado
        $this->estado->LinkCustomAttributes = "";
        $this->estado->HrefValue = "";
        $this->estado->TooltipValue = "";

        // excon_subgrupo
        $this->excon_subgrupo->LinkCustomAttributes = "";
        $this->excon_subgrupo->HrefValue = "";
        $this->excon_subgrupo->TooltipValue = "";

        // horario
        $this->horario->LinkCustomAttributes = "";
        $this->horario->HrefValue = "";
        $this->horario->TooltipValue = "";

        // limite
        $this->limite->LinkCustomAttributes = "";
        $this->limite->HrefValue = "";
        $this->limite->TooltipValue = "";

        // img_user
        $this->img_user->LinkCustomAttributes = "";
        if (!EmptyValue($this->img_user->Upload->DbValue)) {
            $this->img_user->HrefValue = GetFileUploadUrl($this->img_user, $this->img_user->htmlDecode($this->img_user->Upload->DbValue)); // Add prefix/suffix
            $this->img_user->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->img_user->HrefValue = FullUrl($this->img_user->HrefValue, "href");
            }
        } else {
            $this->img_user->HrefValue = "";
        }
        $this->img_user->ExportHrefValue = $this->img_user->UploadPath . $this->img_user->Upload->DbValue;
        $this->img_user->TooltipValue = "";
        if ($this->img_user->UseColorbox) {
            if (EmptyValue($this->img_user->TooltipValue)) {
                $this->img_user->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->img_user->LinkAttrs["data-rel"] = "users_x_img_user";
            $this->img_user->LinkAttrs->appendClass("ew-lightbox");
        }

        // blocks
        $this->blocks->LinkCustomAttributes = "";
        $this->blocks->HrefValue = "";
        $this->blocks->TooltipValue = "";

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

        // id_users
        $this->id_users->EditAttrs["class"] = "form-control";
        $this->id_users->EditCustomAttributes = "";
        $this->id_users->EditValue = $this->id_users->CurrentValue;
        $this->id_users->ViewCustomAttributes = "";

        // fecha

        // nombres
        $this->nombres->EditAttrs["class"] = "form-control";
        $this->nombres->EditCustomAttributes = "";
        if (!$this->nombres->Raw) {
            $this->nombres->CurrentValue = HtmlDecode($this->nombres->CurrentValue);
        }
        $this->nombres->EditValue = $this->nombres->CurrentValue;
        $this->nombres->PlaceHolder = RemoveHtml($this->nombres->caption());

        // apellidos
        $this->apellidos->EditAttrs["class"] = "form-control";
        $this->apellidos->EditCustomAttributes = "";
        if (!$this->apellidos->Raw) {
            $this->apellidos->CurrentValue = HtmlDecode($this->apellidos->CurrentValue);
        }
        $this->apellidos->EditValue = $this->apellidos->CurrentValue;
        $this->apellidos->PlaceHolder = RemoveHtml($this->apellidos->caption());

        // grupo
        $this->grupo->EditAttrs["class"] = "form-control";
        $this->grupo->EditCustomAttributes = "";
        $this->grupo->PlaceHolder = RemoveHtml($this->grupo->caption());

        // subgrupo
        $this->subgrupo->EditAttrs["class"] = "form-control";
        $this->subgrupo->EditCustomAttributes = "";
        $this->subgrupo->PlaceHolder = RemoveHtml($this->subgrupo->caption());

        // perfil
        $this->perfil->EditAttrs["class"] = "form-control";
        $this->perfil->EditCustomAttributes = "";
        if (!$Security->canAdmin()) { // System admin
            $this->perfil->EditValue = $Language->phrase("PasswordMask");
        } else {
            $this->perfil->PlaceHolder = RemoveHtml($this->perfil->caption());
        }

        // email
        $this->_email->EditAttrs["class"] = "form-control";
        $this->_email->EditCustomAttributes = "";
        if (!$this->_email->Raw) {
            $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
        }
        $this->_email->EditValue = $this->_email->CurrentValue;
        $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

        // telefono
        $this->telefono->EditAttrs["class"] = "form-control";
        $this->telefono->EditCustomAttributes = "";
        if (!$this->telefono->Raw) {
            $this->telefono->CurrentValue = HtmlDecode($this->telefono->CurrentValue);
        }
        $this->telefono->EditValue = $this->telefono->CurrentValue;
        $this->telefono->PlaceHolder = RemoveHtml($this->telefono->caption());

        // pais
        $this->pais->EditAttrs["class"] = "form-control";
        $this->pais->EditCustomAttributes = "";
        $this->pais->PlaceHolder = RemoveHtml($this->pais->caption());

        // pw
        $this->pw->EditAttrs["class"] = "form-control";
        $this->pw->EditCustomAttributes = "";
        $this->pw->EditValue = $Language->phrase("PasswordMask"); // Show as masked password
        $this->pw->PlaceHolder = RemoveHtml($this->pw->caption());

        // estado
        $this->estado->EditAttrs["class"] = "form-control";
        $this->estado->EditCustomAttributes = "";
        $this->estado->EditValue = $this->estado->options(true);
        $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

        // excon_subgrupo
        $this->excon_subgrupo->EditAttrs["class"] = "form-control";
        $this->excon_subgrupo->EditCustomAttributes = "";
        $this->excon_subgrupo->EditValue = $this->excon_subgrupo->CurrentValue;
        $this->excon_subgrupo->PlaceHolder = RemoveHtml($this->excon_subgrupo->caption());

        // horario
        $this->horario->EditAttrs["class"] = "form-control";
        $this->horario->EditCustomAttributes = "";
        $this->horario->EditValue = FormatDateTime($this->horario->CurrentValue, 8);
        $this->horario->PlaceHolder = RemoveHtml($this->horario->caption());

        // limite
        $this->limite->EditAttrs["class"] = "form-control";
        $this->limite->EditCustomAttributes = "";
        $this->limite->EditValue = FormatDateTime($this->limite->CurrentValue, 8);
        $this->limite->PlaceHolder = RemoveHtml($this->limite->caption());

        // img_user
        $this->img_user->EditAttrs["class"] = "form-control";
        $this->img_user->EditCustomAttributes = "";
        if (!EmptyValue($this->img_user->Upload->DbValue)) {
            $this->img_user->ImageWidth = 50;
            $this->img_user->ImageHeight = 50;
            $this->img_user->ImageAlt = $this->img_user->alt();
            $this->img_user->EditValue = $this->img_user->Upload->DbValue;
        } else {
            $this->img_user->EditValue = "";
        }
        if (!EmptyValue($this->img_user->CurrentValue)) {
            $this->img_user->Upload->FileName = $this->img_user->CurrentValue;
        }

        // blocks
        $this->blocks->EditAttrs["class"] = "form-control";
        $this->blocks->EditCustomAttributes = "";
        if (!$this->blocks->Raw) {
            $this->blocks->CurrentValue = HtmlDecode($this->blocks->CurrentValue);
        }
        $this->blocks->EditValue = $this->blocks->CurrentValue;
        $this->blocks->PlaceHolder = RemoveHtml($this->blocks->caption());

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
                    $doc->exportCaption($this->id_users);
                    $doc->exportCaption($this->fecha);
                    $doc->exportCaption($this->nombres);
                    $doc->exportCaption($this->apellidos);
                    $doc->exportCaption($this->grupo);
                    $doc->exportCaption($this->subgrupo);
                    $doc->exportCaption($this->perfil);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->telefono);
                    $doc->exportCaption($this->pais);
                    $doc->exportCaption($this->pw);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->horario);
                    $doc->exportCaption($this->limite);
                    $doc->exportCaption($this->img_user);
                    $doc->exportCaption($this->blocks);
                } else {
                    $doc->exportCaption($this->id_users);
                    $doc->exportCaption($this->fecha);
                    $doc->exportCaption($this->nombres);
                    $doc->exportCaption($this->apellidos);
                    $doc->exportCaption($this->grupo);
                    $doc->exportCaption($this->subgrupo);
                    $doc->exportCaption($this->perfil);
                    $doc->exportCaption($this->_email);
                    $doc->exportCaption($this->telefono);
                    $doc->exportCaption($this->pais);
                    $doc->exportCaption($this->pw);
                    $doc->exportCaption($this->estado);
                    $doc->exportCaption($this->excon_subgrupo);
                    $doc->exportCaption($this->horario);
                    $doc->exportCaption($this->limite);
                    $doc->exportCaption($this->img_user);
                    $doc->exportCaption($this->blocks);
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
                        $doc->exportField($this->id_users);
                        $doc->exportField($this->fecha);
                        $doc->exportField($this->nombres);
                        $doc->exportField($this->apellidos);
                        $doc->exportField($this->grupo);
                        $doc->exportField($this->subgrupo);
                        $doc->exportField($this->perfil);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->telefono);
                        $doc->exportField($this->pais);
                        $doc->exportField($this->pw);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->horario);
                        $doc->exportField($this->limite);
                        $doc->exportField($this->img_user);
                        $doc->exportField($this->blocks);
                    } else {
                        $doc->exportField($this->id_users);
                        $doc->exportField($this->fecha);
                        $doc->exportField($this->nombres);
                        $doc->exportField($this->apellidos);
                        $doc->exportField($this->grupo);
                        $doc->exportField($this->subgrupo);
                        $doc->exportField($this->perfil);
                        $doc->exportField($this->_email);
                        $doc->exportField($this->telefono);
                        $doc->exportField($this->pais);
                        $doc->exportField($this->pw);
                        $doc->exportField($this->estado);
                        $doc->exportField($this->excon_subgrupo);
                        $doc->exportField($this->horario);
                        $doc->exportField($this->limite);
                        $doc->exportField($this->img_user);
                        $doc->exportField($this->blocks);
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

    // User ID filter
    public function getUserIDFilter($userId)
    {
        $userIdFilter = '`id_users` = ' . QuotedValue($userId, DATATYPE_NUMBER, Config("USER_TABLE_DBID"));
        return $userIdFilter;
    }

    // Add User ID filter
    public function addUserIDFilter($filter = "")
    {
        global $Security;
        $filterWrk = "";
        $id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
        if (!$this->userIDAllow($id) && !$Security->isAdmin()) {
            $filterWrk = $Security->userIdList();
            if ($filterWrk != "") {
                $filterWrk = '`id_users` IN (' . $filterWrk . ')';
            }
        }

        // Call User ID Filtering event
        $this->userIdFiltering($filterWrk);
        AddFilter($filter, $filterWrk);
        return $filter;
    }

    // User ID subquery
    public function getUserIDSubquery(&$fld, &$masterfld)
    {
        global $UserTable;
        $wrk = "";
        $sql = "SELECT " . $masterfld->Expression . " FROM `users`";
        $filter = $this->addUserIDFilter("");
        if ($filter != "") {
            $sql .= " WHERE " . $filter;
        }

        // List all values
        if ($rs = Conn($UserTable->Dbid)->executeQuery($sql)->fetchAll(\PDO::FETCH_NUM)) {
            foreach ($rs as $row) {
                if ($wrk != "") {
                    $wrk .= ",";
                }
                $wrk .= QuotedValue($row[0], $masterfld->DataType, Config("USER_TABLE_DBID"));
            }
        }
        if ($wrk != "") {
            $wrk = $fld->Expression . " IN (" . $wrk . ")";
        } else { // No User ID value found
            $wrk = "0=1";
        }
        return $wrk;
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
        if ($fldparm == 'img_user') {
            $fldName = "img_user";
            $fileNameFld = "img_user";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->id_users->CurrentValue = $ar[0];
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
