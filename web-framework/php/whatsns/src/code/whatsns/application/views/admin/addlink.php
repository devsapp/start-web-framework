<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;添加友情链接</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table table-striped">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
		<form {if isset($curlink)}action="index.php?admin_link/edit{$setting['seo_suffix']}"{else}action="index.php?admin_link/add{$setting['seo_suffix']}"{/if} method="post">
		<input type="hidden" name="lid" value="{if isset($lid)}$lid{/if}" />
			<table cellspacing="1" cellpadding="4" width="100%" align="center" class="table table-striped">
				<tr class="header">
					<td colspan="2">参数设置</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>链接名称:</b><br><span class="smalltxt">友情链接名称</span></td>
					<td class="altbg2"><input type="text"  {if isset($curlink['name'])}value="{$curlink['name']}" {/if} name="name" style="width:300px;" ></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>链接说明:</b><br><span class="smalltxt">友情链接说明</span></td>
					<td class="altbg2"><input type="text"  {if isset($curlink['description'])}value="{$curlink['description']}"{/if} name="descr" style="width:300px;"></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>链接URL:</b><br><span class="smalltxt">友情链接URL地址</span></td>
					<td class="altbg2"><input type="text"  {if isset($curlink['url'])}value="{$curlink['url']}"{/if} name="url" style="width:300px;"></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>LOGO地址:</b><br><span class="smalltxt">链接图片</span></td>
					<td class="altbg2"><input type="text"  {if isset($curlink['logo'])}value="{$curlink['logo']}"{/if} name="logo" style="width:300px;"></td>
				</tr>
			</table>
			<br />
			<center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
		</form>
<br />
<!--{template footer}-->