<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_pos_log".
 *
 * @property int $poslogId
 * @property int|null $navId 栏目ID
 * @property int|null $positionsId 推荐位ID
 * @property int|null $start_time 开始时间
 * @property int|null $end_time 结束时间，不限为0
 * @property int|null $content_id 内容ID（关联：产品 or 资讯)
 * @property string $title 标题
 * @property string $title_en 标题_en
 * @property string|null $content 简介
 * @property string|null $pic 图片地址
 * @property int $listorder 排序
 * @property int|null $inputtime 创建时间
 */
class Poslog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mo_pos_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['navId', 'positionsId', 'start_time', 'end_time', 'content_id', 'listorder', 'inputtime'], 'integer'],
            [['title', 'title_en'], 'required'],
            [['title', 'title_en'], 'string', 'max' => 100],
            [['content', 'pic'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'poslogId' => Yii::t('app', 'Poslog ID'),
            'navId' => Yii::t('app', 'Nav ID'),
            'positionsId' => Yii::t('app', 'Positions Id'),
            'start_time' => Yii::t('app', 'Start time'),
            'end_time' => Yii::t('app', 'End time'),
            'content_id' => Yii::t('app', 'Content Id'),
            'title' => Yii::t('app', 'Title'),
            'title_en' => Yii::t('app', 'English Title'),
            'content' => Yii::t('app', 'Content'),
            'pic' => Yii::t('app', 'Pic url'),
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
        $model = new Poslog();
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
