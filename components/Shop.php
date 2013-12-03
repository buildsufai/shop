<?php
/**
 * User: Kir Melnikov
 * Date: 26.11.13
 * Time: 0:44
 *
 */
Yii::import('application.modules.shop.*');
Yii::import('application.modules.shop.components.*');
Yii::import('application.modules.shop.models.*');
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


    /**
     * Запись всех ошибок модели в лог
     * @param CActiveRecord $model
     */
    public function logErrors($model) {
        if($model->hasErrors()) {
            $message = ShopModule::t('Validation errors: {name}', array('{name}'=>$model->name));
            $status = CLogger::LEVEL_ERROR;
            $errors = $model->getErrors();
            foreach($errors as $attr=>$error) {
                $errorMessage = $attr.': '.implode(', ', $error);
                var_dump($errorMessage);
                Yii::log($errorMessage, $status);
            }
        } else {
            $message = ShopModule::t('Model imported: {name}', array('{name}'=>$model->name));
            $status = CLogger::LEVEL_INFO;
        }
        Yii::log($message, $status);
    }

    //--------------------------------------------------------------------------------------------  Excel import

    public $baseIndex = 12;
    public $cleanTables = false;

    protected function cleanTables() {
        ProductPrice::model()->deleteAll();
        Product::model()->deleteAll();
        ProductCategory::model()->deleteAll();
    }

    public function importCatalogFromExcel($filename, &$stat = array()) {
        Yii::import('application.modules.shop.components.reader', true);

        if($this->cleanTables) $this->cleanTables();

        $data = new Spreadsheet_Excel_Reader();
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

        $result = $category->save();

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

        $baseIndex = $this->baseIndex;
        $productName = $row[1];
        $kod = @$row[$baseIndex+1];
        $unit = $this->getUnitsId(@$row[$baseIndex+2]);

        $product = new Product();
        $product->name = $productName;
        $product->article = $kod;
        $product->category_id = $category->id;
        $product->unit_id = $unit;

        $result = $product->save();

        $this->logErrors($product);
        $this->currentProduct = $product;
        return $result;
    }

    public function createProductPricesFromRow($product, $row) {
        $result = true;
        $baseIndex = $this->baseIndex + 3;
        foreach($this->priceModels as $i=>$model) {
            $index = $baseIndex+$i;
            if(isset($row[$index])) {
                $priceVal = floatval($row[$index]);
                $currency = $this->currencies[$i];

                $price = new ProductPrice();
                $price->price_model_id = $i;
                $price->product = $product;
                $price->product_id = $product->id;
                $price->price = $priceVal;
                $price->currency = $currency;

                $result = $result && $price->save();
                $this->logErrors($price);
            }
        }
        return $result;
    }


    public function getUnitsId($name) {
        $units = array('шт');
        $result = in_array($name, $units) ? 0 : 1;
        return $result;
    }


    public function isCategory($row) {
        $result = count($row)==1;
        return $result;
    }



} 