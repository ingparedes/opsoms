<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class TareasGrid extends Tareas
{
    use MessagesTrait;

    // Page ID
    public $PageID = "grid";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'tareas';

    // Page object name
    public $PageObjName = "TareasGrid";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "ftareasgrid";
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
        $this->FormActionName .= "_" . $this->FormName;
        $this->OldKeyName .= "_" . $this->FormName;
        $this->FormBlankRowName .= "_" . $this->FormName;
        $this->FormKeyCountName .= "_" . $this->FormName;
        $GLOBALS["Grid"] = &$this;

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
        $this->AddUrl = "TareasAdd";

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

        // List options
        $this->ListOptions = new ListOptions();
        $this->ListOptions->TableVar = $this->TableVar;

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["addedit"] = new ListOptions("div");
        $this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
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
        unset($GLOBALS["Grid"]);
        if ($url === "") {
            return;
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

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
    public $ShowOtherOptions = false;
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

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->id_tarea->setVisibility();
        $this->id_escenario->Visible = false;
        $this->id_grupo->setVisibility();
        $this->titulo_tarea->setVisibility();
        $this->descripcion_tarea->Visible = false;
        $this->fechainireal_tarea->setVisibility();
        $this->fechafin_tarea->setVisibility();
        $this->fechainisimulado_tarea->setVisibility();
        $this->fechafinsimulado_tarea->setVisibility();
        $this->id_tarearelacion->Visible = false;
        $this->archivo->Visible = false;
        $this->id_subgrupo->Visible = false;
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up master detail parameters
        $this->setupMasterParms();

        // Setup other options
        $this->setupOtherOptions();

        // Set up lookup cache
        $this->setupLookupOptions($this->id_grupo);
        $this->setupLookupOptions($this->id_tarearelacion);

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

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

            // Show grid delete link for grid add / grid edit
            if ($this->AllowAddDeleteRow) {
                if ($this->isGridAdd() || $this->isGridEdit()) {
                    $item = $this->ListOptions["griddelete"];
                    if ($item) {
                        $item->Visible = true;
                    }
                }
            }

            // Set up sorting order
            $this->setupSortOrder();
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

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }

        // Restore master/detail filter
        $this->DbMasterFilter = $this->getMasterFilter(); // Restore master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Restore detail filter
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Load master record
        if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "escenario") {
            $masterTbl = Container("escenario");
            $rsmaster = $masterTbl->loadRs($this->DbMasterFilter)->fetch(\PDO::FETCH_ASSOC);
            $this->MasterRecordExists = $rsmaster !== false;
            if (!$this->MasterRecordExists) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
                $this->terminate("EscenarioList"); // Return to master page
                return;
            } else {
                $masterTbl->loadListRowValues($rsmaster);
                $masterTbl->RowType = ROWTYPE_MASTER; // Master row
                $masterTbl->renderListRow();
            }
        }

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }
        if ($this->isGridAdd()) {
            if ($this->CurrentMode == "copy") {
                $this->TotalRecords = $this->listRecordCount();
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->TotalRecords;
                $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
            } else {
                $this->CurrentFilter = "0=1";
                $this->StartRecord = 1;
                $this->DisplayRecords = $this->GridAddRowCount;
            }
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->TotalRecords; // Display all records
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
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

    // Switch to Grid Add mode
    protected function gridAddMode()
    {
        $this->CurrentAction = "gridadd";
        $_SESSION[SESSION_INLINE_MODE] = "gridadd";
        $this->hideFieldsForAddEdit();
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
            // Get new records
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
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

    // Perform Grid Add
    public function gridInsert()
    {
        global $Language, $CurrentForm;
        $rowindex = 1;
        $gridInsert = false;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            return false;
        }

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        $key = "";

        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success

                // Validate form // Already done in validateGridForm
                //if (!$this->validateForm()) {
                //    $gridInsert = false; // Form error, reset action
                //} else {
                    $gridInsert = $this->addRow($this->OldRecordset); // Insert this row
                //}
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->id_tarea->CurrentValue;

                    // Add filter for this record
                    $filter = $this->getRecordFilter();
                    if ($wrkfilter != "") {
                        $wrkfilter .= " OR ";
                    }
                    $wrkfilter .= $filter;
                } else {
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->clearInlineMode(); // Clear grid add mode and return
            return true;
        }
        if ($gridInsert) {
            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAll($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            $this->clearInlineMode(); // Clear grid add mode
        } else {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if ($CurrentForm->hasValue("x_id_grupo") && $CurrentForm->hasValue("o_id_grupo") && $this->id_grupo->CurrentValue != $this->id_grupo->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_titulo_tarea") && $CurrentForm->hasValue("o_titulo_tarea") && $this->titulo_tarea->CurrentValue != $this->titulo_tarea->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_fechainireal_tarea") && $CurrentForm->hasValue("o_fechainireal_tarea") && $this->fechainireal_tarea->CurrentValue != $this->fechainireal_tarea->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_fechafin_tarea") && $CurrentForm->hasValue("o_fechafin_tarea") && $this->fechafin_tarea->CurrentValue != $this->fechafin_tarea->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_fechainisimulado_tarea") && $CurrentForm->hasValue("o_fechainisimulado_tarea") && $this->fechainisimulado_tarea->CurrentValue != $this->fechainisimulado_tarea->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_fechafinsimulado_tarea") && $CurrentForm->hasValue("o_fechafinsimulado_tarea") && $this->fechafinsimulado_tarea->CurrentValue != $this->fechafinsimulado_tarea->OldValue) {
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
        $this->id_tarea->clearErrorMessage();
        $this->id_grupo->clearErrorMessage();
        $this->titulo_tarea->clearErrorMessage();
        $this->fechainireal_tarea->clearErrorMessage();
        $this->fechafin_tarea->clearErrorMessage();
        $this->fechainisimulado_tarea->clearErrorMessage();
        $this->fechafinsimulado_tarea->clearErrorMessage();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "`fechainireal_tarea` DESC";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($this->fechainireal_tarea->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($useDefaultSort) {
                    $this->fechainireal_tarea->setSort("DESC");
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
            // Reset master/detail keys
            if ($this->Command == "resetall") {
                $this->setCurrentMasterTable(""); // Clear master table
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
                        $this->id_escenario->setSessionValue("");
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
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

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
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
            if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
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
        if ($this->CurrentMode == "view") {
            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
            $opt->Body = "<a class=\"ew-row-link ew-delete\"" . "" . " title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("DeleteLink") . "</a>";
            } else {
                $opt->Body = "";
            }
        } // End View mode
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $option = $this->OtherOptions["addedit"];
        $option->UseDropDownButton = false;
        $option->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $option->UseButtonGroup = true;
        //$option->ButtonClass = ""; // Class for button group
        $item = &$option->add($option->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Add
        if ($this->CurrentMode == "view") { // Check view mode
            $item = &$option->add("add");
            $addcaption = HtmlTitle($Language->phrase("AddLink"));
            $this->AddUrl = $this->getAddUrl();
            $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
            $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        }
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && !$this->isConfirm()) { // Check add/copy/edit mode
            if ($this->AllowAddDeleteRow) {
                $option = $options["addedit"];
                $option->UseDropDownButton = false;
                $item = &$option->add("addblankrow");
                $item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
                $item->Visible = $Security->canAdd();
                $this->ShowOtherOptions = $item->Visible;
            }
        }
        if ($this->CurrentMode == "view") { // Check view mode
            $option = $options["addedit"];
            $item = $option["add"];
            $this->ShowOtherOptions = $item && $item->Visible;
        }
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
        $links = "";
        $btngrps = "";
        $sqlwrk = "`id_tareas`=" . AdjustSql($this->id_tarea->CurrentValue, $this->Dbid) . "";

        // Column "detail_mensajes"
        if ($this->DetailPages && $this->DetailPages["mensajes"] && $this->DetailPages["mensajes"]->Visible) {
            $link = "";
            $option = $this->ListOptions["detail_mensajes"];
            $url = "MensajesPreview?t=tareas&f=" . Encrypt($sqlwrk);
            $btngrp = "<div data-table=\"mensajes\" data-url=\"" . $url . "\" class=\"btn-group btn-group-sm\">";
            if ($Security->allowList(CurrentProjectID() . 'tareas')) {
                $label = $Language->TablePhrase("mensajes", "TblCaption");
                $link = "<li class=\"nav-item\"><a href=\"#\" class=\"nav-link\" data-toggle=\"tab\" data-table=\"mensajes\" data-url=\"" . $url . "\">" . $label . "</a></li>";
                $links .= $link;
                $detaillnk = JsEncodeAttribute("MensajesList?" . Config("TABLE_SHOW_MASTER") . "=tareas&" . GetForeignKeyUrl("fk_id_tarea", $this->id_tarea->CurrentValue) . "");
                $btngrp .= "<button type=\"button\" class=\"btn btn-default\" title=\"" . $Language->TablePhrase("mensajes", "TblCaption") . "\" onclick=\"window.location='" . $detaillnk . "';return false;\">" . $Language->phrase("MasterDetailListLink") . "</button>";
            }
            $detailPageObj = Container("MensajesGrid");
            if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'tareas')) {
                $caption = $Language->phrase("MasterDetailViewLink");
                $url = $this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=mensajes");
                $btngrp .= "<button type=\"button\" class=\"btn btn-default\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</button>";
            }
            if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'tareas')) {
                $caption = $Language->phrase("MasterDetailEditLink");
                $url = $this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=mensajes");
                $btngrp .= "<button type=\"button\" class=\"btn btn-default\" title=\"" . HtmlTitle($caption) . "\" onclick=\"window.location='" . HtmlEncode($url) . "';return false;\">" . $caption . "</button>";
            }
            $btngrp .= "</div>";
            if ($link != "") {
                $btngrps .= $btngrp;
                $option->Body .= "<div class=\"d-none ew-preview\">" . $link . $btngrp . "</div>";
            }
        }

        // Hide detail items if necessary
        $this->ListOptions->hideDetailItemsForDropDown();

        // Column "preview"
        $option = $this->ListOptions["preview"];
        if (!$option) { // Add preview column
            $option = &$this->ListOptions->add("preview");
            $option->OnLeft = false;
            if ($option->OnLeft) {
                $option->moveTo($this->ListOptions->itemPos("checkbox") + 1);
            } else {
                $option->moveTo($this->ListOptions->itemPos("checkbox"));
            }
            $option->Visible = !($this->isExport() || $this->isGridAdd() || $this->isGridEdit());
            $option->ShowInDropDown = false;
            $option->ShowInButtonGroup = false;
        }
        if ($option) {
            $option->Body = "<i class=\"ew-preview-row-btn ew-icon icon-expand\"></i>";
            $option->Body .= "<div class=\"d-none ew-preview\">" . $links . $btngrps . "</div>";
            if ($option->Visible) {
                $option->Visible = $links != "";
            }
        }

        // Column "details" (Multiple details)
        $option = $this->ListOptions["details"];
        if ($option) {
            $option->Body .= "<div class=\"d-none ew-preview\">" . $links . $btngrps . "</div>";
            if ($option->Visible) {
                $option->Visible = $links != "";
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id_tarea->CurrentValue = null;
        $this->id_tarea->OldValue = $this->id_tarea->CurrentValue;
        $this->id_escenario->CurrentValue = null;
        $this->id_escenario->OldValue = $this->id_escenario->CurrentValue;
        $this->id_grupo->CurrentValue = null;
        $this->id_grupo->OldValue = $this->id_grupo->CurrentValue;
        $this->titulo_tarea->CurrentValue = null;
        $this->titulo_tarea->OldValue = $this->titulo_tarea->CurrentValue;
        $this->descripcion_tarea->CurrentValue = null;
        $this->descripcion_tarea->OldValue = $this->descripcion_tarea->CurrentValue;
        $this->fechainireal_tarea->CurrentValue = null;
        $this->fechainireal_tarea->OldValue = $this->fechainireal_tarea->CurrentValue;
        $this->fechafin_tarea->CurrentValue = null;
        $this->fechafin_tarea->OldValue = $this->fechafin_tarea->CurrentValue;
        $this->fechainisimulado_tarea->CurrentValue = null;
        $this->fechainisimulado_tarea->OldValue = $this->fechainisimulado_tarea->CurrentValue;
        $this->fechafinsimulado_tarea->CurrentValue = null;
        $this->fechafinsimulado_tarea->OldValue = $this->fechafinsimulado_tarea->CurrentValue;
        $this->id_tarearelacion->CurrentValue = null;
        $this->id_tarearelacion->OldValue = $this->id_tarearelacion->CurrentValue;
        $this->archivo->Upload->DbValue = null;
        $this->archivo->OldValue = $this->archivo->Upload->DbValue;
        $this->archivo->Upload->Index = $this->RowIndex;
        $this->id_subgrupo->CurrentValue = null;
        $this->id_subgrupo->OldValue = $this->id_subgrupo->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $CurrentForm->FormName = $this->FormName;

        // Check field name 'id_tarea' first before field var 'x_id_tarea'
        $val = $CurrentForm->hasValue("id_tarea") ? $CurrentForm->getValue("id_tarea") : $CurrentForm->getValue("x_id_tarea");
        if (!$this->id_tarea->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->id_tarea->setFormValue($val);
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
        if ($CurrentForm->hasValue("o_id_grupo")) {
            $this->id_grupo->setOldValue($CurrentForm->getValue("o_id_grupo"));
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
        if ($CurrentForm->hasValue("o_titulo_tarea")) {
            $this->titulo_tarea->setOldValue($CurrentForm->getValue("o_titulo_tarea"));
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
        if ($CurrentForm->hasValue("o_fechainireal_tarea")) {
            $this->fechainireal_tarea->setOldValue($CurrentForm->getValue("o_fechainireal_tarea"));
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
        if ($CurrentForm->hasValue("o_fechafin_tarea")) {
            $this->fechafin_tarea->setOldValue($CurrentForm->getValue("o_fechafin_tarea"));
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
        if ($CurrentForm->hasValue("o_fechainisimulado_tarea")) {
            $this->fechainisimulado_tarea->setOldValue($CurrentForm->getValue("o_fechainisimulado_tarea"));
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
        if ($CurrentForm->hasValue("o_fechafinsimulado_tarea")) {
            $this->fechafinsimulado_tarea->setOldValue($CurrentForm->getValue("o_fechafinsimulado_tarea"));
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->id_tarea->CurrentValue = $this->id_tarea->FormValue;
        }
        $this->id_grupo->CurrentValue = $this->id_grupo->FormValue;
        $this->titulo_tarea->CurrentValue = $this->titulo_tarea->FormValue;
        $this->fechainireal_tarea->CurrentValue = $this->fechainireal_tarea->FormValue;
        $this->fechainireal_tarea->CurrentValue = UnFormatDateTime($this->fechainireal_tarea->CurrentValue, 109);
        $this->fechafin_tarea->CurrentValue = $this->fechafin_tarea->FormValue;
        $this->fechafin_tarea->CurrentValue = UnFormatDateTime($this->fechafin_tarea->CurrentValue, 109);
        $this->fechainisimulado_tarea->CurrentValue = $this->fechainisimulado_tarea->FormValue;
        $this->fechainisimulado_tarea->CurrentValue = UnFormatDateTime($this->fechainisimulado_tarea->CurrentValue, 109);
        $this->fechafinsimulado_tarea->CurrentValue = $this->fechafinsimulado_tarea->FormValue;
        $this->fechafinsimulado_tarea->CurrentValue = UnFormatDateTime($this->fechafinsimulado_tarea->CurrentValue, 109);
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
        $this->archivo->Upload->Index = $this->RowIndex;
        $this->id_subgrupo->setDbValue($row['id_subgrupo']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id_tarea'] = $this->id_tarea->CurrentValue;
        $row['id_escenario'] = $this->id_escenario->CurrentValue;
        $row['id_grupo'] = $this->id_grupo->CurrentValue;
        $row['titulo_tarea'] = $this->titulo_tarea->CurrentValue;
        $row['descripcion_tarea'] = $this->descripcion_tarea->CurrentValue;
        $row['fechainireal_tarea'] = $this->fechainireal_tarea->CurrentValue;
        $row['fechafin_tarea'] = $this->fechafin_tarea->CurrentValue;
        $row['fechainisimulado_tarea'] = $this->fechainisimulado_tarea->CurrentValue;
        $row['fechafinsimulado_tarea'] = $this->fechafinsimulado_tarea->CurrentValue;
        $row['id_tarearelacion'] = $this->id_tarearelacion->CurrentValue;
        $row['archivo'] = $this->archivo->Upload->DbValue;
        $row['id_subgrupo'] = $this->id_subgrupo->CurrentValue;
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
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

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

            // id_grupo
            $this->id_grupo->LinkCustomAttributes = "";
            $this->id_grupo->HrefValue = "";
            $this->id_grupo->TooltipValue = "";

            // titulo_tarea
            $this->titulo_tarea->LinkCustomAttributes = "";
            $this->titulo_tarea->HrefValue = "";
            $this->titulo_tarea->TooltipValue = "";

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
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // id_tarea

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

            // Add refer script

            // id_tarea
            $this->id_tarea->LinkCustomAttributes = "";
            $this->id_tarea->HrefValue = "";

            // id_grupo
            $this->id_grupo->LinkCustomAttributes = "";
            $this->id_grupo->HrefValue = "";

            // titulo_tarea
            $this->titulo_tarea->LinkCustomAttributes = "";
            $this->titulo_tarea->HrefValue = "";

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
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id_tarea
            $this->id_tarea->EditAttrs["class"] = "form-control";
            $this->id_tarea->EditCustomAttributes = "";
            $this->id_tarea->EditValue = $this->id_tarea->CurrentValue;
            $this->id_tarea->ViewCustomAttributes = "";

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

            // Edit refer script

            // id_tarea
            $this->id_tarea->LinkCustomAttributes = "";
            $this->id_tarea->HrefValue = "";

            // id_grupo
            $this->id_grupo->LinkCustomAttributes = "";
            $this->id_grupo->HrefValue = "";

            // titulo_tarea
            $this->titulo_tarea->LinkCustomAttributes = "";
            $this->titulo_tarea->HrefValue = "";

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
                $thisKey .= $row['id_tarea'];
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

            // id_grupo
            $this->id_grupo->setDbValueDef($rsnew, $this->id_grupo->CurrentValue, null, $this->id_grupo->ReadOnly);

            // titulo_tarea
            $this->titulo_tarea->setDbValueDef($rsnew, $this->titulo_tarea->CurrentValue, null, $this->titulo_tarea->ReadOnly);

            // fechainireal_tarea
            $this->fechainireal_tarea->setDbValueDef($rsnew, UnFormatDateTime($this->fechainireal_tarea->CurrentValue, 109), null, $this->fechainireal_tarea->ReadOnly);

            // fechafin_tarea
            $this->fechafin_tarea->setDbValueDef($rsnew, UnFormatDateTime($this->fechafin_tarea->CurrentValue, 109), null, $this->fechafin_tarea->ReadOnly);

            // fechainisimulado_tarea
            $this->fechainisimulado_tarea->setDbValueDef($rsnew, UnFormatDateTime($this->fechainisimulado_tarea->CurrentValue, 109), null, $this->fechainisimulado_tarea->ReadOnly);

            // fechafinsimulado_tarea
            $this->fechafinsimulado_tarea->setDbValueDef($rsnew, UnFormatDateTime($this->fechafinsimulado_tarea->CurrentValue, 109), null, $this->fechafinsimulado_tarea->ReadOnly);

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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set up foreign key field value from Session
        if ($this->getCurrentMasterTable() == "escenario") {
            $this->id_escenario->CurrentValue = $this->id_escenario->getSessionValue();
        }

        // Check referential integrity for master table 'tareas'
        $validMasterRecord = true;
        $masterFilter = $this->sqlMasterFilter_escenario();
        if ($this->id_escenario->getSessionValue() != "") {
        $masterFilter = str_replace("@id_escenario@", AdjustSql($this->id_escenario->getSessionValue(), "DB"), $masterFilter);
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

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // id_grupo
        $this->id_grupo->setDbValueDef($rsnew, $this->id_grupo->CurrentValue, null, false);

        // titulo_tarea
        $this->titulo_tarea->setDbValueDef($rsnew, $this->titulo_tarea->CurrentValue, null, false);

        // fechainireal_tarea
        $this->fechainireal_tarea->setDbValueDef($rsnew, UnFormatDateTime($this->fechainireal_tarea->CurrentValue, 109), null, false);

        // fechafin_tarea
        $this->fechafin_tarea->setDbValueDef($rsnew, UnFormatDateTime($this->fechafin_tarea->CurrentValue, 109), null, false);

        // fechainisimulado_tarea
        $this->fechainisimulado_tarea->setDbValueDef($rsnew, UnFormatDateTime($this->fechainisimulado_tarea->CurrentValue, 109), null, false);

        // fechafinsimulado_tarea
        $this->fechafinsimulado_tarea->setDbValueDef($rsnew, UnFormatDateTime($this->fechafinsimulado_tarea->CurrentValue, 109), null, false);

        // id_escenario
        if ($this->id_escenario->getSessionValue() != "") {
            $rsnew['id_escenario'] = $this->id_escenario->getSessionValue();
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
        // Hide foreign keys
        $masterTblVar = $this->getCurrentMasterTable();
        if ($masterTblVar == "escenario") {
            $masterTbl = Container("escenario");
            $this->id_escenario->Visible = false;
            if ($masterTbl->EventCancelled) {
                $this->EventCancelled = true;
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
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
       // $this->OtherOptions["addedit"]->Items["add"]->Visible = FALSE;
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
}
