
<div class="editor_container">
  <textarea  id="freeconent" name="freeconent"  style="width:100%;height:100px;">
  {$topic['freeconent']}
            </textarea>
            <div style="margin:10px auto;position:relative;">
            <input id="freeupvedio" type="file" onchange="freeuploadVedio(this)" accept="video/*" capture="camcorder" style="position:absolute;width:70px;left:0px;top:3px;cursor:pointer;opacity:0;">
	<span style="color:#0084ff;font-size: 13px;" class="freeuploadvedio">本地上传视频</span>
	</div>
</div>
<script type="text/javascript">
var freeconent=null;


		// 初始化编辑器的内容
		   freeconent = new wangEditor('freeconent');
		// 自定义配置
			freeconent.config.uploadImgUrl = "{url attach/upimg}" ;
			freeconent.config.uploadImgFileName = 'wangEditorMobileFile';
			// 阻止输出log
		    	freeconent.config.printLog = true;
		
		    	freeconent.config.hideLinkImg = true;
			  // 普通的自定义菜单
		    // 普通的自定义菜单
    freeconent.config.menus = [
                       
	                          	                          
	                           'eraser',
	                     
	                           'quote',
	                           'emotion',	                 	                          
	                           '|',
	                           'img',
	                       
	                        
	                           'undo',
	                           'redo',
	                           'fullscreen'     ];

		    // 将全屏时z-index修改为20000
		   // editor.config.zindex =-1;
		 
	    freeconent.create();
	    function freeuploadVedio(file){
	    	
	   	 if (file.files && file.files[0])
	        {
	
	   	     $(".freeuploadvedio").html("视频上传中....");
	   		 $("#freeupvedio").attr("disabled","disabled");
	   		  var type = "file";
	   		  var ischeck=0;
	   		
	   		    var formData = new FormData();
	   		    formData.append(type, $("#freeupvedio")[0].files[0]);
	   		 formData.append("addvedio",0);
		
	   	  
	   		    $.ajax({
	   		        type: "POST",
	   		        url: '{url attach/uploadvedio}',
	   		        data: formData,
	   		        processData: false,
	   		        contentType: false,
	   		        //返回数据的格式
	   	            datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
	   	            beforeSend: function () {

	   	                ajaxloading("提交中...");
	   	             },
	   		        success: function (data) {
	   		    
	   		     	var data=eval("("+data+")");
	   			        if(data.code==200){
	   			         var _strinfo=data.fileurl;
	   			        
	   			   	  $(".wangEditor-txt").append(	'<video style="max-width:100%;" controls>	    <source src="'+_strinfo+'" type="video/mp4"> 	  </video>');
	   			   
	   			        }else{
	   			        	alert(data.msg)
	   			        }
	   			        
	   		        
	   		          
	   		        },
	   	             complete: function () {
	   	            	 $(".freeuploadvedio").html("本地上传视频");
	   	            	 $("#freeupvedio").removeAttr("disabled");
	   	                 removeajaxloading();
	   	              },
	   	             //调用出错执行的函数
	   	             error: function(){
	   	              removeajaxloading();
	   	            	 $("#freeupvedio").removeAttr("disabled");
	   	                 //请求出错处理
	   	            	 alert("上传出错");
	   	             }
	   		    });
	        }
	   }
	   
	</script>
	