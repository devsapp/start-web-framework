/**
 * 回收站
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
	var that=$.extend(true,{}, admin_module);
	// 回收列表加载
	M.component.commonList(function(that,table_order){
		return {
        	ajax:{
        		dataSrc:function(result){
					var data=[];
					if(result.data){
						$.each(result.data, function(index, val) {
							var item=[
									M.component.checkall('item',val.id),
									val.title,
									val.updatetime,
									val.column_name,
									'<button type="submit" class="btn btn-sm btn-primary mr-1" data-url="'+val.recyclere_url+'">'+METLANG.recyclere+'</button>'
									+M.component.btn('del',{del_url:val.del_url})
								];
							data.push(item);
						});
					}
				    return data;
		        }
        	}
        };
	});
})();