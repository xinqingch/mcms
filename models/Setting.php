<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "mo_setting".
 *
 * @property int $settingId
 * @property string $title 标题
 * @property string $variable 配置名
 * @property string|null $valued 配置值
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'variable'], 'required'],
            [['valued'], 'string'],
            [['title', 'variable'], 'string', 'max' => 100],
            [['variable'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'settingId' => Yii::t('app', 'Setting ID'),
            'title' => Yii::t('app', 'Title'),
            'variable' => Yii::t('app', 'Variable'),
            'valued' => Yii::t('app', 'Valued'),
        ];
    }

    /**
    * 添加
    * @return
    */
    public  function add($data)
    {
        $result = '';
        $model = new Setting();
        $model->attributes = $data;
        if($model->validate() && $model->save()){
            $result['state'] = true;
            $result['data'] = $model->attributes;
        }else{
            $error = $model->getErrors();
            $result['state'] = false;
            $result['data'] = $error;
        }
        $this->delCache();
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
        $model = self::find()->where(['variable'=>$id])->one();
        $model->valued = $data;
        if($model->validate() && $model->save()){
            $result['state'] = true;
            $result['data'] = $model;
        }else{
            $error = $model->getErrors();
            $result['state'] = false;
            $result['data'] = $error;
        }
        $this->delCache();
        return $result;
    }
    
    
    /**
     * 删除缓存
     * @return bool
     */
    public function delCache(){

        Yii::$app->cache->delete('setting');

        return true;
    }

    /**
     * 取所有
     * @return array|mixed|\yii\db\ActiveRecord[]
     */
    public static function getCache(){
        $data = Yii::$app->cache->get('setting');
        if(empty($data)){
            $model = self::find()->orderBy('settingId ASC')->asArray()->all();//所有配置
            $data =  ArrayHelper::map($model,'variable','valued');
            Yii::$app->cache->add('setting',$data,3600*24*365);//缓存24小时
        }
        return $data;
    }

    /**
     * 取配置信息
     * @param $name
     * @return mixed
     */
    public static function getStting($name){
        $data = Yii::$app->cache->get('setting');
        return $data[$name];
    }

    /**
     * 保存前操作
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if($insert){
            }
            else
            {
            }
            $this->delCache();
            return true;
        }
        else
        {
            return false;
        }

    }

}
