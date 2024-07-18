<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<!-- form start -->
<?php $form = ActiveForm::begin([
    'id' => 'jduser-form',
    'layout' => 'horizontal',
]); ?>
<div class="card-body">
    <? echo $form->field($model, 'phone',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>3,'maxlength' => 30,'class'=>'form-control','placeholder'=>'请输入手机号码'])->label('手机号码'); ?>
    <? echo $form->field($model, 'username',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>3,'maxlength' => 30,'class'=>'form-control','placeholder'=>'请输入昵称'])->label('昵称'); ?>
    <? echo $form->field($model, 'authorInfo',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textarea(['rows'=>5])->label('用户信息'); ?>
    <? echo $form->field($model, 'cookie',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textarea(['rows'=>5])->label('登录信息'); ?>
    <div class="form-group field-jduser-exptime has-success">
        <label class="control-label col-sm-3" for="jduser-exptime">有效期</label>
        <div class="col-sm-6">
            <input type="text" id="jduser-exptime" class="form-control" value="<?=$model->exptime?>" name="Jduser[exptime]" placeholder="请输入有效期" aria-invalid="false">
            <span class="error invalid-feedback"></span>
        </div>

    </div>
    <? echo $form->field($model,'vip',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->radioList(['0'=>'普通会员','1'=>'VIP会员'])->label('会员组'); ?>
</div>

<!-- /.card-body -->
<div class="card-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
