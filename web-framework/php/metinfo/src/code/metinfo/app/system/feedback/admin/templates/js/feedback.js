/**
 * 反馈模块
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
	// 反馈列表
    M.component.commonList(function(that,table_order){
		var edit_dataurl=that.module+'/edit/?c='+that.module+'_admin&a=doview&class1='+that.data.class1+'&class2='+that.data.class2+'&class3='+that.data.class3+'&id=';
        return {
        	ajax:{
        		dataSrc:function(result){
					var data=[];
					if(result.data){
						$.each(result.data, function(index, val) {
							val.readok=parseInt(val.readok);
							var para_list=(function(){
									var list=[];
									$.each(val.para_list, function(index1, val1) {
										list.push(val1);
									});
									return list;
								})(),
								item=[
									M.component.checkall('item',val.id),
									val.id,
									'<span class="badge font-weight-normal py-1 badge-'+(val.readok?'secondary':'warning')+'">'+METLANG[val.readok?'read':'unread']+'</span>',
								];
							if(para_list.length) item=item.concat(para_list);
							item=item.concat([
								val.addtime,
								'<button type="button" class="btn btn-sm btn-primary mr-1" data-toggle="modal" data-target=".'+that.module+'-details-modal" data-modal-title="'+METLANG.View+'" data-modal-size="lg" data-modal-url="'+edit_dataurl+val.id+'" data-modal-fullheight="1" data-modal-tablerefresh="'+table_order+'" data-modal-tablerefresh-type="'+(val.readok?0:1)+'">'+METLANG.View+'</button>'
								+M.component.btn('del',{del_url:val.delet_url})
							]);
							data.push(item);
						});
					}
				    return data;
		        }
        	}
        };
    });
    // 反馈信息导出按钮链接更新
    $(document).on('change','.select-feedback-export',function(event) {
    	var $btn_feedback_export=$(this).next('.btn-feedback-export'),
    		val=parseInt($(this).val()),
			url='';
    	if(val){
    		url+='&allid=';
    		$(this).parents('form').find('table tbody tr .checkall-item:checked').each(function(index, el) {
    			url+=(index?',':'')+$(this).val();
    		});
    	}else{
    		$(this).parents('.tab-pane').find('[data-table-search]:not([type="hidden"]):not([hidden])').filter(function(index) {
    			return $(this).val()!='';
    		}).each(function(index, el) {
    			url+='&'+$(this).attr('name')+'='+$(this).val();
    		});
    	}
    	$btn_feedback_export.attr({href:$btn_feedback_export.attr('data-href')+url});
    });
    // 反馈信息导出按钮点击判断
    $(document).on('click','.btn-feedback-export',function(event) {
    	var allid=$(this).attr('href').indexOf('&allid=')>0;
    	if(allid && !$(this).parents('table').find('.checkall-item:checked').length){
    		event.preventDefault();
    		alertify.error(METLANG.jslang3||METLANG.least_one_item);
    	}
    });
    // 反馈列表筛选参数后更新导出按钮链接
    $(document).on('change','[data-table-search*="#feedback-list-"]:not([type="hidden"]):not([hidden]),table[id*="feedback-list-"] [data-table-search]:not([type="hidden"]):not([hidden]),table[id*="feedback-list-"] .checkall-item',function(event) {
    	$(this).parents('.tab-pane').find('.select-feedback-export').change();
    });
})();