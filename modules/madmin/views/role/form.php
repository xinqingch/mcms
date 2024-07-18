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

    <? echo $form->field($model, 'rolename',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>3,'maxlength' => 30,'class'=>'form-control','placeholder'=>'请输入角色名'])->label('角色名'); ?>
    <? echo $form->field($model, 'description',['errorOptions'=>['tag'=>'span','class'=>'error invalid-feedback']])->textInput(['minlength'=>3,'maxlength' => 30,'class'=>'form-control','placeholder'=>'请输入角色描述'])->label('角色描述'); ?>

    <?php echo Html::CheckboxList(
            'permission[]',
            $perdata,
            $menu,
            [   'class'=>'form-group clearfix',
                'item'=>function ($index, $label, $name, $checked, $value){
                    $checked=$checked?"checked":"";
                    $return = '<div class="col-sm-12 icheck-primary">';
                    $return .= '<input type="checkbox" id="' .  $value . '" name="' . $name . '" value="' . $value . '" class="md-checkbox" '.$checked.'>';
                    $return .= '<label for="' .$value . '">' . ucwords($label) . '</label>';
                    $return .= '</div>';
                    return $return;
                }
            ]);?>





</div>

<!-- /.card-body -->
<div class="card-footer">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>