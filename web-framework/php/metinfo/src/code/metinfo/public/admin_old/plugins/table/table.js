define(function(require, exports, module) {

	var common = require('common');
	if(!performance.navigation.type && location.search.indexOf('&turnovertext=')<0){// 如果是重新进入页面，则清除DataTable表格的Local Storage，清除本插件stateSave参数保存的表格信息
		for(var i=0;i<localStorage.length;i++){
		    if(localStorage.key(i).indexOf('DataTables_')>=0) localStorage.removeItem(localStorage.key(i));
		}
 	}
	function tablexp(obj){
		obj.parents(".v52fmbx").css("border","0");
		if(obj.attr('data-table-datatype') == 'jsonp'){
			require('epl/table/js/jquery.dataTables.jsonp');
		}else{
			require('epl/table/js/jquery.dataTables.min');
		}
	 	// setTimeout(function(){
	 		if(typeof datatableOption =='undefined'){
	 			window.datatableOption=function(obj){
	 				// 列表class
		            var cadcs = obj.find("th[data-table-columnclass]"),
		                cjson=[];
		            if(cadcs.length>0){
		                cadcs.each(function(i){
		                    var c = $(this).attr("data-table-columnclass"),n=$(this).index();
		                    cjson[i] = [];
		                    cjson[i]['className'] = c;
		                    cjson[i]['targets']=[];
		                    cjson[i]['targets'][0] = n;
		                });
		            }
		            var language=langset!='cn'&&langset!='en'?'cn':langset,
		            	option={
							scrollX: met_mobile?true:'',
							ordering: false, // 是否支持排序
							searching: false, // 搜索
							searchable: false, // 让搜索支持ajax异步查询
							info: true, // 左下角条数信息
							lengthChange: false,// 让用户可以下拉无刷新设置显示条数
							pageLength:parseInt(obj.attr('data-table-pageLength'))||20,// 每页显示数量
							pagingType:'full_numbers',
							// paging: true,  //
							// processing: true, //
							serverSide: true, // ajax服务开启
							stateSave: true,// 状态保存 - 再次加载页面时还原表格状态
							sServerMethod:obj.data('table-type')||'POST',
							language: { // 语言配置文件
								url: pubjspath + 'plugins/table/lang/'+language+'.php'
							},
							ajax: {
								url: obj.attr('data-table-ajaxurl')||obj.data('ajaxurl'),
								data: function ( para ) {
									para_other={};
									if($("[data-table-search]").length){
										$("[data-table-search]").each(function(index,val){
											para_other[$(this).attr('name')]=$(this).val();
										});
									}
									return $.extend({},para,para_other);
								}
							},
							initComplete: function(settings, json) {// 表格初始化回调函数
								common.defaultoption();
								//用户栏目列表隐藏
								$(".bigid").each(function(){
									if($(this).val() != 0){
										$(this).parents('tr').hide();
									}
								});
				            	if(json.recordsTotal>settings._iDisplayLength){
				            		// 跳转到某页
									var $paginate=$(this).parent().find('.dataTables_paginate'),
						            	gotopage_html='<div class="gotopage pull-left"><span>跳转到第</span> <input type="text" name="gotopage"/> 页 <input type="button" class="btn btn-default btn-sm gotopage-btn" value="跳转"/></div>';
						            $paginate.after(gotopage_html);
						            $('.gotopage .gotopage-btn').click(function(event) {
						            	var gotopage=parseInt($('.gotopage input[name=gotopage]').val());
				            			if(!isNaN(gotopage)){
				            				gotopage--;
				            				window.table.page(gotopage).draw(false);
				        				}
						            });
								}
							},
							drawCallback: function(settings){// 表格重绘后回调函数
					            if($(window).scrollTop()>$(this).offset().top) $(window).scrollTop($(this).offset().top);// 页面滚动回表格顶部
					            if($('[data-original]',this).length){
					            	var $self=$(this);
					            	require.async('plugins/jquery.lazyload.min.js',function(a){
			                            $self.find('[data-original]').lazyload();
			                        });
			                    }
					        },
					        rowCallback: function(row,data){// 行class
								if (data.toclass) $(row).addClass(data.toclass);
							},
							columnDefs: cjson // 单元格class
						};
					if(typeof datatable_option!='undefined'){
						if(typeof datatable_option['dataSrc']!='undefined') option.ajax.dataSrc=datatable_option['dataSrc']; // 自定义的表格返回数据处理
			            if(typeof datatable_option['columns']!='undefined') option.columns=datatable_option['columns']; // 自定义表格单元格对应的数据名称
		            }
		            return option;
	            };
	 		}
	 		if(obj.parents('form').find('.ftype_select-linkage').length){
	 			var $select0=obj.parents('form').find('.ftype_select-linkage select:eq(0)'),
	 				data_checked=typeof $select0.data('checked')=='undefined'?'':$select0.data('checked'),
	 				option_checked_interval=setInterval(function(){
	 					var $option_checked=obj.parents('form').find('.ftype_select-linkage select:eq(0) option:checked');
	 					if($option_checked.length && ($option_checked.val()==data_checked || data_checked=='') ){
	 						window.table = obj.DataTable(datatableOption(obj));
	 						clearInterval(option_checked_interval);
	 					}
	 				},50);
	 		}else{
	 			window.table = obj.DataTable(datatableOption(obj));
	 		}
	 	// },100)
	}
	exports.func = function(d){
		d = d.find('.ui-table[data-table-ajaxurl]');
		if(d.length){
			d.each(function(){
				tablexp($(this));
			});
		}
	}
	/*动态事件绑定，无需重载*/
	//自定义搜索框
	$(document).on('change keyup',"[data-table-search]",function(){
		if(typeof table !='undefined') window.table.ajax.reload();
	})
	//全选
	$(document).on('change',".ui-table input[data-table-chckall]",function(){
		var v = $(this).attr("data-table-chckall"),t = $(this).attr("checked")?true:false;
		$(this).parents('.ui-table').find("input[name='"+v+"']").attr('checked',t);
		$(this).parents('.ui-table').find("input[name='"+v+"']").each(function(){
			var mt = $(this).attr("checked")?true:false,tr=$(this).parents("td").eq(0).parent("tr");
			if(mt){
				tr.addClass("ui-table-td-hover");
			}else{
				tr.removeClass("ui-table-td-hover");
			}
		});
	})
	//下拉菜单提交表单
	$(document).on('change',".ui-table select[data-isubmit='1']",function(){
		if($(this).val()!=''){
			$(this).parents('.ui-table').find("input[name='submit_type']").val('');
			$(this).parents("form").submit();
		}
	})
	//按钮提交表单
	$(document).on('click',".ui-table *[type='submit']",function(){
		var nm = $(this).attr('name'),ip=$(this).parents('.ui-table').find("input[name='submit_type']");
		if(ip.length>0){
			ip.val(nm);
		}else{
			$(this).parents("form").append("<input type='hidden' name='submit_type' value='"+nm+"' />");
		}
	})
	//删除栏目
	$(document).on('click',".ui-table tr.newlist td .delet",function(){
		var newl = $(this).parents('tr.newlist');
		if(newl.length>0){ //删除正在新增的栏目
			newl.remove();
			return false;
		}
	})
	window.ai = 0;
	$(document).on('click',"*[data-table-addlist]",function(){
		var url = $(this).attr("data-table-addlist"),d=$(this).parents(".ui-table").length?$(this).parents(".ui-table").find("tbody tr").last():$(".ui-table:eq(0)").find("tbody tr").last();
		//AJAX获取HTML并追加到页面
		d.after('<tr><td colspan="'+d.find('td').length+'">Loading...</td></tr>');
		$.ajax({
			url: url,//新增行的数据源
			type: "POST",
			data: 'ai=' + window.ai,
			success: function(data) {
				d.next("tr").remove();
				d.after(data);
				d.next("tr").find("input[type='text']").eq(0).focus();
				common.defaultoption(d.next("tr"));
			}
		});
		window.ai++;
		return false;

	});
	// 添加列表项
	$(document).on('click', '.ui-addlist:not([data-table-addlist])', function(event) {
		var $ui_table=$(this).parents('.ui-table'),
			order_name=$(this).data('order-name');
		$ui_table.find('tbody').append($ui_table.find('[ui-addlist-html]').val());
		$ui_table.find('tbody tr:last-child [name="'+order_name+'"]').val($ui_table.find('tbody tr').length-1);
	});
	// 删除项
	$(document).on('click', '.ui-table tbody .ui-table-del', function(event) {
		var $self=$(this);
		require.async('web_plugins/alertify/alertify.js',function(a){
			alertify.theme('bootstrap').okBtn(METLANG.confirm).cancelBtn(METLANG.jslang2).confirm(METLANG.delete_information, function (ev) {
				$self.parents('tr').remove();
			})
		})
	});
	// 删除多项
	$(document).on('click', '.ui-table .submit[name="del"]:not([data-confirm])', function(event) {
		var $self=$(this);
		require.async('web_plugins/alertify/alertify.js',function(a){
			var $checked=$self.parents('.ui-table').find('tbody input[type="checkbox"][name="'+$self.data('del-name')+'"]:checked');
			if($checked.length){
				alertify.theme('bootstrap').okBtn(METLANG.confirm).cancelBtn(METLANG.jslang2).confirm(METLANG.delete_information, function (ev) {
					$checked.each(function(index, el) {
						$(this).parents('tr').remove();
					});
				})
			}else{
				alertify.error('请选择至少一项！');
			}
		})
	});
	//自动选中
	function table_check(){
		if($('.ui-table td input[type="checkbox"],.ui-table td input[type="radio"]').length>0){
			$(document).on('change','.ui-table td input[type="checkbox"],.ui-table td input[type="radio"]',function(){
				var v = $(this).parents(".ui-table").find("input[data-table-chckall]").eq(0).attr("data-table-chckall"),
					t = $(this).attr("checked")?true:false,
					tr = $(this).parents("td").parent("tr");
				if(v&&t){
					tr.addClass("ui-table-td-hover");
					tr.find("input[name='"+v+"']").attr("checked",t);
				}else if(!t&&$(this).attr("name")==v){
					tr.removeClass("ui-table-td-hover");
				}
			});
		}
	}
	/*表格内容修改后自动勾选对应选项*/
	function modifytick(){
		var fints = $(".ui-table td input,.ui-table td select");
		if(fints.length>0){
			var nofocu = true;
			fints.each(function() {
				$(this).data($(this).attr('name'), $(this).val());
			});
			fints.focusout(function() {
				var tr = $(this).parents("tr");
				if ($(this).val() != $(this).data($(this).attr('name'))) tr.find("input[name='id']").attr('checked', nofocu);
			});
			$(".ui-table td input:checkbox[name!='id']").change(function(){
				var tr = $(this).parents("tr");
				tr.find("input[name='id']").attr('checked', nofocu);
			});
		}
	}

	//表格控件事件
	$(document).on( 'init.dt', function ( e, settings ) {
		// var page = $.cookie('tablepage');
		// if(page){
		// 	var y = page.split('|'),u = metn+','+metc+','+meta;
		// 	if(y[1]==u){
		// 		window.table.page(parseInt(y[0])).draw( false );
		// 	}else{
		// 		$.cookie('tablepage',null);
		// 	}
		// }
		var api = new $.fn.dataTable.Api( settings );
		var show = function ( str ) {
			// Old IE :-|
			try {
				str = JSON.stringify( str, null, 2 );
			} catch ( e ) {}

			//alert(str);
			table_check();
			var cklist = $(".ui-table td select[data-checked]");
			if(cklist.length>0){
				cklist.each(function(){
					var v = $(this).attr('data-checked');
					if(v!=''){
						if($(this)[0].tagName=='SELECT'){
							$(this).val(v);
						}
					}
				});
			}
			//common.defaultoption();
			modifytick();
		};
		// First draw
		var json = api.ajax.json();
		if ( json ) {
			show( json );
		}
		// Subsequent draws
		api.on( 'xhr.dt', function ( e, settings, json ) {
			show( json );
		} );
		api.on( 'draw.dt', function ( e, settings, json ) {
			show( json );
			var info = window.table.page.info();
			$.cookie('tablepage',info.page+'|'+metn+','+metc+','+meta);
		} );
	} );
});