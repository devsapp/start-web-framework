//文章详情页面操作 application/views/widescreen/topicone.php 文件
function getarticlecaozuo(_type,tid){
	
	var _url=g_site_url+"index.php?cdnajax/getarticlecaozuo/"+_type+"/"+tid;
	$.get(_url,function(msg){
		
		switch(_type){
		case 1: //文章详情页面--操作菜单
			$(".cdn_ajax_articlecaozuo").html(msg);
			break;
		case 2: //文章详情页面--可收藏和可评论和可举报按钮状态
			$(".cdn_ajax_articlefavoriteandcommentbtn").html(msg);
			break;
		case 3: //文章详情页面--评论+评论框
			$(".cdn_ajax_articlecomment").html(msg);
			break;
		case 4: //文章详情页面--发布文章作者信息
			$(".cdn_ajax_userinfo").html(msg);
			break;
		case 5: //文章详情页面--文章详情顶部固定文章信息提示
			$(".cdn_ajax_articletop").html(msg);
			break;
		case 6: //侧边作者栏 application/views/default文件夹site_author.php文件
			$(".cdn_hotauthorlist").html(msg);
			break;
		case 7: //非plus版窄屏模板首页登录配置
			$(".cdn_userinfolist").html(msg);
			break;
		}
	

		
	});
}
//问题相关操作方法
function getquestioncaozuo(_type,qid,aid=0){
	
	var _url=g_site_url+"index.php?cdnajax/getquestioncaozuo/"+_type+"/"+qid;
	if(_type==5||_type==6){
		_url=_url+"/"+aid;
	}
	$.get(_url,function(msg){
		
		switch(_type){
		case 1: //application/views/default/solve.php--顶部固定提示
			$(".cdn_question_fixedtitle").html(msg);
			break;
		case 2: //application/views/default/solve.php--操作问题菜单
			$(".cdn_question_caozuo").html(msg);
			break;
		case 3: //application/views/default/solve.php--发布者个人信息
			$(".cdn_question_userinfo").html(msg);
			break;
		case 4: //application/views/default/solve.php--问题操作菜单
			$(".cdn_question_button").html(msg);
			break;
		case 5: //application/views/default/solve.php--回答操作权限
			
			$(".cdn_question_answer"+aid).html(msg);
			break;
       case 6: //application/views/default/solve.php--最佳回答操作权限
			
			$(".cdn_question_bestanswer"+aid).html(msg);
			break;
       case 7: //application/views/default/solve.php--问答邀请
			
			$(".cdn_question_invate").html(msg);
			break;
		}
	

		
	});
}