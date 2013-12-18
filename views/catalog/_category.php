<?php
/**
 * User: Kir Melnikov
 * Date: 27.11.13
 * Time: 2:32
 *
 * Одна категория в списке
 *
 * @var ProductCategory $data
 */

$url = array('/shop/catalog/category', 'id' => $data->id);
?>

    <li class="media">
        <? if ($data->image) {
            echo CHtml::link(
                CHtml::image($data->image, $data->name, array('class' => 'media-object')), $url
            );
        } ?>
        <div class="media-body">
            <h4 class="media-heading"><?= CHtml::link($data->name, $url) ?></h4>
            <?= $data->description ?>
            <ul>
                <? foreach ($data->categories as $child): ?>
                    <li><?= CHtml::link($child->name, array('/shop/catalog/category', 'id' => $child->id)) ?></li>
                <? endforeach ?>
            </ul>
        </div>
    </li>