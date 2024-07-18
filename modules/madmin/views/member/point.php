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
                            <h3 class="card-title">积分管理 <small>Point </small></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?php $form = ActiveForm::begin([
                            'id' => 'point-form',
                            'layout' => 'horizontal',
                        ]); ?>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="point-type">类型</label>
                                <div class="col-sm-6">
                                    <?php echo Html::dropDownList('type','1', ['1'=>'增加','2'=>'减少'],['id'=>'point-type','class'=>'form-control']); ?>
                                </div>

                            </div>
                            <div class="form-group  has-success">
                                <label class="control-label col-sm-3" for="point">积分</label>
                                <div class="col-sm-6">
                                    <?php echo Html::textInput('point',0, ['id'=>'point','class'=>'form-control']); ?>
                                </div>

                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <?= Html::submitButton( Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
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
<?php if(!empty($errmsg)){
    $js = <<<JS
        toastr.error('$errmsg');
    JS;
    $this->registerJs($js,\yii\web\View::POS_END);
}?>

