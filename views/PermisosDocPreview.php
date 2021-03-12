<?php

namespace PHPMaker2021\simexamerica;

// Page object
$PermisosDocPreview = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid permisos_doc"><!-- .card -->
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
<?php if ($Page->id_permiso->Visible) { // id_permiso ?>
    <?php if ($Page->SortUrl($Page->id_permiso) == "") { ?>
        <th class="<?= $Page->id_permiso->headerCellClass() ?>"><?= $Page->id_permiso->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_permiso->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id_permiso->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->id_permiso->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id_permiso->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->id_permiso->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->id_file->Visible) { // id_file ?>
    <?php if ($Page->SortUrl($Page->id_file) == "") { ?>
        <th class="<?= $Page->id_file->headerCellClass() ?>"><?= $Page->id_file->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_file->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id_file->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->id_file->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id_file->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->id_file->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->tipo_permiso->Visible) { // tipo_permiso ?>
    <?php if ($Page->SortUrl($Page->tipo_permiso) == "") { ?>
        <th class="<?= $Page->tipo_permiso->headerCellClass() ?>"><?= $Page->tipo_permiso->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->tipo_permiso->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->tipo_permiso->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->tipo_permiso->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->tipo_permiso->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->tipo_permiso->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fecha_created->Visible) { // fecha_created ?>
    <?php if ($Page->SortUrl($Page->fecha_created) == "") { ?>
        <th class="<?= $Page->fecha_created->headerCellClass() ?>"><?= $Page->fecha_created->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fecha_created->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->fecha_created->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->fecha_created->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->fecha_created->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->fecha_created->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->id_usuarios->Visible) { // id_usuarios ?>
    <?php if ($Page->SortUrl($Page->id_usuarios) == "") { ?>
        <th class="<?= $Page->id_usuarios->headerCellClass() ?>"><?= $Page->id_usuarios->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_usuarios->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id_usuarios->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->id_usuarios->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id_usuarios->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->id_usuarios->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
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
<?php if ($Page->id_permiso->Visible) { // id_permiso ?>
        <!-- id_permiso -->
        <td<?= $Page->id_permiso->cellAttributes() ?>>
<span<?= $Page->id_permiso->viewAttributes() ?>>
<?= $Page->id_permiso->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->id_file->Visible) { // id_file ?>
        <!-- id_file -->
        <td<?= $Page->id_file->cellAttributes() ?>>
<span<?= $Page->id_file->viewAttributes() ?>>
<?= $Page->id_file->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->tipo_permiso->Visible) { // tipo_permiso ?>
        <!-- tipo_permiso -->
        <td<?= $Page->tipo_permiso->cellAttributes() ?>>
<span<?= $Page->tipo_permiso->viewAttributes() ?>>
<?= $Page->tipo_permiso->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fecha_created->Visible) { // fecha_created ?>
        <!-- fecha_created -->
        <td<?= $Page->fecha_created->cellAttributes() ?>>
<span<?= $Page->fecha_created->viewAttributes() ?>>
<?= $Page->fecha_created->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->id_usuarios->Visible) { // id_usuarios ?>
        <!-- id_usuarios -->
        <td<?= $Page->id_usuarios->cellAttributes() ?>>
<span<?= $Page->id_usuarios->viewAttributes() ?>>
<?= $Page->id_usuarios->getViewValue() ?></span>
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
