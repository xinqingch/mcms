<!-- DataTables -->
<link rel="stylesheet" href="/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="/AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- DataTables  & Plugins -->
<script src="/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/AdminLTE/plugins/jszip/jszip.min.js"></script>
<script src="/AdminLTE/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/AdminLTE/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/AdminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
    $(function () {

        $('<?= $classid?>').DataTable({
            "bProcessing":true,
            "serverSide": true,
            ajax: {
                "url":"<?= $ajaxurl?>",
                "data":function(d){    //额外传递的参数
                    //return $.extend( {}, d, {
                    //    "phone": ""
                    //} );
                }
            },
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "bStateSave": true,//状态保存
            "aLengthMenu" : [20, 30, 50, 100, 150],
            "order": [[ 0, "desc" ]],
            'iDisplayLength': 100, //每页初始显示100条记录
            "oLanguage": {//国际化配置
                "sProcessing": "正在加载中......",
                "sLengthMenu": "每页显示 _MENU_ 条记录",
                "sZeroRecords": "对不起，查询不到相关数据！",
                "sEmptyTable": "表中无数据存在！",
                "sInfo": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条记录",
                "sInfoFiltered": "数据表中共为 _MAX_ 条记录",
                "infoEmpty": "没有数据",
                "sSearch": "搜索",
                "oPaginate": {
                    "sFirst": "首页",
                    "sPrevious": "上一页",
                    "sNext": "下一页",
                    "sLast": "末页"
                }
            },
            createdRow: function ( row, data, index ) {
                $(row).addClass('text-c');
                $('#count').html(data.recordsFiltered);
            },
            aoColumns:[
                //复选框（通过render渲染复选框）
                {
                    "data": null,
                    "bSortable": false,
                    render: function (data, type, full, meta) {
                        var node = '';
                        node = '<input class="checkchild" name="ids"  value=\"'+full.id+'\" type="checkbox"/>';
                        return node;
                    }
                },
                {
                    "data": "id",
                },
                {
                    "data": "phone",
                    "render": function (data, type, full, meta) {
                        return '<p class="hiddentext"> ' + data + '</p>';
                    },
                },
                {
                    "data": "username",
                    "render": function (data, type, full, meta) {
                        return '<p class="hiddentext">' + data + '</p>';
                    },
                },
                {
                    "data": "inputtime",
                    "render": function (data, type, full, meta) {
                        return '<p class="hiddentext">' + data + '</p>';
                    },
                },
                {
                    "data": "exptime",
                    "render": function (data, type, full, meta) {
                        return '<p class="hiddentext">' + data + '</p>';
                    },
                },
                {
                    "sClass": "text-center",
                    "data": "id",
                    "render": function (data, type, full, meta) {
                        html = '<a class="btn btn-default" href="/madmin/<?=$modules?>/edit?id='+ data +'"><i class="fas fa-edit"></i> 编辑</a>  ';
                        html += '<a class="btn btn-default del_date" href="/madmin/<?=$modules?>/delete?id='+ data +'"  ><i class="fas fa-trash"></i> 删除</a>';
                        return html;
                    },
                    "bSortable": false
                }
            ]

        });
        //var buttonhtml = '<button type="button" class="btn btn-default btn-sm" id="delallinfo">批量删除</button>';
        //$(buttonhtml).appendTo('#example1_wrapper .col-md-6:eq(0)');
        //点击全选按钮
        $('.checkall').on('click', function () {
            //我的需求是要把全选选中的相关内容的id以数组的形式传给后端。在点击全选之前先初始化一下数组
            this.idList=[]
            //如果全选框时选中状态
            if($(this).prop('checked')) {
                //则它下面的复选框为选中状态
                $(".checkchild").prop("checked", true);
                //声明选中的复选框，并遍历
                var allChecked = $('.checkchild:checked');
                for(var i= 0;i<allChecked.length;i++){
                    //因为传给后端的数据id具有唯一性，所以只要保证数组不重复，
                    //就可以保证在先点击其下复选框再点击全选按钮的时候id被重复添加进数组中的问题
                    if(this.idList.indexOf($(allChecked[i]).val())==-1){
                        this.idList.push($(allChecked[i]).val())
                    }
                }
                console.log(this.idList)
            } else {
                //如果全选框为非选中状态时，其下的复选框全部变为非选中状态
                $(".checkchild").prop("checked", false);
                //并把原数组清空
                this.idList=[]
            }
        });

        /* 批量删除 */
        /*$('#delallinfo').click(function() {
            if ($("input[name='ids']:checked")[0] == null) {
                alert("请选择需要删除的信息");
                return;
            }
            if (confirm("确认删除吗？")) {

                var ids = new Array;
                $("input[name='ids']:checked").each(function() {
                    ids.push($(this).val());
                    n = $(this).parents("tr").index() + 1; // 获取checkbox所在行的顺序
                    $("table#dataTable").find("tr:eq(" + n + ")").remove();
                });

                $.ajax({
                    url : "/madmin/<?=$modules?>/ajaxdel",
                    data : "ids=" + ids,
                    type : "post",
                    dataType : "json",
                    success : function(data) {
                        if(data.code==0){
                            window.location.reload();
                        }else{
                            if(confirm(data.result)){
                                window.location.reload();
                            };
                        }

                    }
                });
            }
        })*/
    });
</script>