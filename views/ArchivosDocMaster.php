<?php

namespace PHPMaker2021\simexamerica;

// Table
$archivos_doc = Container("archivos_doc");
?>
<?php if ($archivos_doc->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_archivos_docmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($archivos_doc->id_file->Visible) { // id_file ?>
        <tr id="r_id_file">
            <td class="<?= $archivos_doc->TableLeftColumnClass ?>"><?= $archivos_doc->id_file->caption() ?></td>
            <td <?= $archivos_doc->id_file->cellAttributes() ?>>
<span id="el_archivos_doc_id_file">
<span<?= $archivos_doc->id_file->viewAttributes() ?>>
<?= $archivos_doc->id_file->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($archivos_doc->id_users->Visible) { // id_users ?>
        <tr id="r_id_users">
            <td class="<?= $archivos_doc->TableLeftColumnClass ?>"><?= $archivos_doc->id_users->caption() ?></td>
            <td <?= $archivos_doc->id_users->cellAttributes() ?>>
<span id="el_archivos_doc_id_users">
<span<?= $archivos_doc->id_users->viewAttributes() ?>>
<?= $archivos_doc->id_users->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($archivos_doc->file_name->Visible) { // file_name ?>
        <tr id="r_file_name">
            <td class="<?= $archivos_doc->TableLeftColumnClass ?>"><?= $archivos_doc->file_name->caption() ?></td>
            <td <?= $archivos_doc->file_name->cellAttributes() ?>>
<span id="el_archivos_doc_file_name">
<span<?= $archivos_doc->file_name->viewAttributes() ?>>
<?= GetFileViewTag($archivos_doc->file_name, $archivos_doc->file_name->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($archivos_doc->fecha_created->Visible) { // fecha_created ?>
        <tr id="r_fecha_created">
            <td class="<?= $archivos_doc->TableLeftColumnClass ?>"><?= $archivos_doc->fecha_created->caption() ?></td>
            <td <?= $archivos_doc->fecha_created->cellAttributes() ?>>
<span id="el_archivos_doc_fecha_created">
<span<?= $archivos_doc->fecha_created->viewAttributes() ?>>
<?= $archivos_doc->fecha_created->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
