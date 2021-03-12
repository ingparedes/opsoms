<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class MensajesEdit extends Mensajes
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'mensajes';

    // Page object name
    public $PageObjName = "MensajesEdit";

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

        // Table object (mensajes)
        if (!isset($GLOBALS["mensajes"]) || get_class($GLOBALS["mensajes"]) == PROJECT_NAMESPACE . "mensajes") {
            $GLOBALS["mensajes"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'mensajes');
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
                $doc = new $class(Container("mensajes"));
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
                    if ($pageName == "MensajesView") {
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
            $key .= @$ar['id_inyect'];
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
            $this->id_inyect->Visible = false;
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
        $this->id_inyect->setVisibility();
        $this->id_tareas->setVisibility();
        $this->titulo->setVisibility();
        $this->mensaje->setVisibility();
        $this->fechareal_start->setVisibility();
        $this->fechasim_start->setVisibility();
        $this->medios->setVisibility();
        $this->actividad_esperada->setVisibility();
        $this->id_actor->setVisibility();
        $this->enviado->Visible = false;
        $this->para->setVisibility();
        $this->adjunto->setVisibility();
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
        $this->setupLookupOptions($this->id_actor);
        $this->setupLookupOptions($this->para);

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
            if (($keyValue = Get("id_inyect") ?? Key(0) ?? Route(2)) !== null) {
                $this->id_inyect->setQueryStringValue($keyValue);
                $this->id_inyect->setOldValue($this->id_inyect->QueryStringValue);
            } elseif (Post("id_inyect") !== null) {
                $this->id_inyect->setFormValue(Post("id_inyect"));
                $this->id_inyect->setOldValue($this->id_inyect->FormValue);
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
                if (($keyValue = Get("id_inyect") ?? Route("id_inyect")) !== null) {
                    $this->id_inyect->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id_inyect->CurrentValue = null;
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
                    $this->terminate("MensajesList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "MensajesList") {
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
        $this->adjunto->Upload->Index = $CurrentForm->Index;
        $this->adjunto->Upload->uploadFile();
        $this->adjunto->CurrentValue = $this->adjunto->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id_inyect' first before field var 'x_id_inyect'
        $val = $CurrentForm->hasValue("id_inyect") ? $CurrentForm->getValue("id_inyect") : $CurrentForm->getValue("x_id_inyect");
        if (!$this->id_inyect->IsDetailKey) {
            $this->id_inyect->setFormValue($val);
        }

        // Check field name 'id_tareas' first before field var 'x_id_tareas'
        $val = $CurrentForm->hasValue("id_tareas") ? $CurrentForm->getValue("id_tareas") : $CurrentForm->getValue("x_id_tareas");
        if (!$this->id_tareas->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_tareas->Visible = false; // Disable update for API request
            } else {
                $this->id_tareas->setFormValue($val);
            }
        }

        // Check field name 'titulo' first before field var 'x_titulo'
        $val = $CurrentForm->hasValue("titulo") ? $CurrentForm->getValue("titulo") : $CurrentForm->getValue("x_titulo");
        if (!$this->titulo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->titulo->Visible = false; // Disable update for API request
            } else {
                $this->titulo->setFormValue($val);
            }
        }

        // Check field name 'mensaje' first before field var 'x_mensaje'
        $val = $CurrentForm->hasValue("mensaje") ? $CurrentForm->getValue("mensaje") : $CurrentForm->getValue("x_mensaje");
        if (!$this->mensaje->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->mensaje->Visible = false; // Disable update for API request
            } else {
                $this->mensaje->setFormValue($val);
            }
        }

        // Check field name 'fechareal_start' first before field var 'x_fechareal_start'
        $val = $CurrentForm->hasValue("fechareal_start") ? $CurrentForm->getValue("fechareal_start") : $CurrentForm->getValue("x_fechareal_start");
        if (!$this->fechareal_start->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechareal_start->Visible = false; // Disable update for API request
            } else {
                $this->fechareal_start->setFormValue($val);
            }
            $this->fechareal_start->CurrentValue = UnFormatDateTime($this->fechareal_start->CurrentValue, 109);
        }

        // Check field name 'fechasim_start' first before field var 'x_fechasim_start'
        $val = $CurrentForm->hasValue("fechasim_start") ? $CurrentForm->getValue("fechasim_start") : $CurrentForm->getValue("x_fechasim_start");
        if (!$this->fechasim_start->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fechasim_start->Visible = false; // Disable update for API request
            } else {
                $this->fechasim_start->setFormValue($val);
            }
            $this->fechasim_start->CurrentValue = UnFormatDateTime($this->fechasim_start->CurrentValue, 109);
        }

        // Check field name 'medios' first before field var 'x_medios'
        $val = $CurrentForm->hasValue("medios") ? $CurrentForm->getValue("medios") : $CurrentForm->getValue("x_medios");
        if (!$this->medios->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->medios->Visible = false; // Disable update for API request
            } else {
                $this->medios->setFormValue($val);
            }
        }

        // Check field name 'actividad_esperada' first before field var 'x_actividad_esperada'
        $val = $CurrentForm->hasValue("actividad_esperada") ? $CurrentForm->getValue("actividad_esperada") : $CurrentForm->getValue("x_actividad_esperada");
        if (!$this->actividad_esperada->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->actividad_esperada->Visible = false; // Disable update for API request
            } else {
                $this->actividad_esperada->setFormValue($val);
            }
        }

        // Check field name 'id_actor' first before field var 'x_id_actor'
        $val = $CurrentForm->hasValue("id_actor") ? $CurrentForm->getValue("id_actor") : $CurrentForm->getValue("x_id_actor");
        if (!$this->id_actor->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->id_actor->Visible = false; // Disable update for API request
            } else {
                $this->id_actor->setFormValue($val);
            }
        }

        // Check field name 'para' first before field var 'x_para'
        $val = $CurrentForm->hasValue("para") ? $CurrentForm->getValue("para") : $CurrentForm->getValue("x_para");
        if (!$this->para->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->para->Visible = false; // Disable update for API request
            } else {
                $this->para->setFormValue($val);
            }
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id_inyect->CurrentValue = $this->id_inyect->FormValue;
        $this->id_tareas->CurrentValue = $this->id_tareas->FormValue;
        $this->titulo->CurrentValue = $this->titulo->FormValue;
        $this->mensaje->CurrentValue = $this->mensaje->FormValue;
        $this->fechareal_start->CurrentValue = $this->fechareal_start->FormValue;
        $this->fechareal_start->CurrentValue = UnFormatDateTime($this->fechareal_start->CurrentValue, 109);
        $this->fechasim_start->CurrentValue = $this->fechasim_start->FormValue;
        $this->fechasim_start->CurrentValue = UnFormatDateTime($this->fechasim_start->CurrentValue, 109);
        $this->medios->CurrentValue = $this->medios->FormValue;
        $this->actividad_esperada->CurrentValue = $this->actividad_esperada->FormValue;
        $this->id_actor->CurrentValue = $this->id_actor->FormValue;
        $this->para->CurrentValue = $this->para->FormValue;
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
        $this->id_inyect->setDbValue($row['id_inyect']);
        $this->id_tareas->setDbValue($row['id_tareas']);
        $this->titulo->setDbValue($row['titulo']);
        $this->mensaje->setDbValue($row['mensaje']);
        $this->fechareal_start->setDbValue($row['fechareal_start']);
        $this->fechasim_start->setDbValue($row['fechasim_start']);
        $this->medios->setDbValue($row['medios']);
        $this->actividad_esperada->setDbValue($row['actividad_esperada']);
        $this->id_actor->setDbValue($row['id_actor']);
        $this->enviado->setDbValue($row['enviado']);
        $this->para->setDbValue($row['para']);
        $this->adjunto->Upload->DbValue = $row['adjunto'];
        $this->adjunto->setDbValue($this->adjunto->Upload->DbValue);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id_inyect'] = null;
        $row['id_tareas'] = null;
        $row['titulo'] = null;
        $row['mensaje'] = null;
        $row['fechareal_start'] = null;
        $row['fechasim_start'] = null;
        $row['medios'] = null;
        $row['actividad_esperada'] = null;
        $row['id_actor'] = null;
        $row['enviado'] = null;
        $row['para'] = null;
        $row['adjunto'] = null;
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

        // id_inyect

        // id_tareas

        // titulo

        // mensaje

        // fechareal_start

        // fechasim_start

        // medios

        // actividad_esperada

        // id_actor

        // enviado

        // para

        // adjunto
        if ($this->RowType == ROWTYPE_VIEW) {
            // id_inyect
            $this->id_inyect->ViewValue = $this->id_inyect->CurrentValue;
            $this->id_inyect->ViewCustomAttributes = "";

            // id_tareas
            $this->id_tareas->ViewValue = $this->id_tareas->CurrentValue;
            $this->id_tareas->ViewValue = FormatNumber($this->id_tareas->ViewValue, 0, -2, -2, -2);
            $this->id_tareas->ViewCustomAttributes = "";

            // titulo
            $this->titulo->ViewValue = $this->titulo->CurrentValue;
            $this->titulo->ViewCustomAttributes = "";

            // mensaje
            $this->mensaje->ViewValue = $this->mensaje->CurrentValue;
            $this->mensaje->ViewCustomAttributes = "";

            // fechareal_start
            $this->fechareal_start->ViewValue = $this->fechareal_start->CurrentValue;
            $this->fechareal_start->ViewValue = FormatDateTime($this->fechareal_start->ViewValue, 109);
            $this->fechareal_start->ViewCustomAttributes = "";

            // fechasim_start
            $this->fechasim_start->ViewValue = $this->fechasim_start->CurrentValue;
            $this->fechasim_start->ViewValue = FormatDateTime($this->fechasim_start->ViewValue, 109);
            $this->fechasim_start->ViewCustomAttributes = "";

            // medios
            if (strval($this->medios->CurrentValue) != "") {
                $this->medios->ViewValue = $this->medios->optionCaption($this->medios->CurrentValue);
            } else {
                $this->medios->ViewValue = null;
            }
            $this->medios->ViewCustomAttributes = "";

            // actividad_esperada
            $this->actividad_esperada->ViewValue = $this->actividad_esperada->CurrentValue;
            $this->actividad_esperada->ViewCustomAttributes = "";

            // id_actor
            $curVal = strval($this->id_actor->CurrentValue);
            if ($curVal != "") {
                $this->id_actor->ViewValue = $this->id_actor->lookupCacheOption($curVal);
                if ($this->id_actor->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id_actor`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->id_actor->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->id_actor->Lookup->renderViewRow($rswrk[0]);
                        $this->id_actor->ViewValue = $this->id_actor->displayValue($arwrk);
                    } else {
                        $this->id_actor->ViewValue = $this->id_actor->CurrentValue;
                    }
                }
            } else {
                $this->id_actor->ViewValue = null;
            }
            $this->id_actor->ViewCustomAttributes = "";

            // enviado
            $this->enviado->ViewValue = $this->enviado->CurrentValue;
            $this->enviado->ViewValue = FormatNumber($this->enviado->ViewValue, 0, -2, -2, -2);
            $this->enviado->ViewCustomAttributes = "";

            // para
            $curVal = strval($this->para->CurrentValue);
            if ($curVal != "") {
                $this->para->ViewValue = $this->para->lookupCacheOption($curVal);
                if ($this->para->ViewValue === null) { // Lookup from database
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`id`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                    $sqlWrk = $this->para->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $this->para->ViewValue = new OptionValues();
                        foreach ($rswrk as $row) {
                            $arwrk = $this->para->Lookup->renderViewRow($row);
                            $this->para->ViewValue->add($this->para->displayValue($arwrk));
                        }
                    } else {
                        $this->para->ViewValue = $this->para->CurrentValue;
                    }
                }
            } else {
                $this->para->ViewValue = null;
            }
            $this->para->ViewCustomAttributes = "";

            // adjunto
            if (!EmptyValue($this->adjunto->Upload->DbValue)) {
                $this->adjunto->ViewValue = $this->adjunto->Upload->DbValue;
            } else {
                $this->adjunto->ViewValue = "";
            }
            $this->adjunto->ViewCustomAttributes = "";

            // id_inyect
            $this->id_inyect->LinkCustomAttributes = "";
            $this->id_inyect->HrefValue = "";
            $this->id_inyect->TooltipValue = "";

            // id_tareas
            $this->id_tareas->LinkCustomAttributes = "";
            $this->id_tareas->HrefValue = "";
            $this->id_tareas->TooltipValue = "";

            // titulo
            $this->titulo->LinkCustomAttributes = "";
            $this->titulo->HrefValue = "";
            if (!$this->isExport()) {
                $this->titulo->TooltipValue = strval($this->mensaje->CurrentValue);
                if ($this->titulo->HrefValue == "") {
                    $this->titulo->HrefValue = "javascript:void(0);";
                }
                $this->titulo->LinkAttrs->appendClass("ew-tooltip-link");
                $this->titulo->LinkAttrs["data-tooltip-id"] = "tt_mensajes_x_titulo";
                $this->titulo->LinkAttrs["data-tooltip-width"] = $this->titulo->TooltipWidth;
                $this->titulo->LinkAttrs["data-placement"] = Config("CSS_FLIP") ? "left" : "right";
            }

            // mensaje
            $this->mensaje->LinkCustomAttributes = "";
            $this->mensaje->HrefValue = "";
            $this->mensaje->TooltipValue = "";

            // fechareal_start
            $this->fechareal_start->LinkCustomAttributes = "";
            $this->fechareal_start->HrefValue = "";
            $this->fechareal_start->TooltipValue = "";

            // fechasim_start
            $this->fechasim_start->LinkCustomAttributes = "";
            $this->fechasim_start->HrefValue = "";
            $this->fechasim_start->TooltipValue = "";

            // medios
            $this->medios->LinkCustomAttributes = "";
            $this->medios->HrefValue = "";
            $this->medios->TooltipValue = "";

            // actividad_esperada
            $this->actividad_esperada->LinkCustomAttributes = "";
            $this->actividad_esperada->HrefValue = "";
            $this->actividad_esperada->TooltipValue = "";

            // id_actor
            $this->id_actor->LinkCustomAttributes = "";
            $this->id_actor->HrefValue = "";
            $this->id_actor->TooltipValue = "";

            // para
            $this->para->LinkCustomAttributes = "";
            $this->para->HrefValue = "";
            $this->para->TooltipValue = "";

            // adjunto
            $this->adjunto->LinkCustomAttributes = "";
            if (!EmptyValue($this->adjunto->Upload->DbValue)) {
                $this->adjunto->HrefValue = GetFileUploadUrl($this->adjunto, $this->adjunto->htmlDecode($this->adjunto->Upload->DbValue)); // Add prefix/suffix
                $this->adjunto->LinkAttrs["target"] = "_blank"; // Add target
                if ($this->isExport()) {
                    $this->adjunto->HrefValue = FullUrl($this->adjunto->HrefValue, "href");
                }
            } else {
                $this->adjunto->HrefValue = "";
            }
            $this->adjunto->ExportHrefValue = $this->adjunto->UploadPath . $this->adjunto->Upload->DbValue;
            $this->adjunto->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id_inyect
            $this->id_inyect->EditAttrs["class"] = "form-control";
            $this->id_inyect->EditCustomAttributes = "";
            $this->id_inyect->EditValue = $this->id_inyect->CurrentValue;
            $this->id_inyect->ViewCustomAttributes = "";

            // id_tareas
            $this->id_tareas->EditAttrs["class"] = "form-control";
            $this->id_tareas->EditCustomAttributes = "";
            if ($this->id_tareas->getSessionValue() != "") {
                $this->id_tareas->CurrentValue = GetForeignKeyValue($this->id_tareas->getSessionValue());
                $this->id_tareas->ViewValue = $this->id_tareas->CurrentValue;
                $this->id_tareas->ViewValue = FormatNumber($this->id_tareas->ViewValue, 0, -2, -2, -2);
                $this->id_tareas->ViewCustomAttributes = "";
            } else {
                $this->id_tareas->EditValue = HtmlEncode($this->id_tareas->CurrentValue);
                $this->id_tareas->PlaceHolder = RemoveHtml($this->id_tareas->caption());
            }

            // titulo
            $this->titulo->EditAttrs["class"] = "form-control";
            $this->titulo->EditCustomAttributes = "";
            if (!$this->titulo->Raw) {
                $this->titulo->CurrentValue = HtmlDecode($this->titulo->CurrentValue);
            }
            $this->titulo->EditValue = HtmlEncode($this->titulo->CurrentValue);
            $this->titulo->PlaceHolder = RemoveHtml($this->titulo->caption());

            // mensaje
            $this->mensaje->EditAttrs["class"] = "form-control";
            $this->mensaje->EditCustomAttributes = "";
            $this->mensaje->EditValue = HtmlEncode($this->mensaje->CurrentValue);
            $this->mensaje->PlaceHolder = RemoveHtml($this->mensaje->caption());

            // fechareal_start
            $this->fechareal_start->EditAttrs["class"] = "form-control";
            $this->fechareal_start->EditCustomAttributes = "";
            $this->fechareal_start->EditValue = HtmlEncode(FormatDateTime($this->fechareal_start->CurrentValue, 109));
            $this->fechareal_start->PlaceHolder = RemoveHtml($this->fechareal_start->caption());

            // fechasim_start
            $this->fechasim_start->EditAttrs["class"] = "form-control";
            $this->fechasim_start->EditCustomAttributes = "";
            $this->fechasim_start->EditValue = HtmlEncode(FormatDateTime($this->fechasim_start->CurrentValue, 109));
            $this->fechasim_start->PlaceHolder = RemoveHtml($this->fechasim_start->caption());

            // medios
            $this->medios->EditAttrs["class"] = "form-control";
            $this->medios->EditCustomAttributes = "";
            $this->medios->EditValue = $this->medios->options(true);
            $this->medios->PlaceHolder = RemoveHtml($this->medios->caption());

            // actividad_esperada
            $this->actividad_esperada->EditAttrs["class"] = "form-control";
            $this->actividad_esperada->EditCustomAttributes = "";
            $this->actividad_esperada->EditValue = HtmlEncode($this->actividad_esperada->CurrentValue);
            $this->actividad_esperada->PlaceHolder = RemoveHtml($this->actividad_esperada->caption());

            // id_actor
            $this->id_actor->EditAttrs["class"] = "form-control";
            $this->id_actor->EditCustomAttributes = "";
            $curVal = trim(strval($this->id_actor->CurrentValue));
            if ($curVal != "") {
                $this->id_actor->ViewValue = $this->id_actor->lookupCacheOption($curVal);
            } else {
                $this->id_actor->ViewValue = $this->id_actor->Lookup !== null && is_array($this->id_actor->Lookup->Options) ? $curVal : null;
            }
            if ($this->id_actor->ViewValue !== null) { // Load from cache
                $this->id_actor->EditValue = array_values($this->id_actor->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_actor`" . SearchString("=", $this->id_actor->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->id_actor->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->id_actor->EditValue = $arwrk;
            }
            $this->id_actor->PlaceHolder = RemoveHtml($this->id_actor->caption());

            // para
            $this->para->EditCustomAttributes = "";
            $curVal = trim(strval($this->para->CurrentValue));
            if ($curVal != "") {
                $this->para->ViewValue = $this->para->lookupCacheOption($curVal);
            } else {
                $this->para->ViewValue = $this->para->Lookup !== null && is_array($this->para->Lookup->Options) ? $curVal : null;
            }
            if ($this->para->ViewValue !== null) { // Load from cache
                $this->para->EditValue = array_values($this->para->Lookup->Options);
                if ($this->para->ViewValue == "") {
                    $this->para->ViewValue = $Language->phrase("PleaseSelect");
                }
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $arwrk = explode(",", $curVal);
                    $filterWrk = "";
                    foreach ($arwrk as $wrk) {
                        if ($filterWrk != "") {
                            $filterWrk .= " OR ";
                        }
                        $filterWrk .= "`id`" . SearchString("=", trim($wrk), DATATYPE_STRING, "");
                    }
                }
                $sqlWrk = $this->para->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $this->para->ViewValue = new OptionValues();
                    foreach ($rswrk as $row) {
                        $arwrk = $this->para->Lookup->renderViewRow($row);
                        $this->para->ViewValue->add($this->para->displayValue($arwrk));
                        $ari++;
                    }
                } else {
                    $this->para->ViewValue = $Language->phrase("PleaseSelect");
                }
                $arwrk = $rswrk;
                $this->para->EditValue = $arwrk;
            }
            $this->para->PlaceHolder = RemoveHtml($this->para->caption());

            // adjunto
            $this->adjunto->EditAttrs["class"] = "form-control";
            $this->adjunto->EditCustomAttributes = "";
            if (!EmptyValue($this->adjunto->Upload->DbValue)) {
                $this->adjunto->EditValue = $this->adjunto->Upload->DbValue;
            } else {
                $this->adjunto->EditValue = "";
            }
            if (!EmptyValue($this->adjunto->CurrentValue)) {
                $this->adjunto->Upload->FileName = $this->adjunto->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->adjunto);
            }

            // Edit refer script

            // id_inyect
            $this->id_inyect->LinkCustomAttributes = "";
            $this->id_inyect->HrefValue = "";

            // id_tareas
            $this->id_tareas->LinkCustomAttributes = "";
            $this->id_tareas->HrefValue = "";

            // titulo
            $this->titulo->LinkCustomAttributes = "";
            $this->titulo->HrefValue = "";

            // mensaje
            $this->mensaje->LinkCustomAttributes = "";
            $this->mensaje->HrefValue = "";

            // fechareal_start
            $this->fechareal_start->LinkCustomAttributes = "";
            $this->fechareal_start->HrefValue = "";

            // fechasim_start
            $this->fechasim_start->LinkCustomAttributes = "";
            $this->fechasim_start->HrefValue = "";

            // medios
            $this->medios->LinkCustomAttributes = "";
            $this->medios->HrefValue = "";

            // actividad_esperada
            $this->actividad_esperada->LinkCustomAttributes = "";
            $this->actividad_esperada->HrefValue = "";

            // id_actor
            $this->id_actor->LinkCustomAttributes = "";
            $this->id_actor->HrefValue = "";

            // para
            $this->para->LinkCustomAttributes = "";
            $this->para->HrefValue = "";

            // adjunto
            $this->adjunto->LinkCustomAttributes = "";
            if (!EmptyValue($this->adjunto->Upload->DbValue)) {
                $this->adjunto->HrefValue = GetFileUploadUrl($this->adjunto, $this->adjunto->htmlDecode($this->adjunto->Upload->DbValue)); // Add prefix/suffix
                $this->adjunto->LinkAttrs["target"] = "_blank"; // Add target
                if ($this->isExport()) {
                    $this->adjunto->HrefValue = FullUrl($this->adjunto->HrefValue, "href");
                }
            } else {
                $this->adjunto->HrefValue = "";
            }
            $this->adjunto->ExportHrefValue = $this->adjunto->UploadPath . $this->adjunto->Upload->DbValue;
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
        if ($this->id_inyect->Required) {
            if (!$this->id_inyect->IsDetailKey && EmptyValue($this->id_inyect->FormValue)) {
                $this->id_inyect->addErrorMessage(str_replace("%s", $this->id_inyect->caption(), $this->id_inyect->RequiredErrorMessage));
            }
        }
        if ($this->id_tareas->Required) {
            if (!$this->id_tareas->IsDetailKey && EmptyValue($this->id_tareas->FormValue)) {
                $this->id_tareas->addErrorMessage(str_replace("%s", $this->id_tareas->caption(), $this->id_tareas->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->id_tareas->FormValue)) {
            $this->id_tareas->addErrorMessage($this->id_tareas->getErrorMessage(false));
        }
        if ($this->titulo->Required) {
            if (!$this->titulo->IsDetailKey && EmptyValue($this->titulo->FormValue)) {
                $this->titulo->addErrorMessage(str_replace("%s", $this->titulo->caption(), $this->titulo->RequiredErrorMessage));
            }
        }
        if ($this->mensaje->Required) {
            if (!$this->mensaje->IsDetailKey && EmptyValue($this->mensaje->FormValue)) {
                $this->mensaje->addErrorMessage(str_replace("%s", $this->mensaje->caption(), $this->mensaje->RequiredErrorMessage));
            }
        }
        if ($this->fechareal_start->Required) {
            if (!$this->fechareal_start->IsDetailKey && EmptyValue($this->fechareal_start->FormValue)) {
                $this->fechareal_start->addErrorMessage(str_replace("%s", $this->fechareal_start->caption(), $this->fechareal_start->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->fechareal_start->FormValue)) {
            $this->fechareal_start->addErrorMessage($this->fechareal_start->getErrorMessage(false));
        }
        if ($this->fechasim_start->Required) {
            if (!$this->fechasim_start->IsDetailKey && EmptyValue($this->fechasim_start->FormValue)) {
                $this->fechasim_start->addErrorMessage(str_replace("%s", $this->fechasim_start->caption(), $this->fechasim_start->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->fechasim_start->FormValue)) {
            $this->fechasim_start->addErrorMessage($this->fechasim_start->getErrorMessage(false));
        }
        if ($this->medios->Required) {
            if (!$this->medios->IsDetailKey && EmptyValue($this->medios->FormValue)) {
                $this->medios->addErrorMessage(str_replace("%s", $this->medios->caption(), $this->medios->RequiredErrorMessage));
            }
        }
        if ($this->actividad_esperada->Required) {
            if (!$this->actividad_esperada->IsDetailKey && EmptyValue($this->actividad_esperada->FormValue)) {
                $this->actividad_esperada->addErrorMessage(str_replace("%s", $this->actividad_esperada->caption(), $this->actividad_esperada->RequiredErrorMessage));
            }
        }
        if ($this->id_actor->Required) {
            if (!$this->id_actor->IsDetailKey && EmptyValue($this->id_actor->FormValue)) {
                $this->id_actor->addErrorMessage(str_replace("%s", $this->id_actor->caption(), $this->id_actor->RequiredErrorMessage));
            }
        }
        if ($this->para->Required) {
            if ($this->para->FormValue == "") {
                $this->para->addErrorMessage(str_replace("%s", $this->para->caption(), $this->para->RequiredErrorMessage));
            }
        }
        if ($this->adjunto->Required) {
            if ($this->adjunto->Upload->FileName == "" && !$this->adjunto->Upload->KeepFile) {
                $this->adjunto->addErrorMessage(str_replace("%s", $this->adjunto->caption(), $this->adjunto->RequiredErrorMessage));
            }
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
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // id_tareas
            if ($this->id_tareas->getSessionValue() != "") {
                $this->id_tareas->ReadOnly = true;
            }
            $this->id_tareas->setDbValueDef($rsnew, $this->id_tareas->CurrentValue, null, $this->id_tareas->ReadOnly);

            // titulo
            $this->titulo->setDbValueDef($rsnew, $this->titulo->CurrentValue, null, $this->titulo->ReadOnly);

            // mensaje
            $this->mensaje->setDbValueDef($rsnew, $this->mensaje->CurrentValue, null, $this->mensaje->ReadOnly);

            // fechareal_start
            $this->fechareal_start->setDbValueDef($rsnew, UnFormatDateTime($this->fechareal_start->CurrentValue, 109), null, $this->fechareal_start->ReadOnly);

            // fechasim_start
            $this->fechasim_start->setDbValueDef($rsnew, UnFormatDateTime($this->fechasim_start->CurrentValue, 109), null, $this->fechasim_start->ReadOnly);

            // medios
            $this->medios->setDbValueDef($rsnew, $this->medios->CurrentValue, null, $this->medios->ReadOnly);

            // actividad_esperada
            $this->actividad_esperada->setDbValueDef($rsnew, $this->actividad_esperada->CurrentValue, null, $this->actividad_esperada->ReadOnly);

            // id_actor
            $this->id_actor->setDbValueDef($rsnew, $this->id_actor->CurrentValue, null, $this->id_actor->ReadOnly);

            // para
            $this->para->setDbValueDef($rsnew, $this->para->CurrentValue, null, $this->para->ReadOnly);

            // adjunto
            if ($this->adjunto->Visible && !$this->adjunto->ReadOnly && !$this->adjunto->Upload->KeepFile) {
                $this->adjunto->Upload->DbValue = $rsold['adjunto']; // Get original value
                if ($this->adjunto->Upload->FileName == "") {
                    $rsnew['adjunto'] = null;
                } else {
                    $rsnew['adjunto'] = $this->adjunto->Upload->FileName;
                }
            }

            // Check referential integrity for master table 'tareas'
            $validMasterRecord = true;
            $masterFilter = $this->sqlMasterFilter_tareas();
            $keyValue = $rsnew['id_tareas'] ?? $rsold['id_tareas'];
            if (strval($keyValue) != "") {
                $masterFilter = str_replace("@id_tarea@", AdjustSql($keyValue), $masterFilter);
            } else {
                $validMasterRecord = false;
            }
            if ($validMasterRecord) {
                $rsmaster = Container("tareas")->loadRs($masterFilter)->fetch();
                $validMasterRecord = $rsmaster !== false;
            }
            if (!$validMasterRecord) {
                $relatedRecordMsg = str_replace("%t", "tareas", $Language->phrase("RelatedRecordRequired"));
                $this->setFailureMessage($relatedRecordMsg);
                return false;
            }
            if ($this->adjunto->Visible && !$this->adjunto->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->adjunto->Upload->DbValue) ? [] : [$this->adjunto->htmlDecode($this->adjunto->Upload->DbValue)];
                if (!EmptyValue($this->adjunto->Upload->FileName)) {
                    $newFiles = [$this->adjunto->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->adjunto, $this->adjunto->Upload->Index);
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
                                $file1 = UniqueFilename($this->adjunto->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->adjunto->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->adjunto->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->adjunto->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->adjunto->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->adjunto->setDbValueDef($rsnew, $this->adjunto->Upload->FileName, null, $this->adjunto->ReadOnly);
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
                    if ($this->adjunto->Visible && !$this->adjunto->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->adjunto->Upload->DbValue) ? [] : [$this->adjunto->htmlDecode($this->adjunto->Upload->DbValue)];
                        if (!EmptyValue($this->adjunto->Upload->FileName)) {
                            $newFiles = [$this->adjunto->Upload->FileName];
                            $newFiles2 = [$this->adjunto->htmlDecode($rsnew['adjunto'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->adjunto, $this->adjunto->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->adjunto->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                    @unlink($this->adjunto->oldPhysicalUploadPath() . $oldFile);
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
            // adjunto
            CleanUploadTempPath($this->adjunto, $this->adjunto->Upload->Index);
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
            if ($masterTblVar == "tareas") {
                $validMaster = true;
                $masterTbl = Container("tareas");
                if (($parm = Get("fk_id_tarea", Get("id_tareas"))) !== null) {
                    $masterTbl->id_tarea->setQueryStringValue($parm);
                    $this->id_tareas->setQueryStringValue($masterTbl->id_tarea->QueryStringValue);
                    $this->id_tareas->setSessionValue($this->id_tareas->QueryStringValue);
                    if (!is_numeric($masterTbl->id_tarea->QueryStringValue)) {
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
            if ($masterTblVar == "tareas") {
                $validMaster = true;
                $masterTbl = Container("tareas");
                if (($parm = Post("fk_id_tarea", Post("id_tareas"))) !== null) {
                    $masterTbl->id_tarea->setFormValue($parm);
                    $this->id_tareas->setFormValue($masterTbl->id_tarea->FormValue);
                    $this->id_tareas->setSessionValue($this->id_tareas->FormValue);
                    if (!is_numeric($masterTbl->id_tarea->FormValue)) {
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
            if ($masterTblVar != "tareas") {
                if ($this->id_tareas->CurrentValue == "") {
                    $this->id_tareas->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("MensajesList"), "", $this->TableVar, true);
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
                case "x_medios":
                    break;
                case "x_id_actor":
                    break;
                case "x_para":
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
