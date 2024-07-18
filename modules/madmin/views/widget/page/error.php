<?php if(!empty($errmsg)){ ?>
    <?php $this->beginBlock('errscript'); ?>
    <script>
        toastr.error($errmsg);
    </script>
    <?php $this->endBlock(); ?>
<?php }?>