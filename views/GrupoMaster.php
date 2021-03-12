<?php

namespace PHPMaker2021\simexamerica;

// Table
$grupo = Container("grupo");
?>
<?php if ($grupo->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_grupomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($grupo->id_grupo->Visible) { // id_grupo ?>
        <tr id="r_id_grupo">
            <td class="<?= $grupo->TableLeftColumnClass ?>"><?= $grupo->id_grupo->caption() ?></td>
            <td <?= $grupo->id_grupo->cellAttributes() ?>>
<span id="el_grupo_id_grupo">
<span<?= $grupo->id_grupo->viewAttributes() ?>>
<?= $grupo->id_grupo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($grupo->imgen_grupo->Visible) { // imgen_grupo ?>
        <tr id="r_imgen_grupo">
            <td class="<?= $grupo->TableLeftColumnClass ?>"><?= $grupo->imgen_grupo->caption() ?></td>
            <td <?= $grupo->imgen_grupo->cellAttributes() ?>>
<span id="el_grupo_imgen_grupo">
<span>
<?= GetFileViewTag($grupo->imgen_grupo, $grupo->imgen_grupo->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($grupo->nombre_grupo->Visible) { // nombre_grupo ?>
        <tr id="r_nombre_grupo">
            <td class="<?= $grupo->TableLeftColumnClass ?>"><?= $grupo->nombre_grupo->caption() ?></td>
            <td <?= $grupo->nombre_grupo->cellAttributes() ?>>
<span id="el_grupo_nombre_grupo">
<span<?= $grupo->nombre_grupo->viewAttributes() ?>>
<?= $grupo->nombre_grupo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
