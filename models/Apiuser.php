<?php

namespace app\models;

use app\components\asinanalysis\H10apiAnalysis;
use Yii;

/**
 * This is the model class for table "{{%apiuser}}".
 *
 * @property int $id ID
 * @property int|null $type 类型0H10用户
 * @property string|null $username 用户名
 * @property string|null $password 密码
 * @property string|null $token token
 * @property string|null $cookie cookie
 */
class Apiuser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apiuser}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['cookie'], 'string'],
            [['username', 'password', 'token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'username' => 'Username',
            'password' => 'Password',
            'token' => 'Token',
            'cookie' => 'Cookie',
        ];
    }

    /**
    * 添加
    * @return
    */
    public  function add($data)
    {
        $result = [];
        $model = new Apiuser();
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

    /**
     * 读指定类型缓存
     * @param $type
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public static function getCache($type=0){
        $cachename = 'ApiUser'.$type;
        $cachedata = Yii::$app->cache->get($cachename);
        if(empty($cachedata)) {
            $user = self::find()->where(['type'=>$type])->asArray()->all();
            Yii::$app->cache->set($cachename,$user,3600*24*365);
            return $user;
        }else{
            return $cachedata;
        }
    }


    public function getUserinfo($type=0){
        $users = self::getCache($type);
        if($users){
            foreach ($users as $value){
                $h10_cookie = $value['cookie'];
                $pattern = '/ajs_user_id=(\d+)/';
                if (preg_match($pattern, $h10_cookie, $matches)) {
                    // 匹配成功，$matches[1]包含ajs_user_id的值
                    $accountId = $matches[1];
                } else {
                    // 匹配失败
                    $accountId ='';
                }
                //dump($accountId);exit;
                //调用H10数据
                $config = ['cookie'=>$h10_cookie,'accountId'=>$accountId];
                $api = new H10apiAnalysis($config);
                $checkLogin = $api->CheckLogin();
                if($checkLogin){
                    $md5 = md5($value['cookie']);
                    $cachename = 'helium10Token'.$accountId.$md5;
                    Yii::$app->cache->set($cachename,$value['token'],3600*6);//token保存6小时
                    return $value;
                }
            }

        }
    }

    /**
    * 删除前处理
    * 引入事件处理，使得业务逻辑更清晰
    * @return bool
    */

    public function beforeDelete()
    {
        parent::beforeDelete();
        Yii::$app->cache->delete('ApiUser'.$this->type);//删除缓存
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
            Yii::$app->cache->delete('ApiUser'.$this->type);//删除缓存
        } else {
            Yii::$app->cache->delete('ApiUser'.$this->type);//删除缓存
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
