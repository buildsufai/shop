<?php
/**
 * User: Kir Melnikov
 * Date: 26.11.13
 * Time: 0:44
 *
 */
Yii::import('shop.models.*');
class Shop extends CComponent {

    public $priceModels = array();
    public $currencies = array();


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
                $parentId = $this->isProductRow ? 0 : $this->currentCategory->id;
                $this->createCategoryFromRow($parentId, $row);
            } else {
                $this->createProductFromRow($this->currentCategory, $row);
                $this->createProductPricesFromRow($this->currentProduct, $row);
            }
        }
        $stat['rowCount'] = $data->sheets[0]['numRows'];
        return $stat;
    }

    /**
     * Запись всех ошибок модели в лог
     * @param CActiveRecord $model
     */
    public function logErrors($model) {
        if($model->hasErrors()) {
            $message = ShopModule::t('Model imported: {name}', array('{name}'=>$model->name));
            $status = CLogger::LEVEL_INFO;
        } else {
            $message = ShopModule::t('Validation errors: {name}', array('{name}'=>$model->name));
            $status = CLogger::LEVEL_ERROR;
            foreach($model->errors as $error) {
                Yii::log($error->message, $status);
            }
        }
        Yii::log($message, $status);
    }

    protected $currentCategory;
    protected $currentProduct;
    protected $isProductRow = true;

    /**
     * Создает категорию из строки Excel
     *
     * @param int $parentId
     * @param array $row
     * @return bool
     */
    public function createCategoryFromRow($parentId, $row) {
        $this->isProductRow = false; // строка категории потому что

        $categoryName = $row[1];

        $category = new ProductCategory();
        $category->name = $categoryName;
        $category->parent_id = $parentId;
        $category->is_main = false;

        $result = ($category->validate() && $category->save());

        $this->logErrors($category);
        $this->currentCategory = $category;
        return $result;
    }

    /**
     * Создает товар из строки Excel
     *
     * @param ProductCategory $category
     * @param array $row
     * @return bool
     */
    public function createProductFromRow($category, $row) {
        $this->isProductRow = true;

        $productName = $row[1];
        $kod = $row[2];
        $unit = $row[3];

        $product = new Product();
        $product->name = $productName;
        $product->article = $kod;
        $product->category_id = $category->id;
        $product->unit = $unit;

        $result = ($product->validate() && $product->save());

        $this->logErrors($product);
        $this->currentProduct = $product;
        return $result;
    }

    public function createProductPricesFromRow($product, $row) {
        foreach($this->priceModels as $i=>$model) {
            $index = 3+$i;
            if(isset($row[$index])) {
                $price = new Pro
            }
        }
        return $prices;
    }


    public function isCategory($row) {
        $result = count($row)==1;
        return $result;
    }



} 