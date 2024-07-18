<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'SKU转换';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
        </div>
    </div>
    <?php $form = ActiveForm::begin([
        'id' => 'jd-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <div class="form-group">
        <label class="col-lg-2 control-label">JSON信息</label>
        <div class="col-lg-offset-1 col-lg-11">
        <?= Html::textarea('shopid','',['class'=>'form-control']) ?>
        </div>
    </div>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('生成', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    <div class="col-lg-offset-1" style="color:#999;">
        <?php foreach ((array)$shopids as $key=>$value){?>
        <?= $value?>:<?= $key?><br/>
        <?php }?>
    </div>
    <br/>
    <br/>
    <br/>
    <hr/>

</div>