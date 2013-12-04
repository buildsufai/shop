<?php
/**
 * User: Kir Melnikov
 * Date: 04.12.13
 * Time: 16:01
 *
 * @var Product $data
 *
 */
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