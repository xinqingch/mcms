<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\AppAsset;
use \kucha\ueditor\UEditor;
AppAsset::register($this);
//AppAsset::addCss($this,'@web/css/style.css?v=1');
AppAsset::addScript($this,'@web/js/upload_img.js');
?>
<!-- form start -->
<?php $form = ActiveForm::begin([
    'id' => 'news-form',
    'layout' => 'horizontal',
]); ?>
<?= Html::hiddenInput('Cmsnews[navId]',$model['navId']);?>
<div class="card-body">
    <div class="tab-content" id="custom-tabs-two-tabContent">
        <div class="tab-pane fade active show" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
    <? echo $form->field($model, 'title',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>1,'maxlength' => 100,'class'=>'form-control','placeholder'=>'请输入标题'])->label('标题'); ?>
   <? echo $form->field($model, 'shortTitle',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>1,'maxlength' => 50,'placeholder'=>'请输入短标题'])->label('短标题') ?>
    <? echo $form->field($model, 'source',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>1,'maxlength' => 30,'class'=>'form-control','placeholder'=>'请输入来源'])->label('来源'); ?>
    <div class="form-group">
        <label for="site_logo">缩略图(请上传4：3大小的图片)</label>
        <div class="custom-file">
            <div class="row">
                <div class="col-md-2">
                    <?php if($model['thumb']){echo Html::img('/'.$model['thumb'],['id'=>'img1','width'=>'100%']); }else{echo Html::img('/img/no_pic.jpg',['id'=>'img1','width'=>'100%']);}?>
                    <?php echo Html::hiddenInput('Cmsnews[thumb]', $model['thumb'],['id'=>'proimage1','class'=>'form-control']); ?>
                    <div class="a-upload">
                        <input type="file" class="custom-file-input" name="upFile" id='uploadimg1' onclick="uploadimg(1)">
                        <i class="fas fa-upload"></i> 上传图片</div>
                </div>

            </div>
            <div id="total-progress" class=" progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                <div class="upprogress1 progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="siteicp">内容</label>
        <?php
        echo UEditor::widget([
            'id'=>'Cmsnews[content]',
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
        <? echo $form->field($model, 'title_en',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>1,'maxlength' => 100,'class'=>'form-control','placeholder'=>'请输入英文标题'])->label('英文标题'); ?>
        <div class="form-group">
            <label for="siteicp">英文内容</label> <?php
            echo UEditor::widget([
                'id'=>'Cmsnews[content_en]',
                'name'=>'content_en',
                'value'=>$model['content_en'],
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
        <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
            <? echo $form->field($model, 'seotitle',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>1,'maxlength' => 255,'class'=>'form-control','placeholder'=>'请输入SEO标题'])->label('SEO标题'); ?>
            <? echo $form->field($model, 'seotitle_en',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>1,'maxlength' => 255,'class'=>'form-control','placeholder'=>'请输入英文SEO标题'])->label('英文SEO标题'); ?>
            <? echo $form->field($model, 'seokey',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>1,'maxlength' => 255,'class'=>'form-control','placeholder'=>'请输入SEO关键词'])->label('SEO关键词'); ?>
            <? echo $form->field($model, 'seokey_en',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>1,'maxlength' => 255,'class'=>'form-control','placeholder'=>'请输入英文SEO关键词'])->label('英文SEO关键词'); ?>
            <? echo $form->field($model, 'seodesc',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>1,'maxlength' => 255,'class'=>'form-control','placeholder'=>'请输入SEO描述'])->label('SEO描述'); ?>
            <? echo $form->field($model, 'seodesc_en',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>1,'maxlength' => 255,'class'=>'form-control','placeholder'=>'请输入英文SEO描述'])->label('英文SEO描述'); ?>
        </div>
    </div>
</div>

<!-- /.card-body -->
<div class="card-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>