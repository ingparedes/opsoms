<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class UsersEdit extends Users
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'users';

    // Page object name
    public $PageObjName = "UsersEdit";

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

        // Table object (users)
        if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == PROJECT_NAMESPACE . "users") {
            $GLOBALS["users"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'users');
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
                $doc = new $class(Container("users"));
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
                    if ($pageName == "UsersView") {
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
            $key .= @$ar['id_users'];
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
            $this->id_users->Visible = false;
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
        $this->id_users->setVisibility();
        $this->fecha->setVisibility();
        $this->nombres->setVisibility();
        $this->apellidos->setVisibility();
        $this->grupo->Visible = false;
        $this->subgrupo->setVisibility();
        $this->perfil->setVisibility();
        $this->_email->setVisibility();
        $this->telefono->setVisibility();
        $this->pais->setVisibility();
        $this->pw->setVisibility();
        $this->estado->setVisibility();
        $this->excon_subgrupo->Visible = false;
        $this->horario->setVisibility();
        $this->limite->setVisibility();
        $this->img_user->setVisibility();
        $this->blocks->Visible = false;
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
        $this->setupLookupOptions($this->grupo);
        $this->setupLookupOptions($this->subgrupo);
        $this->setupLookupOptions($this->perfil);
        $this->setupLookupOptions($this->pais);

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
            if (($keyValue = Get("id_users") ?? Key(0) ?? Route(2)) !== null) {
                $this->id_users->setQueryStringValue($keyValue);
                $this->id_users->setOldValue($this->id_users->QueryStringValue);
            } elseif (Post("id_users") !== null) {
                $this->id_users->setFormValue(Post("id_users"));
                $this->id_users->setOldValue($this->id_users->FormValue);
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
                if (($keyValue = Get("id_users") ?? Route("id_users")) !== null) {
                    $this->id_users->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id_users->CurrentValue = null;
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
                    $this->terminate("UsersList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "UsersList") {
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
        $this->img_user->Upload->Index = $CurrentForm->Index;
        $this->img_user->Upload->uploadFile();
        $this->img_user->CurrentValue = $this->img_user->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id_users' first before field var 'x_id_users'
        $val = $CurrentForm->hasValue("id_users") ? $CurrentForm->getValue("id_users") : $CurrentForm->getValue("x_id_users");
        if (!$this->id_users->IsDetailKey) {
            $this->id_users->setFormValue($val);
        }

        // Check field name 'fecha' first before field var 'x_fecha'
        $val = $CurrentForm->hasValue("fecha") ? $CurrentForm->getValue("fecha") : $CurrentForm->getValue("x_fecha");
        if (!$this->fecha->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->fecha->Visible = false; // Disable update for API request
            } else {
                $this->fecha->setFormValue($val);
            }
            $this->fecha->CurrentValue = UnFormatDateTime($this->fecha->CurrentValue, 5);
        }

        // Check field name 'nombres' first before field var 'x_nombres'
        $val = $CurrentForm->hasValue("nombres") ? $CurrentForm->getValue("nombres") : $CurrentForm->getValue("x_nombres");
        if (!$this->nombres->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombres->Visible = false; // Disable update for API request
            } else {
                $this->nombres->setFormValue($val);
            }
        }

        // Check field name 'apellidos' first before field var 'x_apellidos'
        $val = $CurrentForm->hasValue("apellidos") ? $CurrentForm->getValue("apellidos") : $CurrentForm->getValue("x_apellidos");
        if (!$this->apellidos->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->apellidos->Visible = false; // Disable update for API request
            } else {
                $this->apellidos->setFormValue($val);
            }
        }

        // Check field name 'subgrupo' first before field var 'x_subgrupo'
        $val = $CurrentForm->hasValue("subgrupo") ? $CurrentForm->getValue("subgrupo") : $CurrentForm->getValue("x_subgrupo");
        if (!$this->subgrupo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->subgrupo->Visible = false; // Disable update for API request
            } else {
                $this->subgrupo->setFormValue($val);
            }
        }

        // Check field name 'perfil' first before field var 'x_perfil'
        $val = $CurrentForm->hasValue("perfil") ? $CurrentForm->getValue("perfil") : $CurrentForm->getValue("x_perfil");
        if (!$this->perfil->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->perfil->Visible = false; // Disable update for API request
            } else {
                $this->perfil->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
            }
        }

        // Check field name 'telefono' first before field var 'x_telefono'
        $val = $CurrentForm->hasValue("telefono") ? $CurrentForm->getValue("telefono") : $CurrentForm->getValue("x_telefono");
        if (!$this->telefono->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->telefono->Visible = false; // Disable update for API request
            } else {
                $this->telefono->setFormValue($val);
            }
        }

        // Check field name 'pais' first before field var 'x_pais'
        $val = $CurrentForm->hasValue("pais") ? $CurrentForm->getValue("pais") : $CurrentForm->getValue("x_pais");
        if (!$this->pais->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pais->Visible = false; // Disable update for API request
            } else {
                $this->pais->setFormValue($val);
            }
        }

        // Check field name 'pw' first before field var 'x_pw'
        $val = $CurrentForm->hasValue("pw") ? $CurrentForm->getValue("pw") : $CurrentForm->getValue("x_pw");
        if (!$this->pw->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pw->Visible = false; // Disable update for API request
            } else {
                $this->pw->setFormValue($val);
            }
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

        // Check field name 'horario' first before field var 'x_horario'
        $val = $CurrentForm->hasValue("horario") ? $CurrentForm->getValue("horario") : $CurrentForm->getValue("x_horario");
        if (!$this->horario->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->horario->Visible = false; // Disable update for API request
            } else {
                $this->horario->setFormValue($val);
            }
            $this->horario->CurrentValue = UnFormatDateTime($this->horario->CurrentValue, 0);
        }

        // Check field name 'limite' first before field var 'x_limite'
        $val = $CurrentForm->hasValue("limite") ? $CurrentForm->getValue("limite") : $CurrentForm->getValue("x_limite");
        if (!$this->limite->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->limite->Visible = false; // Disable update for API request
            } else {
                $this->limite->setFormValue($val);
            }
            $this->limite->CurrentValue = UnFormatDateTime($this->limite->CurrentValue, 0);
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id_users->CurrentValue = $this->id_users->FormValue;
        $this->fecha->CurrentValue = $this->fecha->FormValue;
        $this->fecha->CurrentValue = UnFormatDateTime($this->fecha->CurrentValue, 5);
        $this->nombres->CurrentValue = $this->nombres->FormValue;
        $this->apellidos->CurrentValue = $this->apellidos->FormValue;
        $this->subgrupo->CurrentValue = $this->subgrupo->FormValue;
        $this->perfil->CurrentValue = $this->perfil->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->telefono->CurrentValue = $this->telefono->FormValue;
        $this->pais->CurrentValue = $this->pais->FormValue;
        $this->pw->CurrentValue = $this->pw->FormValue;
        $this->estado->CurrentValue = $this->estado->FormValue;
        $this->horario->CurrentValue = $this->horario->FormValue;
        $this->horario->CurrentValue = UnFormatDateTime($this->horario->CurrentValue, 0);
        $this->limite->CurrentValue = $this->limite->FormValue;
        $this->limite->CurrentValue = UnFormatDateTime($this->limite->CurrentValue, 0);
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

        // Check if valid User ID
        if ($res) {
            $res = $this->showOptionLink("edit");
            if (!$res) {
                $userIdMsg = DeniedMessage();
                $this->setFailureMessage($userIdMsg);
            }
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
        $this->img_user->setDbValue($this->img_user->Upload->DbValue);
        $this->blocks->setDbValue($row['blocks']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id_users'] = null;
        $row['fecha'] = null;
        $row['nombres'] = null;
        $row['apellidos'] = null;
        $row['grupo'] = null;
        $row['subgrupo'] = null;
        $row['perfil'] = null;
        $row['email'] = null;
        $row['telefono'] = null;
        $row['pais'] = null;
        $row['pw'] = null;
        $row['estado'] = null;
        $row['excon_subgrupo'] = null;
        $row['horario'] = null;
        $row['limite'] = null;
        $row['img_user'] = null;
        $row['blocks'] = null;
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
        if ($this->RowType == ROWTYPE_VIEW) {
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
        } elseif ($this->RowType == ROWTYPE_EDIT) {
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
            $this->nombres->EditValue = HtmlEncode($this->nombres->CurrentValue);
            $this->nombres->PlaceHolder = RemoveHtml($this->nombres->caption());

            // apellidos
            $this->apellidos->EditAttrs["class"] = "form-control";
            $this->apellidos->EditCustomAttributes = "";
            if (!$this->apellidos->Raw) {
                $this->apellidos->CurrentValue = HtmlDecode($this->apellidos->CurrentValue);
            }
            $this->apellidos->EditValue = HtmlEncode($this->apellidos->CurrentValue);
            $this->apellidos->PlaceHolder = RemoveHtml($this->apellidos->caption());

            // subgrupo
            $this->subgrupo->EditAttrs["class"] = "form-control";
            $this->subgrupo->EditCustomAttributes = "";
            $curVal = trim(strval($this->subgrupo->CurrentValue));
            if ($curVal != "") {
                $this->subgrupo->ViewValue = $this->subgrupo->lookupCacheOption($curVal);
            } else {
                $this->subgrupo->ViewValue = $this->subgrupo->Lookup !== null && is_array($this->subgrupo->Lookup->Options) ? $curVal : null;
            }
            if ($this->subgrupo->ViewValue !== null) { // Load from cache
                $this->subgrupo->EditValue = array_values($this->subgrupo->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_subgrupo`" . SearchString("=", $this->subgrupo->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->subgrupo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->subgrupo->EditValue = $arwrk;
            }
            $this->subgrupo->PlaceHolder = RemoveHtml($this->subgrupo->caption());

            // perfil
            $this->perfil->EditAttrs["class"] = "form-control";
            $this->perfil->EditCustomAttributes = "";
            if (!$Security->canAdmin()) { // System admin
                $this->perfil->EditValue = $Language->phrase("PasswordMask");
            } else {
                $curVal = trim(strval($this->perfil->CurrentValue));
                if ($curVal != "") {
                    $this->perfil->ViewValue = $this->perfil->lookupCacheOption($curVal);
                } else {
                    $this->perfil->ViewValue = $this->perfil->Lookup !== null && is_array($this->perfil->Lookup->Options) ? $curVal : null;
                }
                if ($this->perfil->ViewValue !== null) { // Load from cache
                    $this->perfil->EditValue = array_values($this->perfil->Lookup->Options);
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = "`userlevelid`" . SearchString("=", $this->perfil->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->perfil->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->perfil->EditValue = $arwrk;
                }
                $this->perfil->PlaceHolder = RemoveHtml($this->perfil->caption());
            }

            // email
            $this->_email->EditAttrs["class"] = "form-control";
            $this->_email->EditCustomAttributes = "";
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

            // telefono
            $this->telefono->EditAttrs["class"] = "form-control";
            $this->telefono->EditCustomAttributes = "";
            if (!$this->telefono->Raw) {
                $this->telefono->CurrentValue = HtmlDecode($this->telefono->CurrentValue);
            }
            $this->telefono->EditValue = HtmlEncode($this->telefono->CurrentValue);
            $this->telefono->PlaceHolder = RemoveHtml($this->telefono->caption());

            // pais
            $this->pais->EditAttrs["class"] = "form-control";
            $this->pais->EditCustomAttributes = "";
            $curVal = trim(strval($this->pais->CurrentValue));
            if ($curVal != "") {
                $this->pais->ViewValue = $this->pais->lookupCacheOption($curVal);
            } else {
                $this->pais->ViewValue = $this->pais->Lookup !== null && is_array($this->pais->Lookup->Options) ? $curVal : null;
            }
            if ($this->pais->ViewValue !== null) { // Load from cache
                $this->pais->EditValue = array_values($this->pais->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`codpais`" . SearchString("=", $this->pais->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->pais->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->pais->EditValue = $arwrk;
            }
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

            // horario
            $this->horario->EditAttrs["class"] = "form-control";
            $this->horario->EditCustomAttributes = "";
            $this->horario->EditValue = HtmlEncode(FormatDateTime($this->horario->CurrentValue, 8));
            $this->horario->PlaceHolder = RemoveHtml($this->horario->caption());

            // limite
            $this->limite->EditAttrs["class"] = "form-control";
            $this->limite->EditCustomAttributes = "";
            $this->limite->EditValue = HtmlEncode(FormatDateTime($this->limite->CurrentValue, 8));
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
            if ($this->isShow()) {
                RenderUploadField($this->img_user);
            }

            // Edit refer script

            // id_users
            $this->id_users->LinkCustomAttributes = "";
            $this->id_users->HrefValue = "";

            // fecha
            $this->fecha->LinkCustomAttributes = "";
            $this->fecha->HrefValue = "";

            // nombres
            $this->nombres->LinkCustomAttributes = "";
            $this->nombres->HrefValue = "";

            // apellidos
            $this->apellidos->LinkCustomAttributes = "";
            $this->apellidos->HrefValue = "";

            // subgrupo
            $this->subgrupo->LinkCustomAttributes = "";
            $this->subgrupo->HrefValue = "";

            // perfil
            $this->perfil->LinkCustomAttributes = "";
            $this->perfil->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

            // telefono
            $this->telefono->LinkCustomAttributes = "";
            $this->telefono->HrefValue = "";

            // pais
            $this->pais->LinkCustomAttributes = "";
            $this->pais->HrefValue = "";

            // pw
            $this->pw->LinkCustomAttributes = "";
            $this->pw->HrefValue = "";

            // estado
            $this->estado->LinkCustomAttributes = "";
            $this->estado->HrefValue = "";

            // horario
            $this->horario->LinkCustomAttributes = "";
            $this->horario->HrefValue = "";

            // limite
            $this->limite->LinkCustomAttributes = "";
            $this->limite->HrefValue = "";

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
        if ($this->id_users->Required) {
            if (!$this->id_users->IsDetailKey && EmptyValue($this->id_users->FormValue)) {
                $this->id_users->addErrorMessage(str_replace("%s", $this->id_users->caption(), $this->id_users->RequiredErrorMessage));
            }
        }
        if ($this->fecha->Required) {
            if (!$this->fecha->IsDetailKey && EmptyValue($this->fecha->FormValue)) {
                $this->fecha->addErrorMessage(str_replace("%s", $this->fecha->caption(), $this->fecha->RequiredErrorMessage));
            }
        }
        if ($this->nombres->Required) {
            if (!$this->nombres->IsDetailKey && EmptyValue($this->nombres->FormValue)) {
                $this->nombres->addErrorMessage(str_replace("%s", $this->nombres->caption(), $this->nombres->RequiredErrorMessage));
            }
        }
        if ($this->apellidos->Required) {
            if (!$this->apellidos->IsDetailKey && EmptyValue($this->apellidos->FormValue)) {
                $this->apellidos->addErrorMessage(str_replace("%s", $this->apellidos->caption(), $this->apellidos->RequiredErrorMessage));
            }
        }
        if ($this->subgrupo->Required) {
            if (!$this->subgrupo->IsDetailKey && EmptyValue($this->subgrupo->FormValue)) {
                $this->subgrupo->addErrorMessage(str_replace("%s", $this->subgrupo->caption(), $this->subgrupo->RequiredErrorMessage));
            }
        }
        if ($this->perfil->Required) {
            if (!$this->perfil->IsDetailKey && EmptyValue($this->perfil->FormValue)) {
                $this->perfil->addErrorMessage(str_replace("%s", $this->perfil->caption(), $this->perfil->RequiredErrorMessage));
            }
        }
        if ($this->_email->Required) {
            if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
            }
        }
        if (!CheckEmail($this->_email->FormValue)) {
            $this->_email->addErrorMessage($this->_email->getErrorMessage(false));
        }
        if (!$this->_email->Raw && Config("REMOVE_XSS") && CheckUsername($this->_email->FormValue)) {
            $this->_email->addErrorMessage($Language->phrase("InvalidUsernameChars"));
        }
        if ($this->telefono->Required) {
            if (!$this->telefono->IsDetailKey && EmptyValue($this->telefono->FormValue)) {
                $this->telefono->addErrorMessage(str_replace("%s", $this->telefono->caption(), $this->telefono->RequiredErrorMessage));
            }
        }
        if ($this->pais->Required) {
            if (!$this->pais->IsDetailKey && EmptyValue($this->pais->FormValue)) {
                $this->pais->addErrorMessage(str_replace("%s", $this->pais->caption(), $this->pais->RequiredErrorMessage));
            }
        }
        if ($this->pw->Required) {
            if (!$this->pw->IsDetailKey && EmptyValue($this->pw->FormValue)) {
                $this->pw->addErrorMessage(str_replace("%s", $this->pw->caption(), $this->pw->RequiredErrorMessage));
            }
        }
        if (!$this->pw->Raw && Config("REMOVE_XSS") && CheckPassword($this->pw->FormValue)) {
            $this->pw->addErrorMessage($Language->phrase("InvalidPasswordChars"));
        }
        if ($this->estado->Required) {
            if (!$this->estado->IsDetailKey && EmptyValue($this->estado->FormValue)) {
                $this->estado->addErrorMessage(str_replace("%s", $this->estado->caption(), $this->estado->RequiredErrorMessage));
            }
        }
        if ($this->horario->Required) {
            if (!$this->horario->IsDetailKey && EmptyValue($this->horario->FormValue)) {
                $this->horario->addErrorMessage(str_replace("%s", $this->horario->caption(), $this->horario->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->horario->FormValue)) {
            $this->horario->addErrorMessage($this->horario->getErrorMessage(false));
        }
        if ($this->limite->Required) {
            if (!$this->limite->IsDetailKey && EmptyValue($this->limite->FormValue)) {
                $this->limite->addErrorMessage(str_replace("%s", $this->limite->caption(), $this->limite->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->limite->FormValue)) {
            $this->limite->addErrorMessage($this->limite->getErrorMessage(false));
        }
        if ($this->img_user->Required) {
            if ($this->img_user->Upload->FileName == "" && !$this->img_user->Upload->KeepFile) {
                $this->img_user->addErrorMessage(str_replace("%s", $this->img_user->caption(), $this->img_user->RequiredErrorMessage));
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

            // fecha
            $this->fecha->CurrentValue = CurrentDateTime();
            $this->fecha->setDbValueDef($rsnew, $this->fecha->CurrentValue, null);

            // nombres
            $this->nombres->setDbValueDef($rsnew, $this->nombres->CurrentValue, null, $this->nombres->ReadOnly);

            // apellidos
            $this->apellidos->setDbValueDef($rsnew, $this->apellidos->CurrentValue, null, $this->apellidos->ReadOnly);

            // subgrupo
            $this->subgrupo->setDbValueDef($rsnew, $this->subgrupo->CurrentValue, null, $this->subgrupo->ReadOnly);

            // perfil
            if ($Security->canAdmin()) { // System admin
                $this->perfil->setDbValueDef($rsnew, $this->perfil->CurrentValue, null, $this->perfil->ReadOnly);
            }

            // email
            $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, $this->_email->ReadOnly);

            // telefono
            $this->telefono->setDbValueDef($rsnew, $this->telefono->CurrentValue, null, $this->telefono->ReadOnly);

            // pais
            $this->pais->setDbValueDef($rsnew, $this->pais->CurrentValue, null, $this->pais->ReadOnly);

            // pw
            if (!IsMaskedPassword($this->pw->CurrentValue)) {
                $this->pw->setDbValueDef($rsnew, $this->pw->CurrentValue, null, $this->pw->ReadOnly || Config("ENCRYPTED_PASSWORD") && $rsold['pw'] == $this->pw->CurrentValue);
            }

            // estado
            $this->estado->setDbValueDef($rsnew, $this->estado->CurrentValue, null, $this->estado->ReadOnly);

            // horario
            $this->horario->setDbValueDef($rsnew, UnFormatDateTime($this->horario->CurrentValue, 0), null, $this->horario->ReadOnly);

            // limite
            $this->limite->setDbValueDef($rsnew, UnFormatDateTime($this->limite->CurrentValue, 0), null, $this->limite->ReadOnly);

            // img_user
            if ($this->img_user->Visible && !$this->img_user->ReadOnly && !$this->img_user->Upload->KeepFile) {
                $this->img_user->Upload->DbValue = $rsold['img_user']; // Get original value
                if ($this->img_user->Upload->FileName == "") {
                    $rsnew['img_user'] = null;
                } else {
                    $rsnew['img_user'] = $this->img_user->Upload->FileName;
                }
                $this->img_user->ImageWidth = THUMBNAIL_DEFAULT_WIDTH; // Resize width
                $this->img_user->ImageHeight = THUMBNAIL_DEFAULT_HEIGHT; // Resize height
            }
            if ($this->img_user->Visible && !$this->img_user->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->img_user->Upload->DbValue) ? [] : [$this->img_user->htmlDecode($this->img_user->Upload->DbValue)];
                if (!EmptyValue($this->img_user->Upload->FileName)) {
                    $newFiles = [$this->img_user->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->img_user, $this->img_user->Upload->Index);
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
                                $file1 = UniqueFilename($this->img_user->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->img_user->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->img_user->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->img_user->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->img_user->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->img_user->setDbValueDef($rsnew, $this->img_user->Upload->FileName, null, $this->img_user->ReadOnly);
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
                    if ($this->img_user->Visible && !$this->img_user->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->img_user->Upload->DbValue) ? [] : [$this->img_user->htmlDecode($this->img_user->Upload->DbValue)];
                        if (!EmptyValue($this->img_user->Upload->FileName)) {
                            $newFiles = [$this->img_user->Upload->FileName];
                            $newFiles2 = [$this->img_user->htmlDecode($rsnew['img_user'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->img_user, $this->img_user->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->img_user->Upload->ResizeAndSaveToFile($this->img_user->ImageWidth, $this->img_user->ImageHeight, 100, $newFiles[$i], true, $i)) {
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
                                    @unlink($this->img_user->oldPhysicalUploadPath() . $oldFile);
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
            // img_user
            CleanUploadTempPath($this->img_user, $this->img_user->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Show link optionally based on User ID
    protected function showOptionLink($id = "")
    {
        global $Security;
        if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id)) {
            return $Security->isValidUserID($this->id_users->CurrentValue);
        }
        return true;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("UsersList"), "", $this->TableVar, true);
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
                case "x_grupo":
                    break;
                case "x_subgrupo":
                    break;
                case "x_perfil":
                    break;
                case "x_pais":
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
