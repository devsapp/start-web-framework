<!--{template header}-->
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
此功能建议最多一周推送一次内容，全站用户会收到邮件通知
</div>
<a class="btn" target="_blank" style="background:#3280fc" href="https://www.ask2.cn/article-15511.html">查看精选内容推荐模板图片替换教程</a>
<form  method="post" >
<h5>发送须知：</h5>
<div class="alert" style="">
此功能会推荐每周热门文章，热门问题，热门用户给用户，发送邮件每日数量由邮箱提供服务商决定，具体有多少人能收到邮件，本程序不能决定，部分人可能不能收到邮件，可以参考这个地址：
https://jingyan.baidu.com/article/454316ab01ce28f7a7c03a01.html
</div>
<button name="button" id="weekuser" onclick="check()" class="btn btn-info" type="button">发送邮件</button>
</form>
<script type="text/javascript">
var userpages ={$userpages};
var user_num=0;
function checkweekemail(){

    $("#weekuser").prop("disabled", "disabled");

  	  $.get("{SITE_URL}index.php?Admin_emailpush/emailsend/"+user_num, function(msg) {
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
            }
        });


}
function check(){
	if(confirm("确定推送吗？该设置不可逆，发送后不可撤回！")){
		checkweekemail()
	}
	

}
</script>
<!--{template footer}-->
