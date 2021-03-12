<?php

namespace PHPMaker2021\simexamerica;

// Page object
$ParticipantesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fparticipantesview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fparticipantesview = currentForm = new ew.Form("fparticipantesview", "view");
    loadjs.done("fparticipantesview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.participantes) ew.vars.tables.participantes = <?= JsonEncode(GetClientVar("tables", "participantes")) ?>;
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
<form name="fparticipantesview" id="fparticipantesview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="participantes">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_participantes->Visible) { // id_participantes ?>
    <tr id="r_id_participantes">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_participantes_id_participantes"><?= $Page->id_participantes->caption() ?></span></td>
        <td data-name="id_participantes" <?= $Page->id_participantes->cellAttributes() ?>>
<span id="el_participantes_id_participantes">
<span<?= $Page->id_participantes->viewAttributes() ?>>
<?= $Page->id_participantes->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nombres->Visible) { // nombres ?>
    <tr id="r_nombres">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_participantes_nombres"><?= $Page->nombres->caption() ?></span></td>
        <td data-name="nombres" <?= $Page->nombres->cellAttributes() ?>>
<span id="el_participantes_nombres">
<span<?= $Page->nombres->viewAttributes() ?>>
<?= $Page->nombres->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->apellidos->Visible) { // apellidos ?>
    <tr id="r_apellidos">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_participantes_apellidos"><?= $Page->apellidos->caption() ?></span></td>
        <td data-name="apellidos" <?= $Page->apellidos->cellAttributes() ?>>
<span id="el_participantes_apellidos">
<span<?= $Page->apellidos->viewAttributes() ?>>
<?= $Page->apellidos->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_login->Visible) { // login ?>
    <tr id="r__login">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_participantes__login"><?= $Page->_login->caption() ?></span></td>
        <td data-name="_login" <?= $Page->_login->cellAttributes() ?>>
<span id="el_participantes__login">
<span<?= $Page->_login->viewAttributes() ?>>
<?= $Page->_login->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <tr id="r__password">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_participantes__password"><?= $Page->_password->caption() ?></span></td>
        <td data-name="_password" <?= $Page->_password->cellAttributes() ?>>
<span id="el_participantes__password">
<span<?= $Page->_password->viewAttributes() ?>>
<?= $Page->_password->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_participantes__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email" <?= $Page->_email->cellAttributes() ?>>
<span id="el_participantes__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->grupo->Visible) { // grupo ?>
    <tr id="r_grupo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_participantes_grupo"><?= $Page->grupo->caption() ?></span></td>
        <td data-name="grupo" <?= $Page->grupo->cellAttributes() ?>>
<span id="el_participantes_grupo">
<span<?= $Page->grupo->viewAttributes() ?>>
<?= $Page->grupo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->subgrupo->Visible) { // subgrupo ?>
    <tr id="r_subgrupo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_participantes_subgrupo"><?= $Page->subgrupo->caption() ?></span></td>
        <td data-name="subgrupo" <?= $Page->subgrupo->cellAttributes() ?>>
<span id="el_participantes_subgrupo">
<span<?= $Page->subgrupo->viewAttributes() ?>>
<?= $Page->subgrupo->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->imagen_participante->Visible) { // imagen_participante ?>
    <tr id="r_imagen_participante">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_participantes_imagen_participante"><?= $Page->imagen_participante->caption() ?></span></td>
        <td data-name="imagen_participante" <?= $Page->imagen_participante->cellAttributes() ?>>
<span id="el_participantes_imagen_participante">
<span<?= $Page->imagen_participante->viewAttributes() ?>>
<?= $Page->imagen_participante->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_escenario->Visible) { // id_escenario ?>
    <tr id="r_id_escenario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_participantes_id_escenario"><?= $Page->id_escenario->caption() ?></span></td>
        <td data-name="id_escenario" <?= $Page->id_escenario->cellAttributes() ?>>
<span id="el_participantes_id_escenario">
<span<?= $Page->id_escenario->viewAttributes() ?>>
<?= $Page->id_escenario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
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
