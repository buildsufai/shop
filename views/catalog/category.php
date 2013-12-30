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
    $this->widget('bootstrap.widgets.TbExtendedGridView', array_merge_recursive($itemModel->getListAttributes(), array(
        'id' => 'product-list',
        'dataProvider' => $itemDataProvider,
        'columns'=>array(
            'article',
            'name',
            'price',
            array(
                'name'=>'count',
                'type'=>'raw',
                'value'=>'CHtml::numberField("count[$data->id]","0", array("min"=>0, "data-id"=>$data->id,"data-price"=>$data->price))'
            ),
            'total'=>array(
                'name'=>'total',
                'type'=>'raw',
                'value'=>'"<div id=\"total-{$data->id}\">"."0"."</div>"',
            ),
            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'template'=>'{add}',
                'buttons'=>array(
                    'add' => array
                    (
                        'type'=>'ajaxSubmitButton',
                        'icon'=>'shopping-cart',
                        'label'=>'Добавить в корзину',     //Text label of the button.
                        'url'=>'Yii::app()->controller->createUrl("addToCart", array("id"=>$data->id))',       //A PHP expression for generating the URL of the button.
                        //'imageUrl'=>'...',  //Image URL of the button.
                        'options'=>array('class'=>'add-to-cart'), //HTML options for the button tag.
                        //'click'=>'...',     //A JS function to be invoked when the button is clicked.
                        //'visible'=>'...',   //A PHP expression for determining whether the button is visible.
                    )
                )
            ),
        ),
    )));
}
