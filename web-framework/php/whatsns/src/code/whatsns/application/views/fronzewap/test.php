<!--{template header}-->

<!--内容部分--->
<div class="content-body" style="margin-top:20px;">
<div class="container bg-white ">

<div class="row">

<div class="col-sm-24">
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
 
     {if $this->uri->segment ( 2 ) !='view'&&$this->uri->segment ( 1 )=='question'||$this->uri->segment ( 2 ) =='editxinzhi'}



      {if $navtitle=='编辑问题'}  {eval echo htmlspecialchars_decode(htmlspecialchars_decode($question['description']));} {/if}

             {if $this->uri->segment ( 1 )!='question'}
 {eval echo htmlspecialchars($topic['describtion']);}
             {/if}

           {if $user['groupid']==1||$user['uid']==$answer['authorid']&&$this->uri->segment ( 2 )=='editanswer'&&$this->uri->segment ( 1 )=='question'}    {eval echo htmlspecialchars($answer['content']);} {/if}
           {/if}
          {if $this->uri->segment ( 1 )=='question'&&$this->uri->segment ( 2 )=='add'}
{$setting['editor_defaulttip']}
{/if}
            </textarea>
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
	                         
	                  
	                          
	                           '|',
	                           'img',
	                       
	                        
	                           'undo',
	                           'redo',
	                           'fullscreen'     ];

		    // 将全屏时z-index修改为20000
		   // editor.config.zindex =-1;
	    editor.create();
	    $(".wangEditor-container").css("z-index","1");

	 
	   
	</script>
</div>

</div>


</div>

</div>

<!--{template footer}-->