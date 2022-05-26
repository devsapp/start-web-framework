<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;礼品价格区间 </div>
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
	<tbody>
	<tr class="header" ><td>礼品价格区间</td></tr>
	<tr class="altbg1"><td>根据实际情况设置合理的价格范围。</td></tr>
	</tbody>
</table>
<form action="index.php?admin_gift/addrange{$setting['seo_suffix']}" method="post">
 <table class="table">
	<tr class="header"><td colspan="2">参数设置</td></tr>
	<!--{loop $rangelist $key $rang}-->
       <tr>
            <td class="altbg2" width="15%"><input value="{$key}" name="gift_range[]">&nbsp;到</td>
            <td class="altbg2">&nbsp;<input value="{$rang}" name="gift_range[]"></td>
       </tr>
	<!--{/loop}-->
    <tr  id="range">
        <td class="altbg2"><input value="" name="gift_range[]">&nbsp;到</td>
        <td class="altbg2">&nbsp;<input value="" name="gift_range[]"><a href="javascript:void(0);" onclick="addrange()">&nbsp;添加</a> </td>
    </tr>
	<tr class="altbg1"><td colspan="2" class="altbg1"  align="left"><input type="submit" name="submit" class="button"  value="提&nbsp;交" /></td></tr>
</table>
</form>
<br>
<!--{template footer}-->
    <script type="text/javascript">
        function addrange(){
            var range = '<tr><td class="altbg2"><input value="" name="gift_range[]">&nbsp;到</td><td class="altbg2">&nbsp;<input value="" name="gift_range[]"><a href="javascript:delrange(this);"></a> </td></tr>';
            $("#range").after(range);
        }
    </script>
