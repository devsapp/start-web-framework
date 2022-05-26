var has_submitposter=false;
var _elhaibao;//加载进度条元素
var _elpostpop;//海报弹出层
function ajaxloading(text){
	_elhaibao=document.createElement("div");
	_elhaibao.id="ajax_loading";
	_elhaibao.innerHTML="<div style='border-radius: 5px;;font-size: 14px;;color: #fff;background: #000;opacity: 0.8;width: 80px;height: 80px;line-height:80px;text-align:center;position: fixed;top:50%;left: 48%;z-index:999999999;'>"+text+"</div>";
    document.body.appendChild(_elhaibao);
    return _elhaibao;
}
function removeajaxloading(){
    document.body.removeChild(_elhaibao);
}
//显示海报-siteurl 网站网址，postid-处理对象id--posttype处理类型
function showposter(siteurl,postid,posttype){
	if(has_submitposter==true){
		return false;
	}
	var url=siteurl+"?poster/ajaxmake/"+posttype+"/"+postid+".html"
	var poplayer='<div class="whatsns-share-bg"><div class="top_tips" style="display: block;">请长按图片，将内容推荐给好友</div></div>';
	var popcontent='<div class="whatsns-share-wrap"><img src="'+url+'"><div onclick="closeposter()" class="whatsns-share-close">×</div></div>';
	has_submitposter=true;

	_elpostpop=document.createElement("div");
	_elpostpop.id="postpop";
	_elpostpop.innerHTML=poplayer+popcontent;
    document.body.appendChild(_elpostpop);
  
}
function closeposter(){
	document.body.removeChild(_elpostpop);
	 has_submitposter=false;
}