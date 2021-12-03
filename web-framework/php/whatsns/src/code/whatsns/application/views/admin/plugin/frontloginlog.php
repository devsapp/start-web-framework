<!--{template header,admin}-->
<div>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div >
    <ol class="breadcrumb">
  <li><a href="{url admin_main/stat}">后台首页</a></li>
  <li><a href="{url admin_myplugin/clist}">插件列表</a></li>
  <li class="active">{$navtitle}</li>
</ol>

</div>
<div style="padding:8px;">
<div class="row" style="margin-bottom:8px;">
<div class="col-sm-4">
<div style="border: 1px solid #ddd; padding: 10px">
        <div class="switch">
          <input type="checkbox" {if $setting['openfrontlogin']} value="1" checked {else}value="0"{/if} name="openadminlogin" id="openadminlogin">
          <label>开启前端登录错误日志记录</label>
        </div>
        
        
    
      </div>
</div>
<div class="col-sm-8">
     <div style="border: 1px solid #ddd; padding: 10px">
          <form class="form-inline">
  <div class="form-group">
    <label for="exampleInputEmail3">登录错误最大次数：</label>
    <input type="number" {if !isset($setting['pwd_error_num'])}value="3"{else}value="$setting['pwd_error_num']"{/if} class="form-control" name="pwd_error_num" id="pwd_error_num" placeholder="">
  </div>
  <div class="form-group">
    <label for="exampleInputInviteCode3">登录错误超过最大次数后锁定时间</label>
    <input type="number"{if !isset($setting['pwd_error_locktime'])}value="30"{else}value="$setting['pwd_error_locktime']"{/if}  class="form-control" name="pwd_error_locktime" id="pwd_error_locktime" placeholder="">分钟
  </div>
  <button type="button" onclick="setloginsetting()" class="btn btn-primary">设置</button>
</form>
       </div>
       </div>
</div>
<div class="row">
<div class="col-sm-12"><p>共发现<span style="margin:0px 4px;"><b>{$rownum}</b></span>条记录</p></div>

</div>
<table class="table" >
  <thead>
    <tr>
      <th>id</th>
      <th>用户名</th>
      <th>用户uid</th>
       <th>登录ip</th>
         <th>尝试登录时间</th>
          <th>浏览器代理类型</th>
    </tr>
  </thead>
  <tbody>
  {loop $loginloglist $log}
    <tr>
      <td>{$log['id']}</td>
      <td><a  data-toggle="tooltip" data-placement="top" title="查看【$log['username']】信息" href="{url admin_user/edit/$log['uid']}" target="_blank">{$log['username']}</a></td>
       <td>{$log['uid']}</td>
        <td>{$log['ip']}</td>
         <td>{eval echo date('Y-m-d H:i:s',$log['logintime']);}</td>
           <td>{$log['useragent']}</td>
    </tr>
 {/loop}
  </tbody>

</table>
<div class="pages">{$departstr}</div>
</div>
<script type="text/javascript">
//或者在初始化时指定
$('[data-toggle="tooltip"]').tooltip({
    placement: 'bottom'
});
function setloginsetting(){
var _locktime=$.trim($("#pwd_error_locktime").val());
var _pwderrornum=$.trim($("#pwd_error_num").val());
$.post('{url admin/plugin/Frontloginlog/postfrontloginsetting}',{'pwd_error_locktime':_locktime,'pwd_error_num':_pwderrornum},function(result){
if(result.code==200){
	alert("设置成功！");
}else{
	alert("设置失败！");
}
	},'json').error(function(msg){
		alert("我呢个去，你居然点出问题了！");
		});
}
$("#openadminlogin").change(function(){
	var _target=$(this);
	var ckval=_target.val();
	$.post('{url admin/plugin/frontloginlog}',{'openfrontlogin':ckval},function(result){
		if(ckval==1){		
			_target.removeAttr("checked");
			new $.zui.Messager('已关闭', {
			    type: 'success' // 定义颜色主题
			}).show();
			_target.val(0);
		}else{
			_target.attr("checked");
			new $.zui.Messager('已开启', {
			    type: 'success' // 定义颜色主题
			}).show();
			_target.val(1);
		}
		},'json').error(function(msg){
			alert("我呢个去，你居然点出问题了！");
			});

	
});
</script>
<!--{template footer,admin}-->
</div>