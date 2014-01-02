<?php
/**
 * User: Kir Melnikov
 * Date: 31.12.13
 * Time: 4:32
 *
 */

namespace shop\components\behaviors;

class Image extends \yii\base\Behavior {

    public $dir='images';
    public $id;

    public function getThumbnailSrc() {
        $path = \Yii::$app->request->baseUrl;
        $id = $this->owner->id;
        $result = implode(DIRECTORY_SEPARATOR, [
            $path,
            $this->dir,
            $id,
            'thumbnail.jpg',
        ]);
        return $result;
    }
} 