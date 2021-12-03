/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
define(function(require, exports, module) {
	var jQuery = $ = require('jquery');
	require('lang_json_admin');

	/*操作成功，失败提示信息*/
	if(top.location != location) $("html",parent.document).find('.returnover').remove();
	// 弹出页面返回的提示信息
	var turnover=[];
	turnover['text']=getQueryString('turnovertext');
	turnover['type']=parseInt(getQueryString('turnovertype'));
	turnover['delay']=turnover['type']?undefined:0;
	if(turnover['text']) metAlert(turnover['text'],turnover['delay'],!turnover['type'],turnover['type']);
	/*cookie*/
	require('epl/cookie');
	//adminlang = $.cookie('langset');当前后台语言
	//bootstrap
	require('epl/bootstrap/bootstrap.min');
	// 系统参数
	window.MSTR=$('meta[name="generator"]').data('variable').split('|');
	window.M={
		weburl:siteurl,
		lang:lang,
		synchronous:langset,
		url:{
			admin:basepath,
			public_plugins:siteurl + 'public/plugins/',
			system:siteurl+'app/system/'
		},
		
	};
	M.lazyloadbg=M.weburl +'public/images/loading.gif';
	//初始化
	var common = require('common');   		//公用类
	/*---------页面组件加载---------*/
	/*表单验证*/
	if($('form.ui-from').length>0)require.async('epl/form/form');
	common.AssemblyLoad($("body"));
	/*---------动态事件绑定-----------------*/
	/*输入状态*/
	$(document).on('focus',"input[type='text'],input[type='input'],input[type='password'],textarea",function(){
		$(this).addClass('met-focus');
	});
	$(document).on('focusout',"input[type='text'],input[type='input'],input[type='password'],textarea",function(){
		$(this).removeClass('met-focus');
	});
	/*显示隐藏选项*/
	function showhidedom(m){
		var c = m.attr("data-showhide"),d=$("."+c);
		d.stop(true,true);
		if(d.is(":hidden")){
			d.removeClass('none').hide().slideDown();
			if(m.attr("type")=='radio'){
				m.parents('.fbox').find("input").not(m).change(function(){
					d.slideUp();
				});
			}
		}
	}
	$(document).ready(function(){
		var p = $(".ui-from input[type='radio'][data-showhide]:checked,.ui-from input[type='checkbox'][data-showhide]:checked");
		if(p.length>0){
			p.each(function(){
				showhidedom($(this));
			});
		}
	});
	$(document).on('change',".ui-from input[type='radio'][data-showhide]",function(){
		showhidedom($(this));
	});
	$(document).on('change',".ui-from input[type='checkbox'][data-showhide]",function(){
		var s = $(this).attr("checked")== 'checked'?true:false;
		if(s){
			showhidedom($(this));
		}else{
			var c = $(this).attr("data-showhide"),d=$("."+c);
			d.stop(true,true);
			d.slideUp();
		}
	});
	var dlp = '';
	/*浏览器兼容*/
	if($.browser.msie || ($.browser.mozilla && $.browser.version == '11.0')){
		var v = Number($.browser.version);
		if(v<10){
			function dlie(dl){
				var dw;
				dl.each(function(){
					var dt = $(this).find("dt"),dd = $(this).find("dd");
					if(dt.length>0){
						dt.css({"float":"left","overflow":"hidden"});
						dd.css({"float":"left","overflow":"hidden"});
						var wd = $(this).width() - (dt.width()+30) - 15;
						dd.width(wd);
						dw = wd;
					}
				});
				dl.each(function(){
					var dt = $(this).find("dt"),dd = $(this).find("dd");
					if(dt.length>0){
						dd.width(dw);
					}
				});
			}
			var dl = $(".v52fmbx dl");
			dlie(dl);
			dlp = 1;
		}
		if(v<12){
			/*提示文字兼容*/
			function searchzdx(dom,label){
				if(dom.val()==''){
					label.show();
				}else{
					label.hide();
				}
				dom.keyup(function(){
					if($(this).val()==''){
						label.show();
					}else{
						label.hide();
					}
				});
				label.click(function(){
					$(this).next().focus();
				});
			}
			$(document).ready(function(){
				var pd = $("input[type!='hidden'][placeholder],textarea[placeholder]");
				pd.each(function(){
					var t = $(this).attr("placeholder");
					$(this).removeAttr("placeholder");
					$(this).wrap("<div class='placeholder-ie'></div>");
					$(this).before("<label>"+t+"</label>");
					searchzdx($(this),$(this).prev("label"));
				});
				setInterval(function(){
					pd.each(function(){
						searchzdx($(this),$(this).prev("label"));
					});
				}, "200");
			});
		}
	}
	require('own_tem/js/own');//加载应用脚本
});
// 弹出提示信息
function metAlert(text,delay,bg_ok,type){
    delay=typeof delay != 'undefined'?delay:2000;
    bg_ok=bg_ok?'bgshow':'';
    if(text!=' '){
        text=text||METLANG.jsok;
        text='<div>'+text+'</div>';
        if(parseInt(type)==0) text+='<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span></button>';
        if(!$('.metalert-text').length){
        	var html='<div class="metalert-text">'+text+'</div>';
        	if(bg_ok) html='<div class="metalert-wrapper alert '+bg_ok+'">'+html+'</div>';
        	$('body').append(html);
        }
        var $met_alert=$('.metalert-text'),
            $obj=bg_ok?$('.metalert-wrapper'):$met_alert;
        $met_alert.html(text);
        $obj.show();
        if($met_alert.height()%2) $met_alert.height($met_alert.height()+1);
    }
    if(delay){
        setTimeout(function(){
            var $obj=bg_ok?$('.metalert-wrapper'):$('.metalert-text');
            $obj.fadeOut();
        },delay);
    }
}
function js_error(error) {
	switch(error){
		case 'error_code':
			return langtxt.please_again;
		break;
		case 'error_passpay':
			return langtxt.password_mistake;
		break;
		case 'error_code':
			return langtxt.please_again;
		break;
		case 'error_evamuch':
			return langtxt.product_commented;
		break;
		case 'error_nobuyeva':
			return langtxt.goods_comment;
		break;
		case 'error_nop':
			return langtxt.permission_download;
		break;
		default :
			return error;
		break;
	}
}