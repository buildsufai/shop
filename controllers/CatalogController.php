<?php
/**
 * User: Kir Melnikov
 * Date: 27.11.13
 * Time: 0:14
 *
 */

class CatalogController extends Controller
{

    public function actionIndex()
    {
        $this->breadcrumbs[] = 'Каталог';
        $model = new ProductCategory('search');
        if (isset($_GET['ProductCategory'])) {
            $model->setAttributes($_GET['ProductCategory']);
        }
        $this->render('//catalog/index', array(
            'model' => $model
        ));
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionCategory($id)
    {
        $model = ProductCategory::model()->findByPk(intval($id));
        if (!$model) {
            throw new CHttpException(404, ShopModule::t('Category not found'));
        }

        $cs = Yii::app()->clientScript;
        $assetsUrl = CHtml::asset(Yii::getPathOfAlias('shop.assets'));
        $cs->registerCssFile($assetsUrl . '/css/shop.css');
        $cs->registerScriptFile($assetsUrl . '/js/shop.js', CClientScript::POS_END);

        $this->breadcrumbs['Каталог'] = Yii::app()->createUrl('catalog');
        $this->breadcrumbs[] = $model->name;

        $itemModel = new Product('search');
        $itemModel->unsetAttributes();
        if(isset($_GET['Product'])) {
            $itemModel->attributes = $_GET['Product'];
        }
        $itemModel->category_id = $model->id;
        $this->pageTitle = $model->name;
        $this->render('category', array(
            'productListView'=>'list',
            'model' => $model,
            'itemModel' => $itemModel,
        ));
    }


    /**
     * @param null $id
     * @throws CHttpException
     */
    public function actionProduct($id = null)
    {
        $model = Product::model()->findByPk(intval($id));
        if (!$model) {
            throw new CHttpException(404, ShopModule::t('Product not found'));
        }
        $this->pageTitle = $model->name;
        $this->render('product', array(
            'model' => $model
        ));
    }
} 