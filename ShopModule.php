<?php
/**
 * User: Kir Melnikov
 * Date: 26.11.13
 * Time: 0:30
 *
 */

class ShopModule extends CWebModule
{
    protected function init()
    {
        Yii::import('shop.models.*');
    }

    public static function t($message, $params = array())
    {
        return Yii::t('ShopModule.shop', $message, $params);
    }
} 