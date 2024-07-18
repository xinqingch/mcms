<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<link rel="stylesheet" href="/css/style.css">
<style>
    .has-error .error{display: block;}
</style>
<div class="content-wrapper">
    <?php $this->beginContent('@madmin/views/layouts/_right_nav.php');$this->endContent(); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                <li class="pt-2 px-3"><h3 class="card-title"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update')?>资讯 <small>Create News</small></h3></li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">中文信息</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">英文信息</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">SEO信息</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <?= $this->render('form',['model'=>$model])?>

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
<?php if(!empty($errmsg)){
    $js = <<<JS
        toastr.error('$errmsg');
    JS;
    $this->registerJs($js,\yii\web\View::POS_END);
}?>
