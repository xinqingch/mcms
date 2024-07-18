<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\Role;
$roleoption = Role::listoption();
?>

<div class="content-wrapper">
    <?php $this->beginContent('@madmin/views/layouts/_right_nav.php');$this->endContent(); ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">超级管理员 </h3>
                        <div style="text-align: right"><span class="icon node-icon"></span><a class="btn btn-default btn-sm" href="/madmin/adminer/create">
                            <i class="fas fa-plus"></i>添加管理员
                        </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>管理员账号</th>
                                <th>管理员角色</th>
                                <th>最新登录IP</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($list as $value){?>
                            <tr>
                                <td><?=$value['username']?></td>
                                <td><?= $roleoption[$value['roleId']]?></td>
                                <td><?=long2ip($value['login_ip'])?></td>
                                <td><?=date('Y-m-d H:i:s',$value['inputtime'])?></td>
                                <td><a class="btn btn-default" href="<?= Url::to(['/madmin/adminer/edit','id'=>$value['adminerId']])?>">
                                        <i class="fas fa-edit"></i> 编辑
                                    </a>
                                    <a class="btn btn-default del_date" href="javascript:" data-id="<?= $value['adminerId']?>" >
                                        <i class="fas fa-trash"></i> 删除
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
<script>
    $(function () {
        //ajax删除
        $('.del_date').on('click',function(){
            var id = $(this).data('id') ;
            if(!confirm("确认删除")){
                return false;
            }
            var th = $(this);

            $.ajax({
                type: "GET",
                url: "/madmin/adminer/delete",
                data: "id="+id,
                success: function(msg){
                    if(msg.code==0){
                        th.parent().parent().remove();
                        return false;
                    }else{
                        toastr.error(msg.message);
                    }
                }
            })
            return false;
        });
    });
</script>
