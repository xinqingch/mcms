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
                        <?= Html::hiddenInput('Nav[parentid]',$fatherId);?>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">菜单名称</label>
                                <input type="text" name="Nav[title]" class="form-control" id="title" value="<?=$model['title']?>" placeholder="请输入菜单名称">
                            </div>
                            <div class="form-group">
                                <label for="title_ne">菜单名称(En)</label>
                                <input type="text" name="Nav[title_en]" class="form-control" id="title_en" value="<?=$model['title_en']?>" placeholder="请输入菜单英文名称">
                            </div>
                            <div class="form-group">
                                <label for="aliasname">菜单标识名(用于导航识别用)</label>
                                <input type="text" name="Nav[aliasname]" class="form-control" id="aliasname" value="<?=$model['aliasname']?>" placeholder="请输入菜单标识名">
                            </div>
                            <div class="form-group">
                                <label for="index_keyword">菜单类型</label>
                                <?= Html::dropDownList('Nav[pagetype]','menu',$PageType,['class'=>'form-control','empty'=>'请选择菜单类型']);?>
                            </div>
                            <div class="form-group">
                                <label for="site_url">菜单地址</label>
                                <input type="text" name="Nav[url]" class="form-control" id="site_url"  value="<?=$model['url']?>" placeholder="只有选择链接时填写此项">
                            </div>
                            <div class="form-group">
                                <label for="seotitle">菜单SEO</label>
                                <input type="text" name="Nav[seotitle]" class="form-control" id="seotitle"  value="<?=$model['seotitle']?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="seokey">菜单SEO关键词</label>
                                <input type="text" name="Nav[seokey]" class="form-control" id="seokey"  value="<?=$model['seokey']?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="seodesc">菜单SEO描述</label>
                                <input type="text" name="Nav[seodesc]" class="form-control" id="seodesc"  value="<?=$model['seodesc']?>" placeholder="">
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
