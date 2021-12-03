/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
(function(){
	var that=$.extend(true,{}, admin_module);
	// 后台文件夹安全提示
	M.component.modal_options['.admin-folder-safe-modal']={
		modalType:'centered',
		modalTitle:METLANG.help2,
		modalBodyclass:'text-center',
		modalBody:'<p class="text-danger">'+METLANG.tips8_v6+'！</p>'
		    +'<div>'
		        +'<button type="button" class="btn btn-default no-prompt" data-url="'+M.url.admin+'?n=index&c=index&a=do_no_prompt" data-dismiss="modal">'+METLANG.nohint+'</button>'
		        +'<a href="#/safe" class="btn btn-primary ml-5 btn-adminfolder-change" title="'+METLANG.safety_efficiency+'">'+METLANG.tochange+'</a>'
		    +'</div>',
		modalRefresh:'one',
		modalFooterok:0
    };
	M.admin_folder_safe=parseInt(that.obj.find('[name="admin_folder_safe"]').val());
	if(!M.admin_folder_safe){
		that.obj.find('[name="admin_folder_safe"]').click();
		$('.admin-folder-safe-modal .no-prompt').click(function(event) {
			 metui.ajax({
	            url: $(this).data('url')
	        });
		});
		$('.admin-folder-safe-modal .btn-adminfolder-change').click(function(event) {
			$('.admin-folder-safe-modal').modal('hide');
		});
	}
	var $home_app_list=that.obj.find('.home-app-list'),
		$home_news_list=that.obj.find('.home-news-list');
	// 推荐应用
	if($home_app_list.length){
		metui.ajax({
			url:M.url.api+'n=platform&c=platform&a=dotable_applist_json&type=dlist',
			type:'GET',
			dataType:'jsonp'
		},function(result){
			var html='';
			$.each(result, function(index, val) {
				var url='https://www.metinfo.cn/appstore/app'+val.id+'.html';
				html+='<div class="col-12 col-sm-6 col-md-4 py-2 px-2">'
					+'<div class="media p-3 h-100 transition500">'
						+'<a href="'+url+'" target="_blank" class="d-flex">'
							+'<div><img class="mr-3" src="'+val.icon+'" width="80"></div>'
							+'<div class="media-body">'
								+'<h4 class="mt-0 h6">'+val.appname+'</h4>'
								+'<div class="text-grey">'+val.info+'</div>'
							+'</div>'
						+'</a>'
					+'</div>'
				+'</div>';
			});
			$home_app_list.html(html);
		});
	}
	// MetInfo 新闻
	if($home_news_list.length){
		metui.ajax({
			url:$home_news_list.data('url')+'&fromurl='+M.weburl,
			type:'GET',
			dataType:'jsonp',
			jsonp: 'jsoncallback'
		},function(result){
			$home_news_list.html(result.msg).find('ul').addClass('list-unstyled mb-0').find('li').addClass('my-2').find('span').addClass('float-right text-grey');
			$home_news_list.find('li a').addClass('text-content');
		});
	}
})();