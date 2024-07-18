<?php
use yii\helpers\Url;
use app\models\Sysmenu;
$admininfo = Yii::$app->admin->identity->getUser();
$sysmenu = new Sysmenu();
$menu = $sysmenu->findAllChildrens('000000000000');
//dump($menu);exit;
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/madmin" class="brand-link">
        <img src="/img/logo_manage.jpg" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo Yii::t('adm','Manage Title')?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/img/user0-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $admininfo['username'];?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <?php foreach ($menu as $key=>$oneval){ ?>
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link<?php if($key==0){echo ' active';}?>">
                        <i class="<?=$oneval['fontico']?> nav-icon"></i>
                        <p>
                            <?= $oneval['title']?>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <?php if(!empty($oneval['childrens'])){?>
                    <ul class="nav nav-treeview">
                        <?php foreach ($oneval['childrens'] as $two){?>
                        <li class="nav-item">
                            <a href="<?php echo !empty($two['route'])?Url::to($two['route']):'#'?>" class="nav-link">
                                <i class="<?=$two['fontico']?> nav-icon"></i>
                                <p><?=$two['title']?></p>
                                <?php if(!empty($two['childrens'])){?><i class="fas fa-angle-left right"></i><?php } ?>
                            </a>
                            <?php if(!empty($two['childrens'])){?>
                            <ul class="nav nav-treeview">
                                <?php foreach ($two['childrens'] as $three){?>
                                <li class="nav-item">
                                    <a href="<?php echo !empty($three['route'])?Url::to($three['route']):'#'?>" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?=$three['title']?></p>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php }?>
                </li>
                    <?php } ?>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
