<?php

class BestOfferWidget extends CWidget
{

    public $type = 'gallery';
    protected static $offers = array();
    public $itemTagName = 'div';
    public $mediaClass = 'media';
    public $showOrder = false;

    public function getCurrentId()
    {
        return 1;
    }

    public function createGallery($offers = array())
    {
        $result = '';
        $list = array();
        $this->itemTagName = 'li';
        $this->mediaClass = 'media span2';
        foreach ($offers as $offer) {
            $list[] = $this->createSingle($offer);
        }
        $result = CHtml::tag('ul', array('class' => 'media-list row'), implode('', $list));
        return $result;
    }

    public function createSingle($offer)
    {
        if ($offer == null) {
            return '';
        }
        $offerUrl = array('/shop/product', 'id' => $offer->id);
        $baseUrl = Yii::app()->theme->baseUrl;
        $image = CHtml::image($baseUrl . $offer->image, $offer->name);
        $imageLink = CHtml::link($image, $offerUrl);
        $mediaHeading = CHtml::tag('h4', array('class' => 'media-heading'), $offer->name);
        $mediaBody = CHtml::tag('div', array('class' => 'media-body'), $mediaHeading . $offer->description);
        $mediaContent = $imageLink . $mediaBody;
        if ($this->showOrder) {
            $mediaContent = $this->createOrderButton($offer) . $mediaContent;
        }
        $media = CHtml::tag($this->itemTagName, array('class' => $this->mediaClass), $mediaContent);
        return $media;
    }

    public function createOrderButton($offer)
    {
        $result = CHtml::link('Заказать', array('shop/order/create', 'id' => $offer->id),
            array('id' => 'order-button', 'class' => 'btn btn-success'));
        return $result;
    }

    protected function loadBestOffers()
    {
        if (empty(self::$offers)) {
            self::$offers = Product::model()->findAllByAttributes(array(
                'is_best' => 1
            ));
        }
        return self::$offers;
    }

    protected function getCurrentOffer($offers = array())
    {
        $result = null;
        $currentId = $this->currentId;
        foreach ($offers as $offer) {
            if ($offer->id == $currentId) {
                $result = $offer;
                break;
            }
        }
        return $result;
    }

    public function run()
    {
        $gallery = '';
        $result = '';
        $single = '';
        $offers = $this->loadBestOffers();
        $model = $this->getCurrentOffer($offers);
        switch ($this->type) {
            case 'single':
                $result .= $this->createSingle($model);
                break;

            default:
                $result .= $this->createGallery($offers);
                break;
        }
        echo $result;
    }
}
