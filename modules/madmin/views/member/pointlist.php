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
                        <h3 class="card-title">用户积分明细 </h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>操作类型</th>
                                <th>操作积分</th>
                                <th>操作后积分</th>
                                <th>操作时间</th>
                                <th>备注</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($list as $value){?>
                            <tr>
                                <td><?=$value['pointsId']?></td>
                                <td><?=$value['type']==1?'增加':'减少'?></td>
                                <td><?=$value['type']==1?'<span class="text-success">+'.$value['score'].'</span>':'<span class="text-danger">-'.$value['score'].'</span>'?></td>
                                <td><?=$value['type']==1?$value['total']+$value['score']:$value['total']-$value['score']?></td>
                                <td><?=date('Y-m-d H:i:s',$value['inputtime'])?></td>
                                <td><div style="width: 200px;"><?=$value['note']?></div></td>
                            </tr>
                            <?php }?>
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
<?= $this->render('/widget/page/datatable',['classid'=>'#example1'])?>
