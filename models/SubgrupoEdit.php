<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class SubgrupoEdit extends Subgrupo
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'subgrupo';

    // Page object name
    public $PageObjName = "SubgrupoEdit";

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

        // Table object (subgrupo)
        if (!isset($GLOBALS["subgrupo"]) || get_class($GLOBALS["subgrupo"]) == PROJECT_NAMESPACE . "subgrupo") {
            $GLOBALS["subgrupo"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'subgrupo');
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
                $doc = new $class(Container("subgrupo"));
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
                    if ($pageName == "SubgrupoView") {
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
            $key .= @$ar['id_subgrupo'];
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
            $this->id_subgrupo->Visible = false;
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
        $this->id_subgrupo->setVisibility();
        $this->id_grupo->setVisibility();
        $this->imagen_subgrupo->setVisibility();
        $this->nombre_subgrupo->setVisibility();
        $this->descripcion_subgrupo->setVisibility();
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
            if (($keyValue = Get("id_subgrupo") ?? Key(0) ?? Route(2)) !== null) {
                $this->id_subgrupo->setQueryStringValue($keyValue);
                $this->id_subgrupo->setOldValue($this->id_subgrupo->QueryStringValue);
            } elseif (Post("id_subgrupo") !== null) {
                $this->id_subgrupo->setFormValue(Post("id_subgrupo"));
                $this->id_subgrupo->setOldValue($this->id_subgrupo->FormValue);
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
                if (($keyValue = Get("id_subgrupo") ?? Route("id_subgrupo")) !== null) {
                    $this->id_subgrupo->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id_subgrupo->CurrentValue = null;
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
                    $this->terminate("SubgrupoList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "SubgrupoList") {
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
        $this->imagen_subgrupo->Upload->Index = $CurrentForm->Index;
        $this->imagen_subgrupo->Upload->uploadFile();
        $this->imagen_subgrupo->CurrentValue = $this->imagen_subgrupo->Upload->FileName;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id_subgrupo' first before field var 'x_id_subgrupo'
        $val = $CurrentForm->hasValue("id_subgrupo") ? $CurrentForm->getValue("id_subgrupo") : $CurrentForm->getValue("x_id_subgrupo");
        if (!$this->id_subgrupo->IsDetailKey) {
            $this->id_subgrupo->setFormValue($val);
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

        // Check field name 'nombre_subgrupo' first before field var 'x_nombre_subgrupo'
        $val = $CurrentForm->hasValue("nombre_subgrupo") ? $CurrentForm->getValue("nombre_subgrupo") : $CurrentForm->getValue("x_nombre_subgrupo");
        if (!$this->nombre_subgrupo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nombre_subgrupo->Visible = false; // Disable update for API request
            } else {
                $this->nombre_subgrupo->setFormValue($val);
            }
        }

        // Check field name 'descripcion_subgrupo' first before field var 'x_descripcion_subgrupo'
        $val = $CurrentForm->hasValue("descripcion_subgrupo") ? $CurrentForm->getValue("descripcion_subgrupo") : $CurrentForm->getValue("x_descripcion_subgrupo");
        if (!$this->descripcion_subgrupo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->descripcion_subgrupo->Visible = false; // Disable update for API request
            } else {
                $this->descripcion_subgrupo->setFormValue($val);
            }
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id_subgrupo->CurrentValue = $this->id_subgrupo->FormValue;
        $this->id_grupo->CurrentValue = $this->id_grupo->FormValue;
        $this->nombre_subgrupo->CurrentValue = $this->nombre_subgrupo->FormValue;
        $this->descripcion_subgrupo->CurrentValue = $this->descripcion_subgrupo->FormValue;
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
        $this->id_subgrupo->setDbValue($row['id_subgrupo']);
        $this->id_grupo->setDbValue($row['id_grupo']);
        $this->imagen_subgrupo->Upload->DbValue = $row['imagen_subgrupo'];
        $this->imagen_subgrupo->setDbValue($this->imagen_subgrupo->Upload->DbValue);
        $this->nombre_subgrupo->setDbValue($row['nombre_subgrupo']);
        $this->descripcion_subgrupo->setDbValue($row['descripcion_subgrupo']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id_subgrupo'] = null;
        $row['id_grupo'] = null;
        $row['imagen_subgrupo'] = null;
        $row['nombre_subgrupo'] = null;
        $row['descripcion_subgrupo'] = null;
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

        // id_subgrupo

        // id_grupo

        // imagen_subgrupo

        // nombre_subgrupo

        // descripcion_subgrupo
        if ($this->RowType == ROWTYPE_VIEW) {
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
        } elseif ($this->RowType == ROWTYPE_EDIT) {
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
            if ($this->isShow()) {
                RenderUploadField($this->imagen_subgrupo);
            }

            // nombre_subgrupo
            $this->nombre_subgrupo->EditAttrs["class"] = "form-control";
            $this->nombre_subgrupo->EditCustomAttributes = "";
            if (!$this->nombre_subgrupo->Raw) {
                $this->nombre_subgrupo->CurrentValue = HtmlDecode($this->nombre_subgrupo->CurrentValue);
            }
            $this->nombre_subgrupo->EditValue = HtmlEncode($this->nombre_subgrupo->CurrentValue);
            $this->nombre_subgrupo->PlaceHolder = RemoveHtml($this->nombre_subgrupo->caption());

            // descripcion_subgrupo
            $this->descripcion_subgrupo->EditAttrs["class"] = "form-control";
            $this->descripcion_subgrupo->EditCustomAttributes = "";
            $this->descripcion_subgrupo->EditValue = HtmlEncode($this->descripcion_subgrupo->CurrentValue);
            $this->descripcion_subgrupo->PlaceHolder = RemoveHtml($this->descripcion_subgrupo->caption());

            // Edit refer script

            // id_subgrupo
            $this->id_subgrupo->LinkCustomAttributes = "";
            $this->id_subgrupo->HrefValue = "";

            // id_grupo
            $this->id_grupo->LinkCustomAttributes = "";
            $this->id_grupo->HrefValue = "";

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

            // nombre_subgrupo
            $this->nombre_subgrupo->LinkCustomAttributes = "";
            $this->nombre_subgrupo->HrefValue = "";

            // descripcion_subgrupo
            $this->descripcion_subgrupo->LinkCustomAttributes = "";
            $this->descripcion_subgrupo->HrefValue = "";
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
        if ($this->id_subgrupo->Required) {
            if (!$this->id_subgrupo->IsDetailKey && EmptyValue($this->id_subgrupo->FormValue)) {
                $this->id_subgrupo->addErrorMessage(str_replace("%s", $this->id_subgrupo->caption(), $this->id_subgrupo->RequiredErrorMessage));
            }
        }
        if ($this->id_grupo->Required) {
            if (!$this->id_grupo->IsDetailKey && EmptyValue($this->id_grupo->FormValue)) {
                $this->id_grupo->addErrorMessage(str_replace("%s", $this->id_grupo->caption(), $this->id_grupo->RequiredErrorMessage));
            }
        }
        if ($this->imagen_subgrupo->Required) {
            if ($this->imagen_subgrupo->Upload->FileName == "" && !$this->imagen_subgrupo->Upload->KeepFile) {
                $this->imagen_subgrupo->addErrorMessage(str_replace("%s", $this->imagen_subgrupo->caption(), $this->imagen_subgrupo->RequiredErrorMessage));
            }
        }
        if ($this->nombre_subgrupo->Required) {
            if (!$this->nombre_subgrupo->IsDetailKey && EmptyValue($this->nombre_subgrupo->FormValue)) {
                $this->nombre_subgrupo->addErrorMessage(str_replace("%s", $this->nombre_subgrupo->caption(), $this->nombre_subgrupo->RequiredErrorMessage));
            }
        }
        if ($this->descripcion_subgrupo->Required) {
            if (!$this->descripcion_subgrupo->IsDetailKey && EmptyValue($this->descripcion_subgrupo->FormValue)) {
                $this->descripcion_subgrupo->addErrorMessage(str_replace("%s", $this->descripcion_subgrupo->caption(), $this->descripcion_subgrupo->RequiredErrorMessage));
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

            // id_grupo
            if ($this->id_grupo->getSessionValue() != "") {
                $this->id_grupo->ReadOnly = true;
            }
            $this->id_grupo->setDbValueDef($rsnew, $this->id_grupo->CurrentValue, null, $this->id_grupo->ReadOnly);

            // imagen_subgrupo
            if ($this->imagen_subgrupo->Visible && !$this->imagen_subgrupo->ReadOnly && !$this->imagen_subgrupo->Upload->KeepFile) {
                $this->imagen_subgrupo->Upload->DbValue = $rsold['imagen_subgrupo']; // Get original value
                if ($this->imagen_subgrupo->Upload->FileName == "") {
                    $rsnew['imagen_subgrupo'] = null;
                } else {
                    $rsnew['imagen_subgrupo'] = $this->imagen_subgrupo->Upload->FileName;
                }
            }

            // nombre_subgrupo
            $this->nombre_subgrupo->setDbValueDef($rsnew, $this->nombre_subgrupo->CurrentValue, null, $this->nombre_subgrupo->ReadOnly);

            // descripcion_subgrupo
            $this->descripcion_subgrupo->setDbValueDef($rsnew, $this->descripcion_subgrupo->CurrentValue, null, $this->descripcion_subgrupo->ReadOnly);

            // Check referential integrity for master table 'grupo'
            $validMasterRecord = true;
            $masterFilter = $this->sqlMasterFilter_grupo();
            $keyValue = $rsnew['id_grupo'] ?? $rsold['id_grupo'];
            if (strval($keyValue) != "") {
                $masterFilter = str_replace("@id_grupo@", AdjustSql($keyValue), $masterFilter);
            } else {
                $validMasterRecord = false;
            }
            if ($validMasterRecord) {
                $rsmaster = Container("grupo")->loadRs($masterFilter)->fetch();
                $validMasterRecord = $rsmaster !== false;
            }
            if (!$validMasterRecord) {
                $relatedRecordMsg = str_replace("%t", "grupo", $Language->phrase("RelatedRecordRequired"));
                $this->setFailureMessage($relatedRecordMsg);
                return false;
            }
            if ($this->imagen_subgrupo->Visible && !$this->imagen_subgrupo->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->imagen_subgrupo->Upload->DbValue) ? [] : [$this->imagen_subgrupo->htmlDecode($this->imagen_subgrupo->Upload->DbValue)];
                if (!EmptyValue($this->imagen_subgrupo->Upload->FileName)) {
                    $newFiles = [$this->imagen_subgrupo->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->imagen_subgrupo, $this->imagen_subgrupo->Upload->Index);
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
                                $file1 = UniqueFilename($this->imagen_subgrupo->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->imagen_subgrupo->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->imagen_subgrupo->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->imagen_subgrupo->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->imagen_subgrupo->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->imagen_subgrupo->setDbValueDef($rsnew, $this->imagen_subgrupo->Upload->FileName, null, $this->imagen_subgrupo->ReadOnly);
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
                    if ($this->imagen_subgrupo->Visible && !$this->imagen_subgrupo->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->imagen_subgrupo->Upload->DbValue) ? [] : [$this->imagen_subgrupo->htmlDecode($this->imagen_subgrupo->Upload->DbValue)];
                        if (!EmptyValue($this->imagen_subgrupo->Upload->FileName)) {
                            $newFiles = [$this->imagen_subgrupo->Upload->FileName];
                            $newFiles2 = [$this->imagen_subgrupo->htmlDecode($rsnew['imagen_subgrupo'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->imagen_subgrupo, $this->imagen_subgrupo->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->imagen_subgrupo->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                    @unlink($this->imagen_subgrupo->oldPhysicalUploadPath() . $oldFile);
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
            // imagen_subgrupo
            CleanUploadTempPath($this->imagen_subgrupo, $this->imagen_subgrupo->Upload->Index);
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
            if ($masterTblVar == "grupo") {
                $validMaster = true;
                $masterTbl = Container("grupo");
                if (($parm = Get("fk_id_grupo", Get("id_grupo"))) !== null) {
                    $masterTbl->id_grupo->setQueryStringValue($parm);
                    $this->id_grupo->setQueryStringValue($masterTbl->id_grupo->QueryStringValue);
                    $this->id_grupo->setSessionValue($this->id_grupo->QueryStringValue);
                    if (!is_numeric($masterTbl->id_grupo->QueryStringValue)) {
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
            if ($masterTblVar == "grupo") {
                $validMaster = true;
                $masterTbl = Container("grupo");
                if (($parm = Post("fk_id_grupo", Post("id_grupo"))) !== null) {
                    $masterTbl->id_grupo->setFormValue($parm);
                    $this->id_grupo->setFormValue($masterTbl->id_grupo->FormValue);
                    $this->id_grupo->setSessionValue($this->id_grupo->FormValue);
                    if (!is_numeric($masterTbl->id_grupo->FormValue)) {
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
            if ($masterTblVar != "grupo") {
                if ($this->id_grupo->CurrentValue == "") {
                    $this->id_grupo->setSessionValue("");
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("SubgrupoList"), "", $this->TableVar, true);
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
