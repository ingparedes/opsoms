<?php

namespace PHPMaker2021\simexamerica;

// Table
$tareas = Container("tareas");
?>
<?php if ($tareas->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_tareasmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($tareas->id_tarea->Visible) { // id_tarea ?>
        <tr id="r_id_tarea">
            <td class="<?= $tareas->TableLeftColumnClass ?>"><?= $tareas->id_tarea->caption() ?></td>
            <td <?= $tareas->id_tarea->cellAttributes() ?>>
<span id="el_tareas_id_tarea">
<span<?= $tareas->id_tarea->viewAttributes() ?>>
<?= $tareas->id_tarea->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($tareas->id_grupo->Visible) { // id_grupo ?>
        <tr id="r_id_grupo">
            <td class="<?= $tareas->TableLeftColumnClass ?>"><?= $tareas->id_grupo->caption() ?></td>
            <td <?= $tareas->id_grupo->cellAttributes() ?>>
<span id="el_tareas_id_grupo">
<span<?= $tareas->id_grupo->viewAttributes() ?>>
<?= $tareas->id_grupo->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($tareas->titulo_tarea->Visible) { // titulo_tarea ?>
        <tr id="r_titulo_tarea">
            <td class="<?= $tareas->TableLeftColumnClass ?>"><?= $tareas->titulo_tarea->caption() ?></td>
            <td <?= $tareas->titulo_tarea->cellAttributes() ?>>
<span id="el_tareas_titulo_tarea">
<span<?= $tareas->titulo_tarea->viewAttributes() ?>>
<?= $tareas->titulo_tarea->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($tareas->fechainireal_tarea->Visible) { // fechainireal_tarea ?>
        <tr id="r_fechainireal_tarea">
            <td class="<?= $tareas->TableLeftColumnClass ?>"><?= $tareas->fechainireal_tarea->caption() ?></td>
            <td <?= $tareas->fechainireal_tarea->cellAttributes() ?>>
<span id="el_tareas_fechainireal_tarea">
<span<?= $tareas->fechainireal_tarea->viewAttributes() ?>>
<?= $tareas->fechainireal_tarea->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($tareas->fechafin_tarea->Visible) { // fechafin_tarea ?>
        <tr id="r_fechafin_tarea">
            <td class="<?= $tareas->TableLeftColumnClass ?>"><?= $tareas->fechafin_tarea->caption() ?></td>
            <td <?= $tareas->fechafin_tarea->cellAttributes() ?>>
<span id="el_tareas_fechafin_tarea">
<span<?= $tareas->fechafin_tarea->viewAttributes() ?>>
<?= $tareas->fechafin_tarea->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($tareas->fechainisimulado_tarea->Visible) { // fechainisimulado_tarea ?>
        <tr id="r_fechainisimulado_tarea">
            <td class="<?= $tareas->TableLeftColumnClass ?>"><?= $tareas->fechainisimulado_tarea->caption() ?></td>
            <td <?= $tareas->fechainisimulado_tarea->cellAttributes() ?>>
<span id="el_tareas_fechainisimulado_tarea">
<span<?= $tareas->fechainisimulado_tarea->viewAttributes() ?>>
<?= $tareas->fechainisimulado_tarea->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($tareas->fechafinsimulado_tarea->Visible) { // fechafinsimulado_tarea ?>
        <tr id="r_fechafinsimulado_tarea">
            <td class="<?= $tareas->TableLeftColumnClass ?>"><?= $tareas->fechafinsimulado_tarea->caption() ?></td>
            <td <?= $tareas->fechafinsimulado_tarea->cellAttributes() ?>>
<span id="el_tareas_fechafinsimulado_tarea">
<span<?= $tareas->fechafinsimulado_tarea->viewAttributes() ?>>
<?= $tareas->fechafinsimulado_tarea->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
