<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property integer $id
 * @property integer $product_id
 * @property integer $qty
 * @property double $price
 * @property double $total
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $customer_id
 * @property integer $discount_id
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property Customer $customer
 * @property Discount $discount
 * @property SupplyLog[] $supplyLogs
 */
class Order extends CActiveRecord
{
	public $name='';
	public $email='';
	public $address='';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, address, product_id, price, total, customer_id, discount_id', 'required'),
			array('product_id, qty, status, customer_id, discount_id', 'numerical', 'integerOnly'=>true),
			array('price, total', 'numerical'),
			array('create_time, update_time', 'safe'),
			array('email', 'email'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, qty, price, total, status, create_time, update_time, customer_id, discount_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
			'discount' => array(self::BELONGS_TO, 'Discount', 'discount_id'),
			'supplyLogs' => array(self::HAS_MANY, 'SupplyLog', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'qty' => 'Qty',
			'price' => 'Price',
			'total' => 'Total',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'customer_id' => 'Customer',
			'discount_id' => 'Discount',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('price',$this->price);
		$criteria->compare('total',$this->total);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('discount_id',$this->discount_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
