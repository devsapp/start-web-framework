<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;公众号基本信息设置</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->

<div class="alert alert-info">{$message}</div>
<!--{/if}-->
<table class="table">

				<tr>
					<td class="altbg1" width="45%"><b>微信端授权登录地址(可复制):</b><br><span class="smalltxt text-danger">只有认证并且绑定网页授权地址的服务号才行,如果绑定手机二级域名的网站请将域名换成手机端域名，否则验证失败</span>

					<a href="http://www.ask2.cn/upload/wx001.jpg" data-toggle="lightbox" class="btn btn-info">图一</a>
										<a href="http://www.ask2.cn/upload/wx002.jpg" data-toggle="lightbox" class="btn btn-info">图二</a>
					</td>
					<td class="altbg2"><input type="text" required="" class="px form-control " readonly="" value="{url plugin_weixin/wxauth}" tabindex="1" >



</td>
				</tr>
			</table>

<form action="index.php?admin_weixin/savetoken{$setting['seo_suffix']}" method="post" onsubmit="return checktoken();">
			<table class="table">
				<tr class="header">
					<td colspan="2" class="text-danger font-15">开发者模式设置，配置需开启开发者模式<a href="http://www.ask2.cn/css/images/tokensetting.png" data-toggle="lightbox" class="btn btn-info">查看详情</a></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>TOKEN:(手动复制到微信平台)</b><br><span class="smalltxt">公众号平台开发者模式里填写,只能是数字和字母</span></td>
					<td class="altbg2"><input type="text" required="" id="wxtoken" class="px form-control shortinput" name="wxtoken" readonly="" value="{$setting['wxtoken']}" tabindex="1" >
					<button type="button"  class="btn btninfo" id="btnrand">随机生成</button>


</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>URL:</b><br><span class="smalltxt"><span class="red">公众号平台开发者模式里填写</span></span></td>
					<td class="altbg2"><input type="text" required="" name="wxurl" value="{SITE_URL}plugin/weixin/weixin.php" class="px form-control " tabindex="1" ></td>
				</tr>
		<tr>
					<td class="altbg1" width="45%"><b>开启微信支付:</b><br><span class="smalltxt"><span class="red">只支持开通微信支付的公众号，并且网站配置了微信支付，开启后前端网站回答，文章打赏都能看到</span></span></td>
					<td class="altbg2">
					<input class="radio"  type="radio"  {if 1==$setting['openwxpay'] }checked{/if}  value="1" name="openwxpay"><label for="yes">是</label>&nbsp;&nbsp;&nbsp;
                <input class="radio"  type="radio"  {if 0==$setting['openwxpay'] }checked{/if} value="0" name="openwxpay"><label for="no">否</label>
					</td>
				</tr>
			</table>
			<br />
			<center><input type="submit" class="btn btn-info" name="submit" value="提 交"></center><br>
		</form>

<hr>
<a class="btn btn-success" target="_blank" href="https://www.ask2.cn/article-14581.html">查看微信公众号配置教程</a>
<a style="margin-left: 20px;" class="btn btn-success" target="_blank" href="https://www.ask2.cn/article-14934.html">查看微信支付配置教程</a>

<form action="index.php?admin_weixin/setting{$setting['seo_suffix']}" method="post" >
			<table class="table">
				<tr class="header">
					<td colspan="2">公众号参数设置</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>公众号名称:</b><br><span class="smalltxt">你将绑定的公众号名称</span></td>
					<td class="altbg2"><input type="text" required="" class="px form-control shortinput" name="wxname" value="{$wx['wxname']}" tabindex="1" size="25">
必填</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>公众号原始id:</b><br><span class="smalltxt"><span class="red">请认真填写，错了不能修改。</span>比如：gh_423dwjkeww3</span></td>
					<td class="altbg2"><input type="password" required="" name="wxid" value="{$wx['wxid']}" onmouseup="this.value=this.value.replace('_430','')" class="px form-control shortinput" tabindex="1" size="25">必填</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>微信号:</b><br><span class="smalltxt">该公众号的微信号，用户搜索微信号就能找到</span></td>
					<td class="altbg2"><input type="text" required="" name="weixin" value="{$wx['weixin']}" class="px form-control shortinput" tabindex="1" size="25">必填</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>AppID（公众号）:</b><br><span class="smalltxt">用于自定义菜单等高级功能</span></td>
					<td class="altbg2"><input type="password" name="appid" value="{$wx['appid']}" class="px form-control shortinput" tabindex="1" size="25">必填</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>AppSecret:</b><br><span class="smalltxt">用于自定义菜单等高级功能</span></td>
					<td class="altbg2"><input type="password" name="appsecret" value="{$wx['appsecret']}" class="px form-control shortinput" tabindex="1" size="25">必填</td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>微信号类型:</b><br><span class="smalltxt">认证服务号是指每年向微信官方交300元认证费的公众号</span></td>
					<td class="altbg2">
					<select class="form-control  shortinput" id="winxintype" name="winxintype">
                  <option {if $wx['winxintype']==1} selected {/if} value="1">订阅号</option>
                  <option {if $wx['winxintype']==2} selected {/if} value="2">服务号</option>
                  <option {if $wx['winxintype']==3} selected {/if} value="3">认证服务号</option>
                  <option {if $wx['winxintype']==4} selected {/if} value="4">认证订阅号</option>
                  </select>
					</td>
				</tr>
			</table>
			<br />
			<center><input type="submit" class="btn btn-info" name="submit" value="提 交"></center><br>
		</form>
<br />
<script>
function checktoken(){
	var _wxtoken=  $("#wxtoken").val();
	if($.trim(_wxtoken)==""){
		// 使用jQuery对象
		var msg = new $.zui.Messager('Token不能为空', {placement: 'center',time:'1000'});
		// 显示消息
        msg.show();
		return false;
	}

}

function only(ele,arr){
	 if(arr.length==0){
	  return true;
	 }
	 for(var j=0;j<arr.length;j++){
	  if(ele==arr[j]){
	   return false;
	  }else{
	   return true;
	  }
	 }
	}

	var arr=[0,1,2,3,4,5,6,"a","b","c","d","e","f","g"];






$("#btnrand").click(function(){
	var str="";

	 var randNum=null;
	 var old=[];
	 function done(){
		  randNum=Math.floor(Math.random()*14);
		  if(only(randNum,old)){
		   str=str+arr[randNum];
		   old.push(randNum);
		  }
		  else{
		   done();
		  }
		 }

	 for(var index=0;index<24;index++){
		  done();
		 }
	 $("#wxtoken").val(str);
});

</script>
<!--{template footer}-->