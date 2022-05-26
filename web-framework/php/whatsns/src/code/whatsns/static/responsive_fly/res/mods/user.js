/**

 @Name: 用户模块

 */
 
layui.define(['laypage', 'fly', 'element', 'flow'], function(exports){

  var $ = layui.jquery;
  var layer = layui.layer;
  var util = layui.util;
  var laytpl = layui.laytpl;
  var form = layui.form;
  var laypage = layui.laypage;
  var fly = layui.fly;
  var flow = layui.flow;
  var element = layui.element;
  var upload = layui.upload;
  var popusertimer = null;
  var query = '?';
  var has_submit=false;
  var gather = {}, dom = {
    mine: $('#LAY_mine')
    ,mineview: $('.mine-view')
    ,minemsg: $('#LAY_minemsg')
    ,infobtn: $('#LAY_btninfo')
  };
  function gopwdsms(){
		 var _phone = $("#userphone").val();
		  var _rs=check_phone(_phone);
		if(!_rs){
			layer.msg("手机号码有误");  
			 return false;
		}
	 $.post(g_site_url+"index.php?user/getpwdsmscode", {phone: _phone}, function(flag) {
		   flag=$.trim(flag);
	 if(flag==1){
	 	var _timecount=60;
	 	var _listener= setInterval(function(){
	 		--_timecount;
	 		$("#testphonebtn").html(_timecount+"s后获取");
	 		$("#testphonebtn").addClass("layui-btn-disabled");
	 		if(_timecount<=0){
	 			clearInterval(_listener);
	 		$("#testphonebtn").removeClass("layui-btn-disabled").html("发送短信");;
	 		}
	 	},1000);
	 }else{
		  
	 if(flag==0){
		 layer.msg("平台短信已经关闭");
		   }else if(flag==2){
			   layer.msg("手机号没有在网站注册");
		   }else if(flag==3){
			   layer.msg("手机号不正确");
		   }else{
			   if(flag==5){
				   layer.msg("稍后获取验证码");
		   }else{
			   layer.msg(flag);
		   }
			  
		   }
		  
	 }
	 });
	}
  $("#testphonebtn").on("click",function(){
	  gopwdsms();
  })
   $("#testregphonebtn,#sendphonecode").on("click",function(){
	   gosms();
  })
  function check_phone(_phone){

		 if(!(/^1(1|2|3|4|5|6|7|8|9)\d{9}$/.test(_phone))){ 
		       
		        return false; 
		    }else{
		    	return true;
		    }
	}
  function gosms(_type){
  	 var _phone = $("#userphone").val();
  	  var _rs=check_phone(_phone);
  	if(!_rs){
  		layer.msg("手机号码有误");  
  		 return false;
  	}
    $.post(geturl("user/getsmscode"), {phone: _phone,type:'reg'}, function(flag) {
  	   flag=$.trim(flag);
    if(flag==1){
    	var _timecount=60;
    	var _listener= setInterval(function(){
    		--_timecount;
    		$("#testregphonebtn").html(_timecount+"s后获取");
    		$("#testregphonebtn").addClass("layui-btn-disabled");
    		if(_timecount<=0){
    			clearInterval(_listener);
    		$("#testregphonebtn").removeClass("layui-btn-disabled").html("发送短信");;
    		}
    	},1000);
    }else{
   if(flag==0){
	   layer.msg("平台短信已经关闭");
  	   }else if(flag==2){
  		 layer.msg("手机号没有在网站注册");
  	   }else if(flag==3){
  		 layer.msg("手机号不正确");
  	   }else{
  		   if(flag==5){
  			 layer.msg("稍后获取验证码");
  	   }else{
  		 layer.msg(flag);
  	   }
  		  
  	   }
  	  
    }
    });
  }
  function getemailcode(){
		 var _code = $.trim($('#code').val());

		 var _email = $.trim($('#email').val());
		 if(code==''){
			 layer.msg("验证不能为空");
			 return false;
		 }
	    $.ajax({
	        //提交数据的类型 POST GET
	        type:"POST",
	        //提交的网址
	        url:g_site_url+'index.php?user/ajaxsendpwdmail',
	        data:{email:_email,code:_code},
	        //返回数据的格式
	        datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".

	        //成功返回之后调用的函数
	        success:function(data){
	        
	        	var data=eval("("+data+")");
	        	layer.msg(data.msg)
	         if(data.code=='2000'){
	        	  	var _timecount=60;
	        	  	var _listener= setInterval(function(){
	        	  		--_timecount;
	        	  		$("#testbtn").html(_timecount+"s后获取");
	        	  		$("#testbtn").addClass("layui-btn-disabled");
	        	  		if(_timecount<=0){
	        	  			clearInterval(_listener);
	        	  		$("#testbtn").removeClass("layui-btn-disabled").html("发送验证码");;
	        	  		}
	        	  	},1000);
	        	 return false;
	         }

	        }   ,

	        //调用出错执行的函数
	        error: function(){
	            //请求出错处理
	        }
	    });
	}
  $("#testbtn").on("click",function(){
	  getemailcode();
  })
  
  $("#login_submit").click(function(){
		 var _forward=$("#forward").val();
	    var _uname=$("#xm-login-user-name").val();
	    var _upwd=$("#xm-login-user-password").val();
	    var _apikey=$("#tokenkey").val();
	 
	    	var loading = null;
	    $.ajax({
	        //提交数据的类型 POST GET
	        type:"POST",
	        //提交的网址
	        url:g_site_url+g_prefix +"api_user/loginapi"+g_suffix ,
	        //提交的数据
	        data:{uname:_uname,upwd:_upwd,apikey:_apikey},
	        //返回数据的格式
	        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
	        beforeSend: function () {

	        	loading=layer.load(0, {
	                shade: false,
	                time: 2*1000
	            });
	         },
	        //成功返回之后调用的函数
	        success:function(data){
	        	data=$.trim(data);
				console.log(data)
			
						if(data.indexOf('ok|')>=0){
					var datastrs=data.split('|');
					$("body").append(datastrs);
					data='login_ok';
				}
	            if(data=='login_ok'){





	             	
	            	if(_forward.indexOf('user/getphonepass')>=0||_forward.indexOf('user/getpass')>=0||_forward.indexOf('user/logout')>=0||_forward.indexOf('user/checkemail')>=0){
	             		window.location.href=g_site_url;
	             	}else{
	             		window.location.href=_forward;
	             	}





	            }else{
	            	  switch(data){
	            	  case 'login_null':
	            		 layer.msg("用户名或者密码为空", {
	           			  time: 1500 
	         			});
	            		  break;
	 case 'login_user_or_pwd_error':
		 layer.msg("用户名或者密码错误", {
			  time: 1500 
			});
	            		  break;
	default:
		layer.msg(data, {
			  time: 1500 
			});
		break;
	            	  }
	            }
	        }   ,
	        complete: function () {
	        	layer.close(loading);
	         },
	        //调用出错执行的函数
	        error: function(){
	      	 layer.msg("请求异常", {
	 			  time: 1500 
			});
	            //请求出错处理
	        }
	    });
	});
  $(".btnattentionhuati").on("click",function(){
	
	  attentto_cat($(this).attr("data-id"))
  })
 window.login= function(){
	  window.location.href=g_site_url+g_prefix+"user/login"+g_suffix ;
  }
  window.updatecode=function () {

	  var img = geturl("user/code");
	  $(".changecode").parent().find('img').attr("src", img);
	}
  window.viewtopic=function(tid){
		if(g_uid==0){
			login();
		}
	    layer.open({
	        type: 2,
	        title: '付费阅读',
	        maxmin: true,
	        shadeClose: true, //点击遮罩关闭层
	        area : ['200px' , '240px'],
	        content: geturl("topic/ajaxviewtopic/"+tid)
	      });
	
	}
  /*关注分类*/
function attentto_cat(cid) {
    if (g_uid == 0) {
        login();
    }
 
    $.post(g_site_url + "index.php?category/attentto", {cid: cid}, function(msg) {
        if (msg == 'ok') {
            if ($("#attenttouser_"+cid).hasClass("layui-btn-primary")) {
            	  $("#attenttouser_"+cid).removeClass("layui-btn-primary");
                  $("#attenttouser_"+cid).addClass("layui-btn-normal");
                  
                  $("#attenttouser_"+cid).html('+关注话题');
            } else {
             
                
                $("#attenttouser_"+cid).removeClass("layui-btn-normal");
                $("#attenttouser_"+cid).addClass("layui-btn-primary");
                
                $("#attenttouser_"+cid).html('取消关注');
            }
           
        }else{
        	if(msg == '-1'){
        		layer.msg("先登录在关注");
        	}else{
        		layer.msg(msg);
        	}
        }
    });
}
$("#ajaxsubmitasnwer").click(function(){
	postask();

    
});
function postask(){
	 ctrdown=false;
	 returndown=false;
	 var eidtor_content='';
     if(typeof testEditor != "undefined"){
   	  var tmptxt=$.trim(testEditor.getMarkdown());
   	  if(tmptxt==''){
   		layer.msg("回答内容不能为空");
   		  return;
   	  }
   	  eidtor_content= testEditor.getHTML();
     }else{
   	  if (typeof UE != "undefined") {
   			 eidtor_content= editor.getContent();
   		}else{
   			 eidtor_content= $.trim($("#editor").val());
   		}
     }
	
	
	
	if(eidtor_content==''){
		layer.msg("回答内容不能为空");
		 return;
		
	}
	

	
	 var _chakanjine=$("#chakanjine").val();
	 if(_chakanjine!=0){
		 if(_chakanjine>10||_chakanjine<0.1 ){
			 layer.msg("查看金额在0.1-10元之间");
  		 return false;
  	 }
	 }
	 var data=null;
	 if(needcode){
		  data={
				  tokenkey:$("#tokenkey").val(),
		 			content:eidtor_content,
		 			chakanjine:_chakanjine,
		 			qid:$("#ans_qid").val(),
		 			title:$("#ans_title").val(),
		 			code:$("#code").val()
		 	}
	 }else{
		  data={
				  tokenkey:$("#tokenkey").val(),
		   			content:eidtor_content,
		   			chakanjine:_chakanjine,
		   			qid:$("#ans_qid").val(),
		     			title:$("#ans_title").val(),
		   			
		   	}
	 }
	 
	   
		
	   if(has_submit){
		   layer.msg("提交中,稍后操作....");
		   return false;
	   }
	  
	 var url=g_site_url+"index.php?question/ajaxanswer";
	$.ajax({
      //提交数据的类型 POST GET
      type:"POST",
      //提交的网址
      url:url,
      //提交的数据
      data:data,
      async: false,
      //返回数据的格式
      datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
      //在请求之前调用的函数
      beforeSend:function(){has_submit=true; },
      //成功返回之后调用的函数             
      success:function(data){
      	var data=eval("("+data+")");
         if(data.message=='ok'||data.message.indexOf('成功')>=0){
        	 layer.msg(data.message);
      
      	   setTimeout(function(){
                 window.location.reload();
             },1500);
         }else{
        	 layer.msg(data.message);
         }
        
       
      }   ,
      //调用执行后调用的函数
      complete: function(XMLHttpRequest, textStatus){
   	   
   	   has_submit=false;
      },
      //调用出错执行的函数
      error: function(){
          //请求出错处理
      }         
   });
}
$(".delcomment").click(function(){
	if(confirm("确认删除评论吗？")){
		deletewenzhang($(this).attr("data-id"),$(this).attr("data-tid"));
	}
	
})
function deletewenzhang(current_aid,current_tid){
	window.location.href=g_site_url + "index.php" + query + "topic/deletearticlecomment/"+current_aid+"/"+current_tid;

}
//发布文章评论
$(".btn-cm-submit").click(function(){
	postarticle();

    
});
function postarticle(){
	 ctrdown=false;
	 returndown=false;
	 var artcomment=$.trim($(".comment-area").val());
   var _tid=$("#artid").val();
   var _artitle=$("#artitle").val();
   
	var url=geturl("topic/ajaxpostcomment");
	if(artcomment==''){
		 layer.msg("评论不能为空")
	  
		return false;
	}
   $.ajax({
       //提交数据的类型 POST GET
       type:"POST",
       //提交的网址
       url:url,
       //提交的数据
      data:{title:_artitle,tid:_tid, content:artcomment},
       //返回数据的格式
       datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
       beforeSend: function () {
   
       },
       //成功返回之后调用的函数
       success:function(data){
         
            
           var  jsondata=eval('(' + data+ ')');
          
           layer.msg(jsondata.msg)
     
          
          if(jsondata.state==1){
       	   window.location.reload();
          }
          if(jsondata.state==-1){
       	   login();
          }
          
       }   ,
       complete: function () {
         
       },
      
       //调用出错执行的函数
       error: function(){
           //请求出错处理
       }
   });
}
$(".button_commentagree").click(function(){
    var supportobj = $(this);
            var tid = $(this).attr("id");
            $.ajax({
            type: "GET",
                    url:geturl("topic/ajaxhassupport/"+tid),
                    cache: false,
                    success: function(hassupport){
                    if (hassupport != '1'){






                            $.ajax({
                            type: "GET",
                                    cache:false,
                                    url: geturl("topic/ajaxaddsupport/"+tid),
                                    success: function(comments) {

                                    supportobj.find("em").html(comments);
                                    }
                            });
                    }else{
                   	 layer.msg("您已经赞过");
                    }
                    }
            });
    });
function addarticlecomment(_tid,_aid,_comment,_touid){
	var data={
			tid:_tid,
			aid:_aid,
			content:_comment,
			touid:_touid
	}
	var url=geturl("topic/ajaxaddarticlecomment");
	function success(result){
		layer.msg(result.msg)
		if(result.code==200){
			$(".commenttext"+_aid).val("");
			loadarticlecommentlist(_aid,_tid);
		}
	}
	ajaxpost(url,data,success);
}
$(".btn-sendartcomment").click(function(){
	var _aid=$(this).attr("dataid");
	var _tid=$(this).attr("datatid");
	var _content=$.trim($(".commenttext"+_aid).val());
	if(_content==''){
		layer.msg("评论内容不能为空");
		return false;
	}
	var touid=$("#btnsendcomment"+_aid).attr("touid");
	if(touid==null){
		touid=0;
	}
	addarticlecomment(_tid,_aid,_content,touid);
})

function loadarticlecommentlist(_id,_tid){
	var data={
			tid:_tid,
			aid:_id
			
	}
	var url=geturl("topic/ajaxgetcommentlist");
	function success(result){
		if(result.code=200){
			$(".commentlist"+_id).html("");
			var json=JSON.parse(result.msg);
			console.log(json.length)

			 for(var i=0,l=json.length;i<l;i++){
				 
				    console.log(json[i]['content'])
			       
				    var conli = '<div id="comment-'+json[i]['id']+'" class="sub-comment">'+
		             '<p>'+
		              '<div data-v-f3bf5228="" class="v-tooltip-container" style="z-index: 0;">'+
		              '<div class="v-tooltip-content">'+
		              '<a href="'+json[i]['userhomelink']+'" target="_blank">'+json[i]['author']+'</a>：'+
		           '</div></div> <span>' 
		        
		           + json[i]['content']+
		            
		             '</span> </p><div class="sub-tool-group"><span>'+ json[i]['time']+ 
		            
		             '</span> <a class=""><i class="fa fa-comment"></i> <span author="'+ json[i]['author']+'"authorid="'+ json[i]['authorid']+'" class="huifu hand">回复</span></a><a class="subcomment-delete hand">'
		             
		             +json[i]['deltag']+
		             ' </a> </div></div>';

				    $(".commentlist"+_id).append(conli);
			    
			 }
			//回复
			$(".commentlist"+_id).find(".huifu").click(function(){
				var _authorid=$(this).attr("authorid");
				var _author=$(this).attr("author");
				$(".commenttext"+_id).val("");
				$(".commenttext"+_id).attr("placeholder","@"+_author+" ");
				$(".formcomment"+_id).removeClass("hide");
				$(".commenttext"+_id).focus();
				$("#btnsendcomment"+_id).attr("touid",_authorid);
			});
			$(".commentlist"+_id).find(".deltag").click(function(){
				var _cid=$(this).attr("dataid");
				var data={
						id:_cid
				}
				function mysuccess(result){
					if(result.code==200){
						$(".commentlist"+_id).find("#comment-"+_cid).remove();
					}else{
						alert(result.msg)
					}
				}
				var _url=geturl("topic/ajaxdelartcomment");
				   ajaxpost(_url,data,mysuccess);
			})
			 
		}else{
			alert(result.msg)
		}
	}
	ajaxpost(url,data,success);
}
$(".getcommentlist").click(function(){
	var _id=$(this).attr("dataid");
	var _tid=$(this).attr("datatid");
	$("#articlecommentlist"+_id).toggleClass("hide");
	var flag=$("#articlecommentlist"+_id).attr("dataflag");
	if(flag==1){
		flag=0;
	}else{
		flag=1;
		//加载评论
		loadarticlecommentlist(_id,_tid);
	}
	$("#articlecommentlist"+_id).attr("dataflag",flag);
	
})
	$(".add-comment-btn").click(function(){
		var _id=$(this).attr("dataid");
		$(".formcomment"+_id).toggleClass("hide");
	})
		$(".btnattention").click(function(){
		var _uid=$(this).attr("data-uid");
		attentto_user(_uid);
	})
	/*关注用户*/
function attentto_user(uid) {

    if (g_uid == 0) {
        login();
    }
    if(g_uid==uid){
    	layer.msg("不能关注自己");
    	return false;
    }
    $.post(geturl("user/attentto"), {uid: uid}, function(msg) {
    
        if (msg == 'ok') {
            if ($("#attenttouser_"+uid+",."+"attenttouser_"+uid).hasClass("layui-btn-warm")) {
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).removeClass("layui-btn-warm");
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).addClass("layui-btn-primary");                
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).html('+关注');
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).attr('title','添加关注');
            } else {
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).removeClass("layui-btn-primary");
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).addClass("layui-btn-warm");         
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).html('取消关注');
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).attr('title','已关注');
            }
           
        }
    });
}

function geturl(_url){
	return g_site_url+g_prefix+_url+g_suffix;
}
var postsubmiting=false;
window.ajaxpost=function (_url,_data,callback,type){
    if(type==null||type==''||type==false||type=='undefined'){
        type='json';
    }
    //定义一个加载前的loading对象
    var _loadimg=null;
    //var _mydata="jsonParams="+JSON.stringify(_data);
    var _mydata=_data;
    if(type=='jsonp'){
        _url=_url+"?"+_mydata;
    }

if(postsubmiting){
	return false;
}
   
    $.ajax({
        url:_url,
        type:'POST', //GET
        async:true,    //或false,是否异步
        data:_mydata,
        timeout:5000,    //超时时间

        // dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
        dataType : type,
       // jsonp: "callback",//传递给请求处理程序或页面的，用以获得jsonp回调函数名的参数名(默认为:callback)
       // jsonpCallback:"success_jsonpCallback",//自定义的jsonp回调函数名称，默认为jQuery自动生成的随机函数名
        beforeSend:function(xhr){

        	postsubmiting=true;
            //loading对象赋值
          

        },
        success:callback,
        error:function(xhr,textStatus){   
        	postsubmiting=false;
            layer.msg("服务器异常");
        },
        complete:function(){
        	
            //调用完成删掉loading
      
        }
    })
}
var adoptanswer=false;
$(".jieda-accept").click(function(){
	if(adoptanswer){
		
		return false;
	}
	adoptanswer=true;
	  var data={
  			content:"非常感谢",
  			qid:$("#adopt_qid").val(),
  			aid:$(this).attr('data-aid')

  	}
    
	$.ajax({
	    //提交数据的类型 POST GET
	    type:"POST",
	    //提交的网址
	    url:geturl("question/ajaxadopt"),
	    //提交的数据
	    data:data,
	    //返回数据的格式
	    datatype: "json",//"xml", "html", "script", "json", "jsonp", "text".
	    //在请求之前调用的函数
	    beforeSend:function(){},
	    //成功返回之后调用的函数
	    success:function(data){
	    	var data=eval("("+data+")");
	       if(data.message=='ok'){
	    	   adoptanswer=true;
	    	   layer.msg('采纳成功!')
	    	   setTimeout(function(){
	               window.location.reload();
	           },1500);
	       }else{
	    	  layer.msg(data.message)
	       }


	    }   ,
	    //调用执行后调用的函数
	    complete: function(XMLHttpRequest, textStatus){

	    },
	    //调用出错执行的函数
	    error: function(){
	    	adoptanswer=false;
	        //请求出错处理
	    }
	 });
})
 $(".button_agree").click(function(){
             var supportobj = $(this);
                     var answerid = $(this).attr("data-id");
                     $.ajax({
                     type: "GET",
                             url:geturl("answer/ajaxhassupport/" + answerid),
                             cache: false,
                             success: function(hassupport){
                             if (hassupport != '1'){
                                 $.ajax({
                                     type: "GET",
                                             cache:false,
                                             url: geturl("answer/ajaxaddsupport/" + answerid),
                                             success: function(comments) {
                                            	 layer.msg("点赞成功");
                                             supportobj.find("em").html(comments);
                                             }
                                     });
                             }else{
                            	 layer.msg("您已经赞过");
                             }
                             }
                     });
             });
$(".showpinglun").click(function(){
	var aid=$(this).attr("data-id")
	show_comment(aid)
})
$(".addhuidapinglun").click(function(){
	var aid=$(this).attr("data-id")
	addcomment(aid)
})
function bytes(str) {
    var len = 0;
    for (var i = 0; i < str.length; i++) {
        if (str.charCodeAt(i) > 127) {
            len++;
        }
        len++;
    }
    return len;
}
function show_comment(answerid) {
    if ($("#comment_" + answerid).css("display") === "none") {
    load_comment(answerid);
            $("#comment_" + answerid).slideDown();
    } else {
    $("#comment_" + answerid).slideUp();
    }
    }
var postpinglunhuida=false;
//添加评论
function addcomment(answerid) {
	if(postpinglunhuida){
		return false;
	}
	postpinglunhuida=true;
var content = $("#comment_" + answerid + " input[name='content']").val();
var replyauthor = $("#comment_" + answerid + " input[name='replyauthor']").val();
if (g_uid == 0){
    login();
    postpinglunhuida=false;
    return false;
}
if (bytes($.trim(content)) < 5){
	  postpinglunhuida=false;
layer.msg("评论内容不能少于5字");
        return false;
}
$.ajax({
type: "POST",
        url:geturl("answer/addcomment"),
        data: "content=" + content + "&answerid=" + answerid+"&replyauthor="+replyauthor,
        success: function(status) {
        if (status == '1') {
        $("#comment_" + answerid + " input[name='content']").val("");
                load_comment(answerid);
        }else{
        	if(status == '-2'){
        		layer.msg("问题已经关闭，无法评论");
        	}
        }
        }
});
}


//加载评论
function load_comment(answerid){
$.ajax({
type: "GET",
        cache:false,
        url: geturl("answer/ajaxviewcomment/" + answerid),
        success: function(comments) {
        $("#comment_" + answerid + " .my-comments-list").html(comments);
  
      
        }
});
}
//删除评论

window.deletecomment=function (commentid, answerid) {
	if (!confirm("确认删除该评论?")) {
		return false;
		}
		$.ajax({
		type: "POST",
		        url: geturl("answer/deletecomment"),
		        data: "commentid=" + commentid + "&answerid=" + answerid,
		        success: function(status) {
		        if (status == '1') {
		        load_comment(answerid);
		        }
		        }
		});
		}
window.replycomment = function (commentauthorid,answerid){
	  var comment_author = $("#comment_author_"+commentauthorid).attr("title");
	    $("#comment_"+answerid+" .comment-input").focus();
	    $("#comment_"+answerid+" .comment-input").val("回复 "+comment_author+" :");
	    $("#comment_" + answerid + " input[name='replyauthor']").val(commentauthorid);
	}

  //我的相关数据
  var elemUC = $('#LAY_uc'), elemUCM = $('#LAY_ucm');
  gather.minelog = {};
  gather.mine = function(index, type, url){
    var tpl = [
      //求解
      '{{# for(var i = 0; i < d.rows.length; i++){ }}\
      <li>\
        {{# if(d.rows[i].collection_time){ }}\
          <a class="jie-title" href="/jie/{{d.rows[i].id}}/" target="_blank">{{= d.rows[i].title}}</a>\
          <i>{{ d.rows[i].collection_time }} 收藏</i>\
        {{# } else { }}\
          {{# if(d.rows[i].status == 1){ }}\
          <span class="fly-jing layui-hide-xs">精</span>\
          {{# } }}\
          {{# if(d.rows[i].accept >= 0){ }}\
            <span class="jie-status jie-status-ok">已结</span>\
          {{# } else { }}\
            <span class="jie-status">未结</span>\
          {{# } }}\
          {{# if(d.rows[i].status == -1){ }}\
            <span class="jie-status">审核中</span>\
          {{# } }}\
          <a class="jie-title" href="/jie/{{d.rows[i].id}}/" target="_blank">{{= d.rows[i].title}}</a>\
          <i class="layui-hide-xs">{{ layui.util.timeAgo(d.rows[i].time, 1) }}</i>\
          {{# if(d.rows[i].accept == -1){ }}\
          <a class="mine-edit layui-hide-xs" href="/jie/edit/{{d.rows[i].id}}" target="_blank">编辑</a>\
          {{# } }}\
          <em class="layui-hide-xs">{{d.rows[i].hits}}阅/{{d.rows[i].comment}}答</em>\
        {{# } }}\
      </li>\
      {{# } }}'
    ];
   
    var view = function(res){
      var html = laytpl(tpl[0]).render(res);
      dom.mine.children().eq(index).find('span').html(res.count);
      elemUCM.children().eq(index).find('ul').html(res.rows.length === 0 ? '<div class="fly-msg">没有相关数据</div>' : html);
    };

    var page = function(now){
      var curr = now || 1;
      if(gather.minelog[type + '-page-' + curr]){
        view(gather.minelog[type + '-page-' + curr]);
      } else {
        //我收藏的帖
        if(type === 'collection'){
          var nums = 10; //每页出现的数据量
          fly.json(url, {}, function(res){
            res.count = res.rows.length;

            var rows = layui.sort(res.rows, 'collection_timestamp', 'desc')
            ,render = function(curr){
              var data = []
              ,start = curr*nums - nums
              ,last = start + nums - 1;

              if(last >= rows.length){
                last = curr > 1 ? start + (rows.length - start - 1) : rows.length - 1;
              }

              for(var i = start; i <= last; i++){
                data.push(rows[i]);
              }

              res.rows = data;
              
              view(res);
            };

            render(curr)
            gather.minelog['collect-page-' + curr] = res;

            now || laypage.render({
              elem: 'LAY_page1'
              ,count: rows.length
              ,curr: curr
              ,jump: function(e, first){
                if(!first){
                  render(e.curr);
                }
              }
            });
          });
        } else {
          fly.json('/api/'+ type +'/', {
            page: curr
          }, function(res){
            view(res);
            gather.minelog['mine-jie-page-' + curr] = res;
            now || laypage.render({
              elem: 'LAY_page'
              ,count: res.count
              ,curr: curr
              ,jump: function(e, first){
                if(!first){
                  page(e.curr);
                }
              }
            });
          });
        }
      }
    };

    if(!gather.minelog[type]){
      page();
    }
  };

  if(elemUC[0]){
    layui.each(dom.mine.children(), function(index, item){
      var othis = $(item)
      gather.mine(index, othis.data('type'), othis.data('url'));
    });
  }

  //显示当前tab
  if(location.hash){
    element.tabChange('user', location.hash.replace(/^#/, ''));
  }

  element.on('tab(user)', function(){
    var othis = $(this), layid = othis.attr('lay-id');
    if(layid){
      location.hash = layid;
    }
  });

  //根据ip获取城市
  if($('#L_city').val() === ''){
    $.getScript('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js', function(){
      $('#L_city').val(remote_ip_info.city||'');
    });
  }

  //上传图片
  if($('.upload-img')[0]){
    layui.use('upload', function(upload){
      var avatarAdd = $('.avatar-add');

      upload.render({
        elem: '.upload-img'
        ,url: '/user/upload/'
        ,size: 50
        ,before: function(){
          avatarAdd.find('.loading').show();
        }
        ,done: function(res){
          if(res.status == 0){
            $.post('/user/set/', {
              avatar: res.url
            }, function(res){
              location.reload();
            });
          } else {
            layer.msg(res.msg, {icon: 5});
          }
          avatarAdd.find('.loading').hide();
        }
        ,error: function(){
          avatarAdd.find('.loading').hide();
        }
      });
    });
  }

  //合作平台
  if($('#LAY_coop')[0]){

    //资源上传
    $('#LAY_coop .uploadRes').each(function(index, item){
      var othis = $(this);
      upload.render({
        elem: item
        ,url: '/api/upload/cooperation/?filename='+ othis.data('filename')
        ,accept: 'file'
        ,exts: 'zip'
        ,size: 30*1024
        ,before: function(){
          layer.msg('正在上传', {
            icon: 16
            ,time: -1
            ,shade: 0.7
          });
        }
        ,done: function(res){
          if(res.code == 0){
            layer.msg(res.msg, {icon: 6})
          } else {
            layer.msg(res.msg)
          }
        }
      });
    });

    //成效展示
    var effectTpl = ['{{# layui.each(d.data, function(index, item){ }}'
    ,'<tr>'
      ,'<td><a href="/u/{{ item.uid }}" target="_blank" style="color: #01AAED;">{{ item.uid }}</a></td>'
      ,'<td>{{ item.authProduct }}</td>'
      ,'<td>￥{{ item.rmb }}</td>'
      ,'<td>{{ item.create_time }}</td>'
      ,'</tr>'
    ,'{{# }); }}'].join('');

    var effectView = function(res){
      var html = laytpl(effectTpl).render(res);
      $('#LAY_coop_effect').html(html);
      $('#LAY_effect_count').html('你共有 <strong style="color: #FF5722;">'+ (res.count||0) +'</strong> 笔合作授权订单');
    };

    var effectShow = function(page){
      fly.json('/cooperation/effect', {
        page: page||1
      }, function(res){
        effectView(res);
        laypage.render({
          elem: 'LAY_effect_page'
          ,count: res.count
          ,curr: page
          ,jump: function(e, first){
            if(!first){
              effectShow(e.curr);
            }
          }
        });
      });
    };

    effectShow();

  }

  //提交成功后刷新
  fly.form['set-mine'] = function(data, required){
    layer.msg('修改成功', {
      icon: 1
      ,time: 1000
      ,shade: 0.1
    }, function(){
      location.reload();
    });
  }

  //帐号绑定
  $('.acc-unbind').on('click', function(){
    var othis = $(this), type = othis.attr('type');
    layer.confirm('整的要解绑'+ ({
      qq_id: 'QQ'
      ,weibo_id: '微博'
    })[type] + '吗？', {icon: 5}, function(){
      fly.json('/api/unbind', {
        type: type
      }, function(res){
        if(res.status === 0){
          layer.alert('已成功解绑。', {
            icon: 1
            ,end: function(){
              location.reload();
            }
          });
        } else {
          layer.msg(res.msg);
        }
      });
    });
  });


  //我的消息
  gather.minemsg = function(){
    var delAll = $('#LAY_delallmsg')
    ,tpl = '{{# var len = d.rows.length;\
    if(len === 0){ }}\
      <div class="fly-none">您暂时没有最新消息</div>\
    {{# } else { }}\
      <ul class="mine-msg">\
      {{# for(var i = 0; i < len; i++){ }}\
        <li data-id="{{d.rows[i].id}}">\
          <blockquote class="layui-elem-quote">{{ d.rows[i].content}}</blockquote>\
          <p><span>{{d.rows[i].time}}</span><a href="javascript:;" class="layui-btn layui-btn-sm layui-btn-danger fly-delete">删除</a></p>\
        </li>\
      {{# } }}\
      </ul>\
    {{# } }}'
    ,delEnd = function(clear){
      if(clear || dom.minemsg.find('.mine-msg li').length === 0){
        dom.minemsg.html('<div class="fly-none">您暂时没有最新消息</div>');
      }
    }
    
    
    /*
    fly.json('/message/find/', {}, function(res){
      var html = laytpl(tpl).render(res);
      dom.minemsg.html(html);
      if(res.rows.length > 0){
        delAll.removeClass('layui-hide');
      }
    });
    */
    
    //阅读后删除
    dom.minemsg.on('click', '.mine-msg li .fly-delete', function(){
      var othis = $(this).parents('li'), id = othis.data('id');
      fly.json('/message/remove/', {
        id: id
      }, function(res){
        if(res.status === 0){
          othis.remove();
          delEnd();
        }
      });
    });

    //删除全部
    $('#LAY_delallmsg').on('click', function(){
      var othis = $(this);
      layer.confirm('确定清空吗？', function(index){
        fly.json('/message/remove/', {
          all: true
        }, function(res){
          if(res.status === 0){
            layer.close(index);
            othis.addClass('layui-hide');
            delEnd(true);
          }
        });
      });
    });

  };

  dom.minemsg[0] && gather.minemsg();

  exports('user', null);
  
});