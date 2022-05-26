/**
 * 表格插件调用功能（需调用datatables插件）
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
    var datatable_langurl= M.url.public_plugins+'datatables/language/';
    // datatable多语言选择
    if("undefined" != typeof M){
        switch(M.synchronous){
            case 'sq':datatable_langurl+='AL';break;
            case 'ar':datatable_langurl+='MA';break;
            // case 'az':datatable_langurl+='az';break;
            // case 'ga':datatable_langurl+='ie';break;
            // case 'et':datatable_langurl+='ee';break;
            case 'be':datatable_langurl+='BE';break;
            case 'bg':datatable_langurl+='BG';break;
            case 'pl':datatable_langurl+='PL';break;
            case 'fa':datatable_langurl+='IR';break;
            // case 'af':datatable_langurl+='za';break;
            case 'da':datatable_langurl+='DK';break;
            case 'de':datatable_langurl+='DE';break;
            case 'ru':datatable_langurl+='RU';break;
            case 'fr':datatable_langurl+='FR';break;
            // case 'tl':datatable_langurl+='ph';break;
            case 'fi':datatable_langurl+='FI';break;
            // case 'ht':datatable_langurl+='ht';break;
            // case 'ko':datatable_langurl+='kr';break;
            case 'nl':datatable_langurl+='NL';break;
            // case 'gl':datatable_langurl+='es';break;
            case 'ca':datatable_langurl+='ES';break;
            case 'cs':datatable_langurl+='CZ';break;
            // case 'hr':datatable_langurl+='hr';break;
            // case 'la':datatable_langurl+='IT';break;
            // case 'lv':datatable_langurl+='lv';break;
            // case 'lt':datatable_langurl+='lt';break;
            case 'ro':datatable_langurl+='RO';break;
            // case 'mt':datatable_langurl+='mt';break;
            // case 'ms':datatable_langurl+='ID';break;
            // case 'mk':datatable_langurl+='mk';break;
            case 'no':datatable_langurl+='NO';break;
            case 'pt':datatable_langurl+='PT';break;
            case 'ja':datatable_langurl+='JP';break;
            case 'sv':datatable_langurl+='SE';break;
            case 'sr':datatable_langurl+='RS';break;
            case 'sk':datatable_langurl+='SK';break;
            // case 'sl':datatable_langurl+='si';break;
            // case 'sw':datatable_langurl+='tz';break;
            case 'th':datatable_langurl+='TH';break;
            // case 'cy':datatable_langurl+='wls';break;
            // case 'uk':datatable_langurl+='ua';break;
            // case 'iw':datatable_langurl+='';break;
            case 'el':datatable_langurl+='GR';break;
            case 'eu':datatable_langurl+='ES';break;
            case 'es':datatable_langurl+='ES';break;
            case 'hu':datatable_langurl+='HU';break;
            case 'it':datatable_langurl+='IT';break;
            // case 'yi':datatable_langurl+='de';break;
            // case 'ur':datatable_langurl+='pk';break;
            case 'id':datatable_langurl+='ID';break;
            case 'en':datatable_langurl+='English';break;
            case 'vi':datatable_langurl+='VN';break;
            case 'zh':datatable_langurl+='Chinese-traditional';break;
            default:datatable_langurl+='Chinese';break;
        }
    }else{
        datatable_langurl+='Chinese';
    }
    datatable_langurl+='.json';
    // 如果是重新进入页面，则清除DataTable表格的Local Storage，清除本插件stateSave参数保存的表格信息
    if(!performance.navigation.type || M.url.admin){
        for(var i=0;i<localStorage.length;i++){
            if(localStorage.key(i).indexOf('DataTables_')>=0) localStorage.removeItem(localStorage.key(i));
        }
    }
    window.datatableOption=function(obj,datatable_order){
        // 列表class
        var columnDefs=[];
        obj.find("thead th[data-table-columnclass]").each(function(i){
            columnDefs.push({
                className:$(this).attr("data-table-columnclass"),
                targets:[$(this).index()]
            })
        });
        // 插件参数
        var datatable_order=datatable_order||0,
            new_option=datatable_option[datatable_order]||'',
            option={
                scrollX: M.device_type=='m'?true:'',
                sDom: obj.data('table-sdom')||'t<"F"pi>',
                responsive: true,
                ordering: false, // 是否支持排序
                searching: false, // 搜索
                searchable: false, // 让搜索支持ajax异步查询
                lengthChange: false,// 让用户可以下拉无刷新设置显示条数
                pageLength:parseInt(obj.data('table-pagelength'))||20,// 每页显示数量
                pagingType:'full_numbers',// 翻页按钮类型
                serverSide: true, // ajax服务开启
                stateSave:true,// 状态保存 - 再次加载页面时还原表格状态
                sServerMethod:obj.data('table-type')||'POST',
                language: {
                    url:datatable_langurl
                },
                ajax: {
                    url: obj.data('table-ajaxurl'),
                    data: function ( para ) {
                        // 参数集
                        var filter={},
                            other_para={};
                        $("[data-table-search]").each(function(index,val){
                            if(($(this).parents('.dataTable').attr('data-datatable_order')||$($(this).data('table-search')).attr('data-datatable_order'))==datatable_order){
                                var value=$(this).val();
                                if($(this).attr('type')=='checkbox'){
                                    value='';
                                    $('input[data-table-search][type="checkbox"][name="'+$(this).attr('name')+'"]:checked').each(function(index1,val1){
                                        value+=(index1?'#@met@#':'')+$(this).val();
                                    })
                                }
                                var $obj=$(this).attr('type')=='checkbox'?$('input[data-table-search][type="checkbox"][name="'+$(this).attr('name')+'"]:eq(0)'):$(this);
                                if(typeof $obj.attr('data-table-filter')!='undefined') filter[$(this).attr('name')]=value;
                                other_para[$(this).attr('name')]=value;
                            }
                        });
                        para.filter=filter;
                        if(typeof para.order!='undefined'){
                            var new_order='';
                            if(new_option.ajax_para&&new_option.ajax_para.order_type==1) new_order={};
                            $.each(para.order, function(index, val) {
                                var $order=obj.find('thead th').eq(val.column),
                                    order_info=$order.data('order_info');
                                if(order_info){
                                    order_info=order_info.split('|');
                                    var order_value=order_info[1].split(',');
                                    if(new_order){
                                        new_order[order_info[0]]=order_value[val.dir=='asc'?0:1];
                                    }else{
                                        para.order[index].name=order_info[0];
                                        para.order[index].value=order_value[val.dir=='asc'?0:1];
                                    }
                                }
                            });
                            if(new_order) para.order=new_order;
                        }
                        return new_option.ajax_para&&new_option.ajax_para.handle?new_option.ajax_para.handle(para,other_para,filter):$.extend(true,para,other_para);
                    }
                },
                initComplete: function(settings, json) {// 表格初始化回调函数
                    var $wrapper=$(this).parents('.dataTables_wrapper'),
                        $paginate=$wrapper.find('.dataTables_paginate'),
                        $info=$wrapper.find('.dataTables_info'),
                        classname=settings._iDisplayLength>500?'hide':'',
                        pagenum = Math.ceil(json.recordsTotal / settings._iDisplayLength);
                    $wrapper.addClass('clearfix');
                    $paginate.addClass('float-left').parent().addClass('w-100 '+classname);
                    if($paginate.length && !$paginate.parent().hasClass('hide')) $(this).addClass('border-bottom').find('tfoot th').addClass('border-none');
                    $info.addClass('float-right');
                    if(pagenum>2){
                        // 跳转到某页
                        var gotopage_html='<div class="gotopage float-left mt-2 ml-2"><span>'+METLANG.jump_to_no+'</span> <input type="number" name="gotopage" min="1" max="'+pagenum+'" class="form-control form-control-sm text-center" style="width: 60px;"/> '+METLANG.page+' <input type="button" class="btn btn-sm btn-outline-primary gotopage-btn" value="'+METLANG.goto+'"/></div>';
                        $paginate.after(gotopage_html);
                        var $gotopage=$paginate.next('.gotopage');
                        $gotopage.find('.gotopage-btn').click(function(event) {
                            var gotopage=parseInt($gotopage.find('input[name=gotopage]').val());
                            if(!isNaN(gotopage)){
                                if(gotopage>=1&&gotopage<=pagenum){
                                    gotopage--;
                                    datatable[datatable_order].page(gotopage).draw(false);
                                }else{
                                    metui.use('alertify',function(){
                                        alertify.error((M.synchronous=='cn'?'页码有效范围为：':'The valid range of page number is:')+'1~'+pagenum);
                                    });
                                }
                            }
                        });
                    }
                    // 单元格宽度初始化
                    $('thead th',this).each(function(index, el) {
                        var width=parseInt($(this).attr('width'))||'';
                        width && (width<$(this).width()||$(this).width()>1.3*width||!parseInt($(this).css('width'))) && $(this).width(width);
                        if($(this).width()>200) $(this).addClass('text-wrap');
                        if($('.custom-checkbox',this).length) $(this).width(16);
                    });
                },
                drawCallback: function(settings){// 表格重绘后回调函数
                    var $this_scroll=$(this).parents('.met-scrollbar').length?$(this).parents('.met-scrollbar').eq(0):$(window),
                        $show_body=$(this).data('show_body')?$($(this).data('show_body')):$(this);
                    // 功能渲染
                    if($(this).data('show_body')){
                        $show_body.metCommon();
                    }else{
                        $('tbody',this).metCommon();
                    }
                    if($(this).attr('data-scrolltop')!=0){
                        var this_top=$this_scroll.scrollTop()-$show_body.height();
                        if($this_scroll.scrollTop()>this_top) $this_scroll.scrollTop(this_top);// 页面滚动回表格顶部
                    }
                    $(this).removeAttr('data-scrolltop');
                    // $('#'+$(this).attr('id')+'_paginate .paginate_button.active').addClass('disabled');
                    // 添加表单验证
                    metui.use(['form','formvalidation'],function(){$show_body.metFormAddField();});
                    $('.checkall-all',this).prop({checked:false});
                },
                rowCallback: function(row,data){// 行class
                    if(data.toclass) $(row).addClass(data.toclass);
                },
                columnDefs: columnDefs// 单元格class
            };
        if(typeof new_option!='undefined'){
            if(new_option.columnDefs){
                option.columnDefs=option.columnDefs.concat(new_option.columnDefs);
                delete new_option.columnDefs;
            }
            $.extend(true,option, new_option);
        }
        return option;
    };
    $.fn.extend({
        // 执行DataTable函数
        metDataTable:function(fn){
            var $self=$(this),
                $dataTable=$('.dataTable[data-table-ajaxurl]',this);
            if(!$dataTable.length) return;
            metui.use('datatables',function(){
                $dataTable.each(function(index, el) {
                    var order=$(this).attr('data-datatable_order')&&$(this).attr('data-datatable_order')!=''?$(this).attr('data-datatable_order'):($(this).attr('id')?'#'+$(this).attr('id'):('met-datatable-'+new Date().getTime()+index));
                    $(this).attr({'data-datatable_order':order});
                    !$(this).attr('id') && $(this).attr({id:order.substr(0,1)=='#'?order.substr(1):order});
                    $(this).attr('data-table-ajaxurl') && (datatable[order]=$(this).DataTable(datatableOption($(this),order)));
                });
                (typeof fn==='function') && setTimeout(function(){fn()}, 230);
            });
        },
        // 表格提交后返回结果回调
        tabelAjaxFun:function(result,fn){
            var $self=$(this),
                table_order=$(this).attr('data-datatable_order'),
                validate_order=$(this).parents('form').attr('data-validate_order'),
                this_fn=[function(){
                    if(typeof datatable[table_order]!='undefined') datatable[table_order].row().draw(false);
                    $('.met-pageset').length && $('.page-iframe').attr({'data-reload':1});
                    typeof fn=='function' && fn();
                }],
                true_fun='';
            if(typeof validate_fun[validate_order] != 'undefined' && typeof validate_fun[validate_order].success != 'undefined'){
                typeof validate_fun[validate_order].success.true_fun != 'undefined' && (true_fun=validate_fun[validate_order].success.true_fun) && (typeof true_fun==='function'?this_fn.push(fn):$.isArray(true_fun)&&(this_fn=this_fn.concat(true_fun)));
            }
            metAjaxFun({
                result: result,
                true_fun: this_fn
            });
        },
        // 表格删除按钮ajax提交
        metFormAjaxDel:function(){
            var $form=$(this).parents('form'),
                $table=$(this).parents('.dataTable'),
                url=$(this).data('url')||'',
                allid=$form.find('[name="allid"]').val(),
                data={allid:allid};
            $form.removeAttr('data-submited');
            if(url?$(this).parents('tbody').length:allid!=''){
                if(url.indexOf('&allid=')>0) data={};
                metui.ajax({
                    url: url||$form.attr('action'),
                    data:data,
                    success: function(result){
                        $table.tabelAjaxFun(result);
                    }
                });
            }else{
                metui.use('alertify',function(){
                    alertify.error(METLANG.jslang3||'请选择至少一项');
                });
            }
        }
    });
    window.datatable=[];
    window.datatable_option=[];
    typeof M.list=='undefined'&&(M.list=[]);
    $(document).metDataTable();
    // 自定义搜索框
    $(document).on('change',"[data-table-search]",function(){
        if($(this).parents('.form-group').hasClass('has-danger') || M.dataTable_search_stop) return false;
        var $this_datatable=$(this).parents('.dataTable').length?$(this).parents('.dataTable'):$($(this).data('table-search')),
            datatable_order=$this_datatable.attr('data-datatable_order');
        if(typeof datatable[datatable_order]!='undefined') datatable[datatable_order].ajax.reload();
    });
    // 添加项
    $(document).on('click', '[table-addlist]', function(event) {
        var $self=$(this),
            $table=$(this).parents('table').length?$(this).parents('table'):$($(this).attr('table-addlist')),
            addlist=function(html,new_id){
                if($table.find('tbody .dataTables_empty').length){
                    $table.find('tbody').html(html);
                }else $table.find('tbody').append(html);
                var $new_tr=$table.find('tbody tr:last-child');
                if(!$new_tr.find('[table-cancel]').length && typeof $self.data('nocancel')=='undefined') $new_tr.find('td:last-child').append(M.component.btn('cancel'));
                if(new_id){
                    $new_tr.find('[name][name!="id"]').each(function(index, el) {
                        $(this).attr({name:$(this).attr('name')+'-new-'+datatable_option[table_order]['new_id']});
                    });
                    $new_tr.find('[name="id"]').val('new-'+datatable_option[table_order]['new_id']);
                }
                $table.find('thead th').each(function(index, el) {
                    var columnclass=$(this).data('tableColumnclass');
                    columnclass && $new_tr.find('td').eq(index).addClass(columnclass);
                });
                $new_tr.metCommon();
                // 添加表单验证
                $new_tr.metFormAddField();
                $table.find('[type="submit"]').addClass('disabled');
            };
        var table_order=$table.attr('data-datatable_order');
        if(table_order){
            if(typeof datatable_option[table_order]=='undefined') datatable_option[table_order]={};
            if(typeof datatable_option[table_order]['new_id']=='undefined'){
                datatable_option[table_order]['new_id']=0;
            }else{
                datatable_option[table_order]['new_id']++;
            }
        }
        if($table.find('[table-addlist-data]').length){
            var html=$table.find('[table-addlist-data]').val();
            addlist(html,$(this).data('table-newid')?1:0);
        }else if($(this).data('url')){
            metui.ajax({
                url: $(this).data('url'),
                data:{new_id:datatable_option[table_order]['new_id']},
                dataType:'text',
                success:function(result){
                    addlist(result);
                }
            });
        }
    });
    // 保存新加项
    $(document).on('click', 'table tbody tr [table-save-new][data-url]', function(event) {
        if($(this).parents('tr').find('.has-danger').length) return false;
        var data={},
            $table=$(this).parents('.dataTable'),
            table_order=$table.attr('data-datatable_order');
        $(this).parents('tr').find('[name]').each(function(index, el) {
            data[$(this).attr('name')]=$(this).val();
        });
        $.ajax({
            url: $(this).data('url'),
            type: 'POST',
            dataType: 'json',
            data: data,
            success:function(result){
                $table.attr({'data-scrolltop':0});
                $table.tabelAjaxFun(result);
                setTimeout(function(){
                    if(!$table.find('[table-save-new]').length) $table.find('[type="submit"]').removeClass('disabled disableds').removeAttr('disabled');
                },500)
            }
        });
    });
    // 撤销项
    $(document).on('click', 'table [table-cancel]', function(event) {
        var $table=$(this).parents('table');
        $(this).parents('tr').remove();
        if(!$table.find('tbody .checkall-item:checked').length) $table.find('.checkall-all').prop({checked:false});
        if(!$table.find('[table-save-new]').length) $table.find('[type="submit"]').removeClass('disabled disableds').removeAttr('disabled');
    });
    // 删除项-不提交
    $(document).on('click', 'table [table-del]', function(event) {
        var $self=$(this),
            checked_length=$self.parents('table').find('tbody .checkall-item:checked').length;
        metui.use('alertify',function(){
            if(!$self.parents('tbody').length && !checked_length){
                alertify.error(METLANG.jslang3||'请选择至少一项');
            }else{
                alertify.theme('bootstrap').okBtn(METLANG.confirm||'确定').cancelBtn(METLANG.cancel||'取消').confirm(METLANG.delete_information||'您确定要删除该信息吗？删除之后无法再恢复。', function (ev) {
                    if($self.parents('tbody').length){
                        $self.parents('tr').remove();
                    }else if(checked_length){
                        $self.parents('table').find('tbody .checkall-item[name="id"]:checked').parents('tr').remove();
                        $self.parents('table').find('.checkall-all').prop({checked:false});
                    }
                });
            }
        });
    });
    // 删除多项提交
    $(document).on('click', 'table [table-delete]', function(event) {
        event.preventDefault();
        var $form=$(this).parents('form'),
            url=$(this).data('url')||'';
        $form.attr({'data-submited':1}).metSubmit($(this).data('submit_type')||0);
        $(this).parents('table').attr({'data-scrolltop':0});
        if($(this).data('plugin')!='alertify'){
            if(url){
                $(this).metFormAjaxDel();
            }else $form.submit();
        }else{
            var allid=$form.find('[name="allid"]').val()||'';
            if(url?!$(this).parents('tbody').length&&allid=='':allid==''){
                $form.removeAttr('data-submited');
                metui.use('alertify',function(){
                    alertify.error(METLANG.jslang3||'请选择至少一项');
                });
            }
        }
    });
    // 禁止提交按钮
    $(document).on('click', 'button.disableds', function(event) {
        event.preventDefault();
    });
    // 表格中内容修改后勾选所在行
    $(document).on('change', 'table tbody [name]:not(.checkall-item)', function(event) {
        $(this).parents('tr:eq(0)').find('td:eq(0) .checkall-item').prop({checked:true}).trigger('change');
    });
})();
function Tr(array,columnclass){
    var html='',
        columnclass=columnclass||[];
    array && (html=`<tr ${array.DT_RowClass?`class="${array.DT_RowClass}"`:''}>`,$.each(array, function(index, val) {
        var isobject=typeof val=='object',
            innerhtml=isobject?val.html:val,
            classname=columnclass[index]||(isobject?(val.class||''):'');
        if(isobject && typeof val.align!='undefined') classname+=` text-${val.align}`;
        html+=`<td
        ${classname?`class="${classname}"`:''}
        ${isobject && typeof val.colspan!='undefined'?`colspan="${val.colspan}"`:''}
        ${isobject && typeof val.rowspan!='undefined'?`rowspan="${val.rowspan}"`:''}
        ${isobject && typeof val.attr!='undefined'?`attr="${val.attr}"`:''}>${innerhtml}</td>`
    }),html+='</tr>');
    return html;
}
function Tbody(options){
    var html='',
        colspan='';
    if(options.table_obj){
        var $th=options.table_obj.find('thead th'),
            columnclass=(()=>{
                var array=[];
                $th.each(function(index, el) {
                    array.push($(this).data('tableColumnclass')||'');
                });
                return array;
            })();
        colspan=$th.length;
    }
    if(options.thead){
        var columnclass=(()=>{
                var array=[];
                $.each(options.thead, function(index, val) {
                    if(!val) return true;
                    var str='';
                    val.align && (str+=` text-${val.align}`);
                    val.columnclass && (str+=` ${val.columnclass}`);
                    array.push(str);
                });
                return array;
            })();
        colspan=options.thead.length;
    }
    options.data&&options.data.length?$.each(options.data, function(index, val) {
        html+=Tr(val,columnclass);
    }):(html=Tr([
        {
            html:METLANG.csvnodata,
            colspan:colspan,
            align:'center'
        }
    ]));
    return html;
}