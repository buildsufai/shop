<?php
/**
 * User: Kir Melnikov
 * Date: 27.11.13
 * Time: 2:08
 *
 * @var ProductCategory $model
 */

?>
    <ul class="media-list">
<?
$this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider' => $model->search(),
    'itemView' => '_category'
));

?> </ul>