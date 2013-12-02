<?php
Yii::import('shop.ShopModule');
class OrderFormWidget extends CWidget {
	protected $order;
	public function init() {
		$order = new Order();
		$this->order = $order;
		if(isset($_POST['Order'])) {
			$order->attributes = $_POST['Order'];
			if($order->validate()) {
				Yii::app()->shop->createOrder($order);
			}
		}
	}
	public function run() {
		$controller = Yii::app()->controller;
		$model = $this->order;
		$form = $controller->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'action'=>'',
			'method'=>'post'
		));
		echo $form->errorSummary($model);
		echo $form->hiddenField($model, 'product_id');
		echo $form->textFieldRow($model, 'name');
		echo $form->textFieldRow($model, 'email');
		echo $form->textareaRow($model, 'address');
		$controller->widget('bootstrap.widgets.TbButton', array(
			'label'=>ShopModule::t('Create Order'),
			'type'=>'warning',
			'buttonType'=>'submit',
		));
		echo CHtml::link(ShopModule::t('Cancel Order'), '#', array(
			'id'=>'cancel-button', 
			'class'=>'btn btn-link'));
		$controller->endWidget();
	}
}