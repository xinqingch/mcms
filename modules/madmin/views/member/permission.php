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
                            <h3 class="card-title">菜单权限管理 <small>Nav Permission </small></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <?php $form = ActiveForm::begin([
                            'id' => 'permission-form',
                            'layout' => 'horizontal',
                        ]); ?>
                        <div class="card-body">
                            <?php foreach ($memu as $value){?>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <?php
                                    if(in_array($value['navId'],$permission)){
                                        $checked =true;
                                    }else{
                                        $checked =false;
                                    }
                                    ?>
                                    <?php echo Html::checkbox('navId[]',$checked,['value'=>$value['navId']]); ?><?=$value['title']?>
                                </div>

                            </div>
                            <? }?>

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

