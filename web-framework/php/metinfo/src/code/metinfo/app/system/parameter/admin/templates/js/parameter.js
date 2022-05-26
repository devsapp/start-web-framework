/**
 * 参数设置
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
	var parameter_list='.parameter-list';
	// 参数列表
	M.component.commonList(function(that){
		$.inArray(that.data.module, ['message','feedback','job'])>=0 && metui.use('form',function(){
			formSaveCallback(that.obj.find('form').attr('data-validate_order'),{
				true_fun:function(){
					$(that.obj.parents('.content-show-item').find('.met-headtab a[data-url^="'+that.data.module+'/set/"]').attr('href')).removeAttr('data-loaded');
				}
			});
		});
		return {
        	ajax:{
        		dataSrc:function(result){
					var data=[];
					if(result.data){
						$.each(result.data, function(index, val) {
							var options_show=$.inArray(parseInt(val.type), [2,4,6])>=0?1:0,
								item=[
									M.component.checkall('item',val.id)+M.component.formWidget('no_order-'+val.id,val.no_order),
									M.component.formWidget('name-'+val.id,val.name,'text',1),
								];
								if($.inArray(that.data.module, ['product','img','download'])<0){
									item=item.concat([M.component.formWidget('description-'+val.id,val.description,'text')]);
								}
								item=item.concat([
									M.component.formWidget({
										name:'type-'+val.id,
										type:'select',
										value:val.type,
										data:val.type_options,
										data_value_key:'val'
									}),
									(that.data.module=='message'?'':M.component.formWidget({
										name:'class-'+val.id,
										type:'select',
										value:val.class,
										data:val.class_options,
										data_value_key:'val'
									})),
									M.component.formWidget({
										name:'access-'+val.id,
										type:'select',
										value:val.access,
										data:val.access_options,
										data_value_key:'val'
									})
								]);
								that.data.module=='message' && item.splice(4, 1);
								if($.inArray(that.data.module, ['product','img','download'])<0) item=item.concat([M.component.formWidget({
									name:'wr_ok-'+val.id,
									type:'select',
									value:val.wr_ok,
									data:[{name:METLANG.yes,value:1},{name:METLANG.no,value:0}]
								})]);
								item=item.concat([
									'<button type="button" class="btn btn-sm btn-primary mr-1 btn-parameter-setoptions" data-toggle="modal" data-target=".parameter-options-modal" data-modal-title="'+METLANG.listTitle+'" '+(options_show?'':'hidden')+'>'+METLANG.listTitle+'</button>'
									+M.component.formWidget({
										type:'textarea_hidden',
										name:'options-'+val.id,
										value:val.options||'{}'
									})
									+(val.related_columns?M.component.formWidget({
										name:'related-'+val.id,
										type:'select',
										value:val.related,
										data_value_key:'val',
										data:val.related_columns,
										select_option:function(opttion_key,opttion_value){
											var html=opttion_value.classtype>1?'-':'';
											if(opttion_value.classtype==3) html+='-';
											return html+=opttion_value.name;
										},
										class_name:'form-control-sm'
									}):'')
								]);
							data.push(item);
						});
					}
				    return data;
		        }
        	}
        };
	});
    // 拖拽排序
    metui.use('dragsort',function(){
        dragsortFun[parameter_list]=function(wrapper){
        	wrapper.find('tr [name*="no_order-"]').each(function(index, el) {
    			$(this).val($(this).parents('tr').index());
        	});
        };
        dragsortFun['#parameter-options-list']=function(wrapper){
	    	wrapper.find('[name="order"]').each(function(index, el) {
				$(this).val($(this).parents('tr').index());
	    	});
	    };
    });
    // 参数类型切换
    $(document).on('change', parameter_list+' tbody [name*="type-"]', function(event) {
    	var value=parseInt($(this).val()),
    		options_show=$.inArray(value, [2,4,6])>=0?1:0,
			$tr=$(this).parents('tr');
    	if(options_show){
    		$tr.find('.btn-parameter-setoptions').removeAttr('hidden');
    	}else{
    		$tr.find('.btn-parameter-setoptions').attr({hidden:''});
    	}
    });
    // 添加参数
    $(document).on('click', parameter_list+' [table-addlist]',function(event) {
    	var $self=$(this);
    	setTimeout(function(){
    		var $new_tr=$self.parents('table').find('tbody tr:last-child'),
    			$options=$new_tr.find('[name*="options-"]');
    		$new_tr.find('[name*="no_order-"]').val($new_tr.index());
    		$options.after('<textarea name="'+$options.attr('name')+'" hidden></textarea>');
    	},0)
    });
    // 参数属性框-html
    var parameter_options_tr=function(data){
    		var data=$.extend({
    				id:'',
    				order:'',
    				value:''
    			},data);
	    	return '<tr>'
	    				+'<td class="text-center">'+M.component.checkall('item',data.id)+M.component.formWidget('order',data.order)+'</td>'
	    				+'<td>'+M.component.formWidget('value',data.value,'text',1)+'</td>'
	    				+'<td><button type="button" class="btn btn-sm btn-default" table-del>'+METLANG.delete+'</button></td>'
	    			+'</tr>'
	    };
    M.component.modal_options['.parameter-options-modal']={
    	modalBody:'<form action="javascript:;" class="form-inline">'
    		+M.component.formWidget('para_id')
    		+M.component.formWidget('table_order')
    		+'<table class="table table-hover dataTable w-100" id="parameter-options-list" data-plugin="checkAll">'
	    	+'<thead>'
	    		+'<tr>'
		    		+M.component.checkall()
		    		+'<th>'+METLANG.parametervalueinfo+'<span class="text-help font-weight-normal ml-2 text-danger">'+METLANG.admin_content_list1+'</span></th>'
		    		+'<th width="80">'+METLANG.operate+'</th>'
	    		+'</tr>'
	    	+'</thead>'
	    	+'<tbody data-plugin="dragsort" data-dragsort_order="#parameter-options-list">'+M.component.loader({type:'table',colspan:3})+'</tbody>'
	    	+'<tfoot>'
	    		+'<tr>'
	    			+M.component.checkall()
	    			+'<th colspan="2">'
	    				+'<button type="submit" class="btn btn-default hide"></button>'
	    				+'<button type="button" class="btn btn-default" table-del>'+METLANG.delete+'</button>'
	    				+'<button type="button" class="btn btn-primary ml-1" table-addlist data-nocancel="1">'+METLANG.add+'</button>'
	    				+'<textarea table-addlist-data hidden>'
	    					+parameter_options_tr()
	    				+'</textarea>'
	    			+'</th>'
	    		+'</tr>'
	    	+'</tfoot>'
    	+'</table></form>',
    	modalRefresh:'one'
    };
    // 参数属性框-弹出回调
    $(document).on('click', parameter_list+' .btn-parameter-setoptions', function(event) {
    	var table_order=$(this).parents('table').attr('data-datatable_order'),
    		id=$(this).parents('tr').find('[name="id"]').val(),
    		options=$(this).next('[name*="options-"]').val(),
    		is_empty=0,
    		html='';
		if(options){
			options=JSON.parse(options);
			if(!options.length) is_empty=1;
	    	$.each(options, function(index, val) {
	    		html+=parameter_options_tr(val);
	    	});
		}else{
			is_empty=1;
		}
		if(is_empty) html='<tr><th colspan="3" class="text-center dataTables_empty">'+METLANG.csvnodata+'</th></tr>';
    	setTimeout(function(){
    		var $modal=$('.parameter-options-modal');
    		$modal.find('[name="para_id"]').val(id);
    		$modal.find('[name="table_order"]').val(table_order);
    		$('#parameter-options-list tbody').html(html);
    		$('#parameter-options-list').find('.checkall-all').prop('checked', false);
	    	$modal.find('form').attr('data-validate_order') && $modal.find('form').metFormAddField();
    	},0);
    });
    // 参数属性框-添加
    $(document).on('click', '#parameter-options-list [table-addlist]', function(event) {
    	setTimeout(function(){
    		var $new_tr=$('#parameter-options-list').find('tbody tr:last-child');
    		$new_tr.find('[name="order"]').val($new_tr.index());
    	},0);
    });
    // 参数属性框-保存
    $(document).on('click', '.parameter-options-modal [data-ok]', function(event) {
    	var $modal=$('.parameter-options-modal');
    	if(!$modal.find('.has-danger').length){
    		var options=[];
    		$('#parameter-options-list tbody .checkall-item').parents('tr').each(function(index, el) {
				var info={};
				$('[name]',this).each(function(index, el) {
					info[$(this).attr('name')]=$(this).val();
				});
				options.push(info);
    		});
    		var $table=$(parameter_list+'[data-datatable_order="'+$modal.find('[name="table_order"]').val()+'"]');
    		$table.find('tbody [name="options-'+$modal.find('[name="para_id"]').val()+'"]').val(JSON.stringify(options)).change();
    		$table.find('tfoot '+M.component.submit_selctor).click();
    		$modal.modal('hide');
    	}
    });
})();