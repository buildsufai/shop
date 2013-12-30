<?php
/**
 * User: Kir Melnikov
 * Date: 18.12.13
 * Time: 20:38
 *
 */

class ProductController extends Controller
{
    public function actionIndex($id)
    {
        $model = Product::model()->findByPk(intval($id));
        if (!$model) {
            throw new CHttpException(404, 'Продукт не найден');
        }
        $this->render('/catalog/product', array(
            'model' => $model
        ));
    }
} 