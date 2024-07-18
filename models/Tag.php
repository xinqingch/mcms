<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_tag".
 *
 * @property int $tagId
 * @property int|null $navId 栏目ID
 * @property string|null $title 关键词名
 * @property int|null $nums 搜索次数
 * @property int|null $state 是否关闭:1否2是
 * @property int $listorder 排序
 * @property int|null $inputtime 创建时间
 * @property int|null $updatetime 更新时间
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mo_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['navId', 'nums', 'state', 'listorder', 'inputtime', 'updatetime'], 'integer'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tagId' => Yii::t('app', 'Tag ID'),
            'navId' => Yii::t('app', 'Nav ID'),
            'title' => Yii::t('app', 'Keyword'),
            'nums' => Yii::t('app', 'Search nums'),
            'state' => Yii::t('app', 'State'),
            'listorder' => Yii::t('app', 'Listorder'),
            'inputtime' => Yii::t('app', 'Created Time'),
            'updatetime' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
    * 添加
    * @return
    */
    public  function add($data)
    {
        $result = '';
        $model = new Tag();
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
