<?php

namespace PHPMaker2021\simexamerica;

// Page object
$MensajesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmensajesview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fmensajesview = currentForm = new ew.Form("fmensajesview", "view");
    loadjs.done("fmensajesview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.mensajes) ew.vars.tables.mensajes = <?= JsonEncode(GetClientVar("tables", "mensajes")) ?>;
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
<form name="fmensajesview" id="fmensajesview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mensajes">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_inyect->Visible) { // id_inyect ?>
    <tr id="r_id_inyect">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_id_inyect"><?= $Page->id_inyect->caption() ?></span></td>
        <td data-name="id_inyect" <?= $Page->id_inyect->cellAttributes() ?>>
<span id="el_mensajes_id_inyect">
<span<?= $Page->id_inyect->viewAttributes() ?>>
<?= $Page->id_inyect->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_tareas->Visible) { // id_tareas ?>
    <tr id="r_id_tareas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_id_tareas"><?= $Page->id_tareas->caption() ?></span></td>
        <td data-name="id_tareas" <?= $Page->id_tareas->cellAttributes() ?>>
<span id="el_mensajes_id_tareas">
<span<?= $Page->id_tareas->viewAttributes() ?>>
<?= $Page->id_tareas->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
    <tr id="r_titulo">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_titulo"><?= $Page->titulo->caption() ?></span></td>
        <td data-name="titulo" <?= $Page->titulo->cellAttributes() ?>>
<span id="el_mensajes_titulo">
<span<?= $Page->titulo->viewAttributes() ?>>
<?php if (!EmptyString($Page->titulo->TooltipValue) && $Page->titulo->linkAttributes() != "") { ?>
<a<?= $Page->titulo->linkAttributes() ?>><?= $Page->titulo->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->titulo->getViewValue() ?>
<?php } ?>
<span id="tt_mensajes_x_titulo" class="d-none">
<?= $Page->titulo->TooltipValue ?>
</span></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
    <tr id="r_mensaje">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_mensaje"><?= $Page->mensaje->caption() ?></span></td>
        <td data-name="mensaje" <?= $Page->mensaje->cellAttributes() ?>>
<span id="el_mensajes_mensaje">
<span<?= $Page->mensaje->viewAttributes() ?>>
<?= $Page->mensaje->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechareal_start->Visible) { // fechareal_start ?>
    <tr id="r_fechareal_start">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_fechareal_start"><?= $Page->fechareal_start->caption() ?></span></td>
        <td data-name="fechareal_start" <?= $Page->fechareal_start->cellAttributes() ?>>
<span id="el_mensajes_fechareal_start">
<span<?= $Page->fechareal_start->viewAttributes() ?>>
<?= $Page->fechareal_start->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->fechasim_start->Visible) { // fechasim_start ?>
    <tr id="r_fechasim_start">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_fechasim_start"><?= $Page->fechasim_start->caption() ?></span></td>
        <td data-name="fechasim_start" <?= $Page->fechasim_start->cellAttributes() ?>>
<span id="el_mensajes_fechasim_start">
<span<?= $Page->fechasim_start->viewAttributes() ?>>
<?= $Page->fechasim_start->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->medios->Visible) { // medios ?>
    <tr id="r_medios">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_medios"><?= $Page->medios->caption() ?></span></td>
        <td data-name="medios" <?= $Page->medios->cellAttributes() ?>>
<span id="el_mensajes_medios">
<span<?= $Page->medios->viewAttributes() ?>>
<?= $Page->medios->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->actividad_esperada->Visible) { // actividad_esperada ?>
    <tr id="r_actividad_esperada">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_actividad_esperada"><?= $Page->actividad_esperada->caption() ?></span></td>
        <td data-name="actividad_esperada" <?= $Page->actividad_esperada->cellAttributes() ?>>
<span id="el_mensajes_actividad_esperada">
<span<?= $Page->actividad_esperada->viewAttributes() ?>>
<?= $Page->actividad_esperada->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_actor->Visible) { // id_actor ?>
    <tr id="r_id_actor">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_id_actor"><?= $Page->id_actor->caption() ?></span></td>
        <td data-name="id_actor" <?= $Page->id_actor->cellAttributes() ?>>
<span id="el_mensajes_id_actor">
<span<?= $Page->id_actor->viewAttributes() ?>>
<?= $Page->id_actor->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->enviado->Visible) { // enviado ?>
    <tr id="r_enviado">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_enviado"><?= $Page->enviado->caption() ?></span></td>
        <td data-name="enviado" <?= $Page->enviado->cellAttributes() ?>>
<span id="el_mensajes_enviado">
<span<?= $Page->enviado->viewAttributes() ?>>
<?= $Page->enviado->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->para->Visible) { // para ?>
    <tr id="r_para">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_para"><?= $Page->para->caption() ?></span></td>
        <td data-name="para" <?= $Page->para->cellAttributes() ?>>
<span id="el_mensajes_para">
<span<?= $Page->para->viewAttributes() ?>>
<?= $Page->para->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->adjunto->Visible) { // adjunto ?>
    <tr id="r_adjunto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_adjunto"><?= $Page->adjunto->caption() ?></span></td>
        <td data-name="adjunto" <?= $Page->adjunto->cellAttributes() ?>>
<span id="el_mensajes_adjunto">
<span<?= $Page->adjunto->viewAttributes() ?>>
<?= GetFileViewTag($Page->adjunto, $Page->adjunto->getViewValue(), false) ?>
</span>
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
