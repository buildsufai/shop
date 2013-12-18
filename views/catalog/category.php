<?php
/**
 * User: Kir Melnikov
 * Date: 27.11.13
 * Time: 2:08
 *
 * Страница категории товаров
 *
 * @var ProductCategory $model
 * @var Product $itemModel
 */
$itemDataProvider = $itemModel->search();

echo '<div class="page-heading"><h1>'.$model->name.'</h1></div>';
echo $model->content;

if($productListView==='table') {
    $this->widget('bootstrap.widgets.TbExtendedGridView', array_merge_recursive($itemModel->getGridAttributes(), array(
        'id' => 'product-grid',
        'dataProvider' => $itemDataProvider,
        'filter' => $itemModel,
        'columns' => array(

        ),
    )));
} else {
    $this->widget('bootstrap.widgets.TbListView', array_merge_recursive($itemModel->getListAttributes(), array(
        'id' => 'product-list',
        'dataProvider' => $itemDataProvider,
        'itemView'=>'_product',
    )));
}
