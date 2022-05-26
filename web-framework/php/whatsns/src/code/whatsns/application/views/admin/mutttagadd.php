<!--{template header}-->
<SCRIPT src="{SITE_URL}static/js/admin.js" type="text/javascript"></SCRIPT>
<SCRIPT src="{SITE_URL}static/js/calendar.js" type="text/javascript"></SCRIPT>
<div id="append">
</div>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;添加标签信息</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
<a class="btn" href="{url admin_tag}">返回标签列表</a>
<form  onsubmit="return checktag()" method="post" enctype="multipart/form-data" style="margin-top: 20px;">
        <div class="alert alert-warning">标签一行一个，会自动过滤同名标签，自动生成对应的拼音和首字母。一次最多200个标签，否则会处理超时。</div>
		<textarea style="width: 30%;height:200px;" id="mytag"></textarea>
			<br />
			<button type="submit" class="button" name="submit" style="margin-top: 20px;">提交</button><br>
		</form>
<br />
<script type="text/javascript">
function checktag(){

var txt=$.trim($("#mytag").val());
if(txt==''){

	alert("请输入标签，一行一个");
	return false;
}
var data={txttag:txt};
function success(result){
	$("#mytag").val(result.message)
}
var _url="{url admin_tag/postmutttag}";
ajaxpost(_url,data,success);
	
	return false;
}
$(".tagaliascheck").click(function(){
	var _tagalias=$.trim($("#tagalias").val());

 if(_tagalias==''){
alert("别名不能为空");
return false;
 }

	var data={tagalias:_tagalias};
	var url="{url admin_tag/checktagbyalias}";
	function success(message){
      if(message=="0"){
alert("别名可用");return false;
      }
      if(message=="1"){
    	  alert("别名不可用，已存在！");return false;
    	        }
	}
	ajaxpost(url,data,success);
});
$(".tagnamecheck").click(function(){
	var _tagname=$.trim($("#tagname").val());

 if(_tagname==''){
alert("标签名称不能为空");
return false;
 }

	var data={tagname:_tagname};
	var url="{url admin_tag/checktagbyname}";
	function success(message){
      if(message=="0"){
alert("标签名称可用");return false;
      }
      if(message=="1"){
    	  alert("标签名称不可用，已存在！");return false;
    	        }
	}
	ajaxpost(url,data,success);
});

</script>
<!--{template footer}-->