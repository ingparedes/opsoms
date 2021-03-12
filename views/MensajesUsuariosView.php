<?php

namespace PHPMaker2021\simexamerica;

// Page object
$MensajesUsuariosView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmensajes_usuariosview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fmensajes_usuariosview = currentForm = new ew.Form("fmensajes_usuariosview", "view");
    loadjs.done("fmensajes_usuariosview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.mensajes_usuarios) ew.vars.tables.mensajes_usuarios = <?= JsonEncode(GetClientVar("tables", "mensajes_usuarios")) ?>;
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
<form name="fmensajes_usuariosview" id="fmensajes_usuariosview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl() ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mensajes_usuarios">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id_mensaje_usuario->Visible) { // id_mensaje_usuario ?>
    <tr id="r_id_mensaje_usuario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_usuarios_id_mensaje_usuario"><?= $Page->id_mensaje_usuario->caption() ?></span></td>
        <td data-name="id_mensaje_usuario" <?= $Page->id_mensaje_usuario->cellAttributes() ?>>
<span id="el_mensajes_usuarios_id_mensaje_usuario">
<span<?= $Page->id_mensaje_usuario->viewAttributes() ?>>
<?= $Page->id_mensaje_usuario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_user_remitente->Visible) { // id_user_remitente ?>
    <tr id="r_id_user_remitente">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_usuarios_id_user_remitente"><?= $Page->id_user_remitente->caption() ?></span></td>
        <td data-name="id_user_remitente" <?= $Page->id_user_remitente->cellAttributes() ?>>
<span id="el_mensajes_usuarios_id_user_remitente">
<span<?= $Page->id_user_remitente->viewAttributes() ?>>
<?= $Page->id_user_remitente->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_user_destinatario->Visible) { // id_user_destinatario ?>
    <tr id="r_id_user_destinatario">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_usuarios_id_user_destinatario"><?= $Page->id_user_destinatario->caption() ?></span></td>
        <td data-name="id_user_destinatario" <?= $Page->id_user_destinatario->cellAttributes() ?>>
<span id="el_mensajes_usuarios_id_user_destinatario">
<span<?= $Page->id_user_destinatario->viewAttributes() ?>>
<?= $Page->id_user_destinatario->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->id_mensaje->Visible) { // id_mensaje ?>
    <tr id="r_id_mensaje">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mensajes_usuarios_id_mensaje"><?= $Page->id_mensaje->caption() ?></span></td>
        <td data-name="id_mensaje" <?= $Page->id_mensaje->cellAttributes() ?>>
<span id="el_mensajes_usuarios_id_mensaje">
<span<?= $Page->id_mensaje->viewAttributes() ?>>
<?= $Page->id_mensaje->getViewValue() ?></span>
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
