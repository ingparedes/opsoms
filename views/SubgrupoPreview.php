<?php

namespace PHPMaker2021\simexamerica;

// Page object
$SubgrupoPreview = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid subgrupo"><!-- .card -->
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
<?php if ($Page->id_subgrupo->Visible) { // id_subgrupo ?>
    <?php if ($Page->SortUrl($Page->id_subgrupo) == "") { ?>
        <th class="<?= $Page->id_subgrupo->headerCellClass() ?>"><?= $Page->id_subgrupo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_subgrupo->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id_subgrupo->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->id_subgrupo->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id_subgrupo->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->id_subgrupo->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->imagen_subgrupo->Visible) { // imagen_subgrupo ?>
    <?php if ($Page->SortUrl($Page->imagen_subgrupo) == "") { ?>
        <th class="<?= $Page->imagen_subgrupo->headerCellClass() ?>"><?= $Page->imagen_subgrupo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->imagen_subgrupo->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->imagen_subgrupo->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->imagen_subgrupo->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->imagen_subgrupo->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->imagen_subgrupo->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nombre_subgrupo->Visible) { // nombre_subgrupo ?>
    <?php if ($Page->SortUrl($Page->nombre_subgrupo) == "") { ?>
        <th class="<?= $Page->nombre_subgrupo->headerCellClass() ?>"><?= $Page->nombre_subgrupo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nombre_subgrupo->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->nombre_subgrupo->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->nombre_subgrupo->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->nombre_subgrupo->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->nombre_subgrupo->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
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
<?php if ($Page->id_subgrupo->Visible) { // id_subgrupo ?>
        <!-- id_subgrupo -->
        <td<?= $Page->id_subgrupo->cellAttributes() ?>>
<span<?= $Page->id_subgrupo->viewAttributes() ?>>
<?= $Page->id_subgrupo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->imagen_subgrupo->Visible) { // imagen_subgrupo ?>
        <!-- imagen_subgrupo -->
        <td<?= $Page->imagen_subgrupo->cellAttributes() ?>>
<span>
<?= GetFileViewTag($Page->imagen_subgrupo, $Page->imagen_subgrupo->getViewValue(), false) ?>
</span>
</td>
<?php } ?>
<?php if ($Page->nombre_subgrupo->Visible) { // nombre_subgrupo ?>
        <!-- nombre_subgrupo -->
        <td<?= $Page->nombre_subgrupo->cellAttributes() ?>>
<span<?= $Page->nombre_subgrupo->viewAttributes() ?>>
<?= $Page->nombre_subgrupo->getViewValue() ?></span>
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
