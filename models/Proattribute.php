<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_pro_attribute".
 *
 * @property int $proattId
 * @property int|null $productId 产品ID
 * @property int|null $type 类型:1属性2规格3规格组合
 * @property int|null $attributeId 规格属性ID
 * @property string|null $title 规格名称
 * @property string|null $title_en 规格名称_EN
 * @property string|null $stitle 别名(限定规格)
 * @property string|null $val 序列化的规则值,key规则ID,value此货品所具有的规则值
 * @property string|null $pro_no 货号
 * @property string|null $pic 规格图片地址
 * @property int|null $stock 库存
 * @property int|null $weight 重量
 * @property int|null $isphoto 是否图片显示:1否2是
 * @property string|null $md5 规格MD5
 */
class Proattribute extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mo_pro_attribute';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['productId', 'type', 'attributeId', 'stock', 'weight', 'isphoto'], 'integer'],
            [['val'], 'string'],
            [['title', 'title_en', 'stitle'], 'string', 'max' => 100],
            [['pro_no'], 'string', 'max' => 50],
            [['pic', 'md5'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'proattId' => Yii::t('app', 'Proatt ID'),
            'productId' => Yii::t('app', 'Product Id'),
            'type' => Yii::t('app', 'Type'),
            'attributeId' => Yii::t('app', 'Attribute Id'),
            'title' => Yii::t('app', 'Attribute title'),
            'title_en' => Yii::t('app', 'English Attribute title'),
            'stitle' => Yii::t('app', 'Alias name'),
            'val' => Yii::t('app', 'Serialize Attribute value'),
            'pro_no' => Yii::t('app', 'Product No'),
            'pic' => Yii::t('app', 'Pic url'),
            'stock' => Yii::t('app', 'Inventory'),
            'weight' => Yii::t('app', 'Weight'),
            'isphoto' => Yii::t('app', 'Is Photo'),
            'md5' => Yii::t('app', 'Md5'),
        ];
    }

    /**
    * 添加
    * @return
    */
    public  function add($data)
    {
        $result = '';
        $model = new Proattribute();
        $model->attributes = $data;
        if($model->validate() && $model->save()){
            $result['state'] = true;
            $result['data'] = $model->attributes;
        }else{
            $error = $model->getErrors();
            $result['state'] = false;
            $result['data'] = $error;
        }
        return $result;
    }

    /**
    * 更新
    * @param $data
    * @param $id
    * @return
    */
    public  function up($id,$data)
    {
        $result = '';
        $model = self::findOne($id);
        $model->attributes = $data;
        if($model->validate() && $model->save()){
            $result['state'] = true;
            $result['data'] = $model;
        }else{
            $error = $model->getErrors();
            $result['state'] = false;
            $result['data'] = $error;
        }
        return $result;
    }
}
