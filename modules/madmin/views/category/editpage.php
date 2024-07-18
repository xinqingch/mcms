<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\AppAsset;
use \kucha\ueditor\UEditor;
AppAsset::register($this);
//AppAsset::addCss($this,'@web/css/style.css?v=1');
//AppAsset::addScript($this,'@web/js/upload_img.js');

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
                    <div class="card card-primary card-tabs">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                <li class="pt-2 px-3"><h3 class="card-title">编辑内容</h3></li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">基本信息</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">SEO信息</a>
                                </li>
                            </ul>
                        </div>
                        <?php $form = ActiveForm::begin([
                            'id' => 'page-form',
                            'layout' => 'horizontal',
                        ]); ?>
                        <div class="card-body">

                            <?= Html::hiddenInput('Cmspage[navId]',$model['navId']);?>
                            <div class="tab-content" id="custom-tabs-two-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                                    <div class="form-group">
                                        <label for="title">标题</label>
                                        <input type="text" name="Cmspage[title]" class="form-control" id="title" value="<?=$model['title']?>" placeholder="请输入标题">
                                    </div>
                                    <div class="form-group">
                                        <label for="title_ne">标题(En)</label>
                                        <input type="text" name="Cmspage[title_en]" class="form-control" id="title_en" value="<?=$model['title_en']?>" placeholder="请输入菜单英文标题">
                                    </div>
                                    <div class="form-group">
                                        <label for="content">详细内容</label>
                                    <?php
                                    echo UEditor::widget([
                                        'id'=>'Cmspage[content]',
                                        'name'=>'content',
                                        'value'=>$model['content'],
                                        'clientOptions' => [
                                            //编辑区域大小
                                            'initialFrameHeight' => '400',
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
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                                    <div class="form-group">
                                        <label for="seotitle">SEO标题</label>
                                        <input type="text" name="Cmspage[seotitle]" class="form-control" id="seotitle" value="<?=$model['seotitle']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="seotitle">SEO标题(En)</label>
                                        <input type="text" name="Cmspage[seotitle]" class="form-control" id="seotitle" value="<?=$model['seotitle']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="seokey">SEO关键词</label>
                                        <input type="text" name="Cmspage[seokey]" class="form-control" id="seokey" value="<?=$model['seokey']?>" >
                                    </div>
                                    <div class="form-group">
                                        <label for="seokey_en">SEO关键词(En)</label>
                                        <input type="text" name="Cmspage[seokey_en]" class="form-control" id="seokey_en" value="<?=$model['seokey_en']?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="site_url">SEO描述</label>
                                        <input type="text" name="Cmspage[seodesc]" class="form-control" id="seodesc"  value="<?=$model['seodesc']?>" >
                                    </div>
                                    <div class="form-group">
                                        <label for="seodesc">SEO描述(En)</label>
                                        <input type="text" name="Cmspage[seodesc_en]" class="form-control" id="seodesc_en"  value="<?=$model['seodesc_en']?>" placeholder="">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                                    Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-two-settings" role="tabpanel" aria-labelledby="custom-tabs-two-settings-tab">
                                    Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">保存</button>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <!-- /.card -->
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

<?php if(isset($error)){?>
    <script>
        toastr.error('<?php echo $error?>');
    </script>
<?php }?>
