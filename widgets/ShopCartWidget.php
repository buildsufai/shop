<?php
/**
 * User: Kir Melnikov
 * Date: 26.11.13
 * Time: 0:31
 *
 */

class ShopCartWidget extends CWidget {

    protected $cssClass = 'cart';

    /**
     * @var ShopC
     */
    protected $cart;

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
        parent::init();
    }

    public function run()
    {
        $content = CHtml::tag('div', array('class'=>'num'),
            '<i class="icon icon-shopping-cart"></i>'.
            CHtml::link(ShopModule::t('{n} products', Yii::a))
            ,true);
        echo CHtml::tag('div', array(
            'class'=>$this->cssClass
        ), $content, true);
        <div class="cart">
                    <div class="num"><i class="icon icon-shopping-cart"></i> <a href="/shop/cart"><b>5</b> товаров в корзине</a></div>
                    <div class="sum">На сумму <b>1000</b> рублей</div>
                </div>
    }


}