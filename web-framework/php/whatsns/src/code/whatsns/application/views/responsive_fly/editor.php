{if $setting['editor_choose']==0}

<!--引入wangEditor.css-->
<link rel="stylesheet" type="text/css" href="{SITE_URL}static/js/wangeditor/pcwangeditor/css/wangEditor.min.css">



<!--引入jquery和wangEditor.js-->   <!--注意：javascript必须放在body最后，否则可能会出现问题-->

<script type="text/javascript" src="{SITE_URL}static/js/wangeditor/pcwangeditor/js/wangEditor.js"></script>

  <textarea  id="editor" name="content"   style="width:100%;height:200px;">
  {if $this->uri->segment ( 2 )!='view'&&$this->uri->segment ( 1 )=='question'||$this->uri->segment ( 2 )=='editxinzhi'}


           {if $navtitle=='编辑问题'}  {$question['description']} {/if}

             {if $this->uri->segment ( 1 )!='question'}
  {eval echo  replacewords($topic['describtion']);}
             {/if}
           {if $user['groupid']==1||$user['uid']==$answer['authorid']&&$this->uri->segment ( 2 )=='editanswer'&&$this->uri->segment ( 1 )=='question'}  {eval echo $answer['content'];} {/if}

 {/if}
            </textarea>
<script type="text/javascript">


var isueditor=0;
	// 初始化编辑器的内容
	  var editor = new wangEditor('editor');
	// 自定义配置
		editor.config.uploadImgUrl = g_site_url+"index.php?attach/upimg" ;
		editor.config.uploadImgFileName = 'wangEditorMobileFile';
		// 阻止输出log
	    wangEditor.config.printLog = false;
		  // 普通的自定义菜单
	    editor.config.menus = [

{$setting['editor_wtoolbars']}
	     ];
	    // 将全屏时z-index修改为20000
	   // editor.config.zindex =-1;
    editor.create();
$(".wangEditor-container").css("z-index","1");
{if !$user['uid']}
editor.disable();
{/if}

</script>
{else}
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.config.js"></script>
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.all.js"></script>
<script type="text/plain" id="editor"  name="content"  style="width:100%;height:200px;">{if $this->uri->segment ( 2 )!='view'&&$this->uri->segment ( 1 )=='question'||$this->uri->segment ( 2 )=='editxinzhi'}{if $navtitle=='编辑问题'}{$question['description']} {/if}{if $this->uri->segment ( 1 )!='question'}{eval echo  replacewords($topic['describtion']);}{/if}{if $user['groupid']==1||$user['uid']==$answer['authorid']&&$this->uri->segment ( 2 )=='editanswer'&&$this->uri->segment ( 1 )=='question'}{eval echo $answer['content'];}{/if}{/if}</script>                                 
<script type="text/javascript">
                                 var isueditor=1;
            var editor = UE.getEditor('editor',{
                //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
                toolbars:[[{$setting['editor_toolbars']}]],
            
                initialContent:'',
                //关闭字数统计
                wordCount:false,
                zIndex:2,
                //关闭elementPath
                elementPathEnabled:false,
                //默认的编辑区域高度
                initialFrameHeight:250
                //更多其他参数，请参考ueditor.config.js中的配置项
                //更多其他参数，请参考ueditor.config.js中的配置项
            });
            {if !$user['uid']}
            editor.ready(function() {
            	editor.setDisabled();
            	});
            {/if}
        </script>


{/if}