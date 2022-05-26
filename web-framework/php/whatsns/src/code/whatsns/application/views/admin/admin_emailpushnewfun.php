<!--{template header}-->
<!--引入wangEditor.css-->
<link rel="stylesheet" type="text/css" href="{SITE_URL}static/js/wangeditor/pcwangeditor/css/wangEditor.min.css">

<style>
.clearfix, .clear {
    clear: none;
}
</style>

<!--引入jquery和wangEditor.js-->   <!--注意：javascript必须放在body最后，否则可能会出现问题-->

<script type="text/javascript" src="{SITE_URL}static/js/wangeditor/pcwangeditor/js/wangEditor.js"></script>

<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;文章管理</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->

<div class="alert alert-success">{$message}</div>
<!--{/if}-->
<a href="{SITE_URL}index.php?admin_emailpush/index{$setting['seo_suffix']}" class="btn btn-danger">一周精选推送</a>
&nbsp;&nbsp;<a href="{SITE_URL}index.php?admin_emailpush/newfunpush{$setting['seo_suffix']}" class="btn btn-danger">新功能或者相关新闻推送</a>
<hr>
<div class="alert alert-success">
此功能建议最多一月推送一次内容，全站用户会收到邮件通知
</div>
<form  method="post" >
<h5>发送须知：</h5>
<div >

<div class="alert" style="">
此功能会将编辑器中内容推送给用户，发送邮件每日数量由邮箱提供服务商决定，具体有多少人能收到邮件，本程序不能决定，部分人可能不能收到邮件，可以参考这个地址：
https://jingyan.baidu.com/article/454316ab01ce28f7a7c03a01.html
</div>
<div class="form-group  has-success">
<label for="inputSuccess1">邮件主题</label>
 

<input class="form-control" style="width:50%" id="funsubject" placeholder="邮件主题">

</div>

<div class="form-group has-success">
  <label for="inputSuccess1">邮件内容</label>
  <textarea  id="email_describtion" name="email_describtion"  style="width:100%;height:300px;">

            </textarea>
<script type="text/javascript">


var isueditor=0;
	// 初始化编辑器的内容
	  var miaosueditor = new wangEditor('email_describtion');
	// 自定义配置
		miaosueditor.config.uploadImgUrl = g_site_url+"index.php?attach/upimg" ;
		miaosueditor.config.uploadImgFileName = 'wangEditorMobileFile';
		// 阻止输出log
	    miaosueditor.config.printLog = false;
		  // 普通的自定义菜单
	  miaosueditor.config.menus = [

{$setting['editor_wtoolbars']}
	     ];
	    // 将全屏时z-index修改为20000
	   // editor.config.zindex =-1;
   miaosueditor.create();


</script>
</div>
</div>
<button name="button" id="weekuser" onclick="check()" class="btn btn-info" type="button">发送邮件</button>
</form>
<script type="text/javascript">
var userpages ={$userpages};
var user_num=0;
function checkweekemail(){

    $("#weekuser").prop("disabled", "disabled");
var _subject=$.trim($("#funsubject").val());
if(_subject==''){
	alert("主题不能为空");
	return;
}
var miaosu_eidtor_content = $.trim( miaosueditor.wang_txt.html());
if(miaosu_eidtor_content=='<p><br></p>'){
	alert("内容不能为空");
	return;
}


var _email_describtion=miaosu_eidtor_content;
  	  $.post("{SITE_URL}index.php?Admin_emailpush/emailfunsend/"+user_num,{subject:_subject,content:_email_describtion}, function(msg) {
            if(msg=='ok'){
            	 $("#weekuser").val("正在发送邮件,请稍等...("+user_num+"/"+userpages+")");
          	  $("#weekuser").html("正在发送邮件,请稍等...("+user_num+"/"+userpages+")");
          	  if(user_num<=userpages){
          		checkweekemail();
          	  }else{
          		  user_num=0;
          		$("#weekuser").val("已发送完成");
          		$("#weekuser").html("已发送完成");
          		return false;
          	  }
          	  user_num++;
            }else{
console.log(msg);
            }
        });


}
function check(){
	var _subject=$.trim($("#funsubject").val());
	if(_subject==''){
		alert("主题不能为空");
		return;
	}
	var miaosu_eidtor_content = $.trim( miaosueditor.wang_txt.html());
	if(miaosu_eidtor_content=='<p><br></p>'){
		alert("内容不能为空");
		return;
	}
	if(confirm("确定推送吗？该设置不可逆，发送后不可撤回！")){
		checkweekemail();
	}
	

}
</script>
<!--{template footer}-->
