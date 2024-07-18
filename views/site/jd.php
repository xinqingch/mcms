<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\AppAsset;

AppAsset::register($this);
AppAsset::addScript($this,'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js');

$this->title = '生成搜索URL';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

        <!-- Nav tabs -->
        <ul id="myTabs" class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#search" aria-controls="search" role="tab" data-toggle="tab">搜索</a></li>
            <li role="presentation"><a href="#miaosha" aria-controls="miaosha" role="tab" data-toggle="tab">秒杀</a></li>
            <li role="presentation"><a href="#shop" aria-controls="shop" role="tab" data-toggle="tab">店铺</a></li>
            <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">待定</a></li>
        </ul>
    <?php $form = ActiveForm::begin([
        'id' => 'jd-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="search">
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <p>请输入您要生成的关键字(以逗号分隔关键词):</p>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::textInput('keyword',$keyword,['class'=>'form-control']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::textInput('price','',['class'=>'form-control','maxlength' => 10,'placeholder'=>'输入最低价格']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">是否京东物流</label>
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::radioList('shop','0',['0'=>'否','1'=>'是'],['class'=>'form-control']) ?>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="miaosha">
                <div class="form-group">
                    <label class="col-lg-2 control-label">选择秒杀分类</label>
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::dropDownList('category',2,$categorys,['class'=>'form-control']) ?>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="shop">
                <div class="form-group">
                    <div class="col-lg-offset-1 col-lg-11">
                        <p>请输入您要店铺的ID(以逗号分隔关键词):</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">店铺的ID</label>
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::textInput('shopId','',['class'=>'form-control']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">取多少数量</label>
                    <div class="col-lg-offset-1 col-lg-11">
                        <?= Html::textInput('pagesize',30,['class'=>'form-control']) ?>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="settings">...</div>
        </div>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::dropDownList('type','search',['search'=>'搜索','miaosha'=>'秒杀' ,'shop'=>'店铺'],['class'=>'form-control']) ?>
        </div>
    </div>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('生成', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    <div class="col-lg-offset-1" style="color:#999;">
        <?=$str?>
    </div>
    <br/>
    <br/>
    <br/>
    <hr/>
    <div class="">
        <div class="row">
            <?php foreach ($defaultkey as $value){
                echo '<div class="col-md-2">'.$value.'</div>';
            }?>
        </div>
        <div class="row">
            <?php foreach ($shopkeywords as $value){
                echo '<div class="col-md-3">'.$value.'</div>';
            }?>
        </div>
    </div>

</div>

<?php
    $js = <<<JS
        $('#myTabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
    JS;
    $this->registerJs($js,\yii\web\View::POS_END);
?>
