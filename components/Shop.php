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
} 