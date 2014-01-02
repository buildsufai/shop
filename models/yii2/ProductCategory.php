<?php
/**
 * User: Kir Melnikov
 * Date: 31.12.13
 * Time: 3:05
 *
 */

namespace shop\models\yii2;

/**
 * This is the model class for table "tbl_product_category".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $description
 *
 * @property Product[] $products
 * @property ProductCategory $parent
 * @property ProductCategory[] $productCategories
 * @property ProductChar[] $productChars
 */
class ProductCategory extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            'image'=>[
                'class'=>'shop\components\behaviors\Image',
                'dir'=>implode(DIRECTORY_SEPARATOR, [
                    'images',
                    'shop',
                    'categories'
                ]),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getParent()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getProductCategories()
    {
        return $this->hasMany(ProductCategory::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getProductChars()
    {
        return $this->hasMany(ProductChar::className(), ['category_id' => 'id']);
    }

}