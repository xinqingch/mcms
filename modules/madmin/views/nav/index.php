<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\Nav;
$sysmenu = new Nav();
$menu = $sysmenu->findAllChildrens(0);
?>

<link rel="stylesheet" href="/css/bootstrap-treeview.min.css">
<div class="content-wrapper">
    <?php $this->beginContent('@madmin/views/layouts/_right_nav.php');$this->endContent(); ?>
    <section class="content">
        <div class="row">
            <div class="col-md-12 treeview" id="treeview1">
                <?php $form = ActiveForm::begin([
                    'id' => 'nav-form',
                    'layout' => 'horizontal',
                ]); ?>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="list-group">
                        <li class="list-group-item node-treeview1">
                            <div class="row">
                                <div class="col-md-3">
                                    <span class="icon node-icon"></span>
                                    菜单名称 <span class="icon node-icon"></span><a class="btn btn-default btn-xs" href="<?= Url::to(['/madmin/nav/add','parentid'=>$oneval['navId']])?>">
                                        <i class="fas fa-plus"></i>添加一级分类
                                    </a>
                                </div>
                                <div class="col-md-3">路由地址</div>
                                <div class="col-md-3">排序</div>
                                <div class="col-md-3">
                                    操作
                                </div>
                            </div>
                        </li>
                        <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->
                        <?php foreach ($menu as $key=>$oneval){ ?>
                                <?php if(empty($oneval['childrens'])){?>
                                <li class="list-group-item node-treeview1">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <span class="fas fa-minus"></span>
                                            <span class="icon node-icon"></span>
                                        <?= Html::input('text','Nav[title][]',$oneval['title'],['data-id'=>$oneval['navId'],'class'=>'stitle','data-type'=>'title']) ?>
                                        </div>
                                        <div class="col-md-3"><?= Html::input('text','Nav[url][]',$oneval['url'],['data-id'=>$oneval['navId'],'class'=>'stitle','data-type'=>'url']) ?></div>
                                        <div class="col-md-3"><?= Html::input('text','Nav[listorder][]',$oneval['listorder'],['data-id'=>$oneval['navId'],'class'=>'stitle','data-type'=>'listorder']) ?></div>
                                        <div class="col-md-3">
                                            <a class="btn btn-default" href="<?= Url::to(['/madmin/nav/add','parentid'=>$oneval['navId']])?>">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            <a class="btn btn-default" href="<?= Url::to(['/madmin/nav/edit','id'=>$oneval['navId']])?>">
                                                <i class="fas fa-edit"></i> 编辑
                                            </a>
                                            <a class="btn btn-default del_date" href="javascript:" data-id="<?= $oneval['navId']?>">
                                                <i class="fas fa-trash"></i> 删除
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <?php }else{?>
                                <li class="list-group-item node-treeview1">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <span class="fas fa-minus"></span>
                                            <span class="icon node-icon"></span>
                                            <?= Html::input('text','Nav[title][]',$oneval['title'],['data-id'=>$oneval['navId'],'class'=>'stitle','data-type'=>'title']) ?>
                                        </div>
                                        <div class="col-md-3"><?= Html::input('text','Nav[url][]',$oneval['route'],['data-id'=>$oneval['navId'],'class'=>'stitle','data-type'=>'url']) ?></div>
                                        <div class="col-md-3"><?= Html::input('text','Nav[listorder][]',$oneval['listorder'],['data-id'=>$oneval['navId'],'class'=>'stitle','data-type'=>'listorder']) ?></div>
                                        <div class="col-md-3">
                                            <a class="btn btn-default" href="<?= Url::to(['/madmin/nav/add','parentid'=>$oneval['navId']])?>">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            <a class="btn btn-default" href="<?= Url::to(['/madmin/nav/edit','id'=>$oneval['navId']])?>">
                                                <i class="fas fa-edit"></i> 编辑
                                            </a>
                                            <a class="btn btn-default del_date" href="javascript:" data-id="<?= $oneval['navId']?>">
                                                <i class="fas fa-trash"></i> 删除
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                    <?php foreach ($oneval['childrens'] as $two){?>
                                    <li class="list-group-item node-treeview1">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span class="indent"></span>
                                                <span class="fas <?php if(!empty($two['childrens'])){ echo 'fa-minus';}else{ echo 'fa-plus';}?>"></span>
                                                <span class="icon node-icon"></span>
                                                <?= Html::input('text','Nav[title][]',$two['title'],['data-id'=>$two['navId'],'class'=>'stitle','data-type'=>'title']) ?>
                                            </div>
                                            <div class="col-md-3"><?= Html::input('text','Nav[url][]',$two['url'],['data-id'=>$two['navId'],'class'=>'stitle','data-type'=>'url']) ?></div>
                                            <div class="col-md-3"><?= Html::input('text','Nav[listorder][]',$two['listorder'],['data-id'=>$two['navId'],'class'=>'stitle','data-type'=>'listorder']) ?></div>
                                            <div class="col-md-3">
                                                <a class="btn btn-default" href="<?= Url::to(['/madmin/nav/add','fatherId'=>$two['navId']])?>">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                                <a class="btn btn-default" href="<?= Url::to(['/madmin/nav/edit','id'=>$two['navId']])?>">
                                                    <i class="fas fa-edit"></i> 编辑
                                                </a>
                                                <a class="btn btn-default del_date" href="javascript:" data-id="<?= $two['navId']?>"  >
                                                    <i class="fas fa-trash"></i> 删除
                                                </a>
                                            </div>
                                        </div>

                                    </li>
                                        <?php if(!empty($two['childrens'])){?>
                                                <?php foreach ($two['childrens'] as $three){?>
                                                <li class="list-group-item node-treeview1">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <span class="indent"></span>
                                                            <span class="indent"></span>
                                                            <span class="fas fa-plus"></span>
                                                            <span class="icon node-icon"></span>
                                                            <?= Html::input('text','Nav[title][]',$three['title'],['data-id'=>$three['navId'],'class'=>'stitle','data-type'=>'title']) ?>
                                                        </div>
                                                        <div class="col-md-3"><?= Html::input('text','Nav[url][]',$three['url'],['data-id'=>$three['navId'],'class'=>'stitle','data-type'=>'url']) ?></div>
                                                        <div class="col-md-3"><?= Html::input('text','Nav[listorder][]',$three['listorder'],['data-id'=>$three['navId'],'class'=>'stitle','data-type'=>'listorder']) ?></div>
                                                        <div class="col-md-3">
                                                            <!--<a class="btn btn-default" href="<?= Url::to(['/madmin/nav/add','fatherId'=>$three['navId']])?>">
                                                                <i class="fas fa-plus"></i>
                                                            </a>-->
                                                            <span class="indent"></span>
                                                            <span class="indent"></span>
                                                            <span class="icon node-icon"></span>
                                                            <a class="btn btn-default" href="<?= Url::to(['/madmin/nav/edit','id'=>$three['navId']])?>">
                                                                <i class="fas fa-edit"></i> 编辑
                                                            </a>
                                                            <a class="btn btn-default del_date" href="javascript:" data-id="<?= $three['navId']?>" >
                                                                <i class="fas fa-trash"></i> 删除
                                                            </a>
                                                        </div>
                                                    </div>

                                                </li>
                                                <?php } ?>
                                        <?php }?>

                                <?php } ?>

                                <?php } ?>

                        <?php } ?>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </section>
</div>

<script>
    //ajax删除
    $('.del_date').on('click',function(){
        var id = $(this).data('id') ;
        if(!confirm("确认删除")){
            return false;
        }
        var th = $(this);

        $.ajax({
            type: "GET",
            url: "/madmin/nav/delete",
            data: "id="+id,
            success: function(msg){
                if(msg.code==0){
                    th.parent().parent().parent().remove();
                    return false;
                }else{
                    toastr.error(msg.message);
                }
            }
        })
        return false;
    });
    //ajax修改分类标题
    $('.stitle').on('change',function(){
        var id = $(this).data('id') ;
        var type = $(this).data('type') ;
        var value = $(this).val() ;
        console.log(id);
        console.log(value);
        $.ajax({
            type: "GET",
            url: "/madmin/nav/update",
            data: "type="+type+"&id="+id+"&content="+value,
            success: function(msg){
                if(msg.code==0){
                    //alert(msg.message);
                    toastr.success('保存成功');
                }else{
                    toastr.error(msg.message);
                }
            }
        })
        return false;
    });
</script>