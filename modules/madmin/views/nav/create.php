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
                        <h3 class="card-title">菜单 <small>base setting</small></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <?php $form = ActiveForm::begin([
                        'id' => 'menu-form',
                        'layout' => 'horizontal',
                    ]); ?>
                    <?= Html::hiddenInput('parentid',$parentid);?>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="SiteName">菜单名称</label>
                                <input type="text" name="Nav[title]" class="form-control" id="title" value="<?=$model['title']?>" placeholder="菜单名称">
                            </div>
                            <div class="form-group">
                                <label for="SiteName">菜单名称(EN)</label>
                                <input type="text" name="Nav[title_en]" class="form-control" id="title" value="<?=$model['title_en']?>" placeholder="菜单名称">
                            </div>
                            <div class="form-group">
                                <label for="SiteName">SEO标题</label>
                                <input type="text" name="Nav[seotitle]" class="form-control" id="title" value="<?=$model['seotitle']?>" placeholder="SEO标题">
                            </div>
                            <div class="form-group">
                                <label for="SiteName">SEO关键词</label>
                                <input type="text" name="Nav[seokey]" class="form-control" id="title" value="<?=$model['seokey']?>" placeholder="SEO关键词">
                            </div>
                            <div class="form-group">
                                <label for="index_keyword">菜单类型</label>
                                <?= Html::dropDownList('Nav[pagetype]','5',['0'=>'单页','1'=>'资讯列表','2'=>'图片列表','3'=>'招聘列表','4'=>'产品','5'=>'链接'],['class'=>'form-control','empty'=>'一级菜单']);?>
                            </div>
                            <div class="form-group">
                                <label for="index_desc">地址</label>
                                <input type="text" name="Nav[url]" class="form-control" id="url"  value="<?=$model['url']?>" placeholder="请输入路由地址">
                            </div>
                            <div class="form-group">
                                <label for="site_url">别名</label>
                                <input type="text" name="Sysmenu[aliasname]" class="form-control" id="site_url"  value="<?=$model['aliasname']?>" placeholder="">
                            </div>
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

<?php if(isset($error)){?>
<script>
    toastr.error('<?php echo $error?>');
</script>
<?php }?>
