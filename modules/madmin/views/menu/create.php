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
                        <div class="card-body">
                            <div class="form-group">
                                <label for="SiteName">菜单名称</label>
                                <input type="text" name="Sysmenu[title]" class="form-control" id="SiteName" value="<?=$model['title']?>" placeholder="请输入网站名称">
                            </div>
                            <div class="form-group">
                                <label for="index_seotitle">父菜单</label>
                                <?= Html::dropDownList('Sysmenu[fatherId]',$fatherId,$allmenu,['class'=>'form-control','empty'=>'一级菜单']);?>
                            </div>
                            <div class="form-group">
                                <label for="index_keyword">菜单类型</label>
                                <?= Html::dropDownList('Sysmenu[type]','menu',['navigate'=>'一级','group'=>'目录','menu'=>'菜单','action'=>'动作'],['class'=>'form-control','empty'=>'一级菜单']);?>
                            </div>
                            <div class="form-group">
                                <label for="index_desc">路由</label>
                                <input type="text" name="Sysmenu[route]" class="form-control" id="index_desc"  value="<?=$model['route']?>" placeholder="请输入路由地址">
                            </div>
                            <div class="form-group">
                                <label for="site_url">菜单地址</label>
                                <input type="text" name="Sysmenu[url]" class="form-control" id="site_url"  value="<?=$model['url']?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="site_logo">网站LOGO</label>
                                <div class="custom-file">
                                    <div class="row">
                                    <div class="col-md-10">
                                        <?php echo Html::Input('text','Sysmenu[fontico]', $model['fontico'],['id'=>'proimage1','class'=>'form-control']); ?>
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
