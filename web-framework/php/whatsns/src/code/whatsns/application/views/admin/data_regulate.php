<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;数据校正</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<table class="table">
    <tbody>
        <tr class="header" ><td>数据校正</td></tr>
        <tr class="altbg1"><td>校正系统由于异常情况导致的数据不一致的问题，例如分类问题数，问题回答数等</td></tr>
    </tbody>
</table>
<form action="index.php?admin_setting/search{$setting['seo_suffix']}" method="post">
    <table class="table">
        <tr>
            <td width="45%" class="altbg1"><b>分类数据校正</b><br><span class="smalltxt">校正分类问题数目</span></td>
            <td class="altbg2"><input type="button"  class="button" value="开始校正" id="category" onclick="regulate('category');"/></td>
        </tr>
        <tr>
            <td width="45%" class="altbg1"><b>问题数据校正({$qpages})</b><br><span class="smalltxt">校正问题回答数</span></td>
            <td class="altbg2"><input type="button"  class="button" value="开始校正" id="question" onclick="checkquestion();"/></td>
        </tr>
          <tr>
            <td width="45%" class="altbg1"><b>文章数据校正({$articlepages})</b><br><span class="smalltxt">校正文章关注和评论数</span></td>
            <td class="altbg2"><input type="button"  class="button" value="开始校正" id="article" onclick="checkarticle();"/></td>
        </tr>
        <tr>
            <td width="45%" class="altbg1"><b>用户数据校正({$userpages})</b><br><span class="smalltxt">校正用户提问回答数</span></td>
            <td class="altbg2"><input type="button"  class="button" value="开始校正" id="user" onclick="checkuser();"/></td>
        </tr>
          <tr>
            <td width="45%" class="altbg1"><b>动态数据校正({$userdoingpages})</b><br><span class="smalltxt">校正站内动态数</span></td>
            <td class="altbg2"><input type="button"  class="button" value="开始校正" id="btndoing" onclick="checkdonging();"/></td>
        </tr>
    </table>
</form>
<script type="text/javascript">
var userpages ={$userpages};
var userdoingpages ={$userdoingpages};
var qpages ={$qpages};
var articlepages ={$articlepages};
var user_num=0;
var doing_num=0;
var question_num=0;
var article_num=0;
function checkarticle(){
    $("#article").prop("disabled", "disabled");

	  $.get("{SITE_URL}index.php?admin_main/check_article/"+article_num, function(msg) {
          if(msg=='ok'){



        	  if(article_num<=articlepages){
        		  checkarticle();
        	  }else{
        		  article_num=0;
        		$("#article").val("已完成");
        		return false;
        	  }
        	 $("#article").val("正在校正,请稍等...("+article_num+"/"+articlepages+")");
        	 article_num++;


          }
      });
}
function checkuser(){

      $("#user").prop("disabled", "disabled");

    	  $.get("{SITE_URL}index.php?admin_main/check_user/"+user_num, function(msg) {
              if(msg=='ok'){


            	  $("#user").val("正在校正,请稍等...("+user_num+"/"+userpages+")");
            	  if(user_num<=userpages){
            		  checkuser();
            	  }else{
            		  user_num=0;
            		$("#user").val("已完成");
            		return false;
            	  }
            	  user_num++;


              }
          });


}
function checkdonging(){

    $("#btndoing").prop("disabled", "disabled");

  	  $.get("{SITE_URL}index.php?admin_main/check_doing/"+doing_num, function(msg) {
            if(msg=='ok'){


          	  $("#btndoing").val("正在校正,请稍等...("+doing_num+"/"+userdoingpages+")");
          	  if(doing_num<=userdoingpages){
          		checkdonging();
          	  }else{
          		doing_num=0;
          		$("#btndoing").val("已完成");
          		return false;
          	  }
          	doing_num++;


            }
        });


}
function checkquestion(){

    $("#question").prop("disabled", "disabled");

  	  $.get("{SITE_URL}index.php?admin_main/check_question/"+question_num, function(msg) {
            if(msg=='ok'){



          	  if(question_num<=qpages){
          		checkquestion();
          	  }else{
          		question_num=0;
          		$("#question").val("已完成");
          		return false;
          	  }
          	 $("#question").val("正在校正,请稍等...("+question_num+"/"+qpages+")");
          	question_num++;


            }
        });


}

    function regulate(type) {
        $("#"+type).val("正在校正,请稍等...");
        $("#"+type).prop("disabled", "disabled");
        $.get("{SITE_URL}index.php?admin_main/ajaxregulatedata/"+type, function(msg) {
            if(msg=='ok'){
                $("#"+type).val("已完成");
            }
        });
    }
</script>
<!--{template footer}-->