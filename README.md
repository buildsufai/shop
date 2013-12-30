shop
====

Shop module for Yii applications

Features
--------

- Shopping Cart widget
- unlimited Category tree
- multiple Product images
- multiple Product characteristics
- Manufacturers

Installation
------------

Download the package into your modules directory. Install module in your config:
```php
'modules'=>array(
	'shop',
	...
),
```

After place the Shop configuration array inside your 'components' definitions.

```php
'shop' => array(
	'class'=>'shop.components.Shop',
	...
),
```

Preload your component:
```php
	'preload'=>array('log', 'bootstrap','shop'),
```


Shopping Cart widget
--------------------

To add shopping cart widget to your views just add following code:

```php
<?php
$this->widget('shop.widgets.ShopCartWidget', array(
    ...
));
?>
```

How to extend widget views
--------------------------

You can extend views of widgets included by placing your views into theme views folder (i.e. themes/classic/CatalogMapWidget/tree.php).

Dependencies
------------
- [YiiBooster](https://github.com/clevertech/yiibooster "Yii bootstrap widget toolkit")
- [YiiMailer](https://github.com/vernes/YiiMailer "Yii extension for sending emails with layouts using PHPMailer")