<?php
/**
 * User: Kir Melnikov
 * Date: 27.11.13
 * Time: 4:50
 *
 */

Yii::setPathOfAlias('shop', dirname(__FILE__) . '/../..');
return array(
    'basePath' => dirname(__FILE__) . '/../..',

    'import' => array(
        'application.models.*',
    ),

    'components' => array(
        'fixture' => array(
            'class' => 'system.test.CDbFixtureManager',
        ),
    ),
);