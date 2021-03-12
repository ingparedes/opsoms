<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class GrupoAdd extends Grupo
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'grupo';

    // Page object name
    public $PageObjName = "GrupoAdd";

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (grupo)
        if (!isset($GLOBALS["grupo"]) || get_class($GLOBALS["grupo"]) == PROJECT_NAMESPACE . "grupo") {
            $GLOBALS["grupo"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'grupo');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("grupo"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "GrupoView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id_grupo'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id_grupo->Visible = false;
        }
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id_escenario->setVisibility();
        $this->id_grupo->Visible = false;
        $this->imgen_grupo->setVisibility();
        $this->nombre_grupo->setVisibility();
        $this->descripcion_grupo->setVisibility();
        $this->color->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->id_escenario);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id_grupo") ?? Route("id_grupo")) !== null) {
                $this->id_grupo->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Set up master/detail parameters
        // NOTE: must be after loadOldRecord to prevent master key values overwritten
        $this->setupMasterParms();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Set up detail parameters
        $this->setupDetailParms();

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("GrupoList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = "GrupoList";
                    if (GetPageName($returnUrl) == "GrupoList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "GrupoView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Rendering event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->imgen_grupo->Upload->Index = $CurrentForm->Index;
        $this->imgen_grupo->Upload->uploadFile();
        $this->imgen_grupo->CurrentValue = $this->imgen_grupo->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id_escenario->CurrentValue = null;
        $this->id_escenario->OldValue = $this->id_escenario->CurrentValue;
        $this->id_grupo->CurrentValue = null;
        $this->id_grupo->OldValue = $this->id_grupo->CurrentValue;
        $this->imgen_grupo->Upload->DbValue = null;
        $this->imgen_grupo->OldValue = $this->imgen_grupo->Upload->DbValue;
        $this->imgen_grupo->CurrentValue = null; // Clear file related field
        $this->nombre_grupo->CurrentValue = null;
        $this->nombre_grupo->OldValue = $this->nombre_grupo->CurrentValue;
        $this->descripcion_grupo->CurrentValue = null;
        $this->descripcion_grupo->OldValue = $this->descripcion_grupo->CurrentValue;
        $this->color->CurrentValue = null;
        $this->color->OldValue = $this->color->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id_escenario' first before field var 'x_id_escenario'
        $val = $CurrentForm->hasValue("id_escenario") ? $CurrentForm->getValue("id_escenario") : $CurrentForm->getValue("x_id_escenario");
        if (!$this->id_escenario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_escenario->Visible = false; // Disable update for API request
            } else {
                $this->id_escenario->setFormValue($val);
            }
        }

        // Check field name 'nombre_grupo' first before field var 'x_nombre_grupo'
        $val = $CurrentForm->hasValue("nombre_grupo") ? $CurrentForm->getValue("nombre_grupo") : $CurrentForm->getValue("x_nombre_grupo");
        if (!$this->nombre_grupo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombre_grupo->Visible = false; // Disable update for API request
            } else {
                $this->nombre_grupo->setFormValue($val);
            }
        }

        // Check field name 'descripcion_grupo' first before field var 'x_descripcion_grupo'
        $val = $CurrentForm->hasValue("descripcion_grupo") ? $CurrentForm->getValue("descripcion_grupo") : $CurrentForm->getValue("x_descripcion_grupo");
        if (!$this->descripcion_grupo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->descripcion_grupo->Visible = false; // Disable update for API request
            } else {
                $this->descripcion_grupo->setFormValue($val);
            }
        }

        // Check field name 'color' first before field var 'x_color'
        $val = $CurrentForm->hasValue("color") ? $CurrentForm->getValue("color") : $CurrentForm->getValue("x_color");
        if (!$this->color->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->color->Visible = false; // Disable update for API request
            } else {
                $this->color->setFormValue($val);
            }
        }

        // Check field name 'id_grupo' first before field var 'x_id_grupo'
        $val = $CurrentForm->hasValue("id_grupo") ? $CurrentForm->getValue("id_grupo") : $CurrentForm->getValue("x_id_grupo");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id_escenario->CurrentValue = $this->id_escenario->FormValue;
        $this->nombre_grupo->CurrentValue = $this->nombre_grupo->FormValue;
        $this->descripcion_grupo->CurrentValue = $this->descripcion_grupo->FormValue;
        $this->color->CurrentValue = $this->color->FormValue;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->id_escenario->setDbValue($row['id_escenario']);
        $this->id_grupo->setDbValue($row['id_grupo']);
        $this->imgen_grupo->Upload->DbValue = $row['imgen_grupo'];
        $this->imgen_grupo->setDbValue($this->imgen_grupo->Upload->DbValue);
        $this->nombre_grupo->setDbValue($row['nombre_grupo']);
        $this->descripcion_grupo->setDbValue($row['descripcion_grupo']);
        $this->color->setDbValue($row['color']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id_escenario'] = $this->id_escenario->CurrentValue;
        $row['id_grupo'] = $this->id_grupo->CurrentValue;
        $row['imgen_grupo'] = $this->imgen_grupo->Upload->DbValue;
        $row['nombre_grupo'] = $this->nombre_grupo->CurrentValue;
        $row['descripcion_grupo'] = $this->descripcion_grupo->CurrentValue;
        $row['color'] = $this->color->CurrentValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id_escenario

        // id_grupo

        // imgen_grupo

        // nombre_grupo

        // descripcion_grupo

        // color
        if ($this->RowType == ROWTYPE_VIEW) {
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
        } elseif ($this->RowType == ROWTYPE_ADD) {
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
                $curVal = trim(strval($this->id_escenario->CurrentValue));
                if ($curVal != "") {
                    $this->id_escenario->ViewValue = $this->id_escenario->lookupCacheOption($curVal);
                } else {
                    $this->id_escenario->ViewValue = $this->id_escenario->Lookup !== null && is_array($this->id_escenario->Lookup->Options) ? $curVal : null;
                }
                if ($this->id_escenario->ViewValue !== null) { // Load from cache
                    $this->id_escenario->EditValue = array_values($this->id_escenario->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`id_users`" . SearchString("=", $this->id_escenario->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $lookupFilter = function() {
                        return "perfil = '2'";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->id_escenario->Lookup->getSql(true, $filterWrk, $lookupFilter, $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->id_escenario->EditValue = $arwrk;
                }
                $this->id_escenario->PlaceHolder = RemoveHtml($this->id_escenario->caption());
            }

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
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->imgen_grupo);
            }

            // nombre_grupo
            $this->nombre_grupo->EditAttrs["class"] = "form-control";
            $this->nombre_grupo->EditCustomAttributes = "";
            if (!$this->nombre_grupo->Raw) {
                $this->nombre_grupo->CurrentValue = HtmlDecode($this->nombre_grupo->CurrentValue);
            }
            $this->nombre_grupo->EditValue = HtmlEncode($this->nombre_grupo->CurrentValue);
            $this->nombre_grupo->PlaceHolder = RemoveHtml($this->nombre_grupo->caption());

            // descripcion_grupo
            $this->descripcion_grupo->EditAttrs["class"] = "form-control";
            $this->descripcion_grupo->EditCustomAttributes = "";
            if (!$this->descripcion_grupo->Raw) {
                $this->descripcion_grupo->CurrentValue = HtmlDecode($this->descripcion_grupo->CurrentValue);
            }
            $this->descripcion_grupo->EditValue = HtmlEncode($this->descripcion_grupo->CurrentValue);
            $this->descripcion_grupo->PlaceHolder = RemoveHtml($this->descripcion_grupo->caption());

            // color
            $this->color->EditAttrs["class"] = "form-control";
            $this->color->EditCustomAttributes = "";
            $this->color->EditValue = $this->color->options(true);
            $this->color->PlaceHolder = RemoveHtml($this->color->caption());

            // Add refer script

            // id_escenario
            $this->id_escenario->LinkCustomAttributes = "";
            $this->id_escenario->HrefValue = "";

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

            // nombre_grupo
            $this->nombre_grupo->LinkCustomAttributes = "";
            $this->nombre_grupo->HrefValue = "";

            // descripcion_grupo
            $this->descripcion_grupo->LinkCustomAttributes = "";
            $this->descripcion_grupo->HrefValue = "";

            // color
            $this->color->LinkCustomAttributes = "";
            $this->color->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->id_escenario->Required) {
            if (!$this->id_escenario->IsDetailKey && EmptyValue($this->id_escenario->FormValue)) {
                $this->id_escenario->addErrorMessage(str_replace("%s", $this->id_escenario->caption(), $this->id_escenario->RequiredErrorMessage));
            }
        }
        if ($this->imgen_grupo->Required) {
            if ($this->imgen_grupo->Upload->FileName == "" && !$this->imgen_grupo->Upload->KeepFile) {
                $this->imgen_grupo->addErrorMessage(str_replace("%s", $this->imgen_grupo->caption(), $this->imgen_grupo->RequiredErrorMessage));
            }
        }
        if ($this->nombre_grupo->Required) {
            if (!$this->nombre_grupo->IsDetailKey && EmptyValue($this->nombre_grupo->FormValue)) {
                $this->nombre_grupo->addErrorMessage(str_replace("%s", $this->nombre_grupo->caption(), $this->nombre_grupo->RequiredErrorMessage));
            }
        }
        if ($this->descripcion_grupo->Required) {
            if (!$this->descripcion_grupo->IsDetailKey && EmptyValue($this->descripcion_grupo->FormValue)) {
                $this->descripcion_grupo->addErrorMessage(str_replace("%s", $this->descripcion_grupo->caption(), $this->descripcion_grupo->RequiredErrorMessage));
            }
        }
        if ($this->color->Required) {
            if (!$this->color->IsDetailKey && EmptyValue($this->color->FormValue)) {
                $this->color->addErrorMessage(str_replace("%s", $this->color->caption(), $this->color->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("SubgrupoGrid");
        if (in_array("subgrupo", $detailTblVar) && $detailPage->DetailAdd) {
            $detailPage->validateGridForm();
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Check referential integrity for master table 'grupo'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_escenario();
        if (strval($this->id_escenario->CurrentValue) != "") {
            $masterFilter = str_replace("@id_escenario@", AdjustSql($this->id_escenario->CurrentValue, "DB"), $masterFilter);
        } else {
            $validMasterRecord = false;
        }
        if ($validMasterRecord) {
            $rsmaster = Container("escenario")->loadRs($masterFilter)->fetch();
            $validMasterRecord = $rsmaster !== false;
        }
        if (!$validMasterRecord) {
            $relatedRecordMsg = str_replace("%t", "escenario", $Language->phrase("RelatedRecordRequired"));
            $this->setFailureMessage($relatedRecordMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Begin transaction
        if ($this->getCurrentDetailTable() != "") {
            $conn->beginTransaction();
        }

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // id_escenario
        $this->id_escenario->setDbValueDef($rsnew, $this->id_escenario->CurrentValue, null, false);

        // imgen_grupo
        if ($this->imgen_grupo->Visible && !$this->imgen_grupo->Upload->KeepFile) {
            $this->imgen_grupo->Upload->DbValue = ""; // No need to delete old file
            if ($this->imgen_grupo->Upload->FileName == "") {
                $rsnew['imgen_grupo'] = null;
            } else {
                $rsnew['imgen_grupo'] = $this->imgen_grupo->Upload->FileName;
            }
            $this->imgen_grupo->ImageWidth = 50; // Resize width
            $this->imgen_grupo->ImageHeight = 50; // Resize height
        }

        // nombre_grupo
        $this->nombre_grupo->setDbValueDef($rsnew, $this->nombre_grupo->CurrentValue, null, false);

        // descripcion_grupo
        $this->descripcion_grupo->setDbValueDef($rsnew, $this->descripcion_grupo->CurrentValue, null, false);

        // color
        $this->color->setDbValueDef($rsnew, $this->color->CurrentValue, null, false);
        if ($this->imgen_grupo->Visible && !$this->imgen_grupo->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->imgen_grupo->Upload->DbValue) ? [] : [$this->imgen_grupo->htmlDecode($this->imgen_grupo->Upload->DbValue)];
            if (!EmptyValue($this->imgen_grupo->Upload->FileName)) {
                $newFiles = [$this->imgen_grupo->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->imgen_grupo, $this->imgen_grupo->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->imgen_grupo->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->imgen_grupo->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->imgen_grupo->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->imgen_grupo->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->imgen_grupo->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->imgen_grupo->setDbValueDef($rsnew, $this->imgen_grupo->Upload->FileName, null, false);
            }
        }

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        $addRow = false;
        if ($insertRow) {
            try {
                $addRow = $this->insert($rsnew);
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
            }
            if ($addRow) {
                if ($this->imgen_grupo->Visible && !$this->imgen_grupo->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->imgen_grupo->Upload->DbValue) ? [] : [$this->imgen_grupo->htmlDecode($this->imgen_grupo->Upload->DbValue)];
                    if (!EmptyValue($this->imgen_grupo->Upload->FileName)) {
                        $newFiles = [$this->imgen_grupo->Upload->FileName];
                        $newFiles2 = [$this->imgen_grupo->htmlDecode($rsnew['imgen_grupo'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->imgen_grupo, $this->imgen_grupo->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->imgen_grupo->Upload->ResizeAndSaveToFile($this->imgen_grupo->ImageWidth, $this->imgen_grupo->ImageHeight, 100, $newFiles[$i], true, $i)) {
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->imgen_grupo->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }

        // Add detail records
        if ($addRow) {
            $detailTblVar = explode(",", $this->getCurrentDetailTable());
            $detailPage = Container("SubgrupoGrid");
            if (in_array("subgrupo", $detailTblVar) && $detailPage->DetailAdd) {
                $detailPage->id_grupo->setSessionValue($this->id_grupo->CurrentValue); // Set master key
                $Security->loadCurrentUserLevel($this->ProjectID . "subgrupo"); // Load user level of detail table
                $addRow = $detailPage->gridInsert();
                $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                if (!$addRow) {
                $detailPage->id_grupo->setSessionValue(""); // Clear master key if insert failed
                }
            }
        }

        // Commit/Rollback transaction
        if ($this->getCurrentDetailTable() != "") {
            if ($addRow) {
                $conn->commit(); // Commit transaction
            } else {
                $conn->rollback(); // Rollback transaction
            }
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
            // imgen_grupo
            CleanUploadTempPath($this->imgen_grupo, $this->imgen_grupo->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "escenario") {
                $validMaster = true;
                $masterTbl = Container("escenario");
                if (($parm = Get("fk_id_escenario", Get("id_escenario"))) !== null) {
                    $masterTbl->id_escenario->setQueryStringValue($parm);
                    $this->id_escenario->setQueryStringValue($masterTbl->id_escenario->QueryStringValue);
                    $this->id_escenario->setSessionValue($this->id_escenario->QueryStringValue);
                    if (!is_numeric($masterTbl->id_escenario->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "escenario") {
                $validMaster = true;
                $masterTbl = Container("escenario");
                if (($parm = Post("fk_id_escenario", Post("id_escenario"))) !== null) {
                    $masterTbl->id_escenario->setFormValue($parm);
                    $this->id_escenario->setFormValue($masterTbl->id_escenario->FormValue);
                    $this->id_escenario->setSessionValue($this->id_escenario->FormValue);
                    if (!is_numeric($masterTbl->id_escenario->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "escenario") {
                if ($this->id_escenario->CurrentValue == "") {
                    $this->id_escenario->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("subgrupo", $detailTblVar)) {
                $detailPageObj = Container("SubgrupoGrid");
                if ($detailPageObj->DetailAdd) {
                    if ($this->CopyRecord) {
                        $detailPageObj->CurrentMode = "copy";
                    } else {
                        $detailPageObj->CurrentMode = "add";
                    }
                    $detailPageObj->CurrentAction = "gridadd";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->id_grupo->IsDetailKey = true;
                    $detailPageObj->id_grupo->CurrentValue = $this->id_grupo->CurrentValue;
                    $detailPageObj->id_grupo->setSessionValue($detailPageObj->id_grupo->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("GrupoList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_id_escenario":
                    $lookupFilter = function () {
                        return "perfil = '2'";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_color":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
