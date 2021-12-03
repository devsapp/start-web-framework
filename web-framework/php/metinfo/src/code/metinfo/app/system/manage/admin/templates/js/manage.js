/**
 * 内容模块
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
	// 内容管理
	var that=$.extend(true,{},admin_module),
		obj=that.obj,
		$content_btn_group=obj.find('.content-btn-group'),
		$content_show=obj.find('.content-show'),
		$column_view=obj.find('.column-view'),
		$column_view_wrapper=obj.find('.column-view-wrapper'),
		$default_show_column=obj.find('select[name="default_show_column"]'),
		// 栏目/模块列表循环
		columnList=function(data,sub,view_type){
			var html='',
				default_show_column_html=sub?'':'<option value="">'+METLANG.set_default_section+'</option>',
				sub=sub||0,
				tagname=sub?'div':'li';
			sub++;
			$.each(data, function(index, val) {
				var info='';
				if(val.url){
					if(val.url.substr(0,2)=='#/'){
						info=val.url;
					}else{
						var module=val.url.match(/n=(\w+)/),
							class1=val.url.match(/class1=(\w+)/),
							class2=val.url.match(/class2=(\w+)/),
							class3=val.url.match(/class3=(\w+)/);
						module=module?module[1]:'';
						class1=class1?class1[1]:'';
						class2=class2?class2[1]:'';
						class3=class3?class3[1]:'';
						info=module+'|'+class1+'|'+class2+'|'+class3;
					}
				}
				html+='<'+tagname+' class="'+(sub==1?'py-2 d-block':'font-size-12')+'">'
					+'<a href="'+(!M.is_admin&&info.substr(0,2)=='#/'?info:'javascript:;')+'" '+(info?'data-info="'+info+'"':'')+' data-classtype="'+val.classtype+'" class="list-group-item d-flex align-items-center justify-content-between py-2 pr-2 pl-'+(1+sub)+'">'
						+'<span class="'+(sub==3?'pl-2':'')+' pr-1">'+val.name+'</span>'
						+(val.classtype!=3?'<span class="btn-column-slide px-1 '+(val.subcolumn?'':'invisible')+'"><i class="fa-caret-down font-size-16 transition500"></i></span>':'')
					+'</a>';
				info && !view_type && (default_show_column_html+='<option value="'+info+'">'+(sub>1?(sub==2?'-':'--'):'')+val.name+'</option>');
				if(val.subcolumn){
					var sub_html=columnList(val.subcolumn,sub,view_type);
					html+='<div class="subcolumn">'+sub_html.html+'</div>';
					!view_type && (default_show_column_html+=sub_html.default_show_column_html);
				}
				html+='</'+tagname+'>';
			});
			sub == 1 && ($default_show_column.html(view_type ? '' : default_show_column_html).find('option[value="' + (getCookie('manage_default_show_column') || '') + '"]').attr({'checked':''}), view_type ? $default_show_column.addClass('hide').parents('.met-select').addClass('hide') : $default_show_column.removeClass('hide').parents('.met-select').removeClass('hide'));
			return sub>1?{html:html,default_show_column_html:default_show_column_html}:html;
		};
	// 栏目/模块列表渲染
	var columnView=function(view_type){
			var $btn_pageset_nav_manage=$('.pageset-head-nav [data-url="manage"]'),
				location_view_type=M.is_admin?getQueryString('view_type'):'';
				view_type=location_view_type||view_type||$content_btn_group.find('a.active').data('view_type'),
				head_tab_active=M.is_admin?String(getQueryString('head_tab_active')):$btn_pageset_nav_manage.attr('data-head_tab_active'),
				$list=$('#content-view-'+view_type+' .column-view-list');
			obj.find('.column-search').val('');
			view_type=view_type=='module'?2:'';
			$.ajax({
				url: that.own_name+'c=index&a=doGetContentList',
				type: 'POST',
				dataType: 'json',
				data: {content_type: view_type},
				success:function(result){
					if(parseInt(result.status)){
						var html=columnList(result.data.list,'',view_type);
						$list.html(html);
						$content_show.find('.content-show-item').hide();
						$content_show.find('.content-show-item[data-path^="about"]').remove();
						$content_show.find('.content-show-item.tips').show();
						var info=M.is_admin?getQueryString(['module','class1','class2','class3']):{
								module:$btn_pageset_nav_manage.attr('data-module')||'',
								class1:$btn_pageset_nav_manage.attr('data-class1')||'',
								class2:$btn_pageset_nav_manage.attr('data-class2')||'',
								class3:$btn_pageset_nav_manage.attr('data-class3')||'',
							},
							info_str=info.module+'|'+info.class1+'|'+info.class2+'|'+info.class3;
						var $info=$list.find('.list-group-item[data-info="'+info_str+'"]');
						!$info.length && info.module && ($info=$list.find('.list-group-item[data-info*="'+info.module+'|"]').eq(0));
						if(!$info.length && !view_type){
							var default_show_column=getCookie('manage_default_show_column')||'';
							default_show_column && ($info=$list.find('.list-group-item[data-info="'+default_show_column+'"]'));
						}
						if(head_tab_active) $info.attr({'data-head_tab_active':head_tab_active});
						$info.click();
					}
				}
			});
			if(location_view_type){
				$content_btn_group.find('a[data-view_type="'+location_view_type+'"]:not(.active)').addClass('active').siblings().removeClass('active');
				$('#content-view-'+location_view_type+':not(.active)').addClass('active show').siblings().removeClass('active show');
			}
		};
	columnView();
	var maxh=$(window).height()-($('.metadmin-head').height()||0)-305;
	$column_view.find('.tab-content').css({'max-height':maxh});
	// 默认显示栏目数据设置
	obj.find('select[name="default_show_column"]').change(function(event) {
		var $self=$(this),
			val=$(this).val();
		setCookie('manage_default_show_column',val);
		$(this).val('');
		setTimeout(function(){
			$self.next('.dropdown').find('.dropdown-menu a[data-value="'+val+'"]').addClass('active').siblings().removeClass('active');
		},0);
		metui.use('alertify',function(){
			alertify.success(METLANG.jsok);
		});
	});
	// 列表显示类型切换
	$content_btn_group.find('a').click(function(event) {
		if(!M.is_admin) event.preventDefault();
		var view_type=$(this).data('view_type');
		if(location.hash=='#/manage'||!M.is_admin) columnView(view_type);
		if(M.is_admin) setTimeout(function(){
			location.hash='#/manage';
		},0);
	});
	// 切换栏目
	obj.on('click', '.column-view-list .list-group-item', function(event) {
		if(!$(event.target).closest(".btn-column-slide").length){
			var head_tab_active=$(this).attr('data-head_tab_active')||0,
				$next_subcolumn=$(this).next('.subcolumn');
			$(this).parents('.column-view-list').find('.list-group-item').removeClass('active');
			$(this).addClass('active');
			if($(this).attr('data-head_tab_active')){
				$(this).removeAttr('data-head_tab_active');
			}else{
				replaceParamVal('head_tab_active','');
			}
			var info=$(this).data('info'),
				$self=$(this);
			if(info){
				if(info.indexOf('|')>0){
					info=info.split('|');
					if(M.is_admin) replaceParamVal(['module','class1','class2','class3'],info);
					info.push(head_tab_active);
					contentShow(info);
					// if($next_subcolumn.is(':hidden')) $('.btn-column-slide',this).click();
				}else{
					info.substr(0,2)=='#/' && M.is_admin && (location.hash=info);
				}
			}else{
				$content_show.find('.content-show-item').hide();
				$content_show.find('.content-show-item[data-path^="about"]').remove();
				if($next_subcolumn.length) $next_subcolumn.find('.list-group-item:eq(0)').click();
			}
			if($(this).parents('.subcolumn:hidden').length) setTimeout(function(){
				$self.parents('.subcolumn:eq(0)').prev('a').find('.btn-column-slide').click();
			},100)
		}
	});
	obj.on('click', '.column-view-list .list-group-item .btn-column-slide', function(event) {
		$('i',this).toggleClass('rotate180').parents('.list-group-item').next('.subcolumn').slideToggle();
		if($(this).parents('.subcolumn:hidden').length) $(this).parents('.subcolumn:eq(0)').prev('a').find('.btn-column-slide').click();
	});
	// 编辑、列表页面加载
	function contentShow(options){
		var $loader=$content_show.find('.met-loader'),
			url=options[0],
			options={
				module:options[0],
				class1:options[1],
				class2:options[2],
				class3:options[3],
				head_tab_active:options[4]
			},
			view_type=$content_btn_group.find('a.active').data('view_type'),
			filename='',
			is_listmodule=$.inArray(options.module, ['news','product','img','download'])>=0?1:0,
			loadFun=function(){
				// admin_module.obj.find('.met-headtab a'+(options.head_tab_active?':eq('+options.head_tab_active+')':'.active')).click();
				admin_module.obj.find('.met-headtab a:eq('+options.head_tab_active+')').click();
			};
		if(is_listmodule){
			url+='/list/?c='+options.module+'_admin&a=docolumnjson';
		}else{
			switch(options.module){
				case 'about':
					url+='/'+(view_type=='column'?'edit':'list')+'/?c=about_admin&a='+(view_type=='column'?'doeditor':'docolumnjson');
					if(view_type=='column') options.id=options.class3?options.class3:(options.class2?options.class2:options.class1);
					break;
			}
		}
		var hash=url.indexOf('/?')>0?url.split('/?')[0]:url;
		if(options.module=='feedback' || options.module=='about' || options.module=='job'){
			hash+='/'+options.class1+'|'+options.class2+'|'+options.class3
		}
		$loader.removeClass('hide');
		$content_show.find('.content-show-item').hide();
		$content_show.find('.content-show-item[data-path^="about"]').remove();
		var $content_show_item=$content_show.find('.content-show-item[data-path="'+hash+'"]');
		((options.module=='about' && view_type=='module')||(options.module=='product'&&$content_show_item.find('iframe').length)) && $content_show_item.remove()/* && ($content_show_item=$content_show.find('.content-show-item[data-path="'+hash+'"]'))*/;
		if($content_show.find('.content-show-item[data-path="'+hash+'"]').length && $content_show_item.attr('data-loaded')){
			setTimeout(function(){
				$loader.addClass('hide');
				$content_show_item.show();
				if(is_listmodule || options.module=='job'){
					$content_show_item.tabelsearchReset(function(){
						var $select_linkage=$content_show_item.find('[data-plugin="select-linkage"]');
						$select_linkage.find('[name="class1"]').val(options.class1).change();
						$select_linkage.find('[name="class2"]').val(options.class2).change();
						$select_linkage.find('[name="class3"]').val(options.class3).change();
					});
				}
				loadedTempReload(hash,'',function(){
					loadFun();
				});
			},300);
		}else{
			metLoadTemp(url,options,$content_show_item,function(html){
				$loader.addClass('hide');
				$content_show.append('<div class="content-show-item" data-path="'+hash+'" data-loaded="1"></div>');
				$content_show_item=$content_show.find('.content-show-item[data-path="'+hash+'"]');
				$content_show_item[0].innerHTML=html;
			},function(){
				$content_show_item=$content_show.find('.content-show-item[data-path="'+hash+'"]');
				/*if(is_listmodule) */metui.use('#pub/js/content_list',function(){
					is_listmodule && setTimeout(function(){
						M.component.contentList();
					},0);
				});
				loadFun();
				options.module=='about' && metui.use('form',function(){
                    setTimeout(function(){
                        formSaveCallback($content_show_item.find('form').attr('data-validate_order'),{
                            true_fun: function(result) {
                                $content_show_item.remove();
                            }
                        });
                    },500);
                });
			});
		}
	}
	// 栏目列表最小化，展开
	obj.find('.btn-column-control').click(function(event) {
		$column_view_wrapper.toggleClass('min');
		setTimeout(()=>{
			$column_view_wrapper.toggleClass('oxh');
		},$column_view_wrapper.hasClass('min')?0:500);
		$('i',this).attr({class:$column_view_wrapper.hasClass('min')?'fa-angle-right':'fa-angle-left'});
	});
	// 搜索栏目
	obj.find('.column-search').change(function(event) {
		$.ajax({
			url: $(this).data('url'),
			type: 'POST',
			dataType: 'json',
			data: {search_contnet: $(this).val()},
			success:function(result){
				if(parseInt(result.status)){
					var html=columnList(result.data.list);
					$column_view.find('.tab-content .list-group').html(html);
					$content_show.find('.content-show-item').hide();
					$content_show.find('.content-show-item[data-path^="about"]').remove();
					$content_show.find('.content-show-item.tips').show();
				}
			}
		});
	});
	// 页面重载后的操作
	TEMPLOADFUNS['manage']=function(){
		typeof column_refresh!='undefined' && column_refresh && that.obj.find('.content-show .content-show-item .column-select').parents('.content-show-item').remove() && (column_refresh=0);
		($('.pageset-head-nav [data-url="manage"]').attr('data-module') && that.obj.find('.content-btn-group a[data-view_type="column"]:not(.active)').length) ? that.obj.find('.content-btn-group a[data-view_type="column"]:not(.active)').click() : columnView();
	};
})();