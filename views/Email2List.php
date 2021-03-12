<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Email2List = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var femail2list;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    femail2list = currentForm = new ew.Form("femail2list", "list");
    femail2list.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("femail2list");
});
var femail2listsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    femail2listsrch = currentSearchForm = new ew.Form("femail2listsrch");

    // Dynamic selection lists

    // Filters
    femail2listsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("femail2listsrch");
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
<form name="femail2listsrch" id="femail2listsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl() ?>">
<div id="femail2listsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="email2">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> email2">
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
<form name="femail2list" id="femail2list" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="email2">
<div id="gmp_email2" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_email2list" class="table ew-table d-none"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left", "", "block", $Page->TableVar, "email2list");
?>
<?php if ($Page->sender_userid->Visible) { // sender_userid ?>
        <th data-name="sender_userid" class="<?= $Page->sender_userid->headerCellClass() ?>"><div id="elh_email2_sender_userid" class="email2_sender_userid"><?= $Page->renderSort($Page->sender_userid) ?></div></th>
<?php } ?>
<?php if ($Page->copy_sender->Visible) { // copy_sender ?>
        <th data-name="copy_sender" class="<?= $Page->copy_sender->headerCellClass() ?>"><div id="elh_email2_copy_sender" class="email2_copy_sender"><?= $Page->renderSort($Page->copy_sender) ?></div></th>
<?php } ?>
<?php if ($Page->sujeto->Visible) { // sujeto ?>
        <th data-name="sujeto" class="<?= $Page->sujeto->headerCellClass() ?>"><div id="elh_email2_sujeto" class="email2_sujeto"><?= $Page->renderSort($Page->sujeto) ?></div></th>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
        <th data-name="mensaje" class="<?= $Page->mensaje->headerCellClass() ?>"><div id="elh_email2_mensaje" class="email2_mensaje"><?= $Page->renderSort($Page->mensaje) ?></div></th>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
        <th data-name="archivo" class="<?= $Page->archivo->headerCellClass() ?>"><div id="elh_email2_archivo" class="email2_archivo"><?= $Page->renderSort($Page->archivo) ?></div></th>
<?php } ?>
<?php if ($Page->tiempo->Visible) { // tiempo ?>
        <th data-name="tiempo" class="<?= $Page->tiempo->headerCellClass() ?>"><div id="elh_email2_tiempo" class="email2_tiempo"><?= $Page->renderSort($Page->tiempo) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right", "", "block", $Page->TableVar, "email2list");
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
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

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

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_email2", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();

        // Save row and cell attributes
        $Page->Attrs[$Page->RowCount] = ["row_attrs" => $Page->rowAttributes(), "cell_attrs" => []];
        $Page->Attrs[$Page->RowCount]["cell_attrs"] = $Page->fieldCellAttributes();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount, "block", $Page->TableVar, "email2list");
?>
    <?php if ($Page->sender_userid->Visible) { // sender_userid ?>
        <td data-name="sender_userid" <?= $Page->sender_userid->cellAttributes() ?>>
<template id="tpx<?= $Page->RowCount ?>_email2_sender_userid"><span id="el<?= $Page->RowCount ?>_email2_sender_userid">
<span<?= $Page->sender_userid->viewAttributes() ?>>
<?= $Page->sender_userid->getViewValue() ?></span>
</span></template>
</td>
    <?php } ?>
    <?php if ($Page->copy_sender->Visible) { // copy_sender ?>
        <td data-name="copy_sender" <?= $Page->copy_sender->cellAttributes() ?>>
<template id="tpx<?= $Page->RowCount ?>_email2_copy_sender"><span id="el<?= $Page->RowCount ?>_email2_copy_sender">
<span<?= $Page->copy_sender->viewAttributes() ?>>
<?= $Page->copy_sender->getViewValue() ?></span>
</span></template>
</td>
    <?php } ?>
    <?php if ($Page->sujeto->Visible) { // sujeto ?>
        <td data-name="sujeto" <?= $Page->sujeto->cellAttributes() ?>>
<template id="tpx<?= $Page->RowCount ?>_email2_sujeto"><span id="el<?= $Page->RowCount ?>_email2_sujeto">
<span<?= $Page->sujeto->viewAttributes() ?>>
<?= $Page->sujeto->getViewValue() ?></span>
</span></template>
</td>
    <?php } ?>
    <?php if ($Page->mensaje->Visible) { // mensaje ?>
        <td data-name="mensaje" <?= $Page->mensaje->cellAttributes() ?>>
<template id="tpx<?= $Page->RowCount ?>_email2_mensaje"><span id="el<?= $Page->RowCount ?>_email2_mensaje">
<span<?= $Page->mensaje->viewAttributes() ?>>
<?= $Page->mensaje->getViewValue() ?></span>
</span></template>
</td>
    <?php } ?>
    <?php if ($Page->archivo->Visible) { // archivo ?>
        <td data-name="archivo" <?= $Page->archivo->cellAttributes() ?>>
<template id="tpx<?= $Page->RowCount ?>_email2_archivo" class="email2list">
<?php
$arcx = CurrentPage()->archivo->CurrentValue;
if ($arcx != '') { 
echo "<a href='/simexamerica/Inicio' ><i class='cil-paperclip'></i></a>";
}
?>
</template>
<template id="tpx<?= $Page->RowCount ?>_email2_archivo"><span id="el<?= $Page->RowCount ?>_email2_archivo">
<span<?= $Page->archivo->viewAttributes() ?>><slot name="tpx<?= $Page->RowCount ?>_email2_archivo"></slot></span>
</span></template>
</td>
    <?php } ?>
    <?php if ($Page->tiempo->Visible) { // tiempo ?>
        <td data-name="tiempo" <?= $Page->tiempo->cellAttributes() ?>>
<template id="tpx<?= $Page->RowCount ?>_email2_tiempo"><span id="el<?= $Page->RowCount ?>_email2_tiempo">
<span<?= $Page->tiempo->viewAttributes() ?>>
<?= $Page->tiempo->getViewValue() ?></span>
</span></template>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount, "block", $Page->TableVar, "email2list");
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<div id="tpd_email2list" class="ew-custom-template"></div>
<template id="tpm_email2list">
<div id="ct_Email2List"><?php if ($Page->RowCount > 0) { ?>
<section class="content">
      <div class="row" id="inbox">
        <div class="col-md-3">
          <a class="btn btn-primary btn-block mb-3 ew-add-edit ew-add" title="" data-table="email2" data-caption="Add" href="#" onclick="return ew.modalDialogShow({lnk:this,btn:'AddBtn',url:'/simexamerica/Email2Add'});" data-original-title="Add">Compose</a>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Folders</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                  <a href="#" class="nav-link">
                    <i class="fas fa-inbox"></i> Inbox
                    <span class="badge bg-primary float-right">12</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-envelope"></i> Sent
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-file-alt"></i> Drafts
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="fas fa-filter"></i> Junk
                    <span class="badge bg-warning float-right">65</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-trash-alt"></i> Trash
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
            <!-- /.card-body -->
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Inbox</h3>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
<?php for ($i = $Page->StartRowCount; $i <= $Page->RowCount; $i++) { ?>
<div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                  <tr>
                  <td class="mailbox-name" width="10%">xxxs</td>
                   <td class="mailbox-name" width="30%"><a href="read-mail.html"><slot class="ew-slot" name="tpx<?= $i ?>_email2_sender_userid"></slot></a></td>
                    <td class="mailbox-subject" width="30%"><b><slot class="ew-slot" name="tpx<?= $i ?>_email2_sujeto"></slot></b> - Trying to find a solution to this problem...
                    </td>
                    <td class="mailbox-attachment"width="10%"><slot class="ew-slot" name="tpx<?= $i ?>_email2_archivo"></slot></td>
                    <td class="mailbox-date" width="10%"><slot class="ew-slot" name="tpx<?= $i ?>_email2_tiempo"></slot></td>
                    <td class="mailbox-date" width="10%"><td class="ew-slot" id="tpob<?= $i ?>_email2" data-rowspan="1"></td></td>
                  </tr>
<?php } ?>
<?php if ($Page->TotalRecords > 0 && !$email2->isGridAdd() && !$email2->isGridEdit()) { ?>
      </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
<?php } ?>
<?php } ?>
</div>
</template>
</div><!-- /.ew-grid-middle-panel -->
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
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script>
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_email2list", "tpm_email2list", "email2list", "<?= $Page->CustomExport ?>", ew.templateData);
    loadjs.done("customtemplate");
});
</script>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("email2");
});
</script>
<script>
loadjs.ready("load", function () {
    // Startup script
    // Write your table-specific startup script here, no need to add script tags.
    //$('i').addClass('fab fa-accessible-icon ew-icon').removeClass('fas fa-plus ew-icon');
    //$('i').toggleClass('cil-mail ew-icon').toggleClass('fas fa-plus ew-icon');
    //$('i').toggleClass('cil-pen-alt');
    //$('i').addClass('cil-pen-alt').removeClass('fas fa-plus ew-icon');
});
</script>
<?php } ?>
