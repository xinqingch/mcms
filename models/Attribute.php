<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_attribute".
 *
 * @property int $attributeId
 * @property int|null $navId 栏目ID
 * @property int|null $type 类型:1属性2规格
 * @property string|null $text_type 控件类型
 * @property string $title 标题
 * @property string $title_en 标题_en
 * @property string|null $value 值:用逗号分隔
 * @property int|null $issearch 是否支持搜索:1否2是
 * @property int|null $isphoto 是否支持图片:1否2是
 * @property int $listorder 排序
 */
class Attribute extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mo_attribute';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['navId', 'type', 'issearch', 'isphoto', 'listorder'], 'integer'],
            [['text_type'], 'string'],
            [['title', 'title_en'], 'required'],
            [['title', 'title_en'], 'string', 'max' => 100],
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'attributeId' => Yii::t('app', 'Attribute ID'),
            'navId' => Yii::t('app', 'Nav ID'),
            'type' => Yii::t('app', 'Type'),
            'text_type' => Yii::t('app', 'Control type'),
            'title' => Yii::t('app', 'Title'),
            'title_en' => Yii::t('app', 'English Title '),
            'value' => Yii::t('app', 'Value'),
            'issearch' => Yii::t('app', 'Is Search'),
            'isphoto' => Yii::t('app', 'Is Photo'),
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
        $model = new Attribute();
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
