<?php
/**
 * User: Kir Melnikov
 * Date: 27.11.13
 * Time: 2:08
 *
 * @var ProductCategory $model
 * @var Product $itemModel
 */

echo '<div class="page-heading"><h1>'.$model->name.'</h1></div>';
echo $model->content;

$this->widget('bootstrap.widgets.TbExtendedGridView', array_merge_recursive($itemModel->getGridAttributes(), array(
    'id' => 'product-grid',
    'dataProvider' => $itemModel->search(),
    'filter' => $itemModel,
    'columns' => array(

    ),
)));
