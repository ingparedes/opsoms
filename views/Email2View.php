<?php

namespace PHPMaker2021\simexamerica;

// Page object
$Email2View = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var femail2view;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    femail2view = currentForm = new ew.Form("femail2view", "view");
    loadjs.done("femail2view");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.email2) ew.vars.tables.email2 = <?= JsonEncode(GetClientVar("tables", "email2")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl() ?>">
<?= $Page->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<?php } ?>
<form name="femail2view" id="femail2view" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="email2">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table d-none">
<?php if ($Page->id_email->Visible) { // id_email ?>
    <tr id="r_id_email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_email2_id_email"><template id="tpc_email2_id_email"><?= $Page->id_email->caption() ?></template></span></td>
        <td data-name="id_email" <?= $Page->id_email->cellAttributes() ?>>
<template id="tpx_email2_id_email"><span id="el_email2_id_email">
<span<?= $Page->id_email->viewAttributes() ?>>
<?= $Page->id_email->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sender_userid->Visible) { // sender_userid ?>
    <tr id="r_sender_userid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_email2_sender_userid"><template id="tpc_email2_sender_userid"><?= $Page->sender_userid->caption() ?></template></span></td>
        <td data-name="sender_userid" <?= $Page->sender_userid->cellAttributes() ?>>
<template id="tpx_email2_sender_userid"><span id="el_email2_sender_userid">
<span<?= $Page->sender_userid->viewAttributes() ?>>
<?= $Page->sender_userid->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->copy_sender->Visible) { // copy_sender ?>
    <tr id="r_copy_sender">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_email2_copy_sender"><template id="tpc_email2_copy_sender"><?= $Page->copy_sender->caption() ?></template></span></td>
        <td data-name="copy_sender" <?= $Page->copy_sender->cellAttributes() ?>>
<template id="tpx_email2_copy_sender"><span id="el_email2_copy_sender">
<span<?= $Page->copy_sender->viewAttributes() ?>>
<?= $Page->copy_sender->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sujeto->Visible) { // sujeto ?>
    <tr id="r_sujeto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_email2_sujeto"><template id="tpc_email2_sujeto"><?= $Page->sujeto->caption() ?></template></span></td>
        <td data-name="sujeto" <?= $Page->sujeto->cellAttributes() ?>>
<template id="tpx_email2_sujeto"><span id="el_email2_sujeto">
<span<?= $Page->sujeto->viewAttributes() ?>>
<?= $Page->sujeto->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
    <tr id="r_mensaje">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_email2_mensaje"><template id="tpc_email2_mensaje"><?= $Page->mensaje->caption() ?></template></span></td>
        <td data-name="mensaje" <?= $Page->mensaje->cellAttributes() ?>>
<template id="tpx_email2_mensaje"><span id="el_email2_mensaje">
<span<?= $Page->mensaje->viewAttributes() ?>>
<?= $Page->mensaje->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->archivo->Visible) { // archivo ?>
    <tr id="r_archivo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_email2_archivo"><template id="tpc_email2_archivo"><?= $Page->archivo->caption() ?></template></span></td>
        <td data-name="archivo" <?= $Page->archivo->cellAttributes() ?>>
<template id="tpx_email2_archivo" class="email2view">
<?php
$arcx = CurrentPage()->archivo->CurrentValue;
if ($arcx != '') { 
echo "<a href='/simexamerica/Inicio' ><i class='cil-paperclip'></i></a>";
}
?>
</template>
<template id="tpx_email2_archivo"><span id="el_email2_archivo">
<span<?= $Page->archivo->viewAttributes() ?>><slot name="tpx_email2_archivo"></slot></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->reciever_userid->Visible) { // reciever_userid ?>
    <tr id="r_reciever_userid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_email2_reciever_userid"><template id="tpc_email2_reciever_userid"><?= $Page->reciever_userid->caption() ?></template></span></td>
        <td data-name="reciever_userid" <?= $Page->reciever_userid->cellAttributes() ?>>
<template id="tpx_email2_reciever_userid"><span id="el_email2_reciever_userid">
<span<?= $Page->reciever_userid->viewAttributes() ?>>
<?= $Page->reciever_userid->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tiempo->Visible) { // tiempo ?>
    <tr id="r_tiempo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_email2_tiempo"><template id="tpc_email2_tiempo"><?= $Page->tiempo->caption() ?></template></span></td>
        <td data-name="tiempo" <?= $Page->tiempo->cellAttributes() ?>>
<template id="tpx_email2_tiempo"><span id="el_email2_tiempo">
<span<?= $Page->tiempo->viewAttributes() ?>>
<?= $Page->tiempo->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_email2_status"><template id="tpc_email2_status"><?= $Page->status->caption() ?></template></span></td>
        <td data-name="status" <?= $Page->status->cellAttributes() ?>>
<template id="tpx_email2_status"><span id="el_email2_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span></template>
</td>
    </tr>
<?php } ?>
</table>
<div id="tpd_email2view" class="ew-custom-template"></div>
<template id="tpm_email2view">
<div id="ct_Email2View">       <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Read Mail</h3>
              <div class="card-tools">
                <a href="#" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
                <a href="#" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-read-info">
                <h5><slot class="ew-slot" name="tpx_email2_sujeto"></slot></h5>
                <h6>From: <slot class="ew-slot" name="tpx_email2_sender_userid"></slot>
                  <span class="mailbox-read-time float-right"><slot class="ew-slot" name="tpx_email2_tiempo"></slot></span></h6>
              </div>
              <!-- /.mailbox-read-info -->
              <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm" data-container="body" title="Delete">
                    <i class="far fa-trash-alt"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm" data-container="body" title="Reply">
                    <i class="fas fa-reply"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm" data-container="body" title="Forward">
                    <i class="fas fa-share"></i>
                  </button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm" title="Print">
                  <i class="fas fa-print"></i>
                </button>
              </div>
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                <slot class="ew-slot" name="tpx_email2_mensaje"></slot>
               </div>
              <!-- /.mailbox-read-message -->
            </div>
            <div class="card-footer">
              <div class="float-right">
                <button type="button" class="btn btn-default"><i class="fas fa-reply"></i> Reply</button>
                <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Forward</button>
              </div>
              <button type="button" class="btn btn-default"><i class="far fa-trash-alt"></i> Delete</button>
              <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
            </div>
            <!-- /.card-footer -->
          </div>
</div>
</div>
</template>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<script>
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_email2view", "tpm_email2view", "email2view", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
