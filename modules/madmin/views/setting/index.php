<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\AppAsset;
use \kucha\ueditor\UEditor;
AppAsset::register($this);
//AppAsset::addCss($this,'@web/css/style.css?v=1');
AppAsset::addScript($this,'@web/js/upload_img.js');

?>
<link rel="stylesheet" href="/css/style.css">
<div class="content-wrapper">
    <?php $this->beginContent('@madmin/views/layouts/_right_nav.php');$this->endContent(); ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">基本配置 <small>base setting</small></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <?php $form = ActiveForm::begin([
                        'id' => 'setting-form',
                        'layout' => 'horizontal',
                    ]); ?>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="SiteName">网站名称</label>
                                <input type="text" name="setting[site_name]" class="form-control" id="SiteName" value="<?=$model['site_name']?>" placeholder="请输入网站名称">
                            </div>
                            <div class="form-group">
                                <label for="index_seotitle">SEO标题</label>
                                <input type="text" name="setting[index_seotitle]" class="form-control" id="index_seotitle"  value="<?=$model['index_seotitle']?>" placeholder="请输入SEO标题">
                            </div>
                            <div class="form-group">
                                <label for="index_keyword">SEO关键词</label>
                                <input type="text" name="setting[index_keyword]" class="form-control" id="index_keyword"  value="<?=$model['index_keyword']?>" placeholder="请输入SEO关键词">
                            </div>
                            <div class="form-group">
                                <label for="index_desc">SEO介绍</label>
                                <input type="text" name="setting[index_desc]" class="form-control" id="index_desc"  value="<?=$model['index_desc']?>" placeholder="请输入SEO介绍">
                            </div>
                            <div class="form-group">
                                <label for="site_url">网站地址</label>
                                <input type="text" name="setting[site_url]" class="form-control" id="site_url"  value="<?=$model['site_url']?>" placeholder="请输入网站域名地址:http://">
                            </div>
                            <div class="form-group">
                                <label for="site_logo">网站LOGO</label>
                                <div class="custom-file">
                                    <div class="row">
                                    <div class="col-md-10">
                                        <?php echo Html::Input('text','setting[site_logo]', $model['site_logo'],['id'=>'proimage1','class'=>'form-control']); ?>
                                    </div>
                                    <div class="col-md-2 a-upload">
                                        <input type="file" class="custom-file-input" name="upFile" id='uploadimg1' onclick="uploadimg(1)">
                                        <i class="fas fa-upload"></i> 上传图片</div>
                                    </div>
                                    <div id="total-progress" class=" progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                        <div class="upprogress1 progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="hottel">热线电话</label>
                                <input type="text" name="setting[hottel]" class="form-control" id="hottel"  value="<?=$model['hottel']?>" placeholder="请输入热线电话">
                            </div>
                            <div class="form-group">
                                <label for="weixin">微信二维码</label>
                                <div class="row">
                                    <div class="col-md-10">
                                        <?php echo Html::Input('text','setting[weixin]', $model['weixin'],['id'=>'proimage2','class'=>'form-control']); ?>
                                    </div>
                                    <div class="col-md-2 a-upload">
                                        <input type="file" class="custom-file-input" name="upFile" id='uploadimg2' onclick="uploadimg(2)">
                                        <i class="fas fa-upload"></i> 上传图片</div>
                                </div>
                                <div id="total-progress" class=" progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                    <div class="upprogress2 progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="site_address">公司地址</label>
                                <input type="text" name="setting[site_address]" class="form-control" id="site_address"  value="<?=$model['site_address']?>" placeholder="请输入公司地址">
                            </div>
                            <div class="form-group">
                                <label for="siteicp">ICP备案号</label>
                                <input type="text" name="setting[siteicp]" class="form-control" id="siteicp"  value="<?=$model['siteicp']?>" placeholder="请输入公司地址">
                            </div>
                            <div class="form-group">
                                <label for="h10_token">H10TOKEN</label>
                                <input type="text" name="setting[h10_token]" class="form-control" id="h10_token"  value="<?=$model['h10_token']?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="h10_cookie">H10Cookie</label>
                                <textarea type="text" name="setting[h10_cookie]" class="form-control" id="h10_cookie"  placeholder="请输入H10cookie"><?=$model['h10_cookie']?></textarea>
                            </div>
                            <?php
                            echo UEditor::widget([
                                'id'=>'setting[site_address]',
                                'name'=>'site_address',
                                'value'=>$model['site_address'],
                                'clientOptions' => [
                                    //编辑区域大小
                                    'initialFrameHeight' => '200',
                                    //设置语言
                                    'lang' =>'zh-cn', //中文为 zh-cn
                                    //定制菜单
                                    'toolbars'=>[
                                                    [
                                                        'source', //源代码
                                                            //'anchor', //锚点
                                                        'undo', //撤销
                                                        'redo', //重做
                                                        'insertcode', //代码语言
                                                        'fontfamily', //字体
                                                        'fontsize', //字号
                                                        'paragraph', //段落格式
                                                        'customstyle', //自定义标题
                                                        'autotypeset', //自动排版
                                                        'bold', //加粗
                                                        'indent', //首行缩进
                                                        //'snapscreen', //截图
                                                        'italic', //斜体
                                                        'underline', //下划线
                                                        'strikethrough', //删除线
                                                        'justifyleft', //居左对齐
                                                        'justifyright', //居右对齐
                                                        'justifycenter', //居中对齐
                                                        'justifyjustify', //两端对齐
                                                        'forecolor', //字体颜色
                                                        'backcolor', //背景色
                                                        'insertorderedlist', //有序列表
                                                        'insertunorderedlist', //无序列表
                                                        'subscript', //下标
                                                        'fontborder', //字符边框
                                                        'superscript', //上标
                                                        'formatmatch', //格式刷

                                                        'blockquote', //引用
                                                        'pasteplain', //纯文本粘贴模式
                                                        'selectall', //全选
                                                        //'print', //打印
                                                        //'preview', //预览
                                                        'horizontal', //分隔线
                                                        'removeformat', //清除格式
                                                        //'time', //时间
                                                        //'date', //日期
                                                        'unlink', //取消链接
                                                        'inserttable', //插入表格
                                                        'insertrow', //前插入行
                                                        'insertcol', //前插入列
                                                        'mergeright', //右合并单元格
                                                        'mergedown', //下合并单元格
                                                        'deleterow', //删除行
                                                        'deletecol', //删除列
                                                        'splittorows', //拆分成行
                                                        'splittocols', //拆分成列
                                                        'splittocells', //完全拆分单元格
                                                        'deletecaption', //删除表格标题
                                                        'inserttitle', //插入标题
                                                        'mergecells', //合并多个单元格
                                                        'deletetable', //删除表格
                                                        'cleardoc', //清空文档
                                                        'insertparagraphbeforetable', //"表格前插入行"
                                                        'edittable', //表格属性
                                                        'edittd', //单元格属性
                                                        'link', //超链接
                                                        //'emotion', //表情
                                                        'spechars', //特殊字符
                                                        'searchreplace', //查询替换
                                                        'map', //Baidu地图
                                                        //'gmap', //Google地图
                                                        //'insertvideo', //视频
                                                        //'help', //帮助

                                                        'fullscreen', //全屏
                                                        //'directionalityltr', //从左向右输入
                                                        //'directionalityrtl', //从右向左输入
                                                        'rowspacingtop', //段前距
                                                        'rowspacingbottom', //段后距
                                                        'pagebreak', //分页
                                                        //'insertframe', //插入Iframe
                                                        'imagenone', //默认
                                                        'imageleft', //左浮动
                                                        'imageright', //右浮动
                                                        'attachment', //附件
                                                        'imagecenter', //居中
                                                        'wordimage', //图片转存
                                                        'lineheight', //行间距
                                                        'edittip ', //编辑提示

                                                        //'webapp', //百度应用
                                                        'touppercase', //字母大写
                                                        'tolowercase', //字母小写
                                                        //'background', //背景
                                                        'template', //模板
                                                        //'scrawl', //涂鸦
                                                        //'music', //音乐

                                                        'drafts', // 从草稿箱加载
                                                        'simpleupload', //单图上传
                                                        'insertimage', //多图上传
                                                        //'charts', // 图表
                                                    ]
                                                ],
                                ],
                                ]);
                            ?>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">保存</button>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">

            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
</div>
