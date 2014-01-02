<?php
/**
 * User: Kir Melnikov
 * Date: 19.12.13
 * Time: 19:33
 *
 */
namespace shop;

class Module extends \yii\base\Module {

    public $defaultRoute = 'categories';
    public $controllerNamespace = 'shop\controllers';

    /**
     * Returns the module version number.
     * @return string the version.
     */
    public function getVersion()
    {
        return '1.0.0';
    }
} 