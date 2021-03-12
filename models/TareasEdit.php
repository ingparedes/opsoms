<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class TareasEdit extends Tareas
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'tareas';

    // Page object name
    public $PageObjName = "TareasEdit";

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

        // Table object (tareas)
        if (!isset($GLOBALS["tareas"]) || get_class($GLOBALS["tareas"]) == PROJECT_NAMESPACE . "tareas") {
            $GLOBALS["tareas"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'tareas');
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
                $doc = new $class(Container("tareas"));
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
                    if ($pageName == "TareasView") {
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
            $key .= @$ar['id_tarea'];
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
            $this->id_tarea->Visible = false;
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
        $this->id_tarea->setVisibility();
        $this->id_escenario->setVisibility();
        $this->id_grupo->setVisibility();
        $this->titulo_tarea->setVisibility();
        $this->descripcion_tarea->setVisibility();
        $this->fechainireal_tarea->setVisibility();
        $this->fechafin_tarea->setVisibility();
        $this->fechainisimulado_tarea->setVisibility();
        $this->fechafinsimulado_tarea->setVisibility();
        $this->id_tarearelacion->setVisibility();
        $this->archivo->Visible = false;
        $this->id_subgrupo->Visible = false;
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
        $this->setupLookupOptions($this->id_grupo);
        $this->setupLookupOptions($this->id_tarearelacion);

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
            if (($keyValue = Get("id_tarea") ?? Key(0) ?? Route(2)) !== null) {
                $this->id_tarea->setQueryStringValue($keyValue);
                $this->id_tarea->setOldValue($this->id_tarea->QueryStringValue);
            } elseif (Post("id_tarea") !== null) {
                $this->id_tarea->setFormValue(Post("id_tarea"));
                $this->id_tarea->setOldValue($this->id_tarea->FormValue);
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
                if (($keyValue = Get("id_tarea") ?? Route("id_tarea")) !== null) {
                    $this->id_tarea->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id_tarea->CurrentValue = null;
                }
            }

            // Set up master detail parameters
            $this->setupMasterParms();

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
                    $this->terminate("TareasList"); // No matching record, return to list
                    return;
                }

                // Set up detail parameters
                $this->setupDetailParms();
                break;
            case "update": // Update
                if ($this->getCurrentDetailTable() != "") { // Master/detail edit
                    $returnUrl = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
                } else {
                    $returnUrl = $this->getReturnUrl();
                }
                if (GetPageName($returnUrl) == "TareasList") {
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
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id_tarea' first before field var 'x_id_tarea'
        $val = $CurrentForm->hasValue("id_tarea") ? $CurrentForm->getValue("id_tarea") : $CurrentForm->getValue("x_id_tarea");
        if (!$this->id_tarea->IsDetailKey) {
            $this->id_tarea->setFormValue($val);
        }

        // Check field name 'id_escenario' first before field var 'x_id_escenario'
        $val = $CurrentForm->hasValue("id_escenario") ? $CurrentForm->getValue("id_escenario") : $CurrentForm->getValue("x_id_escenario");
        if (!$this->id_escenario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_escenario->Visible = false; // Disable update for API request
            } else {
                $this->id_escenario->setFormValue($val);
            }
        }

        // Check field name 'id_grupo' first before field var 'x_id_grupo'
        $val = $CurrentForm->hasValue("id_grupo") ? $CurrentForm->getValue("id_grupo") : $CurrentForm->getValue("x_id_grupo");
        if (!$this->id_grupo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_grupo->Visible = false; // Disable update for API request
            } else {
                $this->id_grupo->setFormValue($val);
            }
        }

        // Check field name 'titulo_tarea' first before field var 'x_titulo_tarea'
        $val = $CurrentForm->hasValue("titulo_tarea") ? $CurrentForm->getValue("titulo_tarea") : $CurrentForm->getValue("x_titulo_tarea");
        if (!$this->titulo_tarea->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->titulo_tarea->Visible = false; // Disable update for API request
            } else {
                $this->titulo_tarea->setFormValue($val);
            }
        }

        // Check field name 'descripcion_tarea' first before field var 'x_descripcion_tarea'
        $val = $CurrentForm->hasValue("descripcion_tarea") ? $CurrentForm->getValue("descripcion_tarea") : $CurrentForm->getValue("x_descripcion_tarea");
        if (!$this->descripcion_tarea->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->descripcion_tarea->Visible = false; // Disable update for API request
            } else {
                $this->descripcion_tarea->setFormValue($val);
            }
        }

        // Check field name 'fechainireal_tarea' first before field var 'x_fechainireal_tarea'
        $val = $CurrentForm->hasValue("fechainireal_tarea") ? $CurrentForm->getValue("fechainireal_tarea") : $CurrentForm->getValue("x_fechainireal_tarea");
        if (!$this->fechainireal_tarea->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechainireal_tarea->Visible = false; // Disable update for API request
            } else {
                $this->fechainireal_tarea->setFormValue($val);
            }
            $this->fechainireal_tarea->CurrentValue = UnFormatDateTime($this->fechainireal_tarea->CurrentValue, 109);
        }

        // Check field name 'fechafin_tarea' first before field var 'x_fechafin_tarea'
        $val = $CurrentForm->hasValue("fechafin_tarea") ? $CurrentForm->getValue("fechafin_tarea") : $CurrentForm->getValue("x_fechafin_tarea");
        if (!$this->fechafin_tarea->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechafin_tarea->Visible = false; // Disable update for API request
            } else {
                $this->fechafin_tarea->setFormValue($val);
            }
            $this->fechafin_tarea->CurrentValue = UnFormatDateTime($this->fechafin_tarea->CurrentValue, 109);
        }

        // Check field name 'fechainisimulado_tarea' first before field var 'x_fechainisimulado_tarea'
        $val = $CurrentForm->hasValue("fechainisimulado_tarea") ? $CurrentForm->getValue("fechainisimulado_tarea") : $CurrentForm->getValue("x_fechainisimulado_tarea");
        if (!$this->fechainisimulado_tarea->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechainisimulado_tarea->Visible = false; // Disable update for API request
            } else {
                $this->fechainisimulado_tarea->setFormValue($val);
            }
            $this->fechainisimulado_tarea->CurrentValue = UnFormatDateTime($this->fechainisimulado_tarea->CurrentValue, 109);
        }

        // Check field name 'fechafinsimulado_tarea' first before field var 'x_fechafinsimulado_tarea'
        $val = $CurrentForm->hasValue("fechafinsimulado_tarea") ? $CurrentForm->getValue("fechafinsimulado_tarea") : $CurrentForm->getValue("x_fechafinsimulado_tarea");
        if (!$this->fechafinsimulado_tarea->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechafinsimulado_tarea->Visible = false; // Disable update for API request
            } else {
                $this->fechafinsimulado_tarea->setFormValue($val);
            }
            $this->fechafinsimulado_tarea->CurrentValue = UnFormatDateTime($this->fechafinsimulado_tarea->CurrentValue, 109);
        }

        // Check field name 'id_tarearelacion' first before field var 'x_id_tarearelacion'
        $val = $CurrentForm->hasValue("id_tarearelacion") ? $CurrentForm->getValue("id_tarearelacion") : $CurrentForm->getValue("x_id_tarearelacion");
        if (!$this->id_tarearelacion->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_tarearelacion->Visible = false; // Disable update for API request
            } else {
                $this->id_tarearelacion->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id_tarea->CurrentValue = $this->id_tarea->FormValue;
        $this->id_escenario->CurrentValue = $this->id_escenario->FormValue;
        $this->id_grupo->CurrentValue = $this->id_grupo->FormValue;
        $this->titulo_tarea->CurrentValue = $this->titulo_tarea->FormValue;
        $this->descripcion_tarea->CurrentValue = $this->descripcion_tarea->FormValue;
        $this->fechainireal_tarea->CurrentValue = $this->fechainireal_tarea->FormValue;
        $this->fechainireal_tarea->CurrentValue = UnFormatDateTime($this->fechainireal_tarea->CurrentValue, 109);
        $this->fechafin_tarea->CurrentValue = $this->fechafin_tarea->FormValue;
        $this->fechafin_tarea->CurrentValue = UnFormatDateTime($this->fechafin_tarea->CurrentValue, 109);
        $this->fechainisimulado_tarea->CurrentValue = $this->fechainisimulado_tarea->FormValue;
        $this->fechainisimulado_tarea->CurrentValue = UnFormatDateTime($this->fechainisimulado_tarea->CurrentValue, 109);
        $this->fechafinsimulado_tarea->CurrentValue = $this->fechafinsimulado_tarea->FormValue;
        $this->fechafinsimulado_tarea->CurrentValue = UnFormatDateTime($this->fechafinsimulado_tarea->CurrentValue, 109);
        $this->id_tarearelacion->CurrentValue = $this->id_tarearelacion->FormValue;
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
        $this->archivo->setDbValue($this->archivo->Upload->DbValue);
        $this->id_subgrupo->setDbValue($row['id_subgrupo']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id_tarea'] = null;
        $row['id_escenario'] = null;
        $row['id_grupo'] = null;
        $row['titulo_tarea'] = null;
        $row['descripcion_tarea'] = null;
        $row['fechainireal_tarea'] = null;
        $row['fechafin_tarea'] = null;
        $row['fechainisimulado_tarea'] = null;
        $row['fechafinsimulado_tarea'] = null;
        $row['id_tarearelacion'] = null;
        $row['archivo'] = null;
        $row['id_subgrupo'] = null;
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
        if ($this->RowType == ROWTYPE_VIEW) {
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
        } elseif ($this->RowType == ROWTYPE_EDIT) {
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
                $this->id_escenario->EditValue = HtmlEncode($this->id_escenario->CurrentValue);
                $this->id_escenario->PlaceHolder = RemoveHtml($this->id_escenario->caption());
            }

            // id_grupo
            $this->id_grupo->EditAttrs["class"] = "form-control";
            $this->id_grupo->EditCustomAttributes = "";
            $curVal = trim(strval($this->id_grupo->CurrentValue));
            if ($curVal != "") {
                $this->id_grupo->ViewValue = $this->id_grupo->lookupCacheOption($curVal);
            } else {
                $this->id_grupo->ViewValue = $this->id_grupo->Lookup !== null && is_array($this->id_grupo->Lookup->Options) ? $curVal : null;
            }
            if ($this->id_grupo->ViewValue !== null) { // Load from cache
                $this->id_grupo->EditValue = array_values($this->id_grupo->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_grupo`" . SearchString("=", $this->id_grupo->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->id_grupo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->id_grupo->EditValue = $arwrk;
            }
            $this->id_grupo->PlaceHolder = RemoveHtml($this->id_grupo->caption());

            // titulo_tarea
            $this->titulo_tarea->EditAttrs["class"] = "form-control";
            $this->titulo_tarea->EditCustomAttributes = "";
            if (!$this->titulo_tarea->Raw) {
                $this->titulo_tarea->CurrentValue = HtmlDecode($this->titulo_tarea->CurrentValue);
            }
            $this->titulo_tarea->EditValue = HtmlEncode($this->titulo_tarea->CurrentValue);
            $this->titulo_tarea->PlaceHolder = RemoveHtml($this->titulo_tarea->caption());

            // descripcion_tarea
            $this->descripcion_tarea->EditAttrs["class"] = "form-control";
            $this->descripcion_tarea->EditCustomAttributes = "";
            $this->descripcion_tarea->EditValue = HtmlEncode($this->descripcion_tarea->CurrentValue);
            $this->descripcion_tarea->PlaceHolder = RemoveHtml($this->descripcion_tarea->caption());

            // fechainireal_tarea
            $this->fechainireal_tarea->EditAttrs["class"] = "form-control";
            $this->fechainireal_tarea->EditCustomAttributes = "";
            $this->fechainireal_tarea->EditValue = HtmlEncode(FormatDateTime($this->fechainireal_tarea->CurrentValue, 109));
            $this->fechainireal_tarea->PlaceHolder = RemoveHtml($this->fechainireal_tarea->caption());

            // fechafin_tarea
            $this->fechafin_tarea->EditAttrs["class"] = "form-control";
            $this->fechafin_tarea->EditCustomAttributes = "";
            $this->fechafin_tarea->EditValue = HtmlEncode(FormatDateTime($this->fechafin_tarea->CurrentValue, 109));
            $this->fechafin_tarea->PlaceHolder = RemoveHtml($this->fechafin_tarea->caption());

            // fechainisimulado_tarea
            $this->fechainisimulado_tarea->EditAttrs["class"] = "form-control";
            $this->fechainisimulado_tarea->EditCustomAttributes = "";
            $this->fechainisimulado_tarea->EditValue = HtmlEncode(FormatDateTime($this->fechainisimulado_tarea->CurrentValue, 109));
            $this->fechainisimulado_tarea->PlaceHolder = RemoveHtml($this->fechainisimulado_tarea->caption());

            // fechafinsimulado_tarea
            $this->fechafinsimulado_tarea->EditAttrs["class"] = "form-control";
            $this->fechafinsimulado_tarea->EditCustomAttributes = "";
            $this->fechafinsimulado_tarea->EditValue = HtmlEncode(FormatDateTime($this->fechafinsimulado_tarea->CurrentValue, 109));
            $this->fechafinsimulado_tarea->PlaceHolder = RemoveHtml($this->fechafinsimulado_tarea->caption());

            // id_tarearelacion
            $this->id_tarearelacion->EditCustomAttributes = "";
            $curVal = trim(strval($this->id_tarearelacion->CurrentValue));
            if ($curVal != "") {
                $this->id_tarearelacion->ViewValue = $this->id_tarearelacion->lookupCacheOption($curVal);
            } else {
                $this->id_tarearelacion->ViewValue = $this->id_tarearelacion->Lookup !== null && is_array($this->id_tarearelacion->Lookup->Options) ? $curVal : null;
            }
            if ($this->id_tarearelacion->ViewValue !== null) { // Load from cache
                $this->id_tarearelacion->EditValue = array_values($this->id_tarearelacion->Lookup->Options);
                if ($this->id_tarearelacion->ViewValue == "") {
                    $this->id_tarearelacion->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_tarea`" . SearchString("=", $this->id_tarearelacion->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->id_tarearelacion->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->id_tarearelacion->Lookup->renderViewRow($rswrk[0]);
                    $this->id_tarearelacion->ViewValue = $this->id_tarearelacion->displayValue($arwrk);
                } else {
                    $this->id_tarearelacion->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                foreach ($arwrk as &$row)
                    $row = $this->id_tarearelacion->Lookup->renderViewRow($row);
                $this->id_tarearelacion->EditValue = $arwrk;
            }
            $this->id_tarearelacion->PlaceHolder = RemoveHtml($this->id_tarearelacion->caption());

            // Edit refer script

            // id_tarea
            $this->id_tarea->LinkCustomAttributes = "";
            $this->id_tarea->HrefValue = "";

            // id_escenario
            $this->id_escenario->LinkCustomAttributes = "";
            $this->id_escenario->HrefValue = "";

            // id_grupo
            $this->id_grupo->LinkCustomAttributes = "";
            $this->id_grupo->HrefValue = "";

            // titulo_tarea
            $this->titulo_tarea->LinkCustomAttributes = "";
            $this->titulo_tarea->HrefValue = "";

            // descripcion_tarea
            $this->descripcion_tarea->LinkCustomAttributes = "";
            $this->descripcion_tarea->HrefValue = "";

            // fechainireal_tarea
            $this->fechainireal_tarea->LinkCustomAttributes = "";
            $this->fechainireal_tarea->HrefValue = "";

            // fechafin_tarea
            $this->fechafin_tarea->LinkCustomAttributes = "";
            $this->fechafin_tarea->HrefValue = "";

            // fechainisimulado_tarea
            $this->fechainisimulado_tarea->LinkCustomAttributes = "";
            $this->fechainisimulado_tarea->HrefValue = "";

            // fechafinsimulado_tarea
            $this->fechafinsimulado_tarea->LinkCustomAttributes = "";
            $this->fechafinsimulado_tarea->HrefValue = "";

            // id_tarearelacion
            $this->id_tarearelacion->LinkCustomAttributes = "";
            $this->id_tarearelacion->HrefValue = "";
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
        if ($this->id_tarea->Required) {
            if (!$this->id_tarea->IsDetailKey && EmptyValue($this->id_tarea->FormValue)) {
                $this->id_tarea->addErrorMessage(str_replace("%s", $this->id_tarea->caption(), $this->id_tarea->RequiredErrorMessage));
            }
        }
        if ($this->id_escenario->Required) {
            if (!$this->id_escenario->IsDetailKey && EmptyValue($this->id_escenario->FormValue)) {
                $this->id_escenario->addErrorMessage(str_replace("%s", $this->id_escenario->caption(), $this->id_escenario->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->id_escenario->FormValue)) {
            $this->id_escenario->addErrorMessage($this->id_escenario->getErrorMessage(false));
        }
        if ($this->id_grupo->Required) {
            if (!$this->id_grupo->IsDetailKey && EmptyValue($this->id_grupo->FormValue)) {
                $this->id_grupo->addErrorMessage(str_replace("%s", $this->id_grupo->caption(), $this->id_grupo->RequiredErrorMessage));
            }
        }
        if ($this->titulo_tarea->Required) {
            if (!$this->titulo_tarea->IsDetailKey && EmptyValue($this->titulo_tarea->FormValue)) {
                $this->titulo_tarea->addErrorMessage(str_replace("%s", $this->titulo_tarea->caption(), $this->titulo_tarea->RequiredErrorMessage));
            }
        }
        if ($this->descripcion_tarea->Required) {
            if (!$this->descripcion_tarea->IsDetailKey && EmptyValue($this->descripcion_tarea->FormValue)) {
                $this->descripcion_tarea->addErrorMessage(str_replace("%s", $this->descripcion_tarea->caption(), $this->descripcion_tarea->RequiredErrorMessage));
            }
        }
        if ($this->fechainireal_tarea->Required) {
            if (!$this->fechainireal_tarea->IsDetailKey && EmptyValue($this->fechainireal_tarea->FormValue)) {
                $this->fechainireal_tarea->addErrorMessage(str_replace("%s", $this->fechainireal_tarea->caption(), $this->fechainireal_tarea->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->fechainireal_tarea->FormValue)) {
            $this->fechainireal_tarea->addErrorMessage($this->fechainireal_tarea->getErrorMessage(false));
        }
        if ($this->fechafin_tarea->Required) {
            if (!$this->fechafin_tarea->IsDetailKey && EmptyValue($this->fechafin_tarea->FormValue)) {
                $this->fechafin_tarea->addErrorMessage(str_replace("%s", $this->fechafin_tarea->caption(), $this->fechafin_tarea->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->fechafin_tarea->FormValue)) {
            $this->fechafin_tarea->addErrorMessage($this->fechafin_tarea->getErrorMessage(false));
        }
        if ($this->fechainisimulado_tarea->Required) {
            if (!$this->fechainisimulado_tarea->IsDetailKey && EmptyValue($this->fechainisimulado_tarea->FormValue)) {
                $this->fechainisimulado_tarea->addErrorMessage(str_replace("%s", $this->fechainisimulado_tarea->caption(), $this->fechainisimulado_tarea->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->fechainisimulado_tarea->FormValue)) {
            $this->fechainisimulado_tarea->addErrorMessage($this->fechainisimulado_tarea->getErrorMessage(false));
        }
        if ($this->fechafinsimulado_tarea->Required) {
            if (!$this->fechafinsimulado_tarea->IsDetailKey && EmptyValue($this->fechafinsimulado_tarea->FormValue)) {
                $this->fechafinsimulado_tarea->addErrorMessage(str_replace("%s", $this->fechafinsimulado_tarea->caption(), $this->fechafinsimulado_tarea->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->fechafinsimulado_tarea->FormValue)) {
            $this->fechafinsimulado_tarea->addErrorMessage($this->fechafinsimulado_tarea->getErrorMessage(false));
        }
        if ($this->id_tarearelacion->Required) {
            if (!$this->id_tarearelacion->IsDetailKey && EmptyValue($this->id_tarearelacion->FormValue)) {
                $this->id_tarearelacion->addErrorMessage(str_replace("%s", $this->id_tarearelacion->caption(), $this->id_tarearelacion->RequiredErrorMessage));
            }
        }

        // Validate detail grid
        $detailTblVar = explode(",", $this->getCurrentDetailTable());
        $detailPage = Container("MensajesGrid");
        if (in_array("mensajes", $detailTblVar) && $detailPage->DetailEdit) {
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

            // id_escenario
            if ($this->id_escenario->getSessionValue() != "") {
                $this->id_escenario->ReadOnly = true;
            }
            $this->id_escenario->setDbValueDef($rsnew, $this->id_escenario->CurrentValue, null, $this->id_escenario->ReadOnly);

            // id_grupo
            $this->id_grupo->setDbValueDef($rsnew, $this->id_grupo->CurrentValue, null, $this->id_grupo->ReadOnly);

            // titulo_tarea
            $this->titulo_tarea->setDbValueDef($rsnew, $this->titulo_tarea->CurrentValue, null, $this->titulo_tarea->ReadOnly);

            // descripcion_tarea
            $this->descripcion_tarea->setDbValueDef($rsnew, $this->descripcion_tarea->CurrentValue, null, $this->descripcion_tarea->ReadOnly);

            // fechainireal_tarea
            $this->fechainireal_tarea->setDbValueDef($rsnew, UnFormatDateTime($this->fechainireal_tarea->CurrentValue, 109), null, $this->fechainireal_tarea->ReadOnly);

            // fechafin_tarea
            $this->fechafin_tarea->setDbValueDef($rsnew, UnFormatDateTime($this->fechafin_tarea->CurrentValue, 109), null, $this->fechafin_tarea->ReadOnly);

            // fechainisimulado_tarea
            $this->fechainisimulado_tarea->setDbValueDef($rsnew, UnFormatDateTime($this->fechainisimulado_tarea->CurrentValue, 109), null, $this->fechainisimulado_tarea->ReadOnly);

            // fechafinsimulado_tarea
            $this->fechafinsimulado_tarea->setDbValueDef($rsnew, UnFormatDateTime($this->fechafinsimulado_tarea->CurrentValue, 109), null, $this->fechafinsimulado_tarea->ReadOnly);

            // id_tarearelacion
            $this->id_tarearelacion->setDbValueDef($rsnew, $this->id_tarearelacion->CurrentValue, null, $this->id_tarearelacion->ReadOnly);

            // Check referential integrity for master table 'escenario'
            $validMasterRecord = true;
            $masterFilter = $this->sqlMasterFilter_escenario();
            $keyValue = $rsnew['id_escenario'] ?? $rsold['id_escenario'];
            if (strval($keyValue) != "") {
                $masterFilter = str_replace("@id_escenario@", AdjustSql($keyValue), $masterFilter);
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
                }

                // Update detail records
                $detailTblVar = explode(",", $this->getCurrentDetailTable());
                if ($editRow) {
                    $detailPage = Container("MensajesGrid");
                    if (in_array("mensajes", $detailTblVar) && $detailPage->DetailEdit) {
                        $Security->loadCurrentUserLevel($this->ProjectID . "mensajes"); // Load user level of detail table
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
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
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
            $this->setSessionWhere($this->getDetailFilter());

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
            if (in_array("mensajes", $detailTblVar)) {
                $detailPageObj = Container("MensajesGrid");
                if ($detailPageObj->DetailEdit) {
                    $detailPageObj->CurrentMode = "edit";
                    $detailPageObj->CurrentAction = "gridedit";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->id_tareas->IsDetailKey = true;
                    $detailPageObj->id_tareas->CurrentValue = $this->id_tarea->CurrentValue;
                    $detailPageObj->id_tareas->setSessionValue($detailPageObj->id_tareas->CurrentValue);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("TareasList"), "", $this->TableVar, true);
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
                case "x_id_grupo":
                    break;
                case "x_id_tarearelacion":
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
