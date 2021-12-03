/**
 * 内容列表功能
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
	// 产品、新闻、图片、下载模块列表加载
	M.component.contentList=function(){
		M.component.commonList(function(that,table_order){
			var edit_dataurl=that.module+'/edit/?c='+that.module+'_admin&a=doeditor&id=';
			return {
				ajax:{
	        		dataSrc:function(result){
						var data=[];
						if(result.data){
							$.each(result.data, function(index, val) {
								var item=[],
									status='';
								if(parseInt(val.com_ok)) status+='<span class="badge font-weight-normal mx-1 badge-success">'+METLANG.recom+'</span>';
								if(parseInt(val.top_ok)) status+='<span class="badge font-weight-normal mx-1 badge-info">'+METLANG.top+'</span>';
								if(!parseInt(val.displaytype)) status+='<span class="badge font-weight-normal mx-1 badge-secondary">'+METLANG.displaytype2+'</span>';
								if(parseInt(val.addtype)) status+='<span class="badge font-weight-normal mx-1 badge-secondary">'+METLANG.timedrelease+'</span>';
								item.push(M.component.checkall('item',val.id));
								if(that.module=='img'||that.module=='product'){
									item.push('<a href="'+val.url+'" target="_blank" class="media align-items-center"><img src="'+val.imgurl+'" width="100" class="mr-2"/><div class="media-body">'+val.title+'</div></a>');
								}else{
									item.push('<a href="'+val.url+'" target="_blank">'+val.title+'</a>');
								}
								item.push(val.hits);
								item.push(val.updatetime);
								item.push(status);
								item.push(M.component.formWidget('no_order-'+val.id,val.no_order,'text',1,0,'text-center'));
								item.push('<button type="button" class="btn btn-sm btn-primary mr-1" data-toggle="modal" data-target=".'+that.module+'-details-modal" data-modal-title="'+METLANG.editor+'" data-modal-size="xl" data-modal-url="'+edit_dataurl+val.id+'" data-modal-fullheight="1">'+METLANG.editor+'</button>'
									+M.component.btn('del_item',{del_url:val.del_url}));
								data.push(item);
							});
						}
					    return data;
			        }
	        	},
	        	ordering:true,
	        	order:[],
	        	columnDefs:[
	        		{targets:[0,1,4,5,6],orderable:false}
	        	]
			};
		});
	};
	// 内容列表删除-弹框参数
	M.component.webuiPopoverFun['table-del']=function(class_name){
        var del_url=$('.'+class_name+' [data-plugin="webuiPopover"]').data('del_url'),
        	option={
	            placement:'left',
	            animation:'pop',
	            content:'<button type="button" class="btn btn-sm mr-1 btn-primary btn-table-del-recycle" table-delete data-webuipopover-hide '+(del_url?'data-url="'+del_url+'&recycle=1"':'data-submit_type="recycle"')+'>'+METLANG.putIntoRecycle+'</button>'
	                    +'<button type="button" class="btn btn-sm mr-1 btn-primary btn-table-del" table-delete data-webuipopover-hide '+(del_url?'data-url="'+del_url+'"':'')+'>'+METLANG.thoroughlyDeleting+'</button>'
	                    +'<button type="button" class="btn btn-sm btn-default" data-webuipopover-hide>'+METLANG.cancel+'</button>',
	            container:'.'+class_name,
	            template: '<div class="webui-popover"><div class="webui-arrow"></div><div class="webui-popover-inner"><a href="#" class="close"></a><h3 class="webui-popover-title"></h3><div class="webui-popover-content text-nowrap"><i class="icon-refresh"></i> <p>&nbsp;</p></div></div></div>',
	        };
        return option;
	}
	var content_show_item='.content-show .content-show-item';
	// 内容列表-栏目选择后刷新添加按钮地址
	$(document).on('change', content_show_item+' .column-select[data-plugin="select-linkage"] select', function(event) {
		var $parent=$(this).parents('.column-select'),
			class1=$parent.find('[name="class1"]').val()||'',
			class2=$parent.find('[name="class2"]').val()||'',
			class3=$parent.find('[name="class3"]').val()||'',
			$btn_content_list_add=$(this).parents('.content-show-item').find('.btn-content-list-add'),
			url=$btn_content_list_add.attr('data-modal-url').split('class1=')[0]+'class1='+class1+'&class2='+class2+'&class3='+class3;
		$btn_content_list_add.attr({'data-modal-url':url});
	});
	// 模块列表复制下拉列表更新
	$(document).on('click', '.content-show .content-show-item .contentlist-copy-langlist a[data-val]', function(event) {
		var $contentlist_copy=$(this).parents('table').find('.contentlist-copy'),
			tolang=$(this).data('val');
		metui.ajax({
			url:M.url.admin+'?n=manage&index&a=doGetLangColumn',
			data:{tolang:tolang,module:$(this).parents('table').find('[name="module"]').val()}
		},function(result){
			var html='',
				columnList=function(json,p_key,c_key,level,pre_value){
					var pre_value=pre_value||'';
					level++;
					$.each(json, function(index, val) {
						if(val[p_key].value!=""){
							var value=pre_value?(pre_value+'-'+val[p_key].value):val[p_key].value;
							if(val[c_key]){
								html+='<div class="dropdown dropright dropdown-submenu">'
										+'<a href="javascript:;" class="dropdown-item px-3 dropdown-toggle" onClick="dropdownMenuPosition(this)" data-toggle="dropdown">'+val[p_key].name+'</a>'
										+'<div class="dropdown-menu">';
								columnList(val[c_key],level==1?'n':'s',level==1?'a':'ss',level,value);
								html+='</div></div>';
							}else{
								html+='<a href="javascript:;" class="dropdown-item px-3" table-delete data-submit_type="copy_tolang" data-val="'+value+'">'+val[p_key].name+'</a>';
							}
						}
					});
				};
			columnList(result.citylist,'p','c',0);
			$contentlist_copy.html(html).parents('.dropup').removeClass('hide').find('>.dropdown-toggle').click();
			$contentlist_copy.parents('table').find('[name="tolang"]').val(tolang);
		});
	});
	// 选择复制栏目列表失焦后隐藏
	$(document).on('blur', content_show_item+' table .contentlist-copy-list a,'+content_show_item+' table .contentlist-copy-list button', function(event) {
		var $list=$(this).parents('.contentlist-copy-list').find('.contentlist-copy');
		setTimeout(function(){
			if($list.is(':hidden')) $list.parent().addClass('hide');
		},100);
	});
	// 内容列表-移动、复制
	$(document).on('click', content_show_item+' table .contentlist-move a[data-val],'+content_show_item+' table .contentlist-copy a[data-val]', function(event) {
		var $form=$(this).parents('form'),
			value=$(this).data('val');
		if(!$form.find('[type="hidden"][name="columnid"]').length) $form.append(M.component.formWidget('columnid',''));
		$form.find('[type="hidden"][name="columnid"]').val(value);
	});
	// 内容详情/添加弹框-内容加载完后的回调
	M.component.modal_call_status.content_list=[];
	M.component.modal_options['.about-details-modal']=
	M.component.modal_options['.news-details-modal']=
	M.component.modal_options['.product-details-modal']=
	M.component.modal_options['.img-details-modal']=
	M.component.modal_options['.download-details-modal']=
	M.component.modal_options['.job-position-details-modal']=
	M.component.modal_options['.news-add-modal']=
	M.component.modal_options['.product-add-modal']=
	M.component.modal_options['.img-add-modal']=
	M.component.modal_options['.download-add-modal']=
	M.component.modal_options['.job-add-modal']={
		modalOtherclass:'content-details-modal',
		callback:function(key){
			var $form=$(key+' .modal-body form'),
				validate_order=$form.attr('data-validate_order');
			$form.find('.btn-content-para-refresh').click();
			productTab($form);
			if(!M.component.modal_call_status.content_list[validate_order]){
				M.component.modal_call_status.content_list[validate_order]=1;
				// 弹框内表单提交后的回调
				metui.use('form',function(){
					formSaveCallback(validate_order,{
				        true_fun: function(result) {
				        	// 静态页面更新
				        	if(result.html_res){
				        		var $modal_body='';
					        	$('.btn-admin-common-modal,.btn-pageset-common-modal').attr({'data-target':'.html-update-modal'}).click();
					        	setTimeout(function(){
					        		$modal_body=$('.html-update-modal .modal-body');
					        		$modal_body.find('.html-update-list').html('');
					        	},0)
					            metui.ajax({
					            	url:result.html_res
					            },function(result1){
					            	var $html_update_list=$modal_body.find('.html-update-list'),
					            		length=result1.data.length,
					            		key=0;
					            	result1.data.map(val => {
					            		metui.ajax({
											url: val.url
										}, function(res) {
											key++;
											$html_update_list.append(`<p>${res.suc?val.suc:val.fail}</p>`).find('p:last-child span').html((key)+'/'+length);
											var scrolltop=$html_update_list.height()-$modal_body.height();
											scrolltop>0 && $modal_body.stop().animate({scrollTop:scrolltop},300);
											key==length && alertify.success(METLANG.html_createend_v6) && setTimeout(function(){$('.html-update-modal').modal('hide')},500);
										});
					            	});
					            })
				        	}
				        	if(key=='.about-details-modal') return;
				        	// 添加内容后跳转到对应内容列表
				        	var $this_form=$(key+' .modal-body form'),
								module=$this_form.attr('data-validate_order').split('-')[0].substr(1),
								class1=parseInt($this_form.find('[name="class1"]').val()),
								class2=parseInt($this_form.find('[name="class2"]').val())||'',
								class3=parseInt($this_form.find('[name="class3"]').val())||'';
							var info=module+'|'+class1+'|'+class2+'|'+class3,
								data_path=module=='job'?module+'/'+class1+'|'+class2+'|'+class3:module+'/list',
								$content_show_item=$((M.is_admin?'.metadmin-content[data-page="manage"]':'.pageset-nav-modal .nav-modal-item[data-path="manage"]')+':visible .content-show-item[data-path="'+data_path+'"]'),
								$column_select=$content_show_item.find('.column-select')
								table_select_class1=parseInt($column_select.find('[name="class1"]').val())||'',
								table_select_class2=parseInt($column_select.find('[name="class2"]').val())||'',
								table_select_class3=parseInt($column_select.find('[name="class3"]').val())||'';
							// 传统后台已存在显示的目标模块、可视化内容管理页面打开的情况下已存在显示的目标模块
							if((M.is_admin || $('.pageset-nav-modal.show').length) && $content_show_item.length){
								var reload=(table_select_class1!=''?table_select_class1!=class1:0) || (table_select_class2!=''?table_select_class2!=class2:0) || (table_select_class3!=''?table_select_class3!=class3:0);
								!reload && (reload=key.indexOf('add')>0);
								if(reload){// 目标模块所选栏目和当前栏目不一致时，列表更新到目标栏目第一页
									if($('#content-view-column').is(':visible')){// 按栏目显示的模式
										$('#content-view-column .column-view-list li a[data-info="'+info+'"]').click();
									}else{// 按模块显示的模式，只切换栏目id
										$content_show_item.tabelsearchReset(function(){
											$column_select.find('[name="class1"]').val()!=class1 && $column_select.find('[name="class1"]').val(class1).change();
											$column_select.find('[name="class2"]').val()!=class2 && $column_select.find('[name="class2"]').val(class2).change();
										});
										$column_select.find('[name="class3"]').val()!=class3 && $column_select.find('[name="class3"]').val(class3).change();
									}
	        					}else{// 目标模块所选栏目和当前栏目一致时，列表更新当前页
	        						var $table = $content_show_item.find('.dataTable:eq(0)'),
	        							datatable_order=$table.attr('data-datatable_order');
                                    $table.length && datatable[datatable_order].row().draw(false);
	        					}
	        				}
				        }
				    });
				});
			}
		}
	};
	// 内容详情/添加弹框-关闭后
	$(document).on('hidden.bs.modal','.content-details-modal',function(){
		$('.modal-body .modal-html',this).html('');
	});
	// 静态页面生成弹框
	M.component.modal_options['.html-update-modal']={
		modalTitle: METLANG.indexhtm,
		modalBody:'<div class="html-update-list"></div>',
		modalRefresh:0,
		modalFullheight: 1,
		modalFooterok:0
	};
	// 内容详情页-参数刷新
	$(document).on('click', '.btn-content-para-refresh', function(event) {
		var $self=$(this),
			$paralist=$(this).parents('form').find('.content-details-paralist'),
			para_type={
				1:'text',
				2:'select',
				3:'textarea',
				4:'checkbox',
				5:'file',
				6:'radio',
				10:'text'
			};
		$(this).attr({disabled:''}).find('i').addClass('fa-spin');
		metui.ajax({
			url: $paralist.attr('data-url')
		},function(result){
			metAjaxFun({result:result,true_fun:function(){
				var html='';
				$.each(result.data, function(index, val) {
					val.value=val.value||'';
					val.type=parseInt(val.type);
					var name='para-'+val.id,
						option={
							type:para_type[val.type],
							name:name,
							value:val.value,
							label:val.name,
							dl:1
						};
					if($.inArray(val.type, [2,4,6])>=0){
						option.data=[];
						val.list && $.each(val.list, function(index1, val1) {
							option.data.push({
								name:val1.value,
								value:val1.id
							});
							val.type==6 && option.value=='' && (option.value=val1.id);
						});
					}
					val.type==5 && (option.accept='file');
					html+=M.component.formWidget(option);
				});
				if(!html) html='<dl><dt>'+METLANG.csvnodata+'</dt></dl>';
				$paralist.html(html).metCommon();
				$self.removeAttr('disabled').find('i').removeClass('fa-spin');
			}});
		});
	});
	// 内容详情页-自动获取添加时间
	$(document).on('click', 'form [type="radio"][name="addtype"]', function(event) {
		var $addtime=$(this).parents('.form-group').find('[name="addtime"]');
		parseInt($(this).val())==2?$addtime.focus():$addtime.val('');
	})
    // 内容详情页-栏目改变后，参数也改变
    $(document).on('change','.modal .content-details-column select',function(){
    	var $form=$(this).parents('form').eq(0);
    		$paralist=$form.find('.content-details-paralist'),
    		$column=$(this).parents('.content-details-column');
		// 产品栏目数据更新
		if($(this).parents('.product-details-modal,.product-add-modal').length){
			var classother='';
	    	$.each($(this).val(), function(index, val) {
	    		!index && (classother+='|');
	    		classother+='-'+val+'-|';
	    		if(!index){
	    			val=val.split('-');
	    			$column.find('[name="class1"]').val(val[0]);
	    			$column.find('[name="class2"]').val(val[1]);
	    			$column.find('[name="class3"]').val(val[2]);
	    		}
	    	});
	    	$(this).val().length==1 && (classother='');
	    	$column.find('[name="classother"]').val(classother);
	    	// 更新选项卡显示
	    	productTab($form);
		}
		// 更新参数
		if($paralist.length){
			var class1=class2=class3='',
				paralist_url=$paralist.attr('data-url').split('&class1')[0];
	    	setTimeout(function(){
				class1=parseInt($column.find('[name="class1"]').val())||'';
				class2=parseInt($column.find('[name="class2"]').val())||'';
				class3=parseInt($column.find('[name="class3"]').val())||'';
				$paralist.attr({'data-url':paralist_url+'&class1='+class1+'&class2='+class2+'&class3='+class3});
				$form.find('.btn-content-para-refresh').click();
				// 更新选项卡设置按钮地址
				var $btn_product_details_tabset=$form.find('button[data-target=".product-details-tabset-modal"]');
				if($btn_product_details_tabset.length){
					var classnow=class3?class3:(class2?class2:class1);
					$btn_product_details_tabset.attr({'data-modal-url':$btn_product_details_tabset.attr('data-modal-url').split('&classnow=')[0]+'&classnow='+classnow});
				}
	    	},0);
		}
    });
    // 产品详情页tab选项卡信息更新
    function productTab(form){
    	var $navtab=form.find('.product-details-navtab'),
    		$content=form.find('.product-details-content');
		if(!$navtab.length) return;
    	metui.ajax({
			url: $navtab.data('url'),
			data: {
				class1: form.find('[name="class1"]').val(),
				class2: form.find('[name="class2"]').val(),
				class3: form.find('[name="class3"]').val()
			}
		},function(result){
			result.tab_name=result.tab_name.split('|');
			result.tab_num=parseInt(result.tab_num);
			$navtab.find('a').hide().each(function(index, el) {
				$(this).html(result.tab_name[index]);
			});
			$navtab.find('a:lt('+result.tab_num+')').show();
			$content.find('.tab-pane').removeClass('show active').parent().removeClass('hide');
			$navtab.find('a:eq(0)').click();
			$content.find('.tab-pane:eq(0)').addClass('show active');
		});
    }
    // 产品详情页选项卡设置框回调
    M.component.modal_options['.product-details-tabset-modal']={
		callback:function(key){
			metui.use('form',function(){
				setTimeout(function(){
					formSaveCallback($(key+' .modal-body form').attr('data-validate_order'),{
				        true_fun: function(result) {
				        	productTab($('.product-details-modal,.product-add-modal').find('form'));
			        	}
		        	});
	        	},100);
        	});
		}
	};
})();
// 下载模块文件上传后文件大小值更新
function downloadFilesize(obj){
	var $file=obj.parents('.file-input').find('.file-preview-thumbnails .file-preview-frame:last-child .file-preview-view');
	obj.parents('form').find('[name="filesize"]').val($file.attr('data-size')||'');
	obj.parents('form').find('[name="downloadurl"]').val($file.attr('href'));
}