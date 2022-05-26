define(function(require, exports, module) {
	var $ = jQuery = require('jquery');
	require('edturl/ueditor.all.min');
	function editor(d,name,type,x,y) {
		var p=d.parents(".ftype_ckeditor");
		/*加载状态*/
		if(p.prev("dt").length<1){
			p.css({'padding':'0px','margin':'0px'});
			d.parent(".fbox").css("padding","0px 5px");
		}else{
			x = x?x:'98%';
		}
		p.find('.fbox').css('margin','0px');
		if(type==1)p.find('.fbox').css('padding-right','5px');
		/*配置编辑器*/
		d.attr("id",'container_'+name);
		var ue = UE.getEditor('container_'+name,{
			lang:M.synchronous=='en'?'en':'zh-cn',
			iframeCssUrl: siteurl + 'public/admin_old/plugins/bootstrap/bootstrap.min.css',
			scaleEnabled :true,
			initialFrameWidth : x?x:'100%',
			initialFrameHeight : y?y:(type==1?160:400)
		});
	}
	exports.func = function(d){
		d = d.find('.ftype_ckeditor .fbox textarea');
		d.each(function(){
			var n = $(this).attr('name'),t=$(this).attr('data-ckeditor-type'),x=$(this).attr('data-ckeditor-x'),y=$(this).attr('data-ckeditor-y');
			editor($(this),n,t,x,y);
		});
	}
});