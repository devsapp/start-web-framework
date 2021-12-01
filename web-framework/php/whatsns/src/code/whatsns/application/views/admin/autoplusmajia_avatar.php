<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;马甲头像生成器</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<div style="margin-top:16px;margin-bottom:16px;background:#fff;">
<div class="alert alert-warning">
<p><b>友情提示</b></p>
<p>输入关键词+"头像结尾"，点击搜索。如:美女头像，帅哥头像，护士小姐姐头像，医生头像，律师头像，学生头像，女学生头像，男学生头像，外国人头像</p>
</div>

</div>

<div class="alert alert-info"><b>当前剩余{$rownum}个马甲头像没生成</b><p style="margin-top:8px;">(同一个词最多生成120个头像)</p></div>
<div class="row">
<div class="col col-md-12">
<form class="form-horizontal" action="{url admin_autocaiji/avatarset}" method="post" onsubmit="return checkword()">
<input type="hidden" name="setmode" id="setmode" value="0"/>
<input type="hidden" name="setmajianum" id="setmajianum" value="{$rownum}"/>
    <div class="form-group">
    <label for="exampleInputAccount4" class="col-sm-2">输入相关职业名称：</label>
    <div class="col-md-6 col-sm-10">
      <input type="text" class="form-control" value="{$kname}" name="keyword" id="keyword" placeholder="如:医生头像，护士头像，美女小姐姐头像，帅哥头像">
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default" onclick="setmodelfun(0)">头像搜索</button>&nbsp;&nbsp;&nbsp;
      <button type="submit" class="btn btn-primary" onclick="setmodelfun(1)">头像搜索并直接生成马甲头像</button>
    </div>
  </div>
  
      <div class="form-group">
    <label for="exampleInputAccount4" class="col-sm-2">抓取结果:</label>
    <div class="col-md-10 col-sm-10">
    {if $rownum==0}
    <div style="margin-top:8px;margin-bottom:8px;color:red;"><b>没有需要生成的马甲头像</b></div>
    {/if}
    {if $avatarlist&&$setmode==0||$rownum==0}
<div class="row">
{loop $avatarlist $avatar}
<div class="col col-md-1" style="padding:16px;">
<img src="$avatar"  style="width:65px;height:65px;"/>
<div><input type="checkbox" value="{$avatar}" name="majiackbox" class="majiackbox">选择</div>
</div>
{/loop}
</div>
{if $avatarlist&&$setmode==0}
<button id="batchUpdate" type="button" class="btn btn-default" style="margin-top:16px;margin-bottom:16px;">批处理已选头像</button>
&nbsp;&nbsp;&nbsp;&nbsp;
<span><input type="checkbox" name="ckall" class="ckallmajiackbox">全选</span>
<div style="margin-top:16px;">
<p class="cktip" style="color:blue;"></p>
</div>

<div style="margin-top:16px;" id="showresult" sytle="display:none;">
<p><b>生成结果:</b></p>
<ul class="resultlist items" style="padding-left:0px;">
<li></li>
</ul>
</div>
{/if}
{/if}

  {if $avataruserlist&&$setmode==1&&$rownum>0}
<div class="row">
{loop $avataruserlist $avatar}
<div class="col col-md-1" style="padding:16px;">
<a title="{$avatar['username']}" href="{url user/space/$avatar['uid']}" target="_blank">
<img src="{$avatar['avatar']}"  style="width:65px;height:65px;"/>
<div>{eval cutstr($avatar['username'],4);}</div>
</a>
</div>
{/loop}
</div>


{/if}

    </div>
  </div>
  
</form>


</div>
</div>
<script type="text/javascript">
var _setmajiaindex=1;
function ajaxpostavatar(avatarurl){
	var canset=1;
  var _url="{url admin_autocaiji/makeavatar}";
  var _data={"url":avatarurl}
  function success(result){
	  if(result.code==200){
		  _setmajiaindex=1;
		  $(".resultlist").append("<li class='item' style='min-height:40px;line-height:40px;color:blue;'><a href='"+result.spaceurl+"' target='_blank'><b>"+result.msg+"</b></a></li>");
		  
	    }
	 
	    console.log(result);
    if(result.code==400){
    	canset=0;
    	_setmajiaindex=0;
    	 $(".resultlist").append("<li class='item' style='min-height:40px;line-height:40px;color:blue;'><b>"+result.msg+"</b></li>");
     	
    }
  }
  $.post(_url,_data,success,"JSON");
  return canset;
}
$(".ckallmajiackbox").change(function() {
	if($('.ckallmajiackbox').is(':checked')){
		console.log("选择");
		$("input[name='majiackbox']").prop("checked", $(this).is(":checked"));
	}else{
		console.log("没有选择");
		$("input[name='majiackbox']").prop("checked", $(this).is(":checked"));
	     
		
	}
	var _len=$("input[name='majiackbox']:checked").length;
	$(".cktip").html("<b>已选中"+_len+"个马甲</b>");

	});
$(".majiackbox").change(function() {
	var _len=$("input[name='majiackbox']:checked").length;
$(".cktip").html("<b>已选中"+_len+"个马甲</b>");
	});
//批量处理
$('#batchUpdate').on("click", function () {
	var _len=$("input[name='majiackbox']:checked").length;
	var _numavatar=$.trim($("#setmajianum").val());
	if(_numavatar==0){
		alert("当前没有需要生成的马甲头像");
		return false;
	}
	if(_len==0){
		alert("还没选择需要处理的头像");
return false;
	}
    var str = "";
    var _canset=1;
    $("input[name='majiackbox']:checked").each(function (index, item) {
    	
    	if(_setmajiaindex==1){
    		_canset=ajaxpostavatar($(this).val());
    	}
       console.log($(this).val());
    });
});

function checkword(){
	var _word=$.trim($("#keyword").val());
	if(_word==''){
		alert("搜索关键词不能为空");
return false;
	}
}
function setmodelfun(_val){

	$("#setmode").val(_val)
}

</script>
<!--{template footer}-->