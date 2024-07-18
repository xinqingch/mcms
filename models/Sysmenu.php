<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mo_sysmenu".
 *
 * @property int $sysmenuId
 * @property int $fatherId 父节点
 * @property int|null $hidden 是否隐藏
 * @property string $type 菜单类型
 * @property string $title 菜单名
 * @property string $url 菜单地址
 * @property string $route 菜单路由
 * @property int $listorder 排序
 * @property string|null $fontico 图标
 */
class Sysmenu extends \yii\db\ActiveRecord
{
    private $_childrens = array();

    const TYPE_NAVIGATE = 'navigate';
    const TYPE_GROUP    = 'group';
    const TYPE_MENU     = 'menu';
    const TYPE_ACTION   = 'action';

    public $state;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sysmenu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hidden', 'listorder'], 'integer'],
            [['type', 'title'], 'required'],
            [['type','sysmenuId','fatherId','fontico'], 'string'],
            [['title'], 'string', 'max' => 30],
            [['url', 'route'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sysmenuId' => Yii::t('app', 'Sysmenu ID'),
            'fatherId' => Yii::t('app', 'Father ID'),
            'hidden' => Yii::t('app', 'Hidden'),
            'type' => Yii::t('app', 'Type'),
            'title' => Yii::t('app', 'Title'),
            'url' => Yii::t('app', 'Url'),
            'route' => Yii::t('app', 'Route'),
            'listorder' => Yii::t('app', 'Listorder'),
            'fontico' => Yii::t('app', 'Fontico'),
        ];
    }

    /**
     * 添加
     * @return
     */
    public  function add($data,$leve='000000000000')
    {
        $result = ['state'=>true,'data'=>''];
        $model = new Sysmenu();
        $model->fatherId = $leve;
        $model->attributes = $data;
        if($model->validate() && $model->save()){
            $result['state'] = true;
            $result['data'] = $model->attributes;
            self::delCache();
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
        $result = ['state'=>true,'data'=>''];
        $model = self::findOne(['sysmenuId'=>$id]);
        //var_dump($model->fatherId);
        //dump($data['fatherId']);
        if(isset($data['fatherId'])&&$data['fatherId']!=$model->fatherId){//如果父菜单不同则修改sysmenuId
            $data['sysmenuId']=self::getMenuId($data['fatherId']);
        }
        $model->attributes = $data;
        if($model->validate() && $model->save()){
            $result['state'] = true;
            $result['data'] = $model->attributes;
            self::delCache();
        }else{
            $error = $model->getErrors();
            $result['state'] = false;
            $result['data'] = $error;
        }
        return $result;
    }

    public function del( $id ){
        $result = ['state'=>true,'data'=>''];
        $re = self::deleteAll('sysmenuId=:sysmenuId',[':sysmenuId'=>$id]);//删除数据
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

    public function beforeDelete(){
        self::delCache();//清空缓存
    }

    /**
     * 删除缓存
     * @return bool
     */
    public function delCache(){
        Yii::$app->cache->delete('sysmenu');//缓存
        return true;
    }

    /**
     * 读取所有菜单
     * @return mixed
     */
    public function getALLMenu(){
        $menu = Yii::$app->cache->get('sysmenu');
        if(empty($menu)){
            $menu = self::find()->orderBy('listorder ASC, sysmenuId ASC')->asArray()->all();//所有菜单
            Yii::$app->cache->add('sysmenu',$menu,3600*24);//缓存24小时

        }
        return $menu;
    }


    /**
     * 返回指定上级菜单数据
     * @param $fatherId 上级
     *
     */
    protected function recombination($fatherId){
        $data = $this->getALLMenu();
        $return = array();
        //var_dump($data);
        foreach ($data as $value){
            if($value['fatherId']==$fatherId){
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
            if($permission) {
                /** 非超级管理员，且没有访问权限，直接略过 */
                //dump(Yii::$app->admin->identity->toArray());exit;
                if(Yii::$app->admin->identity->getIsadmin()==0 && !$this->hasAssign($item['sysmenuId'])){
                    continue;
                }
            }

            $children = $this->findAllChildrens($item['sysmenuId'], $permission);
            if($children) {
                $item['childrens'] = $children;
            }
            array_push($dataList, $item);
        }
        return $dataList;
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findAllByNavigate($id) {
        $condition = ['type'=>self::TYPE_GROUP,'fatherId'=>$id];
        $groups = self::find()->where($condition)->orderBy('listorder ASC, systemId ASC')->all();
        if(Yii::$app->admin->identity->getIsadmin()==0) {
            foreach ($groups as $index => $item) {
                if (!$item->hasAssign()) {
                    unset($groups[$index]);
                }
            }
        }


        foreach($groups as & $item) {
            $item->childrens = $this->findAllByGroup($item->id);
        }
        return $groups;
    }

    public function findAllByGroup($id) {
        $condition = ['type'=>self::TYPE_MENU,'fatherId'=>$id];
        $menus = self::find()->where($condition)->orderBy('listorder ASC, systemId ASC')->all();
        if(Yii::$app->admin->identity->getIsadmin()==0) {
            foreach ($menus as $index => $item) {
                if (!$item->hasAssign()) {
                    unset($menus[$index]);
                }
            }
        }

        foreach($menus as & $item) {
            $item->childrens = $this->findAllByMenu($item->id);
        }
        return $menus;
    }

    /**
     * 获取菜单项的子项
     * @param unknown $id
     */
    public function findAllByMenu($id) {
        $condition = ['type'=>self::TYPE_ACTION,'fatherId'=>$id];
        $result = self::find()->where($condition)->orderBy('listorder ASC, systemId ASC')->all();

        if(Yii::$app->admin->identity->getIsadmin()==0) {
            foreach($result as $index => $item) {
                if(!$item->hasAssign()) {
                    unset($result[$index]);
                }
            }
        }
        return $result;
    }

    /**
     * 判断角色ID是否有访问权限
     * @param integer $roleId
     * @return boolean
     */
    public function isAssign($roleId,$sysmenuId=null) {
        $sysmenuId = !empty($sysmenuId)?$sysmenuId:$this->sysmenuId;
        $condition = ['roleId'=>$roleId, 'sysmenuId'=>$sysmenuId];
        $permission = Permission::find()->where($condition)->one();
        return !is_null($permission)? true : false;
    }

    /**
     * 检验菜单是否有访问权限
     * @return boolean
     */
    public function hasAssign($sysmenuId) {
        $roles = Yii::$app->admin->identity->getRoleId();
        //dump($roles);
        if(!$roles) {
            return false;
        }
        $condition = ['roleId'=>$roles, 'sysmenuId'=>$sysmenuId];
        $menu = Permission::find()->where($condition)->all();
        if($menu) {
            return true;
        }
        return false;
    }

    /**
     * 获取我有权限访问的导航栏菜单ID
     * @return array
     */
    public function fetchMyNavigate() {

        $tMenu = self::tableName();
        $tPermission = Permission::tableName();
        $sql = "SELECT sysmenuId FROM {$tMenu} t WHERE `type`='navigate' AND EXISTS(SELECT 1 FROM {$tPermission} WHERE t.`sysmenuId`=sysmenuId AND roleId IN (:roles))";
        $cmd = Yii::$app->getDb()->createCommand($sql);
        $roles = implode(',', Yii::$app->user->getState('roles'));
        $cmd->bindValue(':roles', $roles, PDO::PARAM_STR);
        return $cmd->queryColumn();
    }


    public function getTopId($url){
        $condition = ['like','route',$url];
        $model = self::find()->select('fatherId')->where($condition)->one();
        $topid = '';
        if($model){
            $fatherId = $model->fatherId;
            $topid = substr($fatherId,0,3);
            $topid = $topid.'000000000';
        }
        return $topid;


    }

    /**
     * 取当前路由的菜单名
     * @param $route
     */
    public function getMenuName(){
        $route = '/'.Yii::$app->controller->route;
        $data = $this->getALLMenu();
        $menuname = '';
        //var_dump($data);
        foreach ($data as $value){
            if($value['route']==$route){
                $menuname = $value['title'];
            }
        }
        return $menuname;
    }

    /**
     * 生成所有菜单下拉列表数据
     */
    public function getMenuOption(){
        $data = $this->getALLMenu();
        $data = Helper::array_sort($data,'sysmenuId');
        $item =['000000000000'=>'一级菜单'];
        foreach ($data as $v){
            $item[$v['sysmenuId']]=$v['title'];
            $s = str_split($v['sysmenuId'],3);
            if($s[3]>0){
                $item[$v['sysmenuId']]='------'.$v['title'];
            }elseif ($s[2]>0){
                $item[$v['sysmenuId']]='----'.$v['title'];
            }elseif($s[1]>0){
                $item[$v['sysmenuId']]='--'.$v['title'];
            }else{
                $item[$v['sysmenuId']]=$v['title'];
            }
        }
        return $item;
    }

    /**
     * 根据上线ID生成最新的ID
     * @param $fatherId
     */
    public function getMenuId($fatherId){
        $s = str_split($fatherId,3);
        $count = self::find()->where(['fatherId'=>$fatherId])->count();
        //判断是第几级
        if($s[0]==0){
            $s[0] = str_pad($count+1,3,"0",STR_PAD_LEFT);
        }elseif($s[1]==0){
            $s[1] = str_pad($count+1,3,"0",STR_PAD_LEFT);
        }elseif($s[2]==0){
            $s[2] = str_pad($count+1,3,"0",STR_PAD_LEFT);
        }elseif($s[3]==0){
            $s[3] = str_pad($count+1,3,"0",STR_PAD_LEFT);
        }
        return implode($s);

    }
}
