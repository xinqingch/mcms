<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use app\models\Helper;

/**
 * This is the model class for table "mo_adminer".
 *
 * @property int $adminerId
 * @property int $roleId 管理员角色
 * @property string $username 管理员账号
 * @property string $password 管理员密码
 * @property int $login_ip 登录IP
 * @property int $login_time 登录时间
 * @property string $code 盐值
 * @property int|null $isadmin 是否超管：0否1是
 * @property int|null $state 状态：0无效1有效
 * @property int|null $inputtime 创建时间
 */
class Adminer extends \yii\db\ActiveRecord   implements \yii\web\IdentityInterface
{
    public $id;
    public $password;
    public $repassword;
    public $authKey;
    public $accessToken;
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ROLE_USER = 10;
    const ROLE_ID = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mo_adminer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [


            // 在 "login" 场景下 username 和 password 必须有值
            [['roleId', 'username', 'password_hash', 'login_ip', 'login_time'], 'required'],
            [['roleId', 'login_ip', 'login_time', 'isadmin', 'state', 'inputtime'], 'integer'],
            [['username'], 'string', 'max' => 30],
            [['password_hash'], 'string', 'max' => 255],
            ['state', 'default', 'value' => self::STATUS_ACTIVE],
            ['roleId', 'default', 'value' => self::ROLE_ID],
            ['state', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'adminerId' => Yii::t('app', 'Adminer ID'),
            'roleId' => Yii::t('app', 'Role Id'),
            'username' => Yii::t('app', 'User name'),
            'password' => Yii::t('app', 'Password'),
            'password_hash' => Yii::t('app', 'Password'),
            'login_ip' => Yii::t('app', 'Login ip'),
            'login_time' => Yii::t('app', 'Login time'),
            'isadmin' => Yii::t('app', 'Is admin'),
            'state' => Yii::t('app', 'State'),
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
        $model = new Adminer();
        $model->attributes = $data;
        $model->setPassword($data['password']);
        $model->generateAuthKey();
        $model->generatePasswordResetToken();
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
            self::delCache();//清空缓存
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
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne(['adminerId' => $id, 'state' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface|null the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
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
        return static::findOne(['username' => $username, 'state' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'state' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getIsadmin()
    {
        return $this->attributes['isadmin'];
    }

    public function getname(){
        return $this->attributes['username'];
    }

    public function getRoleId(){
        return $this->attributes['roleId'];
    }

    /**
     * 取用户信息
     * @return array
     */
    public function getUser(){
        return $this->attributes;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
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

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getCache(){

    }

}
