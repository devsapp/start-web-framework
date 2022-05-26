<!--引入wangEditor.css-->
<link rel="stylesheet" type="text/css" href="{SITE_URL}static/js/wangeditor/pcwangeditor/css/wangEditor.min.css">



<!--引入jquery和wangEditor.js-->   <!--注意：javascript必须放在body最后，否则可能会出现问题-->
 <script src="{SITE_URL}static/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="{SITE_URL}static/js/wangeditor/pcwangeditor/js/wangEditor.js"></script>
<script>
$.noConflict()
</script>
<style>
	.editor_container {
			 
			height:auto; 
			
			background-color: #fff;
			text-align: left;
		
			text-shadow: none; 
            margin:10px 10px;
		}
		.wangEditor-drop-panel{
			left:0px;
		margin-left:0px;
		width:100%;
		     
}
</style>
<div class="editor_container">
  <textarea  id="editor" name="content"  style="width:100%;height:100px;">
 
     {if $this->uri->segment ( 2 )!='view'&&$this->uri->segment ( 1 )=='question'||$this->uri->segment ( 2 )=='editxinzhi'}


           {if $navtitle=='编辑问题'}  {eval echo htmlspecialchars_decode(htmlspecialchars_decode($question['description']));} {/if}

             {if $this->uri->segment ( 1 )!='question'}
  {eval echo  replacewords($topic['describtion']);}
             {/if}
           {if $user['groupid']==1||$user['uid']==$answer['authorid']&&$this->uri->segment ( 2 )=='editanswer'&&$this->uri->segment ( 1 )=='question'}    {eval  echo htmlspecialchars_decode($answer['content']);} {/if}

 {/if}
            </textarea>
            <div style="margin:10px auto;position:relative;">
            <input id="upvedio" type="file" onchange="uploadVedio(this)" accept="video/*"  style="position:absolute;width:70px;left:0px;top:3px;cursor:pointer;opacity:0;">
	<span style="color:#0084ff;font-size: 13px;" class="uploadvedio">本地上传视频</span>
	</div>
</div>
<script type="text/javascript">
var testeditor='999';
var editor=null;


		// 初始化编辑器的内容
		   editor = new wangEditor('editor');
		// 自定义配置
			editor.config.uploadImgUrl = "{url attach/upimg}" ;
			editor.config.uploadImgFileName = 'wangEditorMobileFile';
			// 阻止输出log
		    	editor.config.printLog = true;
		
		    	editor.config.hideLinkImg = true;
			  // 普通的自定义菜单
		    // 普通的自定义菜单
    editor.config.menus = [
                       
	                          	                          
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
		 
	    editor.create();
	    $(".wangEditor-container").css("z-index","1");
	    $(".wangEditor-txt").css("height","auto");
	    function uploadVedio(file){
	    	
	   	 if (file.files && file.files[0])
	        {
	
	   	     $(".uploadvedio").html("视频上传中....");
	   		 $("#upvedio").attr("disabled","disabled");
	   		  var type = "file";
	   		  var ischeck=0;
	   		
	   		    var formData = new FormData();
	   		    formData.append(type, $("#upvedio")[0].files[0]);
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
	   	            	 $(".uploadvedio").html("本地上传视频");
	   	            	 $("#upvedio").removeAttr("disabled");
	   	                 removeajaxloading();
	   	              },
	   	             //调用出错执行的函数
	   	             error: function(){
	   	              removeajaxloading();
	   	            	 $("#upvedio").removeAttr("disabled");
	   	                 //请求出错处理
	   	            	 alert("上传出错");
	   	             }
	   		    });
	        }
	   }
	   
	</script>
	