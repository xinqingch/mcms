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
                                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Ai配置</a>
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
                                        <label>Azure OPENAI接口</label>
                                        <div class="row">
                                            <div class="col-12">
                                                <label>终结点（即API地址）:</label>
                                                <input type="text" name="openaiapi[apiurl]" class="form-control" value="<?= $openaiapi['apiurl']?>" placeholder="请填写终结点（即API地址）" >
                                                <span></span>
                                            </div>
                                            <div class="col-12">
                                                <label>密 钥:</label>
                                                <input type="text" name="openaiapi[apikey]" class="form-control" value="<?= $openaiapi['apikey']?>" placeholder="请填写密钥">

                                            </div>
                                            <div class="col-12">
                                                <label>部署名:</label>
                                                <input type="text" name="openaiapi[apiname]" class="form-control" value="<?= $openaiapi['apiname']?>" placeholder="请填写部署名">

                                            </div>
                                            <div class="col-12">
                                                <label>模型:</label>
                                                <input type="text" name="openaiapi[apimodel]" class="form-control" value="<?= $openaiapi['apimodel']?>" placeholder="请填写模型">
                                                <span>部署使用的OPENAPI模型，例如gpt-35-turbo</span>
                                            </div>
                                            <div class="col-12">
                                                <label>请填写模型版本:</label>
                                                <input type="text" name="openaiapi[apiversion]" class="form-control" value="<?= $openaiapi['apiversion']?>" placeholder="请填写模型版本">
                                                <span> 所有版本都遵循 YYYY-MM-DD 日期结构，例如2024-02-01，详细<a href="https://learn.microsoft.com/zh-cn/azure/ai-services/openai/reference" target="_blank">查看官网</a></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Gemin接口</label>
                                        <div class="row">
                                            <div class="col-12">
                                                <label>API地址:</label>
                                                <input type="text" name="geminapi[apiurl]" class="form-control" value="<?= $geminapi['apiurl']?>" placeholder="请填写API地址" >
                                                <span></span>
                                            </div>
                                            <div class="col-12">
                                                <label>密 钥:</label>
                                                <input type="text" name="geminapi[apikey]" class="form-control" value="<?= $geminapi['apikey']?>" placeholder="请填写密钥">

                                            </div>
                                            <div class="col-12">
                                                <label>模型:</label>
                                                <input type="text" name="geminapi[apimodel]" class="form-control" value="<?= $geminapi['apimodel']?>" placeholder="请填写模型">
                                                <span>部署使用的Gemin模型，例如gemini-1.5-flash-latest</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>文案调取接口</label>
                                        <div class="row">
                                            <div class="col-2">
                                                <select  name="aiapi" class="form-control">
                                                    <option value="openai" <?if($aiapi=='openai'){?>selected <? }?>>Openai</option>
                                                    <option value="gemin" <?if($aiapi=='gemin'){?>selected <? }?>>Gemin</option>
                                                </select></div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-2"><button type="submit" class="btn btn-primary">保存</button></div>
                                            <div class="col-8"></div>
                                        </div>

                                    </div>
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

    });
</script>