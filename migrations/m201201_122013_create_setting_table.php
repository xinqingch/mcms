<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%setting}}`.
 */
class m201201_122013_create_setting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions ='';
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB ';
        }
        $this->createTable('{{%setting}}', [
            'settingId' => $this->primaryKey(),
            'title' => $this->string(100)->notNull()->comment('标题'),
            'variable' => $this->string(100)->notNull()->comment('配置名'),
            'valued' => $this->text()->comment('配置值'),
        ], $tableOptions.'COMMENT="系统配置信息表"');
        $this->createIndex('variable','{{%setting}}','variable',true);
        $settingcol = ['title','variable','valued'];
        $settingdata =[
            ['网站名称','site_name','礷天企业管理系统'],
            ['网站地址','site_url','http://www.cms.com'],
            ['网站LOGO','site_logo','/images/logo.png'],
            ['热线电话','hottel','0755-8888888'],
            ['SEO标题','index_seotitle','礷天企业管理系统'],
            ['SEO关键词','index_keyword','cms,cms系统，企业网站,建站系统,网站建设'],
            ['SEO描述','index_desc','礷天企业管理系统是由morven打造的一套专门为企业建站用的系统，使用的是Yii为框架，功能有单页面，新闻资讯，产品，相册,留言,客服系统,碎片管理,广告管理,推荐位管理.'],
            ['企业地址','site_address','广东深圳'],
            ['备案号','siteicp','ICP备案888888'],
            ['统计代码','copying','baidu'],
            ['微信','weixin','/images/weixin.png'],
            ['上传文件大小','filesize','2000000'],
        ];
        $this->batchInsert('{{%setting}}',$settingcol,$settingdata);



        $this->createTable('{{%sysmenu}}', [
            'sysmenuId' => $this->string(12)->primaryKey(),
            'fatherId' => $this->string(12)->notNull()->defaultValue('000000000000')->comment('父节点'),
            'hidden' => $this->tinyInteger(1)->defaultValue(0)->comment('是否隐藏'),
            'type' => 'enum(\'navigate\',\'group\',\'menu\',\'action\') NOT NULL COMMENT \'菜单类型\'',
            'title' => $this->string(30)->notNull()->comment('菜单名'),
            'url' => $this->string(100)->notNull()->comment('菜单地址'),
            'route' => $this->string(100)->notNull()->comment('菜单路由'),
            'listorder' => $this->smallInteger(3)->notNull()->defaultValue(0)->comment('排序'),
            'fontico' => $this->string(30)->comment('图标'),
        ], $tableOptions.'COMMENT="系统菜单表"');
        $sysmenucol = ['sysmenuId','fatherId','type','title','url','route','listorder','fontico'];
        $sysmenudata =[
            ['001000000000','000000000000','navigate','系统配置','','','1','fontico'],
            ['002000000000','000000000000','navigate','栏目管理','','','2','fontico'],
            ['003000000000','000000000000','navigate','客服配置','','','3','fontico'],
            ['004000000000','000000000000','navigate','广告配置','','','4','fontico'],
            ['001001000000','001000000000','group','网站配置','','','1','fontico'],
            ['001001001000','001001000000','menu','基本配置','','/madmin/setting/index','1','fontico'],
            ['001001002000','001001000000','menu','上传配置','','/madmin/setting/upfile','2','fontico'],
            ['001002000000','001000000000','group','后台菜单','','/madmin/menu/index','2','fontico'],
            ['001001003000','001001000000','group','邮件配置','','/madmin/setting/mail','3','fontico'],
            ['001004000000','001000000000','group','友情链接','','/madmin/friendlink/index','4','fontico'],
            ['001005000000','001000000000','group','管理员管理','','','5','fontico'],
            ['001006000000','001000000000','group','备份管理','','/madmin/webback/index','6','fontico'],
        ];
        $this->batchInsert('{{%sysmenu}}',$sysmenucol,$sysmenudata);

        $this->createTable('{{%adminer}}', [
            'adminerId' => $this->primaryKey(),
            'roleId' => $this->integer(10)->notNull()->comment('管理员角色'),
            'username' => $this->string(30)->notNull()->comment('管理员账号'),
            'password_hash' => $this->string(255)->notNull()->comment('管理员密码'),
            'password_reset_token' => $this->string(255)->notNull()->comment('管理员重置token'),
            'login_ip' => $this->integer(10)->notNull()->comment('登录IP'),
            'login_time' => $this->integer(10)->notNull()->comment('登录时间'),
            'auth_key' => $this->string(32)->notNull()->comment('自动登录KEY'),
            'isadmin' => $this->tinyInteger(1)->defaultValue(0)->comment('是否超管：0否1是'),
            'state' => $this->tinyInteger(1)->defaultValue(0)->comment('状态：0无效1有效'),
            'inputtime'=>$this->integer(10)->comment('创建时间'),
        ], $tableOptions.'COMMENT="后台管理员表"');
        $adminercol = ['roleId','username','password_hash','password_reset_token','login_ip','login_time','auth_key','isadmin','state','inputtime'];
        $adminerdata =[
            [ '1', 'morven', '$2y$13$93M0Hl/d6tIU6hpnoqVzB.ttsDe.k1qkNQje0CPep/JJyGrJCXWzy', 'f4muX8KvHOXAOz_we26WKVt7p10-_yMO_1619331114', '127', '1619331114', 'fbjwf8AIV4iAUR0rO35ZmC6qlheyGig3', '1', '10', '1619331114'],

        ];
        $this->batchInsert('{{%adminer}}',$adminercol,$adminerdata);

        $this->createTable('{{%role}}', [
            'roleId' => $this->primaryKey(),
            'rolename' => $this->string(30)->notNull()->comment('角色名称'),
            'description' => $this->string(100)->notNull()->comment('角色描述'),
            'state' => $this->tinyInteger(1)->defaultValue(0)->comment('状态：0无效1有效'),
        ], $tableOptions.'COMMENT="管理员角色表"');
        $rolecol = ['rolename','description','state'];
        $roledata =[
            ['超级管理员','超级管理员','1'],

        ];
        $this->batchInsert('{{%role}}',$rolecol,$roledata);

        $this->createTable('{{%permission}}', [
            'permissionId' => $this->primaryKey(),
            'roleId' => $this->integer(10)->notNull()->comment('角色ID'),
            'sysmenuId' => $this->bigInteger(12)->notNull()->comment('菜单ID'),
        ], $tableOptions.'COMMENT="角色权限表"');


        $this->createTable('{{%attachment}}', [
            'attachmentId' => $this->primaryKey(),
            'memberId' => $this->integer(11)->defaultValue(0)->comment('会员'),
            'file_name' => $this->string(100)->notNull()->comment('文件名'),
            'url' => $this->string(250)->notNull()->comment('文件地址'),
            'title' => $this->string(30)->notNull()->comment('标题'),
            'file_type' => $this->string(100)->notNull()->comment('文件类型'),
            'file_size' => $this->integer(10)->notNull()->defaultValue(0)->comment('文件大小'),
            'thumb' => $this->string(250)->comment('文件缩略图地址'),
            'is_image' => $this->tinyInteger(1)->defaultValue(1)->comment('是否图片：1否2是'),
            'ip' => $this->bigInteger(15)->comment('上传IP'),
            'state' => $this->tinyInteger(1)->defaultValue(1)->comment('状态：1有效2无效'),
            'md5key' => $this->string(32)->comment('文件md5'),
            'inputtime'=>$this->integer(10)->comment('创建时间'),
        ], $tableOptions.'COMMENT="附件表"');

        $this->createTable('{{%nav}}', [
            'navId' => $this->primaryKey(),
            'topid' => $this->integer(11)->defaultValue(0)->comment('顶级'),
            'parentid' => $this->integer(11)->defaultValue(0)->comment('父ID'),
            'childid' => $this->tinyInteger(1)->defaultValue(1)->comment('是否有子ID:1无2有'),
            'arrchildid' => $this->string(100)->notNull()->comment('子ID'),
            'pagetype' => $this->tinyInteger(1)->notNull()->comment('页面类型：0单页 1资讯列表 2图片列表 3招聘列表 4产品 5链接'),
            'title' => $this->string(100)->notNull()->comment('菜单名'),
            'title_en' => $this->string(100)->notNull()->comment('菜单名_EN'),
            'url' => $this->string(250)->comment('菜单地址'),
            'aliasname' => $this->string(100)->comment('栏目别名'),
            'level' => $this->tinyInteger(1)->defaultValue(1)->comment('等级'),
            'seotitle' => $this->string(255)->comment('SEO标题'),
            'seotitle_en' => $this->string(255)->comment('SEO标题_EN'),
            'seokey' => $this->string(255)->comment('SEO关键字'),
            'seokey_en' => $this->string(255)->comment('SEO关键字_EN'),
            'seodesc' => $this->string(255)->comment('SEO简介'),
            'seodesc_en' => $this->string(255)->comment('SEO简介_EN'),
            'state' => $this->tinyInteger(1)->defaultValue(1)->comment('是否显示:1是2否'),
            'listorder' => $this->smallInteger(3)->notNull()->defaultValue(0)->comment('排序'),
            'inputtime'=>$this->integer(10)->comment('创建时间'),
        ], $tableOptions.'COMMENT="前端菜单表"');

        $this->createTable('{{%cms_page}}', [
            'pageId' => $this->primaryKey(),
            'navId' => $this->integer(11)->defaultValue(0)->comment('栏目ID'),
            'title' => $this->string(100)->notNull()->comment('标题'),
            'title_en' => $this->string(100)->notNull()->comment('标题_EN'),
            'seotitle' => $this->string(255)->comment('SEO标题'),
            'seotitle_en' => $this->string(255)->comment('SEO标题_EN'),
            'seokey' => $this->string(255)->comment('SEO关键字'),
            'seokey_en' => $this->string(255)->comment('SEO关键字_EN'),
            'seodesc' => $this->string(255)->comment('SEO简介'),
            'seodesc_en' => $this->string(255)->comment('SEO简介_EN'),
            'content' => $this->text()->comment('内容'),
            'content_en' => $this->text()->comment('内容_EN'),
            'state' => $this->tinyInteger(1)->defaultValue(1)->comment('状态：1发布，2删除'),
            'listorder' => $this->smallInteger(3)->notNull()->defaultValue(0)->comment('排序'),
            'inputtime'=>$this->integer(10)->comment('创建时间'),
        ], $tableOptions.'COMMENT="CMS单页表"');
        $this->createIndex('navId','{{%cms_page}}','navId');

        $this->createTable('{{%cms_news}}', [
            'newsId' => $this->primaryKey(),
            'navId' => $this->integer(11)->defaultValue(0)->comment('栏目ID'),
            'title' => $this->string(100)->notNull()->comment('标题'),
            'shortTitle' => $this->string(50)->comment('短标题'),
            'title_en' => $this->string(100)->notNull()->comment('标题_EN'),
            'seotitle' => $this->string(255)->comment('SEO标题'),
            'seotitle_en' => $this->string(255)->comment('SEO标题_EN'),
            'seokey' => $this->string(255)->comment('SEO关键字'),
            'seokey_en' => $this->string(255)->comment('SEO关键字_EN'),
            'seodesc' => $this->string(255)->comment('SEO简介'),
            'seodesc_en' => $this->string(255)->comment('SEO简介_EN'),
            'source' => $this->string(50)->notNull()->comment('来源'),
            'thumb' => $this->string(255)->comment('缩略图地址'),
            'hits' => $this->integer(11)->defaultValue(0)->comment('浏览数'),
            'key_ids' => $this->string(255)->comment('关键词ID'),
            'jumplink' => $this->string(255)->comment('跳转链接'),
            'content' => $this->text()->comment('内容'),
            'content_en' => $this->text()->comment('内容_EN'),
            'state' => $this->tinyInteger(1)->defaultValue(1)->comment('状态：1发布，2删除'),
            'listorder' => $this->smallInteger(3)->notNull()->defaultValue(0)->comment('排序'),
            'inputtime'=>$this->integer(10)->comment('创建时间'),
        ], $tableOptions.'COMMENT="CMS资讯表"');

        $this->createTable('{{%cms_photo}}', [
            'photoId' => $this->primaryKey(),
            'navId' => $this->integer(11)->defaultValue(0)->comment('栏目ID'),
            'title' => $this->string(100)->notNull()->comment('标题'),
            'shortTitle' => $this->string(50)->comment('短标题'),
            'title_en' => $this->string(100)->notNull()->comment('标题_EN'),
            'seotitle' => $this->string(255)->comment('SEO标题'),
            'seotitle_en' => $this->string(255)->comment('SEO标题_EN'),
            'seokey' => $this->string(255)->comment('SEO关键字'),
            'seokey_en' => $this->string(255)->comment('SEO关键字_EN'),
            'seodesc' => $this->string(255)->comment('SEO简介'),
            'seodesc_en' => $this->string(255)->comment('SEO简介_EN'),
            'thumb' => $this->string(255)->comment('缩略图地址'),
            'photo' => $this->text()->comment('序列化图片库'),
            'content' => $this->text()->comment('内容'),
            'content_en' => $this->text()->comment('内容_EN'),
            'state' => $this->tinyInteger(1)->defaultValue(1)->comment('状态：1发布，2删除'),
            'listorder' => $this->smallInteger(3)->notNull()->defaultValue(0)->comment('排序'),
            'inputtime'=>$this->integer(10)->comment('创建时间'),
        ], $tableOptions.'COMMENT="CMS相册表"');

        $this->createTable('{{%block}}', [
            'blockId' => $this->primaryKey(),
            'navId' => $this->integer(11)->defaultValue(0)->comment('栏目ID'),
            'title' => $this->string(100)->notNull()->comment('标题'),
            'pos' => $this->string(50)->comment('碎片标识'),
            'type' => $this->tinyInteger(1)->comment('碎片类型1HTML2模板'),
            'photo' => $this->text()->comment('序列化图片库'),
            'content' => $this->text()->comment('碎片内容'),
            'template' => $this->text()->comment('碎片模板'),
            'state' => $this->tinyInteger(1)->defaultValue(1)->comment('状态：1发布，2删除'),
            'listorder' => $this->smallInteger(3)->notNull()->defaultValue(0)->comment('排序'),
            'inputtime'=>$this->integer(10)->comment('创建时间'),
        ], $tableOptions.'COMMENT="碎片表"');

        $this->createTable('{{%adzone}}', [
            'adzoneId' => $this->primaryKey(),
            'navId' => $this->integer(11)->defaultValue(0)->comment('栏目ID'),
            'title' => $this->string(100)->notNull()->comment('标题'),
            'pos' => $this->string(50)->comment('广告标识'),
            'width' => $this->smallInteger(4)->defaultValue(0)->comment('广告宽度'),
            'height' => $this->smallInteger(4)->defaultValue(0)->comment('广告高度'),
            'max' => $this->smallInteger(4)->defaultValue(0)->comment('广告最大数量'),
            'content' => $this->string(255)->comment('广告简介'),
            'inputtime'=>$this->integer(10)->comment('创建时间'),
        ], $tableOptions.'COMMENT="广告位表"');

        $this->createTable('{{%adse}}', [
            'adseId' => $this->primaryKey(),
            'navId' => $this->integer(11)->defaultValue(0)->comment('栏目ID'),
            'adzoneId' => $this->integer(11)->comment('广告位ID'),
            'start_time' => $this->integer(11)->defaultValue(0)->comment('开始时间'),
            'end_time' => $this->integer(11)->defaultValue(0)->comment('结束时间，不限为0'),
            'title' => $this->string(100)->notNull()->comment('标题'),
            'content' => $this->string(255)->comment('广告简介'),
            'url' => $this->string(255)->comment('广告图片地址'),
            'listorder' => $this->smallInteger(3)->notNull()->defaultValue(0)->comment('排序'),
            'inputtime'=>$this->integer(10)->comment('创建时间'),
        ], $tableOptions.'COMMENT="广告信息表"');

        $this->createTable('{{%positions}}', [
            'positionsId' => $this->primaryKey(),
            'navId' => $this->integer(11)->defaultValue(0)->comment('栏目ID'),
            'title' => $this->string(100)->notNull()->comment('标题'),
            'type' => $this->tinyInteger(1)->defaultValue(1)->comment('类型：1产品 2资讯 '),
            'max' => $this->smallInteger(4)->defaultValue(0)->comment('最大数量'),
        ], $tableOptions.'COMMENT="推荐位表"');

        $this->createTable('{{%pos_log}}', [
            'poslogId' => $this->primaryKey(),
            'navId' => $this->integer(11)->defaultValue(0)->comment('栏目ID'),
            'positionsId' => $this->integer(11)->comment('推荐位ID'),
            'start_time' => $this->integer(11)->defaultValue(0)->comment('开始时间'),
            'end_time' => $this->integer(11)->defaultValue(0)->comment('结束时间，不限为0'),
            'content_id'=> $this->integer(11)->defaultValue(0)->comment('内容ID（关联：产品 or 资讯)'),
            'title' => $this->string(100)->notNull()->comment('标题'),
            'title_en' => $this->string(100)->notNull()->comment('标题_en'),
            'content' => $this->string(255)->comment('简介'),
            'pic' => $this->string(255)->comment('图片地址'),
            'listorder' => $this->smallInteger(3)->notNull()->defaultValue(0)->comment('排序'),
            'inputtime'=>$this->integer(10)->comment('创建时间'),
        ], $tableOptions.'COMMENT="推荐信息表"');

        $this->createTable('{{%attribute}}', [
            'attributeId' => $this->primaryKey(),
            'navId' => $this->integer(11)->defaultValue(0)->comment('栏目ID'),
            'type' => $this->tinyInteger(1)->defaultValue(1)->comment('类型:1属性2规格'),
            'text_type' => "enum('checkbox','select','radio','textarea','input') DEFAULT 'radio' COMMENT '控件类型'",
            'title' => $this->string(100)->notNull()->comment('标题'),
            'title_en' => $this->string(100)->notNull()->comment('标题_en'),
            'value' => $this->string(255)->comment('值:用逗号分隔'),
            'issearch' => $this->tinyInteger(1)->defaultValue(1)->comment('是否支持搜索:1否2是'),
            'isphoto' => $this->tinyInteger(1)->defaultValue(1)->comment('是否支持图片:1否2是'),
            'listorder' => $this->smallInteger(3)->notNull()->defaultValue(0)->comment('排序'),
        ], $tableOptions.'COMMENT="公共属性规格表"');

        $this->createTable('{{%services}}', [
            'servicesId' => $this->primaryKey(),
            'type' => $this->tinyInteger(1)->defaultValue(1)->comment('客服类型:1:qq,2:MSN 3旺旺'),
            'text_type' => "enum('checkbox','select','radio','textarea','input') DEFAULT 'radio' COMMENT '控件类型'",
             'account' => $this->string(100)->notNull()->comment('账号'),
            'title' => $this->string(100)->notNull()->comment('客服名称'),
            'title_en' => $this->string(100)->notNull()->comment('客服名称_en'),
            'tel' => $this->string(15)->comment('客服电话'),
            'isdefault' => $this->tinyInteger(1)->defaultValue(1)->comment('是否默认:1否2是'),
            'listorder' => $this->smallInteger(3)->notNull()->defaultValue(0)->comment('排序'),
        ], $tableOptions.'COMMENT="客服表"');

        $this->createTable('{{%product}}', [
            'productId' => $this->primaryKey(),
            'type' => $this->tinyInteger(1)->defaultValue(1)->comment('销售模式1:零售,2:批发,3积分'),
            'navId' => $this->integer(11)->comment('栏目ID'),
            'areaId' => $this->integer(11)->defaultValue(0)->comment('地域'),
            'title' => $this->string(100)->notNull()->comment('标题'),
            'title_en' => $this->string(100)->notNull()->comment('标题_en'),
            'seotitle' => $this->string(255)->comment('SEO标题'),
            'seotitle_en' => $this->string(255)->comment('SEO标题_EN'),
            'seokey' => $this->string(255)->comment('SEO关键字'),
            'seokey_en' => $this->string(255)->comment('SEO关键字_EN'),
            'seodesc' => $this->string(255)->comment('SEO简介'),
            'seodesc_en' => $this->string(255)->comment('SEO简介_EN'),
            'product_no' => $this->string(255)->comment('产品编号'),
            'price' => $this->float(2)->defaultValue(0.00)->comment('产品实售价'),
            'saleprice' => $this->float(2)->defaultValue(0.00)->comment('产品销售价'),
            'costprice' => $this->float(2)->defaultValue(0.00)->comment('产品成本价'),
            'min_num' => $this->integer(11)->defaultValue(1)->comment('最小销售量'),
            'inventory' => $this->integer(11)->defaultValue(0)->comment('产品库存'),
            'pic' => $this->string(255)->comment('产品主图片地址'),
            'content' => $this->string(255)->comment('简介'),
            'state' => $this->tinyInteger(1)->defaultValue(2)->comment('是否上架:1否2是3逻辑删除'),
            'listorder' => $this->smallInteger(3)->notNull()->defaultValue(0)->comment('排序'),
            'inputtime'=>$this->integer(10)->comment('创建时间'),
            'updatetime'=>$this->integer(10)->comment('更新时间'),
        ], $tableOptions.'COMMENT="产品信息表"');

        $this->createTable('{{%pro_images}}', [
            'proimgId' => $this->primaryKey(),
            'productId' => $this->integer(11)->comment('产品ID'),
            'url' => $this->string(255)->comment('图片地址'),
            'attachmentId' => $this->integer(11)->comment('附件ID'),
            'listorder' => $this->smallInteger(3)->notNull()->defaultValue(0)->comment('排序'),
        ], $tableOptions.'COMMENT="产品图片表"');

        $this->createTable('{{%pro_attribute}}', [
            'proattId' => $this->primaryKey(),
            'productId' => $this->integer(11)->comment('产品ID'),
            'type' => $this->tinyInteger(1)->defaultValue(1)->comment('类型:1属性2规格3规格组合'),
            'attributeId' => $this->integer(11)->comment('规格属性ID'),
            'title' => $this->string(100)->comment('规格名称'),
            'title_en' => $this->string(100)->comment('规格名称_EN'),
            'stitle' => $this->string(100)->comment('别名(限定规格)'),
            'val' => $this->text()->comment('序列化的规则值,key规则ID,value此货品所具有的规则值'),
            'pro_no' => $this->string(50)->comment('货号'),
            'pic' => $this->string(255)->comment('规格图片地址'),
            'stock' => $this->integer(11)->defaultValue(0)->comment('库存'),
            'weight' => $this->integer(11)->defaultValue(0)->comment('重量'),
            'isphoto' => $this->tinyInteger(1)->defaultValue(1)->comment('是否图片显示:1否2是'),
            'md5' => $this->string(255)->comment('规格MD5'),
        ], $tableOptions.'COMMENT="产品属性规格库存表"');

        $this->createTable('{{%pro_spe}}', [
            'prospeId' => $this->primaryKey(),
            'productId' => $this->integer(11)->comment('产品ID'),
            'proattId' => $this->integer(11)->comment('规格ID'),
            'price' => $this->float(2)->defaultValue(0.00)->comment('产品价格'),
            'min' => $this->smallInteger(4)->defaultValue(0)->comment('最小数量'),
            'max' => $this->integer(10)->defaultValue(0)->comment('最大数量'),
        ], $tableOptions.'COMMENT="产品规格价格表"');

        $this->createTable('{{%tag}}', [
            'tagId' => $this->primaryKey(),
            'navId' => $this->integer(11)->comment('栏目ID'),
            'title' => $this->string(100)->comment('关键词名'),
            'nums' => $this->smallInteger(4)->defaultValue(0)->comment('搜索次数'),
            'state' => $this->tinyInteger(1)->defaultValue(1)->comment('是否关闭:1否2是'),
            'listorder' => $this->smallInteger(3)->notNull()->defaultValue(0)->comment('排序'),
            'inputtime'=>$this->integer(10)->comment('创建时间'),
            'updatetime'=>$this->integer(10)->comment('更新时间'),
        ], $tableOptions.'COMMENT="关键词表"');

        $this->createTable('{{%search_log}}', [
            'searchlogId' => $this->primaryKey(),
            'type' => 'enum(\'product\',\'company\',\'buy\',\'news\') NOT NULL COMMENT \'搜索类型\'',
            'keyword' => $this->string(100)->comment('搜索关键词'),
            'nums' => $this->smallInteger(4)->defaultValue(0)->comment('搜索次数'),
            'ip' => $this->integer(10)->defaultValue(0)->comment('搜索ip'),
            'state' => $this->tinyInteger(1)->defaultValue(1)->comment('是否关闭:1否2是'),
            'listorder' => $this->smallInteger(3)->notNull()->defaultValue(0)->comment('排序'),
            'inputtime'=>$this->integer(10)->comment('创建时间'),
            'updatetime'=>$this->integer(10)->comment('更新时间'),
        ], $tableOptions.'COMMENT="搜索记录表"');


        $this->createTable('{{%message_log}}', [
            'messageId' => $this->primaryKey(),
            'memberId' => $this->integer(11)->comment('会员ID'),
            'type' =>  $this->tinyInteger(1)->defaultValue(1)->comment('类型:1系统2用户3邮件4短信'),
            'account' => $this->string(50)->comment('发送账号'),
            'title' => $this->string(50)->comment('标题'),
            'content' => $this->string(255)->comment('内容'),
            'state' => $this->tinyInteger(1)->defaultValue(1)->comment('状态:0::未查看1:已查看2:删除'),
            'inputtime'=>$this->integer(10)->comment('创建时间'),
        ], $tableOptions.'COMMENT="消息记录表"');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%setting}}');
        $this->dropTable('{{%sysmenu}}');
        $this->dropTable('{{%adminer}}');
        $this->dropTable('{{%role}}');
        $this->dropTable('{{%permission}}');
        $this->dropTable('{{%attachment}}');
        $this->dropTable('{{%nav}}');
        $this->dropTable('{{%cms_page}}');
        $this->dropTable('{{%cms_news}}');
        $this->dropTable('{{%cms_photo}}');
        $this->dropTable('{{%block}}');
        $this->dropTable('{{%adzone}}');
        $this->dropTable('{{%adse}}');
        $this->dropTable('{{%positions}}');
        $this->dropTable('{{%pos_log}}');
        $this->dropTable('{{%attribute}}');
        $this->dropTable('{{%services}}');
        $this->dropTable('{{%product}}');
        $this->dropTable('{{%pro_images}}');
        $this->dropTable('{{%pro_attribute}}');
        $this->dropTable('{{%pro_spe}}');
        $this->dropTable('{{%tag}}');
        $this->dropTable('{{%search_log}}');
        $this->dropTable('{{%message_log}}');
    }
}
