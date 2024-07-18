<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%realestat}}".
 *
 * @property int $realestatId ID
 * @property string $name 楼盘名称
 * @property string|null $building 楼栋号用逗号分隔
 * @property string|null $house_type 户型用逗号分隔
 */
class Realestat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%realestat}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['building', 'house_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'realestatId' => 'Realestat ID',
            'name' => 'Name',
            'building' => 'Building',
            'house_type' => 'House Type',
        ];
    }

    /**
    * 添加
    * @return
    */
    public  function add($data)
    {
        $result = [];
        $model = new Realestat();
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
     * 楼盘栋号
     * @param $realestatId
     * @return mixed
     */
    public function getBuilding($realestatId){
        $cachename = 'building_'.$realestatId;
        $this->getCache($realestatId);
        return  Yii::$app->cache->get($cachename);
    }

    /**
     * 楼盘户型
     * @param $realestatId
     * @return mixed
     */
    public function getHouseType($realestatId){
        $cachename = 'house_type_'.$realestatId;
        $this->getCache($realestatId);
        return  Yii::$app->cache->get($cachename);
    }

    /**
     * 读取楼盘缓存
     * @param $realestatId
     * @return array|mixed
     */
    public function getCache($realestatId){
        $cachename = 'Real_estat'.$realestatId;
        $data = Yii::$app->cache->get($cachename);
        if(empty($data)){
            $model = self::findOne($realestatId);
            $data = $model->attributes;
            //写入整体信息缓存
            Yii::$app->cache->set($cachename, $data, 3600 * 24 * 365);
            //楼号与户型信息
            $cachename2 = 'building_'.$realestatId;
            $cachename1 = 'house_type_'.$realestatId;
            if($model->building) {
                $buildingdata = explode(',', $model->building);
                Yii::$app->cache->set($cachename2, $buildingdata, 3600 * 24 * 365);
            }
            if($model->house_type) {
                $housedata = explode(',', $model->house_type);
                Yii::$app->cache->set($cachename1, $housedata, 3600 * 24 * 365);
            }
        }
        return $data;
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
