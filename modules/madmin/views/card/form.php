<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\AppAsset;

AppAsset::register($this);
AppAsset::addScript($this,'@web/js/upload_img.js');
?>
<!-- form start -->
<?php $form = ActiveForm::begin([
    'id' => 'card-form',
    'layout' => 'horizontal',
]); ?>
<?= Html::hiddenInput('Certificate[roleId]',1);?>
<div class="card-body">
    <? echo $form->field($model, 'name',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>1,'maxlength' => 30,'class'=>'form-control','placeholder'=>'请输入姓名'])->label('姓名'); ?>
    <?= $form->field($model, 'sex')->dropdownList([
        '男' => '男',
        '女'=> '女'
    ],
    ['prompt'=>'性别']
)->label('性别');?>
    <? echo $form->field($model, 'card',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>15,'maxlength' => 20,'placeholder'=>'请输入身份证号码'])->label('身份证号码') ?>
    <? echo $form->field($model, 'type',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>1,'maxlength' => 30,'class'=>'form-control','placeholder'=>'请输入工种'])->label('工种'); ?>
    <? echo $form->field($model, 'level',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>1,'maxlength' => 30,'class'=>'form-control','placeholder'=>'请输入等级'])->label('等级'); ?>
    <? echo $form->field($model, 'num',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>5,'maxlength' => 20,'placeholder'=>'输入证书编号'])->label('证书编号') ?>
    <? echo $form->field($model, 'organization',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>5,'maxlength' => 100,'placeholder'=>'输入培训机构'])->label('培训机构') ?>
    <? echo $form->field($model, 'createTime',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>5,'maxlength' => 100,'placeholder'=>'输入创建证书日期'])->label('证书日期') ?>
    <div class="form-group">
        <label for="site_logo">头像(请上传420x572像素大小的头像照片)</label>
        <div class="custom-file">
            <div class="row">
                <div class="col-md-10">
                    <?php echo Html::Input('text','Certificate[face]', $model['face'],['id'=>'proimage1','class'=>'form-control']); ?>
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
    <!--<div class="form-group">
        <label for="weixin">证书图片</label>
        <div class="row">
            <div class="col-md-10">
                <?php echo Html::Input('text','Certificate[pic]', $model['pic'],['id'=>'proimage2','class'=>'form-control']); ?>
            </div>
            <div class="col-md-2 a-upload">
                <input type="file" class="custom-file-input" name="upFile" id='uploadimg2' onclick="uploadimg(2)">
                <i class="fas fa-upload"></i> 上传图片</div>
        </div>
        <div id="total-progress" class=" progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
            <div class="upprogress2 progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>
        </div>
    </div>-->
</div>

<!-- /.card-body -->
<div class="card-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>