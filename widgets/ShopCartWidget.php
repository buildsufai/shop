<?php
/**
 * User: Kir Melnikov
 * Date: 26.11.13
 * Time: 0:31
 *
 */
Yii::import('shop.ShopModule');

class ShopCartWidget extends CWidget {

    protected $cssClass = 'cart';
    protected $showIcon = true;
    protected $showCount = true;
    protected $showTotal = true;

    /**
     * @var Shop
     */
    protected $shop;

    /**
     * @param string $cssClass
     */
    public function setCssClass($cssClass)
    {
        $this->cssClass = $cssClass;
    }

    /**
     * @return string
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }



    public function init()
    {
        $this->shop = Yii::app()->shop;
        parent::init();
    }

    public function run()
    {
        $content = '';
        if($this->showIcon) {
            $content .= CHtml::tag('i', array('class'=>'icon icon-shopping-cart'), '', true);
        }
        if($this->showCount) {
            $message = ShopModule::t('<b>{n}</b> product|<b>{n}</b> products', array($this->shop->count));
            $link = CHtml::link($message, array('shop/cart'));
            $content .= CHtml::tag('div', array('class'=>'count'), $link, true);
        }

        if($this->showTotal) {
            $message = ShopModule::t('Total: <b>{n}</b> ruble|Total: <b>{n}</b> rubles', array($this->shop->total));
            $link = CHtml::link($message, array('shop/cart'));
            $content .= CHtml::tag('div', array('class'=>'total'), $link, true);
        }
        echo CHtml::tag('div', array('class'=>$this->cssClass), $content, true);
    }


}