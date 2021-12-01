/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
define(function(require, exports, module) {

	window.met_mobile= document.body.clientWidth<700?true:false;
	var $ = require('jquery');
	window.jQuery = window.$ = $;
	/*增加对$.browser.msie的支持*/
	require('epl/jquery-migrate-1.2.1.min');
	function AssemblyLoad(dom){
		/*上传组件*/
		if(dom.find('.ftype_upload .fbox input').length){
			require.async('epl/upload/own',function(a){
				a.func(dom);
			});
		}
		/*编辑器*/
		if(dom.find('.ftype_ckeditor .fbox textarea').length){
			require.async('edturl/own',function(a){
				a.func(dom);
			});
		}
		/*颜色选择器*/
		if(dom.find('.ftype_color').length){
			require.async('epl/color/set',function(a){
				a.func(dom);
			});
		}
		/*滑块*/
		if(dom.find('.ftype_range .fbox input').length){
			require.async('epl/range/range',function(a){
				a.func(dom);
			});
		}
		/*日期选择器*/
		if(dom.find('.ftype_day input').length){
			require.async('epl/time/time',function(a){
				a.func(dom);
			});
		}
		/*联动菜单*/
		if(dom.find('.ftype_select-linkage .fbox').length){
			require.async('epl/select-linkage/select',function(a){
				a.func(dom);
			});
		}
		/*标签增加器*/
		if(dom.find('.ftype_tags').length){
			require.async('epl/tags/tags',function(a){
				a.func(dom);
			});
		}
		/*表格控件*/
		if(dom.find('.ui-table:not([data-noajax])').length){
			require.async('epl/table/table',function(a){
				a.func(dom);
			});
		}
		// 图标选择
		if(dom.find('.icon-add[data-toggle="modal"][data-target=".icon-modal"]').length) require.async('epl/icon_choose/icon');
		/*特殊参数表单控件处理*/
		var $input_data_name=dom.find('.ftype_input input[data-name]');
		if($input_data_name.length){
			$input_data_name.each(function(index, el) {
				if($(this).data('name')=='met_font'){
					var met_font=new Array('宋体','Microsoft YaHei','Tahoma','Verdana','Simsun','Segoe UI','Lucida Grande','Helvetica','Arial','FreeSans','Arimo','Droid Sans','wenquanyi micro hei','Hiragino Sans GB','Hiragino Sans GB W3','sans-serif'),
						met_font_str='<datalist id="tsselect_met_font">';
					$.each(met_font, function(index, val) {
						met_font_str+='<option value="'+val+'"/>';
					});
					met_font_str+='</datalist>';
					$(this).attr({list:'tsselect_met_font'}).after(met_font_str);
				}
			});
		}
		// 表单底部下拉菜单高度过长控制
		if($(".list-type-update").length){
			var $list_type_update=$(".list-type-update");
			$list_type_update.prev('.dropdown-toggle').click(function(e) {
				var $obj=$(this).next('.list-type-update'),
					this_top=$(this).parents('.dropup').offset().top;
				if($obj.outerHeight()+5>this_top){
					$obj.addClass('maxh').css({'max-height':this_top-2});
				}else{
					$obj.removeClass('maxh').css({'max-height':'none'});
				}
			});
			$('.list-type-update .dropdown-submenu .dropdown-toggle').one('click',function(event) {
				if(!$(this).parents('.list-type-update').hasClass('maxh')){
					var this_top=$(this).offset().top,
						this_h=$(this).outerHeight(),
						dropdown_menu_h=$(this).next('.dropdown-menu').outerHeight();
					if(this_top+this_h<dropdown_menu_h+5){
						$(this).next('.dropdown-menu').css({bottom:this_top+this_h+2-dropdown_menu_h});
					}else{
						$(this).next('.dropdown-menu').css({bottom:0});
					}
				}
			});
		}
	}

	/*加载组件*/
	exports.AssemblyLoad = function(dom){
		AssemblyLoad(dom);
	}

	/*默认选中*/
	exports.defaultoption = function(box){
		function ckchuli(n,v){
			$("input[name='"+n+"'][value='"+v+"']").attr('checked',true);
		}
		var cklist = $("input[data-checked],select[data-checked]");
		if(box)cklist = box.find("input[data-checked],select[data-checked]");
		if(cklist.length>0){
			cklist.each(function(){
				var v = $(this).attr('data-checked'),n=$(this).attr('name'),t=$(this).attr('type');
				if(v!=''){
					if($(this)[0].tagName=='SELECT'){
						$(this).val(v);
					}
					if(t=='radio')ckchuli(n,v);
					if(t=='checkbox'){
						if(v.indexOf("|")==-1){
							ckchuli(n,v);
						}else{
							v = v.split("|");
							for (var i = 0; i < v.length; i++) {
								if(v[i]!=''){
									ckchuli(n,v[i]);
								}
							}
						}
					}
				}
			});
		}
	}

	exports.metalert = function(data){
		var html     = data.html,
			type     = data.type?data.type:'alert',
			LeftTxt  = data.LeftTxt?data.LeftTxt:'确定',
			RighTtxt = data.RighTtxt?data.RighTtxt:'取消',
			MaxWidth = data.MaxWidth?data.MaxWidth:400;
		switch(type){
			case 'alert':
				html = "<p>"+html+"</p><ul class='cd-buttons metalert_type_alert'><li><a href='#0'>"+METLANG.jslang5+"</a></li></ul>";
			break;
			case 'confirm':
				html = "<p>"+html+"</p><ul class='cd-buttons metalert_type_confirm'><li><a href='#0' data-buer='1'>"+LeftTxt+"</a></li><li><a href='#0' data-buer='0'>"+RighTtxt+"</a></li></ul>";
			break;
		}
		if($("#metalertbox").length>0){
			html = "<div class='cd-popup-container'>"+html+"<a href='#0' class='cd-popup-close img-replace'>Close</a></div>";
			$("#metalertbox").html(html);
		}else{
			html = "<div class='cd-popup' id='metalertbox'><div class='cd-popup-container'>"+html+"<a href='#0' class='cd-popup-close img-replace'>Close</a></div></div>";
			$("body").append(html);
		}
		if(MaxWidth!=400)$(".cd-popup-container").css("max-width",MaxWidth+'px');
		setTimeout(function () {
			$('.cd-popup').addClass('is-visible');
		}, 10);
		if(type == 'window')AssemblyLoad($("#metalertbox"));
		//事件绑定
		$('.metalert_type_alert').on('click', function(event){
			event.preventDefault();
			$('.cd-popup').removeClass('is-visible');
			data.callback(data.status);
		});
		$('.metalert_type_confirm a').on('click', function(event){
			event.preventDefault();
			var b = $(this).attr("data-buer")==1?true:false;
			data.callback(b);
			$('.cd-popup').removeClass('is-visible');
		});
		$('.cd-popup').on('click', function(event){
			if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup') ) {
				event.preventDefault();
				$(this).removeClass('is-visible');
			}
		});
		$(document).keyup(function(event){
			if(event.which=='27'){
				$('.cd-popup').removeClass('is-visible');
			}
		});
	}

	/*数值转换为金额*/
	exports.fmoney = function(s, n){
		n = n > 0 && n <= 20 ? n : 2;
		s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";
		var l = s.split(".")[0].split("").reverse(), r = s.split(".")[1];
		t = "";
		for (i = 0; i < l.length; i++) {
		t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");
		}
		return '￥'+t.split("").reverse().join("") + "." + r;
	}

	/*列表自适应排版*/
	function listpun(zd,ld,min,i){
			i = i?i:1;
		var z= zd.width(),
			l= ld.length,
			h = parseInt(l/i),
			p = parseInt(z/h);
		if(p>min){
			var w = 1/h*100;
			w = w.toFixed(5)+'%';
			ld.css("width",w);
		}else{
			listpun(zd,ld,min,i+1);
		}
	}
	exports.listpun = function(zd,ld,min){//整体元素,列表元素,最小宽度
		listpun(zd,ld,min);
	}

	/*替换URL特定参数*/
	exports.replaceParamVal = function(Url,Name,Val){
		var re=eval('/('+ Name+'=)([^&]*)/gi');
		var nUrl = Url.replace(re,Name+'='+Val);
		return nUrl;
	}
	/*语言文字*/

	exports.langtxt = function(){
		return langtxt;
	}

	/*隐藏、展开更多设置*/
	exports.showMoreSet = function(){
		$(document).on('click','.showmoreset-btn',function(e){
			var $self=$(this),
				index=$(this).index($('.showmoreset-btn')),
				$content=$('.showmoreset-content').eq(index),
				hidden_text=$(this).data('hidden_text')||METLANG.jslang7,
				show_text=$(this).data('show_text')||METLANG.jslang6;
			$content.slideToggle(300);
			setTimeout(function(){
				if($content.is(':visible')){
					$('html,body').stop().animate({scrollTop:$content.offset().top},300);
					$self.html(hidden_text);
				}else{
					$self.html(show_text);
				}
			},500)
		})
	}
});
