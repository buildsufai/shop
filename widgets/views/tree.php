<?php
/**
 * User: Kir Melnikov
 * Date: 27.11.13
 * Time: 2:11
 *
 * @var ProductCategory $model
 */

$this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider' => $model->search(),
    'itemView' => '_category'
));
