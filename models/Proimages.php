<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_pro_images".
 *
 * @property int $proimgId
 * @property int|null $productId 产品ID
 * @property string|null $url 图片地址
 * @property int|null $attachmentId 附件ID
 * @property int $listorder 排序
 */
class Proimages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mo_pro_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['productId', 'attachmentId', 'listorder'], 'integer'],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'proimgId' => Yii::t('app', 'Proimg ID'),
            'productId' => Yii::t('app', 'Product ID'),
            'url' => Yii::t('app', 'Pic url'),
            'attachmentId' => Yii::t('app', 'Attachment ID'),
            'listorder' => Yii::t('app', 'Listorder'),
        ];
    }

    /**
    * 添加
    * @return
    */
    public  function add($data)
    {
        $result = '';
        $model = new Proimages();
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
