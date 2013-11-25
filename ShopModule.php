<?php
/**
 * User: Kir Melnikov
 * Date: 26.11.13
 * Time: 0:30
 *
 */

class ShopModule extends CWebModule {
    public static function t($message, $params) {
        return Yii::t('ShopModule.shop', $message, $params);
    }
} 