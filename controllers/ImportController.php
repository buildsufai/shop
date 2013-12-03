<?php
/**
 * User: Kir Melnikov
 * Date: 29.11.13
 * Time: 11:05
 *
 */


class ImportController extends Controller {

    public function actionIndex() {
        $filename = Yii::getPathOfAlias('application.data').'/price.xls';
        $stat = array();
        $stat = Yii::app()->shop->importCatalogFromExcel($filename, $stat);
        var_dump($stat);
    }
} 