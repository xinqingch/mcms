<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<!-- form start -->
<?php $form = ActiveForm::begin([
    'id' => 'user-form',
    'layout' => 'horizontal',
]); ?>
<div class="card-body">
    <? echo $form->field($model, 'username',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>3,'maxlength' => 30,'class'=>'form-control','placeholder'=>'请输入账号'])->label('账号'); ?>
    <? echo $form->field($model, 'phone',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>3,'maxlength' => 30,'class'=>'form-control','placeholder'=>'请输入手机号码'])->label('手机号码'); ?>
    <? echo $form->field($model, 'password',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->passwordInput(['minlength'=>5,'maxlength' => 30,'placeholder'=>'请输入登录密码,如不需要修改密码请留空'])->label('用户登录密码') ?>
    <? echo $form->field($model, 'repassword',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->passwordInput(['minlength'=>5,'maxlength' => 30,'placeholder'=>'请再次输入密码'])->label('确认登录密码') ?>
    <div class="form-group field-user-exptime has-success">
        <label class="control-label col-sm-3" for="user-exptime">有效期</label>
        <div class="col-sm-6">
            <input type="text" id="user-exptime" class="form-control" value="<?=$model->exptime?>" name="User[exptime]" placeholder="请输入有效期" aria-invalid="false">
            <span class="error invalid-feedback"></span>
        </div>

    </div>
</div>

<!-- /.card-body -->
<div class="card-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
