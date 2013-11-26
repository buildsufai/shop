<?php
/**
 * User: Kir Melnikov
 * Date: 27.11.13
 * Time: 4:19
 *
 */

Yii::import('shop.models.*');

class ProductTest extends CDbTestCase
{

    public $fixtures = array(
        'products' => 'Product',
        'categories' => 'ProductCategory',
    );

    public function testSample()
    {
        $this->assertTrue(true);
    }
} 