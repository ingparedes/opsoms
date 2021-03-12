<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class EscenarioEdit extends Escenario
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'escenario';

    // Page object name
    public $PageObjName = "EscenarioEdit";

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

        // Table object (escenario)
        if (!isset($GLOBALS["escenario"]) || get_class($GLOBALS["escenario"]) == PROJECT_NAMESPACE . "escenario") {
            $GLOBALS["escenario"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'escenario');
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
                $doc = new $class(Container("escenario"));
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
                    if ($pageName == "EscenarioView") {
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
            $key .= @$ar['id_escenario'];
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
            $this->id_escenario->Visible = false;
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
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->icon_escenario->setVisibility();
        $this->fechacreacion_escenario->setVisibility();
        $this->nombre_escenario->setVisibility();
        $this->tipo_evento->setVisibility();
        $this->incidente->setVisibility();
        $this->pais_escenario->setVisibility();
        $this->zonahora_escenario->Visible = false;
        $this->descripcion_escenario->setVisibility();
        $this->fechaini_simulado->setVisibility();
        $this->fechafin_simulado->setVisibility();
        $this->fechaini_real->setVisibility();
        $this->fechafinal_real->setVisibility();
        $this->image_escenario->setVisibility();
        $this->estado->setVisibility();
        $this->entrar->Visible = false;
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
        $this->setupLookupOptions($this->tipo_evento);
        $this->setupLookupOptions($this->incidente);
        $this->setupLookupOptions($this->pais_escenario);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id_escenario") ?? Key(0) ?? Route(2)) !== null) {
                $this->id_escenario->setQueryStringValue($keyValue);
                $this->id_escenario->setOldValue($this->id_escenario->QueryStringValue);
            } elseif (Post("id_escenario") !== null) {
                $this->id_escenario->setFormValue(Post("id_escenario"));
                $this->id_escenario->setOldValue($this->id_escenario->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id_escenario") ?? Route("id_escenario")) !== null) {
                    $this->id_escenario->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id_escenario->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values

            // Set up detail parameters
            $this->setupDetailParms();
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("EscenarioList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                $returnUrl = "EscenarioList";
                if (GetPageName($returnUrl) == "EscenarioList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed

                    // Set up detail parameters
                    $this->setupDetailParms();
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
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
        $this->image_escenario->Upload->Index = $CurrentForm->Index;
        $this->image_escenario->Upload->uploadFile();
        $this->image_escenario->CurrentValue = $this->image_escenario->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id_escenario' first before field var 'x_id_escenario'
        $val = $CurrentForm->hasValue("id_escenario") ? $CurrentForm->getValue("id_escenario") : $CurrentForm->getValue("x_id_escenario");
        if (!$this->id_escenario->IsDetailKey) {
            $this->id_escenario->setFormValue($val);
        }

        // Check field name 'icon_escenario' first before field var 'x_icon_escenario'
        $val = $CurrentForm->hasValue("icon_escenario") ? $CurrentForm->getValue("icon_escenario") : $CurrentForm->getValue("x_icon_escenario");
        if (!$this->icon_escenario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->icon_escenario->Visible = false; // Disable update for API request
            } else {
                $this->icon_escenario->setFormValue($val);
            }
        }

        // Check field name 'fechacreacion_escenario' first before field var 'x_fechacreacion_escenario'
        $val = $CurrentForm->hasValue("fechacreacion_escenario") ? $CurrentForm->getValue("fechacreacion_escenario") : $CurrentForm->getValue("x_fechacreacion_escenario");
        if (!$this->fechacreacion_escenario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechacreacion_escenario->Visible = false; // Disable update for API request
            } else {
                $this->fechacreacion_escenario->setFormValue($val);
            }
            $this->fechacreacion_escenario->CurrentValue = UnFormatDateTime($this->fechacreacion_escenario->CurrentValue, 9);
        }

        // Check field name 'nombre_escenario' first before field var 'x_nombre_escenario'
        $val = $CurrentForm->hasValue("nombre_escenario") ? $CurrentForm->getValue("nombre_escenario") : $CurrentForm->getValue("x_nombre_escenario");
        if (!$this->nombre_escenario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombre_escenario->Visible = false; // Disable update for API request
            } else {
                $this->nombre_escenario->setFormValue($val);
            }
        }

        // Check field name 'tipo_evento' first before field var 'x_tipo_evento'
        $val = $CurrentForm->hasValue("tipo_evento") ? $CurrentForm->getValue("tipo_evento") : $CurrentForm->getValue("x_tipo_evento");
        if (!$this->tipo_evento->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tipo_evento->Visible = false; // Disable update for API request
            } else {
                $this->tipo_evento->setFormValue($val);
            }
        }

        // Check field name 'incidente' first before field var 'x_incidente'
        $val = $CurrentForm->hasValue("incidente") ? $CurrentForm->getValue("incidente") : $CurrentForm->getValue("x_incidente");
        if (!$this->incidente->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->incidente->Visible = false; // Disable update for API request
            } else {
                $this->incidente->setFormValue($val);
            }
        }

        // Check field name 'pais_escenario' first before field var 'x_pais_escenario'
        $val = $CurrentForm->hasValue("pais_escenario") ? $CurrentForm->getValue("pais_escenario") : $CurrentForm->getValue("x_pais_escenario");
        if (!$this->pais_escenario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pais_escenario->Visible = false; // Disable update for API request
            } else {
                $this->pais_escenario->setFormValue($val);
            }
        }

        // Check field name 'descripcion_escenario' first before field var 'x_descripcion_escenario'
        $val = $CurrentForm->hasValue("descripcion_escenario") ? $CurrentForm->getValue("descripcion_escenario") : $CurrentForm->getValue("x_descripcion_escenario");
        if (!$this->descripcion_escenario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->descripcion_escenario->Visible = false; // Disable update for API request
            } else {
                $this->descripcion_escenario->setFormValue($val);
            }
        }

        // Check field name 'fechaini_simulado' first before field var 'x_fechaini_simulado'
        $val = $CurrentForm->hasValue("fechaini_simulado") ? $CurrentForm->getValue("fechaini_simulado") : $CurrentForm->getValue("x_fechaini_simulado");
        if (!$this->fechaini_simulado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechaini_simulado->Visible = false; // Disable update for API request
            } else {
                $this->fechaini_simulado->setFormValue($val);
            }
            $this->fechaini_simulado->CurrentValue = UnFormatDateTime($this->fechaini_simulado->CurrentValue, 109);
        }

        // Check field name 'fechafin_simulado' first before field var 'x_fechafin_simulado'
        $val = $CurrentForm->hasValue("fechafin_simulado") ? $CurrentForm->getValue("fechafin_simulado") : $CurrentForm->getValue("x_fechafin_simulado");
        if (!$this->fechafin_simulado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechafin_simulado->Visible = false; // Disable update for API request
            } else {
                $this->fechafin_simulado->setFormValue($val);
            }
            $this->fechafin_simulado->CurrentValue = UnFormatDateTime($this->fechafin_simulado->CurrentValue, 109);
        }

        // Check field name 'fechaini_real' first before field var 'x_fechaini_real'
        $val = $CurrentForm->hasValue("fechaini_real") ? $CurrentForm->getValue("fechaini_real") : $CurrentForm->getValue("x_fechaini_real");
        if (!$this->fechaini_real->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechaini_real->Visible = false; // Disable update for API request
            } else {
                $this->fechaini_real->setFormValue($val);
            }
            $this->fechaini_real->CurrentValue = UnFormatDateTime($this->fechaini_real->CurrentValue, 109);
        }

        // Check field name 'fechafinal_real' first before field var 'x_fechafinal_real'
        $val = $CurrentForm->hasValue("fechafinal_real") ? $CurrentForm->getValue("fechafinal_real") : $CurrentForm->getValue("x_fechafinal_real");
        if (!$this->fechafinal_real->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechafinal_real->Visible = false; // Disable update for API request
            } else {
                $this->fechafinal_real->setFormValue($val);
            }
            $this->fechafinal_real->CurrentValue = UnFormatDateTime($this->fechafinal_real->CurrentValue, 109);
        }

        // Check field name 'estado' first before field var 'x_estado'
        $val = $CurrentForm->hasValue("estado") ? $CurrentForm->getValue("estado") : $CurrentForm->getValue("x_estado");
        if (!$this->estado->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->estado->Visible = false; // Disable update for API request
            } else {
                $this->estado->setFormValue($val);
            }
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id_escenario->CurrentValue = $this->id_escenario->FormValue;
        $this->icon_escenario->CurrentValue = $this->icon_escenario->FormValue;
        $this->fechacreacion_escenario->CurrentValue = $this->fechacreacion_escenario->FormValue;
        $this->fechacreacion_escenario->CurrentValue = UnFormatDateTime($this->fechacreacion_escenario->CurrentValue, 9);
        $this->nombre_escenario->CurrentValue = $this->nombre_escenario->FormValue;
        $this->tipo_evento->CurrentValue = $this->tipo_evento->FormValue;
        $this->incidente->CurrentValue = $this->incidente->FormValue;
        $this->pais_escenario->CurrentValue = $this->pais_escenario->FormValue;
        $this->descripcion_escenario->CurrentValue = $this->descripcion_escenario->FormValue;
        $this->fechaini_simulado->CurrentValue = $this->fechaini_simulado->FormValue;
        $this->fechaini_simulado->CurrentValue = UnFormatDateTime($this->fechaini_simulado->CurrentValue, 109);
        $this->fechafin_simulado->CurrentValue = $this->fechafin_simulado->FormValue;
        $this->fechafin_simulado->CurrentValue = UnFormatDateTime($this->fechafin_simulado->CurrentValue, 109);
        $this->fechaini_real->CurrentValue = $this->fechaini_real->FormValue;
        $this->fechaini_real->CurrentValue = UnFormatDateTime($this->fechaini_real->CurrentValue, 109);
        $this->fechafinal_real->CurrentValue = $this->fechafinal_real->FormValue;
        $this->fechafinal_real->CurrentValue = UnFormatDateTime($this->fechafinal_real->CurrentValue, 109);
        $this->estado->CurrentValue = $this->estado->FormValue;
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
        $this->image_escenario->setDbValue($this->image_escenario->Upload->DbValue);
        $this->estado->setDbValue($row['estado']);
        $this->entrar->setDbValue($row['entrar']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id_escenario'] = null;
        $row['icon_escenario'] = null;
        $row['fechacreacion_escenario'] = null;
        $row['nombre_escenario'] = null;
        $row['tipo_evento'] = null;
        $row['incidente'] = null;
        $row['pais_escenario'] = null;
        $row['zonahora_escenario'] = null;
        $row['descripcion_escenario'] = null;
        $row['fechaini_simulado'] = null;
        $row['fechafin_simulado'] = null;
        $row['fechaini_real'] = null;
        $row['fechafinal_real'] = null;
        $row['image_escenario'] = null;
        $row['estado'] = null;
        $row['entrar'] = null;
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

        // icon_escenario

        // fechacreacion_escenario

        // nombre_escenario

        // tipo_evento

        // incidente

        // pais_escenario

        // zonahora_escenario

        // descripcion_escenario

        // fechaini_simulado

        // fechafin_simulado

        // fechaini_real

        // fechafinal_real

        // image_escenario

        // estado

        // entrar
        if ($this->RowType == ROWTYPE_VIEW) {
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
        } elseif ($this->RowType == ROWTYPE_EDIT) {
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
            $this->nombre_escenario->EditValue = HtmlEncode($this->nombre_escenario->CurrentValue);
            $this->nombre_escenario->PlaceHolder = RemoveHtml($this->nombre_escenario->caption());

            // tipo_evento
            $this->tipo_evento->EditCustomAttributes = "";
            $curVal = trim(strval($this->tipo_evento->CurrentValue));
            if ($curVal != "") {
                $this->tipo_evento->ViewValue = $this->tipo_evento->lookupCacheOption($curVal);
            } else {
                $this->tipo_evento->ViewValue = $this->tipo_evento->Lookup !== null && is_array($this->tipo_evento->Lookup->Options) ? $curVal : null;
            }
            if ($this->tipo_evento->ViewValue !== null) { // Load from cache
                $this->tipo_evento->EditValue = array_values($this->tipo_evento->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_tipo`" . SearchString("=", $this->tipo_evento->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->tipo_evento->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->tipo_evento->EditValue = $arwrk;
            }
            $this->tipo_evento->PlaceHolder = RemoveHtml($this->tipo_evento->caption());

            // incidente
            $this->incidente->EditCustomAttributes = "";
            $curVal = trim(strval($this->incidente->CurrentValue));
            if ($curVal != "") {
                $this->incidente->ViewValue = $this->incidente->lookupCacheOption($curVal);
            } else {
                $this->incidente->ViewValue = $this->incidente->Lookup !== null && is_array($this->incidente->Lookup->Options) ? $curVal : null;
            }
            if ($this->incidente->ViewValue !== null) { // Load from cache
                $this->incidente->EditValue = array_values($this->incidente->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_incidente`" . SearchString("=", $this->incidente->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->incidente->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->incidente->EditValue = $arwrk;
            }
            $this->incidente->PlaceHolder = RemoveHtml($this->incidente->caption());

            // pais_escenario
            $this->pais_escenario->EditAttrs["class"] = "form-control";
            $this->pais_escenario->EditCustomAttributes = "";
            $curVal = trim(strval($this->pais_escenario->CurrentValue));
            if ($curVal != "") {
                $this->pais_escenario->ViewValue = $this->pais_escenario->lookupCacheOption($curVal);
            } else {
                $this->pais_escenario->ViewValue = $this->pais_escenario->Lookup !== null && is_array($this->pais_escenario->Lookup->Options) ? $curVal : null;
            }
            if ($this->pais_escenario->ViewValue !== null) { // Load from cache
                $this->pais_escenario->EditValue = array_values($this->pais_escenario->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_zone`" . SearchString("=", $this->pais_escenario->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->pais_escenario->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->pais_escenario->EditValue = $arwrk;
            }
            $this->pais_escenario->PlaceHolder = RemoveHtml($this->pais_escenario->caption());

            // descripcion_escenario
            $this->descripcion_escenario->EditAttrs["class"] = "form-control";
            $this->descripcion_escenario->EditCustomAttributes = "";
            $this->descripcion_escenario->EditValue = HtmlEncode($this->descripcion_escenario->CurrentValue);
            $this->descripcion_escenario->PlaceHolder = RemoveHtml($this->descripcion_escenario->caption());

            // fechaini_simulado
            $this->fechaini_simulado->EditAttrs["class"] = "form-control";
            $this->fechaini_simulado->EditCustomAttributes = "";
            $this->fechaini_simulado->EditValue = HtmlEncode(FormatDateTime($this->fechaini_simulado->CurrentValue, 109));
            $this->fechaini_simulado->PlaceHolder = RemoveHtml($this->fechaini_simulado->caption());

            // fechafin_simulado
            $this->fechafin_simulado->EditAttrs["class"] = "form-control";
            $this->fechafin_simulado->EditCustomAttributes = "";
            $this->fechafin_simulado->EditValue = HtmlEncode(FormatDateTime($this->fechafin_simulado->CurrentValue, 109));
            $this->fechafin_simulado->PlaceHolder = RemoveHtml($this->fechafin_simulado->caption());

            // fechaini_real
            $this->fechaini_real->EditAttrs["class"] = "form-control";
            $this->fechaini_real->EditCustomAttributes = "";
            $this->fechaini_real->EditValue = HtmlEncode(FormatDateTime($this->fechaini_real->CurrentValue, 109));
            $this->fechaini_real->PlaceHolder = RemoveHtml($this->fechaini_real->caption());

            // fechafinal_real
            $this->fechafinal_real->EditAttrs["class"] = "form-control";
            $this->fechafinal_real->EditCustomAttributes = "";
            $this->fechafinal_real->EditValue = HtmlEncode(FormatDateTime($this->fechafinal_real->CurrentValue, 109));
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
            if ($this->isShow()) {
                RenderUploadField($this->image_escenario);
            }

            // estado
            $this->estado->EditCustomAttributes = "";
            $this->estado->EditValue = $this->estado->options(false);
            $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

            // Edit refer script

            // id_escenario
            $this->id_escenario->LinkCustomAttributes = "";
            $this->id_escenario->HrefValue = "";

            // icon_escenario
            $this->icon_escenario->LinkCustomAttributes = "";
            $this->icon_escenario->HrefValue = "";

            // fechacreacion_escenario
            $this->fechacreacion_escenario->LinkCustomAttributes = "";
            $this->fechacreacion_escenario->HrefValue = "";

            // nombre_escenario
            $this->nombre_escenario->LinkCustomAttributes = "";
            $this->nombre_escenario->HrefValue = "";

            // tipo_evento
            $this->tipo_evento->LinkCustomAttributes = "";
            $this->tipo_evento->HrefValue = "";

            // incidente
            $this->incidente->LinkCustomAttributes = "";
            $this->incidente->HrefValue = "";

            // pais_escenario
            $this->pais_escenario->LinkCustomAttributes = "";
            $this->pais_escenario->HrefValue = "";

            // descripcion_escenario
            $this->descripcion_escenario->LinkCustomAttributes = "";
            $this->descripcion_escenario->HrefValue = "";

            // fechaini_simulado
            $this->fechaini_simulado->LinkCustomAttributes = "";
            $this->fechaini_simulado->HrefValue = "";

            // fechafin_simulado
            $this->fechafin_simulado->LinkCustomAttributes = "";
            $this->fechafin_simulado->HrefValue = "";

            // fechaini_real
            $this->fechaini_real->LinkCustomAttributes = "";
            $this->fechaini_real->HrefValue = "";

            // fechafinal_real
            $this->fechafinal_real->LinkCustomAttributes = "";
            $this->fechafinal_real->HrefValue = "";

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

            // estado
            $this->estado->LinkCustomAttributes = "";
            $this->estado->HrefValue = "";
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
        if ($this->icon_escenario->Required) {
            if (!$this->icon_escenario->IsDetailKey && EmptyValue($this->icon_escenario->FormValue)) {
                $this->icon_escenario->addErrorMessage(str_replace("%s", $this->icon_escenario->caption(), $this->icon_escenario->RequiredErrorMessage));
            }
        }
        if ($this->fechacreacion_escenario->Required) {
            if (!$this->fechacreacion_escenario->IsDetailKey && EmptyValue($this->fechacreacion_escenario->FormValue)) {
                $this->fechacreacion_escenario->addErrorMessage(str_replace("%s", $this->fechacreacion_escenario->caption(), $this->fechacreacion_escenario->RequiredErrorMessage));
            }
        }
        if ($this->nombre_escenario->Required) {
            if (!$this->nombre_escenario->IsDetailKey && EmptyValue($this->nombre_escenario->FormValue)) {
                $this->nombre_escenario->addErrorMessage(str_replace("%s", $this->nombre_escenario->caption(), $this->nombre_escenario->RequiredErrorMessage));
            }
        }
        if ($this->tipo_evento->Required) {
            if ($this->tipo_evento->FormValue == "") {
                $this->tipo_evento->addErrorMessage(str_replace("%s", $this->tipo_evento->caption(), $this->tipo_evento->RequiredErrorMessage));
            }
        }
        if ($this->incidente->Required) {
            if ($this->incidente->FormValue == "") {
                $this->incidente->addErrorMessage(str_replace("%s", $this->incidente->caption(), $this->incidente->RequiredErrorMessage));
            }
        }
        if ($this->pais_escenario->Required) {
            if (!$this->pais_escenario->IsDetailKey && EmptyValue($this->pais_escenario->FormValue)) {
                $this->pais_escenario->addErrorMessage(str_replace("%s", $this->pais_escenario->caption(), $this->pais_escenario->RequiredErrorMessage));
            }
        }
        if ($this->descripcion_escenario->Required) {
            if (!$this->descripcion_escenario->IsDetailKey && EmptyValue($this->descripcion_escenario->FormValue)) {
                $this->descripcion_escenario->addErrorMessage(str_replace("%s", $this->descripcion_escenario->caption(), $this->descripcion_escenario->RequiredErrorMessage));
            }
        }
        if ($this->fechaini_simulado->Required) {
            if (!$this->fechaini_simulado->IsDetailKey && EmptyValue($this->fechaini_simulado->FormValue)) {
                $this->fechaini_simulado->addErrorMessage(str_replace("%s", $this->fechaini_simulado->caption(), $this->fechaini_simulado->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->fechaini_simulado->FormValue)) {
            $this->fechaini_simulado->addErrorMessage($this->fechaini_simulado->getErrorMessage(false));
        }
        if ($this->fechafin_simulado->Required) {
            if (!$this->fechafin_simulado->IsDetailKey && EmptyValue($this->fechafin_simulado->FormValue)) {
                $this->fechafin_simulado->addErrorMessage(str_replace("%s", $this->fechafin_simulado->caption(), $this->fechafin_simulado->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->fechafin_simulado->FormValue)) {
            $this->fechafin_simulado->addErrorMessage($this->fechafin_simulado->getErrorMessage(false));
        }
        if ($this->fechaini_real->Required) {
            if (!$this->fechaini_real->IsDetailKey && EmptyValue($this->fechaini_real->FormValue)) {
                $this->fechaini_real->addErrorMessage(str_replace("%s", $this->fechaini_real->caption(), $this->fechaini_real->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->fechaini_real->FormValue)) {
            $this->fechaini_real->addErrorMessage($this->fechaini_real->getErrorMessage(false));
        }
        if ($this->fechafinal_real->Required) {
            if (!$this->fechafinal_real->IsDetailKey && EmptyValue($this->fechafinal_real->FormValue)) {
                $this->fechafinal_real->addErrorMessage(str_replace("%s", $this->fechafinal_real->caption(), $this->fechafinal_real->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->fechafinal_real->FormValue)) {
            $this->fechafinal_real->addErrorMessage($this->fechafinal_real->getErrorMessage(false));
        }
        if ($this->image_escenario->Required) {
            if ($this->image_escenario->Upload->FileName == "" && !$this->image_escenario->Upload->KeepFile) {
                $this->image_escenario->addErrorMessage(str_replace("%s", $this->image_escenario->caption(), $this->image_escenario->RequiredErrorMessage));
            }
        }
        if ($this->estado->Required) {
            if ($this->estado->FormValue == "") {
                $this->estado->addErrorMessage(str_replace("%s", $this->estado->caption(), $this->estado->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("GrupoGrid");
        if (in_array("grupo", $detailTblVar) && $detailPage->DetailEdit) {
            $detailPage->validateGridForm();
        }
        $detailPage = Container("TareasGrid");
        if (in_array("tareas", $detailTblVar) && $detailPage->DetailEdit) {
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Begin transaction
            if ($this->getCurrentDetailTable() != "") {
                $conn->beginTransaction();
            }

            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // icon_escenario
            $this->icon_escenario->setDbValueDef($rsnew, $this->icon_escenario->CurrentValue, null, $this->icon_escenario->ReadOnly);

            // fechacreacion_escenario
            $this->fechacreacion_escenario->CurrentValue = CurrentDateTime();
            $this->fechacreacion_escenario->setDbValueDef($rsnew, $this->fechacreacion_escenario->CurrentValue, null);

            // nombre_escenario
            $this->nombre_escenario->setDbValueDef($rsnew, $this->nombre_escenario->CurrentValue, null, $this->nombre_escenario->ReadOnly);

            // tipo_evento
            $this->tipo_evento->setDbValueDef($rsnew, $this->tipo_evento->CurrentValue, null, $this->tipo_evento->ReadOnly);

            // incidente
            $this->incidente->setDbValueDef($rsnew, $this->incidente->CurrentValue, null, $this->incidente->ReadOnly);

            // pais_escenario
            $this->pais_escenario->setDbValueDef($rsnew, $this->pais_escenario->CurrentValue, null, $this->pais_escenario->ReadOnly);

            // descripcion_escenario
            $this->descripcion_escenario->setDbValueDef($rsnew, $this->descripcion_escenario->CurrentValue, null, $this->descripcion_escenario->ReadOnly);

            // fechaini_simulado
            $this->fechaini_simulado->setDbValueDef($rsnew, UnFormatDateTime($this->fechaini_simulado->CurrentValue, 109), null, $this->fechaini_simulado->ReadOnly);

            // fechafin_simulado
            $this->fechafin_simulado->setDbValueDef($rsnew, UnFormatDateTime($this->fechafin_simulado->CurrentValue, 109), null, $this->fechafin_simulado->ReadOnly);

            // fechaini_real
            $this->fechaini_real->setDbValueDef($rsnew, UnFormatDateTime($this->fechaini_real->CurrentValue, 109), null, $this->fechaini_real->ReadOnly);

            // fechafinal_real
            $this->fechafinal_real->setDbValueDef($rsnew, UnFormatDateTime($this->fechafinal_real->CurrentValue, 109), null, $this->fechafinal_real->ReadOnly);

            // image_escenario
            if ($this->image_escenario->Visible && !$this->image_escenario->ReadOnly && !$this->image_escenario->Upload->KeepFile) {
                $this->image_escenario->Upload->DbValue = $rsold['image_escenario']; // Get original value
                if ($this->image_escenario->Upload->FileName == "") {
                    $rsnew['image_escenario'] = null;
                } else {
                    $rsnew['image_escenario'] = $this->image_escenario->Upload->FileName;
                }
                $this->image_escenario->ImageWidth = THUMBNAIL_DEFAULT_WIDTH; // Resize width
                $this->image_escenario->ImageHeight = THUMBNAIL_DEFAULT_HEIGHT; // Resize height
            }

            // estado
            $this->estado->setDbValueDef($rsnew, $this->estado->CurrentValue, null, $this->estado->ReadOnly);
            if ($this->image_escenario->Visible && !$this->image_escenario->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->image_escenario->Upload->DbValue) ? [] : [$this->image_escenario->htmlDecode($this->image_escenario->Upload->DbValue)];
                if (!EmptyValue($this->image_escenario->Upload->FileName)) {
                    $newFiles = [$this->image_escenario->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->image_escenario, $this->image_escenario->Upload->Index);
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
                                $file1 = UniqueFilename($this->image_escenario->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->image_escenario->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->image_escenario->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->image_escenario->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->image_escenario->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->image_escenario->setDbValueDef($rsnew, $this->image_escenario->Upload->FileName, null, $this->image_escenario->ReadOnly);
                }
            }

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                    if ($this->image_escenario->Visible && !$this->image_escenario->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->image_escenario->Upload->DbValue) ? [] : [$this->image_escenario->htmlDecode($this->image_escenario->Upload->DbValue)];
                        if (!EmptyValue($this->image_escenario->Upload->FileName)) {
                            $newFiles = [$this->image_escenario->Upload->FileName];
                            $newFiles2 = [$this->image_escenario->htmlDecode($rsnew['image_escenario'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->image_escenario, $this->image_escenario->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->image_escenario->Upload->ResizeAndSaveToFile($this->image_escenario->ImageWidth, $this->image_escenario->ImageHeight, 100, $newFiles[$i], true, $i)) {
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
                                    @unlink($this->image_escenario->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                }

                // Update detail records
                $detailTblVar = explode(",", $this->getCurrentDetailTable());
                if ($editRow) {
                    $detailPage = Container("GrupoGrid");
                    if (in_array("grupo", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "grupo"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }
                if ($editRow) {
                    $detailPage = Container("TareasGrid");
                    if (in_array("tareas", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "tareas"); // Load user level of detail table
                        $editRow = $detailPage->gridUpdate();
                        $Security->loadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
                    }
                }

                // Commit/Rollback transaction
                if ($this->getCurrentDetailTable() != "") {
                    if ($editRow) {
                        $conn->commit(); // Commit transaction
                    } else {
                        $conn->rollback(); // Rollback transaction
                    }
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
            // image_escenario
            CleanUploadTempPath($this->image_escenario, $this->image_escenario->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
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
            if (in_array("grupo", $detailTblVar)) {
                $detailPageObj = Container("GrupoGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->id_escenario->IsDetailKey = true;
                    $detailPageObj->id_escenario->CurrentValue = $this->id_escenario->CurrentValue;
                    $detailPageObj->id_escenario->setSessionValue($detailPageObj->id_escenario->CurrentValue);
                }
            }
            if (in_array("tareas", $detailTblVar)) {
                $detailPageObj = Container("TareasGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->id_escenario->IsDetailKey = true;
                    $detailPageObj->id_escenario->CurrentValue = $this->id_escenario->CurrentValue;
                    $detailPageObj->id_escenario->setSessionValue($detailPageObj->id_escenario->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("EscenarioList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_tipo_evento":
                    break;
                case "x_incidente":
                    break;
                case "x_pais_escenario":
                    break;
                case "x_estado":
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
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
