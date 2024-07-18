<?php
use app\models\Sysmenu;
$menu = new Sysmenu();
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo $menu->getMenuName()?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">首页</a></li>
                    <li class="breadcrumb-item active"><?php echo $menu->getMenuName()?></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
