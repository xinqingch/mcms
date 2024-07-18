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
                        <div class="card-header">
                            <h3 class="card-title"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update')?>证书 <small>Create Card</small></h3>
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
