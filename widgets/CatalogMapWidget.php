<?php
/**
 * User: Kir Melnikov
 * Date: 27.11.13
 * Time: 0:21
 *
 * Выводит иерархический список категорий каталога
 */

Yii::import('shop.models.*');

class CatalogMapWidget extends CWidget
{

    public function init()
    {
    }

    public function run()
    {
        $model = new ProductCategory('search');
        $model->unsetAttributes();
        if (isset($_GET['ProductCategory'])) {
            $model->setAttributes($_GET['ProductCategory']);
        }
        $model->parent_id = 0;
        $this->render('tree', array(
            'model' => $model
        ));
    }
}
