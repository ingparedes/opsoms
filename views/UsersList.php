<?php

namespace PHPMaker2021\simexamerica;

// Page object
$UsersList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fuserslist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fuserslist = currentForm = new ew.Form("fuserslist", "list");
    fuserslist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "users")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.users)
        ew.vars.tables.users = currentTable;
    fuserslist.addFields([
        ["id_users", [fields.id_users.visible && fields.id_users.required ? ew.Validators.required(fields.id_users.caption) : null], fields.id_users.isInvalid],
        ["fecha", [fields.fecha.visible && fields.fecha.required ? ew.Validators.required(fields.fecha.caption) : null], fields.fecha.isInvalid],
        ["nombres", [fields.nombres.visible && fields.nombres.required ? ew.Validators.required(fields.nombres.caption) : null], fields.nombres.isInvalid],
        ["apellidos", [fields.apellidos.visible && fields.apellidos.required ? ew.Validators.required(fields.apellidos.caption) : null], fields.apellidos.isInvalid],
        ["grupo", [fields.grupo.visible && fields.grupo.required ? ew.Validators.required(fields.grupo.caption) : null], fields.grupo.isInvalid],
        ["subgrupo", [fields.subgrupo.visible && fields.subgrupo.required ? ew.Validators.required(fields.subgrupo.caption) : null], fields.subgrupo.isInvalid],
        ["perfil", [fields.perfil.visible && fields.perfil.required ? ew.Validators.required(fields.perfil.caption) : null], fields.perfil.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
        ["telefono", [fields.telefono.visible && fields.telefono.required ? ew.Validators.required(fields.telefono.caption) : null], fields.telefono.isInvalid],
        ["pais", [fields.pais.visible && fields.pais.required ? ew.Validators.required(fields.pais.caption) : null], fields.pais.isInvalid],
        ["estado", [fields.estado.visible && fields.estado.required ? ew.Validators.required(fields.estado.caption) : null], fields.estado.isInvalid],
        ["img_user", [fields.img_user.visible && fields.img_user.required ? ew.Validators.fileRequired(fields.img_user.caption) : null], fields.img_user.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fuserslist,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fuserslist.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }
        return true;
    }

    // Form_CustomValidate
    fuserslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fuserslist.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fuserslist.lists.grupo = <?= $Page->grupo->toClientList($Page) ?>;
    fuserslist.lists.subgrupo = <?= $Page->subgrupo->toClientList($Page) ?>;
    fuserslist.lists.perfil = <?= $Page->perfil->toClientList($Page) ?>;
    fuserslist.lists.pais = <?= $Page->pais->toClientList($Page) ?>;
    fuserslist.lists.estado = <?= $Page->estado->toClientList($Page) ?>;
    loadjs.done("fuserslist");
});
var fuserslistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fuserslistsrch = currentSearchForm = new ew.Form("fuserslistsrch");

    // Dynamic selection lists

    // Filters
    fuserslistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fuserslistsrch");
});
</script>
<style type="text/css">
.ew-table-preview-row { /* main table preview row color */
    background-color: #FFFFFF; /* preview row color */
}
.ew-table-preview-row .ew-grid {
    display: table;
}
</style>
<div id="ew-preview" class="d-none"><!-- preview -->
    <div class="ew-nav-tabs"><!-- .ew-nav-tabs -->
        <ul class="nav nav-tabs"></ul>
        <div class="tab-content"><!-- .tab-content -->
            <div class="tab-pane fade active show"></div>
        </div><!-- /.tab-content -->
    </div><!-- /.ew-nav-tabs -->
</div><!-- /preview -->
<script>
loadjs.ready("head", function() {
    ew.PREVIEW_PLACEMENT = ew.CSS_FLIP ? "right" : "left";
    ew.PREVIEW_SINGLE_ROW = false;
    ew.PREVIEW_OVERLAY = false;
    loadjs(ew.PATH_BASE + "js/ewpreview.js", "preview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fuserslistsrch" id="fuserslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="fuserslistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="users">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> users">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fuserslist" id="fuserslist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="users">
<div id="gmp_users" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_userslist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id_users->Visible) { // id_users ?>
        <th data-name="id_users" class="<?= $Page->id_users->headerCellClass() ?>"><div id="elh_users_id_users" class="users_id_users"><?= $Page->renderSort($Page->id_users) ?></div></th>
<?php } ?>
<?php if ($Page->fecha->Visible) { // fecha ?>
        <th data-name="fecha" class="<?= $Page->fecha->headerCellClass() ?>"><div id="elh_users_fecha" class="users_fecha"><?= $Page->renderSort($Page->fecha) ?></div></th>
<?php } ?>
<?php if ($Page->nombres->Visible) { // nombres ?>
        <th data-name="nombres" class="<?= $Page->nombres->headerCellClass() ?>"><div id="elh_users_nombres" class="users_nombres"><?= $Page->renderSort($Page->nombres) ?></div></th>
<?php } ?>
<?php if ($Page->apellidos->Visible) { // apellidos ?>
        <th data-name="apellidos" class="<?= $Page->apellidos->headerCellClass() ?>"><div id="elh_users_apellidos" class="users_apellidos"><?= $Page->renderSort($Page->apellidos) ?></div></th>
<?php } ?>
<?php if ($Page->grupo->Visible) { // grupo ?>
        <th data-name="grupo" class="<?= $Page->grupo->headerCellClass() ?>"><div id="elh_users_grupo" class="users_grupo"><?= $Page->renderSort($Page->grupo) ?></div></th>
<?php } ?>
<?php if ($Page->subgrupo->Visible) { // subgrupo ?>
        <th data-name="subgrupo" class="<?= $Page->subgrupo->headerCellClass() ?>"><div id="elh_users_subgrupo" class="users_subgrupo"><?= $Page->renderSort($Page->subgrupo) ?></div></th>
<?php } ?>
<?php if ($Page->perfil->Visible) { // perfil ?>
        <th data-name="perfil" class="<?= $Page->perfil->headerCellClass() ?>"><div id="elh_users_perfil" class="users_perfil"><?= $Page->renderSort($Page->perfil) ?></div></th>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <th data-name="_email" class="<?= $Page->_email->headerCellClass() ?>"><div id="elh_users__email" class="users__email"><?= $Page->renderSort($Page->_email) ?></div></th>
<?php } ?>
<?php if ($Page->telefono->Visible) { // telefono ?>
        <th data-name="telefono" class="<?= $Page->telefono->headerCellClass() ?>"><div id="elh_users_telefono" class="users_telefono"><?= $Page->renderSort($Page->telefono) ?></div></th>
<?php } ?>
<?php if ($Page->pais->Visible) { // pais ?>
        <th data-name="pais" class="<?= $Page->pais->headerCellClass() ?>"><div id="elh_users_pais" class="users_pais"><?= $Page->renderSort($Page->pais) ?></div></th>
<?php } ?>
<?php if ($Page->estado->Visible) { // estado ?>
        <th data-name="estado" class="<?= $Page->estado->headerCellClass() ?>"><div id="elh_users_estado" class="users_estado"><?= $Page->renderSort($Page->estado) ?></div></th>
<?php } ?>
<?php if ($Page->img_user->Visible) { // img_user ?>
        <th data-name="img_user" class="<?= $Page->img_user->headerCellClass() ?>"><div id="elh_users_img_user" class="users_img_user"><?= $Page->renderSort($Page->img_user) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}

// Restore number of post back records
if ($CurrentForm && ($Page->isConfirm() || $Page->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Page->FormKeyCountName) && ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm())) {
        $Page->KeyCount = $CurrentForm->getValue($Page->FormKeyCountName);
        $Page->StopRecord = $Page->StartRecord + $Page->KeyCount - 1;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
if ($Page->isGridEdit())
    $Page->RowIndex = 0;
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;
        if ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm()) {
            $Page->RowIndex++;
            $CurrentForm->Index = $Page->RowIndex;
            if ($CurrentForm->hasValue($Page->FormActionName) && ($Page->isConfirm() || $Page->EventCancelled)) {
                $Page->RowAction = strval($CurrentForm->getValue($Page->FormActionName));
            } elseif ($Page->isGridAdd()) {
                $Page->RowAction = "insert";
            } else {
                $Page->RowAction = "";
            }
        }

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view
        if ($Page->isGridEdit()) { // Grid edit
            if ($Page->EventCancelled) {
                $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
            }
            if ($Page->RowAction == "insert") {
                $Page->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Page->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Page->isGridEdit() && ($Page->RowType == ROWTYPE_EDIT || $Page->RowType == ROWTYPE_ADD) && $Page->EventCancelled) { // Update failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }
        if ($Page->RowType == ROWTYPE_EDIT) { // Edit row
            $Page->EditRowCount++;
        }

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_users", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();

        // Skip delete row / empty row for confirm page
        if ($Page->RowAction != "delete" && $Page->RowAction != "insertdelete" && !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow())) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id_users->Visible) { // id_users ?>
        <td data-name="id_users" <?= $Page->id_users->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_id_users" class="form-group"></span>
<input type="hidden" data-table="users" data-field="x_id_users" data-hidden="1" name="o<?= $Page->RowIndex ?>_id_users" id="o<?= $Page->RowIndex ?>_id_users" value="<?= HtmlEncode($Page->id_users->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_id_users" class="form-group">
<span<?= $Page->id_users->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_users->getDisplayValue($Page->id_users->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_id_users" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_users" id="x<?= $Page->RowIndex ?>_id_users" value="<?= HtmlEncode($Page->id_users->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_id_users">
<span<?= $Page->id_users->viewAttributes() ?>>
<?= $Page->id_users->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="users" data-field="x_id_users" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_users" id="x<?= $Page->RowIndex ?>_id_users" value="<?= HtmlEncode($Page->id_users->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->fecha->Visible) { // fecha ?>
        <td data-name="fecha" <?= $Page->fecha->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="users" data-field="x_fecha" data-hidden="1" name="o<?= $Page->RowIndex ?>_fecha" id="o<?= $Page->RowIndex ?>_fecha" value="<?= HtmlEncode($Page->fecha->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_fecha">
<span<?= $Page->fecha->viewAttributes() ?>>
<?= $Page->fecha->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->nombres->Visible) { // nombres ?>
        <td data-name="nombres" <?= $Page->nombres->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_nombres" class="form-group">
<input type="<?= $Page->nombres->getInputTextType() ?>" data-table="users" data-field="x_nombres" name="x<?= $Page->RowIndex ?>_nombres" id="x<?= $Page->RowIndex ?>_nombres" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->nombres->getPlaceHolder()) ?>" value="<?= $Page->nombres->EditValue ?>"<?= $Page->nombres->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nombres->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_nombres" data-hidden="1" name="o<?= $Page->RowIndex ?>_nombres" id="o<?= $Page->RowIndex ?>_nombres" value="<?= HtmlEncode($Page->nombres->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_nombres" class="form-group">
<input type="<?= $Page->nombres->getInputTextType() ?>" data-table="users" data-field="x_nombres" name="x<?= $Page->RowIndex ?>_nombres" id="x<?= $Page->RowIndex ?>_nombres" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->nombres->getPlaceHolder()) ?>" value="<?= $Page->nombres->EditValue ?>"<?= $Page->nombres->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nombres->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_nombres">
<span<?= $Page->nombres->viewAttributes() ?>>
<?= $Page->nombres->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->apellidos->Visible) { // apellidos ?>
        <td data-name="apellidos" <?= $Page->apellidos->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_apellidos" class="form-group">
<input type="<?= $Page->apellidos->getInputTextType() ?>" data-table="users" data-field="x_apellidos" name="x<?= $Page->RowIndex ?>_apellidos" id="x<?= $Page->RowIndex ?>_apellidos" size="30" maxlength="90" placeholder="<?= HtmlEncode($Page->apellidos->getPlaceHolder()) ?>" value="<?= $Page->apellidos->EditValue ?>"<?= $Page->apellidos->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->apellidos->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_apellidos" data-hidden="1" name="o<?= $Page->RowIndex ?>_apellidos" id="o<?= $Page->RowIndex ?>_apellidos" value="<?= HtmlEncode($Page->apellidos->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_apellidos" class="form-group">
<input type="<?= $Page->apellidos->getInputTextType() ?>" data-table="users" data-field="x_apellidos" name="x<?= $Page->RowIndex ?>_apellidos" id="x<?= $Page->RowIndex ?>_apellidos" size="30" maxlength="90" placeholder="<?= HtmlEncode($Page->apellidos->getPlaceHolder()) ?>" value="<?= $Page->apellidos->EditValue ?>"<?= $Page->apellidos->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->apellidos->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_apellidos">
<span<?= $Page->apellidos->viewAttributes() ?>>
<?= $Page->apellidos->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->grupo->Visible) { // grupo ?>
        <td data-name="grupo" <?= $Page->grupo->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_grupo" class="form-group">
<?php $Page->grupo->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_grupo"
        name="x<?= $Page->RowIndex ?>_grupo"
        class="form-control ew-select<?= $Page->grupo->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Page->RowIndex ?>_grupo"
        data-table="users"
        data-field="x_grupo"
        data-value-separator="<?= $Page->grupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->grupo->getPlaceHolder()) ?>"
        <?= $Page->grupo->editAttributes() ?>>
        <?= $Page->grupo->selectOptionListHtml("x{$Page->RowIndex}_grupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->grupo->getErrorMessage() ?></div>
<?= $Page->grupo->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_grupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Page->RowIndex ?>_grupo']"),
        options = { name: "x<?= $Page->RowIndex ?>_grupo", selectId: "users_x<?= $Page->RowIndex ?>_grupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.grupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="users" data-field="x_grupo" data-hidden="1" name="o<?= $Page->RowIndex ?>_grupo" id="o<?= $Page->RowIndex ?>_grupo" value="<?= HtmlEncode($Page->grupo->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_grupo" class="form-group">
<?php $Page->grupo->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_grupo"
        name="x<?= $Page->RowIndex ?>_grupo"
        class="form-control ew-select<?= $Page->grupo->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Page->RowIndex ?>_grupo"
        data-table="users"
        data-field="x_grupo"
        data-value-separator="<?= $Page->grupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->grupo->getPlaceHolder()) ?>"
        <?= $Page->grupo->editAttributes() ?>>
        <?= $Page->grupo->selectOptionListHtml("x{$Page->RowIndex}_grupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->grupo->getErrorMessage() ?></div>
<?= $Page->grupo->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_grupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Page->RowIndex ?>_grupo']"),
        options = { name: "x<?= $Page->RowIndex ?>_grupo", selectId: "users_x<?= $Page->RowIndex ?>_grupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.grupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_grupo">
<span<?= $Page->grupo->viewAttributes() ?>>
<?= $Page->grupo->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->subgrupo->Visible) { // subgrupo ?>
        <td data-name="subgrupo" <?= $Page->subgrupo->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_subgrupo" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_subgrupo"
        name="x<?= $Page->RowIndex ?>_subgrupo"
        class="form-control ew-select<?= $Page->subgrupo->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Page->RowIndex ?>_subgrupo"
        data-table="users"
        data-field="x_subgrupo"
        data-value-separator="<?= $Page->subgrupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->subgrupo->getPlaceHolder()) ?>"
        <?= $Page->subgrupo->editAttributes() ?>>
        <?= $Page->subgrupo->selectOptionListHtml("x{$Page->RowIndex}_subgrupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->subgrupo->getErrorMessage() ?></div>
<?= $Page->subgrupo->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_subgrupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Page->RowIndex ?>_subgrupo']"),
        options = { name: "x<?= $Page->RowIndex ?>_subgrupo", selectId: "users_x<?= $Page->RowIndex ?>_subgrupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.subgrupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="users" data-field="x_subgrupo" data-hidden="1" name="o<?= $Page->RowIndex ?>_subgrupo" id="o<?= $Page->RowIndex ?>_subgrupo" value="<?= HtmlEncode($Page->subgrupo->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_subgrupo" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_subgrupo"
        name="x<?= $Page->RowIndex ?>_subgrupo"
        class="form-control ew-select<?= $Page->subgrupo->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Page->RowIndex ?>_subgrupo"
        data-table="users"
        data-field="x_subgrupo"
        data-value-separator="<?= $Page->subgrupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->subgrupo->getPlaceHolder()) ?>"
        <?= $Page->subgrupo->editAttributes() ?>>
        <?= $Page->subgrupo->selectOptionListHtml("x{$Page->RowIndex}_subgrupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->subgrupo->getErrorMessage() ?></div>
<?= $Page->subgrupo->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_subgrupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Page->RowIndex ?>_subgrupo']"),
        options = { name: "x<?= $Page->RowIndex ?>_subgrupo", selectId: "users_x<?= $Page->RowIndex ?>_subgrupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.subgrupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_subgrupo">
<span<?= $Page->subgrupo->viewAttributes() ?>>
<?= $Page->subgrupo->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->perfil->Visible) { // perfil ?>
        <td data-name="perfil" <?= $Page->perfil->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_users_perfil" class="form-group">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->perfil->getDisplayValue($Page->perfil->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_users_perfil" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_perfil"
        name="x<?= $Page->RowIndex ?>_perfil"
        class="form-control ew-select<?= $Page->perfil->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Page->RowIndex ?>_perfil"
        data-table="users"
        data-field="x_perfil"
        data-value-separator="<?= $Page->perfil->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->perfil->getPlaceHolder()) ?>"
        <?= $Page->perfil->editAttributes() ?>>
        <?= $Page->perfil->selectOptionListHtml("x{$Page->RowIndex}_perfil") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->perfil->getErrorMessage() ?></div>
<?= $Page->perfil->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_perfil") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Page->RowIndex ?>_perfil']"),
        options = { name: "x<?= $Page->RowIndex ?>_perfil", selectId: "users_x<?= $Page->RowIndex ?>_perfil", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.perfil.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="users" data-field="x_perfil" data-hidden="1" name="o<?= $Page->RowIndex ?>_perfil" id="o<?= $Page->RowIndex ?>_perfil" value="<?= HtmlEncode($Page->perfil->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_users_perfil" class="form-group">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->perfil->getDisplayValue($Page->perfil->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_users_perfil" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_perfil"
        name="x<?= $Page->RowIndex ?>_perfil"
        class="form-control ew-select<?= $Page->perfil->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Page->RowIndex ?>_perfil"
        data-table="users"
        data-field="x_perfil"
        data-value-separator="<?= $Page->perfil->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->perfil->getPlaceHolder()) ?>"
        <?= $Page->perfil->editAttributes() ?>>
        <?= $Page->perfil->selectOptionListHtml("x{$Page->RowIndex}_perfil") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->perfil->getErrorMessage() ?></div>
<?= $Page->perfil->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_perfil") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Page->RowIndex ?>_perfil']"),
        options = { name: "x<?= $Page->RowIndex ?>_perfil", selectId: "users_x<?= $Page->RowIndex ?>_perfil", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.perfil.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_perfil">
<span<?= $Page->perfil->viewAttributes() ?>>
<?= $Page->perfil->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->_email->Visible) { // email ?>
        <td data-name="_email" <?= $Page->_email->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users__email" class="form-group">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="users" data-field="x__email" name="x<?= $Page->RowIndex ?>__email" id="x<?= $Page->RowIndex ?>__email" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x__email" data-hidden="1" name="o<?= $Page->RowIndex ?>__email" id="o<?= $Page->RowIndex ?>__email" value="<?= HtmlEncode($Page->_email->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users__email" class="form-group">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="users" data-field="x__email" name="x<?= $Page->RowIndex ?>__email" id="x<?= $Page->RowIndex ?>__email" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->telefono->Visible) { // telefono ?>
        <td data-name="telefono" <?= $Page->telefono->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_telefono" class="form-group">
<input type="<?= $Page->telefono->getInputTextType() ?>" data-table="users" data-field="x_telefono" name="x<?= $Page->RowIndex ?>_telefono" id="x<?= $Page->RowIndex ?>_telefono" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->telefono->getPlaceHolder()) ?>" value="<?= $Page->telefono->EditValue ?>"<?= $Page->telefono->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->telefono->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_telefono" data-hidden="1" name="o<?= $Page->RowIndex ?>_telefono" id="o<?= $Page->RowIndex ?>_telefono" value="<?= HtmlEncode($Page->telefono->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_telefono" class="form-group">
<input type="<?= $Page->telefono->getInputTextType() ?>" data-table="users" data-field="x_telefono" name="x<?= $Page->RowIndex ?>_telefono" id="x<?= $Page->RowIndex ?>_telefono" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->telefono->getPlaceHolder()) ?>" value="<?= $Page->telefono->EditValue ?>"<?= $Page->telefono->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->telefono->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_telefono">
<span<?= $Page->telefono->viewAttributes() ?>>
<?= $Page->telefono->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->pais->Visible) { // pais ?>
        <td data-name="pais" <?= $Page->pais->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_pais" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_pais"
        name="x<?= $Page->RowIndex ?>_pais"
        class="form-control ew-select<?= $Page->pais->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Page->RowIndex ?>_pais"
        data-table="users"
        data-field="x_pais"
        data-value-separator="<?= $Page->pais->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->pais->getPlaceHolder()) ?>"
        <?= $Page->pais->editAttributes() ?>>
        <?= $Page->pais->selectOptionListHtml("x{$Page->RowIndex}_pais") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->pais->getErrorMessage() ?></div>
<?= $Page->pais->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_pais") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Page->RowIndex ?>_pais']"),
        options = { name: "x<?= $Page->RowIndex ?>_pais", selectId: "users_x<?= $Page->RowIndex ?>_pais", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.pais.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="users" data-field="x_pais" data-hidden="1" name="o<?= $Page->RowIndex ?>_pais" id="o<?= $Page->RowIndex ?>_pais" value="<?= HtmlEncode($Page->pais->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_pais" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_pais"
        name="x<?= $Page->RowIndex ?>_pais"
        class="form-control ew-select<?= $Page->pais->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Page->RowIndex ?>_pais"
        data-table="users"
        data-field="x_pais"
        data-value-separator="<?= $Page->pais->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->pais->getPlaceHolder()) ?>"
        <?= $Page->pais->editAttributes() ?>>
        <?= $Page->pais->selectOptionListHtml("x{$Page->RowIndex}_pais") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->pais->getErrorMessage() ?></div>
<?= $Page->pais->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_pais") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Page->RowIndex ?>_pais']"),
        options = { name: "x<?= $Page->RowIndex ?>_pais", selectId: "users_x<?= $Page->RowIndex ?>_pais", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.pais.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_pais">
<span<?= $Page->pais->viewAttributes() ?>>
<?= $Page->pais->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->estado->Visible) { // estado ?>
        <td data-name="estado" <?= $Page->estado->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_estado" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_estado"
        name="x<?= $Page->RowIndex ?>_estado"
        class="form-control ew-select<?= $Page->estado->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Page->RowIndex ?>_estado"
        data-table="users"
        data-field="x_estado"
        data-value-separator="<?= $Page->estado->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estado->getPlaceHolder()) ?>"
        <?= $Page->estado->editAttributes() ?>>
        <?= $Page->estado->selectOptionListHtml("x{$Page->RowIndex}_estado") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->estado->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Page->RowIndex ?>_estado']"),
        options = { name: "x<?= $Page->RowIndex ?>_estado", selectId: "users_x<?= $Page->RowIndex ?>_estado", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.users.fields.estado.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.estado.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="users" data-field="x_estado" data-hidden="1" name="o<?= $Page->RowIndex ?>_estado" id="o<?= $Page->RowIndex ?>_estado" value="<?= HtmlEncode($Page->estado->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_estado" class="form-group">
    <select
        id="x<?= $Page->RowIndex ?>_estado"
        name="x<?= $Page->RowIndex ?>_estado"
        class="form-control ew-select<?= $Page->estado->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Page->RowIndex ?>_estado"
        data-table="users"
        data-field="x_estado"
        data-value-separator="<?= $Page->estado->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estado->getPlaceHolder()) ?>"
        <?= $Page->estado->editAttributes() ?>>
        <?= $Page->estado->selectOptionListHtml("x{$Page->RowIndex}_estado") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->estado->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Page->RowIndex ?>_estado']"),
        options = { name: "x<?= $Page->RowIndex ?>_estado", selectId: "users_x<?= $Page->RowIndex ?>_estado", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.users.fields.estado.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.estado.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_estado">
<span<?= $Page->estado->viewAttributes() ?>>
<?= $Page->estado->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->img_user->Visible) { // img_user ?>
        <td data-name="img_user" <?= $Page->img_user->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_img_user" class="form-group">
<div id="fd_x<?= $Page->RowIndex ?>_img_user">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->img_user->title() ?>" data-table="users" data-field="x_img_user" name="x<?= $Page->RowIndex ?>_img_user" id="x<?= $Page->RowIndex ?>_img_user" lang="<?= CurrentLanguageID() ?>"<?= $Page->img_user->editAttributes() ?><?= ($Page->img_user->ReadOnly || $Page->img_user->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Page->RowIndex ?>_img_user"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->img_user->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_img_user" id= "fn_x<?= $Page->RowIndex ?>_img_user" value="<?= $Page->img_user->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_img_user" id= "fa_x<?= $Page->RowIndex ?>_img_user" value="0">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_img_user" id= "fs_x<?= $Page->RowIndex ?>_img_user" value="60">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_img_user" id= "fx_x<?= $Page->RowIndex ?>_img_user" value="<?= $Page->img_user->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_img_user" id= "fm_x<?= $Page->RowIndex ?>_img_user" value="<?= $Page->img_user->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Page->RowIndex ?>_img_user" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="users" data-field="x_img_user" data-hidden="1" name="o<?= $Page->RowIndex ?>_img_user" id="o<?= $Page->RowIndex ?>_img_user" value="<?= HtmlEncode($Page->img_user->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_img_user" class="form-group">
<div id="fd_x<?= $Page->RowIndex ?>_img_user">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->img_user->title() ?>" data-table="users" data-field="x_img_user" name="x<?= $Page->RowIndex ?>_img_user" id="x<?= $Page->RowIndex ?>_img_user" lang="<?= CurrentLanguageID() ?>"<?= $Page->img_user->editAttributes() ?><?= ($Page->img_user->ReadOnly || $Page->img_user->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Page->RowIndex ?>_img_user"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->img_user->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_img_user" id= "fn_x<?= $Page->RowIndex ?>_img_user" value="<?= $Page->img_user->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_img_user" id= "fa_x<?= $Page->RowIndex ?>_img_user" value="<?= (Post("fa_x<?= $Page->RowIndex ?>_img_user") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_img_user" id= "fs_x<?= $Page->RowIndex ?>_img_user" value="60">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_img_user" id= "fx_x<?= $Page->RowIndex ?>_img_user" value="<?= $Page->img_user->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_img_user" id= "fm_x<?= $Page->RowIndex ?>_img_user" value="<?= $Page->img_user->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Page->RowIndex ?>_img_user" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_img_user">
<span>
<?= GetFileViewTag($Page->img_user, $Page->img_user->getViewValue(), false) ?>
</span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == ROWTYPE_ADD || $Page->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fuserslist","load"], function () {
    fuserslist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Page->isGridAdd())
        if (!$Page->Recordset->EOF) {
            $Page->Recordset->moveNext();
        }
}
?>
<?php
    if ($Page->isGridAdd() || $Page->isGridEdit()) {
        $Page->RowIndex = '$rowindex$';
        $Page->loadRowValues();

        // Set row properties
        $Page->resetAttributes();
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_users", "data-rowtype" => ROWTYPE_ADD]);
        $Page->RowAttrs->appendClass("ew-template");
        $Page->RowType = ROWTYPE_ADD;

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
        $Page->StartRowCount = 0;
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowIndex);
?>
    <?php if ($Page->id_users->Visible) { // id_users ?>
        <td data-name="id_users">
<span id="el$rowindex$_users_id_users" class="form-group users_id_users"></span>
<input type="hidden" data-table="users" data-field="x_id_users" data-hidden="1" name="o<?= $Page->RowIndex ?>_id_users" id="o<?= $Page->RowIndex ?>_id_users" value="<?= HtmlEncode($Page->id_users->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->fecha->Visible) { // fecha ?>
        <td data-name="fecha">
<input type="hidden" data-table="users" data-field="x_fecha" data-hidden="1" name="o<?= $Page->RowIndex ?>_fecha" id="o<?= $Page->RowIndex ?>_fecha" value="<?= HtmlEncode($Page->fecha->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->nombres->Visible) { // nombres ?>
        <td data-name="nombres">
<span id="el$rowindex$_users_nombres" class="form-group users_nombres">
<input type="<?= $Page->nombres->getInputTextType() ?>" data-table="users" data-field="x_nombres" name="x<?= $Page->RowIndex ?>_nombres" id="x<?= $Page->RowIndex ?>_nombres" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->nombres->getPlaceHolder()) ?>" value="<?= $Page->nombres->EditValue ?>"<?= $Page->nombres->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->nombres->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_nombres" data-hidden="1" name="o<?= $Page->RowIndex ?>_nombres" id="o<?= $Page->RowIndex ?>_nombres" value="<?= HtmlEncode($Page->nombres->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->apellidos->Visible) { // apellidos ?>
        <td data-name="apellidos">
<span id="el$rowindex$_users_apellidos" class="form-group users_apellidos">
<input type="<?= $Page->apellidos->getInputTextType() ?>" data-table="users" data-field="x_apellidos" name="x<?= $Page->RowIndex ?>_apellidos" id="x<?= $Page->RowIndex ?>_apellidos" size="30" maxlength="90" placeholder="<?= HtmlEncode($Page->apellidos->getPlaceHolder()) ?>" value="<?= $Page->apellidos->EditValue ?>"<?= $Page->apellidos->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->apellidos->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_apellidos" data-hidden="1" name="o<?= $Page->RowIndex ?>_apellidos" id="o<?= $Page->RowIndex ?>_apellidos" value="<?= HtmlEncode($Page->apellidos->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->grupo->Visible) { // grupo ?>
        <td data-name="grupo">
<span id="el$rowindex$_users_grupo" class="form-group users_grupo">
<?php $Page->grupo->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_grupo"
        name="x<?= $Page->RowIndex ?>_grupo"
        class="form-control ew-select<?= $Page->grupo->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Page->RowIndex ?>_grupo"
        data-table="users"
        data-field="x_grupo"
        data-value-separator="<?= $Page->grupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->grupo->getPlaceHolder()) ?>"
        <?= $Page->grupo->editAttributes() ?>>
        <?= $Page->grupo->selectOptionListHtml("x{$Page->RowIndex}_grupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->grupo->getErrorMessage() ?></div>
<?= $Page->grupo->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_grupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Page->RowIndex ?>_grupo']"),
        options = { name: "x<?= $Page->RowIndex ?>_grupo", selectId: "users_x<?= $Page->RowIndex ?>_grupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.grupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="users" data-field="x_grupo" data-hidden="1" name="o<?= $Page->RowIndex ?>_grupo" id="o<?= $Page->RowIndex ?>_grupo" value="<?= HtmlEncode($Page->grupo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->subgrupo->Visible) { // subgrupo ?>
        <td data-name="subgrupo">
<span id="el$rowindex$_users_subgrupo" class="form-group users_subgrupo">
    <select
        id="x<?= $Page->RowIndex ?>_subgrupo"
        name="x<?= $Page->RowIndex ?>_subgrupo"
        class="form-control ew-select<?= $Page->subgrupo->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Page->RowIndex ?>_subgrupo"
        data-table="users"
        data-field="x_subgrupo"
        data-value-separator="<?= $Page->subgrupo->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->subgrupo->getPlaceHolder()) ?>"
        <?= $Page->subgrupo->editAttributes() ?>>
        <?= $Page->subgrupo->selectOptionListHtml("x{$Page->RowIndex}_subgrupo") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->subgrupo->getErrorMessage() ?></div>
<?= $Page->subgrupo->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_subgrupo") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Page->RowIndex ?>_subgrupo']"),
        options = { name: "x<?= $Page->RowIndex ?>_subgrupo", selectId: "users_x<?= $Page->RowIndex ?>_subgrupo", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.subgrupo.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="users" data-field="x_subgrupo" data-hidden="1" name="o<?= $Page->RowIndex ?>_subgrupo" id="o<?= $Page->RowIndex ?>_subgrupo" value="<?= HtmlEncode($Page->subgrupo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->perfil->Visible) { // perfil ?>
        <td data-name="perfil">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el$rowindex$_users_perfil" class="form-group users_perfil">
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->perfil->getDisplayValue($Page->perfil->EditValue))) ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_users_perfil" class="form-group users_perfil">
    <select
        id="x<?= $Page->RowIndex ?>_perfil"
        name="x<?= $Page->RowIndex ?>_perfil"
        class="form-control ew-select<?= $Page->perfil->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Page->RowIndex ?>_perfil"
        data-table="users"
        data-field="x_perfil"
        data-value-separator="<?= $Page->perfil->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->perfil->getPlaceHolder()) ?>"
        <?= $Page->perfil->editAttributes() ?>>
        <?= $Page->perfil->selectOptionListHtml("x{$Page->RowIndex}_perfil") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->perfil->getErrorMessage() ?></div>
<?= $Page->perfil->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_perfil") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Page->RowIndex ?>_perfil']"),
        options = { name: "x<?= $Page->RowIndex ?>_perfil", selectId: "users_x<?= $Page->RowIndex ?>_perfil", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.perfil.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="users" data-field="x_perfil" data-hidden="1" name="o<?= $Page->RowIndex ?>_perfil" id="o<?= $Page->RowIndex ?>_perfil" value="<?= HtmlEncode($Page->perfil->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->_email->Visible) { // email ?>
        <td data-name="_email">
<span id="el$rowindex$_users__email" class="form-group users__email">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="users" data-field="x__email" name="x<?= $Page->RowIndex ?>__email" id="x<?= $Page->RowIndex ?>__email" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x__email" data-hidden="1" name="o<?= $Page->RowIndex ?>__email" id="o<?= $Page->RowIndex ?>__email" value="<?= HtmlEncode($Page->_email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->telefono->Visible) { // telefono ?>
        <td data-name="telefono">
<span id="el$rowindex$_users_telefono" class="form-group users_telefono">
<input type="<?= $Page->telefono->getInputTextType() ?>" data-table="users" data-field="x_telefono" name="x<?= $Page->RowIndex ?>_telefono" id="x<?= $Page->RowIndex ?>_telefono" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->telefono->getPlaceHolder()) ?>" value="<?= $Page->telefono->EditValue ?>"<?= $Page->telefono->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->telefono->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_telefono" data-hidden="1" name="o<?= $Page->RowIndex ?>_telefono" id="o<?= $Page->RowIndex ?>_telefono" value="<?= HtmlEncode($Page->telefono->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->pais->Visible) { // pais ?>
        <td data-name="pais">
<span id="el$rowindex$_users_pais" class="form-group users_pais">
    <select
        id="x<?= $Page->RowIndex ?>_pais"
        name="x<?= $Page->RowIndex ?>_pais"
        class="form-control ew-select<?= $Page->pais->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Page->RowIndex ?>_pais"
        data-table="users"
        data-field="x_pais"
        data-value-separator="<?= $Page->pais->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->pais->getPlaceHolder()) ?>"
        <?= $Page->pais->editAttributes() ?>>
        <?= $Page->pais->selectOptionListHtml("x{$Page->RowIndex}_pais") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->pais->getErrorMessage() ?></div>
<?= $Page->pais->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_pais") ?>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Page->RowIndex ?>_pais']"),
        options = { name: "x<?= $Page->RowIndex ?>_pais", selectId: "users_x<?= $Page->RowIndex ?>_pais", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.pais.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="users" data-field="x_pais" data-hidden="1" name="o<?= $Page->RowIndex ?>_pais" id="o<?= $Page->RowIndex ?>_pais" value="<?= HtmlEncode($Page->pais->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->estado->Visible) { // estado ?>
        <td data-name="estado">
<span id="el$rowindex$_users_estado" class="form-group users_estado">
    <select
        id="x<?= $Page->RowIndex ?>_estado"
        name="x<?= $Page->RowIndex ?>_estado"
        class="form-control ew-select<?= $Page->estado->isInvalidClass() ?>"
        data-select2-id="users_x<?= $Page->RowIndex ?>_estado"
        data-table="users"
        data-field="x_estado"
        data-value-separator="<?= $Page->estado->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->estado->getPlaceHolder()) ?>"
        <?= $Page->estado->editAttributes() ?>>
        <?= $Page->estado->selectOptionListHtml("x{$Page->RowIndex}_estado") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->estado->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='users_x<?= $Page->RowIndex ?>_estado']"),
        options = { name: "x<?= $Page->RowIndex ?>_estado", selectId: "users_x<?= $Page->RowIndex ?>_estado", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.users.fields.estado.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.users.fields.estado.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="users" data-field="x_estado" data-hidden="1" name="o<?= $Page->RowIndex ?>_estado" id="o<?= $Page->RowIndex ?>_estado" value="<?= HtmlEncode($Page->estado->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->img_user->Visible) { // img_user ?>
        <td data-name="img_user">
<span id="el$rowindex$_users_img_user" class="form-group users_img_user">
<div id="fd_x<?= $Page->RowIndex ?>_img_user">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->img_user->title() ?>" data-table="users" data-field="x_img_user" name="x<?= $Page->RowIndex ?>_img_user" id="x<?= $Page->RowIndex ?>_img_user" lang="<?= CurrentLanguageID() ?>"<?= $Page->img_user->editAttributes() ?><?= ($Page->img_user->ReadOnly || $Page->img_user->Disabled) ? " disabled" : "" ?>>
        <label class="custom-file-label ew-file-label" for="x<?= $Page->RowIndex ?>_img_user"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<div class="invalid-feedback"><?= $Page->img_user->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_img_user" id= "fn_x<?= $Page->RowIndex ?>_img_user" value="<?= $Page->img_user->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_img_user" id= "fa_x<?= $Page->RowIndex ?>_img_user" value="0">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_img_user" id= "fs_x<?= $Page->RowIndex ?>_img_user" value="60">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_img_user" id= "fx_x<?= $Page->RowIndex ?>_img_user" value="<?= $Page->img_user->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_img_user" id= "fm_x<?= $Page->RowIndex ?>_img_user" value="<?= $Page->img_user->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?= $Page->RowIndex ?>_img_user" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="users" data-field="x_img_user" data-hidden="1" name="o<?= $Page->RowIndex ?>_img_user" id="o<?= $Page->RowIndex ?>_img_user" value="<?= HtmlEncode($Page->img_user->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fuserslist","load"], function() {
    fuserslist.updateLists(<?= $Page->RowIndex ?>);
});
</script>
    </tr>
<?php
    }
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
