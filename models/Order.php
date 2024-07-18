<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $orderId  订单号
 * @property int|null $memberId 会员ID
 * @property int|null $type 订单类型：1窗帘订单，2窗花订单
 * @property int|null $customerId 客户ID
 * @property int|null $realestatId 楼盘ID
 * @property string|null $building 楼号
 * @property string|null $houseNum 房间号
 * @property float|null $price 总价
 * @property float|null $deposit 订金
 * @property float|null $unpaid 未付款
 * @property float|null $goodsPrice 货款
 * @property int|null $state 状态：0关闭，1下单，2厂家下单，3到货，4安装，5收余款，6完成
 * @property int|null $inputtime 建立时间
 * @property int|null $exptime 到货时间
 * @property int|null $paytime 收款时间
 * @property int|null $setptime 安装时间
 * @property int|null $overtime 完成时间
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orderId'], 'required'],
            [['memberId', 'type', 'customerId', 'realestatId', 'state', 'inputtime', 'exptime', 'paytime', 'setptime', 'overtime'], 'integer'],
            [['price', 'deposit', 'unpaid', 'goodsPrice'], 'number'],
            [['orderId'], 'string', 'max' => 30],
            [['building'], 'string', 'max' => 255],
            [['houseNum'], 'string', 'max' => 20],
            [['orderId'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'orderId' => 'Order ID',
            'memberId' => 'Member ID',
            'type' => 'Type',
            'customerId' => 'Customer ID',
            'realestatId' => 'Realestat ID',
            'building' => 'Building',
            'houseNum' => 'House Num',
            'price' => 'Price',
            'deposit' => 'Deposit',
            'unpaid' => 'Unpaid',
            'goodsPrice' => 'Goods Price',
            'state' => 'State',
            'inputtime' => 'Inputtime',
            'exptime' => 'Exptime',
            'paytime' => 'Paytime',
            'setptime' => 'Setptime',
            'overtime' => 'Overtime',
        ];
    }

    /**
    * 添加
    * @return
    */
    public  function add($data)
    {
        $result = [];
        $model = new Order();
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
