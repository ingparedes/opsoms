<?php

namespace PHPMaker2021\simexamerica;

// Table
$escenario = Container("escenario");
?>
<?php if ($escenario->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_escenariomaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($escenario->id_escenario->Visible) { // id_escenario ?>
        <tr id="r_id_escenario">
            <td class="<?= $escenario->TableLeftColumnClass ?>"><?= $escenario->id_escenario->caption() ?></td>
            <td <?= $escenario->id_escenario->cellAttributes() ?>>
<span id="el_escenario_id_escenario">
<span<?= $escenario->id_escenario->viewAttributes() ?>>
<?= $escenario->id_escenario->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($escenario->icon_escenario->Visible) { // icon_escenario ?>
        <tr id="r_icon_escenario">
            <td class="<?= $escenario->TableLeftColumnClass ?>"><?= $escenario->icon_escenario->caption() ?></td>
            <td <?= $escenario->icon_escenario->cellAttributes() ?>>
<span id="el_escenario_icon_escenario">
<span><?php
$idm = CurrentPage()->icon_escenario->CurrentValue;
echo "<img width='25px' src='$idm'>";
?>
</span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($escenario->fechacreacion_escenario->Visible) { // fechacreacion_escenario ?>
        <tr id="r_fechacreacion_escenario">
            <td class="<?= $escenario->TableLeftColumnClass ?>"><?= $escenario->fechacreacion_escenario->caption() ?></td>
            <td <?= $escenario->fechacreacion_escenario->cellAttributes() ?>>
<span id="el_escenario_fechacreacion_escenario">
<span<?= $escenario->fechacreacion_escenario->viewAttributes() ?>>
<?= $escenario->fechacreacion_escenario->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($escenario->nombre_escenario->Visible) { // nombre_escenario ?>
        <tr id="r_nombre_escenario">
            <td class="<?= $escenario->TableLeftColumnClass ?>"><?= $escenario->nombre_escenario->caption() ?></td>
            <td <?= $escenario->nombre_escenario->cellAttributes() ?>>
<span id="el_escenario_nombre_escenario">
<span<?= $escenario->nombre_escenario->viewAttributes() ?>>
<?= $escenario->nombre_escenario->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($escenario->incidente->Visible) { // incidente ?>
        <tr id="r_incidente">
            <td class="<?= $escenario->TableLeftColumnClass ?>"><?= $escenario->incidente->caption() ?></td>
            <td <?= $escenario->incidente->cellAttributes() ?>>
<span id="el_escenario_incidente">
<span<?= $escenario->incidente->viewAttributes() ?>>
<?= $escenario->incidente->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($escenario->pais_escenario->Visible) { // pais_escenario ?>
        <tr id="r_pais_escenario">
            <td class="<?= $escenario->TableLeftColumnClass ?>"><?= $escenario->pais_escenario->caption() ?></td>
            <td <?= $escenario->pais_escenario->cellAttributes() ?>>
<span id="el_escenario_pais_escenario">
<span<?= $escenario->pais_escenario->viewAttributes() ?>>
<?= $escenario->pais_escenario->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($escenario->fechaini_simulado->Visible) { // fechaini_simulado ?>
        <tr id="r_fechaini_simulado">
            <td class="<?= $escenario->TableLeftColumnClass ?>"><?= $escenario->fechaini_simulado->caption() ?></td>
            <td <?= $escenario->fechaini_simulado->cellAttributes() ?>>
<span id="el_escenario_fechaini_simulado">
<span<?= $escenario->fechaini_simulado->viewAttributes() ?>>
<?= $escenario->fechaini_simulado->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($escenario->fechaini_real->Visible) { // fechaini_real ?>
        <tr id="r_fechaini_real">
            <td class="<?= $escenario->TableLeftColumnClass ?>"><?= $escenario->fechaini_real->caption() ?></td>
            <td <?= $escenario->fechaini_real->cellAttributes() ?>>
<span id="el_escenario_fechaini_real">
<span<?= $escenario->fechaini_real->viewAttributes() ?>>
<?= $escenario->fechaini_real->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($escenario->estado->Visible) { // estado ?>
        <tr id="r_estado">
            <td class="<?= $escenario->TableLeftColumnClass ?>"><?= $escenario->estado->caption() ?></td>
            <td <?= $escenario->estado->cellAttributes() ?>>
<span id="el_escenario_estado">
<span<?= $escenario->estado->viewAttributes() ?>>
<?= $escenario->estado->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($escenario->entrar->Visible) { // entrar ?>
        <tr id="r_entrar">
            <td class="<?= $escenario->TableLeftColumnClass ?>"><?= $escenario->entrar->caption() ?></td>
            <td <?= $escenario->entrar->cellAttributes() ?>>
<span id="el_escenario_entrar">
<span<?= $escenario->entrar->viewAttributes() ?>><div class = "btn-group btn-group-sm ew-btn-group">
<?php
$id = CurrentPage()->entrar->CurrentValue;
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"\" data-table=\"escenario\" data-caption=\"Grupo\" href=\"GrupoList?showmaster=escenario&fk_id_escenario=$id&showdetail=\" data-original-title=\"Grupo\"><i class=\"fa fa-user-plus\"data-caption=\"Grupo\"></i></a> <br>";
echo "<a class=\"btn btn-default ew-row-link ew-view\" title=\"\" data-table=\"escenario\" data-caption=\"Tarea\" href=\"TareasList?showmaster=escenario&fk_id_escenario=$id\" data-original-title=\"Tareas\"><i class=\"fa fa-list-alt\" data-caption=\"Tareas\"></i></a>";
?>
</div>
</span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
