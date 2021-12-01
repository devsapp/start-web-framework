/**
 * 
 */

var popusertimer = null;
var query = '?';
$("#topbar_username,.panel-setting").hover(function(){

	$(".panel-setting").css("display","block");
},function(){
	$(".panel-setting").css("display","none");
});
// Firefox, Google Chrome, Opera, Safari, Internet Explorer from version 9
function OnInput (event) {

    var val=event.target.value;
    if(val.length>=2){
		$(".js-suggest-area").css("display","block");
		$(".suggest-list").html("");
	    $.ajax({
	        type: "POST",
	        async: true,
	      
	      
	        data:{'word':val},
	        url:g_site_url + "index.php?question/searchkey",
	        success: function(msg) {
	        	  console.log(msg);
	        	$(".suggest-list").html(msg);
	    
	           $(".suggest-list li").hover(function(){
	        		$(this).addClass("selected");
	        		
	        	},function(){
	        		$(this).removeClass("selected");
	        	})
	        }
	    });
	}else{
		$(".js-suggest-area").css("display","none");
		$(".suggest-list").html("");
	}
}
// Internet Explorer
function OnPropChanged (event) {
    if (event.propertyName.toLowerCase () == "value") {
    	var val=event.srcElement.value;
    	
    	if(val.length>=2){
    		$(".js-suggest-area").css("display","block");
    		$(".suggest-list").html("");
    	    $.ajax({
    	        type: "POST",
    	        async: true,
    	       
    	      
    	        data:{'word':val},
    	        url:g_site_url + "index.php?question/searchkey",
    	        success: function(msg) {
    	       
    	        	$(".suggest-list").append(msg);
    	      
    	           $(".suggest-list li").hover(function(){
    	        		$(this).addClass("selected");
    	        		
    	        	},function(){
    	        		$(this).removeClass("selected");
    	        	})
    	        }
    	    });
    	}else{
    		$(".js-suggest-area").css("display","none");
    		$(".suggest-list").html("");
    	}
    }
}

load_message_sowenda();

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
/*关注问题*/
function attentto_question(qid) {
    if (g_uid == 0) {
        login();
    }
    $.post(g_site_url + "index.php?question/attentto", {qid: qid}, function(msg) {
        if (msg == 'ok') {
            if ($("#attenttoquestion").hasClass("btnattetion")) {
                $("#attenttoquestion").removeClass("btnattetion");
                $("#attenttoquestion").addClass("btnfollow");
                $("#attenttoquestion").html("取消关注");
            } else {
                $("#attenttoquestion").removeClass("btnfollow");
                $("#attenttoquestion").addClass("btnattetion");
                $("#attenttoquestion").html("关注");
            }
        }
    });
}
$(".bottom-fixed .bottom-close").click(function(){
	$(this).parent().hide();
})
/*关注用户*/
function attentto_user(uid) {
    if (g_uid == 0) {
        login();
    }
    $.post(g_site_url + "index.php?user/attentto", {uid: uid}, function(msg) {
        if (msg == 'ok') {
            if ($("#attenttouser_"+uid).hasClass("button_attention")) {
                $("#attenttouser_"+uid).removeClass("button_attention");
                $("#attenttouser_"+uid).addClass("button_followed");
                $("#attenttouser_"+uid).val("取消关注");
            } else {
                $("#attenttouser_"+uid).removeClass("button_followed");
                $("#attenttouser_"+uid).addClass("button_attention");
                $("#attenttouser_"+uid).val("关注");
            }
        }
    });
}
function load_message_sowenda() {
	
    if (g_uid == 0) {
        return false;
    }
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url:g_site_url + "index.php?user/ajaxloadmessage",
        success: function(msg) {
        	//var msg=eval('({'+msg+'})');
        //	console.log(msg);
        
        	var msg_count=parseInt(msg.msg_personal)+parseInt(msg.msg_system);
	    	
	    	$(".msg-count").html(msg_count);
	        if (msg.msg_personal != 0) {
	            $("#mymessage_personal").html(msg.msg_personal);
	            $("#mymessage_personal").show();
	            $("#mymessage .ismore a").removeClass("msg-null");
	        }
	        if (msg.msg_system != 0) {
	            $("#mymessage_system").html(msg.msg_system);
	            $("#mymessage_system").show();
	            $("#mymessage .ismore a").removeClass("msg-null");
	        }
	        if (msg.message_recommand != 0) {
	            $("#mymessage_recommend").html(msg.message_recommand);
	            $("#mymessage_recommend").show();
	            $("#mymessage .ismore a").removeClass("msg-null");
	        }

        }
    });
   
}
$(".quickask").hover(function(){
	
	$(this).find(".btn-1-off").css("display","inline-block");

},function(){
	$(this).find(".btn-1-off").css("display","none");
	
});
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
    $("#catedialog").dialog({
        autoOpen: false,
        width: 480,
        modal: true,
        resizable: false
    });
}

$("#ask_btn").click(function() {
    document.searchform.action = g_site_url + '' + query + 'question/add' + g_suffix;
    document.searchform.submit();
});
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
$("#changecategory").click(function() {
    if (!$(this).hasClass("btn-disabled-1"))
       $("#catedialog").dialog("open");

});

//usercard弹出层
function pop_user_on(popobj, uid, type) {
    var myalign = "left-27 bottom-30";
    if (type == 'text') {
        myalign = "left-21 bottom-10";
    } else if (type == 'image_active') {
        myalign = "left-40 bottom-43";
    } else if (type == 'image_follow') {
        myalign = "left-10 bottom-20";
    }
    if (popusertimer) {
        clearTimeout(popusertimer);
    }
    $("#usercard").html("");
    popusertimer = setTimeout(function() {
    	
        $("#usercard").show();
        
        $("#usercard").css("top", $(popobj).offset().top).css("left", $(popobj).offset().left+30);
    }, 300);
    $("#usercard").load(g_site_url + "index.php" + query + "user/ajaxuserinfo/" + uid);
}
function pop_user_out() {
    if (popusertimer) {
        clearTimeout(popusertimer);
    }
    popusertimer = setTimeout(function() {
       // $("#usercard").hide();
    	
    	//usercard关闭
    	$("#usercard").hover(function() {
    		//console.log("2323243243");
    	    if (popusertimer) {
    	        clearTimeout(popusertimer);
    	    }
    	    
    	    $("#usercard").show();
    	}, function() {
    	    if (popusertimer) {
    	        clearTimeout(popusertimer);
    	    }
    	    popusertimer = setTimeout(function() {
    	        $("#usercard").hide();
    	    }, 300);
    	});
    }, 300);
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
$(".btn-1-off").click(function(){
	$(".quick-answer").css("display","none");
	$(this).next().toggle(1000);
	$(this).next().css("display","block");
});

/*用户登陆*/
function login() {
    $("#poplogin").remove();
    $("body").append('<div id="poplogin" title="欢迎登陆' + g_site_name + '"></div>');
    $("#poplogin").load(g_site_url + "index.php?user/ajaxpoplogin");
    $("#poplogin").dialog({
        width: 520,
        modal: true,
        resizable: false,
        position: {my: "bottom-60"}
    });
}
$(".quc-panel-close").click(function(){
		$("#zhediv").css("display","none");
	$("#login_div").css("display","none");
});

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
function check_login_code() {

	
    var code = $.trim($('#code').val());
  
    if ($.trim(code) == '') {
    	 $(".quc-tip-error").html("验证码错误");
        
        return false;
    }
    $.ajax({
        type: "POST",
        async: false,
        cache: false,
        url: "{SITE_URL}index.php?user/ajaxcode/"+code,
        success: function(flag) {                   
            if (1 == flag) {
              
             //预留验证码样式设置，返回正确的
                return true;
            } else {
            	 $(".quc-tip-error").html("验证码错误");
              
                return false;
            }

        }
    });
};
$("#navStore,#bread-crumbs").hover(function(){
//console.log($("#bread-crumbs").html());
	$("#bread-crumbs").css("display","block");
},function(){
	$("#bread-crumbs").css("display","none");
});
$(document).ready(function() {
	$("#popusername").focus(function(){

		$(this).parent().addClass("quc-input-bg-focus");
	});
	$("#poppassword").focus(function(){
		$(this).parent().addClass("quc-input-bg-focus");
	})
		$("#popusername").blur(function(){

		$(this).parent().removeClass("quc-input-bg-focus");
	});
	$("#poppassword").blur(function(){
		$(this).parent().removeClass("quc-input-bg-focus");
	})
	   load_message();
});
$(".js-dailyAns").click(function(){
	
	$("#datelist").css("display","block");
	$("#datazhe").css("display","block");
	
});
$(".close").click(function(){
	$("#datazhe").css("display","none");
	$(this).parent().css("display","none");
});
//列表页连续登陆--开始
$(".tab-card1").click(function(){
	$(".js-tab-change").removeClass("on");
	$(this).addClass("on");
	$(".page-index").addClass("sp");
	$(".page-rule").removeClass("sp");
	$(".page-history").removeClass("sp");
});

$(".tab-card2").click(function(){
	
	$(".js-tab-change").removeClass("on");
	$(this).addClass("on");
	$(".page-rule").addClass("sp");
	$(".page-index").removeClass("sp");
	$(".page-history").removeClass("sp");
});
$(".tab-card3").click(function(){
	$(".js-tab-change").removeClass("on");
	$(this).addClass("on");
	$(".page-history").addClass("sp");
	$(".page-rule").removeClass("sp");
	$(".page-index").removeClass("sp");
});
$(".no-history .js-tab-change").click(function(){
	$(".js-tab-change").removeClass("on");
	$(".tab-card2").addClass("on");
	$(".page-rule").addClass("sp");
	$(".page-index").removeClass("sp");
	$(".page-history").removeClass("sp");
});

//登陆退出
$("#loginout").click(function(){

	  
    $.ajax({
        //提交数据的类型 POST GET
        type:"GET",
        //提交的网址
        url:"/?api_user/loginoutapi",
        //提交的数据
       
        //返回数据的格式
        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".

        //成功返回之后调用的函数
        success:function(data){
          

            if(data=='loginout_ok'){
                window.location.href=g_site_url;
            }
        }   ,
       
        //调用出错执行的函数
        error: function(){
            //请求出错处理
        }
    });
});
//列表页连续登陆--结束

//最新消息
function load_message() {
    if (g_uid == 0) {
        return false;
    }
    $.post(g_site_url + "index.php?user/ajaxloadmessage", function(msg) {
    	var msgcount= parseInt(msg.msg_personal)+parseInt(msg.msg_system)+parseInt(msg.message_recommand);
    	$(".msg-tip").html("")
    		if(msgcount>0){
    			$('.msg-tip').show();
    		}
    		$(".msg-count").html(msgcount);
    		var personurl=g_site_url + "index.php?message/personal"+g_suffix;
            var systemurl=g_site_url + "index.php?message/system"+g_suffix;
            var recommendurl=g_site_url + "index.php?user/recommend"+g_suffix;
           // console.log(personurl);
        if (msg.msg_personal != 0) {
        
          var p='  <p class="close-tip1">'+msg.msg_personal+'条私人消息，<a href="'+personurl+'" target="_blank">立即查看</a></p><span class="close-tip1 close-tip js-close-tip"></span>';
       $(".msg-tip").append(p);
        }
        if (msg.msg_system != 0) {
        	
        	 var p='  <p class="close-tip2">'+msg.msg_system+'条系统消息，<a href="'+systemurl+'" target="_blank">立即查看</a></p><span class="close-tip2 close-tip js-close-tip"></span>';
        	 $(".msg-tip").append(p);
        }
        if (msg.message_recommand != 0) {
        	
        	 var p='  <p class="close-tip3">'+msg.message_recommand+'条为我推荐，<a href="'+recommendurl+'" target="_blank">立即查看</a></p><span class="close-tip3 close-tip js-close-tip"></span>';
        	 $(".msg-tip").append(p);
        }
        $(".close-tip1").click(function(){
        	$(".close-tip1").remove();
var msg=$(".msg-tip").html();
        	
        	if(msg.length==2){
        		$(".msg-tip").remove();
        	}
        	
        });
        $(".close-tip2").click(function(){
        	$(".close-tip2").remove();
var msg=$(".msg-tip").html();
        	
        	if(msg.length==2){
        		$(".msg-tip").remove();
        	}
        });
        $(".close-tip3").click(function(){
        	$(".close-tip3").remove();
        	var msg=$(".msg-tip").html();
        	
        	if(msg.length==2){
        		$(".msg-tip").remove();
        	}
        });
    }, "json");
}
//设置分类位置
$("#navStore").hover(function(){
	$("#bread-crumbs").css("top",$(this).offset().top+40).css("left",$(this).offset().left).show();
},function(){
	$("#bread-crumbs").hide();
})
 $(".navshow").hover(function(){
                    	$(this).addClass("bcolor").find(".subnav").css("display","block");
                    },function(){
                    	$(this).removeClass("bcolor");
                    	$(this).find(".subnav").css("display","none");
                    });
