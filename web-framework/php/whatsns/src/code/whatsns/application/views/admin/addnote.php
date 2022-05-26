<!--{template header}-->
<script type="text/javascript">g_site_url='{SITE_URL}';g_prefix='{$setting['seo_prefix']}';g_suffix='{$setting['seo_suffix']}';</script>
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.config.js"></script>
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.all.js"></script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;添加公告</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table  class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
		<form action="index.php?admin_note/add{$setting['seo_suffix']}" method="post">
			<table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder">
				<tr class="header"><td colspan="2">参数设置</td></tr>
				<tr><td colspan="2" class="altbg1">如果要添加站外的公告，只需要填写网址即可。</td></tr>
				<tr>
					<td class="altbg1" width="30%"><b>公告标题:</b><br><span class="smalltxt">链接到公告的标题</span></td>
					<td class="altbg2"><input type="text"  name="title" style="width:300px;"></td>
				</tr>
				<tr>
					<td class="altbg1" width="30%"><b>公告网址:</b><br><span class="smalltxt">公告的地址，如果公告是在其它地方写的，填写网址即可,<font color="red">网址格式必须完整</font>，例如：http://www.ask2.cn</span></td>
					<td class="altbg2"><input type="text"  name="url" style="width:300px;"></td>
				</tr>
				<tr>
					<td class="altbg1" width="30%"><b>公告内容:</b><br><span class="smalltxt">公告显示内容,站外公告不需要填写此项</span></td>
					<td class="altbg2">
                                                <script type="text/plain" id="mycontent" name="content" style="width:610px;height:300px;">{if isset($note['content'])}$note['content']{/if}</script>
                                                <script type="text/javascript">UE.getEditor('mycontent');</script>
					</td>
				</tr>
			</table>
			<br />
			<center><input type="submit" class="button" name="submit" value="提 交"></center><br>
		</form>
<br />
<!--{template footer}-->