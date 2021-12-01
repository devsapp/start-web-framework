<!--{template header}-->

<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;数据库备份</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
<form action="index.php?admin_db/backup" method="post" onsubmit="return docheck();">
	<table class="table">
		<tr class="header">
			<td colspan="4">数据库备份</td>
		</tr>
		<tr>
			<td class="altbg2" width="45%" colspan="2"><b>备份类型:</b><br><span class="smalltxt">根据自己的需求选择备份类型</span></td>
			<td class="altbg2" colspan="2">
				<input type="radio" name="type" value="full" class="radio" checked="checked" onclick="document.getElementById('showtables').style.display='none'">全部备份(推荐)，备份Ask2数据库所有表<br />
				<input type="radio" name="type" value="stand" class="radio"  onclick="document.getElementById('showtables').style.display='none'">标准备份,备份常用的数据表,包括分类表、问题表、回答表、用户表、系统设置表<br />
				<input type="radio" name="type" value="min" class="radio" onclick="document.getElementById('showtables').style.display='none'">最小备份,仅包括问题表、回答表<br />
				<input type="radio" name="type" value="custom" class="radio" onclick="document.getElementById('showtables').style.display=''">自定义备份,根据自行选择备份数据表
			</td>
		</tr>

		<tbody id="showtables" style="display:none">
			<tr>
				<td colspan="4" class="altbg1"><input name="chkall" class="checkbox" value="chkall" id="chkall" onClick="selectAll('tip','chkall','tables[]');" type="checkbox"><label id="tip"> 全选 </label></td>
			</tr>
			<tr>
			<!--{loop $tables $key $value}-->
			<!--{if $key%4!=0}-->
			<td class="altbg2"><input type="checkbox" class="checkbox" value="{$value}" name="tables[]"/>{$value}</td>
			<!--{else}-->
			</tr>
			<tr>
				<td class="altbg2"><input type="checkbox" class="checkbox" value="{$value}" name="tables[]"/>{$value}</td>
			<!--{/if}-->
			<!--{/loop}-->
			</tr>
		</tbody>
		<tr class="header"><td colspan="4">其它选项</td></tr>
		<tr>
			<td colspan="2" class="altbg2" width="45%"><b>备份文件名:</b><br><span class="smalltxt">备份文件名名称</span></td>
			<td colspan="2" class="altbg2"><input type="text"  id="sqlfilename" name="sqlfilename" value="{$sqlfilename}" size="25">.sql</td>
		</tr>
		<tr>
			<td colspan="2" class="altbg2" width="45%"><b>分卷文件大小:</b></td>
			<td colspan="2" class="altbg2"><input type="text"  id="sizelimit" name="sizelimit" value="2048" size="15">KB</td>
		</tr>
		<tr>
			<td colspan="2" class="altbg2" width="45%"><b>分卷文件大小:</b><br><span class="smalltxt">多分卷压缩成一个文件</span></td>
			<td  colspan="2" class="altbg2"><input type="radio" class="radio"  name="compression" value="1" > 多分卷压缩成一个文件不压缩&nbsp;&nbsp;&nbsp;<input type="radio" class="radio" checked  name="compression" value="0" > 不压缩</td>
		</tr>
		<tr><td class="altbg1" align="left" colspan="4"><input name="backupsubmit" type="submit" class="btn" value="数据库备份" /></td></tr>
	</table>
</form>
<br>

<table class="table">
		<tr class="header">
			<td colspan="6">数据库备份</td>
		</tr>
		<tr class="header">
			<td width="20%" >SQL文件</td>
			<td width="10%">文件大小</td>
			<td width="20%">文件修改日期</td>
			<td width="20%">导入文件</td>
			<td width="20%">下载文件</td>
			<td width="10%">删除文件</td>
		</tr>
	<!--{loop $filename $key $value}-->
	<tr>
		<td class="altbg2">{$value['filepath']}</td>
		<td class="altbg2">{$value['filesize']}</td>
		<td class="altbg2">{$value['filectime']}</td>
		<td class="altbg2"><a href="javascript:void(0)" onclick="cofirmimport('{$value['filename']}')" >导入文件</a></td>
		<td class="altbg2"><a href="javascript:void(0)" onclick="downloadfile('{$value['filename']}')">下载文件</a></td>
		<td class="altbg2"><a href="javascript:void(0)" onclick="removefile('{$value['filename']}')">删除文件</a></td>
	</tr>
	<!--{/loop}-->
</table>
<!--{template footer}-->

<script type="text/javascript" >
function cofirmimport(filename){
	if(confirm('导入该sql文件会覆盖原来的数据!是否导入？')==false){
		return false;
	}else{
		window.location='{SITE_URL}index.php?admin_db/import/'+filename.replace(/\./g,'*');
	}
}
function removefile(filename){
	if(confirm('删除数据库备份文件不可恢复!是否删除？')==false){
		return false;
	}else{
		window.location='{SITE_URL}index.php?admin_db/remove/'+filename.replace(/\./g,'*');
	}
}
function downloadfile(filename){
	window.location='{SITE_URL}index.php?admin_db/downloadfile/'+filename.replace(/\./g,'*');
}
function selectAll(tipid,chkid,childname){
	var chk=$("#"+chkid);
	var infotip=$("#"+tipid);
	if(chk.attr('checked')==true){
		checkAll(childname,true);
	}else{
		checkAll(childname,false);
	}
}
function checkAll(eleName,state){
	$("input[name='"+eleName+"']").attr('checked',state);
}
function checkname(s){
	var patrn=/^[a-zA-Z0-9]([a-zA-Z0-9]|[_])*$/;
	return patrn.test(s) ;
}
function docheck(){
	if($.trim($('#sqlfilename').val())==''|| !checkname($.trim($('#sqlfilename').val()))){
		alert('文件名错误,请以字母或数字开头,并且名称中只允许有字母,数字和下划线');
		return false;
	}else if(isNaN($('#sizelimit').val())==true){
		alert('分卷大小请填写数字');
		return false;
	}else if($('#sizelimit').val()<512){
		alert('文件大小限制不要小于512K');
		return false;
	}else{
		return true;
	}
}
</script>
