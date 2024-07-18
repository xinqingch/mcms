<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_search_log".
 *
 * @property int $searchlogId
 * @property string $type 搜索类型
 * @property string|null $keyword 搜索关键词
 * @property int|null $nums 搜索次数
 * @property int|null $ip 搜索ip
 * @property int|null $state 是否关闭:1否2是
 * @property int $listorder 排序
 * @property int|null $inputtime 创建时间
 * @property int|null $updatetime 更新时间
 */
class Searchlog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%search_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type','keyword'], 'required'],
            [['type'], 'string'],
            [['nums', 'ip', 'state', 'listorder', 'inputtime', 'updatetime'], 'integer'],
            [['keyword'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'searchlogId' => Yii::t('app', 'Searchlog ID'),
            'type' => Yii::t('app', 'Search type'),
            'keyword' => Yii::t('app', 'Keyword'),
            'nums' => Yii::t('app', 'Search nums'),
            'ip' => Yii::t('app', 'Ip'),
            'state' => Yii::t('app', 'State'),
            'listorder' => Yii::t('app', 'Listorder'),
            'inputtime' => Yii::t('app', 'Created Time'),
            'updatetime' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
    * 添加
    * @return
    */
    public  function add($data)
    {
        $result = ['state'=>false,'data'=>''];
        $model = new Searchlog();
        $model->attributes = $data;
        $model->inputtime =$model->updatetime = time();
        $check = $this->check($data['keyword']);
        //dump($check);
        if($check){
            //更新关键词
            $upmodel = self::find()->where(['keyword'=>$data['keyword']])->one();

            $upmodel->nums =$upmodel->nums+1;
            if($upmodel->save()){
                $result['state'] = true;
                $result['data'] = $model->attributes;
            }else{
                $error = $model->getErrors();
                $result['state'] = false;
                $result['data'] = $error;
            }

        }else{

            if($model->validate() && $model->save()){
                $result['state'] = true;
                $result['data'] = $model->attributes;
            }else{
                $error = $model->getErrors();
                $result['state'] = false;
                $result['data'] = $error;
            }
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

    /**
     * 检测关键词是否可用
     * @param $keyword
     * @return bool
     */
    public function check($keyword){
        $total = self::find()->where(['keyword'=>$keyword])->count();
        return $total>0?true:false;
    }


    public function getCache($type='search'){
        $keyname = 'all-'.$type.'-key';
        $data = Yii::$app->cache->get($keyname);
        if(empty($data)){
            $item = self::find()->select(['keyword'])->where(['type'=>$type])->asArray()->all();
            if($item){
                foreach ($item as $value){
                    $data[]=$value['keyword'];
                }
                Yii::$app->cache->set($keyname,$data,3600);
            }
        }
        return $data;
    }

    /**
     * 重置缓存
     * @return bool
     */
    public static function RefreshCache(){
        Yii::$app->cache->delete('all-search-key');
        return true;
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
