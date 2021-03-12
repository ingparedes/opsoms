<?php

namespace PHPMaker2021\simexamerica;

// Page object
$TareasPreview = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid tareas"><!-- .card -->
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel ew-preview-middle-panel"><!-- .table-responsive -->
<table class="table ew-table ew-preview-table"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id_tarea->Visible) { // id_tarea ?>
    <?php if ($Page->SortUrl($Page->id_tarea) == "") { ?>
        <th class="<?= $Page->id_tarea->headerCellClass() ?>"><?= $Page->id_tarea->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_tarea->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id_tarea->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->id_tarea->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id_tarea->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->id_tarea->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
    <?php if ($Page->SortUrl($Page->id_grupo) == "") { ?>
        <th class="<?= $Page->id_grupo->headerCellClass() ?>"><?= $Page->id_grupo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_grupo->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id_grupo->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->id_grupo->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id_grupo->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->id_grupo->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->titulo_tarea->Visible) { // titulo_tarea ?>
    <?php if ($Page->SortUrl($Page->titulo_tarea) == "") { ?>
        <th class="<?= $Page->titulo_tarea->headerCellClass() ?>"><?= $Page->titulo_tarea->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->titulo_tarea->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->titulo_tarea->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->titulo_tarea->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->titulo_tarea->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->titulo_tarea->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fechainireal_tarea->Visible) { // fechainireal_tarea ?>
    <?php if ($Page->SortUrl($Page->fechainireal_tarea) == "") { ?>
        <th class="<?= $Page->fechainireal_tarea->headerCellClass() ?>"><?= $Page->fechainireal_tarea->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fechainireal_tarea->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->fechainireal_tarea->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->fechainireal_tarea->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->fechainireal_tarea->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->fechainireal_tarea->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fechafin_tarea->Visible) { // fechafin_tarea ?>
    <?php if ($Page->SortUrl($Page->fechafin_tarea) == "") { ?>
        <th class="<?= $Page->fechafin_tarea->headerCellClass() ?>"><?= $Page->fechafin_tarea->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fechafin_tarea->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->fechafin_tarea->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->fechafin_tarea->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->fechafin_tarea->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->fechafin_tarea->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fechainisimulado_tarea->Visible) { // fechainisimulado_tarea ?>
    <?php if ($Page->SortUrl($Page->fechainisimulado_tarea) == "") { ?>
        <th class="<?= $Page->fechainisimulado_tarea->headerCellClass() ?>"><?= $Page->fechainisimulado_tarea->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fechainisimulado_tarea->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->fechainisimulado_tarea->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->fechainisimulado_tarea->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->fechainisimulado_tarea->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->fechainisimulado_tarea->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fechafinsimulado_tarea->Visible) { // fechafinsimulado_tarea ?>
    <?php if ($Page->SortUrl($Page->fechafinsimulado_tarea) == "") { ?>
        <th class="<?= $Page->fechafinsimulado_tarea->headerCellClass() ?>"><?= $Page->fechafinsimulado_tarea->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fechafinsimulado_tarea->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->fechafinsimulado_tarea->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->fechafinsimulado_tarea->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->fechafinsimulado_tarea->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->fechafinsimulado_tarea->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
<?php
$Page->RecCount = 0;
$Page->RowCount = 0;
while ($Page->Recordset && !$Page->Recordset->EOF) {
    // Init row class and style
    $Page->RecCount++;
    $Page->RowCount++;
    $Page->CssStyle = "";
    $Page->loadListRowValues($Page->Recordset);

    // Render row
    $Page->RowType = ROWTYPE_PREVIEW; // Preview record
    $Page->resetAttributes();
    $Page->renderListRow();

    // Render list options
    $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php if ($Page->id_tarea->Visible) { // id_tarea ?>
        <!-- id_tarea -->
        <td<?= $Page->id_tarea->cellAttributes() ?>>
<span<?= $Page->id_tarea->viewAttributes() ?>>
<?= $Page->id_tarea->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
        <!-- id_grupo -->
        <td<?= $Page->id_grupo->cellAttributes() ?>>
<span<?= $Page->id_grupo->viewAttributes() ?>>
<?= $Page->id_grupo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->titulo_tarea->Visible) { // titulo_tarea ?>
        <!-- titulo_tarea -->
        <td<?= $Page->titulo_tarea->cellAttributes() ?>>
<span<?= $Page->titulo_tarea->viewAttributes() ?>>
<?= $Page->titulo_tarea->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fechainireal_tarea->Visible) { // fechainireal_tarea ?>
        <!-- fechainireal_tarea -->
        <td<?= $Page->fechainireal_tarea->cellAttributes() ?>>
<span<?= $Page->fechainireal_tarea->viewAttributes() ?>>
<?= $Page->fechainireal_tarea->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fechafin_tarea->Visible) { // fechafin_tarea ?>
        <!-- fechafin_tarea -->
        <td<?= $Page->fechafin_tarea->cellAttributes() ?>>
<span<?= $Page->fechafin_tarea->viewAttributes() ?>>
<?= $Page->fechafin_tarea->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fechainisimulado_tarea->Visible) { // fechainisimulado_tarea ?>
        <!-- fechainisimulado_tarea -->
        <td<?= $Page->fechainisimulado_tarea->cellAttributes() ?>>
<span<?= $Page->fechainisimulado_tarea->viewAttributes() ?>>
<?= $Page->fechainisimulado_tarea->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fechafinsimulado_tarea->Visible) { // fechafinsimulado_tarea ?>
        <!-- fechafinsimulado_tarea -->
        <td<?= $Page->fechafinsimulado_tarea->cellAttributes() ?>>
<span<?= $Page->fechafinsimulado_tarea->viewAttributes() ?>>
<?= $Page->fechafinsimulado_tarea->getViewValue() ?></span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    $Page->Recordset->moveNext();
} // while
?>
    </tbody>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php } else { // No record ?>
<div class="card no-border">
<div class="ew-detail-count"><?= $Language->phrase("NoRecord") ?></div>
<?php } ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option)
        $option->render("body");
?>
</div>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="clearfix"></div>
</div><!-- /.card-footer -->
<?php } ?>
</div><!-- /.card -->
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
