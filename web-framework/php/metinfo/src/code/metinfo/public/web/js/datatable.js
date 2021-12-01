/*!
 * 表格插件调用功能（需调用datatables插件）
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
$.fn.metDataTable=function(){
    var $datatable=$('.dataTable',this);
    if($datatable.length){
        // if(!performance.navigation.type){// 如果是重新进入页面，则清除DataTable表格的Local Storage，清除本插件stateSave参数保存的表格信息
            for(var i=0;i<localStorage.length;i++){
                if(localStorage.key(i).indexOf('DataTables_')>=0) localStorage.removeItem(localStorage.key(i));
            }
        // }
        var datatable_langurl= M['weburl']+'public/web/plugins/datatables/language/';
        // datatable多语言选择
        if("undefined" != typeof M){
            switch(M['synchronous']){
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
            datatable_order=datatable_order||0;
            var new_option=datatable_option[datatable_order]||'',
                option={
                    scrollX: M['device_type']=='m'?true:'',
                    sDom: 'tip',
                    responsive: true,
                    ordering: false, // 是否支持排序
                    searching: false, // 搜索
                    searchable: false, // 让搜索支持ajax异步查询
                    lengthChange: false,// 让用户可以下拉无刷新设置显示条数
                    pageLength:parseInt(obj.data('table-pagelength'))||30,// 每页显示数量
                    pagingType:'full_numbers',// 翻页按钮类型
                    serverSide: true, // ajax服务开启
                    stateSave:true,// 状态保存 - 再次加载页面时还原表格状态
                    sServerMethod:obj.data('table-type')||'POST',
                    language: {
                        url:datatable_langurl
                    },
                    ajax: {
                        url: obj.data('table-ajaxurl')||obj.data('ajaxurl'),
                        data: function ( para ) {
                            // 参数集
                            var filter={},
                                other_para={};
                            $("[data-table-search]").each(function(index,val){
                                if(($(this).parents('.dataTable').attr('data-datatable_order')||(typeof $(this).data('table-search')=='boolean'||!$(this).data('table-search')?0:$(this).data('table-search')))==datatable_order){
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
                            pagenum = Math.ceil(json.recordsTotal / settings._iDisplayLength);;
                        $wrapper.addClass('clearfix');
                        $paginate.addClass('pull-md-left text-xs-center');
                        $info.addClass('pull-md-right');
                        if(pagenum>2){
                            // 跳转到某页
                            var gotopage_html='<div class="gotopage inline-block m-t-15 m-l-10"><span>'+(M['synchronous']=='cn'?'跳转至':'Go to')+'</span> <input type="number" name="gotopage" min="1" max="'+pagenum+'" class="form-control form-control-sm w-50 text-xs-center"/> 页 <input type="button" class="btn btn-default btn-sm gotopage-btn" value="'+(M['synchronous']=='cn'?'跳转':'to')+'"/></div>';
                            $paginate.after(gotopage_html);
                            var $gotopage=$paginate.next('.gotopage');
                            $gotopage.find('.gotopage-btn').click(function(event) {
                                var gotopage=parseInt($gotopage.find('input[name=gotopage]').val());
                                if(!isNaN(gotopage)){
                                    if(gotopage>=1&&gotopage<=pagenum){
                                        gotopage--;
                                        datatable[datatable_order].page(gotopage).draw(false);
                                    }else{
                                        alert((M.synchronous=='cn'?'页码有效范围为：':'The valid range of page number is:')+'1~'+pagenum);
                                    }
                                }
                            });
                        }
                    },
                    drawCallback: function(settings){// 表格重绘后回调函数
                        var $this_scroll=$(window),
                            $show_body=$(this).data('show_body')?$($(this).data('show_body')):$(this);
                        if($(this).data('show_body')){
                            $show_body.metCommon();
                        }else{
                            $('tbody',this).metCommon();
                        }
                        $show_body.parents().each(function(index, el) {
                            if($(this).height()>0 && $(this).css('overflow-y')=='auto' || $(this).css('overflow-y')=='scroll'){
                                $this_scroll=$(this);
                                return false;
                            }
                        });
                        var this_top=$show_body.offset().top-($this_scroll.offset()?$this_scroll.offset().top:0);
                        if($this_scroll.scrollTop()>this_top) $this_scroll.scrollTop(this_top);// 页面滚动回表格顶部
                        $('#'+$(this).attr('id')+'_paginate .paginate_button.active').addClass('disabled');
                        // 添加表单验证
                        if(typeof $.fn.metFormAddField !='undefined') $show_body.metFormAddField();
                        $('.checkall-all',this).prop({checked:false});
                    },
                    rowCallback: function(row,data){// 行class
                        if(data.toclass) $(row).addClass(data.toclass);
                    },
                    columnDefs: columnDefs// 单元格class
                };
            if(new_option){
                if(new_option.columnDefs){
                    option.columnDefs=option.columnDefs.concat(new_option.columnDefs);
                    delete new_option.columnDefs;
                }
                $.extend(true,option, new_option);
            }
            return option;
        };
        if($datatable.length){
            /*动态事件绑定，无需重载*/
            if(typeof datatable =='undefined'){
                window.datatable={};
                window.datatable_option={};
                // 自定义搜索框
                $(document).on('change',"[data-table-search]",function(){
                    if($(this).parents('.form-group').hasClass('has-danger')) return false;
                    if(typeof datatable != 'undefined'){
                        var $this_datatable=$(this).parents('.dataTable'),
                            datatable_order=$this_datatable.index('.dataTable');
                            if(datatable_order<0) datatable_order=0;
                        typeof datatable[datatable_order]!='undefined' && datatable[datatable_order].ajax.reload();
                    }
                })
            }
            $datatable.each(function(index, el) {
                if($(this).data('table-ajaxurl')) datatable[index]=$(this).DataTable(datatableOption($(this),index));
            });
        }
    }
};
$(document).metDataTable();