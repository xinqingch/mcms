<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_pro_spe".
 *
 * @property int $prospeId
 * @property int|null $productId 产品ID
 * @property int|null $proattId 规格ID
 * @property float|null $price 产品价格
 * @property int|null $min 最小数量
 * @property int|null $max 最大数量
 */
class Prospe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mo_pro_spe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['productId', 'proattId', 'min', 'max'], 'integer'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'prospeId' => Yii::t('app', 'Prospe ID'),
            'productId' => Yii::t('app', 'Product Id'),
            'proattId' => Yii::t('app', 'Product attribute Id'),
            'price' => Yii::t('app', 'Price'),
            'min' => Yii::t('app', 'Min num'),
            'max' => Yii::t('app', 'Max num'),
        ];
    }

    /**
    * 添加
    * @return
    */
    public  function add($data)
    {
        $result = '';
        $model = new Prospe();
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
