/**
 * 招聘模块
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
	var that=$.extend(true,{}, admin_module);
		datatableHtml=function(thats,table_order){// 职位、简历列表渲染
			if(thats.hash=='job/position_list'){
		        return {
		        	ajax:{
		        		dataSrc:function(result){
							var data=[],
								edit_dataurl=thats.module+'/position_edit/?c='+thats.module+'_admin&a=doeditor&class1='+thats.data.class1+'&class2='+(thats.data.class2||'')+'&class3='+(thats.data.class3||'')+'&id=';
							result.data && $.each(result.data, function(index, val) {
								var status='';
								if(parseInt(val.top_ok)) status+='<span class="badge font-weight-normal mx-1 badge-success">'+METLANG.top+'</span>';
								if(!parseInt(val.displaytype)) status+='<span class="badge font-weight-normal mx-1 badge-secondary">'+METLANG.displaytype2+'</span>';
								val.count=parseInt(val.count);
								!val.count && (val.count=METLANG.josAlways);
								var item=[
										M.component.checkall('item',val.id),
										'<span>'+val.position+'</span>',
										'<span>'+val.count+'</span>',
										status,
										'<span>'+val.useful_life+'</span>',
										'<span>'+val.updatetime+'</span>',
										'<span>'+val.access.name+'</span>',
										M.component.formWidget('no_order-'+val.id,val.no_order,'text',1,0,'text-center'),
										'<button type="button" class="btn btn-sm btn-primary mr-1" data-toggle="modal" data-target=".'+thats.module+'-position-details-modal" data-modal-title="'+METLANG.jobposition+'" data-modal-size="lg" data-modal-url="'+edit_dataurl+val.id+'" data-modal-fullheight="1">'+METLANG.editor+'</button>'
										+'<button type="button" class="btn btn-sm btn-primary mr-1 btn-view-cv" data-id="'+val.id+'">'+METLANG.memberCV+'</button>'
										+M.component.btn('del',{del_url:val.delete})
									];
								data.push(item);
							});
						    return data;
				        }
		        	}
		        };
			}else{
				getPosition(thats.obj.find('form'));
				return {
					ajax:{
		        		dataSrc:function(result){
							var data=[],
								edit_dataurl=thats.module+'/edit/?c='+thats.module+'_manage&a=doview&class1='+thats.data.class1+'&class2='+thats.data.class2+'&class3='+thats.data.class3+'&id=';
							result.data && $.each(result.data, function(index, val) {
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
										val.position,
										'<span class="badge font-weight-normal py-1 badge-'+(val.readok?'secondary':'warning')+'">'+METLANG[val.readok?'read':'unread']+'</span>'
									];
								if(para_list.length) item=item.concat(para_list);
								item=item.concat([
									val.addtime||'',
									'<button type="button" class="btn btn-sm btn-primary mr-1" data-toggle="modal" data-target=".'+thats.module+'-details-modal" data-modal-title="'+METLANG.memberCV+'" data-modal-size="lg" data-modal-url="'+edit_dataurl+val.id+'" data-modal-fullheight="1" data-modal-tablerefresh="'+table_order+'" data-modal-tablerefresh-type="'+(val.readok.val?0:1)+'" data-modal-oktext="" data-modal-notext="'+METLANG.close+'">'+METLANG.View+'</button>'
									+'<a href="'+val.export_url+'" class="btn btn-primary btn-sm mr-1" target="_blank">'+METLANG.cv_export+'</a>'
									+M.component.btn('del',{del_url:val.del_url})
								]);
								data.push(item);
							});
						    return data;
		        		}
	        		}
				};
			}
		};
	// 职位列表
    M.component.commonList(datatableHtml);
    // 简历列表
	var hash=that.hash=='job/position_list'?'job/list':'job/position_list';
	TEMPLOADFUNS[hash]=function(){
		M.component.commonList(datatableHtml);
	}
	// 简历列表获取职位
	function getPosition(form){
		metui.ajax({
			url: that.own_name+'c=job_manage&a=doget_position_list&class1='+form.find('[name="class1"]').val()+'&class2='+(form.find('[name="class2"]').val()||'')+'&class3='+(form.find('[name="class3"]').val()||''),
			success:function(result){
				if(result.length){
					var html='';
					$.each(result, function(index, val) {
						html+='<option value="'+val.jobid+'">'+val.position+'</option>';
					});
					setTimeout(function(){
						var tab_pane_id=form.parents('.tab-pane').eq(0).attr('id'),
							$tab=$('.content-show-item[data-path^="job/"] .met-headtab a[href="#'+tab_pane_id+'"]'),
							url=$tab.attr('data-url').split('&jobid')[0],
							jobid=$tab.attr('data-url').split('&jobid=')[1];
						form.find('select[name="jobid"]').html(html).val(jobid);
						if($tab.attr('data-jobidchange')){
							form.find('select[name="jobid"]').change();
							$tab.removeAttr('data-jobidchange');
						}
						$tab.attr({'data-url':url+'&jobid='});
					},200);
				}
			}
		});
	}
	// 查看简历
	$(document).on('click', '[id^="job-position-list-"] tbody .btn-view-cv', function(event) {
		var id=$(this).data('id'),
			$tab=$(this).parents('.content-show-item').find('.met-headtab a:nth-child(2)'),
			url=$tab.attr('data-url').split('&jobid')[0],
			$tab_pane=$($tab.attr('href'));
		if(!$tab_pane.attr('data-loaded')) $tab.attr({'data-jobidchange':1});
		$tab.attr({'data-url':url+'&jobid='+id}).click();
		$tab_pane.find('form [name="jobid"]').val(id);
	});
	// 查看所有简历
	$(document).on('click', '.content-show-item[data-path^="job/"] .met-headtab a:nth-child(2)', function(event) {
		var $form=$($(this).attr('href')).find('form');
		$form.length && getPosition($form);
	});
	// 简历列表下方导出按钮链接更新
    $(document).on('change','.select-job-export',function(event) {
    	var $btn_job_export=$(this).parents('table').find('.btn-job-export'),
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
    	$btn_job_export.attr({href:$btn_job_export.attr('data-href')+url});
    });
    // 简历列表下方导出按钮点击判断
    $(document).on('click','.btn-job-export',function(event) {
    	var allid=$(this).attr('href').indexOf('&allid=')>0;
    	if(allid && !$(this).parents('table').find('.checkall-item:checked').length){
    		event.preventDefault();
    		alertify.error(METLANG.jslang3||METLANG.least_one_item);
    	}
    });
    // 简历列表筛选参数后更新导出按钮链接
    $(document).on('change','[data-table-search*="#job-list-"]:not([type="hidden"]):not([hidden]),table[id*="job-list-"] [data-table-search]:not([type="hidden"]):not([hidden]),table[id*="job-list-"] .checkall-item',function(event) {
    	$(this).parents('.tab-pane').find('.select-job-export').change();
    });
})();