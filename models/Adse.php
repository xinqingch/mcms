<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_adse".
 *
 * @property int $adseId
 * @property int|null $navId 栏目ID
 * @property int|null $adzoneId 广告位ID
 * @property int|null $start_time 开始时间
 * @property int|null $end_time 结束时间，不限为0
 * @property string $title 标题
 * @property string|null $content 广告简介
 * @property string|null $url 广告图片地址
 * @property int $listorder 排序
 * @property int|null $inputtime 创建时间
 */
class Adse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mo_adse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['navId', 'adzoneId', 'start_time', 'end_time', 'listorder', 'inputtime'], 'integer'],
            [['title'], 'required'],
            [['title'], 'string', 'max' => 100],
            [['content', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'adseId' => Yii::t('app', 'Adse ID'),
            'navId' => Yii::t('app', 'Nav ID'),
            'adzoneId' => Yii::t('app', 'Adzone Id'),
            'start_time' => Yii::t('app', 'Start time'),
            'end_time' => Yii::t('app', 'End time'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Adse content'),
            'url' => Yii::t('app', 'Adse url'),
            'listorder' => Yii::t('app', 'Listorder'),
            'inputtime' => Yii::t('app', 'Created Time'),
        ];
    }

    /**
    * 添加
    * @return
    */
    public  function add($data)
    {
        $result = '';
        $model = new Adse();
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
