/**
 * banner管理
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
	var that=$.extend(true,{}, admin_module),
		other_hash=that.hash=='banner/button_list'?'banner':'banner/button_list',
		bannerList=function(){
			M.component.commonList(function(thats,table_order){
				if(thats.hash=='banner'){
					// banner列表加载
					return {
			        	ajax:{
			        		dataSrc:function(result){
								var data=[];
								if(result.data){
									var edit_dataurl='banner/edit/?c=banner_admin&a=doeditor&id=',
										button_dataurl='banner/button_list/?c=banner_admin&a=doeditor&id=',
										del_url=that.own_name+'c=banner_admin&';
									$.each(result.data, function(index, val) {
										val.height=parseInt(val.height)?val.height:METLANG.adaptive;
										val.height_t=parseInt(val.height_t)?val.height_t:METLANG.adaptive;
										val.height_m=parseInt(val.height_m)?val.height_m:METLANG.adaptive;
										var item=[
												M.component.checkall('item',val.id)+M.component.formWidget('no_order_'+val.id,val.no_order),
												'<span title="'+val.modulename+'">'+val.valmname+'</span>',
												'<span><a href="'+val.img_path+'" target="_blank" title="'+METLANG.clickview+'">'+val.img_title+'</a></span>',
												M.component.formWidget('height_'+val.id,val.height,'text'),
												M.component.formWidget('height_t_'+val.id,val.height_t,'text'),
												M.component.formWidget('height_m_'+val.id,val.height_m,'text'),
												'<button type="button" class="btn btn-sm btn-primary mr-1" data-toggle="modal" data-target=".banner-details-modal" data-modal-title="'+METLANG.editor+'" data-modal-size="xl" data-modal-url="'+edit_dataurl+val.id+'" data-modal-fullheight="1" data-modal-tablerefresh="'+table_order+'">'+METLANG.editor+'</button>'
												+'<button type="button" class="btn btn-sm btn-primary mr-1" data-toggle="modal" data-target=".banner-button-modal" data-modal-title="'+METLANG.button+'" data-modal-size="100" data-modal-fullheight="1" data-modal-url="'+button_dataurl+val.id+'" data-modal-oktext data-modal-notext="'+METLANG.close+'">'+METLANG.button+'</button>'
												+M.component.btn('del',{del_url:del_url+val.del_url})
											];
										data.push(item);
									});
								}
							    return data;
					        }
			        	}
			        };
		        }else{
		        	// banner按钮列表加载
					return {
			        	ajax:{
			        		dataSrc:function(result){
								var data=[];
								if(result.data){
									var del_url=that.own_name+'c=banner_admin&a=doFlashButtonSave&submit_type=del&allid=',
										but_size_option={
											type:'text',
											class_name:'d-inline-block text-center banner-size',
											attr:'style="width:70px"',
											placeholder:METLANG.default_values
										};
									$.each(result.data, function(index, val) {
										val.height=parseInt(val.height)?val.height:METLANG.adaptive;
										val.height_t=parseInt(val.height_t)?val.height_t:METLANG.adaptive;
										val.height_m=parseInt(val.height_m)?val.height_m:METLANG.adaptive;
										val.but_sizes=val.but_size.split('x');
										var item=[
												M.component.checkall('item',val.id)+M.component.formWidget('no_order-'+val.id,val.no_order),
												M.component.formWidget('but_text-'+val.id,val.but_text,'text',1),
												M.component.formWidget('but_url-'+val.id,val.but_url,'text'),
												M.component.formWidget({
													name:'target-'+val.id,
													type:'select',
													value:val.target,
													data:[
														{name:METLANG.original_window,value:0},
														{name:METLANG.new_window,value:1},
													]
												}),
												'<div class="text-nowrap">'
													+M.component.formWidget($.extend(but_size_option,{
														name:'but_size_x',
														value:val.but_sizes[0]||''
													}))
													+'<span class="mx-1">x</span>'
													+M.component.formWidget($.extend(but_size_option,{
														name:'but_size_y',
														value:val.but_sizes[1]||''
													}))
													+M.component.formWidget('but_size-'+val.id,val.but_size)
												+'</div>',
												M.component.formWidget('but_color-'+val.id,val.but_color,'color'),
												M.component.formWidget('but_hover_color-'+val.id,val.but_hover_color,'color'),
												bannertextSize('but_text_size-'+val.id,val.but_text_size),
												M.component.formWidget('but_text_color-'+val.id,val.but_text_color,'color'),
												M.component.formWidget('but_text_hover_color-'+val.id,val.but_text_hover_color,'color'),
												M.component.formWidget({
													name:'is_mobile-'+val.id,
													type:'select',
													value:val.is_mobile,
													data:[
														{name:METLANG.funNav4,value:0},
														{name:METLANG.PC,value:1},
														{name:METLANG.mobile_terminal,value:2},
													]
												}),
												M.component.btn('del',{del_url:del_url+val.id})
											];
										data.push(item);
									});
								}
							    return data;
					        }
			        	}
			        };
		        }
			});
			var that1=$.extend(true,{}, admin_module);
			// banner列表排序
			metui.use('dragsort',function(){
		        dragsortFun[that1.obj.find('table tbody').attr('data-dragsort_order')]=function(wrapper,item){
		        	wrapper.find('tr [name*="no_order"]').each(function(index, el) {
		    			$(this).val($(this).parents('tr').index());
		        	});
		        };
		    });
		    if(that1.hash=='banner/button_list'){
		    	// 按钮文字大小
				function bannertextSize(name,value){
					return '<input type="text" name="'+name+'" value="'+(value||16)+'" data-plugin="select-fontsize" class="form-control">'
				}
				// 按钮大小切换
				that1.obj.on('change', 'table tbody .banner-size', function(event) {
					var $parent=$(this).parent().find('.banner-size');
					$(this).parent().find('[type="hidden"]').val($parent.eq(0).val()+'x'+$parent.eq(1).val());
				});
				// 添加按钮后的回调
				that1.obj.on('click','table [table-addlist]',function(event) {
					var $self=$(this);
					setTimeout(function(){
						var $new_tr=$self.parents('table').find('tbody tr:last-child');
						$new_tr.find('[name*="no_order-"]').val($new_tr.index());
					},0);
				});
		    }
		};
	bannerList();
	TEMPLOADFUNS[other_hash]=function(){
		bannerList();
	}
})();