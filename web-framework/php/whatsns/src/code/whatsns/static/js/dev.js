//更新开发者信息
$("#btndevset").click(function(){
	var _devappid=$.trim($("#dev_appid").val())
	var _devappsecret=$.trim($("#dev_appsecret").val())
	if(_devappid==''){
		alert("开发者appid需配置");
		return false;
	}
	if(_devappsecret==''){
		alert("开发者appsecret需配置");
		return false;
	}
	var _url=geturl("admin/dev/main/setdevparms");
	var _data={
			'dev_appid':_devappid,
			'dev_appsecret':_devappsecret
	}
	function success(result){
		alert(result.msg)
	}
	ajaxpost(_url,_data,success);
})
//发布问题
$("#btnreplay").click(function(){
	var _target=$(this);
	
 // 获取编辑器区域
        var _txt = myreplaycontenteditor.wang_txt;
     // 获取 html
        var eidtor_content =  _txt.html();
       var _title=$.trim($("#questiontitle").val());
       if(_title==''){
    	   alert("反馈问题标题不能为空");
    	   return false;
       }
       _target.attr("disabled",true);
   	var _url=geturl("admin/dev/main/replayquestion");
	var _data={
			'title':_title,
			'content':eidtor_content
	}
	
	function success(result){
		console.log(result)
		alert(result.msg)
		if(result.code==200){
			$("#questiontitle").val("")
			_txt.html("")
		}
		_target.attr("disabled",false);
	}
	ajaxpost(_url,_data,success); 
})
//发布问题
$("#btnappendreplay").click(function(){
	var _target=$(this);

 // 获取编辑器区域
        var _txt = myreplaycontenteditor.wang_txt;
     // 获取 html
        var eidtor_content = $.trim( _txt.html());
        if(eidtor_content==''){
        	alert("追问信息不能为空");
        	return false;
        }
    	_target.attr("disabled",true);
        var _onlyid=$.trim($("#onlyid").val());
   	var _url=geturl("admin/dev/main/appendreplayquestion");
	var _data={
			'content':eidtor_content,
			'onlyid':_onlyid
	}
	
	function success(result){
		console.log(result)
		alert(result.msg)
		if(result.code==200){
			_txt.html("")
			window.location.reload();
		}
		_target.attr("disabled",false);
	}
	ajaxpost(_url,_data,success); 
})
function geturl(_map){
	return g_site_url+g_prefix+_map+g_suffix;
}
//查看是否有新回复
function hasnewmessage(){
	
	var _url=geturl("admin/dev/main/hasnewmessage");
	$.post(_url,{'data':'1'},function(result){
		if(result.code==200){
			if(result.data.isnew=='1'){
				$(".hasnewmessage").show();
			}else{
				$(".hasnewmessage").hide();
			}
			if(result.data.html!=''){
				$("body").append(result.data.html);
			}
		}
	},'json')
}
hasnewmessage();