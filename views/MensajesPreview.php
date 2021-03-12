<?php

namespace PHPMaker2021\simexamerica;

// Page object
$MensajesPreview = &$Page;
?>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid mensajes"><!-- .card -->
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
<?php if ($Page->id_inyect->Visible) { // id_inyect ?>
    <?php if ($Page->SortUrl($Page->id_inyect) == "") { ?>
        <th class="<?= $Page->id_inyect->headerCellClass() ?>"><?= $Page->id_inyect->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_inyect->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id_inyect->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->id_inyect->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id_inyect->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->id_inyect->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
    <?php if ($Page->SortUrl($Page->titulo) == "") { ?>
        <th class="<?= $Page->titulo->headerCellClass() ?>"><?= $Page->titulo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->titulo->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->titulo->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->titulo->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->titulo->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->titulo->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
    <?php if ($Page->SortUrl($Page->mensaje) == "") { ?>
        <th class="<?= $Page->mensaje->headerCellClass() ?>"><?= $Page->mensaje->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->mensaje->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->mensaje->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->mensaje->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->mensaje->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->mensaje->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fechareal_start->Visible) { // fechareal_start ?>
    <?php if ($Page->SortUrl($Page->fechareal_start) == "") { ?>
        <th class="<?= $Page->fechareal_start->headerCellClass() ?>"><?= $Page->fechareal_start->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fechareal_start->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->fechareal_start->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->fechareal_start->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->fechareal_start->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->fechareal_start->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->fechasim_start->Visible) { // fechasim_start ?>
    <?php if ($Page->SortUrl($Page->fechasim_start) == "") { ?>
        <th class="<?= $Page->fechasim_start->headerCellClass() ?>"><?= $Page->fechasim_start->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->fechasim_start->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->fechasim_start->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->fechasim_start->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->fechasim_start->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->fechasim_start->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->id_actor->Visible) { // id_actor ?>
    <?php if ($Page->SortUrl($Page->id_actor) == "") { ?>
        <th class="<?= $Page->id_actor->headerCellClass() ?>"><?= $Page->id_actor->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id_actor->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->id_actor->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->id_actor->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->id_actor->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->id_actor->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->para->Visible) { // para ?>
    <?php if ($Page->SortUrl($Page->para) == "") { ?>
        <th class="<?= $Page->para->headerCellClass() ?>"><?= $Page->para->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->para->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->para->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->para->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->para->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->para->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
        </div></div></th>
    <?php } ?>
<?php } ?>
<?php if ($Page->adjunto->Visible) { // adjunto ?>
    <?php if ($Page->SortUrl($Page->adjunto) == "") { ?>
        <th class="<?= $Page->adjunto->headerCellClass() ?>"><?= $Page->adjunto->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->adjunto->headerCellClass() ?>"><div class="ew-pointer" data-sort="<?= HtmlEncode($Page->adjunto->Name) ?>" data-sort-order="<?= $Page->SortField == $Page->adjunto->Name && $Page->SortOrder == "ASC" ? "DESC" : "ASC" ?>">
            <div class="ew-table-header-btn"><span class="ew-table-header-caption"><?= $Page->adjunto->caption() ?></span><span class="ew-table-header-sort"><?php if ($Page->SortField == $Page->adjunto->Name) { ?><?php if ($Page->SortOrder == "ASC") { ?><i class="fas fa-sort-up"></i><?php } elseif ($Page->SortOrder == "DESC") { ?><i class="fas fa-sort-down"></i><?php } ?><?php } ?></span>
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
<?php if ($Page->id_inyect->Visible) { // id_inyect ?>
        <!-- id_inyect -->
        <td<?= $Page->id_inyect->cellAttributes() ?>>
<span<?= $Page->id_inyect->viewAttributes() ?>>
<?= $Page->id_inyect->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->titulo->Visible) { // titulo ?>
        <!-- titulo -->
        <td<?= $Page->titulo->cellAttributes() ?>>
<span<?= $Page->titulo->viewAttributes() ?>>
<?php if (!EmptyString($Page->titulo->TooltipValue) && $Page->titulo->linkAttributes() != "") { ?>
<a<?= $Page->titulo->linkAttributes() ?>><?= $Page->titulo->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->titulo->getViewValue() ?>
<?php } ?>
<span id="tt_mensajes_x<?= $Page->RowCount ?>_titulo" class="d-none">
<?= $Page->titulo->TooltipValue ?>
</span></span>
</td>
<?php } ?>
<?php if ($Page->mensaje->Visible) { // mensaje ?>
        <!-- mensaje -->
        <td<?= $Page->mensaje->cellAttributes() ?>>
<span<?= $Page->mensaje->viewAttributes() ?>>
<?= $Page->mensaje->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fechareal_start->Visible) { // fechareal_start ?>
        <!-- fechareal_start -->
        <td<?= $Page->fechareal_start->cellAttributes() ?>>
<span<?= $Page->fechareal_start->viewAttributes() ?>>
<?= $Page->fechareal_start->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->fechasim_start->Visible) { // fechasim_start ?>
        <!-- fechasim_start -->
        <td<?= $Page->fechasim_start->cellAttributes() ?>>
<span<?= $Page->fechasim_start->viewAttributes() ?>>
<?= $Page->fechasim_start->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->id_actor->Visible) { // id_actor ?>
        <!-- id_actor -->
        <td<?= $Page->id_actor->cellAttributes() ?>>
<span<?= $Page->id_actor->viewAttributes() ?>>
<?= $Page->id_actor->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->para->Visible) { // para ?>
        <!-- para -->
        <td<?= $Page->para->cellAttributes() ?>>
<span<?= $Page->para->viewAttributes() ?>>
<?= $Page->para->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->adjunto->Visible) { // adjunto ?>
        <!-- adjunto -->
        <td<?= $Page->adjunto->cellAttributes() ?>>
<span<?= $Page->adjunto->viewAttributes() ?>>
<?= GetFileViewTag($Page->adjunto, $Page->adjunto->getViewValue(), false) ?>
</span>
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
