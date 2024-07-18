<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_cms_page".
 *
 * @property int $pageId
 * @property int|null $navId 栏目ID
 * @property string $title 标题
 * @property string $title_en 标题_EN
 * @property string|null $seotitle SEO标题
 * @property string|null $seotitle_en SEO标题_EN
 * @property string|null $seokey SEO关键字
 * @property string|null $seokey_en SEO关键字_EN
 * @property string|null $seodesc SEO简介
 * @property string|null $seodesc_en SEO简介_EN
 * @property string|null $content 内容
 * @property string|null $content_en 内容_EN
 * @property int|null $state 状态：1发布，2删除
 * @property int $listorder 排序
 * @property int|null $inputtime 创建时间
 */
class Cmspage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mo_cms_page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['navId', 'state', 'listorder', 'inputtime'], 'integer'],
            [['title', 'title_en'], 'required'],
            [['content', 'content_en'], 'string'],
            [['title', 'title_en'], 'string', 'max' => 100],
            [['seotitle', 'seotitle_en', 'seokey', 'seokey_en', 'seodesc', 'seodesc_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pageId' => Yii::t('app', 'Page ID'),
            'navId' => Yii::t('app', 'Nav ID'),
            'title' => Yii::t('app', 'Title'),
            'title_en' => Yii::t('app', 'English Title'),
            'seotitle' => Yii::t('app', 'SEO Title'),
            'seotitle_en' => Yii::t('app', 'English SEO Title'),
            'seokey' => Yii::t('app', 'SEO Keyword'),
            'seokey_en' => Yii::t('app', 'English SEO Keyword'),
            'seodesc' => Yii::t('app', 'SEO Description'),
            'seodesc_en' => Yii::t('app', 'English SEO Description'),
            'content' => Yii::t('app', 'content'),
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
        $result = '';
        $model = new Cmspage();
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
