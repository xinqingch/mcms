<?php

namespace app\models;

use Yii;
use app\models\MemberPermission;

/**
 * This is the model class for table "mo_nav".
 *
 * @property int $navId
 * @property int|null $topid 顶级
 * @property int|null $parentid 父ID
 * @property int|null $childid 是否有子ID:1无2有
 * @property string $arrchildid 子ID
 * @property int $pagetype 页面类型：0单页 1资讯列表 2图片列表 3招聘列表 4产品 5链接
 * @property string $title 菜单名
 * @property string $title_en 菜单名_EN
 * @property string|null $url 菜单地址
 * @property string|null $aliasname 栏目别名
 * @property int|null $level 等级
 * @property string|null $seotitle SEO标题
 * @property string|null $seotitle_en SEO标题_EN
 * @property string|null $seokey SEO关键字
 * @property string|null $seokey_en SEO关键字_EN
 * @property string|null $seodesc SEO简介
 * @property string|null $seodesc_en SEO简介_EN
 * @property int|null $state 是否显示:1是2否
 * @property int $listorder 排序
 * @property int|null $inputtime 创建时间
 */
class Nav extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%nav}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['topid', 'parentid', 'childid', 'pagetype', 'level', 'state', 'listorder', 'inputtime'], 'integer'],
            [['pagetype', 'title', 'title_en'], 'required'],
            [['arrchildid', 'title', 'title_en', 'aliasname'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 250],
            [['seotitle', 'seotitle_en', 'seokey', 'seokey_en', 'seodesc', 'seodesc_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'navId' => Yii::t('app', 'Nav ID'),
            'topid' => Yii::t('app', 'TopID'),
            'parentid' => Yii::t('app', 'Parent id'),
            'childid' => Yii::t('app', 'is Child id'),
            'arrchildid' => Yii::t('app', 'Child ids'),
            'pagetype' => Yii::t('app', 'Page type'),
            'title' => Yii::t('app', 'Menu name'),
            'title_en' => Yii::t('app', 'English Menu name'),
            'url' => Yii::t('app', 'Url'),
            'aliasname' => Yii::t('app', 'Alias name'),
            'level' => Yii::t('app', 'Level'),
            'seotitle' => Yii::t('app', 'SEO Title'),
            'seotitle_en' => Yii::t('app', 'English SEO Title'),
            'seokey' => Yii::t('app', 'SEO Keyword'),
            'seokey_en' => Yii::t('app', 'English SEO Keyword'),
            'seodesc' => Yii::t('app', 'SEO Description'),
            'seodesc_en' => Yii::t('app', 'English SEO Description'),
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
        $result = [];
        $model = new Nav();
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
        $result = [];
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
        $re = self::deleteAll('navId=:navId',[':navId'=>$id]);//删除数据
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
     *更新子ID
     * @param $id
     * @return void
     */
    public function setParent($id){
        //取所有子ID
        $arrchildid = self::find()->select('navId')->where(['parentid'=>$id])->asArray()->all();
        $re = self::updateAll(['childid'=>2,'arrchildid'=>implode(',',$arrchildid)],['navid'=>$id]);
        return $re;
    }

    /**
     * 读取所有菜单
     * @return mixed
     */
    public function getALLMenu(){
        $menu = Yii::$app->cache->get('menu');
        if(empty($menu)){
            $menu = self::find()->orderBy('listorder ASC, navId ASC')->asArray()->all();//所有菜单
            Yii::$app->cache->add('menu',$menu,3600*24);//缓存24小时

        }
        return $menu;
    }


    /**
     * 返回指定上级菜单数据
     * @param $parentid 上级
     *
     */
    protected function recombination($parentid){
        $data = $this->getALLMenu();
        $return = array();
        //var_dump($data);
        foreach ($data as $value){
            if($value['parentid']==$parentid){
                $return[]=$value;
            }
        }
        return $return;
    }

    /**
     * 递归的获取下级菜单内容
     * @param integer $id 父级菜单ID
     * @return array
     */
    public function findAllChildrens($id,$permission=true) {
        $childrens = $this->recombination($id);

        $dataList = array();
        foreach($childrens as $item) {
            /** 是否需要进行权限检查 */
//            if($permission) {
//                /** 非超级管理员，且没有访问权限，直接略过 */
//                if($this->hasAssign($item['navId'])){
//                    continue;
//                }
//            }

            $children = $this->findAllChildrens($item['navId'], $permission);
            if($children) {
                $item['childrens'] = $children;
            }
            array_push($dataList, $item);
        }
        return $dataList;
    }

    /**
     * 检验菜单是否有访问权限
     * @return boolean
     */
    public function hasAssign($navId) {
        $roles = Yii::$app->user->identity->getRoleId();
        //dump($roles);
        if(!$roles) {
            return false;
        }
        $condition = ['memberroleId'=>$roles, 'navId'=>$navId];
        $menu = MemberPermission::find()->where($condition)->all();
        if($menu) {
            return true;
        }
        return false;
    }

    /**
     * 生成所有菜单下拉列表数据
     */
    public function getMenuOption(){
        $data = $this->getALLMenu();
        $data = Helper::array_sort($data,'navId');
        $item =['0'=>'一级菜单'];
        foreach ($data as $v){
            $item[$v['navId']]=$v['title'];
        }
        return $item;
    }

    public function beforeDelete(){
        self::delCache();//清空缓存
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
            self::delCache();//清空缓存
        } else {
            //这里是更新数据
            self::delCache();//清空缓存
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
            $this->inputtime = time();
        } else {
            //执行更新的情况
        }
        return true;
    }

    /**
     * 删除缓存
     * @return bool
     */
    public function delCache(){
        Yii::$app->cache->delete('menu');//缓存
        return true;
    }




}
