<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_certificate".
 *
 * @property int $certificateId
 * @property string $type 证书类型
 * @property string|null $level
 * @property string|null $name 姓名
 * @property string|null $sex
 * @property string|null $card 身份证
 * @property string|null $num 证书编号
 * @property string|null $organization 培训机构
 * @property string|null $createTime 发证时间
 */
class Certificate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mo_certificate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sex'], 'string'],
            [['createTime'], 'safe'],
            [['type', 'level', 'name'], 'string', 'max' => 30],
            [['card', 'num'], 'string', 'max' => 20],
            [['organization'], 'string', 'max' => 50],
            [['qrcode','face','pic'], 'string', 'max' => 255],
            [['certificateId'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'certificateId' => 'Certificate ID',
            'type' => 'Type',
            'level' => 'Level',
            'name' => 'Name',
            'sex' => 'Sex',
            'card' => 'Card',
            'num' => 'Num',
            'organization' => 'Organization',
            'createTime' => 'Create Time',
        ];
    }

    /**
     * 添加
     * @return
     */
    public  function add($data)
    {
        $result = ['state'=>false,'data'=>''];
        $model = new Certificate();
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
        $result = ['state'=>false,'data'=>''];
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

    public function del( $id ){
        $result = ['state'=>true,'data'=>''];
        $re = self::deleteAll(['certificateId'=>$id]);//删除数据
        //dump($re);
        if($re){
            $result['state'] = true;
            $result['data'] = '删除成功';
        }else{
            $error = $re->getErrors();
            $result['state'] = false;
            $result['data'] = $error;
        }
        return $result;
    }
}
