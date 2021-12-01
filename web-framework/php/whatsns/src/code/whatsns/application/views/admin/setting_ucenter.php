<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;UCenter整合</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->

<div class="alert alert-success">{$message}</div>
<!--{/if}-->
<table class="table">
	<tbody><tr class="header"><td>设置说明</td></tr>
            <tr class="altbg1"><td>UCenter整合开启前，务必关闭通行证整合。<br />配置步骤如下：<br />1、ucenter服务端添加ask2问答应用<br />2、添加完成之后将生成的应用配置贴到下方即可<br />3、ucenter服务端检测ask2问答连接状态，通信成功即表示整合完成</td></tr>
</tbody></table>
<br />
<div class="alert alert-warning">ucenter配置文件保存路径:&nbsp;&nbsp;<b>{SITE_URL}data/ucconfig.inc.php</b></div>
<form action="index.php?admin_setting/ucenter{$setting['seo_suffix']}" method="post">
	<a name="基本设置"></a>
	<table class="table">
		<tr class="header">
			<td colspan="2">参数设置</td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>UCenter整合:</b><br><span class="smalltxt">关闭后设置还会保留。</span></td>
			<td class="altbg2">
					<input class="radio inline"  type="radio"  {if 1==$setting['ucenter_open'] }checked{/if}  value="1" name="ucenter_open" ><label for="yes">开启</label>&nbsp;&nbsp;
					<input class="radio inline"  type="radio"  {if 0==$setting['ucenter_open'] }checked{/if} value="0" name="ucenter_open" ><label for="no">关闭</label>
			</td>
		</tr>
			<tr>
			<td class="altbg1" width="45%"><b>uid同步问答:</b><br><span class="smalltxt">设置后插入ucenter用户uc_members表会员的uid会同步当前问答用户表。</span></td>
			<td class="altbg2">
					<input class="radio inline"  type="radio"  {if 1==$setting['ucenter_setuid_byask'] }checked{/if}  value="1" name="ucenter_setuid_byask" ><label for="yes">应用</label>&nbsp;&nbsp;
					<input class="radio inline"  type="radio"  {if 0==$setting['ucenter_setuid_byask'] }checked{/if} value="0" name="ucenter_setuid_byask" ><label for="no">不应用</label>
			   <a style="color:red;font-weight:700;" href="">查看如何设置【必看，否则对数据造成不可逆转的结果】</a>
			</td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>论坛UCenter地址</b><br><span class="smalltxt">填写uc中的uc_api,也就是你论坛ucenter的地址<a href="http://www.ask2.cn/upload/dzucapi.jpg" data-toggle="lightbox" class="btn btn-danger">查看在哪复制</a></span></td>
			<td class="altbg2"><input type="text" class="form-control" value="$setting['ucenter_url']" name="ucenter_url"/></td>
		</tr>
		<tr>
			<td class="altbg1" width="45%"><b>应用配置信息</b><br><span class="smalltxt">ucener中的应用配置信息,保存之后配置会写入到ask2/data/ucconfig.inc.php中，也可自行修改</span></td>
			<td class="altbg2"><textarea name="ucenter_config" style="width:650px;height:200px;"></textarea></td>
		</tr>
	</table>
	<br>
	<p style="text-align:center;"><a target="_blank" style="color:red;font-weight:700;" href="https://www.ask2.cn/topic/getone/14829.html">配置之前先读下这篇问答【慎重配置】</a></p>
	<center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
</form>

<br>
<!--{template footer}-->