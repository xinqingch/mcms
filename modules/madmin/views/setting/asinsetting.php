<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

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
                    <div class="card-header  p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">ASIN配置</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">算法方案</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <?php $form = ActiveForm::begin([
                        'id' => 'asin-form',
                        'layout' => 'horizontal',
                    ]); ?>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                <div class="form-group">
                                    <label for="SiteName">相关性得分配置</label>

                                    <?php if($asinconfig['relateLevel']){foreach ($asinconfig['relateLevel'] as $key=>$val){?>
                                        <div class="row">
                                            <div class="col-2"><input type="text" name="asinconfig[relateLevel][<?=$key?>][min]" class="form-control" value="<?= $val['min']?>" placeholder="最小值"></div>
                                            <div class="col-2"><input type="text" name="asinconfig[relateLevel][<?=$key?>][max]" class="form-control" value="<?= $val['max']?>" placeholder="最大值"></div>
                                            <div class="col-2"><input type="text" name="asinconfig[relateLevel][<?=$key?>][coefficient]" class="form-control" value="<?= $val['coefficient']?>" placeholder="系数"></div>
                                            <div class="col-2"><input type="text" name="asinconfig[relateLevel][<?=$key?>][description]" class="form-control" value="<?= $val['description']?>" placeholder="分数说明"></div>
                                            <div class="col-2"><input type="text" name="asinconfig[relateLevel][<?=$key?>][level]" class="form-control" value="<?= $val['level']?>" placeholder="分类"></div>
                                            <div class="col-2"><input type="text" name="asinconfig[relateLevel][<?=$key?>][Advertising]" class="form-control" value="<?= $val['Advertising']?>" placeholder="等级"></div>

                                        </div>
                                    <?php }}else{?>
                                        <div class="row">
                                            <div class="col-2"><input type="text" name="asinconfig[relateLevel][0][min]" class="form-control" value="<?= $asinconfig['relateLevel'][0]['min']?$asinconfig['relateLevel'][0]['min']:''?>" placeholder="最小值"></div>
                                            <div class="col-2"><input type="text" name="asinconfig[relateLevel][0][max]" class="form-control" value="<?= $asinconfig['relateLevel'][0]['max']?$asinconfig['relateLevel'][0]['max']:''?>" placeholder="最大值"></div>
                                            <div class="col-2"><input type="text" name="asinconfig[relateLevel][0][coefficient]" class="form-control" value="<?= $asinconfig['relateLevel'][0]['coefficient']?$asinconfig['relateLevel'][0]['coefficient']:''?>" placeholder="系数"></div>
                                            <div class="col-2"><input type="text" name="asinconfig[relateLevel][0][description]" class="form-control" value="<?= $asinconfig['relateLevel'][0]['description']?$asinconfig['relateLevel'][0]['description']:''?>" placeholder="分数说明"></div>
                                            <div class="col-2"><input type="text" name="asinconfig[relateLevel][0][level]" class="form-control" value="<?= $asinconfig['relateLevel'][0]['level']?$asinconfig['relateLevel'][0]['level']:''?>" placeholder="分类"></div>
                                            <div class="col-2"><input type="text" name="asinconfig[relateLevel][0][Advertising]" class="form-control" value="<?= $asinconfig['relateLevel'][0]['Advertising']?$asinconfig['relateLevel'][0]['Advertising']:''?>" placeholder="分类"></div>

                                        </div>
                                    <?php }?>
                                    <a href="javascript:" class="plus" ><i class="fas fa-plus"></i></a>  <a href="javascript:" class="minus"><i class="fas fa-minus"></i></a>
                                </div>
                                <div class="form-group">
                                    <label for="SiteName">广告排名得分系数配置</label>
                                    <?php if($asinconfig['Advcompetition']){foreach ($asinconfig['Advcompetition'] as $key=>$val){?>
                                        <div class="row">
                                            <div class="col-3"><input type="text" name="asinconfig[Advcompetition][<?=$key?>][min]" class="form-control" value="<?= $val['min']?>" placeholder="最小得分"></div>
                                            <div class="col-3"><input type="text" name="asinconfig[Advcompetition][<?=$key?>][max]" class="form-control" value="<?= $val['max']?>" placeholder="最大得分"></div>
                                            <div class="col-3"><input type="text" name="asinconfig[Advcompetition][<?=$key?>][coefficient]" class="form-control" value="<?= $val['coefficient']?>" placeholder="系数"></div>
                                        </div>
                                    <?php }}else{?>
                                        <div class="row">
                                            <div class="col-3"><input type="text" name="asinconfig[Advcompetition][0][min]" class="form-control" value="<?= $asinconfig['Advcompetition'][0]['min']?>" placeholder="最小得分"></div>
                                            <div class="col-3"><input type="text" name="asinconfig[Advcompetition][0][max]" class="form-control" value="<?= $asinconfig['Advcompetition'][0]['max']?>" placeholder="最大得分"></div>
                                            <div class="col-3"><input type="text" name="asinconfig[Advcompetition][0][coefficient]" class="form-control" value="<?= $asinconfig['Advcompetition'][0]['coefficient']?>" placeholder="系数"></div>
                                        </div>
                                    <?php }?>
                                    <a href="javascript:" class="plus" ><i class="fas fa-plus"></i></a>  <a href="javascript:" class="minus"><i class="fas fa-minus"></i></a>
                                </div>
                                <div class="form-group">
                                    <label for="SiteName">自然排名得分系数配置</label>
                                    <?php if($asinconfig['Competition']){foreach ($asinconfig['Competition'] as $key=>$val){?>
                                        <div class="row">
                                            <div class="col-3"><input type="text" name="asinconfig[Competition][<?=$key?>][min]" class="form-control" value="<?= $val['min']?>" placeholder="最小得分"></div>
                                            <div class="col-3"><input type="text" name="asinconfig[Competition][<?=$key?>][max]" class="form-control" value="<?= $val['max']?>" placeholder="最大得分"></div>
                                            <div class="col-3"><input type="text" name="asinconfig[Competition][<?=$key?>][coefficient]" class="form-control" value="<?= $val['coefficient']?>" placeholder="系数"></div>
                                        </div>
                                    <?php }}else{?>
                                        <div class="row">
                                            <div class="col-3"><input type="text" name="asinconfig[Competition][0][min]" class="form-control" value="<?= $asinconfig['Competition'][0]['min']?>" placeholder="最小得分"></div>
                                            <div class="col-3"><input type="text" name="asinconfig[Competition][0][max]" class="form-control" value="<?= $asinconfig['Competition'][0]['max']?>" placeholder="最大得分"></div>
                                            <div class="col-3"><input type="text" name="asinconfig[Competition][0][coefficient]" class="form-control" value="<?= $asinconfig['Competition'][0]['coefficient']?>" placeholder="系数"></div>
                                        </div>
                                    <?php }?>
                                    <a href="javascript:" class="plus" ><i class="fas fa-plus"></i></a>  <a href="javascript:" class="minus"><i class="fas fa-minus"></i></a>
                                </div>
                                <div class="form-group">
                                    <label for="SiteName">排名得分配置</label>
                                    <?php if($asinconfig['scores']){foreach ($asinconfig['scores'] as $key=>$val){?>
                                    <div class="row">
                                        <div class="col-3"><input type="text" name="asinconfig[scores][<?=$key?>][min]" class="form-control" value="<?= $val['min']?>" placeholder="最小值"></div>
                                        <div class="col-3"><input type="text" name="asinconfig[scores][<?=$key?>][max]" class="form-control" value="<?= $val['max']?>" placeholder="最大值"></div>
                                        <div class="col-3"><input type="text" name="asinconfig[scores][<?=$key?>][description]" class="form-control" value="<?= $val['description']?>" placeholder="得分"></div>
                                    </div>
                                    <?php }}else{?>
                                        <div class="row">
                                            <div class="col-3"><input type="text" name="asinconfig[scores][0][min]" class="form-control" value="<?= $asinconfig['scores'][0]['min']?>" placeholder="最小值"></div>
                                            <div class="col-3"><input type="text" name="asinconfig[scores][0][max]" class="form-control" value="<?= $asinconfig['scores'][0]['max']?>" placeholder="最大值"></div>
                                            <div class="col-3"><input type="text" name="asinconfig[scores][0][description]" class="form-control" value="<?= $asinconfig['scores'][0]['description']?>" placeholder="得分"></div>
                                        </div>
                                    <?php }?>
                                    <a href="javascript:" class="plus" ><i class="fas fa-plus"></i></a>  <a href="javascript:" class="minus"><i class="fas fa-minus"></i></a>
                                </div>
                                <div class="form-group">
                                    <label for="SiteName">上榜率系数配置</label>
                                    <div class="row">
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][0][min]" class="form-control" value="<?= $asinconfig['proportion'][0]['min']?$asinconfig['proportion'][0]['min']:''?>" placeholder="最小值"></div>
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][0][max]" class="form-control" value="<?= $asinconfig['proportion'][0]['max']?$asinconfig['proportion'][0]['max']:''?>" placeholder="最大值"></div>
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][0][coefficient]" class="form-control" value="<?= $asinconfig['proportion'][0]['coefficient']?$asinconfig['proportion'][0]['coefficient']:''?>" placeholder="系数"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][1][min]" class="form-control" value="<?= $asinconfig['proportion'][1]['min']?$asinconfig['proportion'][1]['min']:''?>" placeholder="最小值"></div>
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][1][max]" class="form-control" value="<?= $asinconfig['proportion'][1]['max']?$asinconfig['proportion'][1]['max']:''?>" placeholder="最大值"></div>
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][1][coefficient]" class="form-control" value="<?= $asinconfig['proportion'][1]['coefficient']?$asinconfig['proportion'][1]['coefficient']:''?>" placeholder="系数"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][2][min]" class="form-control" value="<?= $asinconfig['proportion'][2]['min']?$asinconfig['proportion'][2]['min']:''?>" placeholder="最小值"></div>
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][2][max]" class="form-control" value="<?= $asinconfig['proportion'][2]['max']?$asinconfig['proportion'][2]['max']:''?>" placeholder="最大值"></div>
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][2][coefficient]" class="form-control" value="<?= $asinconfig['proportion'][2]['coefficient']?$asinconfig['proportion'][2]['coefficient']:''?>" placeholder="系数"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][3][min]" class="form-control" value="<?= $asinconfig['proportion'][3]['min']?$asinconfig['proportion'][3]['min']:''?>" placeholder="最小值"></div>
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][3][max]" class="form-control" value="<?= $asinconfig['proportion'][3]['max']?$asinconfig['proportion'][3]['max']:''?>" placeholder="最大值"></div>
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][3][coefficient]" class="form-control" value="<?= $asinconfig['proportion'][3]['coefficient']?$asinconfig['proportion'][3]['coefficient']:''?>" placeholder="系数"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][4][min]" class="form-control" value="<?= $asinconfig['proportion'][4]['min']?$asinconfig['proportion'][4]['min']:''?>" placeholder="最小值"></div>
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][4][max]" class="form-control" value="<?= $asinconfig['proportion'][4]['max']?$asinconfig['proportion'][4]['max']:''?>" placeholder="最大值"></div>
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][4][coefficient]" class="form-control" value="<?= $asinconfig['proportion'][4]['coefficient']?$asinconfig['proportion'][4]['coefficient']:''?>" placeholder="系数"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][5][min]" class="form-control" value="<?= $asinconfig['proportion'][5]['min']?>" placeholder="最小值"></div>
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][5][max]" class="form-control" value="<?= $asinconfig['proportion'][5]['max']?>" placeholder="最大值"></div>
                                        <div class="col-3"><input type="text" name="asinconfig[proportion][5][coefficient]" class="form-control" value="<?= $asinconfig['proportion'][5]['coefficient']?>" placeholder="系数"></div>
                                    </div>

                                    <a href="javascript:" class="plus" ><i class="fas fa-plus"></i></a>  <a href="javascript:" class="minus"><i class="fas fa-minus"></i></a>
                                </div>
                                    <div class="form-group">
                                        <label for="SiteName">搜索配置/分类</label>

                                        <?php if($asinconfig['SearchLevel']){foreach ($asinconfig['SearchLevel'] as $key=>$val){?>
                                            <div class="row">
                                                <div class="col-2"><input type="text" name="asinconfig[SearchLevel][<?=$key?>][min]" class="form-control" value="<?= $val['min']?>" placeholder="最小值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[SearchLevel][<?=$key?>][max]" class="form-control" value="<?= $val['max']?>" placeholder="最大值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[SearchLevel][<?=$key?>][score]" class="form-control" value="<?= $val['score']?>" placeholder="得分"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[SearchLevel][<?=$key?>][description]" class="form-control" value="<?= $val['description']?>" placeholder="分数说明"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[SearchLevel][<?=$key?>][level]" class="form-control" value="<?= $val['level']?>" placeholder="分类"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[SearchLevel][<?=$key?>][coefficient]" class="form-control" value="<?= $val['coefficient']?>" placeholder="系数"></div>
                                            </div>
                                        <?php }}else{?>
                                            <div class="row">
                                                <div class="col-2"><input type="text" name="asinconfig[SearchLevel][0][min]" class="form-control" value="<?= $asinconfig['SearchLevel'][0]['min']?$asinconfig['SearchLevel'][0]['min']:''?>" placeholder="最小值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[SearchLevel][0][max]" class="form-control" value="<?= $asinconfig['SearchLevel'][0]['max']?$asinconfig['SearchLevel'][0]['max']:''?>" placeholder="最大值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[SearchLevel][0][score]" class="form-control" value="<?= $asinconfig['SearchLevel'][0]['score']?$asinconfig['SearchLevel'][0]['score']:''?>" placeholder="得分"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[SearchLevel][0][description]" class="form-control" value="<?= $asinconfig['SearchLevel'][0]['description']?$asinconfig['SearchLevel'][0]['description']:''?>" placeholder="分数说明"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[SearchLevel][0][level]" class="form-control" value="<?= $asinconfig['SearchLevel'][0]['level']?$asinconfig['SearchLevel'][0]['level']:''?>" placeholder="分类"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[SearchLevel][0][coefficient]" class="form-control" value="<?= $asinconfig['SearchLevel'][0]['coefficient']?$asinconfig['SearchLevel'][0]['coefficient']:''?>" placeholder="系数"></div>
                                            </div>
                                        <?php }?>
                                        <a href="javascript:" class="plus" ><i class="fas fa-plus"></i></a>  <a href="javascript:" class="minus"><i class="fas fa-minus"></i></a>
                                    </div>
                                    <div class="form-group">
                                        <label for="SiteName">流量配置/分类</label>

                                        <?php if($asinconfig['Traffic']){foreach ($asinconfig['Traffic'] as $key=>$val){?>
                                            <div class="row">
                                                <div class="col-2"><input type="text" name="asinconfig[Traffic][<?=$key?>][min]" class="form-control" value="<?= $val['min']?>" placeholder="最小值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Traffic][<?=$key?>][max]" class="form-control" value="<?= $val['max']?>" placeholder="最大值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Traffic][<?=$key?>][score]" class="form-control" value="<?= $val['score']?>" placeholder="得分"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Traffic][<?=$key?>][description]" class="form-control" value="<?= $val['description']?>" placeholder="分数说明"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Traffic][<?=$key?>][level]" class="form-control" value="<?= $val['level']?>" placeholder="分类"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Traffic][<?=$key?>][coefficient]" class="form-control" value="<?= $val['coefficient']?>" placeholder="系数"></div>
                                            </div>
                                        <?php }}else{?>
                                            <div class="row">
                                                <div class="col-2"><input type="text" name="asinconfig[Traffic][0][min]" class="form-control" value="<?= $asinconfig['Traffic'][0]['min']?$asinconfig['Traffic'][0]['min']:''?>" placeholder="最小值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Traffic][0][max]" class="form-control" value="<?= $asinconfig['Traffic'][0]['max']?$asinconfig['Traffic'][0]['max']:''?>" placeholder="最大值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Traffic][0][score]" class="form-control" value="<?= $asinconfig['Traffic'][0]['score']?$asinconfig['Traffic'][0]['score']:''?>" placeholder="得分"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Traffic][0][description]" class="form-control" value="<?= $asinconfig['Traffic'][0]['description']?$asinconfig['Traffic'][0]['description']:''?>" placeholder="分数说明"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Traffic][0][level]" class="form-control" value="<?= $asinconfig['Traffic'][0]['level']?$asinconfig['Traffic'][0]['level']:''?>" placeholder="分类"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Traffic][0][coefficient]" class="form-control" value="<?= $asinconfig['Traffic'][0]['coefficient']?$asinconfig['Traffic'][0]['coefficient']:''?>" placeholder="系数"></div>
                                            </div>
                                        <?php }?>
                                        <a href="javascript:" class="plus" ><i class="fas fa-plus"></i></a>  <a href="javascript:" class="minus"><i class="fas fa-minus"></i></a>
                                    </div>

                                    <div class="form-group">
                                        <label for="SiteName">机会配置/分类</label>

                                        <?php if($asinconfig['Success']){foreach ($asinconfig['Success'] as $key=>$val){?>
                                            <div class="row">
                                                <div class="col-2"><input type="text" name="asinconfig[Success][<?=$key?>][min]" class="form-control" value="<?= $val['min']?>" placeholder="最小值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Success][<?=$key?>][max]" class="form-control" value="<?= $val['max']?>" placeholder="最大值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Success][<?=$key?>][score]" class="form-control" value="<?= $val['score']?>" placeholder="得分"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Success][<?=$key?>][description]" class="form-control" value="<?= $val['description']?>" placeholder="分数说明"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Success][<?=$key?>][level]" class="form-control" value="<?= $val['level']?>" placeholder="分类"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Success][<?=$key?>][coefficient]" class="form-control" value="<?= $val['coefficient']?>" placeholder="系数"></div>
                                            </div>
                                        <?php }}else{?>
                                            <div class="row">
                                                <div class="col-2"><input type="text" name="asinconfig[Success][0][min]" class="form-control" value="<?= $asinconfig['Success'][0]['min']?$asinconfig['Success'][0]['min']:''?>" placeholder="最小值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Success][0][max]" class="form-control" value="<?= $asinconfig['Success'][0]['max']?$asinconfig['Success'][0]['max']:''?>" placeholder="最大值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Success][0][score]" class="form-control" value="<?= $asinconfig['Success'][0]['score']?$asinconfig['Success'][0]['score']:''?>" placeholder="得分"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Success][0][description]" class="form-control" value="<?= $asinconfig['Success'][0]['description']?$asinconfig['Success'][0]['description']:''?>" placeholder="分数说明"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Success][0][level]" class="form-control" value="<?= $asinconfig['Success'][0]['level']?$asinconfig['Success'][0]['level']:''?>" placeholder="分类"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[Success][0][coefficient]" class="form-control" value="<?= $asinconfig['Success'][0]['coefficient']?$asinconfig['Success'][0]['coefficient']:''?>" placeholder="系数"></div>
                                            </div>
                                        <?php }?>
                                        <a href="javascript:" class="plus" ><i class="fas fa-plus"></i></a>  <a href="javascript:" class="minus"><i class="fas fa-minus"></i></a>
                                    </div>
                                    <div class="form-group">
                                        <label for="SiteName">大盘转换率得分配置</label>

                                        <?php if($asinconfig['SearchConversionRate']){foreach ($asinconfig['SearchConversionRate'] as $key=>$val){?>
                                            <div class="row">
                                                <div class="col-3"><input type="text" name="asinconfig[SearchConversionRate][<?=$key?>][min]" class="form-control" value="<?= $val['min']?>" placeholder="最小值"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[SearchConversionRate][<?=$key?>][max]" class="form-control" value="<?= $val['max']?>" placeholder="最大值"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[SearchConversionRate][<?=$key?>][description]" class="form-control" value="<?= $val['description']?>" placeholder="分数说明"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[SearchConversionRate][<?=$key?>][coefficient]" class="form-control" value="<?= $val['coefficient']?>" placeholder="系数"></div>
                                            </div>
                                        <?php }}else{?>
                                            <div class="row">
                                                <div class="col-3"><input type="text" name="asinconfig[SearchConversionRate][0][min]" class="form-control" value="<?= $asinconfig['SearchConversionRate'][0]['min']?$asinconfig['SearchConversionRate'][0]['min']:''?>" placeholder="最小值"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[SearchConversionRate][0][max]" class="form-control" value="<?= $asinconfig['SearchConversionRate'][0]['max']?$asinconfig['SearchConversionRate'][0]['max']:''?>" placeholder="最大值"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[SearchConversionRate][0][description]" class="form-control" value="<?= $asinconfig['SearchConversionRate'][0]['description']?$asinconfig['SearchConversionRate'][0]['description']:''?>" placeholder="分数说明"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[SearchConversionRate][0][coefficient]" class="form-control" value="<?= $asinconfig['SearchConversionRate'][0]['coefficient']?$asinconfig['SearchConversionRate'][0]['coefficient']:''?>" placeholder="系数"></div>
                                            </div>
                                        <?php }?>
                                        <a href="javascript:" class="plus" ><i class="fas fa-plus"></i></a>  <a href="javascript:" class="minus"><i class="fas fa-minus"></i></a>
                                    </div>
                                    <div class="form-group">
                                        <label for="SiteName">预估转换率配置</label>

                                        <?php if($asinconfig['EstimatedConversionRate']){foreach ($asinconfig['EstimatedConversionRate'] as $key=>$val){?>
                                            <div class="row">
                                                <div class="col-2"><input type="text" name="asinconfig[EstimatedConversionRate][<?=$key?>][min]" class="form-control" value="<?= $val['min']?>" placeholder="最小值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[EstimatedConversionRate][<?=$key?>][max]" class="form-control" value="<?= $val['max']?>" placeholder="最大值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[EstimatedConversionRate][<?=$key?>][score]" class="form-control" value="<?= $val['score']?>" placeholder="得分"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[EstimatedConversionRate][<?=$key?>][description]" class="form-control" value="<?= $val['description']?>" placeholder="分数说明"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[EstimatedConversionRate][<?=$key?>][level]" class="form-control" value="<?= $val['level']?>" placeholder="分类"></div>
                                            </div>
                                        <?php }}else{?>
                                            <div class="row">
                                                <div class="col-3"><input type="text" name="asinconfig[EstimatedConversionRate][0][min]" class="form-control" value="<?= $asinconfig['EstimatedConversionRate'][0]['min']?$asinconfig['EstimatedConversionRate'][0]['min']:''?>" placeholder="最小值"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[EstimatedConversionRate][0][max]" class="form-control" value="<?= $asinconfig['EstimatedConversionRate'][0]['max']?$asinconfig['EstimatedConversionRate'][0]['max']:''?>" placeholder="最大值"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[EstimatedConversionRate][0][score]" class="form-control" value="<?= $asinconfig['EstimatedConversionRate'][0]['score']?$asinconfig['EstimatedConversionRate'][0]['score']:''?>" placeholder="得分"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[EstimatedConversionRate][0][description]" class="form-control" value="<?= $asinconfig['EstimatedConversionRate'][0]['description']?$asinconfig['EstimatedConversionRate'][0]['description']:''?>" placeholder="分数说明"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[EstimatedConversionRate][0][level]" class="form-control" value="<?= $asinconfig['EstimatedConversionRate'][0]['level']?$asinconfig['EstimatedConversionRate'][0]['level']:''?>" placeholder="分类"></div>
                                            </div>
                                        <?php }?>
                                        <a href="javascript:" class="plus" ><i class="fas fa-plus"></i></a>  <a href="javascript:" class="minus"><i class="fas fa-minus"></i></a>
                                    </div>

                                    <div class="form-group">
                                        <label for="SiteName">订单占比配置</label>

                                        <?php if($asinconfig['orderProportion']){foreach ($asinconfig['orderProportion'] as $key=>$val){?>
                                            <div class="row">
                                                <div class="col-2"><input type="text" name="asinconfig[orderProportion][<?=$key?>][min]" class="form-control" value="<?= $val['min']?>" placeholder="最小值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[orderProportion][<?=$key?>][max]" class="form-control" value="<?= $val['max']?>" placeholder="最大值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[orderProportion][<?=$key?>][score]" class="form-control" value="<?= $val['score']?>" placeholder="得分"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[orderProportion][<?=$key?>][description]" class="form-control" value="<?= $val['description']?>" placeholder="占比说明"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[orderProportion][<?=$key?>][level]" class="form-control" value="<?= $val['level']?>" placeholder="分类"></div>
                                            </div>
                                        <?php }}else{?>
                                            <div class="row">
                                                <div class="col-2"><input type="text" name="asinconfig[orderProportion][0][min]" class="form-control" value="<?= $asinconfig['orderProportion'][0]['min']?$asinconfig['orderProportion'][0]['min']:''?>" placeholder="最小值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[orderProportion][0][max]" class="form-control" value="<?= $asinconfig['orderProportion'][0]['max']?$asinconfig['orderProportion'][0]['max']:''?>" placeholder="最大值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[orderProportion][0][score]" class="form-control" value="<?= $asinconfig['orderProportion'][0]['score']?$asinconfig['orderProportion'][0]['score']:''?>" placeholder="最大值"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[orderProportion][0][description]" class="form-control" value="<?= $asinconfig['orderProportion'][0]['description']?$asinconfig['orderProportion'][0]['description']:''?>" placeholder="占比说明"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[orderProportion][0][level]" class="form-control" value="<?= $asinconfig['orderProportion'][0]['level']?$asinconfig['orderProportion'][0]['level']:''?>" placeholder="分类"></div>
                                            </div>
                                        <?php }?>
                                        <a href="javascript:" class="plus" ><i class="fas fa-plus"></i></a>  <a href="javascript:" class="minus"><i class="fas fa-minus"></i></a>
                                    </div>

                                    <div class="form-group">
                                        <label for="SiteName">CPC竞价配置</label>

                                        <?php if($asinconfig['cpc']){foreach ($asinconfig['cpc'] as $key=>$val){?>
                                            <div class="row">
                                                <div class="col-2"><input type="text" name="asinconfig[cpc][<?=$key?>][min]" class="form-control" value="<?= $val['min']?>" placeholder="最小值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[cpc][<?=$key?>][max]" class="form-control" value="<?= $val['max']?>" placeholder="最大值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[cpc][<?=$key?>][score]" class="form-control" value="<?= $val['score']?>" placeholder="得分"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[cpc][<?=$key?>][description]" class="form-control" value="<?= $val['description']?>" placeholder="说明"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[cpc][<?=$key?>][level]" class="form-control" value="<?= $val['level']?>" placeholder="分类"></div>
                                            </div>
                                        <?php }}else{?>
                                            <div class="row">
                                                <div class="col-2"><input type="text" name="asinconfig[cpc][0][min]" class="form-control" value="<?= $asinconfig['cpc'][0]['min']?$asinconfig['cpc'][0]['min']:''?>" placeholder="最小值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[cpc][0][max]" class="form-control" value="<?= $asinconfig['cpc'][0]['max']?$asinconfig['cpc'][0]['max']:''?>" placeholder="最大值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[cpc][0][score]" class="form-control" value="<?= $asinconfig['cpc'][0]['score']?$asinconfig['cpc'][0]['score']:''?>" placeholder="分类"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[cpc][0][description]" class="form-control" value="<?= $asinconfig['cpc'][0]['description']?$asinconfig['cpc'][0]['description']:''?>" placeholder="说明"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[cpc][0][level]" class="form-control" value="<?= $asinconfig['cpc'][0]['level']?$asinconfig['cpc'][0]['level']:''?>" placeholder="分类"></div>
                                            </div>
                                        <?php }?>
                                        <a href="javascript:" class="plus" ><i class="fas fa-plus"></i></a>  <a href="javascript:" class="minus"><i class="fas fa-minus"></i></a>
                                    </div>
                                    <div class="form-group">
                                        <label for="SiteName">投产比配置</label>
                                        <?php if($asinconfig['productionRatio']){foreach ($asinconfig['productionRatio'] as $key=>$val){?>
                                            <div class="row">
                                                <div class="col-2"><input type="text" name="asinconfig[productionRatio][<?=$key?>][min]" class="form-control" value="<?= $val['min']?>" placeholder="最小值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[productionRatio][<?=$key?>][max]" class="form-control" value="<?= $val['max']?>" placeholder="最大值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[productionRatio][<?=$key?>][score]" class="form-control" value="<?= $val['score']?>" placeholder="得分"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[productionRatio][<?=$key?>][description]" class="form-control" value="<?= $val['description']?>" placeholder="说明"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[productionRatio][<?=$key?>][level]" class="form-control" value="<?= $val['level']?>" placeholder="分类"></div>
                                            </div>
                                        <?php }}else{?>
                                            <div class="row">
                                                <div class="col-2"><input type="text" name="asinconfig[productionRatio][0][min]" class="form-control" value="<?= $asinconfig['productionRatio'][0]['min']?$asinconfig['productionRatio'][0]['min']:''?>" placeholder="最小值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[productionRatio][0][max]" class="form-control" value="<?= $asinconfig['productionRatio'][0]['max']?$asinconfig['productionRatio'][0]['max']:''?>" placeholder="最大值"></div>
                                                <div class="col-2"><input type="text" name="asinconfig[productionRatio][0][score]" class="form-control" value="<?= $asinconfig['productionRatio'][0]['score']?$asinconfig['productionRatio'][0]['score']:''?>" placeholder="得分"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[productionRatio][0][description]" class="form-control" value="<?= $asinconfig['productionRatio'][0]['description']?$asinconfig['productionRatio'][0]['description']:''?>" placeholder="说明"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[productionRatio][0][level]" class="form-control" value="<?= $asinconfig['productionRatio'][0]['level']?$asinconfig['productionRatio'][0]['level']:''?>" placeholder="分类"></div>
                                            </div>
                                        <?php }?>
                                        <a href="javascript:" class="plus" ><i class="fas fa-plus"></i></a>  <a href="javascript:" class="minus"><i class="fas fa-minus"></i></a>
                                    </div>
                                    <div class="form-group">
                                        <label for="SiteName">目标位置配置</label>
                                        <?php if($asinconfig['targetPosition']){foreach ($asinconfig['targetPosition'] as $key=>$val){?>
                                            <div class="row">
                                                <div class="col-3"><input type="text" name="asinconfig[targetPosition][<?=$key?>][min]" class="form-control" value="<?= $val['min']?>" placeholder="最小值"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[targetPosition][<?=$key?>][max]" class="form-control" value="<?= $val['max']?>" placeholder="最大值"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[targetPosition][<?=$key?>][description]" class="form-control" value="<?= $val['description']?>" placeholder="说明"></div>
                                            </div>
                                        <?php }}else{?>
                                            <div class="row">
                                                <div class="col-3"><input type="text" name="asinconfig[targetPosition][0][min]" class="form-control" value="<?= $asinconfig['targetPosition'][0]['min']?>" placeholder="最小值"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[targetPosition][0][max]" class="form-control" value="<?= $asinconfig['targetPosition'][0]['max']?>" placeholder="最大值"></div>
                                                <div class="col-3"><input type="text" name="asinconfig[targetPosition][0][description]" class="form-control" value="<?= $asinconfig['targetPosition'][0]['description']?>" placeholder="说明"></div>
                                            </div>
                                        <?php }?>
                                        <a href="javascript:" class="plus" ><i class="fas fa-plus"></i></a>  <a href="javascript:" class="minus"><i class="fas fa-minus"></i></a>
                                    </div>
                                <div class="form-group">
                                    <label>垄断系数配置</label>
                                    <div class="row">
                                        <div class="col-2"><input type="text" name="asinconfig[monopoly][0]" class="form-control" value="<?= $asinconfig['monopoly'][0]?>" placeholder="非常高系数"></div>
                                        <div class="col-2"><input type="text" name="asinconfig[monopoly][1]" class="form-control" value="<?= $asinconfig['monopoly'][1]?>" placeholder="高系数"></div>
                                        <div class="col-2"><input type="text" name="asinconfig[monopoly][2]" class="form-control" value="<?= $asinconfig['monopoly'][2]?>" placeholder="中系数"></div>
                                        <div class="col-2"><input type="text" name="asinconfig[monopoly][3]" class="form-control" value="<?= $asinconfig['monopoly'][3]?>" placeholder="低系数"></div>
                                        <div class="col-2"><input type="text" name="asinconfig[monopoly][4]" class="form-control" value="<?= $asinconfig['monopoly'][4]?>" placeholder="非常低系数"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>相关性分数计算公式</label>
                                    <div class="row">
                                        <div class="col-6"><input type="text" name="asinconfig[formula][relatedScores]" class="form-control" value="<?= $asinconfig['formula']['relatedScores']?>" "><span>{rankstotal}上榜总数量，{rankstotalsort}有数据的自然排名总数值,{coefficient}上榜率系数{asintotal}ASIN总数</span></div>
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <label>总得分分数计算公式</label>
                                        <div class="row">
                                            <div class="col-12"><input type="text" name="asinconfig[formula][TotalScores]" class="form-control" value="<?= $asinconfig['formula']['TotalScores']?>" "><span>{traffic_score}流量得分,{successrate_score}机会得分,{searchesUp_score}搜索趋势得分{cpc_score}竞价得分{estimatedConversionRate_score}预估转化率得分{productionRatio_score}投产比得分{orderProportion_score}订单占比得分{coefficient}系数{related_coefficient}相关性系数</span></div>
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label>积分扣分数</label>
                                    <div class="row">
                                        <div class="col-2"><input type="text" name="point" class="form-control" value="<?= $point?>" placeholder="输入每次扣除的点数"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label>默认调取接口</label>
                                        <div class="row">
                                            <div class="col-2">
                                                <select  name="api" class="form-control">
                                                    <option value="jm" <?if($api=='jm'){?>selected <? }?>>极目+数派</option>
                                                    <option value="helium" <?if($api=='helium'){?>selected <? }?>>H10</option>
                                                </select></div>
                                        </div>
                                 </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-2"><button type="submit" class="btn btn-primary">保存</button></div>
                                            <div class="col-8"></div>
                                            <div class="col-2"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">另存方案</button></div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                    <table id="algorithm" class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>算法名称</th>
                                            <th>算法英文</th>
                                            <th>是否默认</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($list as $value){?>
                                            <tr>
                                                <td><?=$value['settingId']?></td>
                                                <td><?=$value['title']?></td>
                                                <td><?=$value['title_en']?></td>
                                                <td><?=$value['isDefault']==0?'否':'是'?></td>
                                                <td><a class="btn btn-default" href="<?= Url::to(['/madmin/setting/asinedit','id'=>$value['settingId']])?>">
                                                        <i class="fas fa-edit"></i> 编辑
                                                    </a>
                                                    <?if($value['isDefault']==0){?>
                                                    <a id="isdefault" data-id="<?=$value['settingId']?>" class="btn btn-default" href="<?= Url::to(['/madmin/setting/setdefault','id'=>$value['settingId']])?>">
                                                        <i class="fas fa-circle"></i> 设为默认
                                                    </a>
                                                    <? }?>
                                                    <a class="btn btn-default del_date" href="<?= Url::to(['/madmin/setting/asindel','id'=>$value['settingId']])?>" data-id="<?= $value['settingId']?>" >
                                                        <i class="fas fa-trash"></i> 删除
                                                    </a></td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
        </div>

        <!-- /.row -->
    </div><!-- /.container-fluid -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">算法方案</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>方案名称</label>
                        <div class="row">
                            <div class="col-6"><input type="text" id="title" name="title" class="form-control" value="" placeholder="输入方案名称"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>方案英文名称</label>
                        <div class="row">
                            <div class="col-6"><input type="text" id="title_en" name="title_en" class="form-control" value="" placeholder="请输入英文和数字"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary algorithm">保存方案</button>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<script>
    $(document).ready(function() {
        $(".plus").click(function() {
            // 找到最后一个等级（即最后一个.row元素）
            var lastLevel = $(this).siblings(".row").last();

            // 克隆最后一个等级
            var clonedLevel = lastLevel.clone(true); // 使用true来复制事件处理程序和数据

            // 在克隆的等级中更新 name 属性
            clonedLevel.find('[name]').each(function() {
                var name = $(this).attr('name');
                // 使用正则表达式提取 name 中的整个数字序列
                var match = name.match(/(\d+)/);
                if (match) {
                    // 如果找到数字，将其转换为整数并增加 1
                    var number = parseInt(match[0], 10) + 1;

                    // 更新元素的 name 属性
                    $(this).attr('name', name.replace(match[0], number));
                }
            });

            // 将克隆的等级追加到表格的末尾
            lastLevel.after(clonedLevel);

            // 清空克隆的等级中的输入框值（如果需要）
            clonedLevel.find('input').val('');
        });

        // 删除最后一行的功能
        $(".minus").click(function() {
            var lastrow = $(this).siblings(".row");
            var lastcount =lastrow.length;
            //console.log(lastcount)
            if (lastcount > 1) { // 确保至少有一行
                $(this).siblings(".row").last().remove(); // 删除最后一行
            } else {
                alert('不能删除最后一行！'); // 或者其他提示信息
            }
        });
        //保存方案
        $(".algorithm").click(function (event){
            event.preventDefault(); // 阻止表单的默认提交行为
            // 获取表单的数据
            var formData = $('#asin-form').serialize();
            // 获取额外的数据
            var title = $('#title').val();
            var title_en = $('#title_en').val();
            // 将额外的数据添加到表单数据中
            var postData = formData + '&title=' + encodeURIComponent(title)+ '&title_en=' + encodeURIComponent(title_en);
            $.ajax({
                type: "POST",
                url: "/madmin/setting/algorithm",
                data: postData,
                success: function(response){
                    if(response.code==0){
                        $('#exampleModalLong').modal('hide')
                        toastr.success(response.message);
                        return false;
                    }else{
                        console.log(response.code)
                        toastr.error(response.message);
                    }
                }
            })
        });
    });
</script>