/**
 * 系统新闻
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
	var that=$.extend(true,{}, admin_module);
	// 消息列表加载
	M.component.commonList(function(that){
		return {
        	ajax:{
        		dataSrc:function(result){
					var data=[];
					if(result.data){
						$.each(result.data, function(index, val) {
							var item=[
									'<a href="'+val.url+'" target="_blank" data-id="'+val.id+'" data-see_ok="'+val.see_ok+'">'+val.newstitle+'</a>',
									val.time
								];
							data.push(item);
						});
					}
				    return data;
		        }
        	}
        };
	});
	// 点击消息标记为已读
	that.obj.find('#sysnews-list tbody').on('click', 'a', function(event) {
		if(!parseInt($(this).data('see_ok'))) $(this).attr('data-see_ok',1) && metui.ajax({
			url:that.own_name+'c=news&a=donews_seeok',
			data:{id:$(this).data('id')}
		});
	});
})();