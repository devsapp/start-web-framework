<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;设置列表</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert  alert-warning">{$message}</div>
<!--{/if}-->

		<form action="{SITE_URL}index.php?admin_totalset/index{$setting['seo_suffix']}" method="post" enctype="multipart/form-data">
			<table class="table">
				<tr class="header">
					<td colspan="2">全局参数设置</td>
				</tr>
				 <tr>
					<td class="altbg1" width="45%"><b>第三方授权登录<label class="label" style="margin-left:3px;">新</label>:</b><br><span class="smalltxt">授权是否自动注册如果无网站账号</span></td>
					<td class="altbg2">
					<input class="" type="checkbox" {if $setting['weixinregset']==1}checked{/if} name="weixinregset" />勾选启用将应用设置(请在高级管理菜单中设置第三方登录信息)
					</td>
				</tr>
			
					      <tr>
					<td class="altbg1" width="45%"><b>开启禁止游客访问模式:</b><br><span class="smalltxt">开启后禁止游客一切操作，只有登录后才能访问网站</span></td>
					<td class="altbg2">
					<input class="" type="checkbox" {if $setting['needlogin']==1}checked{/if} name="needlogin" />勾选启用禁止游客访问模式，网站需登录才能访问
					</td>
				</tr>
				    
					      <tr>
					<td class="altbg1" width="45%"><b>前端注册是否需要邀请码:</b><br><span class="smalltxt">开启邀请码注册后只要邀请的人才能成功注册</span></td>
					<td class="altbg2">
					<input class="" type="checkbox" {if $setting['needinvatereg']==1}checked{/if} name="needinvatereg" />勾选启用邀请注册
					</td>
				</tr>
				      <tr>
					<td class="altbg1" width="45%"><b>站内图片开启水印:</b><br><span class="smalltxt">默认不开启，可在此启用，gif慎用会转静态图，默认替换水印地址：static\js\neweditor\marker.png</span></td>
					<td class="altbg2">
					<input class="" type="checkbox" {if $setting['waterset']==1}checked{/if} name="waterset" />勾选开启图片加水印
					</td>
				</tr>
				
               
						<tr>
					<td class="altbg1" width="45%"><b>是否只允许专家发布文章:</b><br><span class="smalltxt">开启后文章只允许专家才有权限发布</span></td>
					<td class="altbg2">

					<input class="" type="checkbox" {if $setting['publisharticleforexpert']==1}checked{/if} name="publisharticleforexpert" />只允许专家发布文章
					</td>
				
				</tr>
					<tr>
					<td class="altbg1" width="45%"><b>发布文章是否审核:</b><br><span class="smalltxt">默认不需要审核，如果需要审核请勾选</span></td>
					<td class="altbg2">
					<input class="" type="checkbox" {if $setting['publisharticlecheck']==1}checked{/if} name="publisharticlecheck" />审核文章
					</td>
				</tr>
					<tr>
					<td class="altbg1" width="45%"><b>文章评论是否审核:</b><br><span class="smalltxt">默认不需要审核，如果需要审核请勾选</span></td>
					<td class="altbg2">
					<input class="" type="checkbox" {if $setting['publisharticlecommentcheck']==1}checked{/if} name="publisharticlecommentcheck" />审核文章评论
					</td>
				</tr>
				<tr class="">
					<td class="altbg1" width="45%"><b>个人认证名称:</b><br><span class="smalltxt">默认显示个人认证</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['vertify_gerentip']}" name="vertify_gerentip" /></td>
				</tr>
			    <tr  class="">
					<td class="altbg1" width="45%"><b>企业认证名称:</b><br><span class="smalltxt">默认显示企业认证</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['vertify_qiyetip']}" name="vertify_qiyetip" /></td>
				</tr>

				<tr>
					<td class="altbg1" width="45%"><b>用户允许设置的擅长分类数目:</b><br><span class="smalltxt">默认能设置三个，建议不超过三个</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['cansetcatnum']}" name="cansetcatnum" /></td>
				</tr>
			
					
				<tr>
					<td class="altbg1" width="45%"><b>是否允许重复提问:</b><br><span class="smalltxt">如果标题一样视为同一个问题，不允许入库，默认是不支持重复标题提问</span></td>
					<td class="altbg2">
					<input class="" type="checkbox" {if $setting['canrepeatquestion']==1}checked{/if} name="canrepeatquestion" />允许重复提问
					</td>
				</tr>
					<tr>
					<td class="altbg1" width="45%"><b>是否允许自问自答:</b><br><span class="smalltxt">自己发布问题可以自己回答</span></td>
					<td class="altbg2">
					<input class="" type="checkbox" {if $setting['cananswerselfquestion']==1}checked{/if} name="cananswerselfquestion" />允许回答自己问题
					</td>
				</tr>
					<tr>
					<td class="altbg1" width="45%"><b>是否全站单窗口打开:</b><br><span class="smalltxt">如果开启后打开网页不会新增窗口，在同一个窗口打开</span></td>
					<td class="altbg2">
					<input class="" type="checkbox" {if $setting['opensinglewindow']==1}checked{/if} name="opensinglewindow" />开启单窗口打开模式
					</td>
				</tr>
			
				<tr>
					<td class="altbg1" width="45%"><b>前台首页顶置数目:</b><br><span class="smalltxt">默认3条，不建议很多，首页顶置内容功能属于社交版，其它模板配置无效</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['list_topdatanum']}" name="list_topdatanum" /></td>
				</tr>
			    <tr>
					<td class="altbg1" width="45%"><b>后台问题管理显示数目:</b><br><span class="smalltxt">默认启用站点设置里全局列表数目设置项，此处如果配置会应用当前显示的设置</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['admin_list_default']}" name="admin_list_default" /></td>
				</tr>
				<tr>
					<td class="altbg1" width="45%"><b>问题详情页面回答数显示:</b><br><span class="smalltxt">默认3条，超过3条会分页</span></td>
					<td class="altbg2"><input class="form-control shortinput" type="text" value="{$setting['list_answernum']}" name="list_answernum" /></td>
				</tr>
			  <tr>
            <td class="altbg1" width="45%"><b>等级经验特权:</b><br><span class="smalltxt text-danger">如果经验值达到这个数值可以免去提问和回答还有发布文章还有站内评论验证码</span></td>
            <td class="altbg2"><input type="text" class="form-control shortinput" value="{if $setting['jingyan']<=0}0 {else}$setting['jingyan']{/if}" name="jingyan"></td>
        </tr>
				  <tr>
            <td class="altbg1" width="45%"><b>禁用右键和复制内容:</b><br>
                <span class="smalltxt">要保护网站知识可以禁用鼠标右键和禁止选择内容复制</span></td>
            <td class="altbg2">
                <input class="radio inline" type="radio" {if 0==$setting['cancopy']}checked{/if} value="0" name="cancopy" >&nbsp;否-不禁用&nbsp;&nbsp;
                       <input class="radio inline" type="radio" {if 1==$setting['cancopy']}checked{/if} value="1" name="cancopy" >&nbsp;是-禁用复制&nbsp;&nbsp;

            </td>
        </tr>
						  <tr>
            <td class="altbg1" width="45%"><b>开启百度分词:</b><br>
                <span class="smalltxt">后台网页采集使用，自动分词</span></td>
            <td class="altbg2">
                <input class="radio inline" type="radio" {if 0==$setting['baidufenci']}checked{/if} value="0" name="baidufenci" >&nbsp;不开启&nbsp;&nbsp;
             <input class="radio inline" type="radio" {if 1==$setting['baidufenci']}checked{/if} value="1" name="baidufenci" >&nbsp;开启分词&nbsp;&nbsp;
            </td>
        </tr>
        
     
			</table>
			<br />
			<center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
		</form>
<br />

<style>

html,body{
	overflow:scroll;
}
</style>

<!--{template footer}-->