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
        $model = new ProductCategory('search');
        $model->unsetAttributes();
        if (isset($_GET['ProductCategory'])) {
            $model->setAttributes($_GET['ProductCategory']);
        }
        $this->render('index', array(
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
        $this->pageTitle = $model->name;
        $this->render('category', array(
            'model' => $model
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