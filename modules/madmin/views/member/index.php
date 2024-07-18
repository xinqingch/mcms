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
                        <h3 class="card-title">用户管理 </h3>
                        <div style="text-align: right"><span class="icon node-icon"></span><a class="btn btn-default btn-sm" href="/madmin/member/create">
                            <i class="fas fa-plus"></i>添加用户
                        </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>账号</th>
                                <th>手机号</th>
                                <th>积分</th>
                                <th>登录时间</th>
                                <th>有效时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($list as $value){?>
                            <tr>
                                <td><?=$value['username']?></td>
                                <td><?=$value['phone']?></td>
                                <td><a href="<?= Url::to(['/madmin/member/pointlist','id'=>$value['memberId']])?>" ><?=$value['points']?></a></td>
                                <td><?=date('Y-m-d H:i:s',$value['inputtime'])?></td>
                                <td><?=date('Y-m-d H:i:s',$value['exptime'])?></td>
                                <td><a class="btn btn-default" href="<?= Url::to(['/madmin/member/edit','id'=>$value['memberId']])?>">
                                        <i class="fas fa-edit"></i> 编辑
                                    </a>
                                    <a class="btn btn-default" href="<?= Url::to(['/madmin/member/point','id'=>$value['memberId']])?>">
                                        <i class="fas fa-edit"></i>修改积分
                                    </a>
                                    <a class="btn btn-default del_date" href="<?= Url::to(['/madmin/member/delete','id'=>$value['memberId']])?>" data-id="<?= $value['memberId']?>" >
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
                url: "/madmin/jduser/delete",
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
