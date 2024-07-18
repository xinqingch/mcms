<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%system_log}}".
 *
 * @property int $systemlogId
 * @property int|null $memberId 操作会员
 * @property string|null $url 操作地址
 * @property string|null $data 操作数据
 * @property int|null $inputtime 操作时间
 */
class SystemLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%system_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['memberId', 'inputtime'], 'integer'],
            [['data'], 'string'],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'systemlogId' => 'Systemlog ID',
            'memberId' => 'Member ID',
            'url' => 'Url',
            'data' => 'Data',
            'inputtime' => 'Inputtime',
        ];
    }

    /**
    * 添加
    * @return
    */
    public  function add($data)
    {
        $result = [];
        $model = new SystemLog();
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
        $result = [];
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
    /**
    * 删除前处理
    * 引入事件处理，使得业务逻辑更清晰
    * @return bool
    */

    public function beforeDelete()
    {
        parent::beforeDelete();
        //在这里做删除前的事情
        return true;
    }

    /**
    * 删除后处理
    * 引入事件处理，使得业务逻辑更清晰
    * @return bool
    */

    public function afterDelete()
    {
        parent::afterDelete();
        //在这里做删除后的事情
        return true;
    }

    /**
    *保存后执行
    * @param bool $insert
    * @param array $changedAttributes
    */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if($insert) {
            //这里是新增数据
        } else {
            //这里是更新数据
        }
        return true;
    }

    /**
    * 保存前
    * @param bool $insert
    * @return bool
    */
    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        if($insert) {
        //执行添加的情况
        } else {
        //执行更新的情况
        }
        return true;
    }

}