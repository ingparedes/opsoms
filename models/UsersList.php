<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class UsersList extends Users
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'users';

    // Page object name
    public $PageObjName = "UsersList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fuserslist";
    public $FormActionName = "k_action";
    public $FormBlankRowName = "k_blankrow";
    public $FormKeyCountName = "key_count";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Export URLs
    public $ExportPrintUrl;
    public $ExportHtmlUrl;
    public $ExportExcelUrl;
    public $ExportWordUrl;
    public $ExportXmlUrl;
    public $ExportCsvUrl;
    public $ExportPdfUrl;

    // Custom export
    public $ExportExcelCustom = false;
    public $ExportWordCustom = false;
    public $ExportPdfCustom = false;
    public $ExportEmailCustom = false;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

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

        // Initialize URLs
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->AddUrl = "UsersAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "UsersDelete";
        $this->MultiUpdateUrl = "UsersUpdate";

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

        // List options
        $this->ListOptions = new ListOptions();
        $this->ListOptions->TableVar = $this->TableVar;

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Import options
        $this->ImportOptions = new ListOptions("div");
        $this->ImportOptions->TagClassName = "ew-import-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["addedit"] = new ListOptions("div");
        $this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";

        // Filter options
        $this->FilterOptions = new ListOptions("div");
        $this->FilterOptions->TagClassName = "ew-filter-option fuserslistsrch";

        // List actions
        $this->ListActions = new ListActions();
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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
                        if ($fld->DataType == DATATYPE_MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
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
        if ($this->isAddOrEdit()) {
            $this->fecha->Visible = false;
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

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $DisplayRecords = 10;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchRowCount = 0; // For extended search
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $EditRowCount;
    public $StartRowCount = 1;
    public $RowCount = 0;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $RowAction = ""; // Row action
    public $MultiColumnClass = "col-sm";
    public $MultiColumnEditClass = "w-100";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $OldRecordset;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Create form object
        $CurrentForm = new HttpForm();

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        } elseif (IsPost()) {
            if (Post("exporttype") !== null) {
                $this->Export = Post("exporttype");
            }
            $custom = Post("custom", "");
        } elseif (Get("cmd") == "json") {
            $this->Export = Get("cmd");
        } else {
            $this->setExportReturnUrl(CurrentUrl());
        }
        $ExportFileName = $this->TableVar; // Get export file, used in header

        // Get custom export parameters
        if ($this->isExport() && $custom != "") {
            $this->CustomExport = $this->Export;
            $this->Export = "print";
        }
        $CustomExportType = $this->CustomExport;
        $ExportType = $this->Export; // Get export parameter, used in header

        // Update Export URLs
        if (Config("USE_PHPEXCEL")) {
            $this->ExportExcelCustom = false;
        }
        if (Config("USE_PHPWORD")) {
            $this->ExportWordCustom = false;
        }
        if ($this->ExportExcelCustom) {
            $this->ExportExcelUrl .= "&amp;custom=1";
        }
        if ($this->ExportWordCustom) {
            $this->ExportWordUrl .= "&amp;custom=1";
        }
        if ($this->ExportPdfCustom) {
            $this->ExportPdfUrl .= "&amp;custom=1";
        }
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();

        // Setup export options
        $this->setupExportOptions();

        // Setup import options
        $this->setupImportOptions();
        $this->id_users->setVisibility();
        $this->fecha->setVisibility();
        $this->nombres->setVisibility();
        $this->apellidos->setVisibility();
        $this->grupo->setVisibility();
        $this->subgrupo->setVisibility();
        $this->perfil->setVisibility();
        $this->_email->setVisibility();
        $this->telefono->setVisibility();
        $this->pais->setVisibility();
        $this->pw->Visible = false;
        $this->estado->setVisibility();
        $this->excon_subgrupo->Visible = false;
        $this->horario->Visible = false;
        $this->limite->Visible = false;
        $this->img_user->setVisibility();
        $this->blocks->Visible = false;
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
        }

        // Show checkbox column if multiple action
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE && $listaction->Allow) {
                $this->ListOptions["checkbox"]->Visible = true;
                break;
            }
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->grupo);
        $this->setupLookupOptions($this->subgrupo);
        $this->setupLookupOptions($this->perfil);
        $this->setupLookupOptions($this->pais);

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Process list action first
            if ($this->processListAction()) { // Ajax request
                $this->terminate();
                return;
            }

            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Set up Breadcrumb
            if (!$this->isExport()) {
                $this->setupBreadcrumb();
            }

            // Check QueryString parameters
            if (Get("action") !== null) {
                $this->CurrentAction = Get("action");

                // Clear inline mode
                if ($this->isCancel()) {
                    $this->clearInlineMode();
                }

                // Switch to grid edit mode
                if ($this->isGridEdit()) {
                    $this->gridEditMode();
                }
            } else {
                if (Post("action") !== null) {
                    $this->CurrentAction = Post("action"); // Get action

                    // Process import
                    if ($this->isImport()) {
                        $this->import(Post(Config("API_FILE_TOKEN_NAME")));
                        $this->terminate();
                        return;
                    }

                    // Grid Update
                    if (($this->isGridUpdate() || $this->isGridOverwrite()) && Session(SESSION_INLINE_MODE) == "gridedit") {
                        if ($this->validateGridForm()) {
                            $gridUpdate = $this->gridUpdate();
                        } else {
                            $gridUpdate = false;
                        }
                        if ($gridUpdate) {
                        } else {
                            $this->EventCancelled = true;
                            $this->gridEditMode(); // Stay in Grid edit mode
                        }
                    }
                } elseif (Session(SESSION_INLINE_MODE) == "gridedit") { // Previously in grid edit mode
                    if (Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NO")) !== null) { // Stay in grid edit mode if paging
                        $this->gridEditMode();
                    } else { // Reset grid edit
                        $this->clearInlineMode();
                    }
                }
            }

            // Hide list options
            if ($this->isExport()) {
                $this->ListOptions->hideAllOptions(["sequence"]);
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            } elseif ($this->isGridAdd() || $this->isGridEdit()) {
                $this->ListOptions->hideAllOptions();
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            }

            // Hide options
            if ($this->isExport() || $this->CurrentAction) {
                $this->ExportOptions->hideAllOptions();
                $this->FilterOptions->hideAllOptions();
                $this->ImportOptions->hideAllOptions();
            }

            // Hide other options
            if ($this->isExport()) {
                $this->OtherOptions->hideAllOptions();
            }

            // Show grid delete link for grid add / grid edit
            if ($this->AllowAddDeleteRow) {
                if ($this->isGridAdd() || $this->isGridEdit()) {
                    $item = $this->ListOptions["griddelete"];
                    if ($item) {
                        $item->Visible = true;
                    }
                }
            }

            // Get default search criteria
            AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));

            // Get basic search values
            $this->loadBasicSearchValues();

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
            }

            // Restore search parms from Session if not searching / reset / export
            if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
                $this->restoreSearchParms();
            }

            // Call Recordset SearchValidated event
            $this->recordsetSearchValidated();

            // Set up sorting order
            $this->setupSortOrder();

            // Get basic search criteria
            if (!$this->hasInvalidFields()) {
                $srchBasic = $this->basicSearchWhere();
            }
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 10; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load Sorting Order
        if ($this->Command != "json") {
            $this->loadSortOrder();
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms()) {
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere();
            }
        }

        // Build search criteria
        AddFilter($this->SearchWhere, $srchAdvanced);
        AddFilter($this->SearchWhere, $srchBasic);

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json") {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }

        // Export data only
        if (!$this->CustomExport && in_array($this->Export, array_keys(Config("EXPORT_CLASSES")))) {
            $this->exportData();
            $this->terminate();
            return;
        }
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if (!$this->CurrentAction && $this->TotalRecords == 0) {
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }
        }

        // Search/sort options
        $this->setupSearchSortOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset);
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
            $this->terminate(true);
            return;
        }

        // Set up pager
        $this->Pager = new PrevNextPager($this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

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

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 10; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to Grid Edit mode
    protected function gridEditMode()
    {
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
    }

    // Perform update to grid
    public function gridUpdate()
    {
        global $Language, $CurrentForm;
        $gridUpdate = true;

        // Get old recordset
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($rs = $conn->executeQuery($sql)) {
            $rsold = $rs->fetchAll();
            $rs->closeCursor();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($rsold)) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            return false;
        }

        // Begin transaction
        $conn->beginTransaction();
        $key = "";

        // Update row index and get row key
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $CurrentForm->Index = $rowindex;
            $this->setKey($CurrentForm->getValue($this->OldKeyName));
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));

            // Load all values and keys
            if ($rowaction != "insertdelete") { // Skip insert then deleted rows
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                    //} elseif (!$this->validateForm()) { // Already done in validateGridForm
                    //    $gridUpdate = false; // Form error, reset action
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    break;
                }
            }
        }
        if ($gridUpdate) {
            $conn->commit(); // Commit transaction

            // Get new records
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up update success message
            }
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            $conn->rollback(); // Rollback transaction
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if ($CurrentForm->hasValue("x_nombres") && $CurrentForm->hasValue("o_nombres") && $this->nombres->CurrentValue != $this->nombres->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_apellidos") && $CurrentForm->hasValue("o_apellidos") && $this->apellidos->CurrentValue != $this->apellidos->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_grupo") && $CurrentForm->hasValue("o_grupo") && $this->grupo->CurrentValue != $this->grupo->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_subgrupo") && $CurrentForm->hasValue("o_subgrupo") && $this->subgrupo->CurrentValue != $this->subgrupo->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_perfil") && $CurrentForm->hasValue("o_perfil") && $this->perfil->CurrentValue != $this->perfil->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x__email") && $CurrentForm->hasValue("o__email") && $this->_email->CurrentValue != $this->_email->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_telefono") && $CurrentForm->hasValue("o_telefono") && $this->telefono->CurrentValue != $this->telefono->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_pais") && $CurrentForm->hasValue("o_pais") && $this->pais->CurrentValue != $this->pais->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_estado") && $CurrentForm->hasValue("o_estado") && $this->estado->CurrentValue != $this->estado->OldValue) {
            return false;
        }
        if (!EmptyValue($this->img_user->Upload->Value)) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->getFieldValues("FormValue"); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues($idx)
    {
        global $CurrentForm;

        // Get row based on current index
        $CurrentForm->Index = $idx;
        $rowaction = strval($CurrentForm->getValue($this->FormActionName));
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError()
    {
        $this->id_users->clearErrorMessage();
        $this->fecha->clearErrorMessage();
        $this->nombres->clearErrorMessage();
        $this->apellidos->clearErrorMessage();
        $this->grupo->clearErrorMessage();
        $this->subgrupo->clearErrorMessage();
        $this->perfil->clearErrorMessage();
        $this->_email->clearErrorMessage();
        $this->telefono->clearErrorMessage();
        $this->pais->clearErrorMessage();
        $this->estado->clearErrorMessage();
        $this->img_user->clearErrorMessage();
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->id_users->AdvancedSearch->toJson(), ","); // Field id_users
        $filterList = Concat($filterList, $this->fecha->AdvancedSearch->toJson(), ","); // Field fecha
        $filterList = Concat($filterList, $this->nombres->AdvancedSearch->toJson(), ","); // Field nombres
        $filterList = Concat($filterList, $this->apellidos->AdvancedSearch->toJson(), ","); // Field apellidos
        $filterList = Concat($filterList, $this->grupo->AdvancedSearch->toJson(), ","); // Field grupo
        $filterList = Concat($filterList, $this->subgrupo->AdvancedSearch->toJson(), ","); // Field subgrupo
        $filterList = Concat($filterList, $this->perfil->AdvancedSearch->toJson(), ","); // Field perfil
        $filterList = Concat($filterList, $this->_email->AdvancedSearch->toJson(), ","); // Field email
        $filterList = Concat($filterList, $this->telefono->AdvancedSearch->toJson(), ","); // Field telefono
        $filterList = Concat($filterList, $this->pais->AdvancedSearch->toJson(), ","); // Field pais
        $filterList = Concat($filterList, $this->pw->AdvancedSearch->toJson(), ","); // Field pw
        $filterList = Concat($filterList, $this->estado->AdvancedSearch->toJson(), ","); // Field estado
        $filterList = Concat($filterList, $this->excon_subgrupo->AdvancedSearch->toJson(), ","); // Field excon_subgrupo
        $filterList = Concat($filterList, $this->horario->AdvancedSearch->toJson(), ","); // Field horario
        $filterList = Concat($filterList, $this->limite->AdvancedSearch->toJson(), ","); // Field limite
        $filterList = Concat($filterList, $this->img_user->AdvancedSearch->toJson(), ","); // Field img_user
        $filterList = Concat($filterList, $this->blocks->AdvancedSearch->toJson(), ","); // Field blocks
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        global $UserProfile;
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            $UserProfile->setSearchFilters(CurrentUserName(), "fuserslistsrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field id_users
        $this->id_users->AdvancedSearch->SearchValue = @$filter["x_id_users"];
        $this->id_users->AdvancedSearch->SearchOperator = @$filter["z_id_users"];
        $this->id_users->AdvancedSearch->SearchCondition = @$filter["v_id_users"];
        $this->id_users->AdvancedSearch->SearchValue2 = @$filter["y_id_users"];
        $this->id_users->AdvancedSearch->SearchOperator2 = @$filter["w_id_users"];
        $this->id_users->AdvancedSearch->save();

        // Field fecha
        $this->fecha->AdvancedSearch->SearchValue = @$filter["x_fecha"];
        $this->fecha->AdvancedSearch->SearchOperator = @$filter["z_fecha"];
        $this->fecha->AdvancedSearch->SearchCondition = @$filter["v_fecha"];
        $this->fecha->AdvancedSearch->SearchValue2 = @$filter["y_fecha"];
        $this->fecha->AdvancedSearch->SearchOperator2 = @$filter["w_fecha"];
        $this->fecha->AdvancedSearch->save();

        // Field nombres
        $this->nombres->AdvancedSearch->SearchValue = @$filter["x_nombres"];
        $this->nombres->AdvancedSearch->SearchOperator = @$filter["z_nombres"];
        $this->nombres->AdvancedSearch->SearchCondition = @$filter["v_nombres"];
        $this->nombres->AdvancedSearch->SearchValue2 = @$filter["y_nombres"];
        $this->nombres->AdvancedSearch->SearchOperator2 = @$filter["w_nombres"];
        $this->nombres->AdvancedSearch->save();

        // Field apellidos
        $this->apellidos->AdvancedSearch->SearchValue = @$filter["x_apellidos"];
        $this->apellidos->AdvancedSearch->SearchOperator = @$filter["z_apellidos"];
        $this->apellidos->AdvancedSearch->SearchCondition = @$filter["v_apellidos"];
        $this->apellidos->AdvancedSearch->SearchValue2 = @$filter["y_apellidos"];
        $this->apellidos->AdvancedSearch->SearchOperator2 = @$filter["w_apellidos"];
        $this->apellidos->AdvancedSearch->save();

        // Field grupo
        $this->grupo->AdvancedSearch->SearchValue = @$filter["x_grupo"];
        $this->grupo->AdvancedSearch->SearchOperator = @$filter["z_grupo"];
        $this->grupo->AdvancedSearch->SearchCondition = @$filter["v_grupo"];
        $this->grupo->AdvancedSearch->SearchValue2 = @$filter["y_grupo"];
        $this->grupo->AdvancedSearch->SearchOperator2 = @$filter["w_grupo"];
        $this->grupo->AdvancedSearch->save();

        // Field subgrupo
        $this->subgrupo->AdvancedSearch->SearchValue = @$filter["x_subgrupo"];
        $this->subgrupo->AdvancedSearch->SearchOperator = @$filter["z_subgrupo"];
        $this->subgrupo->AdvancedSearch->SearchCondition = @$filter["v_subgrupo"];
        $this->subgrupo->AdvancedSearch->SearchValue2 = @$filter["y_subgrupo"];
        $this->subgrupo->AdvancedSearch->SearchOperator2 = @$filter["w_subgrupo"];
        $this->subgrupo->AdvancedSearch->save();

        // Field perfil
        $this->perfil->AdvancedSearch->SearchValue = @$filter["x_perfil"];
        $this->perfil->AdvancedSearch->SearchOperator = @$filter["z_perfil"];
        $this->perfil->AdvancedSearch->SearchCondition = @$filter["v_perfil"];
        $this->perfil->AdvancedSearch->SearchValue2 = @$filter["y_perfil"];
        $this->perfil->AdvancedSearch->SearchOperator2 = @$filter["w_perfil"];
        $this->perfil->AdvancedSearch->save();

        // Field email
        $this->_email->AdvancedSearch->SearchValue = @$filter["x__email"];
        $this->_email->AdvancedSearch->SearchOperator = @$filter["z__email"];
        $this->_email->AdvancedSearch->SearchCondition = @$filter["v__email"];
        $this->_email->AdvancedSearch->SearchValue2 = @$filter["y__email"];
        $this->_email->AdvancedSearch->SearchOperator2 = @$filter["w__email"];
        $this->_email->AdvancedSearch->save();

        // Field telefono
        $this->telefono->AdvancedSearch->SearchValue = @$filter["x_telefono"];
        $this->telefono->AdvancedSearch->SearchOperator = @$filter["z_telefono"];
        $this->telefono->AdvancedSearch->SearchCondition = @$filter["v_telefono"];
        $this->telefono->AdvancedSearch->SearchValue2 = @$filter["y_telefono"];
        $this->telefono->AdvancedSearch->SearchOperator2 = @$filter["w_telefono"];
        $this->telefono->AdvancedSearch->save();

        // Field pais
        $this->pais->AdvancedSearch->SearchValue = @$filter["x_pais"];
        $this->pais->AdvancedSearch->SearchOperator = @$filter["z_pais"];
        $this->pais->AdvancedSearch->SearchCondition = @$filter["v_pais"];
        $this->pais->AdvancedSearch->SearchValue2 = @$filter["y_pais"];
        $this->pais->AdvancedSearch->SearchOperator2 = @$filter["w_pais"];
        $this->pais->AdvancedSearch->save();

        // Field pw
        $this->pw->AdvancedSearch->SearchValue = @$filter["x_pw"];
        $this->pw->AdvancedSearch->SearchOperator = @$filter["z_pw"];
        $this->pw->AdvancedSearch->SearchCondition = @$filter["v_pw"];
        $this->pw->AdvancedSearch->SearchValue2 = @$filter["y_pw"];
        $this->pw->AdvancedSearch->SearchOperator2 = @$filter["w_pw"];
        $this->pw->AdvancedSearch->save();

        // Field estado
        $this->estado->AdvancedSearch->SearchValue = @$filter["x_estado"];
        $this->estado->AdvancedSearch->SearchOperator = @$filter["z_estado"];
        $this->estado->AdvancedSearch->SearchCondition = @$filter["v_estado"];
        $this->estado->AdvancedSearch->SearchValue2 = @$filter["y_estado"];
        $this->estado->AdvancedSearch->SearchOperator2 = @$filter["w_estado"];
        $this->estado->AdvancedSearch->save();

        // Field excon_subgrupo
        $this->excon_subgrupo->AdvancedSearch->SearchValue = @$filter["x_excon_subgrupo"];
        $this->excon_subgrupo->AdvancedSearch->SearchOperator = @$filter["z_excon_subgrupo"];
        $this->excon_subgrupo->AdvancedSearch->SearchCondition = @$filter["v_excon_subgrupo"];
        $this->excon_subgrupo->AdvancedSearch->SearchValue2 = @$filter["y_excon_subgrupo"];
        $this->excon_subgrupo->AdvancedSearch->SearchOperator2 = @$filter["w_excon_subgrupo"];
        $this->excon_subgrupo->AdvancedSearch->save();

        // Field horario
        $this->horario->AdvancedSearch->SearchValue = @$filter["x_horario"];
        $this->horario->AdvancedSearch->SearchOperator = @$filter["z_horario"];
        $this->horario->AdvancedSearch->SearchCondition = @$filter["v_horario"];
        $this->horario->AdvancedSearch->SearchValue2 = @$filter["y_horario"];
        $this->horario->AdvancedSearch->SearchOperator2 = @$filter["w_horario"];
        $this->horario->AdvancedSearch->save();

        // Field limite
        $this->limite->AdvancedSearch->SearchValue = @$filter["x_limite"];
        $this->limite->AdvancedSearch->SearchOperator = @$filter["z_limite"];
        $this->limite->AdvancedSearch->SearchCondition = @$filter["v_limite"];
        $this->limite->AdvancedSearch->SearchValue2 = @$filter["y_limite"];
        $this->limite->AdvancedSearch->SearchOperator2 = @$filter["w_limite"];
        $this->limite->AdvancedSearch->save();

        // Field img_user
        $this->img_user->AdvancedSearch->SearchValue = @$filter["x_img_user"];
        $this->img_user->AdvancedSearch->SearchOperator = @$filter["z_img_user"];
        $this->img_user->AdvancedSearch->SearchCondition = @$filter["v_img_user"];
        $this->img_user->AdvancedSearch->SearchValue2 = @$filter["y_img_user"];
        $this->img_user->AdvancedSearch->SearchOperator2 = @$filter["w_img_user"];
        $this->img_user->AdvancedSearch->save();

        // Field blocks
        $this->blocks->AdvancedSearch->SearchValue = @$filter["x_blocks"];
        $this->blocks->AdvancedSearch->SearchOperator = @$filter["z_blocks"];
        $this->blocks->AdvancedSearch->SearchCondition = @$filter["v_blocks"];
        $this->blocks->AdvancedSearch->SearchValue2 = @$filter["y_blocks"];
        $this->blocks->AdvancedSearch->SearchOperator2 = @$filter["w_blocks"];
        $this->blocks->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->nombres, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->apellidos, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->_email, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->telefono, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->pais, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->pw, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->estado, $arKeywords, $type);
        return $where;
    }

    // Build basic search SQL
    protected function buildBasicSearchSql(&$where, &$fld, $arKeywords, $type)
    {
        $defCond = ($type == "OR") ? "OR" : "AND";
        $arSql = []; // Array for SQL parts
        $arCond = []; // Array for search conditions
        $cnt = count($arKeywords);
        $j = 0; // Number of SQL parts
        for ($i = 0; $i < $cnt; $i++) {
            $keyword = $arKeywords[$i];
            $keyword = trim($keyword);
            if (Config("BASIC_SEARCH_IGNORE_PATTERN") != "") {
                $keyword = preg_replace(Config("BASIC_SEARCH_IGNORE_PATTERN"), "\\", $keyword);
                $ar = explode("\\", $keyword);
            } else {
                $ar = [$keyword];
            }
            foreach ($ar as $keyword) {
                if ($keyword != "") {
                    $wrk = "";
                    if ($keyword == "OR" && $type == "") {
                        if ($j > 0) {
                            $arCond[$j - 1] = "OR";
                        }
                    } elseif ($keyword == Config("NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NULL";
                    } elseif ($keyword == Config("NOT_NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NOT NULL";
                    } elseif ($fld->IsVirtual && $fld->Visible) {
                        $wrk = $fld->VirtualExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    } elseif ($fld->DataType != DATATYPE_NUMBER || is_numeric($keyword)) {
                        $wrk = $fld->BasicSearchExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    }
                    if ($wrk != "") {
                        $arSql[$j] = $wrk;
                        $arCond[$j] = $defCond;
                        $j += 1;
                    }
                }
            }
        }
        $cnt = count($arSql);
        $quoted = false;
        $sql = "";
        if ($cnt > 0) {
            for ($i = 0; $i < $cnt - 1; $i++) {
                if ($arCond[$i] == "OR") {
                    if (!$quoted) {
                        $sql .= "(";
                    }
                    $quoted = true;
                }
                $sql .= $arSql[$i];
                if ($quoted && $arCond[$i] != "OR") {
                    $sql .= ")";
                    $quoted = false;
                }
                $sql .= " " . $arCond[$i] . " ";
            }
            $sql .= $arSql[$cnt - 1];
            if ($quoted) {
                $sql .= ")";
            }
        }
        if ($sql != "") {
            if ($where != "") {
                $where .= " OR ";
            }
            $where .= "(" . $sql . ")";
        }
    }

    // Return basic search WHERE clause based on search keyword and type
    protected function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $searchKeyword = ($default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = ($default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            // Search keyword in any fields
            if (($searchType == "OR" || $searchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
                foreach ($ar as $keyword) {
                    if ($keyword != "") {
                        if ($searchStr != "") {
                            $searchStr .= " " . $searchType . " ";
                        }
                        $searchStr .= "(" . $this->basicSearchSql([$keyword], $searchType) . ")";
                    }
                }
            } else {
                $searchStr = $this->basicSearchSql($ar, $searchType);
            }
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear basic search parameters
        $this->resetBasicSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->id_users); // id_users
            $this->updateSort($this->fecha); // fecha
            $this->updateSort($this->nombres); // nombres
            $this->updateSort($this->apellidos); // apellidos
            $this->updateSort($this->grupo); // grupo
            $this->updateSort($this->subgrupo); // subgrupo
            $this->updateSort($this->perfil); // perfil
            $this->updateSort($this->_email); // email
            $this->updateSort($this->telefono); // telefono
            $this->updateSort($this->pais); // pais
            $this->updateSort($this->estado); // estado
            $this->updateSort($this->img_user); // img_user
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($useDefaultSort) {
                    $orderBy = $this->getSqlOrderBy();
                    $this->setSessionOrderBy($orderBy);
                } else {
                    $this->setSessionOrderBy("");
                }
            }
        }
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->id_users->setSort("");
                $this->fecha->setSort("");
                $this->nombres->setSort("");
                $this->apellidos->setSort("");
                $this->grupo->setSort("");
                $this->subgrupo->setSort("");
                $this->perfil->setSort("");
                $this->_email->setSort("");
                $this->telefono->setSort("");
                $this->pais->setSort("");
                $this->pw->setSort("");
                $this->estado->setSort("");
                $this->excon_subgrupo->setSort("");
                $this->horario->setSort("");
                $this->limite->setSort("");
                $this->img_user->setSort("");
                $this->blocks->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = false;
            $item->Visible = false; // Default hidden
        }

        // Add group option item
        $item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
        $item->Body = "";
        $item->OnLeft = false;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = false;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = false;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = false;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = false;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = false;
        $item->Header = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"custom-control-input\" onclick=\"ew.selectAllKey(this);\"><label class=\"custom-control-label\" for=\"key\"></label></div>";
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = true;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $this->setupListOptionsExt();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->isGridAdd() || $this->isGridEdit()) {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (!$Security->canDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" onclick=\"return ew.deleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }
        $pageUrl = $this->pageUrl();
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView() && $this->showOptionLink("view")) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit() && $this->showOptionLink("edit")) {
                if (IsMobile()) {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
                } else {
                    $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . $editcaption . "\" data-table=\"users\" data-caption=\"" . $editcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,btn:'SaveBtn',url:'" . HtmlEncode(GetUrl($this->EditUrl)) . "'});\">" . $Language->phrase("EditLink") . "</a>";
                }
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete() && $this->showOptionLink("delete")) {
            $opt->Body = "<a class=\"ew-row-link ew-delete\"" . "" . " title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("DeleteLink") . "</a>";
            } else {
                $opt->Body = "";
            }
        } // End View mode

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions->Items as $listaction) {
                if ($listaction->Select == ACTION_SINGLE && $listaction->Allow) {
                    $action = $listaction->Action;
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listaction->Icon)) . "\" data-caption=\"" . HtmlTitle($caption) . "\"></i> " : "";
                    $links[] = "<li><a class=\"dropdown-item ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a></li>";
                    if (count($links) == 1) { // Single button
                        $body = "<a class=\"ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a>";
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = "";
                foreach ($links as $link) {
                    $content .= "<li>" . $link . "</li>";
                }
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
                $opt->Visible = true;
            }
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->id_users->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("AddLink"));
        if (IsMobile()) {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-table=\"users\" data-caption=\"" . $addcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,btn:'AddBtn',url:'" . HtmlEncode(GetUrl($this->AddUrl)) . "'});\">" . $Language->phrase("AddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();

        // Add grid edit
        $option = $options["addedit"];
        $item = &$option->add("gridedit");
        $item->Body = "<a class=\"ew-add-edit ew-grid-edit\" title=\"" . HtmlTitle($Language->phrase("GridEditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->GridEditUrl)) . "\">" . $Language->phrase("GridEditLink") . "</a>";
        $item->Visible = $this->GridEditUrl != "" && $Security->canEdit();
        $option = $options["action"];

        // Set up options default
        foreach ($options as $option) {
            $option->UseDropDownButton = false;
            $option->UseButtonGroup = true;
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->add($option->GroupOptionName);
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fuserslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fuserslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->add($this->FilterOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        if (!$this->isGridAdd() && !$this->isGridEdit()) { // Not grid add/edit mode
            $option = $options["action"];
            // Set up list action buttons
            foreach ($this->ListActions->Items as $listaction) {
                if ($listaction->Select == ACTION_MULTIPLE) {
                    $item = &$option->add("custom_" . $listaction->Action);
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? '<i class="' . HtmlEncode($listaction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                    $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fuserslist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
                    $item->Visible = $listaction->Allow;
                }
            }

            // Hide grid edit and other options
            if ($this->TotalRecords <= 0) {
                $option = $options["addedit"];
                $item = $option["gridedit"];
                if ($item) {
                    $item->Visible = false;
                }
                $option = $options["action"];
                $option->hideAllOptions();
            }
        } else { // Grid add/edit mode
            // Hide all options first
            foreach ($options as $option) {
                $option->hideAllOptions();
            }
            $pageUrl = $this->pageUrl();

            // Grid-Edit
            if ($this->isGridEdit()) {
                if ($this->AllowAddDeleteRow) {
                    // Add add blank row
                    $option = $options["addedit"];
                    $option->UseDropDownButton = false;
                    $item = &$option->add("addblankrow");
                    $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
                    $item->Visible = $Security->canAdd();
                }
                $option = $options["action"];
                $option->UseDropDownButton = false;
                    $item = &$option->add("gridsave");
                    $item->Body = "<a class=\"ew-action ew-grid-save\" title=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" href=\"#\" onclick=\"ew.forms.get(this).submit(event, '" . $this->pageName() . "'); return false;\">" . $Language->phrase("GridSaveLink") . "</a>";
                    $item = &$option->add("gridcancel");
                    $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                    $item->Body = "<a class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("GridCancelLink") . "</a>";
            }
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security;
        $userlist = "";
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("useraction", "");
        if ($filter != "" && $userAction != "") {
            // Check permission first
            $actionCaption = $userAction;
            if (array_key_exists($userAction, $this->ListActions->Items)) {
                $actionCaption = $this->ListActions[$userAction]->Caption;
                if (!$this->ListActions[$userAction]->Allow) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            }
            $this->CurrentFilter = $filter;
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = LoadRecordset($sql, $conn, \PDO::FETCH_ASSOC);
            $this->CurrentAction = $userAction;

            // Call row action event
            if ($rs) {
                $conn->beginTransaction();
                $this->SelectedCount = $rs->recordCount();
                $this->SelectedIndex = 0;
                while (!$rs->EOF) {
                    $this->SelectedIndex++;
                    $row = $rs->fields;
                    $user = GetUserInfo(Config("LOGIN_USERNAME_FIELD_NAME"), $row);
                    if ($userlist != "") {
                        $userlist .= ",";
                    }
                    $userlist .= $user;
                    if ($userAction == "resendregisteremail") {
                        $processed = false;
                    } elseif ($userAction == "resetconcurrentuser") {
                        $processed = false;
                    } elseif ($userAction == "resetloginretry") {
                        $processed = false;
                    } elseif ($userAction == "setpasswordexpired") {
                        $processed = false;
                    } else {
                        $processed = $this->rowCustomAction($userAction, $row);
                     }
                    if (!$processed) {
                        break;
                    }
                    $rs->moveNext();
                }
                if ($processed) {
                    $conn->commit(); // Commit the changes
                    if ($this->getSuccessMessage() == "" && !ob_get_length()) { // No output
                        $this->setSuccessMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    $conn->rollback(); // Rollback changes

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if ($rs) {
                $rs->close();
            }
            $this->CurrentAction = ""; // Clear action
            if (Post("ajax") == $userAction) { // Ajax
                if ($this->getSuccessMessage() != "") {
                    echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                    $this->clearSuccessMessage(); // Clear message
                }
                if ($this->getFailureMessage() != "") {
                    echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                    $this->clearFailureMessage(); // Clear message
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Set up list options (extended codes)
    protected function setupListOptionsExt()
    {
        // Hide detail items for dropdown if necessary
        $this->ListOptions->hideDetailItemsForDropDown();
    }

    // Render list options (extended codes)
    protected function renderListOptionsExt()
    {
        global $Security, $Language;
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->img_user->Upload->Index = $CurrentForm->Index;
        $this->img_user->Upload->uploadFile();
        $this->img_user->CurrentValue = $this->img_user->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id_users->CurrentValue = null;
        $this->id_users->OldValue = $this->id_users->CurrentValue;
        $this->fecha->CurrentValue = null;
        $this->fecha->OldValue = $this->fecha->CurrentValue;
        $this->nombres->CurrentValue = null;
        $this->nombres->OldValue = $this->nombres->CurrentValue;
        $this->apellidos->CurrentValue = null;
        $this->apellidos->OldValue = $this->apellidos->CurrentValue;
        $this->grupo->CurrentValue = null;
        $this->grupo->OldValue = $this->grupo->CurrentValue;
        $this->subgrupo->CurrentValue = null;
        $this->subgrupo->OldValue = $this->subgrupo->CurrentValue;
        $this->perfil->CurrentValue = null;
        $this->perfil->OldValue = $this->perfil->CurrentValue;
        $this->_email->CurrentValue = null;
        $this->_email->OldValue = $this->_email->CurrentValue;
        $this->telefono->CurrentValue = null;
        $this->telefono->OldValue = $this->telefono->CurrentValue;
        $this->pais->CurrentValue = null;
        $this->pais->OldValue = $this->pais->CurrentValue;
        $this->pw->CurrentValue = null;
        $this->pw->OldValue = $this->pw->CurrentValue;
        $this->estado->CurrentValue = null;
        $this->estado->OldValue = $this->estado->CurrentValue;
        $this->excon_subgrupo->CurrentValue = null;
        $this->excon_subgrupo->OldValue = $this->excon_subgrupo->CurrentValue;
        $this->horario->CurrentValue = null;
        $this->horario->OldValue = $this->horario->CurrentValue;
        $this->limite->CurrentValue = null;
        $this->limite->OldValue = $this->limite->CurrentValue;
        $this->img_user->Upload->DbValue = null;
        $this->img_user->OldValue = $this->img_user->Upload->DbValue;
        $this->blocks->CurrentValue = null;
        $this->blocks->OldValue = $this->blocks->CurrentValue;
    }

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id_users' first before field var 'x_id_users'
        $val = $CurrentForm->hasValue("id_users") ? $CurrentForm->getValue("id_users") : $CurrentForm->getValue("x_id_users");
        if (!$this->id_users->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
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

        // Check field name 'grupo' first before field var 'x_grupo'
        $val = $CurrentForm->hasValue("grupo") ? $CurrentForm->getValue("grupo") : $CurrentForm->getValue("x_grupo");
        if (!$this->grupo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->grupo->Visible = false; // Disable update for API request
            } else {
                $this->grupo->setFormValue($val);
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
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->id_users->CurrentValue = $this->id_users->FormValue;
        }
        $this->fecha->CurrentValue = $this->fecha->FormValue;
        $this->fecha->CurrentValue = UnFormatDateTime($this->fecha->CurrentValue, 5);
        $this->nombres->CurrentValue = $this->nombres->FormValue;
        $this->apellidos->CurrentValue = $this->apellidos->FormValue;
        $this->grupo->CurrentValue = $this->grupo->FormValue;
        $this->subgrupo->CurrentValue = $this->subgrupo->FormValue;
        $this->perfil->CurrentValue = $this->perfil->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
        $this->telefono->CurrentValue = $this->telefono->FormValue;
        $this->pais->CurrentValue = $this->pais->FormValue;
        $this->estado->CurrentValue = $this->estado->FormValue;
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
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
            if (!$this->EventCancelled) {
                $this->HashValue = $this->getRowHash($row); // Get hash value for record
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
        $this->loadDefaultValues();
        $row = [];
        $row['id_users'] = $this->id_users->CurrentValue;
        $row['fecha'] = $this->fecha->CurrentValue;
        $row['nombres'] = $this->nombres->CurrentValue;
        $row['apellidos'] = $this->apellidos->CurrentValue;
        $row['grupo'] = $this->grupo->CurrentValue;
        $row['subgrupo'] = $this->subgrupo->CurrentValue;
        $row['perfil'] = $this->perfil->CurrentValue;
        $row['email'] = $this->_email->CurrentValue;
        $row['telefono'] = $this->telefono->CurrentValue;
        $row['pais'] = $this->pais->CurrentValue;
        $row['pw'] = $this->pw->CurrentValue;
        $row['estado'] = $this->estado->CurrentValue;
        $row['excon_subgrupo'] = $this->excon_subgrupo->CurrentValue;
        $row['horario'] = $this->horario->CurrentValue;
        $row['limite'] = $this->limite->CurrentValue;
        $row['img_user'] = $this->img_user->Upload->DbValue;
        $row['blocks'] = $this->blocks->CurrentValue;
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
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

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

            // estado
            $this->estado->LinkCustomAttributes = "";
            $this->estado->HrefValue = "";
            $this->estado->TooltipValue = "";

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
                $this->img_user->LinkAttrs["data-rel"] = "users_x" . $this->RowCount . "_img_user";
                $this->img_user->LinkAttrs->appendClass("ew-lightbox");
            }
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id_users

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

            // grupo
            $this->grupo->EditAttrs["class"] = "form-control";
            $this->grupo->EditCustomAttributes = "";
            $curVal = trim(strval($this->grupo->CurrentValue));
            if ($curVal != "") {
                $this->grupo->ViewValue = $this->grupo->lookupCacheOption($curVal);
            } else {
                $this->grupo->ViewValue = $this->grupo->Lookup !== null && is_array($this->grupo->Lookup->Options) ? $curVal : null;
            }
            if ($this->grupo->ViewValue !== null) { // Load from cache
                $this->grupo->EditValue = array_values($this->grupo->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_grupo`" . SearchString("=", $this->grupo->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->grupo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->grupo->EditValue = $arwrk;
            }
            $this->grupo->PlaceHolder = RemoveHtml($this->grupo->caption());

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

            // estado
            $this->estado->EditAttrs["class"] = "form-control";
            $this->estado->EditCustomAttributes = "";
            $this->estado->EditValue = $this->estado->options(true);
            $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

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
                if ($this->RowIndex == '$rowindex$') {
                    $this->img_user->Upload->FileName = "";
                } else {
                    $this->img_user->Upload->FileName = $this->img_user->CurrentValue;
                }
            }
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->img_user, $this->RowIndex);
            }

            // Add refer script

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

            // grupo
            $this->grupo->LinkCustomAttributes = "";
            $this->grupo->HrefValue = "";

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

            // estado
            $this->estado->LinkCustomAttributes = "";
            $this->estado->HrefValue = "";

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

            // grupo
            $this->grupo->EditAttrs["class"] = "form-control";
            $this->grupo->EditCustomAttributes = "";
            $curVal = trim(strval($this->grupo->CurrentValue));
            if ($curVal != "") {
                $this->grupo->ViewValue = $this->grupo->lookupCacheOption($curVal);
            } else {
                $this->grupo->ViewValue = $this->grupo->Lookup !== null && is_array($this->grupo->Lookup->Options) ? $curVal : null;
            }
            if ($this->grupo->ViewValue !== null) { // Load from cache
                $this->grupo->EditValue = array_values($this->grupo->Lookup->Options);
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = "`id_grupo`" . SearchString("=", $this->grupo->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->grupo->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->grupo->EditValue = $arwrk;
            }
            $this->grupo->PlaceHolder = RemoveHtml($this->grupo->caption());

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

            // estado
            $this->estado->EditAttrs["class"] = "form-control";
            $this->estado->EditCustomAttributes = "";
            $this->estado->EditValue = $this->estado->options(true);
            $this->estado->PlaceHolder = RemoveHtml($this->estado->caption());

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
                if ($this->RowIndex == '$rowindex$') {
                    $this->img_user->Upload->FileName = "";
                } else {
                    $this->img_user->Upload->FileName = $this->img_user->CurrentValue;
                }
            }
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->img_user, $this->RowIndex);
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

            // grupo
            $this->grupo->LinkCustomAttributes = "";
            $this->grupo->HrefValue = "";

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

            // estado
            $this->estado->LinkCustomAttributes = "";
            $this->estado->HrefValue = "";

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
        if ($this->grupo->Required) {
            if (!$this->grupo->IsDetailKey && EmptyValue($this->grupo->FormValue)) {
                $this->grupo->addErrorMessage(str_replace("%s", $this->grupo->caption(), $this->grupo->RequiredErrorMessage));
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
        if ($this->estado->Required) {
            if (!$this->estado->IsDetailKey && EmptyValue($this->estado->FormValue)) {
                $this->estado->addErrorMessage(str_replace("%s", $this->estado->caption(), $this->estado->RequiredErrorMessage));
            }
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

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $deleteRows = true;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAll($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }

        // Clone old rows
        $rsold = $rows;

        // Call row deleting event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $deleteRows = $this->rowDeleting($row);
                if (!$deleteRows) {
                    break;
                }
            }
        }
        if ($deleteRows) {
            $key = "";
            foreach ($rsold as $row) {
                $thisKey = "";
                if ($thisKey != "") {
                    $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
                }
                $thisKey .= $row['id_users'];
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }
                $deleteRows = $this->delete($row); // Delete
                if ($deleteRows === false) {
                    break;
                }
                if ($key != "") {
                    $key .= ", ";
                }
                $key .= $thisKey;
            }
        }
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }

        // Call Row Deleted event
        if ($deleteRows) {
            foreach ($rsold as $row) {
                $this->rowDeleted($row);
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
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

            // grupo
            $this->grupo->setDbValueDef($rsnew, $this->grupo->CurrentValue, null, $this->grupo->ReadOnly);

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

            // estado
            $this->estado->setDbValueDef($rsnew, $this->estado->CurrentValue, null, $this->estado->ReadOnly);

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

    /**
     * Import file
     *
     * @param string $filetoken File token to locate the uploaded import file
     * @return bool
     */
    public function import($filetoken)
    {
        global $Security, $Language;
        if (!$Security->canImport()) {
            return false; // Import not allowed
        }

        // Check if valid token
        if (EmptyValue($filetoken)) {
            return false;
        }

        // Get uploaded files by token
        $files = GetUploadedFileNames($filetoken);
        $exts = explode(",", Config("IMPORT_FILE_ALLOWED_EXT"));
        $totCnt = 0;
        $totSuccessCnt = 0;
        $totFailCnt = 0;
        $result = [Config("API_FILE_TOKEN_NAME") => $filetoken, "files" => [], "success" => false];

        // Import records
        foreach ($files as $file) {
            $res = [Config("API_FILE_TOKEN_NAME") => $filetoken, "file" => basename($file)];
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            // Ignore log file
            if ($ext == "txt") {
                continue;
            }
            if (!in_array($ext, $exts)) {
                $res = array_merge($res, ["error" => str_replace("%e", $ext, $Language->phrase("ImportMessageInvalidFileExtension"))]);
                WriteJson($res);
                return false;
            }

            // Set up options for Page Importing event

            // Get optional data from $_POST first
            $ar = array_keys($_POST);
            $options = [];
            foreach ($ar as $key) {
                if (!in_array($key, ["action", "filetoken"])) {
                    $options[$key] = $_POST[$key];
                }
            }

            // Merge default options
            $options = array_merge(["maxExecutionTime" => $this->ImportMaxExecutionTime, "file" => $file, "activeSheet" => 0, "headerRowNumber" => 0, "headers" => [], "offset" => 0, "limit" => 0], $options);
            if ($ext == "csv") {
                $options = array_merge(["inputEncoding" => $this->ImportCsvEncoding, "delimiter" => $this->ImportCsvDelimiter, "enclosure" => $this->ImportCsvQuoteCharacter], $options);
            }
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader(ucfirst($ext));

            // Call Page Importing server event
            if (!$this->pageImporting($reader, $options)) {
                WriteJson($res);
                return false;
            }

            // Set max execution time
            if ($options["maxExecutionTime"] > 0) {
                ini_set("max_execution_time", $options["maxExecutionTime"]);
            }
            try {
                if ($ext == "csv") {
                    if ($options["inputEncoding"] != '') {
                        $reader->setInputEncoding($options["inputEncoding"]);
                    }
                    if ($options["delimiter"] != '') {
                        $reader->setDelimiter($options["delimiter"]);
                    }
                    if ($options["enclosure"] != '') {
                        $reader->setEnclosure($options["enclosure"]);
                    }
                }
                $spreadsheet = @$reader->load($file);
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                $res = array_merge($res, ["error" => $e->getMessage()]);
                WriteJson($res);
                return false;
            }

            // Get active worksheet
            $spreadsheet->setActiveSheetIndex($options["activeSheet"]);
            $worksheet = $spreadsheet->getActiveSheet();

            // Get row and column indexes
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

            // Get column headers
            $headers = $options["headers"];
            $headerRow = 0;
            if (count($headers) == 0) { // Undetermined, load from header row
                $headerRow = $options["headerRowNumber"] + 1;
                $headers = $this->getImportHeaders($worksheet, $headerRow, $highestColumn);
            }
            if (count($headers) == 0) { // Unable to load header
                $res["error"] = $Language->phrase("ImportMessageNoHeaderRow");
                WriteJson($res);
                return false;
            }
            foreach ($headers as $name) {
                if (!array_key_exists($name, $this->Fields)) { // Unidentified field, not header row
                    $res["error"] = str_replace('%f', $name, $Language->phrase("ImportMessageInvalidFieldName"));
                    WriteJson($res);
                    return false;
                }
            }
            $startRow = $headerRow + 1;
            $endRow = $highestRow;
            if ($options["offset"] > 0) {
                $startRow += $options["offset"];
            }
            if ($options["limit"] > 0) {
                $endRow = $startRow + $options["limit"] - 1;
                if ($endRow > $highestRow) {
                    $endRow = $highestRow;
                }
            }
            if ($endRow >= $startRow) {
                $records = $this->getImportRecords($worksheet, $startRow, $endRow, $highestColumn);
            } else {
                $records = [];
            }
            $recordCnt = count($records);
            $cnt = 0;
            $successCnt = 0;
            $failCnt = 0;
            $failList = [];
            $relLogFile = IncludeTrailingDelimiter(UploadPath(false) . Config("UPLOAD_TEMP_FOLDER_PREFIX") . $filetoken, false) . $filetoken . ".txt";
            $res = array_merge($res, ["totalCount" => $recordCnt, "count" => $cnt, "successCount" => $successCnt, "failCount" => 0]);

            // Begin transaction
            if ($this->ImportUseTransaction) {
                $conn = $this->getConnection();
                $conn->beginTransaction();
            }

            // Process records
            foreach ($records as $values) {
                $importSuccess = false;
                try {
                    $row = array_combine($headers, $values);
                    $cnt++;
                    $res["count"] = $cnt;
                    if ($this->importRow($row, $cnt)) {
                        $successCnt++;
                        $importSuccess = true;
                    } else {
                        $failCnt++;
                        $failList["row" . $cnt] = $this->getFailureMessage();
                        $this->clearFailureMessage(); // Clear error message
                    }
                } catch (\Throwable $e) {
                    $failCnt++;
                    if ($failList["row" . $cnt] == "") {
                        $failList["row" . $cnt] = $e->getMessage();
                    }
                }

                // Reset count if import fail + use transaction
                if (!$importSuccess && $this->ImportUseTransaction) {
                    $successCnt = 0;
                    $failCnt = $cnt;
                }

                // Save progress to cache
                $res["successCount"] = $successCnt;
                $res["failCount"] = $failCnt;
                SetCache($filetoken, $res);

                // No need to process further if import fail + use transaction
                if (!$importSuccess && $this->ImportUseTransaction) {
                    break;
                }
            }
            $res["failList"] = $failList;

            // Commit/Rollback transaction
            if ($this->ImportUseTransaction) {
                $conn = $this->getConnection();
                if ($failCnt > 0) { // Rollback
                    $conn->rollback();
                } else { // Commit
                    $conn->commit();
                }
            }
            $totCnt += $cnt;
            $totSuccessCnt += $successCnt;
            $totFailCnt += $failCnt;

            // Call Page Imported server event
            $this->pageImported($reader, $res);
            if ($totCnt > 0 && $totFailCnt == 0) { // Clean up if all records imported
                $res["success"] = true;
                $result["success"] = true;
            } else {
                $res["log"] = $relLogFile;
                $result["success"] = false;
            }
            $result["files"][] = $res;
        }
        if ($result["success"]) {
            CleanUploadTempPaths($filetoken);
        }
        WriteJson($result);
        return $result["success"];
    }

    /**
     * Get import header
     *
     * @param object $ws PhpSpreadsheet worksheet
     * @param int $rowIdx Row index for header row (1-based)
     * @param string $endColName End column Name (e.g. "F")
     * @return array
     */
    protected function getImportHeaders($ws, $rowIdx, $endColName)
    {
        $ar = $ws->rangeToArray("A" . $rowIdx . ":" . $endColName . $rowIdx);
        return $ar[0];
    }

    /**
     * Get import records
     *
     * @param object $ws PhpSpreadsheet worksheet
     * @param int $startRowIdx Start row index
     * @param int $endRowIdx End row index
     * @param string $endColName End column Name (e.g. "F")
     * @return array
     */
    protected function getImportRecords($ws, $startRowIdx, $endRowIdx, $endColName)
    {
        $ar = $ws->rangeToArray("A" . $startRowIdx . ":" . $endColName . $endRowIdx);
        return $ar;
    }

    /**
     * Import a row
     *
     * @param array $row
     * @param int $cnt
     * @return bool
     */
    protected function importRow($row, $cnt)
    {
        global $Language;

        // Call Row Import server event
        if (!$this->rowImport($row, $cnt)) {
            return false;
        }

        // Check field values
        foreach ($row as $name => $value) {
            $fld = $this->Fields[$name];
            if (!$this->checkValue($fld, $value)) {
                $this->setFailureMessage(str_replace(["%f", "%v"], [$fld->Name, $value], $Language->phrase("ImportMessageInvalidFieldValue")));
                return false;
            }
        }

        // Insert/Update to database
        if (!$this->ImportInsertOnly && $oldrow = $this->load($row)) {
            $res = $this->update($row, "", $oldrow);
        } else {
            $res = $this->insert($row);
        }
        return $res;
    }

    /**
     * Check field value
     *
     * @param object $fld Field object
     * @param object $value
     * @return bool
     */
    protected function checkValue($fld, $value)
    {
        if ($fld->DataType == DATATYPE_NUMBER && !is_numeric($value)) {
            return false;
        } elseif ($fld->DataType == DATATYPE_DATE && !CheckDate($value)) {
            return false;
        }
        return true;
    }

    // Load row
    protected function load($row)
    {
        $filter = $this->getRecordFilter($row);
        if (!$filter) {
            return null;
        }
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        return $conn->fetchAssoc($sql);
    }

    // Load row hash
    protected function loadRowHash()
    {
        $filter = $this->getRecordFilter();

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $row = $conn->fetchAssoc($sql);
        $this->HashValue = $row ? $this->getRowHash($row) : ""; // Get hash value for record
    }

    // Get Row Hash
    public function getRowHash(&$rs)
    {
        if (!$rs) {
            return "";
        }
        $row = ($rs instanceof Recordset) ? $rs->fields : $rs;
        $hash = "";
        $hash .= GetFieldHash($row['fecha']); // fecha
        $hash .= GetFieldHash($row['nombres']); // nombres
        $hash .= GetFieldHash($row['apellidos']); // apellidos
        $hash .= GetFieldHash($row['grupo']); // grupo
        $hash .= GetFieldHash($row['subgrupo']); // subgrupo
        $hash .= GetFieldHash($row['perfil']); // perfil
        $hash .= GetFieldHash($row['email']); // email
        $hash .= GetFieldHash($row['telefono']); // telefono
        $hash .= GetFieldHash($row['pais']); // pais
        $hash .= GetFieldHash($row['estado']); // estado
        $hash .= GetFieldHash($row['img_user']); // img_user
        return md5($hash);
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Check if valid User ID
        $validUser = false;
        if ($Security->currentUserID() != "" && !EmptyValue($this->id_users->CurrentValue) && !$Security->isAdmin()) { // Non system admin
            $validUser = $Security->isValidUserID($this->id_users->CurrentValue);
            if (!$validUser) {
                $userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
                $userIdMsg = str_replace("%u", $this->id_users->CurrentValue, $userIdMsg);
                $this->setFailureMessage($userIdMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // fecha
        $this->fecha->CurrentValue = CurrentDateTime();
        $this->fecha->setDbValueDef($rsnew, $this->fecha->CurrentValue, null);

        // nombres
        $this->nombres->setDbValueDef($rsnew, $this->nombres->CurrentValue, null, false);

        // apellidos
        $this->apellidos->setDbValueDef($rsnew, $this->apellidos->CurrentValue, null, false);

        // grupo
        $this->grupo->setDbValueDef($rsnew, $this->grupo->CurrentValue, null, strval($this->grupo->CurrentValue) == "");

        // subgrupo
        $this->subgrupo->setDbValueDef($rsnew, $this->subgrupo->CurrentValue, null, strval($this->subgrupo->CurrentValue) == "");

        // perfil
        if ($Security->canAdmin()) { // System admin
            $this->perfil->setDbValueDef($rsnew, $this->perfil->CurrentValue, null, false);
        }

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, false);

        // telefono
        $this->telefono->setDbValueDef($rsnew, $this->telefono->CurrentValue, null, false);

        // pais
        $this->pais->setDbValueDef($rsnew, $this->pais->CurrentValue, null, false);

        // estado
        $this->estado->setDbValueDef($rsnew, $this->estado->CurrentValue, null, false);

        // img_user
        if ($this->img_user->Visible && !$this->img_user->Upload->KeepFile) {
            $this->img_user->Upload->DbValue = ""; // No need to delete old file
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
                $this->img_user->setDbValueDef($rsnew, $this->img_user->Upload->FileName, null, false);
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
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
            // img_user
            CleanUploadTempPath($this->img_user, $this->img_user->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl();
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" onclick=\"return ew.export(document.fuserslist, '" . $this->ExportExcelUrl . "', 'excel', true);\">" . $Language->phrase("ExportToExcel") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" onclick=\"return ew.export(document.fuserslist, '" . $this->ExportWordUrl . "', 'word', true);\">" . $Language->phrase("ExportToWord") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportWordUrl . "\" class=\"ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<a href=\"#\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" onclick=\"return ew.export(document.fuserslist, '" . $this->ExportPdfUrl . "', 'pdf', true);\">" . $Language->phrase("ExportToPDF") . "</a>";
            } else {
                return "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPDFText")) . "\">" . $Language->phrase("ExportToPDF") . "</a>";
            }
        } elseif (SameText($type, "html")) {
            return "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ew-export-link ew-html\" title=\"" . HtmlEncode($Language->phrase("ExportToHtmlText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToHtmlText")) . "\">" . $Language->phrase("ExportToHtml") . "</a>";
        } elseif (SameText($type, "xml")) {
            return "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ew-export-link ew-xml\" title=\"" . HtmlEncode($Language->phrase("ExportToXmlText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToXmlText")) . "\">" . $Language->phrase("ExportToXml") . "</a>";
        } elseif (SameText($type, "csv")) {
            return "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ew-export-link ew-csv\" title=\"" . HtmlEncode($Language->phrase("ExportToCsvText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToCsvText")) . "\">" . $Language->phrase("ExportToCsv") . "</a>";
        } elseif (SameText($type, "email")) {
            $url = $custom ? ",url:'" . $pageUrl . "export=email&amp;custom=1'" : "";
            return '<button id="emf_users" class="ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" onclick="ew.emailDialogShow({lnk:\'emf_users\', hdr:ew.language.phrase(\'ExportToEmailText\'), f:document.fuserslist, sel:false' . $url . '});">' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("PrinterFriendlyText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("PrinterFriendlyText")) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = false;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        $item->Visible = true;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = false;

        // Export to Html
        $item = &$this->ExportOptions->add("html");
        $item->Body = $this->getExportTag("html");
        $item->Visible = false;

        // Export to Xml
        $item = &$this->ExportOptions->add("xml");
        $item->Body = $this->getExportTag("xml");
        $item->Visible = false;

        // Export to Csv
        $item = &$this->ExportOptions->add("csv");
        $item->Body = $this->getExportTag("csv");
        $item->Visible = false;

        // Export to Pdf
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        $item->Visible = false;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = false;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->add($this->ExportOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
    }

    // Set up search/sort options
    protected function setupSearchSortOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl();
        $this->SearchOptions = new ListOptions("div");
        $this->SearchOptions->TagClassName = "ew-search-option";

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fuserslistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->add($this->SearchOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction) {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Set up import options
    protected function setupImportOptions()
    {
        global $Security, $Language;

        // Import
        $item = &$this->ImportOptions->add("import");
        $item->Body = "<a class=\"ew-import-link ew-import\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("ImportText") . "\" data-caption=\"" . $Language->phrase("ImportText") . "\" onclick=\"return ew.importDialogShow({lnk:this,hdr:ew.language.phrase('ImportText')});\">" . $Language->phrase("Import") . "</a>";
        $item->Visible = $Security->canImport();
        $this->ImportOptions->UseButtonGroup = true;
        $this->ImportOptions->UseDropDownButton = false;
        $this->ImportOptions->DropDownButtonPhrase = $Language->phrase("ButtonImport");

        // Add group option item
        $item = &$this->ImportOptions->add($this->ImportOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
    }

    /**
    * Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
    *
    * @param bool $return Return the data rather than output it
    * @return mixed
    */
    public function exportData($return = false)
    {
        global $Language;
        $utf8 = SameText(Config("PROJECT_CHARSET"), "utf-8");

        // Load recordset
        $this->TotalRecords = $this->listRecordCount();
        $this->StartRecord = 1;

        // Export all
        if ($this->ExportAll) {
            if (Config("EXPORT_ALL_TIME_LIMIT") >= 0) {
                @set_time_limit(Config("EXPORT_ALL_TIME_LIMIT"));
            }
            $this->DisplayRecords = $this->TotalRecords;
            $this->StopRecord = $this->TotalRecords;
        } else { // Export one page only
            $this->setupStartRecord(); // Set up start record position
            // Set the last record to display
            if ($this->DisplayRecords <= 0) {
                $this->StopRecord = $this->TotalRecords;
            } else {
                $this->StopRecord = $this->StartRecord + $this->DisplayRecords - 1;
            }
        }
        $rs = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords);
        $this->ExportDoc = GetExportDocument($this, "h");
        $doc = &$this->ExportDoc;
        if (!$doc) {
            $this->setFailureMessage($Language->phrase("ExportClassNotFound")); // Export class not found
        }
        if (!$rs || !$doc) {
            RemoveHeader("Content-Type"); // Remove header
            RemoveHeader("Content-Disposition");
            $this->showMessage();
            return;
        }
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords;

        // Call Page Exporting server event
        $this->ExportDoc->ExportCustom = !$this->pageExporting();
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        $doc->Text .= $header;
        $this->exportDocument($doc, $rs, $this->StartRecord, $this->StopRecord, "");
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        $doc->Text .= $footer;

        // Close recordset
        $rs->close();

        // Call Page Exported server event
        $this->pageExported();

        // Export header and footer
        $doc->exportHeaderAndFooter();

        // Clean output buffer (without destroying output buffer)
        $buffer = ob_get_contents(); // Save the output buffer
        if (!Config("DEBUG") && $buffer) {
            ob_clean();
        }

        // Write debug message if enabled
        if (Config("DEBUG") && !$this->isExport("pdf")) {
            echo GetDebugMessage();
        }

        // Output data
        if ($this->isExport("email")) {
            // Export-to-email disabled
        } else {
            $doc->export();
            if ($return) {
                RemoveHeader("Content-Type"); // Remove header
                RemoveHeader("Content-Disposition");
                $content = ob_get_contents();
                if ($content) {
                    ob_clean();
                }
                if ($buffer) {
                    echo $buffer; // Resume the output buffer
                }
                return $content;
            }
        }
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
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
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
        if ($this->CurrentAction == "gridedit") 
    {
    $this->email->Visible = FALSE;
    $this->telefono->Visible = FALSE;
    $this->pais->Visible = FALSE;
    $this->pw->Visible = FALSE;
    $this->img_user->Visible = FALSE;
    $this->perfil->Visible = FALSE;
    }}

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

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->Add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->MoveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
        return true;
    }

    // Page Exporting event
    // $this->ExportDoc = export document object
    public function pageExporting()
    {
        //$this->ExportDoc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $this->ExportDoc = export document object
    public function rowExport($rs)
    {
        //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $this->ExportDoc = export document object
    public function pageExported()
    {
        //$this->ExportDoc->Text .= "my footer"; // Export footer
        //Log($this->ExportDoc->Text);
    }

    // Page Importing event
    public function pageImporting($reader, &$options)
    {
        //var_dump($reader); // Import data reader
        //var_dump($options); // Show all options for importing
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($reader, $results)
    {
        //var_dump($reader); // Import data reader
        //var_dump($results); // Import results
    }
}
