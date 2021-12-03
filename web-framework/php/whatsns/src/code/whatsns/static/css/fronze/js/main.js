/**
 * Created by Administrator on 2016/11/4.
 */

window.alert=function(msg){
	$.tips({
        content:msg,
        stayTime:1000,
        type:"info"
    });
}

function togglenav(){
	$("#menu").toggle();
}
  function goTop(acceleration, time) {
acceleration = acceleration || 0.1;
time = time || 16;
var x1 = 0;
var y1 = 0;
var x2 = 0;
var y2 = 0;
var x3 = 0;
var y3 = 0;
if (document.documentElement) {
x1 = document.documentElement.scrollLeft || 0;
y1 = document.documentElement.scrollTop || 0;
}
if (document.body) {
x2 = document.body.scrollLeft || 0;
y2 = document.body.scrollTop || 0;
}
var x3 = window.scrollX || 0;
var y3 = window.scrollY || 0;
// 滚动条到页面顶部的水平距离
var x = Math.max(x1, Math.max(x2, x3));
// 滚动条到页面顶部的垂直距离
var y = Math.max(y1, Math.max(y2, y3));
// 滚动距离 = 目前距离 / 速度, 因为距离原来越小, 速度是大于 1 的数, 所以滚动距离会越来越小
var speed = 1 + acceleration;
window.scrollTo(Math.floor(x / speed), Math.floor(y / speed));
// 如果距离不为零, 继续调用迭代本函数
if (x > 0 || y > 0) {
var invokeFunction = "goTop(" + acceleration + ", " + time + ")";
window.setTimeout(invokeFunction, time);
}
}
$(function (){
	load_message_sowenda();
    $(".ui-icon-close").bind("click",function(event){

        $(this).parent().find("input").val("");
        event.stopPropagation();    //  阻止事件冒泡
    });

    $(".fixed-bar .ui-icon-refresh").bind("click",function(event){
        window.location.reload();
        event.stopPropagation();
    });
    $(".fixed-bar .ui-icon-home").bind("click",function(event){
        window.location.href=g_site_url;
        event.stopPropagation();
    });

    $(".fixed-bar .ui-icon-gototop").bind("click",function(event){
    	 goTop();
        event.stopPropagation();
    });
    var tab = new fz.Scroll('.ui-tab', {
        role: 'tab',
        autoplay: false,
        interval: 3000
    });

  
  
  
  

});
$("input").focus(function(){
	
	     var target=$(".xuanfu");
            target.addClass("ui-hide");




}).blur(function(){
	var target=$(".xuanfu");
  target.removeClass("ui-hide");
	});
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
function load_message_sowenda() {

    if (g_uid == 0) {
        return false;
    }

    $.ajax({
        type: "GET",
        async: false,
        cache: false,
        url:g_site_url + "index.php?user/ajaxloadmessage",
        dataType:"json",
        success: function(msg) {
        	
        
        
        	var msg_count=parseInt(msg.msg_personal)+parseInt(msg.msg_system);
        	
        	if(msg.msg_personal!=0){
        		$(".msg-count .m_num").html(msg_count)
        		$(".msg-count ").removeClass("hide").show();
        		$(".p-msg-count").html(msg.msg_personal).show();
        	}else{
        		$(".p-msg-count").hide();
        	}
        	if(msg.msg_system!=0){
        		$(".msg-count .m_num").html(msg_count)
        		$(".msg-count ").removeClass("hide").show();
        		$(".s-msg-count").html(msg.msg_system).show();
        	}else{
        		$(".s-msg-count").hide();
        	}
        	
        	if(msg_count==0){
        		$(".msg-count").hide();
        		$(".p-msg-count").hide();
        		$(".s-msg-count").hide();
        	}else{
        		
        		$(".msg-count .m_num").html(msg_count)
        		$(".msg-count ").removeClass("hide").show();
        	}
        	
	    	
	
        }
    });
   
}
function checkall(checkname) {
    var chkall = $("#chkall:checked").val();
    if (chkall && (chkall === 'chkall')) {
        $("input[name^='" + checkname + "']").each(function() {
            $(this).attr("checked", "checked");
        });
    } else {
        $("input[name^='" + checkname + "']").each(function() {
            $(this).removeAttr("checked");
        });
    }
}
function attentto_question(qid) {
    if (g_uid == 0) {
        window.location.href=g_site_url + "index.php" + query + "user/login/";
    }
    var ael='';
   
    $.ajax({
        type: "POST",
      
        data:{qid: qid},
        url:g_site_url + "index.php?question/attentto",
      //在请求之前调用的函数
        beforeSend:function(){
        	ael=$.loading({
     	        content:'加载中...',
     	    })
        },
        success: function(msg) {
        	ael.loading("hide");
        	 if (msg == 'ok') {
             	
                 if ($("#attentquestion").hasClass("button_attention")) {
                 	$("#attentquestion").removeClass("button_attention");
                 
                   var html_element=' <div class="q-unfollower "> <i class="ui-icon-add"></i>  <span class="q-follower-txt">    关注';
             	  
                   
                   

                   
                   
             	  $("#attentquestion").html(html_element);
                 } else {
                 	$("#attentquestion").addClass("button_attention");
                 	var html_element='<div class="q-follower "><i class="ui-icon-success-block"></i>             <span class="q-follower-txt">                   已关注             </span>          </div>   </span> </div>';
                     $("#attentquestion").html(html_element);
                 }
               
             }
        },
        //调用执行后调用的函数
        complete: function(XMLHttpRequest, textStatus){
        	ael.loading("hide");
        }
    });
    
   
}
/*关注用户*/
function attentto_user(uid) {
    if (g_uid == 0) {
        login();
    }
    if(g_uid==uid){
    	alert("不能关注自己");
    	return false;
    }
    $.post(g_site_url + "index.php?user/attentto", {uid: uid}, function(msg) {
        if (msg == 'ok') {
            if ($("#attenttouser_"+uid).hasClass("button_followed")) {
                $("#attenttouser_"+uid).removeClass("button_followed");
                $("#attenttouser_"+uid).addClass("button_attention");
                
                $("#attenttouser_"+uid).html('+关注</span>');
            } else {
                $("#attenttouser_"+uid).removeClass("button_attention");
                $("#attenttouser_"+uid).addClass("button_followed");
               
                $("#attenttouser_"+uid).html('<span >已关注</span>');
            }
       
        }
    });
}
function login(){
	window.location.href=g_site_url+ "index.php?user/login";
}
/*关注分类*/
function attentto_cat(cid) {
    if (g_uid == 0) {
        login();
    }
 
    $.post(g_site_url + "index.php?category/attentto", {cid: cid}, function(msg) {
        if (msg == 'ok') {
            if ($("#attenttouser_"+cid).hasClass("following")) {
                $("#attenttouser_"+cid).removeClass("btn-default following");
                $("#attenttouser_"+cid).addClass("btn-success follow");
                
                $("#attenttouser_"+cid).html('<i class="fa fa-plus"></i><span>关注</span>');
            } else {
                $("#attenttouser_"+cid).removeClass("btn-success follow");
                $("#attenttouser_"+cid).addClass("btn-default following");
               
                $("#attenttouser_"+cid).html('<i class="fa fa-check"></i><span >已关注</span>');
            }
          
        }else{
        	if(msg == '-1'){
        		alert("先登录在关注");
        	}else{
        		alert(msg);
        	}
        }
    });
}
//验证码
function updatecode() {
	
  var img = g_site_url + "index.php" + query + "user/code/" + Math.random();
  $('#verifycode').attr("src", img);
}

//验证码检测
function check_code() {
  var code = $.trim($('#code').val());
  if ($.trim(code) == '') {
     
      el2=$.tips({
          content:'验证码错误',
          stayTime:1000,
          type:"info"
      });
      return false;
  }
  $.ajax({
      type: "GET",
      async: false,
      cache: false,
      url: g_site_url + "index.php" + query + "user/ajaxcode/" + code,
      success: function(flag) {
          if (1 == flag) {
              
              el2=$.tips({
                  content:'验证码正确',
                  stayTime:2000,
                  type:"success"
              });
              return true;
          } else {
            
              el2=$.tips({
                  content:'验证码错误',
                  stayTime:1000,
                  type:"info"
              });
              return false;
          }

      }
  });
}

function ajaxloading(text){
    _el=document.createElement("div");
   _el.id="ajax_loading";
   _el.innerHTML="<div style='border-radius: 5px;;font-size: 14px;;color: #fff;background: #000;opacity: 0.8;width: 80px;height: 80px;line-height:80px;text-align:center;position: fixed;top:50%;left: 38%;z-index:999999999;'>"+text+"</div>";
   document.body.appendChild(_el);
   return _el;
}
function removeajaxloading(){
   document.body.removeChild(_el);
}
window.loading=function(msg){

   var _div="<div style='border-radius: 5px;;font-size: 14px;;color: #fff;background: #000;opacity: 0.8;width: 80px;height: 80px;line-height:80px;text-align:center;position: fixed;top:50%;left: 38%;z-index:999999999;'>"+msg+"</div>";

   var _mdiv=document.createElement("div");
   _mdiv.innerHTML=_div;
   document.body.appendChild(_mdiv);

   return _mdiv;

}//url获取参数
function GetQueryString(name)
{
   var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
   var r = window.location.search.substr(1).match(reg);
   if(r!=null)return  unescape(r[2]); return null;
}
var submiting=false;
function ajaxpost(_url,_data,callback,type){
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

           submiting=true;
           //loading对象赋值
           _loadimg=loading("加载中..");

       },
       success:callback,
       error:function(xhr,textStatus){
           console.log('错误')
           alert("服务器异常");
       },
       complete:function(){
           submiting=false;
           //调用完成删掉loading
           document.body.removeChild(_loadimg);
           console.log('结束')
       }
   })
}

function check_phone(_phone){
	
 if(!(/^1(1|2|3|4|5|6|7|8|9)\d{9}$/.test(_phone))){ 
	       
	        return false; 
	    }else{
	    	return true;
	    }
}
function gopwdsms(_type){
	 var _phone = $("#userphone").val();
	  var _rs=check_phone(_phone);
	if(!_rs){
		 alert("手机号码有误");  
		 return false;
	}
$.post(g_site_url+"index.php?user/getpwdsmscode", {phone: _phone}, function(flag) {
	   flag=$.trim(flag);
if(flag==1){
	var _timecount=60;
	var _listener= setInterval(function(){
		--_timecount;
		$("#testbtn").html(_timecount+"s后获取");
		$("#testbtn").addClass("disabled");
		if(_timecount<=0){
			clearInterval(_listener);
		$("#testbtn").removeClass("disabled").html("发送短信");;
		}
	},1000);
}else{
	  
 if(flag==0){
		   alert("平台短信已经关闭");
	   }else if(flag==2){
		   alert("手机号没有在网站注册");
	   }else if(flag==3){
		   alert("手机号不正确");
	   }else{
		   if(flag==5){
		   alert("稍后获取验证码");
	   }else{
		    alert(flag);
	   }
		  
	   }
	  
}
});
}
function gosms(_type){
	 var _phone = $("#userphone").val();
	  var _rs=check_phone(_phone);
	if(!_rs){
		 alert("手机号码有误");  
		 return false;
	}
	if(!_type){
		_type="reg"
	}
  $.post(g_site_url+"index.php?user/getsmscode", {phone: _phone,type:_type}, function(flag) {
	   flag=$.trim(flag);
  if(flag==1){
  	var _timecount=60;
  	var _listener= setInterval(function(){
  		--_timecount;
  		$("#testbtn").html(_timecount+"s后获取");
  		$("#testbtn").addClass("disabled");
  		if(_timecount<=0){
  			clearInterval(_listener);
  		$("#testbtn").removeClass("disabled").html("发送短信");
  		}
  	},1000);
  }else{
 if(flag==0){
		   alert("平台短信已经关闭");
	   }else if(flag==2){
		   alert("手机号已被注册");
	   }else if(flag==3){
		   alert("手机号不正确");
	   }else{
		   if(flag==5){
		   alert("稍后获取验证码");
	   }else{
		    alert(flag);
	   }
		  
	   }
	  
 }
  });
}
function getemailcode(){
	 var _code = $.trim($('#code').val());

	 var _email = $.trim($('#email').val());
	 if(code==''){
		 alert("图片验证不能为空");
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
        if(data.code!='2000'){
        	alert(data.msg)
        	return false;
        }
       	
        if(data.code=='2000'){
       	  	var _timecount=60;
       	  	var _listener= setInterval(function(){
       	  		--_timecount;
       	  		$("#testbtn").html(_timecount+"s后获取");
       	  		$("#testbtn").addClass("disabled");
       	  		if(_timecount<=0){
       	  			clearInterval(_listener);
       	  		$("#testbtn").removeClass("disabled").html("发送验证码");;
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
//发布文章评论
$(".btn-cm-submit").click(function(){
	postarticle();

    
});
function invateuseranswer(_qid){
	 $(".m_invate_tab li").removeClass("active");
	 $(".m_invate_tab li:first").addClass("active");
	$(".popover").hide();
	$("#dialog_invate .m_invateinfo span.m_i_view").popover('hide');
	loaduserbyqid(_qid);
	
	
}
function searchuserbyqid(_qid,strusername){
	var _url=g_site_url+"index.php?question/invatebysearch.html";
	data={qid:_qid,username:strusername}
	function success(result){
		$(".m_invatelist").html("");
		if(result.code==20000){
		
			   $(".m_i_persionnum").html(result.invatenum);
              $(".box_m_invatelist").html(result.message);
            
              $(".m_invate_user").click(function(){
           	   var _backnum=$(this).attr("data-back");
           	   if(_backnum&&_backnum==1){
           		   cancelinvateuser($(this),$(this).attr("data-qid"),$(this).attr("data-uid"),false);
           	   }else{
           		   invateuseranswerhome($(this),$(this).attr("data-qid"),$(this).attr("data-cid"),$(this).attr("data-uid"))
           	   }
           	 
              })
		}else{
			if(result.code==20003){
			
			}else{
				alert(result.message)
			}
			
		}
		  
		
	}
	ajaxpost(_url,data,success);
}
function loaduserbyqid(_qid){
	var _url=g_site_url+"index.php?question/loadinvateuser.html";
	data={qid:_qid}
	function success(result){
		$(".m_invatelist").html("");
		if(result.code==20000){
			 $("#dialog_invate .m_invateinfo span.m_i_view").attr("data-content",result.invateuserlist);
		
			   $(".m_i_persionnum").html(result.invatenum);
              $(".m_invatelist").html(result.message);
              $('#dialog_invate').modal('show');
              $(".m_invate_user").click(function(){
           	   var _backnum=$(this).attr("data-back");
           	   if(_backnum&&_backnum==1){
           		   cancelinvateuser($(this),$(this).attr("data-qid"),$(this).attr("data-uid"),false);
           	   }else{
           		   invateuseranswerhome($(this),$(this).attr("data-qid"),$(this).attr("data-cid"),$(this).attr("data-uid"))
           	   }
           	 
              })
		}else{
			if(result.code==20003){
				$('#dialog_invate').modal('show');
			}else{
				alert(result.message)
			}
			
		}
		  
		
	}
	ajaxpost(_url,data,success);
}
//根据分类读取改分类下有回答的人
function loaduserbyanswerincid(_qid){
	var _url=g_site_url+"index.php?question/loadinavterbyanswerincid.html";
	data={qid:_qid}
	function success(result){
		$(".m_invatelist").html("");
		if(result.code==20000){
			 $("#dialog_invate .m_invateinfo span.m_i_view").attr("data-content",result.invateuserlist);
		
			   $(".m_i_persionnum").html(result.invatenum);
              $(".m_invatelist").html(result.message);
     
              $(".m_invate_user").click(function(){
           	   var _backnum=$(this).attr("data-back");
           	   if(_backnum&&_backnum==1){
           		   cancelinvateuser($(this),$(this).attr("data-qid"),$(this).attr("data-uid"),false);
           	   }else{
           		   invateuseranswerhome($(this),$(this).attr("data-qid"),$(this).attr("data-cid"),$(this).attr("data-uid"))
           	   }
           	 
              })
		}else{
			if(result.code==20003){
		
			}else{
				alert(result.message)
			}
			
		}
		  
		
	}
	ajaxpost(_url,data,success);
}
$('#m_i_searchusertxt').bind('input propertychange', function() { 
	  _qid=$(this).attr("data-qid");
	    if($(this).val().length>=1){
	    	searchuserbyqid(_qid,$(this).val());
	    }
	});  
//获取我关注的人
function invatemyattention(_qid){
	var _url=g_site_url+"index.php?question/invatemyattention.html";
	data={qid:_qid}
	function success(result){
		if(result.code==20000){
			 $("#dialog_invate .m_invateinfo span.m_i_view").attr("data-content",result.invateuserlist);
		
			   $(".m_i_persionnum").html(result.invatenum);
              $(".m_invatelist").html(result.message);
            
              $(".m_invate_user").click(function(){
           	   var _backnum=$(this).attr("data-back");
           	   if(_backnum&&_backnum==1){
           		   cancelinvateuser($(this),$(this).attr("data-qid"),$(this).attr("data-uid"),false);
           	   }else{
           		   invateuseranswerhome($(this),$(this).attr("data-qid"),$(this).attr("data-cid"),$(this).attr("data-uid"))
           	   }
           	 
              })
		}else{
			if(result.code==20003){
				$('#dialog_invate').modal('show');
			}else{
				alert(result.message)
			}
			
		}
		  
		
	}
	ajaxpost(_url,data,success);
}
function invateuseranswerhome(target,_qid,_cid,_uid){
	
	var _url=g_site_url+"index.php?question/invateuseranswer.html";
	data={qid:_qid,cid:_cid,uid:_uid};
	function success(result){
		if(result.code==20000){
			target.addClass("m_invate_user_back");
			target.attr("data-back",1);
			target.html("收回邀请");
			target.val("收回邀请");
			$(".m_i_persionnum").html(parseInt($(".m_i_persionnum").html())+1);
			
			getinvatelist(_qid);
		}
	
		alert(result.message)
	}
	ajaxpost(_url,data,success);
}
function getinvatelist(_qid){
	var _url=g_site_url+"index.php?question/getinvatelist.html";
	data={qid:_qid};
	function success(result){
		if(result.code==20000){
			
			 $("#dialog_invate .m_invateinfo span.m_i_view").attr("data-content",result.invateuserlist);
				
		}
		
	}
	ajaxpost(_url,data,success);
}
function cancelinvateuser(target,_qid,_uid,_bin){
	target=$(target);
	var _url=g_site_url+"index.php?question/cancelinvateuseranswer.html";
	data={qid:_qid,uid:_uid};
	function success(result){
		if(result.code==20000){
			 
			  if(_bin!=false){
				  target.parent().remove();
			  }
			
			var intvatenum=parseInt($(".m_i_persionnum").html())-1;
			$(".m_i_persionnum").html(intvatenum);
			target.removeClass("m_invate_user_back");
			target.attr("data-back",0);
			target.html("邀请回答");
			target.val("邀请回答");
	        if(intvatenum==0){
	        	getinvatelist(_qid);
	       
	        }
			
		}
		alert(result.message)
	}
	ajaxpost(_url,data,success);
}
function postarticle(){
	 ctrdown=false;
	 returndown=false;
	//var artcomment=$.trim($("#editor").val());
	 var artcomment=$.trim($(".comment-area").val());
   var _tid=$("#artid").val();
   var _artitle=$("#artitle").val();
   
	var url=g_site_url+"/index.php?topic/ajaxpostcomment";
	if(artcomment==''){
	  alert("评论不能为空")
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
   
          ajaxloading("提交中...");
       },
       //成功返回之后调用的函数
       success:function(data){
         
            
           var  jsondata=eval('(' + data+ ')');
          
          
         alert(jsondata.msg)
          
          if(jsondata.state==1){
       	   window.location.reload();
          }
          if(jsondata.state==-1){
       	   login();
          }
          
       }   ,
       complete: function () {
          removeajaxloading();
       },
      
       //调用出错执行的函数
       error: function(){
           //请求出错处理
       }
   });
}
