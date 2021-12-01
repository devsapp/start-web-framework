<!--{template header}-->
<SCRIPT src="{SITE_URL}static/js/admin.js" type="text/javascript"></SCRIPT>
<SCRIPT src="{SITE_URL}static/js/calendar.js" type="text/javascript"></SCRIPT>
<div id="append">
</div>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;编辑标签信息</div>
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
<form action="{url admin_tag/edit/$tagalias}" method="post" enctype="multipart/form-data">
<input type="hidden" name="uid" value="{$member['uid']}" />
			<table class="table">
				<tr class="header">
					<td colspan="2">标签信息</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>标签名称(必填):</b><br><span class="smalltxt">可修改</span></td>
					<td class="altbg2">
					<input type="hidden" id="sourcetagname" value="{$tag['tagname']}" >
					<input class="text" value="{$tag['tagname']}" id="tagname" name="tagname">(必填，唯一)<span class="tagnamecheck" style="color:red;cursor:pointer;margin-left:10px;">点击标签名称重复冲突检测</span></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>标签别名(必填):</b><br><span class="smalltxt">英文名称或者拼音，一般不要修改，否则影响seo</span></td>
					<td class="altbg2">
					<input type="hidden" id="sourcetagalias" value="{$tag['tagalias']}" >
					<input class="text" placeholder="英文/拼音，禁止中文" type="text" id="tagalias" name="tagalias" value="{$tag['tagalias']}">(必填，唯一) <span class="tagaliascheck" style="color:red;;cursor:pointer;margin-left:10px;">点击别名重复冲突检测</span></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>seo标签标题(必填):</b><br><span class="smalltxt">seo优化使用，将会显示在页面head的title标签里</span></td>
					<td class="altbg2"><input class="text"  style="width:500px " type="text"  name="title" value="{$tag['title']}">(必填)</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>seo标签描述:</b><br><span class="smalltxt">seo优化使用，将会显示在页面head的describtion标签里</span></td>
					<td class="altbg2"><textarea class="textarea"  style="width:500px;height:100px; " cols="50" rows="2" name="description">{$tag['description']}</textarea></td>
				</tr>
				
					<tr>
					<td class="altbg1" width="45%"><b>seo标签关键词:</b><br><span class="smalltxt">seo优化使用，将会显示在页面head的keyword标签里,英文逗号分开关键词</span></td>
					<td class="altbg2"><input class="" style="width:500px " type="text"  name="keywords" value="{$tag['keywords']}"></td>
				</tr>
				        <tr>
            <td class="altbg1"><b>tag标签封面图:</b><br><span class="smalltxt">上传专栏封面图，大小不小于200*200合适最佳,jpg,png格式图片</span></td>
            <td class="altbg2" colspan="2">

                        {if $tag['tagimage']==""||$tag['tagimage']==null}
                         <img src="{SITE_URL}static/images/defaulticon.jpg" style="width:80px;height:80px;">
                         {else}
                             <img src="{$tag['tagimage']}" style="width:80px;height:80px;">
                         {/if}



                         </p>
                         <input type="file" id="file_upload" name="tagimage">

            </td>
        </tr>
			</table>
			<br />
			<center><input type="submit" class="button" name="submit" value="提 交"></center><br>
		</form>
<br />
<script type="text/javascript">
$(".tagaliascheck").click(function(){
	var _tagalias=$.trim($("#tagalias").val());
	var _sourcetagalias=$.trim($("#sourcetagalias").val());
 if(_tagalias==''){
alert("别名不能为空");
return false;
 }
 if(_sourcetagalias==_tagalias){
	 alert("别名没有修改");
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
	var _sourcetagname=$.trim($("#sourcetagname").val());
 if(_tagname==''){
alert("标签名称不能为空");
return false;
 }
 if(_sourcetagname==_tagname){
	 alert("别名没有修改");
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