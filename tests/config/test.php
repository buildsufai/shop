<?php
/**
 * User: Kir Melnikov
 * Date: 27.11.13
 * Time: 4:50
 *
 */
return array(
    'basePath' => dirname(__FILE__) . '/../..',

    'import' => array(
        'application.models.*',
    ),

    'components' => array(
        'fixture' => array(
            'class' => 'system.test.CDbFixtureManager',
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=test',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ),
    ),
);