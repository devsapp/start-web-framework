<!--{template header}-->
<div id="append">
</div>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;更新缓存</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->

<div class="alert alert-info-inverse with-icon">
        <i class="icon-info-sign"></i>
        <div class="content"> {$message}</div>
      </div>
<!--{/if}-->
<table class="table">
	<tbody>
	<tr class="header" ><td>更新缓存</td></tr>
	<tr class="altbg1"><td>当后台的设置发生改变后，需要及时更新下缓存，才能立即生效</td></tr>
	</tbody>
</table>
<form action="index.php?admin_setting/cache{$setting['seo_suffix']}" method="post">
 <table class="table">
	<tr>
		<td class="altbg2" width="10"><input class="checkbox" type="checkbox"  checked value="data" name="type[]"></td><td class="altbg2" >更新数据缓存</td>
	</tr>
	<tr>
		<td class="altbg2" width="10"><input class="checkbox" type="checkbox"  checked  value="tpl" name="type[]"></td><td class="altbg2">更新模板缓存</td>
	</tr>
	<tr>
		<td colspan="2" class="altbg1"><input class="btn btn-info" type="submit" name="submit" value="提 交"></td>
	</tr>
</table>
</form>
<!--{template footer}-->