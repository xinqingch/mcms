<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_block".
 *
 * @property int $blockId
 * @property int|null $navId 栏目ID
 * @property string $title 标题
 * @property string|null $pos 碎片标识
 * @property int|null $type 碎片类型1HTML2模板
 * @property string|null $photo 序列化图片库
 * @property string|null $content 碎片内容
 * @property string|null $template 碎片模板
 * @property int|null $state 状态：1发布，2删除
 * @property int $listorder 排序
 * @property int|null $inputtime 创建时间
 */
class Block extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mo_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['navId', 'type', 'state', 'listorder', 'inputtime'], 'integer'],
            [['title'], 'required'],
            [['photo', 'content', 'template'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['pos'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'blockId' => Yii::t('app', 'Block ID'),
            'navId' => Yii::t('app', 'Nav ID'),
            'title' => Yii::t('app', 'Title'),
            'pos' => Yii::t('app', 'Block pos'),
            'type' => Yii::t('app', 'Block type'),
            'photo' => Yii::t('app', 'Block photo'),
            'content' => Yii::t('app', 'Block content'),
            'template' => Yii::t('app', 'Block template'),
            'state' => Yii::t('app', 'State'),
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
        $model = new Block();
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
