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
                            <h3 class="card-title">用户角色管理 </h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>角色</th>
                                    <th>描述</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($list as $value){?>
                                    <tr>
                                        <td><?=$value['memberroleId']?></td>
                                        <td><?=$value['name']?></td>
                                        <td><?=$value['description']?></td>
                                        <td><?=$value['state']==1?'有效':'无效'?></td>
                                        <td>  <a class="btn btn-default del_date" href="<?= Url::to(['/madmin/member/permission','id'=>$value['memberroleId']])?>"  >
                                                <i class="fas fa-edit"></i>菜单权限
                                            </a></td>
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
