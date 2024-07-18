<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<!-- form start -->
<?php $form = ActiveForm::begin([
    'id' => 'apiuser-form',
    'layout' => 'horizontal',
]); ?>
<div class="card-body">
    <? echo $form->field($model, 'username',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>3,'maxlength' => 255,'class'=>'form-control','placeholder'=>'请输入账号'])->label('账号'); ?>
    <? echo $form->field($model, 'password',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>1,'maxlength' => 255,'class'=>'form-control','placeholder'=>'请输入密码'])->label('手机密码'); ?>
    <? echo $form->field($model, 'token',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['class'=>'form-control','placeholder'=>'请输入TOKEN'])->label('TOKEN'); ?>
    <? echo $form->field($model, 'cookie',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textarea(['rows'=>5])->label('COOKIE'); ?>
    <? echo $form->field($model,'type',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->radioList(['0'=>'H10','1'=>'其它'])->label('用户类型'); ?>
</div>

<!-- /.card-body -->
<div class="card-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
