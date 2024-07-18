<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_services".
 *
 * @property int $servicesId
 * @property int|null $type 客服类型:1:qq,2:MSN 3旺旺
 * @property string|null $text_type 控件类型
 * @property string $account 账号
 * @property string $title 客服名称
 * @property string $title_en 客服名称_en
 * @property string|null $tel 客服电话
 * @property int|null $isdefault 是否默认:1否2是
 * @property int $listorder 排序
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mo_services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'isdefault', 'listorder'], 'integer'],
            [['text_type'], 'string'],
            [['account', 'title', 'title_en'], 'required'],
            [['account', 'title', 'title_en'], 'string', 'max' => 100],
            [['tel'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'servicesId' => Yii::t('app', 'Services ID'),
            'type' => Yii::t('app', 'Service type'),
            'text_type' => Yii::t('app', 'Control type'),
            'account' => Yii::t('app', 'Account'),
            'title' => Yii::t('app', 'Service title'),
            'title_en' => Yii::t('app', 'English service title'),
            'tel' => Yii::t('app', 'Tel'),
            'isdefault' => Yii::t('app', 'Is default'),
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
        $model = new Services();
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
