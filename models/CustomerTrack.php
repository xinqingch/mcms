<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%customer_track}}".
 *
 * @property int $trackId ID
 * @property int|null $memberId 会员ID
 * @property int|null $customerId 客户ID
 * @property string|null $detail 内容
 * @property int|null $inputtime 创建时间
 * @property int|null $remindtime 提醒时间
 * @property string|null $send 提醒内容
 * @property string|null $images 图片备注
 */
class CustomerTrack extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customer_track}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['memberId', 'customerId', 'inputtime', 'remindtime','top'], 'integer'],
            [['detail', 'send'], 'string', 'max' => 255],
            [['images'],'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'trackId' => 'Track ID',
            'memberId' => 'Member ID',
            'customerId' => '客户ID',
            'detail' => '内容',
            'inputtime' => '创建时间',
            'remindtime' => '提醒时间',
            'send' => '提醒内容',
            'images' => '图片',
            'top'=>'是否置顶',
        ];
    }

    /**
    * 添加
    * @return
    */
    public  function add($data)
    {
        $result = [];
        $model = new CustomerTrack();
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

    public function getCustomer(){
        return $this->hasOne(Customer::className(), ['customerId' => 'customerId']);
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
            $this->inputtime = time();
        } else {
        //执行更新的情况
        }
        return true;
    }

}
