<?php

namespace app\models;
use app\models\Helper;
use Yii;

class User extends \yii\db\ActiveRecord  implements \yii\web\IdentityInterface
{
    public $id;
    public $password;
    public $repassword;
    public $authKey;
    public $accessToken;
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    /*private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];*/

    public static function tableName()
    {
        return "{{%member}}";
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['username'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 50],
            [['authKey'], 'string', 'max' => 100],
            [['access_token','password_hash'], 'string', 'max' => 100],
            [['login_ip','login_time','exptime','inputtime'],'integer'],
            ['state', 'default', 'value' => self::STATUS_ACTIVE],
            ['state', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'memberId' => 'ID',
            'username' => Yii::t('app', 'User name'),
            'password' => Yii::t('app', 'Password'),
            'phone' => 'Phone',
            'authKey' => 'AuthKey',
            'accessToken' => 'AccessToken',
            'login_ip' => Yii::t('app', 'Login ip'),
            'login_time' => Yii::t('app', 'Login time'),
            'state' => Yii::t('app', 'State'),
            'exptime' => Yii::t('app', 'Valid Time'),
            'inputtime' => Yii::t('app', 'Created Time'),
        ];
    }

    /**
     * 添加
     * @return
     */
    public  function add($data)
    {
        $result = ['state'=>false,'data'=>''];
        $model = new User();
        $model->attributes = $data;
        $model->setPassword($data['password']);
        $model->generateAuthKey();
        $model->login_time = time();
        $model->inputtime = $model->login_time;
        $model->login_ip = ip2long(Helper::GetIP());
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
        $result = ['state'=>false,'data'=>''];
        $model = self::findOne($id);
        $model->attributes = $data;
        if(isset($data['password'])){
            $model->setPassword($data['password']);
            $model->generateAuthKey();
        }
        $model->login_time = time();
        $model->login_ip = ip2long(Helper::GetIP());
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

    public function del( $id ){
        $result = ['state'=>true,'data'=>''];
        $re = self::up($id,['state'=>0]);//删除数据
        //dump($re);
        if($re){
            //self::delCache();//清空缓存
            $result['state'] = true;
            $result['data'] = '删除成功';
        }else{
            $error = $re->getErrors();
            $result['state'] = false;
            $result['data'] = $error;
        }
        return $result;
    }



    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['memberId' => $id, 'state' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = User::find()
            ->where(['username' => $username, 'state' => self::STATUS_ACTIVE])
            ->asArray()
            ->one();

        if($user){
            return new static($user);
        }

        return null;

    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * 读取会员角色
     * @return mixed
     */
    public function getRoleId(){
        return $this->attributes['memberroleId'];
    }

    /**
     * 取用户信息
     * @return array
     */
    public function getUser(){
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
}
