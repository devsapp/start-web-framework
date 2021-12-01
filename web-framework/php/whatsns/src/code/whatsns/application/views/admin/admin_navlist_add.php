<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;添加后台导航</div>
</div>
<!--{if isset($message)}-->
<div class="alert alert-warning">{$message}</div>
<!--{/if}-->

<div class="row mycontentform">
  <div class="col-md-6 col-sm-12 col-xs-12">
  <form {if $type=='edit'}action="index.php?admin_nav/manageredit{$setting['seo_suffix']}"{/if} {if $type=='add'}action="index.php?admin_nav/manageradd{$setting['seo_suffix']}"{/if} method="post" onsubmit="return checkform()">
  <div class="form-group">
    <label for="name">导航名字:</label>
    <input type="text" class="form-control" value="{$name}" autocomplete="off" id="navname"  name="name" placeholder="后台导航名字">
  </div>
   
  <div class="form-group">
    <label for="pid">父级菜单(下拉只展示顶级导航，只支持最深二级):</label>
  
      <select class="form-control" name="pid" id="navpid" >
        <option value="0">不选择</option>
        {loop $navlist $nav}
        <option value="{$nav['id']}" {if $navpid==$nav['id']}selected{/if}>{$nav['name']}</option>
        {/loop}
      </select>
   
     </div>
     <div class="form-group">
    <label for="url">导航地址(一级导航，地址留空)：</label>
    <input type="text" class="form-control" id="navurl"  value="{$url}" autocomplete="off" name="url" placeholder="如果是一级导航，此项为空">
  </div>
  <button type="submit" name="submit" class="btn btn-danger">提交</button>
</form>
  </div>
</div>
<div style="margin-top: 16px;margin-left:16px;background:#fff;">
<p><b>提示</b></p>
<p>1. url如果写绝对路径请以http或者https开头</p>
<p>2. 一级导航，url留空</p>
</div>
<script>
function checkform(){
	var _navname=$.trim($("#navname").val());
	var _navpid=$.trim($("select[name='pid']").val());
	var _navurl=$.trim($("#navurl").val());
	if(_navname==''){
alert("导航名称不能为空");
return false;
	}
	if(_navpid==0&&_navurl!=''){
		alert("一级导航地址请留空");
		return false;
	}
}
</script>
<!--{template footer}-->