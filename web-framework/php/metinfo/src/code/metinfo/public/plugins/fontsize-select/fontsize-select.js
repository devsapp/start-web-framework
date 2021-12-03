/**
 * 字体大小下拉选择
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
$.fn.fontSizeSelect=function(){
	var id='select-font'+new Date().getTime(),
		list_html=(function(){
			var list=[12,14,16,18,20,24,26,28,30,36,40],
				html='';
			$.each(list,function(index, el){
				html+='<a class="dropdown-item px-2 py-1" href="javascript:;">'+el+METLANG.setimgPixel+'</a>';
			});
			html='<div class="dropdown-menu">'
				+'<a class="dropdown-item px-2 py-1" href="javascript:;">'+METLANG.default_values+'</a>'
				+html
			+'</div>';
			return html;
		})();
	$(this).attr({placeholder:METLANG.default_values,'data-toggle':'dropdown'}).each(function(index, el) {
		var inline_block=$(this).css('display')=='inline-block'?' d-inline-block':' d-block',
			float=$(this).css('float')!='none'?' float-'+$(this).css('float'):'';
		$(this).wrap('<div class="navbar p-0'+inline_block+float+'"><div class="dropdown clearfix"></div></div>');
		$(this).val(parseInt($(this).val())||'').after(list_html);
	});
};
(function(){
	// 字体大小切换
	$(document).on('click', '[data-plugin="select-fontsize"]+.dropdown-menu a', function(event) {
		$(this).parent().prev('input').val(parseInt($(this).html())||'');
	});
	$(document).on('change', '[data-plugin="select-fontsize"]', function(event) {
		$(this).val(parseInt($(this).val())||'');
	});
})();