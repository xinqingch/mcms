<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_permission".
 *
 * @property int $permissionId
 * @property int $roleId 角色ID
 * @property int $sysmenuId 菜单ID
 */
class Permission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mo_permission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['roleId', 'sysmenuId'], 'required'],
            [['roleId', 'sysmenuId'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'permissionId' => Yii::t('app', 'Permission ID'),
            'roleId' => Yii::t('app', 'Role Id'),
            'sysmenuId' => Yii::t('app', 'Sysmenu Id'),
        ];
    }

    /**
    * 添加
    * @return
    */
    public  function add($data)
    {
        $result = '';
        $model = new Permission();
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
        $result = '';
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
}
