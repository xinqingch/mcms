<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<link rel="stylesheet" href="/css/style.css">
<div class="content-wrapper">
    <?php $this->beginContent('@madmin/views/layouts/_right_nav.php');$this->endContent(); ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">邮件配置 <small>mail setting</small></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <?php $form = ActiveForm::begin([
                        'id' => 'mail-form',
                        'layout' => 'horizontal',
                    ]); ?>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="SiteName">邮件服务器</label>
                                <input type="text" name="mailconfig[Host]" class="form-control" id="SiteName" value="<?= $mailconfig['Host']?$mailconfig['Host']:''?>" placeholder="请输入邮件服务器地址">
                            </div>
                            <div class="form-group">
                                <label for="index_seotitle">邮件服务器端口<label>
                                <input type="text" name="mailconfig[Port]" class="form-control" id="index_seotitle"  value="<?= $mailconfig['Port']?$mailconfig['Port']:'25'?>" placeholder="请输入邮件服务器端口">
                            </div>
                            <div class="form-group">
                                <label for="index_keyword">是否启用SMTP认证</label>
                                <?= Html::radioList('mailconfig[SMTPAuth]',true,[true=>'启用',false=>'禁用'],['class'=>'icheck-primary d-inline']);?>
                            </div>
                            <div class="form-group">
                                <label for="index_desc">发邮件地址</label>
                                <input type="text" name="mailconfig[From]" class="form-control" id="index_desc"  value="<?=$mailconfig['From']?$mailconfig['From']:'service@qq.com'?>" placeholder="请输入发邮件地址">
                            </div>
                            <div class="form-group">
                                <label for="site_url">发邮件名称</label>
                                <input type="text" name="mailconfig[FromName]" class="form-control" id="site_url"  value="<?=$mailconfig['FromName']?$mailconfig['FromName']:'service'?>" placeholder="请输入发邮件名称">
                            </div>
                            <div class="form-group">
                                <label for="hottel">登录账号名</label>
                                <input type="text" name="mailconfig[Username]" class="form-control" id="hottel"  value="<?=$mailconfig['Username']?$mailconfig['Username']:'username@qq.com'?>" placeholder="请输入登录账号名">
                            </div>
                            <div class="form-group">
                                <label for="site_address">密码</label>
                                <input type="text" name="mailconfig[Password]" class="form-control" id="site_address"  value="<?=$mailconfig['Password']?$mailconfig['Password']:'123456'?>" placeholder="请输入密码">
                            </div>
                            <div class="form-group">
                                <label for="siteicp">格式</label>
                                <input type="text" name="mailconfig[CharSet]" class="form-control" id="siteicp"  value="<?=$mailconfig['CharSet']?$mailconfig['CharSet']:'UTF-8'?>" placeholder="请输入格式">
                            </div>
                            <div class="form-group">
                                <label for="siteicp">内容类型</label>
                                <input type="text" name="mailconfig[ContentType]" class="form-control" id="siteicp"  value="<?=$mailconfig['ContentType']?$mailconfig['ContentType']:'text/html'?>" placeholder="请输入格式">
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">保存</button>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
        </div>
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">测试发邮件 <small>mail test</small></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="mailto">邮件服务器</label>
                            <input type="text" name="mail" class="form-control" id="mailto" value="8818190@qq.com" >
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary send">发送</button>
                    </div>

                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
</div>
<script>
    //ajax删除
    $('.send').on('click',function(){
        var mail = $('#mailto').val() ;
        if(!confirm("确认发送")){
            return false;
        }
        var th = $(this);

        $.ajax({
            type: "post",
            url: "/madmin/setting/testmail",
            data: "mail="+mail,
            success: function(msg){
                if(msg.code==0){
                    toastr.success(msg.message);
                }else{
                    toastr.error(msg.message);
                }
            }
        })
        return false;
    });
</script>