<?php

namespace app\models;

use Yii;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "mo_attachment".
 *
 * @property int $attachmentId
 * @property int|null $memberId 会员
 * @property string $file_name 文件名
 * @property string $url 文件地址
 * @property string $title 标题
 * @property string $file_type 文件类型
 * @property int $file_size 文件大小
 * @property string|null $thumb 文件缩略图地址
 * @property int|null $is_image 是否图片：1否2是
 * @property int|null $ip 上传IP
 * @property int|null $state 状态：1有效2无效
 * @property string|null $md5key 文件md5
 * @property int|null $inputtime 创建时间
 */
class Attachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%attachment}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['memberId', 'file_size', 'is_image', 'ip', 'state', 'inputtime'], 'integer'],
            [['file_name', 'url', 'title', 'file_type'], 'required'],
            [['file_name', 'file_type'], 'string', 'max' => 100],
            [['url', 'thumb'], 'string', 'max' => 250],
            [['title'], 'string', 'max' => 30],
            [['md5key'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'attachmentId' => Yii::t('app', 'Attachment ID'),
            'memberId' => Yii::t('app', '会员'),
            'file_name' => Yii::t('app', '文件名'),
            'url' => Yii::t('app', '文件地址'),
            'title' => Yii::t('app', '标题'),
            'file_type' => Yii::t('app', '文件类型'),
            'file_size' => Yii::t('app', '文件大小'),
            'thumb' => Yii::t('app', '文件缩略图地址'),
            'is_image' => Yii::t('app', '是否图片：1否2是'),
            'ip' => Yii::t('app', '上传IP'),
            'state' => Yii::t('app', '状态：1有效2无效'),
            'md5key' => Yii::t('app', '文件md5'),
            'inputtime' => Yii::t('app', '创建时间'),
        ];
    }


    /**
     * 添加
     * @return
     */
    public  function add($data)
    {
        $result = [];
        $check = $this->check($data['md5key']);
        //dump($check);
        if($check) {
            $model = new Attachment();
            $model->attributes = $data;
            if ($model->validate() && $model->save()) {
                $result['state'] = true;
                $result['data'] = $model->attributes;
            } else {
                $error = $model->getErrors();
                $result['state'] = false;
                $result['data'] = $error;
            }
            $this->delCache();
        }else{
            $result = $this->getfile($data['md5key']);
        }
        return $result;
    }

    /**
     * 根据MD5查文件
     * @param $md5
     * @return array|\yii\db\ActiveRecord|null
     */
    public function getfile($md5){
        $data = $this->getCache();
        //dump($data[$md5]);
        return $data[$md5];
    }

    /**
     * 通过ID取值
     * @param $id
     * @return array|mixed
     */
    public function getIdfile($id){
        $re = [];
        $data = $this->getCache();
        foreach ($data as $val){
            if($val['attachmentId']==$id){
                $re = $val;
            }
        }
        return $re;
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
        $model = self::find()->where(['attachmentId'=>$id])->one();
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
     * 检查文件是否存在
     * @param $md5
     * @return bool
     */
    public function check($md5){
        $data = $this->getCache();
        if(array_key_exists($md5, $data)){
            return false;
        }else{
            return true;
        }
    }
    /**
     * 删除缓存
     * @return bool
     */
    public function delCache(){

        Yii::$app->cache->delete('file_md5cache');

        return true;
    }

    protected function getCache(){
        $data = Yii::$app->cache->get('file_md5cache');
        if(empty($data)){
            $model = self::find()->where(['state'=>1])->asArray()->all();//所有配置
            $data =  ArrayHelper::index($model, 'md5key');
            Yii::$app->cache->add('file_md5cache',$data,3600*24*365);//缓存24小时
        }
        return $data;
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
