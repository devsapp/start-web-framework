define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');

	/*语言文字*/
	var langtxt = common.langtxt();
	var err = new Array();
		err[1] = langtxt.formerror1;
		err[2] = langtxt.formerror2;
		err[3] = langtxt.formerror3;
		err[4] = langtxt.formerror4;
		err[5] = langtxt.formerror5;
		err[6] = langtxt.formerror6;
		err[7] = langtxt.formerror7;
		err[8] = langtxt.formerror8;
		err[9] = langtxt.js46;
	function trim(str){ //删除左右两端的空格
		//return str.replace(/(^\s*)|(\s*$)/g, "");
		return str;
	}
	function ftn(m){ //验证
		var f='';
			m.each(function(i){
				var d=$(this),e='|*|',v = d.attr('data-size'),l=trim(d.val()),j=0,t=d.attr('type');//最小字数
				/*字数限制*/
				if(v){
					v = v.split('-');
					if(v[1]=='min'){
						if(l.length<v[0]){ j=1;e+=err[6]+'|$|'; }
					}else if(v[1]=='max'){
						if(l.length>v[0]){ j=1;e+=err[7]+'|$|'; }
					}else{
						if(l.length<v[0]||l.length>v[1]){ j=1;e+=err[8]+'|$|'; }
					}
				}

				/*不为空*/
				if(d.attr('data-required')){
					if(t=='input'||t=='text'||t=='password'||t=='number'||d[0].tagName=='TEXTAREA'){
						if(l==''){ j=1;e+=err[1]+'|$|'; }
					}
					if(d[0].tagName=='SELECT'){
						if(l==''){ j=1;e+=err[2]+'|$|'; }
					}
					if(t=='radio'){
						if($("input[name='"+d.attr('name')+"']:checked").length<1){ j=1;e+=err[2]+'|$|'; }
					}
				}
				if(t=='checkbox'){
					if(d.parents('div.fbox').find("input").eq(0).attr('data-required')){
						if(d.parents('div.fbox').find("input:checked").length<1){ j=1;e+=err[2]+'|$|'; }
					}
				}

				/*手机号码*/
				if(d.attr('data-mobile')){
					if(l!=''){
						var regexp=/^1[0-9]{10}$/;
						if(!regexp.test(l)){ j=1;e+=err[3]+'|$|'; }
					}
				}

				/*邮箱地址*/
				if(d.attr('data-email')){
					if(l!=''){
						var regexp=/^[-a-zA-Z0-9_\.]+@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$/;
						if(!regexp.test(l)){ j=1;e+=err[4]+'|$|'; }
					}
				}

				/*自定义验证*/
				if(d.attr('data-custom')){
					var rok = eval(d.attr('data-custom'));
					if(!rok){ j=1;e+='errortxt'+'|$|'; }
				}

				/*密码*/
				if(d.attr("data-password")){
					var p = $("input[name='"+d.attr("data-password")+"']");
					if((l==''&&p.val()!='')||(l!=''&&l!=p.val())){ j=1;e+=err[5]+'|$|'; }
				}
				if($("input[data-password='"+d.attr("name")+"']").length>0){
					var p = $("input[data-password='"+d.attr("name")+"']").eq(0);
					fsut(p,1);
				}

				/*不能重复*/
				if(d.attr('data-norepeat')&&l!=''){
					var r = d.attr('data-norepeat');
					var dr = $("input[data-norepeat='"+r+"']");
					var q = 0;
					dr.each(function(){
						if( $(this).val() == l && $(this).attr('name') != d.attr('name') )q=1;
					});
					if(q==1){
						j=1;e+= err[9]+'|$|';
					}
				}

				if(j==1)f += d.attr('name')+e+'|#|';
			});
		return f;
	}
	/*同步验证*/
	$(document).on('change', '.ui-from [data-ajaxcheck-url]', function(event) {
		var $self=$(this),
			value=trim($(this).val());
		if(value!=''){
			$.ajax({
				type: "GET",
				async:false,
				url: $(this).attr('data-ajaxcheck-url')+'&'+$(this).attr('name')+'='+value,
				success: function(result){
					if(typeof result.valid=='undefined'){
						result=result.split('|');
						result={
							valid:result[0],
							message:result[1],
						};
					}
					var m = result.message;
					var fa = Number(result.valid)?'fa fa-check':'';
					if(fa==''){
						var e='|*|'+m+'|$|';
						var f = $self.attr('name')+e+'|#|';
						chuli(f,'');
						$self.parents('.ui-from').find('.btn[type="submit"]').addClass('disabled');
					}else{
						zchuli($self,m,0,fa);
						$self.parents('.ui-from').find('.btn[type="submit"]').removeClass('disabled');
					}
				}
			});
		}
	});
	/*报错处理*/
	function errtxt(d,fv){ //错误文字提取
		var t;
		var f = fv.split("|$|");
		t = f[0];
		return t;
	}
	function zchuli(d,txt,g,fa){//报错执行
		var o = d.parents('div.fbox'),fs=fa?fa:'fa fa-times';
		if(o.find(".formerror").length>0){
			o.find(".formerror").remove();
		}
		if(d.next(".formerror").length>0){
			d.next(".formerror").remove();
		}
		if(o.length>0){
			o.append("<div class='formerror'><i class='"+fs+"'></i>"+txt+"</div>");
		}else{
			d.after("<div class='formerror'><i class='"+fs+"'></i>"+txt+"</div>");
		}
		if(d[0].tagName=='INPUT'||d[0].tagName=='TEXTAREA'){
			d.addClass("formerrorbox");
			if(fs!='fa fa-times')d.removeClass('formerrorbox');
		}
		if(g==1)d.focus();
	}
	function chuli(f,t){ //报错信息分解
		f = f.split("|#|");
		var n = '',d,txt;
		for(var i=0;i<f.length;i++){
			if(f[i]!=''){
				var fv = f[i].split("|*|");
				d = $("*[name='"+fv[0]+"']").eq(0);
				txt = d.attr("data-errortxt")?d.attr("data-errortxt"):errtxt(d,fv[1]);
				if(txt.indexOf('&metinfo&')!=-1&&d.attr("data-size")){
					var x,v = d.attr("data-size").split('-');
					if(v[1]=='min'||v[1]=='max'){
						x = v[0];
					}else{
						x = d.attr("data-size");
					}
					txt = txt.replace("&metinfo&",x);
				}
				var g = 0;
				if(i==0&&!t)g = 1;
				zchuli(d,txt,g);
			}
		}
	}
	function hfbc(d){
		/*清除提示信息*/
		d.removeClass('formerrorbox');
		if(!d.attr('data-ajaxcheck-url')){
			d.parents('div.fbox').find(".formerror").remove();
			if(d.next(".formerror").length>0){
				d.next(".formerror").remove();
			}
		}
		/*多选赋值*/
		d.each(function(){
			var d=$(this),l=d.val(),t=d.attr('type');
			if(t=='checkbox'){
				if($("input[name='"+d.attr('name')+"']").length>1){
					var v='',c = d.parents('div.fbox').find("input[name='"+d.attr('name')+"']:checked");
					var z = $("input[data-checkbox='"+d.attr('name')+"']");
					c.each(function(i){
						v+=(i+1)==c.length?$(this).val():$(this).val()+'|';
					});
					if(z.length>0){
						z.val(v);
					}else{
						d.parents('div.fbox').append("<input name='"+d.attr('name')+"' data-checkbox='"+d.attr('name')+"' type='hidden' value='"+v+"' />");
					}
				}
			}
		});
	}
	function fsut(d,t,l){ //表单提交处理 * d 表单 * t 非点击按钮 * l 表格列表提交
		if(l){
			var id = d.parents('form').find("input[name='id']");
			if(id.length>0&&$(".ui-table").length>0){
				if(d.parents('form').find("input[name='allid']").length==0){
					d.parents('form').append('<input type="hidden" name="allid" value="" />');
				}
				var allid = $("input[name='allid']"),value = '';
				id.each(function() {
					if ($(this).attr("checked")) value += $(this).val() + ',';
				});
				allid.val(value);
				if(allid.val()==''){
					common.metalert({html:langtxt.js23});
					var issubmit = $("select[data-isubmit='1']");
					if(issubmit.length>0){
						issubmit.val('');
					}
					return false;
				}
			}
		}
		// 商品图尺寸数组合并赋值（新模板框架v2）
		var $appimagelist=d.parents('form').find('.app-image-list'),
			imgsizes_value = '';
		$appimagelist.find('.sort img').each(function(index, el) {
			if(index>0) imgsizes_value+='|';
			imgsizes_value+=$(this).data('size');
		});
		if(!d.parents('form').find("input[name='imgsizes']").length) $appimagelist.parent('.picture-list').after('<input type="hidden" name="imgsizes"/>');
		d.parents('form').find("input[name='imgsizes']").val(imgsizes_value);

		var f=ftn(d),r;
		if(f){
			chuli(f,t);//验证失败处理
			r = false;
		}else{
			hfbc(d);//验证成功处理
			r = true;
		}
		if(!t)return r;
	}

	common.defaultoption();//默认选择项
	/*表单验证*/
	$(document).on('submit',"form.ui-from",function(){
		if(fsut($(this).find("input,textarea,select"),'',1)){
			$('form.ui-from input[type="submit"][data-yval]').val('loading...').addClass("inputloading").attr("disabled",true);
			return true;
		}else{
			return false;
		}
	});
	$(document).on('click',"form.ui-from input[type='submit']",function(){
		$(this).attr("data-yval",$(this).val());
	});

	//失去焦点时验证
	$(document).on('focusout',".ui-from dd input,.ui-from dd textarea",function(){
		var c=$(this);
		if(c.parents('dd.ftype_day').length==0){
			if(!c.attr('type')||c.attr('type')!='submit'){
				fsut(c,1);
			}
		}
	});
	//单选多选获得焦点时验证
	$(document).on('focusout',".ui-from input[type='radio'],.ui-from input[type='checkbox']",function(){
		var d=$("input[name='"+$(this).attr('name')+"']").eq(0); fsut(d,1);
	});
	//特殊情况处理
	$(document).on('change',".ui-from input[type='radio'],.ui-from input[type='checkbox']",function(){
		var d=$("input[name='"+$(this).attr('name')+"']").eq(0); fsut(d,1);
	});
	$(document).on('change',".ui-from select",function(){
		var d=$(this); fsut(d,1);
	});

	//确认
	$(document).on('click',"*[data-confirm]",function(event){
		var my = $(this) , txt = my.attr('data-confirm'),tg = my[0].tagName;
		event.preventDefault();
		common.metalert({
			html:txt,
			type:'confirm',
			callback:function(buer){
				if(buer){
					switch(tg){
						case 'A':
							my.data('ajax')?
							$.ajax({
								url: my.attr("href"),
								type: 'GET',
								dataType: 'json',
								success:function(result){
									result.msg && common.metalert({
										html:result.msg,
										type:'alert',
										status:result.status,
										callback:function(buer){
											buer && ($('.page-iframe',parent.document).attr({'data-reload':1}),window.location.reload());
										}
									});
								}
							}):(window.location.href = my.attr("href"));
							break;
						case 'INPUT': my.parents("form").submit(); break;
						case 'BUTTON': my.parents("form").submit(); break;
						case 'BUTTON': my.parents("form").submit(); break;
					}
				}
			}
		});
	});

	/*提交按钮效果*/
	$(document).ready(function(){
		$(".ui-from .submit").focus(function(){
			this.blur();
		}).mousedown(function(){
			$(this).addClass("active");
		}).mouseup(function(){
			$(this).removeClass("active");
		}).mouseleave(function(){
			$(this).removeClass("active");
		});
	});

	/*快捷提交*/
	Array.prototype.unique = function() {
		var o = {};
		for (var i = 0, j = 0; i < this.length; ++i) {
			if (o[this[i]] === undefined) {
				o[this[i]] = j++;
			}
		}
		this.length = 0;
		for (var key in o) {
			this[o[key]] = key;
		}
		return this;
	};
	var keys = [];
	$(document).keydown(function(event) {
		keys.push(event.keyCode);
		keys.unique();
	}).keyup(function(event) {
		if (keys.length > 2) keys = [];
		keys.push(event.keyCode);
		keys.unique();
		if (keys.join('') == '1713') {
			var input = $("input[type='submit']");
			if (input.length == 1) {
				if (!input.attr('disabled')) {
					input.click();
				}
			}
		}
		keys = [];
	});

});
