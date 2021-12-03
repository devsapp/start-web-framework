<!--{template header}-->
<SCRIPT src="{SITE_URL}static/js/admin.js" type="text/javascript"></SCRIPT>
<link href="{SITE_URL}static/css/admin/main.css" rel="stylesheet" type="text/css" />

<div id="append">
</div>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;">
      <a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;当前模板:{$dir}>{$dir_file}


  </div>

</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
<form action="index.php?admin_template/editdirfile/{$dir}/{$dir_file}" onsubmit="return setcode()" method="post">
<input type="hidden" name="dir" value="{$dir}" />
    <input type="hidden" name="dir_file" value="{$dir_file}" />
    <input type="hidden" id="tpl_content" name="tpl_content" value="" />
			<table class="table">
				<tr class="header">
					<td colspan="2">模板信息&nbsp;&nbsp;&nbsp;&nbsp;  <input type="button" class="button" name="quxiao" value="返回上一页" onclick="redirect()" ></td>
				</tr>
				<tr>
					<td >

                         
                          <pre>
                <code class="language-html" id="codefromadmin">
                {if $_POST}
                   <div contenteditable="true" style="width:100%;padding:10px;">{eval echo htmlspecialchars($tpl_content);}</div>                                     
               {else}
                  <div contenteditable="true" style="width:100%;padding:10px;">{$tpl_content}</div>                             
               {/if}
               </code>
               </pre>
                          
					</td>
				</tr>
</table>
			<br />
			<center><input type="submit" class="button" name="submit" value="提 交">

            &nbsp;<input type="button" class="button" name="quxiao" value="取消" onclick="window.history.go(-1)">
            </center><br>
		</form>
<br />
   <link rel="stylesheet" type="text/css" href="{SITE_URL}static/js/neweditor/code/styles/tomorrow-night-eighties.css">
    <script src="{SITE_URL}static/js/neweditor/code/highlight.pack.js" type="text/javascript"></script>
<script>hljs.initHighlightingOnLoad();</script>

<script>
    function setcode(){
        var _html='';
    	  document.querySelectorAll('pre code').forEach((block) => {
        	  var _tmptext=$.trim($(block).text());
        	  if(_tmptext!=''){
        		  _html=_html+_tmptext;
        		  console.log(_html);
        	  }
    		 
    		  
    		 
      	  });
    	  $("#tpl_content").val(_html);

    }
    function redirect() {
        var dirfileurl=g_site_url+"index.php?admin_template/default/"+"{$dir}"+"{$setting['seo_suffix']}";
        window.location.href=dirfileurl;
    }
</script>
<!--{template footer}-->