<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<!-- form start -->
<?php $form = ActiveForm::begin([
    'id' => 'addadminer-form',
    'layout' => 'horizontal',
]); ?>
<?= Html::hiddenInput('Adminer[roleId]',1);?>
<div class="card-body">
    <? echo $form->field($model, 'username',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>3,'maxlength' => 30,'class'=>'form-control','placeholder'=>'请输入管理员账号'])->label('管理员账号'); ?>
    <? echo $form->field($model,'roleId',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->dropDownList($roleoption)->label('管理员组'); ?>
    <? echo $form->field($model, 'password',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->passwordInput(['minlength'=>5,'maxlength' => 30,'placeholder'=>'请输入管理员登录密码'])->label('管理员登录密码') ?>
    <? echo $form->field($model, 'repassword',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->passwordInput(['minlength'=>5,'maxlength' => 30,'placeholder'=>'请再次输入管理员密码'])->label('确认登录密码') ?>


</div>

<!-- /.card-body -->
<div class="card-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>