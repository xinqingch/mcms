/**
 * 文件上传js插件
 * 
 */
/*

//用法一
<div class="uploadimg">
	<img id="img1" src="<?php if(!empty($model->ztr_pic)){echo $model->ztr_pic;}else{echo "/images/pro_img.jpg";}?>" alt="" />
</div>
<p class="mt10">
	<?php echo CHtml::link('上传图片<b class="mem_bgx left"></b><b class="mem_bgx right"></b>'.CHtml::fileField('image','',array('id'=>'uploadimg1','multiple'=>true)),'javascript:',array('class'=>'mem_bgx link_btn filelink mr20','onclick'=>"uploadimg('1')"))?>
	<?php echo $form->hiddenField($model,'ztr_pic',array('id'=>'proimage1'))?>	
</p>	
<script src="<?php echo Yii::app()->baseUrl;?>/js/upload_img.js"></script>


//用法二
<img id="img1" src="<?php if(!empty($model->ztr_pic)){echo $model->ztr_pic;}else{echo "/images/pro_img.jpg";}?>" alt="" />
<?php echo CHtml::link('上传图片<b class="mem_bgx left"></b><b class="mem_bgx right"></b>'.CHtml::fileField('image','',array('id'=>'uploadimg1','multiple'=>true)),'javascript:',array('class'=>'mem_bgx link_btn filelink mr20','onclick'=>"uploadimg('1')"))?>
<?php echo $form->hiddenField($model,'ztr_pic',array('id'=>'proimage1'))?>	

<script src="<?php echo Yii::app()->baseUrl;?>/js/upload_img.js"></script>
*/			


//载入基本模型
document.write("<script type=\"text/javascript\" src=\"/js/jquery.ui.widget.js\"></script>");
document.write("<script type=\"text/javascript\" src=\"/js/jquery.iframe-transport.js\"></script>");
document.write("<script type=\"text/javascript\" src=\"/js/jquery.fileupload.js\"></script>");

var xhrOnProgress=function(fun) {
	xhrOnProgress.onprogress = fun; //绑定监听
	//使用闭包实现监听绑
	return function() {
		//通过$.ajaxSettings.xhr();获得XMLHttpRequest对象
		var xhr = $.ajaxSettings.xhr();
		//判断监听函数是否为函数
		if (typeof xhrOnProgress.onprogress !== 'function')
			return xhr;
		//如果有监听函数并且xhr对象支持绑定时就把监听函数绑定上去
		if (xhrOnProgress.onprogress && xhr.upload) {
			xhr.upload.onprogress = xhrOnProgress.onprogress;
		}
		return xhr;
	}
}
//上传图片,增加删除按钮
function uploadimg (id) {
		//上传图片
	   $('#uploadimg'+id).fileupload({         	
	        dataType: 'json',       
	        url: '/v1/upfiles',
	        beforeSend: function() {
	        	$('#img'+id).attr('src','/images/loading100.gif');
	        },
		   cache: false,//上传文件无需缓存
		   processData: false,//用于对data参数进行序列化处理 这里必须false
		   contentType: false, //必须
		   xhr:xhrOnProgress(function(e){
			   var percent=e.loaded/e.total*100;
			   $('.upprogress'+id).attr('style', 'width:'+percent+"%");
		   }),
	        success: function (data) {
	               if(data.errno >'0'){
	               		alert(data.errstr);
	               }else{
		                 //修改图片地址
		            	 $('#img'+id).attr('src','/'+data.result.url);
						 //修改按钮文本
		            	 $('#uploadimg'+id).parent().html('\n' +
                             '                                <i class="fas fa-edit"></i>修改图片<input class="btn btn-block btn-default filelink" type="file" class="custom-file-input" id="uploadimg'+id+'" multiple name="image" onclick="uploadimg('+id+')"/>');
                       /*var btnclass = $('#uploadimg'+id).parent().attr('class');
                       //加判断，防止重复增加上删除按钮
                     /*if($('#uploadimg'+id).parent().next('.del').length==0){
                       //填加删除按钮
                           $('#uploadimg'+id).parent().after('<a class="'+btnclass+' am-btn am-btn-danger am-btn-sm " href="javascript:" onclick="removeimg(\''+id+'\')"><i class="am-icon-repeat"></i>删除图片</a>')
                       }*/
		            	 //修改隐藏域值
	               		 $('#proimage'+id).attr('value','/'+data.result.url);
	               } 	
	        }
	    });
};
function moreuploadimg (id) {
	//上传图片
	$('#uploadimg'+id).fileupload({
		dataType: 'json',
		url: '/v1/upfiles',
		beforeSend: function() {
			$('#img'+id).attr('src','/images/loading100.gif');
		},
		cache: false,//上传文件无需缓存
		processData: false,//用于对data参数进行序列化处理 这里必须false
		contentType: false, //必须
		xhr:xhrOnProgress(function(e){
			var percent=e.loaded/e.total*100;
			$('.upprogress'+id).attr('style', 'width:'+percent+"%");
		}),
		success: function (data) {
			if(data.errno >'0'){
				alert(data.errstr);
			}else{
				var preview = $('#imagePreview');
				//preview.empty();
				preview.append('<img src="/' + data.result.url + '" style="max-width: 100px; max-height: 100px; margin: 5px;">');
				preview.append('<input type="hidden" name="images[]" value="/' + data.result.url + '" >');
			}
		}
	});
};

function uploadfile(id) {
	//上传图片
	$('#uploadfile'+id).fileupload({
		dataType: 'json',
		url: '/v1/upfiles',
		cache: false,//上传文件无需缓存
		processData: false,//用于对data参数进行序列化处理 这里必须false
		contentType: false, //必须
		xhr:xhrOnProgress(function(e){
			var percent=e.loaded/e.total*100;
			$('.upprogress'+id).attr('style', 'width:'+percent+"%");
			$('.upnum'+id).text(parseInt(percent)+"%");
		}),
		success: function (data) {
			if(data.errno >'0'){
				alert(data.errstr);
			}else{
				//修改图片地址
				///$('#file'+id).attr('src','/'+data.result.url);
				//修改按钮文本
				$('#uploadfile'+id).parent().html('\n' +
					'                                <i class="fas fa-edit"></i>上传报告<input class="btn btn-block btn-default filelink" type="file" class="custom-file-input" id="uploadfile'+id+'" multiple name="upFile" onclick="uploadfile('+id+')"/>');
				/*var btnclass = $('#uploadimg'+id).parent().attr('class');
                //加判断，防止重复增加上删除按钮
              /*if($('#uploadimg'+id).parent().next('.del').length==0){
                //填加删除按钮
                    $('#uploadimg'+id).parent().after('<a class="'+btnclass+' am-btn am-btn-danger am-btn-sm " href="javascript:" onclick="removeimg(\''+id+'\')"><i class="am-icon-repeat"></i>删除图片</a>')
                }*/
				//修改隐藏域值
				$('#profile'+id).attr('value','/'+data.result.url);
			}
		}
	});
};

//上传图片，不需要删除按钮
function uploadimg_0 (id) {
		//上传图片
	   $('#uploadimg'+id).fileupload({         	
	        dataType: 'json',       
	        url: '/v1/upfiles',
	        beforeSend: function() {
	        	$('#img'+id).attr('src','/images/loading100.gif');
	        },
	        success: function (json) {
	               if(json.upfile.errors=='1'){
	               		alert(json.upfile.msg);
	               }else if(json.upfile.errors=='2'){
	               		alert(json.upfile.msg);
	               }else{
		           		//如果是替换图片，上传功能后删除原来的文件
		           		if($('#proimage'+id).val().length>0){
		           			$.ajax({
		           				   type: "DELETE",
		           				   url: "/v1/upfile",
		           				   data: "url="+$('#proimage'+id).val(),
		           				   success: function(msg){
		           					   return;
		           				   }
		           			});
		           		}
		                 //修改按钮图标
		            	 $('#img'+id).attr('src',json.upfile.file);
						 //修改按钮文本
		            	 $('#uploadimg'+id).parent().html('修改图片<b class="mem_bgx left"></b><b class="mem_bgx right"></b><input type="file" id="uploadimg'+id+'" multiple name="image"/>');
						 //修改隐藏域值
	               		 $('#proimage'+id).attr('value',json.upfile.file);
	               		 $('#proimgid'+id).attr('value',json.upfile.zat_id);
	               } 	
	        }
	    });
};

//上传图片，增加删除按钮，---预览图片按钮 ,预览暂时不用，按钮文本简化
function uploadimg_2 (id) {
		//上伟图片
	   $('#uploadimg'+id).fileupload({
	        dataType: 'json',
	        url: '/gqjadm/upload/create',
	        beforeSend: function() {
	        	$('#img'+id).attr('src','/images/loading100.gif');
	        },
	        success: function (json) {
	               if(json.upfile.errors=='1'){
	               		alert(json.upfile.msg);
	               }else if(json.upfile.errors=='2'){
	               		alert(json.upfile.msg);
	               }else{
		           		//如果是替换图片，上传功能后删除原来的文件
		           		if($('#proimage'+id).val().length>0){
		           			$.ajax({
		           				   type: "GET",
		           				   url: "/gqjadm/upload/delImg",
		           				   data: "url="+$('#proimage'+id).val(),
		           				   success: function(msg){
		           					   return;
		           				   }
		           			});
		           		}
		           		//修改按钮图标
		            	 $('#img'+id).attr('src',json.upfile.file);
	            	   	 var btnclass = $('#uploadimg'+id).parent().attr('class');
	            	   	 //加判断，防止重复增加上查看按钮
	           /* 	   	if($('#uploadimg'+id).parent().prev('.view').length==0){
	            	   		//查看图片
	            	   		$('#uploadimg'+id).parent().before('<a class="'+btnclass+' view" href="javascript:" onclick="showimg(\''+id+'\')">查看<b class="mem_bgx left"></b><b class="mem_bgx right"></b></a>');
	            	   	}*/
		            	 //修改按钮文本
		            	 $('#uploadimg'+id).parent().html('修改<b class="mem_bgx left"></b><b class="mem_bgx right"></b><input type="file" id="uploadimg'+id+'" multiple name="image"/>');
		            	 //加判断，防止重复增加上查看按钮
		            	 if($('#uploadimg'+id).parent().next('.del').length==0){
			            	 //填加删除按钮
			            	 $('#uploadimg'+id).parent().after('<a class="'+btnclass+' del" href="javascript:" onclick="removeimg(\''+id+'\')">删除<b class="mem_bgx left"></b><b class="mem_bgx right"></b></a>');
		            	 }
		            	 //修改隐藏域值
	               		 $('#proimage'+id).attr('value',json.upfile.file);
	               }
	        }
	    });
};


//删除图片
function removeimg(id){
	//修改上传按钮文本
	$('#uploadimg'+id).parent().html('上传图片<b class="mem_bgx left"></b><b class="mem_bgx right"></b><input type="file" id="uploadimg'+id+'" multiple name="image"/>');
	//删除“删除”按钮
	$('#uploadimg'+id).parent().next('.del').remove();
	//删除“预览按钮
	$('#uploadimg'+id).parent().prev('.view').remove();
	//删除图片显示
	$('#img'+id).attr('src','/images/pro_img.jpg');
	//删除文件
	$.ajax({
		   type: "GET",
		   url: "/gqjadm/upload/delImg",
		   data: "url="+$('#proimage'+id).val(),
		   success: function(msg){
			   return;
		   }
	});
	//清空隐藏值域
	$('#proimage'+id).attr('value','');
	$('#proimgid'+id).attr('value','');
}

//显示图片
function showimg(id){
	var url = $('#proimage'+id).val();
	art.dialog({
			title:'规格图片',
			content: '<img class="w_180" src="'+url+'" />'
	});
}