<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;礼品兑换日志</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
 <form action="index.php?admin_gift/logsearch{$setting['seo_suffix']}" method="post">
 <table class="table">
	<tbody>
	<tr class="header" ><td colspan="7">礼品兑换日志列表</td></tr>
	<tr class="altbg1"><td colspan="7">可以通过如下搜索条件，检索兑换日志</td></tr>
	<tr>
        <td width="20%" class="altbg2">价格范围:
            <select name="pricerange">
                <option value="all">全部</option>
                <!--{loop $gift_range $key $val}-->
                <option value="{$key}-{$val}">{$key}-{$val}</option>
                <!--{/loop}-->
            </select>
        </td>
        <td width="30%" class="altbg2">礼品名称:<input type="text" name="giftname"></td>
        <td rowspan="2" class="altbg2"><input class="btn" type="submit" value="提 交"></td>
        </tr>
        <tr>
            <td class="altbg2">兑换用户：<input class="txt" name="username"></td>
            <td class="altbg2">兑换时间:<input class="txt" id="timestart" name="srchregdatestart">到&nbsp;<input class="txt" id="timeend" name="srchregdateend"></td>
        </tr>
	</tbody>
</table>
</form>
<h4>[共 <font color="green">{$giftlognum}</font> 个礼品兑换申请]</h4>
<form name="userForm" action="index.php?admin_gift/remove{$setting['seo_suffix']}" method="post">
 <table class="table">
	<tr class="header">
		<td width="5%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('id[]')" type="checkbox" name="chkall"><label for="chkall">全选</label></td>
		<td  width="10%">礼品名称</td>
		<td  width="5%">用户名</td>
		<td  width="5%">真实姓名</td>
		<td  width="15%">地址</td>
		<td  width="5%">邮编</td>
		<td  width="5%">电话</td>
		<td  width="5%">QQ</td>
		<td  width="10%">Email</td>
		<td  width="15%">备注</td>
		<td  width="10%">兑换时间</td>
		<td  width="10%">状态</td>
	</tr>

	<!--{loop $loglist $log}-->
        <tr>
            <td class="altbg2"><input class="checkbox" type="checkbox" value="{$log['id']}" name="id[]"></td>
            <td class="altbg2"><strong>{$log['giftname']}</strong></td>
            <td class="altbg2">{$log['username']}</td>
            <td class="altbg2">{$log['realname']}</td>
            <td class="altbg2">{$log['address']}</td>
            <td class="altbg2">{$log['postcode']}</td>
            <td class="altbg2">{$log['phone']}</td>
            <td class="altbg2">{$log['qq']}</td>
            <td class="altbg2">{$log['email']}</td>
            <td class="altbg2">{$log['notes']}</td>
            <td class="altbg2">{$log['time']}</td>
            <td class="altbg2">{if !$log['status']}<font color="Red">等待兑换...</font>{else}<font color="green">已送出</font>{/if}</td>
        </tr>
	<!--{/loop}-->
      <!--{if $departstr}-->
        <tr class="smalltxt">
            <td class="altbg2" colspan="12" align="right"><div class="scott">{$departstr}</div></td>
        </tr>
        <!--{/if}-->
	<tr><td colspan="12" class="altbg1" align="left"><input class="btn" type="button" name="available" onclick="onavailable(1);" value="设为已寄送" /></td></tr>
</table>
</form>
<br>
<!--{template footer}-->
    <script type="text/javascript">
        function onavailable(type){
            if($("input[name='id[]']:checked").length == 0){
                alert('你没有选择任何礼品记录！');
                return false;
            }
            document.userForm.action="index.php?admin_gift/csend/"+type+"{$setting['seo_suffix']}";
            document.userForm.submit();
        }
    </script>


