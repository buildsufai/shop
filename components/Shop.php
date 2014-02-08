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
    public $priceIndex = 15;
    public $cleanTables = false;

    protected function cleanTables($parentId) {
        ProductPrice::model()->deleteAll();
        Product::model()->deleteAll();
    }

    public function importCatalogFromExcel($filename, &$stat = array(), $parent, $categories = array()) {
        Yii::import('application.modules.shop.components.reader', true);

        if($this->cleanTables) $this->cleanTables($parent->id);

        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('UTF8');

        $data->read($filename);
        $data->sheets[0]['cells'];
        $this->currentCategory = $parent;
        $needParse = false;
        for ($i = 7; $i <= $data->sheets[0]['numRows']; $i++) {
            $row = $data->sheets[0]['cells'][$i];
            if($this->isCategory($row)) {
                $needParse = in_array($i, $categories);
                if(!$needParse) {
                    continue;
                }
                $parentId = $this->isProductRow ? 0 : $parent->id;
                $this->createCategoryFromRow($parentId, $row);
            } else {
                if($needParse) {
                    $this->createProductFromRow($this->currentCategory, $row);
                    $this->createProductPricesFromRow($this->currentProduct, $row);
                }
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
        $category->model = 'ProductCategory';
        $category->act = 1;
        $category->name = $categoryName;
        $category->parent_id = $parentId;

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
        $priceIndex = $this->priceIndex;

        $productName = $row[1];
        $kod = @$row[$baseIndex+1];
        $unit = $this->getUnitsId(@$row[$baseIndex+2]);
        $price = intval(@$row[$priceIndex]);

        $product = new Product();
        $product->name = $productName;
        $product->article = $kod;
        $product->category_id = $category->id;
        $product->price = $price;
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

    //---------------------------------------------------------- cart

    public $orders = array();

    public function addToCart($id, $count) {
        $this->setOrderCount($id, $count);
        $result = array(
            'success'=>true
        );
    }
    public function getOrderSum($id)
    {
        $count = $this->getOrderCount($id);
        $price = $this->getPrice($id);
        $sum = $count * $price;
        return number_format($sum, 2, '.', '');
    }

    public function getOrderTotal()
    {
        $total = 0;
        foreach ($this->orders as $id => $count) {
            $price = $this->getPrice($id);
            $total += $count * $price;
        }
        return number_format($total, 2, '.', '');

    }

    public function getOrderItems()
    {
        $crit = $this->getOrderItemsCriteria();
        $items = Product::model()->findAll($crit);
        return $items;
    }

    public function getOrderItemsCriteria()
    {
        $crit = new CDbCriteria();
        $crit->addInCondition('id', array_keys($this->orders));
        return $crit;
    }

    public function getOrderCount($id)
    {
        return isset($this->orders[$id]) ? $this->orders[$id] : 0;
    }

    public function setOrderCount($id, $count)
    {
        if (!$count) {
            $this->removeFromOrder($id);
        } else {
            $this->orders[$id] = $count;
        }
        $this->saveSession();
    }

    public function removeFromOrder($id)
    {
        unset($this->orders[$id]);
        $this->saveSession();
    }

    public function loadSession()
    {
        $orders = Yii::app()->session['orders'];
        if (!$orders) {
            $orders = array();
            Yii::app()->session['orders'] = $orders;
        }
        $this->orders = $orders;

        $currentSorter = Yii::app()->session['currentSorter'];
        if (!$currentSorter) {
            Yii::app()->session['currentSorter'] = $this->currentSorter;
        } else {
            $this->currentSorter = $currentSorter;
        }
    }

    /**
     * @param string $currentSorter
     */
    public function setCurrentSorter($currentSorter)
    {
        $this->currentSorter = $currentSorter;
        $this->saveSession();
    }


    public function saveSession()
    {
        Yii::app()->session['orders'] = $this->orders;
        Yii::app()->session['currentSorter'] = $this->currentSorter;
    }
} 