shop
====

Shop module for Yii applications

Installation
------------

Download the package into your modules directory.
After place the Shop configuration array inside your 'components' definitions.

```php
'shop' => array(
	'class'=>'shop.components.Shop',
	...
),
```

Shopcart widget
---------------

To add shopping cart widget to your views just add following code:

```php
<?php
$this->widget('shop.widgets.ShopCartWidget', array(
    ...
));
?>
```

Dependencies
------------
- [YiiBooster](https://github.com/clevertech/yiibooster "Yii bootstrap widget toolkit")
- [YiiMailer](https://github.com/vernes/YiiMailer "Yii extension for sending emails with layouts using PHPMailer")