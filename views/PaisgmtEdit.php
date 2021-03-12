<?php

namespace PHPMaker2021\simexamerica;

// Page object
$PaisgmtEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpaisgmtedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fpaisgmtedit = currentForm = new ew.Form("fpaisgmtedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "paisgmt")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.paisgmt)
        ew.vars.tables.paisgmt = currentTable;
    fpaisgmtedit.addFields([
        ["id_zone", [fields.id_zone.visible && fields.id_zone.required ? ew.Validators.required(fields.id_zone.caption) : null], fields.id_zone.isInvalid],
        ["codpais", [fields.codpais.visible && fields.codpais.required ? ew.Validators.required(fields.codpais.caption) : null], fields.codpais.isInvalid],
        ["nompais", [fields.nompais.visible && fields.nompais.required ? ew.Validators.required(fields.nompais.caption) : null], fields.nompais.isInvalid],
        ["timezone", [fields.timezone.visible && fields.timezone.required ? ew.Validators.required(fields.timezone.caption) : null], fields.timezone.isInvalid],
        ["gmt", [fields.gmt.visible && fields.gmt.required ? ew.Validators.required(fields.gmt.caption) : null], fields.gmt.isInvalid],
        ["codiso3", [fields.codiso3.visible && fields.codiso3.required ? ew.Validators.required(fields.codiso3.caption) : null], fields.codiso3.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpaisgmtedit,
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
    fpaisgmtedit.validate = function () {
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

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fpaisgmtedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpaisgmtedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fpaisgmtedit");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpaisgmtedit" id="fpaisgmtedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="paisgmt">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->id_zone->Visible) { // id_zone ?>
    <div id="r_id_zone" class="form-group row">
        <label id="elh_paisgmt_id_zone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_zone->caption() ?><?= $Page->id_zone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->id_zone->cellAttributes() ?>>
<span id="el_paisgmt_id_zone">
<span<?= $Page->id_zone->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_zone->getDisplayValue($Page->id_zone->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="paisgmt" data-field="x_id_zone" data-hidden="1" name="x_id_zone" id="x_id_zone" value="<?= HtmlEncode($Page->id_zone->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codpais->Visible) { // codpais ?>
    <div id="r_codpais" class="form-group row">
        <label id="elh_paisgmt_codpais" for="x_codpais" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codpais->caption() ?><?= $Page->codpais->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->codpais->cellAttributes() ?>>
<span id="el_paisgmt_codpais">
<input type="<?= $Page->codpais->getInputTextType() ?>" data-table="paisgmt" data-field="x_codpais" name="x_codpais" id="x_codpais" size="30" maxlength="3" placeholder="<?= HtmlEncode($Page->codpais->getPlaceHolder()) ?>" value="<?= $Page->codpais->EditValue ?>"<?= $Page->codpais->editAttributes() ?> aria-describedby="x_codpais_help">
<?= $Page->codpais->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codpais->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nompais->Visible) { // nompais ?>
    <div id="r_nompais" class="form-group row">
        <label id="elh_paisgmt_nompais" for="x_nompais" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nompais->caption() ?><?= $Page->nompais->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nompais->cellAttributes() ?>>
<span id="el_paisgmt_nompais">
<input type="<?= $Page->nompais->getInputTextType() ?>" data-table="paisgmt" data-field="x_nompais" name="x_nompais" id="x_nompais" size="30" maxlength="60" placeholder="<?= HtmlEncode($Page->nompais->getPlaceHolder()) ?>" value="<?= $Page->nompais->EditValue ?>"<?= $Page->nompais->editAttributes() ?> aria-describedby="x_nompais_help">
<?= $Page->nompais->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nompais->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->timezone->Visible) { // timezone ?>
    <div id="r_timezone" class="form-group row">
        <label id="elh_paisgmt_timezone" for="x_timezone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->timezone->caption() ?><?= $Page->timezone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->timezone->cellAttributes() ?>>
<span id="el_paisgmt_timezone">
<input type="<?= $Page->timezone->getInputTextType() ?>" data-table="paisgmt" data-field="x_timezone" name="x_timezone" id="x_timezone" size="30" maxlength="40" placeholder="<?= HtmlEncode($Page->timezone->getPlaceHolder()) ?>" value="<?= $Page->timezone->EditValue ?>"<?= $Page->timezone->editAttributes() ?> aria-describedby="x_timezone_help">
<?= $Page->timezone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->timezone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gmt->Visible) { // gmt ?>
    <div id="r_gmt" class="form-group row">
        <label id="elh_paisgmt_gmt" for="x_gmt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->gmt->caption() ?><?= $Page->gmt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->gmt->cellAttributes() ?>>
<span id="el_paisgmt_gmt">
<input type="<?= $Page->gmt->getInputTextType() ?>" data-table="paisgmt" data-field="x_gmt" name="x_gmt" id="x_gmt" size="30" maxlength="20" placeholder="<?= HtmlEncode($Page->gmt->getPlaceHolder()) ?>" value="<?= $Page->gmt->EditValue ?>"<?= $Page->gmt->editAttributes() ?> aria-describedby="x_gmt_help">
<?= $Page->gmt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->gmt->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->codiso3->Visible) { // codiso3 ?>
    <div id="r_codiso3" class="form-group row">
        <label id="elh_paisgmt_codiso3" for="x_codiso3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->codiso3->caption() ?><?= $Page->codiso3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->codiso3->cellAttributes() ?>>
<span id="el_paisgmt_codiso3">
<input type="<?= $Page->codiso3->getInputTextType() ?>" data-table="paisgmt" data-field="x_codiso3" name="x_codiso3" id="x_codiso3" size="30" maxlength="4" placeholder="<?= HtmlEncode($Page->codiso3->getPlaceHolder()) ?>" value="<?= $Page->codiso3->EditValue ?>"<?= $Page->codiso3->editAttributes() ?> aria-describedby="x_codiso3_help">
<?= $Page->codiso3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->codiso3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("paisgmt");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
