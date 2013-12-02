<?php

class OrderController extends Controller {
	public function actionCreate($id) {
		$product = Product::model()->findByPk(intval($id));
		if(!$product) {
			throw new CHttpException(404, "Profuct not found");
		}
		$order = new Order();
		if(isset($_POST['Order'])) {
			$order->attributes = $_POST['Order'];
			if($order->validate()) {
				Yii::app()->shop->createOrder($order);
			}
		}
		$this->render('create', array(
			'product'=>$product,
			'model'=>$order));
	}
}