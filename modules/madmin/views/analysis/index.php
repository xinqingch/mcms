<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\Nav;
$Nav = new Nav();
?>

<div class="content-wrapper">
    <?php $this->beginContent('@madmin/views/layouts/_right_nav.php');$this->endContent(); ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Asin查询管理 </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class='th'>
                                    <input type="checkbox" class="checkall" />
                                </th>
                                <th>会员ID</th>
                                <th>ASIN</th>
                                <th>站点</th>
                                <th>查询时间</th>
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
<?= $this->render('/widget/page/asindatatable',['classid'=>'#example1','ajaxurl'=>'/madmin/analysis/ajaxlist','modules'=>'analysis','memberId'=>$memberId])?>
<?php if(!empty($errmsg)){
    $js = <<<JS
        toastr.error('$errmsg');
    JS;
    $this->registerJs($js,\yii\web\View::POS_END);
}?>

