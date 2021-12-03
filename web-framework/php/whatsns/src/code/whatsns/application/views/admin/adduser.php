<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;添加新用户</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table  class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
<div class="row mycontentform">
  <div class="col-md-6 col-sm-12 col-xs-12">
  <form action="index.php?admin_user/add{$setting['seo_suffix']}" method="post">
  <div class="form-group">
    <label for="exampleInputAccount1">账号</label>
    <input type="text" class="form-control" name="addname" placeholder="注册用户名">
  </div>
    <div class="form-group">
    <label for="exampleInputAccount1">密码</label>
    <input type="text" class="form-control" name="addpassword" placeholder="注册用户密码">
  </div>
     <div class="form-group">
    <label for="exampleInputAccount1">邮箱</label>
    <input type="text" class="form-control" name="addemail" placeholder="注册邮箱">
  </div>
<div class="form-group">
  <label class="radio-inline">
    <input type="radio" checked value="1" name="fromtype"> 专门用户采集和插件中(马甲)
  </label>
   <label class="radio-inline">
    <input type="radio" value="0" name="fromtype"> 网站正常注册用户(不参站内与模拟互动)
  </label>
</div>
  <button type="submit" name="submit" class="btn btn-danger">提交</button>
</form>
  </div>
</div>



<br />
<!--{template footer}-->