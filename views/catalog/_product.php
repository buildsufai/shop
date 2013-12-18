<?php
/**
 * User: Kir Melnikov
 * Date: 04.12.13
 * Time: 16:01
 *
 * @var Product $data
 *
 */

$url = array('/shop/catalog/product', 'id' => $data->id);
?>
<li class="media hproduct">
    <? if ($data->image) {
        echo CHtml::link(
            CHtml::image($data->image, $data->name, array('class' => 'media-object product-thumb')), $url, array('rel'=>'product')
        );
    } ?>
    <div class="media-body">
        <h4 class="media-heading product-title"><?= CHtml::link($data->name, $url, array('rel'=>'product')) ?></h4>
        <?= $data->description ?>

        <p class="product-buy"><a href="#" title="Добавить в корзину" rel="product">Добавить в корзину</a></p>
    </div>
</li>