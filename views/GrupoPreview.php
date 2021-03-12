<?php

namespace PHPMaker2021\simexamerica;

// Page object
$GrupoPreview = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid grupo"><!-- .card -->
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
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
    <?php if ($Page->SortUrl($Page->id_grupo) == "") { ?>
        <th class="<?= $Page->id_grupo->headerCellClass() ?>"><?= $Page->id_grupo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_grupo->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id_grupo->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->id_grupo->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id_grupo->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->id_grupo->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->imgen_grupo->Visible) { // imgen_grupo ?>
    <?php if ($Page->SortUrl($Page->imgen_grupo) == "") { ?>
        <th class="<?= $Page->imgen_grupo->headerCellClass() ?>"><?= $Page->imgen_grupo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->imgen_grupo->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->imgen_grupo->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->imgen_grupo->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->imgen_grupo->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->imgen_grupo->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nombre_grupo->Visible) { // nombre_grupo ?>
    <?php if ($Page->SortUrl($Page->nombre_grupo) == "") { ?>
        <th class="<?= $Page->nombre_grupo->headerCellClass() ?>"><?= $Page->nombre_grupo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nombre_grupo->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->nombre_grupo->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->nombre_grupo->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->nombre_grupo->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->nombre_grupo->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
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
<?php if ($Page->id_grupo->Visible) { // id_grupo ?>
        <!-- id_grupo -->
        <td<?= $Page->id_grupo->cellAttributes() ?>>
<span<?= $Page->id_grupo->viewAttributes() ?>>
<?= $Page->id_grupo->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->imgen_grupo->Visible) { // imgen_grupo ?>
        <!-- imgen_grupo -->
        <td<?= $Page->imgen_grupo->cellAttributes() ?>>
<span>
<?= GetFileViewTag($Page->imgen_grupo, $Page->imgen_grupo->getViewValue(), false) ?>
</span>
</td>
<?php } ?>
<?php if ($Page->nombre_grupo->Visible) { // nombre_grupo ?>
        <!-- nombre_grupo -->
        <td<?= $Page->nombre_grupo->cellAttributes() ?>>
<span<?= $Page->nombre_grupo->viewAttributes() ?>>
<?= $Page->nombre_grupo->getViewValue() ?></span>
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
