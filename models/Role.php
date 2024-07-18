<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%role}}".
 *
 * @property int $roleId
 * @property string $rolename 角色名称
 * @property string $description 角色描述
 * @property int|null $state 状态：0无效1有效
 */
class Role extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%role}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rolename', 'description'], 'required'],
            [['state'], 'integer'],
            [['rolename'], 'string', 'max' => 30],
            [['description'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'roleId' => 'Role ID',
            'rolename' => '角色名',
            'description' => '描述',
            'state' => 'State',
        ];
    }

    /**
    * 添加
    * @return
    */
    public  function add($data)
    {
        $result = [];
        $model = new Role();
        $model->attributes = $data;
        $model->state = self::STATUS_ACTIVE;
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


    public static function listoption(){
        $data = Yii::$app->cache->get('Admin_role');
        if(empty($data)){
            $data = self::find()->where(['state'=>1])->asArray()->all();
            Yii::$app->cache->set('Admin_role',$data,3600*24*360);
        }
        return ArrayHelper::map($data,'roleId','rolename');
    }

    public static function RefreshCache(){
        Yii::$app->cache->delete('Admin_role');
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
        self::RefreshCache();
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
            self::RefreshCache();
        } else {
            //这里是更新数据
            self::RefreshCache();
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
