<?php
/**
 * User: Kir Melnikov
 * Date: 26.11.13
 * Time: 0:44
 *
 */
Yii::import('shop.models.*');
class Shop extends CComponent {

    protected $count = 0;
    protected $total = 0;

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }



    public function init() {
    }

    public function importCatalogFromExcel($filename, &$stat = array()) {
        require_once Yii::getPathOfAlias('shop.extensions').'/Excel/reader.php';

        $data = new Spreadsheet_Excel_Reader();


// Set output Encoding.
        $data->setOutputEncoding('UTF8');

        $data->read($filename);
        $data->sheets[0]['cells'];
        $currentCategory = null;
        for ($i = 7; $i <= $data->sheets[0]['numRows']; $i++) {
            $row = $data->sheets[0]['cells'][$i];
            if($this->isCategory($row)) {
                $this->createCategoryFromRow($row);
            } else {
                $this->createPricesFromRow($row);
            }
        }

        $stat['rowCount'] = $data->sheets[0]['numRows'];
        return $stat;
    }

    /**
     * Запись всех ошибок модели в лог
     * @param $model
     */
    public function logErrors($model) {
        foreach($model->errors as $error) {
            Yii::log($error->message, CLogger::LEVEL_ERROR);
        }
    }

    protected $currentCategory;
    protected $isProductRow = true;

    public function createCategoryFromRow($row) {
        $categoryName = $row[1];
        $category = new ProductCategory();
        if(!$this->isProductRow) {
            $category->parent_id = $this->currentCategory->id;
        }
        $this->isProductRow = false;
        $category->name = $categoryName;
        $category->is_main = false;
        if($category->validate() && $category->save()) {
            $message = ShopModule::t('Category imported: {categoryName}', array('{categoryName}'=>$categoryName));
        } else {
            $message = ShopModule::t('Ошибка проверки категории: {categoryName}', array('{categoryName}'=>$categoryName));
        }
        Yii::log($message);
        $this->currentCategory = $category;
        return $category;
    }

    public function createProductFromRow($row) {
        $this->isProductRow = true;
        $productName = $row[1];
        $kod = $row[2];
        $unit = $row[3];
        $product = new Product();
        $product->name = $productName;
        $product->article = $kod;
        $product->unit = $unit;
        if($product->validate() && $product->save()) {
            $message = ShopModule::t('Category imported: {categoryName}', array('{categoryName}'=>$productName));
        } else {
            $message = ShopModule::t('Ошибка проверки категории: {categoryName}', array('{categoryName}'=>$productName));
        }
        Yii::log($message);
        $this->logErrors($product);

    }

    public function createProductPricesFromRow($product, $row) {
        $prices = array();
        return $prices;
    }


    public function isCategory($row) {
        $result = count($row)==1;
        return $result;
    }



} 