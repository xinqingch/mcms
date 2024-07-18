<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\Role;
?>

<div class="content-wrapper">
    <?php $this->beginContent('@madmin/views/layouts/_right_nav.php');$this->endContent(); ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">API用户管理 </h3>
                        <div style="text-align: right"><span class="icon node-icon"></span><a class="btn btn-default btn-sm" href="/madmin/apiuser/create">
                            <i class="fas fa-plus"></i>添加用户
                        </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class='th'>
                                    <input type="checkbox" class="checkall" />
                                </th>
                                <th>ID</th>
                                <th>账号</th>
                                <th>类型</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->


            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
</div>
<?= $this->render('/widget/page/apiuserdatatable',['classid'=>'#example1','ajaxurl'=>'/madmin/apiuser/ajaxlist','modules'=>'apiuser'])?>
<?php if(!empty($errmsg)){
    $js = <<<JS
        toastr.error('$errmsg');
    JS;
    $this->registerJs($js,\yii\web\View::POS_END);
}?>
