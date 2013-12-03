<?php

/**
 * This is the model class for table "product_category".
 *
 * The followings are the available columns in table 'product_category':
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $description
 * @property string $content
 * @property integer $ord
 * @property integer $is_main
 * @property string $image
 *
 * The followings are the available model relations:
 * @property Product[] $products
 * @property ProductCategory $parent
 * @property ProductCategory[] $productCategories
 * @property ProductChar[] $productChars
 */
class ProductCategory extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'product_category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('parent_id, ord', 'numerical', 'integerOnly' => true),
            array('is_main', 'boolean'),
            array('name, image', 'length', 'max' => 255),
            array('description, content', 'safe'),
            // The following rule is used by search().
            array('id, name, parent_id, description, content, is_main', 'safe', 'on' => 'search'),
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
            'products' => array(self::HAS_MANY, 'Product', 'category_id'),
            'parent' => array(self::BELONGS_TO, 'ProductCategory', 'parent_id'),
            'categories' => array(self::HAS_MANY, 'ProductCategory', 'parent_id'),
            'chars' => array(self::MANY_MANY, 'ProductChar', 'product_category_char(category_id, char_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent',
            'description' => 'Description',
            'content' => 'Content',
            'ord' => 'Ord',
            'main' => 'Main',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('main', $this->main);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductCategory the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
