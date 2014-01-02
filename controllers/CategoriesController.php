<?php
/**
 * User: Kir Melnikov
 * Date: 31.12.13
 * Time: 2:53
 *
 */

namespace shop\controllers;

use shop\models\yii2\ProductCategory;

class CategoriesController extends \yii\base\Controller {
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

        ];
    }


    public function actionIndex() {
        $id = isset($_GET['id']) ? $_GET['id'] : 1;
        $model = ProductCategory::find()
            ->where(['id' => intval($id)])
            ->one();


        return $this->render('index', [
            'categories' => $model->productCategories,
            'breadcrumbs' => ['Магазин'],
        ]);
    }
} 