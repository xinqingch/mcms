<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%customer}}".
 *
 * @property int $customerId ID
 * @property int|null $memberId 会员ID
 * @property string|null $name 客户名称
 * @property string|null $phone 手机号码
 * @property int|null $realestatId 所属楼盘
 * @property string|null $building 楼栋号
 * @property string|null $houseNum 房间号
 * @property string|null $notes 备注
 * @property int|null $is_curtain 是否安装窗帘
 * @property int|null $is_antiMosquito 是否安装窗花
 * @property int|null $state 状态，0删除，1可用
 * @property int|null $inputtime 添加时间
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['memberId', 'realestatId', 'is_curtain', 'is_antiMosquito', 'state', 'inputtime'], 'integer'],
            [['name', 'building'], 'string', 'max' => 255],
            [['notes'], 'string'],
            [['houseNum','phone'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customerId' => 'Customer ID',
            'memberId' => 'Member ID',
            'name' => 'Name',
            'realestatId' => 'Realestat ID',
            'building' => 'Building',
            'houseNum' => 'House Num',
            'is_curtain' => 'Is Curtain',
            'is_antiMosquito' => 'Is Anti Mosquito',
            'state' => 'State',
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
        $model = new Customer();
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
     * 检测指定字段
     * @param $f
     * @param $v
     */
    public static function checkField($f,$v){
        $total =  self::find()->where([$f=>$v])->count();
        return $total>0?true:false;
    }

    public function getCustomerTrack(){
        return $this->hasOne(CustomerTrack::className(), ['customerId' => 'customerId'])->orderBy('trackId DESC');
    }

    public function getCustomerTracksend(){
        $where =  [ '>=' , 'remindtime' , time()];

        return $this->hasOne(CustomerTrack::className(), ['customerId' => 'customerId'])->where($where)->orderBy('remindtime DESC, trackId DESC ');
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

            $this->inputtime =time();
            //执行添加的情况
        } else {
        //执行更新的情况
        }
        return true;
    }

}
