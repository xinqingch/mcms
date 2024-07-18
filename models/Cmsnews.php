<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_cms_news".
 *
 * @property int $newsId
 * @property int|null $navId 栏目ID
 * @property string $title 标题
 * @property string|null $shortTitle 短标题
 * @property string $title_en 标题_EN
 * @property string|null $seotitle SEO标题
 * @property string|null $seotitle_en SEO标题_EN
 * @property string|null $seokey SEO关键字
 * @property string|null $seokey_en SEO关键字_EN
 * @property string|null $seodesc SEO简介
 * @property string|null $seodesc_en SEO简介_EN
 * @property string $source 来源
 * @property string|null $thumb 缩略图地址
 * @property int|null $hits 浏览数
 * @property string|null $key_ids 关键词ID
 * @property string|null $jumplink 跳转链接
 * @property string|null $content 内容
 * @property string|null $content_en 内容_EN
 * @property int|null $state 状态：1发布，2删除
 * @property int $listorder 排序
 * @property int|null $inputtime 创建时间
 */
class Cmsnews extends \yii\db\ActiveRecord
{
    public $navTitle;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cms_news}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['navId', 'hits', 'state', 'listorder', 'inputtime'], 'integer'],
            [['title',  'source'], 'required'],
            [['content', 'content_en'], 'string'],
            [['title', 'title_en'], 'string', 'max' => 100],
            [['shortTitle', 'source'], 'string', 'max' => 50],
            [['seotitle', 'seotitle_en', 'seokey', 'seokey_en', 'seodesc', 'seodesc_en', 'thumb', 'key_ids', 'jumplink'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'newsId' => Yii::t('app', 'News ID'),
            'navId' => Yii::t('app', 'Nav ID'),
            'title' => Yii::t('app', 'Title'),
            'shortTitle' => Yii::t('app', 'Short Title'),
            'title_en' => Yii::t('app', 'English Title'),
            'seotitle' => Yii::t('app', 'SEO Title'),
            'seotitle_en' => Yii::t('app', 'English SEO Title'),
            'seokey' => Yii::t('app', 'SEO Keyword'),
            'seokey_en' => Yii::t('app', 'English SEO Keyword'),
            'seodesc' => Yii::t('app', 'SEO Description'),
            'seodesc_en' => Yii::t('app', 'English SEO Description'),
            'source' => Yii::t('app', 'Source'),
            'thumb' => Yii::t('app', 'Thumb url'),
            'hits' => Yii::t('app', 'Hits'),
            'key_ids' => Yii::t('app', 'Keyword ids'),
            'jumplink' => Yii::t('app', 'Jump link'),
            'content' => Yii::t('app', 'Content'),
            'content_en' => Yii::t('app', 'English content'),
            'state' => Yii::t('app', 'State'),
            'listorder' => Yii::t('app', 'Listorder'),
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
        $model = new Cmsnews();
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

    /**
     * 删除前处理
     * 引入事件处理，使得业务逻辑更清晰
     * @return bool
     */

    public function beforeDelete()
    {
        parent::beforeDelete();
        //dump($this->user);
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
        //dump($this->user);
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

    public function afterFind()
    {
        parent::afterFind(); // TODO: Change the autogenerated stub
    }

}
