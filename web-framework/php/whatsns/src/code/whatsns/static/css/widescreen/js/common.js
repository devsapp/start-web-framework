/**
 * Created by Administrator on 2017/4/2.
 */

var popusertimer = null;
var query = '?';
var has_submit=false;
var _el;//加载进度条元素
window.alert=function(msg){
    new $.zui.Messager(msg, {
    
        time:1000,
        placement: 'center' // 定义显示位置
    }).show();
}
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

//快速登录
function loginquick(){
	var _username=$("#side_username").val();
	var _password=$("#side_password").val();
	var _apikey=$("#side_tokenkey").val();
	var _url=g_site_url+"index.php?api_user/loginapi";
	 $.ajax({
	        //提交数据的类型 POST GET
	        type:"POST",
	        //提交的网址
	        url:_url,
	        //提交的数据
	        data:{uname:_username,upwd:_password,apikey:_apikey},
	        //返回数据的格式
	        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
	        beforeSend: function () {
	            
	            ajaxloading("提交中...");
	         },
	        //成功返回之后调用的函数
	        success:function(data){
	        	data=$.trim(data);

	            if(data=='login_ok'){
	            
	             	
	             	
	             	
	             	
	            	window.location.reload()
	               
	             
	            	
	            	
	            
	            }else{
	            	  switch(data){
	            	  case 'login_null':
	            		  alert("用户名或者密码为空");
	            		  break;
	 case 'login_user_or_pwd_error':
		  alert("用户名或者密码错误");
	            		  break;
	default:
		alert(data);
		break;
	            	  }
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
//快速提问
function addquestion(){
	if(g_uid <=0){
		login();
		return false;
	}
	var _text=$(".questionblock_text").val();
	var data={
			  title:_text
	}
	var url=g_site_url+"index.php?question/ajaxquickadd";
	function success(result){
	 
        if(result.message=='ok'){
     	   var tmpmsg='提问成功!';
     	   if(result.sh=='1'){
     		   tmpmsg='问题发布成功！为了确保问答的质量，我们会对您的提问内容进行审核。请耐心等待......';
     	   }
     	   alert(tmpmsg)
     	   setTimeout(function(){
     		  
                window.location.reload();
            },1500);
        }else{
     	  alert(result.message)
        }
	}
	ajaxpost(url,data,success);
}

//标签选择
function tagchoose(str){
	var url=g_site_url+"index.php?question/ajaxchoosetag";
	var data={};
	    data.content=str;
	    function success(result){
	    	$(".tag_selects").html("");
	    	if(result.msg=='-1'){
	    		 
	    		console.log('没有结果');
	    		alert("没有检测到可分词的内容");
	    		return false;
	    	}
	    	
	    	$.each(result, function(idx, obj) {
	    	 
	    		$(".tag_selects").append('<div class="tag_s"><span>'+obj+'</span><i class="fa fa-close"></i></div>');
	    	    $(".tag_selects .tag_s i").click(function(){
	    	    	$(this).parent().remove();
	    	    })
	    	});
	    }
	    ajaxpost(url,data,success);
}
//登录弹窗
function login(){


var url=g_site_url+"index.php?user/ajaxpoplogin";
var myModalTrigger = new $.zui.ModalTrigger({url:url});
myModalTrigger.show();
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
  		$("#testbtn").removeClass("disabled").html("发送短信");;
  		}
  	},1000);
  }else{
 if(flag==0){
		   alert("平台短信已经关闭");
	   }else if(flag==2){
		   alert("手机号在网站已经被注册");
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
            if ($("#attenttouser_"+uid+",."+"attenttouser_"+uid).hasClass("following")) {
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).removeClass("btn-current attention btn-default-secondary following");
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).addClass("btn-current attention btn-default-main notfollow follow");                
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).val('关注');
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).html('关注');
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).attr('title','添加关注');
            } else {
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).removeClass("btn-current attention btn-default-main notfollow follow");
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).addClass("btn-current attention btn-default-secondary following");         
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).val('已关注');
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).html('已关注');
                $("#attenttouser_"+uid+",."+"attenttouser_"+uid).attr('title','已关注');
            }
           
        }
    });
}

/*关注用户*/
function attentto_user_index(uid) {
    if (g_uid == 0) {
        login();
    }
    if(g_uid==uid){
    	alert("不能关注自己");
    	return false;
    }
    $.post(g_site_url + "index.php?user/attentto", {uid: uid}, function(msg) {
        if (msg == 'ok') {
            if ($("#attenttouser_"+uid).hasClass("following")) {
                $("#attenttouser_"+uid).removeClass("following");
                $("#attenttouser_"+uid).addClass(" follow");
                
                $("#attenttouser_"+uid).html('<i class="fa fa-plus"></i><span>关注</span>');
            } else {
                $("#attenttouser_"+uid).removeClass("follow");
                $("#attenttouser_"+uid).addClass("following");
               
                $("#attenttouser_"+uid).html('<i class="fa fa-check"></i><span >已关注</span>');
            }
            $("#attenttouser_"+uid).hover(function(){
            	
            	 if ($("#attenttouser_"+uid).hasClass("following")){
            		 $("#attenttouser_"+uid).html('<i class="fa fa-times"></i><span >取消关注</span>');
            	 }
            	
            },function(){
            	 if ($("#attenttouser_"+uid).hasClass("following")){
            		 $("#attenttouser_"+uid).html('<i class="fa fa-check"></i><span >已关注</span>');
            	 }
            })
        }
    });
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
                
                $("#attenttouser_"+cid).html('<span>关注</span>');
            } else {
                $("#attenttouser_"+cid).removeClass("btn-success follow");
                $("#attenttouser_"+cid).addClass("btn-default following");
               
                $("#attenttouser_"+cid).html('<span >已关注</span>');
            }
            $("#attenttouser_"+cid).hover(function(){
            	
            	 if ($("#attenttouser_"+cid).hasClass("following")){
            		 $("#attenttouser_"+cid).html('<span >取消关注</span>');
            	 }
            	
            },function(){
            	 if ($("#attenttouser_"+cid).hasClass("following")){
            		 $("#attenttouser_"+cid).html('<span >已关注</span>');
            	 }
            })
        }else{
        	if(msg == '-1'){
        		alert("先登录在关注");
        	}else{
        		alert(msg);
        	}
        }
    });
}
function getemailcode(){
	 var _code = $.trim($('#code').val());

	 var _email = $.trim($('#email').val());
	 if(code==''){
		 alert("验证不能为空");
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
        	alert(data.msg)
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
var _ListenPCWX=null;
function getloginresult(payattachname){
	var _attachname=payattachname;
	
	var _cot=0;
	var _djstime=60;
	_ListenPCWX=setInterval(function(){
		++_cot;
		if((_djstime-_cot)>=0){
			$(".daojishitext").html((_djstime-_cot)+"s 后二维码将过期 ");
		}
		
		if(_cot>60){
			$(".daojishitext").html("");
			$(".loginqecodetext").html('扫码登录超时，请刷新页面重新打开微信扫一扫');
			 $("#loginqrcode").css("opacity","0.2");
			window.clearInterval(_ListenPCWX);
			return false;
		}
		var _url=g_site_url + "index.php?plugin_weixin/ajaxrequestresult";
		   $.ajax({
		        //提交数据的类型 POST GET
		        type:"POST",
		        //提交的网址
		        url:_url,
		        //提交的数据
		        data:{name:payattachname},
		        //返回数据的格式
		        datatype: "json",

		        //成功返回之后调用的函数
		        success:function(result){
		        
		        	
			        var rs=$.parseJSON( result )
			   
			        if(rs.code==2000){
			        	window.clearInterval(_ListenPCWX)
			        	$(".daojishitext").html("");
						$(".loginqecodetext").html('扫码成功√').css("color","#fff");
						setTimeout(function(){
							if(rs.forward!=null){
								window.location.href=rs.forward;
							
						}else{
								window.location.href=g_site_url;
						}
						},2000)
			        }else{
			            if(rs.code==2002){
			            	window.clearInterval(_ListenPCWX)
			            }
			        	$(".loginqecodetext").html(rs.msg).css("color","#ea644a");
						
			        }

		        }   ,

		        //调用出错执行的函数
		        error: function(){
		            //请求出错处理
		        }
		    });
	},1000);
}
var _Listen=null;
//监听是否支付
function getresult(payattachname){
	var _attachname=payattachname;
	
	var _cot=0;
	 _Listen=setInterval(function(){
		++_cot;
		if(_cot>15){
			$(".pay_success").html('订单支付超时<i class="fa fa-times"></i>');
			 $(".dasahngqrcode").hide();
			window.clearInterval(_Listen);
			return false;
		}
		var _url=g_site_url + "index.php?user/ajaxrequestresult";
		   $.ajax({
		        //提交数据的类型 POST GET
		        type:"POST",
		        //提交的网址
		        url:_url,
		        //提交的数据
		        data:{name:payattachname},
		        //返回数据的格式
		        datatype: "json",

		        //成功返回之后调用的函数
		        success:function(result){
		        
		        	
			        var rs=$.parseJSON( result )
			  
			        if(rs.code==200){
			        	window.clearInterval(_Listen)
			        	$(".pay_success").html('支付成功<i class="fa  fa-check-circle"></i>');
			        	setTimeout(function(){
			        		$("#triggerModal").hide();
			        		$(".modal").hide();
			        		$(".modal-open").css("overflow","visible");
			        		$("body").removeClass("modal-open");
			        		//window.location.href
			        	},2000)
			        }else{
			        	$(".pay_success").html('等待支付....')
			        }

		        }   ,

		        //调用出错执行的函数
		        error: function(){
		            //请求出错处理
		        }
		    });
	},2000);
}

function setoutTime(num){


	var intDiff = parseInt(num);//倒计时总秒数量



	function timer(intDiff){

		window.setInterval(function(){

		var day=0,

			hour=0,

			minute=0,

			second=0;//时间默认值		

		if(intDiff > 0){

			day = Math.floor(intDiff / (60 * 60 * 24));

			hour = Math.floor(intDiff / (60 * 60)) - (day * 24);

			minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);

			second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);

		}

		if (minute <= 9) minute = '0' + minute;

		if (second <= 9) second = '0' + second;

		$('#day_show').html(day+"天");

		$('#hour_show').html('<s id="h"></s>'+hour+'时');

		$('#minute_show').html('<s></s>'+minute+'分');

		$('#second_show').html('<s></s>'+second+'秒');

		intDiff--;

		}, 1000);

	} 



	$(function(){

		timer(intDiff);

	});	
	}
function checkall(checkname) {
    var chkall = $("#chkall:checked").val();
    if (chkall && (chkall === 'chkall')) {
        $("input[name^='" + checkname + "']").each(function() {
            $(this).prop("checked", "checked");
        });
    } else {
        $("input[name^='" + checkname + "']").each(function() {
            $(this).removeProp("checked");
        });
    }
}

function ajaxloading(text){
     _el=document.createElement("div");
    _el.id="ajax_loading";
    _el.innerHTML="<div style='border-radius: 5px;;font-size: 14px;;color: #fff;background: #000;opacity: 0.8;width: 80px;height: 80px;line-height:80px;text-align:center;position: fixed;top:50%;left: 48%;z-index:999999999;'>"+text+"</div>";
    document.body.appendChild(_el);
    return _el;
}
function removeajaxloading(){
    document.body.removeChild(_el);
}
window.loading=function(msg){

    var _div="<div style='border-radius: 5px;;font-size: 14px;;color: #fff;background: #000;opacity: 0.8;width: 80px;height: 80px;line-height:80px;text-align:center;position: fixed;top:50%;left: 48%;z-index:999999999;'>"+msg+"</div>";

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
            //alert("服务器异常");
        },
        complete:function(){
            submiting=false;
            //调用完成删掉loading
            document.body.removeChild(_loadimg);
            console.log('结束')
        }
    })
}
function getlogininfo(){
	
	$.get(g_site_url+"index.php?user/ajaxgetlogininfo",function(msg){
		$(".ws_header .menu").html(msg);
		
		load_message_sowenda();
		$(".message .message-list,.message .message-box").hover(function(){
			$(".message .message-box").show();
		},function(){	$(".message .message-box").hide();});
	});
}
function load_message_sowenda() {
	
    if (g_uid == 0) {
        return false;
    }

    $.ajax({
        type: "GET",
        url:g_site_url + "index.php?user/ajaxloadmessage",
        dataType:"json",
        success: function(msg) {
        	
       
        
        	var msg_count=parseInt(msg.msg_personal)+parseInt(msg.msg_system);
        	if(msg_count==0){
        		$(".clean-box-msg,.subnav-dot-sup").remove();
        	
        		$("#empty_message_box").show();
        	}else{
        
        		$(".clean-box-msg,.subnav-dot-sup").show();
        		$("#empty_message_box").remove();
        	}
        	if(msg.msg_personal!=0){
        		$(".msg-count").html(msg_count).removeClass("hide").show();
        		$(".p-msg-count").html(msg.msg_personal).show();
        		$(".personmsgbox").html("<a href="+msg.url+">"+msg.text+'<span class="msg-box-num">'+msg.msg_personal+"</span></a>");
        	}else{
        		$(".personmsgbox").hide();
        		$(".p-msg-count").hide();
        	}
        	if(msg.msg_system!=0){
        		$(".msg-count").html(msg_count).removeClass("hide").show();
        		$(".s-msg-count").html(msg.msg_system).show();
        		$(".systemmsgbox").html("<a href="+msg.systemurl+">"+msg.systemtext+'<span class="msg-box-num">'+msg.msg_system+"</span></a>");
        	}else{
        		$(".systemmsgbox").hide();
        		$(".s-msg-count").hide();
        	}
        	if(msg_count==0){
        		$(".msg-count").hide();
        		$(".p-msg-count").hide();
        		$(".s-msg-count").hide();
        	}else{
        		$(".msg-count").html(msg_count).removeClass("hide").show();
        	}
        	
	    	
        	$(".message .message-list,.message .message-box").hover(function(){
        		$(".message .message-box").show();
        	},function(){	$(".message .message-box").hide();});
        }
    });
   
}

function refresh_code() {
    var img = g_site_url + "index.php" + query + "user/code/" + Math.random();
    $('#verifylogincode').attr("src", img);
};

//验证码
function updatecode() {
  var img = g_site_url + "index.php" + query + "user/code/" + Math.random();
  $('#verifycode').attr("src", img);
}

//验证码检测
function check_code() {
  var code = $.trim($('#code').val());
  if ($.trim(code) == '') {
      $('#codetip').html("<i class='fa fa-exclamation mar-lr-1'></i>验证码错误");
      $('#codetip').attr('class', 'alert alert-warning input_error');
      return false;
  }
  $.ajax({
      type: "GET",
      async: false,
      cache: false,
      url: g_site_url + "index.php" + query + "user/ajaxcode/" + code,
      success: function(flag) {
          if (1 == flag) {
              $('#codetip').html("<i class='fa fa-check mar-lr-1'></i>验证码正确");
              $('#codetip').attr('class', 'alert alert-info input_ok');
              return true;
          } else {
              $('#codetip').html("<i class='fa fa-exclamation mar-lr-1'></i>验证码错误");
              $('#codetip').attr('class', 'alert alert-warning input_error');
              return false;
          }

      }
  });
}
//问题分类选择函数
function initcategory(category1) {
    var selectedcid1 = $("#selectcid1").val();
    $("#category1").html('');
    for (var i = 0; i < category1.length; i++) {
        var selected = '';
        if (selectedcid1 === category1[i][0]) {
            selected = ' selected';
        }
        $("#category1").append("<option value='" + category1[i][0] + "' " + selected + ">" + category1[i][1] + "</option>");
    }

}
var ctrdown=false;
var returndown=false;
function keydownlistener(){
	 var e = e||event;
	   var currKey = e.keyCode||e.which||e.charCode;
	   console.log(currKey);
	   if (currKey==17)
	   {
		   ctrdown=true;
	   }
	   if (currKey==13)
	   {
		   returndown=true;
	   }
	   if(returndown&&ctrdown){
		   postask();
	   }
}
var myModalTrigger=null;
function wxpay(type,typevalue,touser){
	
	
	var url=g_site_url+"index.php?user/ajaxpopwxpay/"+type+"/"+typevalue+"/"+touser;
	 myModalTrigger = new $.zui.ModalTrigger({url:url,size:'sm',title:'打赏作者'});
	myModalTrigger.show({onHide: function() {
		window.clearInterval(_Listen);
	    $("#triggerModal").remove();
	}});
}
function viewanswer(answerid){
	
	
	var url=g_site_url+"index.php?question/ajaxviewanswer/"+answerid;
	var myModalTrigger = new $.zui.ModalTrigger({url:url,size:'sm',title:'付费偷看'});
	myModalTrigger.show();
}
function viewtopic(tid){
	if(g_uid==0){
		login();
	}
	
	var url=g_site_url+"index.php?topic/ajaxviewtopic/"+tid;
	var myModalTrigger = new $.zui.ModalTrigger({url:url,size:'sm',title:'付费阅读'});
	myModalTrigger.show();
}
function topickeydownlistener(e){
	 var e = e||event;
	   var currKey = e.keyCode||e.which||e.charCode;
	   console.log(currKey);
	   if (currKey==17)
	   {
		   ctrdown=true;
	   }
	   if (currKey==13)
	   {
		   returndown=true;
	   }
	   if(returndown&&ctrdown){
		   postarticle();
	   }
}
function postask(){
	 ctrdown=false;
	 returndown=false;
	 var eidtor_content='';
      if(typeof testEditor != "undefined"){
    	  var tmptxt=$.trim(testEditor.getMarkdown());
    	  if(tmptxt==''){
    		  alert("回答内容不能为空");
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
		alert("回答内容不能为空");
		 return;
		
	}
	

	
	 var _chakanjine=$("#chakanjine").val();
	 if(_chakanjine!=0){
		 if(_chakanjine>10||_chakanjine<0.1 ){
   		 alert("查看金额在0.1-10元之间");
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
		   alert("提交中,稍后操作....");
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
       beforeSend:function(){has_submit=true; ajaxloading("提交中...");},
       //成功返回之后调用的函数             
       success:function(data){
       	var data=eval("("+data+")");
          if(data.message=='ok'||data.message.indexOf('成功')>=0){
       	   new $.zui.Messager(data.message, {
       		   type: 'success',
       		   close: true,
          	    placement: 'center' // 定义显示位置
          	}).show();
       	   setTimeout(function(){
                  window.location.reload();
              },1500);
          }else{
       	   new $.zui.Messager(data.message, {
           	   close: true,
           	    placement: 'center' // 定义显示位置
           	}).show();
          }
         
        
       }   ,
       //调用执行后调用的函数
       complete: function(XMLHttpRequest, textStatus){
    	   removeajaxloading();
    	   has_submit=false;
       },
       //调用出错执行的函数
       error: function(){
           //请求出错处理
       }         
    });
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
	    new $.zui.Messager("评论不能为空", {
    	    placement: 'center' // 定义显示位置
    	}).show();
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
           
           
           new $.zui.Messager(jsondata.msg, {
        	    placement: 'center' // 定义显示位置
        	}).show();
           
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
function fillcategory(category2, value1, cateid) {
    var optionhtml = '<option value="0">不选择</option>';
    var selectedcid = 0;
    if (cateid === "category2") {
        selectedcid = $("#selectcid2").val();
    } else if (cateid === "category3") {
        selectedcid = $("#selectcid3").val();
    }
    $("#" + cateid).html("");
    for (var i = 0; i < category2.length; i++) {
        if (value1 === category2[i][0]) {
            var selected = '';
            if (selectedcid === category2[i][1]) {
                selected = ' selected';
                $("#" + cateid).show();
            }
            optionhtml += "<option value='" + category2[i][1] + "' " + selected + ">" + category2[i][2] + "</option>";
        }
    }
    $("#" + cateid).html(optionhtml);
}
setTimeout(function(){
	$(".fixedbottom").removeClass("hide").addClass("slideInUp animated ");
	
},3000);
setTimeout(function(){
	$(".btn-buy,.btn-theme").removeClass("hide").addClass("lightSpeedIn animated ");
	$(".btn-down").removeClass("hide").addClass("lightSpeedIn animated ");
	$(".btn-update").removeClass("hide").addClass("lightSpeedIn animated ");
},3600);
function addarticlecomment(_tid,_aid,_comment,_touid){
	var data={
			tid:_tid,
			aid:_aid,
			content:_comment,
			touid:_touid
	}
	var url=g_site_url+"index.php?topic/ajaxaddarticlecomment.html";
	function success(result){
		alert(result.msg)
		if(result.code==200){
			$(".commenttext"+_aid).val("");
			loadarticlecommentlist(_aid,_tid);
		}
	}
	ajaxpost(url,data,success);
}
function loadarticlecommentlist(_id,_tid){
	var data={
			tid:_tid,
			aid:_id
			
	}
	var url=g_site_url+"index.php?topic/ajaxgetcommentlist.html";
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
		            
		             '</span> <a class=""><i class="fa fa-comment"></i> <span author="'+ json[i]['author']+'"authorid="'+ json[i]['authorid']+'" class="huifu">回复</span></a><a class="subcomment-delete">'
		             
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
				$(".formcomment"+_id).toggleClass("hide");
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
				var _url=g_site_url+"index.php?topic/ajaxdelartcomment.html";
				   ajaxpost(_url,data,mysuccess);
			})
			 
		}else{
			alert(result.msg)
		}
	}
	ajaxpost(url,data,success);
}
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
//获取我关注的人
function invatemyattention(_qid){
	var _url=g_site_url+"index.php?question/invatemyattention.html";
	data={qid:_qid}
	function success(result){
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
		$(".popover").hide();
		$("#dialog_invate .m_invateinfo span.m_i_view").popover('hide');
		alert(result.message);
		return false;
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
	        	$(".popover").hide();
	        	$("#dialog_invate .m_invateinfo span.m_i_view").popover('hide');
	        }
			
		}
		alert(result.message)
	}
	ajaxpost(_url,data,success);
}

$(function(){

	getlogininfo();
     $(".m_invate_tab li").click(function(){
    	 $(".m_invatelist").html("");
    	 var _index=$(this).attr("data-item");
    	 var _qid=$(this).attr("data-qid");
    	 $(".m_invate_tab li").removeClass("active");
    	 $(this).addClass("active");
    	 switch(_index){
    	 case '1':
    		 loaduserbyqid(_qid);
    		 break;
    	 case '2':
    		 loaduserbyanswerincid(_qid)
    		 break;
    	 case '3':
    		 invatemyattention(_qid);
    		 break;
    	 }
     })

	
	
	$(".questionblock_btn").click(function(){
		addquestion();
	})
	$(".side-btn-login").click(function(){
		loginquick();
	})
	$('[data-toggle="tooltip"]').tooltip('hide');
    $(".user,.notification ").hover(function(){

        $(this).find(".dropdown-menu").show();
        $(this).find(".dropdown-menu").hover(function(){
        	$(this).find(".dropdown-menu").show();

        },function(){
        	$(this).find(".dropdown-menu").hide();

        })
    },function(){
    	$(this).find(".dropdown-menu").hide();

    });
    $(".index .list-container .note-list li ").hover(function(){
    	$(this).addClass("lightSpeedIn animated ");
   
    },function(){
    	$(this).removeClass("lightSpeedIn animated ");

    });
    $.fn.smartFloat = function() { 
        var position = function(element) { 
            var top = element.position().top; //当前元素对象element距离浏览器上边缘的距离 
            var left = element.position().left; //当前元素对象element距离浏览器上边缘的距离 
            var pos = element.css("position"); //当前元素距离页面document顶部的距离 
            $(window).scroll(function() { //侦听滚动时 
                var scrolls = $(this).scrollTop(); 
                if (scrolls > top) { //如果滚动到页面超出了当前元素element的相对页面顶部的高度 
                    if (window.XMLHttpRequest) { //如果不是ie6 
                        element.css({ //设置css 
                            position: "fixed", //固定定位,即不再跟随滚动 
                            top: 60 //距离页面顶部为20 
                            
                        }).addClass("shadow"); //加上阴影样式.shadow 
                    } else { //如果是ie6 
                        element.css({ 
                            top: scrolls  //与页面顶部距离 
                        });     
                    } 
                }else { 
                    element.css({ //如果当前元素element未滚动到浏览器上边缘，则使用默认样式 
                        position: pos, 
                        top: top
                       
                    }).removeClass("shadow");//移除阴影样式.shadow 
                } 
            }); 
        }; 
        return $(this).each(function() { 
            position($(this));                          
        }); 
    }; 
  //分类选择
    $("#category1").change(function() {
        fillcategory(category2, $("#category1 option:selected").val(), "category2");
        $("#jiantou1").show();
        $("#category2").show();
    });
    $("#category2").change(function() {
        fillcategory(category3, $("#category2 option:selected").val(), "category3");
        $("#jiantou2").show();
        $("#category3").show();
    });
	$("#comfirm_pay").click(function(){
		 var _chakanjine=$("#chakanjine").val();
		 if(_chakanjine!=0){
    		 if(_chakanjine>10||_chakanjine<0.1 ){
        		 alert("查看金额在0.1-10元之间");
        		 return false;
        	 }
    		 $(".emoji-modal-wrap .fa-paypal").html(_chakanjine+"元");
    		
    	 }
		 $(".pay-money").hide();
		
		 $("#anscontent").focus();
	})
	   //显示回答偷看金额弹窗
          $(".emoji-modal-wrap .fa-paypal").click(function(){
        	 
    	 $(".pay-money").show();
    	 $(".pay-money .modal-body #chakanjine").focus();
     });

    //发布文章评论
    $(".btn-cm-submit").click(function(){
    	postarticle();
    
        
    });
    $("#ajaxsubmitasnwer").click(function(){
    	postask();
    
        
    });
	  $('[data-toggle="popover"]').popover({
		    tipClass: 'danger'

		});
	  $('#m_i_searchusertxt').bind('input propertychange', function() { 
		  _qid=$(this).attr("data-qid");
		    if($(this).val().length>=1){
		    	searchuserbyqid(_qid,$(this).val());
		    }
		});  

    
});
