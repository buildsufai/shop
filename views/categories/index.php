<?php
/**
 * User: Kir Melnikov
 * Date: 31.12.13
 * Time: 3:11
 *
 * @var yii\web\View $this
 */


use yii\helpers\Html;

$this->title = 'Магазин';
$this->params['breadcrumbs'] = $breadcrumbs;
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <?php foreach($categories as $ctg): ?>
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <?php echo Html::a(Html::img($ctg->thumbnailSrc, ['style'=>'height:156px']), ['//shop/categories/'.$ctg->id]) ?>
                        <div class="caption">
                            <h3><?php echo $ctg->name ?></h3>

                            <p><?php echo $ctg->description ?></p>

                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

    </div>
</div>
