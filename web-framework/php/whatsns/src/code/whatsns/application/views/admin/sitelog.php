<!--{template header}-->

<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;站点日志管理</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
<form action="index.php?admin_sitelog/delete{$setting['seo_suffix']}" method="POST">

<table class="table">

<tr>
     <td width="25%" ><label >
删除日期:</label>
             <div class="input-group date form-date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
            <input  class="form-control " size="16" id="timestart" name="srchdatestart" value="{if isset($srchdatestart)}$srchdatestart{/if}"  readonly="">
            <span class="input-group-addon"><span class="icon-remove"></span></span>
            <span class="input-group-addon"><span class="icon-calendar"></span></span>
          </div>
             </td>
              <td width="25%">
               <label>
  到</label>
               <div class="input-group date form-date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
            <input  class="form-control " size="16"  id="timeend" name="srchdateend" value="{if isset($srchdateend)}$srchdateend{/if}" readonly="">
            <span class="input-group-addon"><span class="icon-remove"></span></span>
            <span class="input-group-addon"><span class="icon-calendar"></span></span>

          </div>

              </td>
            <td width="25%">
             <button type="submit" style="margin-top:25px;"  class="btn btn-primary" name="submit">删除</button>
            </td>
</tr>

</table>

</form>
<table class="table">
	<tbody><tr class="header"><td>站点日志列表&nbsp;&nbsp;&nbsp;</td></tr>

</tbody></table>
	<table class="table">
		<tr class="header" align="center">
			<td width="20%">uid</td>
			<td  width="25%">用户名</td>
			<td  width="30%">访问网址</td>
			<td  width="15%">描述</td>
			<td  width="10%">操作时间</td>
		</tr>
		<!--{loop $loglist $log}-->
		<tr align="center" class="smalltxt">

					<td  class="altbg2" align="center">{$log['uid']}</td>
					<td class="altbg1" align="center">{$log['username']}</td>
					<td  class="altbg2" align="center">{$log['guize']}</td>
						<td class="altbg2" align="center">
						{if strstr($log['guize'],'topic/getone')>0}
						查看了文章
						{/if}
							{if $log['guize']=='api_user/loginoutapi'}
						退出登录
						{/if}
						{if $log['guize']=='download/default'}
						查看了下载页面
						{/if}
						{if $log['guize']=='topic/default'}
						查看了专题首页
						{/if}
						{if strstr($log['guize'],'question/view')>0}
						查看了问题
						{/if}
						{if $log['guize']=='question/searchkey'}
						查询了数据
						{/if}
						{if $log['guize']=='admin_sitelog'}
						浏览站点日志页面

						{/if}

						{if $log['guize']=='admin_setting/cache'}
						点击了清空缓存按钮
						{/if}

							{if $log['guize']=='admin_word/add'}
						  增加了过滤关键词
						{/if}

							{if $log['guize']=='admin_main'}
						进入了后台首页
						{/if}

						{if $log['guize']=='expert/default'}
						浏览了专家首页
						{/if}
						{if $log['guize']=='admin_word'}
						进入添加过滤词语页面
						{/if}

						{if $log['guize']=='admin_main/login'}
						进入后台登录页面
						{/if}

						{if $log['guize']=='user/editxinzhi'}
						前台编辑文章
						{/if}

						{if $log['guize']=='admin_setting/ajaxpostpage'}
						点击了采集提交按钮
						{/if}

							{if $log['guize']=='admin_setting/caiji'}
						进入了采集页面
						{/if}
							{if $log['guize']=='category/view/all'}
						查看了网站分类页面
						{/if}
						{if $log['guize']=='topic/userxinzhi/1'}
						查看了管理员文章列表
						{/if}
						{if $log['guize']==''}
						进入了网站首页
						{/if}

							{if $log['guize']=='rss/list'}
						 查看了订阅页面
						{/if}

						{if $log['guize']=='contact/default'}
						 查看了官方联系我们页面
						{/if}
						{if $log['guize']=='buy/default'}
						 查看了官方购买页面
						{/if}

						{if $log['guize']=='user/addxinzhi'}
						进入添加文章页面
						{/if}


						{if $log['guize']=='question/add'}
						 进入了提问页面
						{/if}

						{if $log['guize']=='note/list'}
						 进入了通知列表页面
						{/if}

							{if $log['guize']=='admin_tixian'}
						 管理员进入提现列表页面
						{/if}
							{if $log['guize']=='admin_dashang'}
						 管理员进入打赏记录页面
						{/if}
							{if $log['guize']=='admin_setting/search'}
						 管理员进入后台搜索设置页面
						{/if}
							{if $log['guize']=='index/default'}
						 进入了首页
						{/if}





						{if $log['guize']=='user/default'}
						 进入了个人中心
						{/if}
						{if $log['guize']=='about/default'}
						 查看了关于我们页面
						{/if}
						{if $log['guize']=='favorite/default'}
						 查看了自己收藏列表
						{/if}

						{if $log['guize']=='user/space/1'}
						 查看了管理员的空间
						{/if}

						{if $log['guize']=='message/remove'}
						 删除站内消息
						{/if}
						{if $log['guize']=='admin_topic/makeindex'}
						 点击了创建全文检索文章索引
						{/if}
						{if $log['guize']=='user/ajaxupdateusername'}
						更新用户信息
						{/if}

							{if $log['guize']=='user/sendcheckmail'}
						用户发送了激活邮件申请
						{/if}
							{if $log['guize']=='user/editemail'}
						修改了用户邮件
						{/if}
							{if $log['guize']=='user/score'}
						进入个人中心
						{/if}
							{if $log['guize']=='message/system'}
						查看了个人中心-系统私信
						{/if}
							{if $log['guize']=='admin_main/stat'}
						管理员进入后台面板
						{/if}
							{if $log['guize']=='admin_user'}
						管理员进入后台用户管理页面
						{/if}

							{if $log['guize']=='user/userbank'}
						用户进入了个人中心--我的银行页面
						{/if}

							{if $log['guize']=='user/userbank'}
						用户进入了个人中心--我的银行页面
						{/if}
							{if $log['guize']=='question/ajaxadd'}
						用户提了一个问题
						{/if}

							{if $log['guize']=='user/recommend'}
						用户进入个人中心--正在浏览推荐给我的问题列表
						{/if}
							{if $log['guize']=='user/userzhangdan'}
						用户进入个人中心--正在浏览我的对账单页面
						{/if}

						{if $log['guize']=='user/mycategory'}
						用户进入个人中心--正在浏览我的分类页面
						{/if}


						{if $log['guize']=='ebank/aliapytransfer'}
						用户进入个人中心--用户正准备发起支付宝充值
						{/if}
							{if $log['guize']=='ebank/weixintransfer'}
						用户进入个人中心--用户正准备发起微信扫码充值
						{/if}
							{if $log['guize']=='user/recharge'}
						用户进入个人中心--我要充值页面
						{/if}

							{if $log['guize']=='plugin_weixin/login'}
						用户进入微信登录页面
						{/if}

							{if $log['guize']=='plugin_weixin/wxauth'}
						用户进入微信授权页面
						{/if}
							{if $log['guize']=='question/search'}
						用户进入搜索页面
						{/if}
							{if $log['guize']=='user/profile'}
						用户进入个人中心--个人设置资料修改页面
						{/if}

						{eval if(strstr($log['guize'],'topic/search/')) echo '用户正在检索文章';}
							{eval if(strstr($log['guize'],'question/delete/')) echo '用户删了问题';}
						{eval if(strstr($log['guize'],'user/answer/')) echo '用户查看了别人的回答列表页面';}
							{eval if(strstr($log['guize'],'user/ajaxcode')) echo '正在输入验证码';}
						{eval if(strstr($log['guize'],'question/add/')) echo '用户进入提问页面--邀请回答';}
							{eval if(strstr($log['guize'],'user/checkemail')) echo '邮箱验证';}
						{eval if(strstr($log['guize'],'category/view')) echo '查看了分类';}
						{eval if(strstr($log['guize'],'topic/userxinzhi')) echo '查看用户文章列表';}
						{eval if(strstr($log['guize'],'question/search/')) echo '检索问题数据';}
						{eval if(strstr($log['guize'],'user/ajaxuserinfo')) echo '查看了个人名片';}
						{eval if(strstr($log['guize'],'topic/getone')) echo '查看了文章';}
						{eval if(strstr($log['guize'],'question/view')) echo '查看了问题详情页面';}
						{eval if(strstr($log['guize'],'note/view')) echo '查看了通知详情页面';}
						{eval if(strstr($log['guize'],'user/editxinzh')) echo '编辑了文章';}
						</td>
						<td class="altbg2" align="center">{$log['time']}</td>
				</tr>
				<!--{/loop}-->
				   <!--{if $departstr}-->

        <!--{/if}-->
	</table>
   <div class="pages">{$departstr}</div>
       <link href="{SITE_URL}static/css/dist/lib/datetimepicker/datetimepicker.min.css" rel="stylesheet">
  <script src="{SITE_URL}static/css/dist/lib/datetimepicker/datetimepicker.min.js"></script>
<br>
<script>
$(".form-date").datetimepicker(
	    {
	    	weekStart: 1,
	        todayBtn:  1,
	        autoclose: 1,
	        todayHighlight: 1,
	        startView: 2,
	        forceParse: 0,
	        showMeridian: 1,
	        format: "yyyy-mm-dd hh:ii"
	    });
</script>
<!--{template footer}-->

