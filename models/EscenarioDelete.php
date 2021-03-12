<?php

namespace PHPMaker2021\simexamerica;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class EscenarioDelete extends Escenario
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'escenario';

    // Page object name
    public $PageObjName = "EscenarioDelete";

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
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id_escenario->setVisibility();
        $this->icon_escenario->setVisibility();
        $this->fechacreacion_escenario->setVisibility();
        $this->nombre_escenario->setVisibility();
        $this->tipo_evento->Visible = false;
        $this->incidente->setVisibility();
        $this->pais_escenario->setVisibility();
        $this->zonahora_escenario->Visible = false;
        $this->descripcion_escenario->Visible = false;
        $this->fechaini_simulado->setVisibility();
        $this->fechafin_simulado->Visible = false;
        $this->fechaini_real->setVisibility();
        $this->fechafinal_real->Visible = false;
        $this->image_escenario->Visible = false;
        $this->estado->setVisibility();
        $this->entrar->setVisibility();
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

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("EscenarioList"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action");
        } elseif (Get("action") == "1") {
            $this->CurrentAction = "delete"; // Delete record directly
        } else {
            $this->CurrentAction = "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsApi()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsApi()) {
                    $this->terminate();
                    return;
                }
                $this->CurrentAction = "show"; // Display record
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("EscenarioList"); // Return to list
                return;
            }
        }

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
        $this->zonahora_escenario->CellCssStyle = "white-space: nowrap;";

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

            // incidente
            $this->incidente->LinkCustomAttributes = "";
            $this->incidente->HrefValue = "";
            $this->incidente->TooltipValue = "";

            // pais_escenario
            $this->pais_escenario->LinkCustomAttributes = "";
            $this->pais_escenario->HrefValue = "";
            $this->pais_escenario->TooltipValue = "";

            // fechaini_simulado
            $this->fechaini_simulado->LinkCustomAttributes = "";
            $this->fechaini_simulado->HrefValue = "";
            $this->fechaini_simulado->TooltipValue = "";

            // fechaini_real
            $this->fechaini_real->LinkCustomAttributes = "";
            $this->fechaini_real->HrefValue = "";
            $this->fechaini_real->TooltipValue = "";

            // estado
            $this->estado->LinkCustomAttributes = "";
            $this->estado->HrefValue = "";
            $this->estado->TooltipValue = "";

            // entrar
            $this->entrar->LinkCustomAttributes = "";
            $this->entrar->HrefValue = "";
            $this->entrar->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
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
        $conn->beginTransaction();

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
                $thisKey .= $row['id_escenario'];
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
        if ($deleteRows) {
            $conn->commit(); // Commit the changes
        } else {
            $conn->rollback(); // Rollback changes
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("EscenarioList"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
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
}
