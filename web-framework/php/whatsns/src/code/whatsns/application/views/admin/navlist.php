<!--{template header}-->
<script type="text/javascript" src="{SITE_URL}static/js/jquery-ui/jquery-ui.js"></script>
<script src="{SITE_URL}static/js/admin.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#list").sortable({
		update: function(){
			var reorderid="";
			var numValue=$("input[name='order[]']");
			for(var i=0;i<numValue.length;i++){
				reorderid+=$(numValue[i]).val()+",";
			}
			var hiddencid=$("input[name='hiddencid']").val();
			$.post("index.php?admin_nav/reorder{$setting['seo_suffix']}",{order:reorderid,hiddencid:hiddencid});
		}
	});
});
function removenav(nid){
	if(confirm('删除该导航，确定继续?')){
		window.location="index.php?admin_nav/remove/"+nid+"{$setting['seo_suffix']}";
	}
}
</script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;导航管理</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
<table class="table">
	<tbody><tr class="header"><td>导航列表&nbsp;&nbsp;&nbsp;<input class="btn btn-info" onclick="document.location.href='index.php?admin_nav/add{$setting['seo_suffix']}'" type="button" value="添加导航" /></td></tr>
	<tr class="altbg1"><td>导航的排序可以通过鼠标拖动来改变，当鼠标在某一链接上面时，按住左键即可上下移动。</td></tr>
</tbody></table>
	<table class="table">
		<tr class="header" align="center">
			<td width="10%">名称</td>
			<td width="30%">链接地址</td>
			<td  width="20%">说明</td>

			<td  width="8%">打开方式</td>
			<td  width="7%">状态操作</td>
			<td  width="5%">编辑</td>
			<td  width="5%">删除</td>
		</tr>
	</table>
    <input type="hidden" name="hiddencid" value="{if isset($pid)}$pid{/if}" />
    <ul id="list" class="nav" >
		<!--{loop $navlist $nav}-->
		<li style="list-style:none;">
			<table  id="table1" cellspacing="1" cellpadding="4" width="100%" align="center" class="table table-striped">
				<tr align="center" class="smalltxt">
					<td width="10%" class="altbg1"><input name="order[]" type="hidden" value="{$nav['id']}"/><a href="$nav['url']" target="_blank">{$nav['name']}</a></td>
					<td width="30%" align="center" class="altbg2"><a href="{$nav['url']}" target="_blank">{$nav['url']}</a></td>
					<td width="20%" align="center" class="altbg2">{$nav['title']}</td>
					<td width="8%" align="center" class="altbg1">{if $nav['target']}新窗口{else}本窗口{/if}</td>
					<td width="7%" align="center" class="altbg2"><a href="{SITE_URL}index.php?admin_nav/available/$nav['id']/$nav['available']{$setting['seo_suffix']}">{if $nav['available']}点击禁用{else}<font color="green">点击启用</font>{/if}</a></td>
					<td width="5%" align="center" class="altbg1"><img src="{SITE_URL}static/css/admin/edit.png" onclick="document.location.href='index.php?admin_nav/edit/$nav['id']{$setting['seo_suffix']}'"></td>
					<td width="5%" align="center" class="altbg2"><img src="{SITE_URL}static/css/admin/remove.png" onclick="removenav({$nav['id']})"></td>
				</tr>
			</table>
		</li>
		<!--{/loop}-->
	</ul>
<br>
<!--{template footer}-->