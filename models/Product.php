<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_product".
 *
 * @property int $productId
 * @property int|null $type 销售模式1:零售,2:批发,3积分
 * @property int|null $navId 栏目ID
 * @property int|null $areaId 地域
 * @property string $title 标题
 * @property string $title_en 标题_en
 * @property string|null $seotitle SEO标题
 * @property string|null $seotitle_en SEO标题_EN
 * @property string|null $seokey SEO关键字
 * @property string|null $seokey_en SEO关键字_EN
 * @property string|null $seodesc SEO简介
 * @property string|null $seodesc_en SEO简介_EN
 * @property string|null $product_no 产品编号
 * @property float|null $price 产品实售价
 * @property float|null $saleprice 产品销售价
 * @property float|null $costprice 产品成本价
 * @property int|null $min_num 最小销售量
 * @property int|null $inventory 产品库存
 * @property string|null $pic 产品主图片地址
 * @property string|null $content 简介
 * @property int|null $state 是否上架:1否2是3逻辑删除
 * @property int $listorder 排序
 * @property int|null $inputtime 创建时间
 * @property int|null $updatetime 更新时间
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mo_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'navId', 'areaId', 'min_num', 'inventory', 'state', 'listorder', 'inputtime', 'updatetime'], 'integer'],
            [['title', 'title_en'], 'required'],
            [['price', 'saleprice', 'costprice'], 'number'],
            [['title', 'title_en'], 'string', 'max' => 100],
            [['seotitle', 'seotitle_en', 'seokey', 'seokey_en', 'seodesc', 'seodesc_en', 'product_no', 'pic', 'content'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'productId' => Yii::t('app', 'Product ID'),
            'type' => Yii::t('app', 'Sale type'),
            'navId' => Yii::t('app', 'Nav ID'),
            'areaId' => Yii::t('app', 'Area Id'),
            'title' => Yii::t('app', 'Title'),
            'title_en' => Yii::t('app', 'English Title'),
            'seotitle' => Yii::t('app', 'SEO Title'),
            'seotitle_en' => Yii::t('app', 'English SEO Title'),
            'seokey' => Yii::t('app', 'SEO Keyword'),
            'seokey_en' => Yii::t('app', 'English SEO Keyword'),
            'seodesc' => Yii::t('app', 'SEO Description'),
            'seodesc_en' => Yii::t('app', 'English SEO Description'),
            'product_no' => Yii::t('app', 'Product No'),
            'price' => Yii::t('app', 'Price'),
            'saleprice' => Yii::t('app', 'Sale price'),
            'costprice' => Yii::t('app', 'Cost price'),
            'min_num' => Yii::t('app', 'Min sale num'),
            'inventory' => Yii::t('app', 'Inventory'),
            'pic' => Yii::t('app', 'Pic url'),
            'content' => Yii::t('app', 'content'),
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
        $result = '';
        $model = new Product();
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
