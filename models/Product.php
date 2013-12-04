<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property integer $category_id
 * @property integer $unit_id
 * @property integer $manufacturer_id
 * @property string $article
 * @property string $name
 * @property string $description
 * @property string $content
 * @property double $price
 * @property string $image
 *
 * The followings are the available model relations:
 * @property Order[] $orders
 * @property ProductCategory $category
 * @property Manufacturer $manufacturer
 * @property ProductChar[] $chars
 * @property ProductPhoto[] $photos
 * @property ProductPrice[] $prices
 * @property Product[] $resources
 * @property Supply[] $supplies
 * @property Warehouse[] $warehouses
 */
class Product extends CActiveRecord
{
    public function getGridAttributes() {
        return array(

        );
    }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, name', 'required'),
			array('category_id, unit_id, manufacturer_id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('article', 'length', 'max'=>45),
			array('name, image', 'length', 'max'=>255),
			array('description, content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, category_id, unit_id, manufacturer_id, article, name, description, content, price, image', 'safe', 'on'=>'search'),
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
			'orders' => array(self::HAS_MANY, 'Order', 'product_id'),
			'category' => array(self::BELONGS_TO, 'ProductCategory', 'category_id'),
			'manufacturer' => array(self::BELONGS_TO, 'Manufacturer', 'manufacturer_id'),
			'chars' => array(self::MANY_MANY, 'ProductChar', 'product_char_value(product_id, char_id)'),
			'photos' => array(self::HAS_MANY, 'ProductPhoto', 'product_id'),
			'prices' => array(self::HAS_MANY, 'ProductPrice', 'product_id'),
			'resources' => array(self::MANY_MANY, 'Product', 'product_resource(product_id, resource_id'),
			'supplies' => array(self::HAS_MANY, 'Supply', 'product_id'),
			'warehouses' => array(self::MANY_MANY, 'Warehouse', 'warehouse_rest(product_id, warehouse_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => 'Category',
			'unit_id' => 'Unit',
			'manufacturer_id' => 'Manufacturer',
			'article' => 'Article',
			'name' => 'Name',
			'description' => 'Description',
			'content' => 'Content',
			'price' => 'Price',
			'image' => 'Image',
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
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('unit_id',$this->unit_id);
		$criteria->compare('manufacturer_id',$this->manufacturer_id);
		$criteria->compare('article',$this->article,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('image',$this->image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
