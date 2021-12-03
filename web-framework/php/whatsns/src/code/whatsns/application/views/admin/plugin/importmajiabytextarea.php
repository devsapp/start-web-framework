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
<form class="form-horizontal">
  <div class="form-group">
    <label for="exampleInputAccount4" class="col-sm-2">用户名(一行一个):</label>
    <div class="col-md-6 col-sm-10">
     <textarea name="usernames" id="usernames" class="form-control" rows="10" placeholder="一行一个用户名"></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="exampleInputAddress1" class="col-sm-2">性别</label>
    <div class="col-sm-3">
      <select class="form-control" name="usersex" id="usersex">
        <option value="-1">随机</option>
        <option value="1">男</option>
        <option value="0">女</option>
      </select>
    </div>
 
  </div>
    <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox" value="1"  name="useravatar" id="useravatar"  checked> 自动生成头像
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button onclick="importuser()" type="button" class="btn btn-default">导入</button>
    </div>
  </div>
</form>
<div class="divaravar" style="margin-top:8px;border:solid 1px #ebebeb;background:#fff;">

</div>
<script>
function importuser(){

	var _usernames=$.trim($("#usernames").val());
	var _usersex=$.trim($("#usersex").val());
	var _useravatar=$.trim($("input:checkbox:checked").val());
	if(_usernames==''){

		alert("请输入用户名，一行一个");
		return false;
	}
	var data={usernames:_usernames,usersex:_usersex,useravatar:_useravatar};
	function success(result){
		console.log(result.message);
		$("#usernames").val(result.message.replace(/<br>/g,'\n'))
	}
	var _url="{url admin_majia/importmajiabytextarea}";
	ajaxpost(_url,data,success);
		
		return false;
	}
</script>
<!--{template footer,admin}-->
</div>