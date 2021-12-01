/**
 * 栏目模块
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
    var that=$.extend(true,{}, admin_module),
        obj=that.obj,
        column_list='#column-list',
        $column_list=obj.find(column_list),
        delurl=that.own_name+'c=index&a=doDeleteColumn&id=',
        moveurl=that.own_name+'c=index&a=domove',
        edit_dataurl='?c=index&a=doGetColumn&id=',
        subcolumns={},
        allsubcolumn=0,
        config={
            module_option:function(classtype,parent_module,fn){
                var html='',
                    parent_module=parent_module||'';
                metui.ajax({
                    url: that.own_name+'c=index&a=doGetModlist'
                },function(result){
                    $.each(result, function(index, val) {
                        val.mod=parseInt(val.mod);
                        val.num=parseInt(val.num);
                        if(classtype==3 && val.mod!=parent_module && val.mod) return true;
                        if((val.mod==6 && val.num && parent_module!=6) || (parent_module==6 && val.mod!=parent_module)) return true;
                        var same_mod_length=$(column_add_modal+' table tbody [name*="module-"]').filter(function(index) {
                                return $(this).val()==val.mod;
                            }).length;
                        if($.inArray(val.mod, [7,9,10,11,12,13])>=0 && same_mod_length) return true;
                        if(val.mod==6 && classtype==1 && same_mod_length) return true;
                        html+='<option value="'+val.mod+'">'+val.name+'</option>';
                    });
                    (typeof fn==='function')&&fn(html);
                });
            }
        },
        columnList=function(data){// 栏目列表数据渲染
            var new_data=[];
            $.each(data, function(index, val) {
                var list=[];
                val.module=parseInt(val.module);
                list.push(M.component.checkall('item',val.id)
                        +M.component.formWidget('bigclass-'+val.id,val.bigclass)
                        +M.component.formWidget('classtype-'+val.id,val.classtype)
                        +M.component.formWidget('index_num-'+val.id,val.index_num));
                list.push(M.component.formWidget('no_order-'+val.id,val.no_order,'text',1,'','text-center'));
                var name_html=M.component.formWidget('name-'+val.id,val.name,'text',1,1);
                if(val.subcolumn){
                    name_html='<div class="input-group">'
                        +'<div class="input-group-prepend">'
                            +'<a href="javascript:;" class="input-group-text px-1 noshow bg-white btn-show-subcolumn"><i class="fa-caret-down"></i></a>'
                        +'</div>'
                        +name_html
                    +'</div>'
                }
                list.push('<div class="form-group '+(val.classtype>1?'pl-'+(val.classtype==2?4:5):'')+'">'+name_html+'</div>');
                nav_option_val='<select name="nav-'+val.id+'" data-checked="'+val.nav+'" class="form-control w-a d-inline-block">'+config.nav_option+'</select>';
                list.push(nav_option_val);
                list.push(val.module_name+M.component.formWidget('module-'+val.id,val.module));
                list.push('<span class="text-break">'+val.foldername+'</span>'+M.component.formWidget((val.module?'foldername':'out_url')+'-'+val.id,(val.module?val.foldername:val.out_url)));
                var action_more='';
                if(val.action.add_subcolumn) action_more+='<a href="javascript:;" class="dropdown-item btn-add-subcolumn" data-toggle="modal" data-target=".column-add-modal">'+METLANG.addsubcolumn+'</a>';
                if(val.action.columnmove){
                    var columnmove='';
                    if(val.classtype>1 && val.action.top_column) columnmove+='<a href="javascript:;" class="dropdown-item px-3" data-uplv="1" data-top_column="'+val.action.top_column+'">'+METLANG.columnerr7+'</a>';
                    if(val.action.move_columns){
                        if(val.classtype>1) columnmove+='<div class="dropdown-divider"></div>';
                        $.each(val.action.move_columns, function(index1, val1) {
                            columnmove+='<a href="javascript:;" class="dropdown-item px-3" data-id="'+val1.id+'">'+val1.name+'</a>';
                        });
                    }
                    action_more+='<div class="dropdown dropdown-submenu dropleft"><a href="javascript:;" class="dropdown-item dropdown-toggle btn-move-column" data-toggle="dropdown">'+METLANG.columnmove1+'</a>'
                    +'<div class="dropdown-menu move-column-list">'
                        +columnmove
                    +'</div>'
                    +'</div>';
                }
                list.push('<button type="button" class="btn btn-primary mr-1" data-toggle="modal" data-target=".column-details-modal" data-modal-title="'+METLANG.columnmeditor+'" data-modal-size="lg" data-modal-url="column/edit/'+edit_dataurl+val.id+'" data-modal-fullheight="1" data-modal-tablerefresh="'+column_list+'">'+METLANG.seting+'</button>'
                    +'<div class="dropdown d-inline-block">'
                        +'<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-submenu>'+METLANG.columnmore+'</button>'
                        +'<div class="dropdown-menu dropdown-menu-right">'
                            +action_more
                            +M.component.btn('del',{del_url:delurl+val.id,class:'dropdown-item btn-del-column',confirm_title:METLANG.delete_information+METLANG.jsx39})
                        +'</div>'
                    +'</div>');
                $.each(list,function(index,item){
                    list[index]='<div>'+list[index]+'</div>';
                })
                list['DT_RowClass']='class'+val.classtype;
                if(val.classtype>1) list['DT_RowClass']+=' hidden';
                new_data[new_data.length]=list;
                if(val.subcolumn) subcolumns[val.id]=val.subcolumn;
            });
            return new_data;
        };
    // 栏目列表加载
    M.component.commonList(function(){
        return {
            ajax:{
                dataSrc:function(result){
                    config.nav_option='';
                    subcolumns={};
                    allsubcolumn=0;
                    $.each(result.data.nav_list, function(index, val) {
                        config.nav_option+='<option value="'+index+'">'+val+'</option>';
                    });
                    var data=columnList(result.data.column_list);
                    result.draw>1 && sidebarReload();
                    return data;
                }
            }
        };
    });
    // 列表渲染后回调
    $column_list.on('draw.dt',function(event) {
        event.preventDefault();
        $column_list.find('tbody tr').each(function(index, el) {
            $(this).attr({'data-bigclass':$(this).find('[name*="bigclass"]').val(),'data-classtype':$(this).find('[name*="classtype"]').val()});
        });
        if($column_list.find('.btn-show-allsubcolumn i').hasClass('rotate180')){
            obj.find('.btn-show-allsubcolumn2').click();
        }else{
            var showcolumn=parseInt($column_list.attr('data-showcolumn'));
            if(showcolumn){
                var $tr=$column_list.find('tbody [name="id"][value="'+showcolumn+'"]').parents('tr');
                if(!$tr.length){
                    $.each(subcolumns, function(index, val) {
                        $.each(val, function(index1, val1) {
                            if(parseInt(showcolumn)==parseInt(val1.id)){
                                $column_list.find('tbody [name="id"][value="'+index+'"]').parents('tr').find('.btn-show-subcolumn').click();
                                return false;
                            }
                        });
                    });
                    $tr=$column_list.find('tbody [name="id"][value="'+showcolumn+'"]').parents('tr');
                }
                $tr.find('.btn-show-subcolumn').click();
                $column_list.removeAttr('data-showcolumn');
            }
        }
    });
    // 列表保存回调
    metui.use('form',function(){
        formSaveCallback($column_list.parents('form').attr('data-validate_order'),{
            true_fun:function(){
                window.column_refresh=1;
            }
        });
    });
    // 展开全部子栏目
    $column_list.find('.btn-show-allsubcolumn').click(function(event) {
        if(!$('i',this).hasClass('transition500')) $('i',this).addClass('transition500');
        $column_list.find('.btn-show-subcolumn i:not(.transition500)').addClass('transition500');
        obj.find('.btn-show-allsubcolumn2').html(METLANG[($('i.rotate180',this).length?'open':'close')+'_allchildcolumn_v6']);
        if($('i.rotate180',this).length){
            $column_list.find('tbody tr:not(.class1) td>div').stop().slideUp(300);
            $column_list.find('tbody tr').find('.btn-show-subcolumn i').removeClass('rotate180');
            setTimeout(function(){
                $column_list.find('tbody tr:not(.class1)').addClass('hide');
            },300);
        }else{
            $column_list.find('tbody tr').removeClass('hide').find('td>div').stop().slideDown(300).find('.btn-show-subcolumn:not(.noshow) i').addClass('rotate180');
            if(!allsubcolumn){
                allsubcolumn=1;
                var $noshow=$column_list.find('tbody tr .btn-show-subcolumn.noshow');
                $noshow.length && (metAlert('栏目展开中...','',1),$noshow.click());
                // setTimeout(()=>{
                    $column_list.find('tbody tr .btn-show-subcolumn.noshow').click();
                // },0);
            }
        }
        $('i',this).toggleClass('rotate180');
    });
    obj.find('.btn-show-allsubcolumn2').click(function(event) {
        $column_list.find('.btn-show-allsubcolumn').click();
    });
    // 展开子栏目
    $column_list.on('click clicks', '.btn-show-subcolumn', function(event) {
        var is_click=event.type=='click',
            toggleColumn=function(objs,hide){
                var $icon=objs.find('i[class*="fa-caret-"]'),
                    $tr=objs.parents('tr'),
                    bigclass=parseInt($tr.find('[name*="bigclass-"]').val()),
                    $bigclass_btn_show_subcolumn=$column_list.find('[name="id"][value="'+bigclass+'"]').parents('tr').find('.btn-show-subcolumn');
                if(!$icon.hasClass('transition500')) $icon.addClass('transition500');
                if(is_click){
                    if(hide){
                        $icon.removeClass('rotate180');
                    }else $icon.toggleClass('rotate180');
                }
                var id=$tr.find('[name="id"]').val(),
                    son_classtype=parseInt($tr.find('[name*="classtype-"]').val())+1,
                    $sub=$column_list.find('[name*="bigclass-"][value="'+id+'"]').parents('tr.class'+son_classtype);
                if($icon.hasClass('rotate180')||!is_click){
                    if(!$sub.length){
                        var html=Tbody({
                                data:columnList(subcolumns[id]),
                                table_obj:$column_list
                            });
                        $tr.after(html);
                        $sub=$column_list.find('[name*="bigclass"][value="'+id+'"]').parents('tr.class'+son_classtype);
                        $sub.metCommon();
                        $sub.metFormAddField();
                        var sub_length=$sub.length;
                        $sub.each(function(index, el) {
                            $(this).attr({'data-bigclass':$(this).find('[name*="bigclass"]').val(),'data-classtype':$(this).find('[name*="classtype"]').val(),'data-index':sub_length-index-1});
                        });
                    }
                    if(is_click){
                        $sub.removeClass('hide').find('td>div').stop().slideDown(300);
                        if(bigclass && !$bigclass_btn_show_subcolumn.find('i[class*="fa-caret-"]').hasClass('rotate180')) $bigclass_btn_show_subcolumn.click();
                    }
                }else{
                    $sub.find('td>div').stop().slideUp(300);
                    setTimeout(function(){
                        $sub.addClass('hide');
                    },300);
                }
                if(is_click&&son_classtype==2&&!$icon.hasClass('rotate180')){
                    $sub.each(function(index, el) {
                        toggleColumn($(this).find('.btn-show-subcolumn'),1);
                    });
                }
            };
        $(this).removeClass('noshow');
        if(allsubcolumn&&!$column_list.find('tbody tr .btn-show-subcolumn.noshow').length) metAlert(' ');
        toggleColumn($(this));
    });
    // 添加一级栏目、子栏目
    var column_add_id=0,
        column_add_modal='.column-add-modal';
    M.component.modal_call_status[column_add_modal]=[];
    metui.use('modal',function(){
        M.component.modal_options[column_add_modal]={
            modalSize:'lg',
            modalTitle:METLANG.add+METLANG.settopcolumns,
            modalRefresh:'one',
            modalBody:`<form action="${that.own_name}c=index&a=doAddColumn" class="form-inline" data-submit-ajax="1">
                <table class="table table-hover w-100 dtr-inline">
                    <thead>
                        <tr>
                            <th class="text-center" width="60">${METLANG.sort}</th>
                            <th>${METLANG.columnname}</th>
                            <th class="text-center" width="150">${METLANG.columnnav}</th>
                            <th class="text-center" width="120">${METLANG.columnmodule}</th>
                            <th class="text-center" width="150">${METLANG.columndocument}</th>
                            <th class="text-center" width="50">${METLANG.operate}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6">
                                <button type="button" class="btn btn-primary btn-add-columns">${METLANG.add}</button>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </form>`,
            callback:function(key,data){
                $(column_add_modal+' table tbody').html('');
                setTimeout(function(){
                    $(column_add_modal+' .btn-add-columns').click();
                },100);
                metui.use('form',function(){
                    var validate_order=$(column_add_modal+' form').attr('data-validate_order');
                    if(!M.component.modal_call_status[column_add_modal][validate_order]){
                        M.component.modal_call_status[column_add_modal][validate_order]=1;
                        formSaveCallback(validate_order, {
                            true_fun: function() {
                                $column_list.attr({'data-showcolumn':$(column_add_modal+' .btn-add-columns').attr('data-bigclass')});
                                window.column_refresh=1;
                            }
                        });
                    }
                });
            }
        }
    });
    // 表格中添加按钮点击操作
    obj.on('click', '[data-target="'+column_add_modal+'"]', function(event) {
        var $tr=$(this).parents('tr'),
            name=$tr.find('[name*="name-"]').val(),
            isaddsub=$(this).hasClass('btn-add-subcolumn'),
            classtype=isaddsub?(parseInt($tr.data('classtype'))+1):1,
            bigclass=isaddsub?$tr.find('[name="id"]').val():0,
            module=isaddsub?parseInt($tr.find('[name*="module-"]').val()):1;
        setTimeout(function(){
            $(column_add_modal+' .btn-add-columns').attr({'data-classtype':classtype,'data-bigclass':bigclass,'data-parent_module':module});
            $(column_add_modal+' .modal-body').attr({'data-title':isaddsub?`${METLANG.addsubcolumn}<span class="h6 mb-0">（${name}）</span>`:METLANG.add+METLANG.settopcolumns});
        },0)
    });
    // 添加栏目弹框中添加按钮点击操作
    $(document).on('click', column_add_modal+' .btn-add-columns', function(event) {
        var id='-new-'+column_add_id,
            classtype=$(this).attr('data-classtype'),
            parent_module=$(this).attr('data-parent_module'),
            html=`<tr>
                <td class="text-center">
                    ${M.component.formWidget('no_order'+id,$(column_add_modal+' table tbody tr').length,'text',1,'','text-center')}
                    ${M.component.formWidget('id',column_add_id)}
                    ${M.component.formWidget('bigclass'+id,$(this).attr('data-bigclass'))}
                    ${M.component.formWidget('classtype'+id,classtype)}
                </td>
                <td>${M.component.formWidget('name'+id,'','text',1)}</td>
                <td class="text-center"><select name="nav${id}" class="form-control">${config.nav_option}</select></td>
                <td class="text-center"><select name="module${id}" class="form-control"></select></td>
                <td class="text-center">${M.component.formWidget('foldername'+id,'','text',1,'','text-center')}</td>
                <td class="text-center">${M.component.btn('cancel')}</td>
            </tr>`;
        $(column_add_modal+' table tbody').append(html);
        var $new_tr=$(column_add_modal+' table tbody tr:last-child');
        config.module_option(classtype,parent_module,function(module_option){
            $new_tr.find('[name*="module-"]').html(module_option);
            classtype>1 && $new_tr.find('[name*="module-"]').val(parent_module).change();
            setTimeout(function(){
                $new_tr.metFormAddField();
            },0)
        });
        column_add_id++;
    });
    // 切换栏目类型
    $(document).on('change', `${column_add_modal} [name*="module-"]`, function(event) {
        var value=parseInt($(this).val()),
            $tr=$(this).parents('tr'),
            id='-new-'+$tr.find('[name="id"]').val(),
            bigclass=$tr.find('[name*="bigclass-"]').val(),
            $bigclass=$column_list.find('tbody [name="id"][value="'+bigclass+'"]').parents('tr'),
            name=value?'foldername'+id:'out_url'+id,
            foldername='',
            readonly=false,
            $foldername=$tr.find('[name*="foldername-"],[name*="out_url-"]');
        switch(value){
            case 6:
                foldername='job';
                break;
            case 7:
                foldername='message';
                break;
            case 10:
                foldername='member';
                break;
            case 11:
                foldername='search';
                break;
            case 12:
                foldername='sitemap';
                break;
            case 13:
                foldername='tags';
                break;
        }
        if(value==6||value==7||value==10||value==11||value==12||value==13) readonly=true;
        if(value==$bigclass.find('[name*="module-"]').val()){
            foldername=$bigclass.find('[name*="foldername-"]').val();
            readonly=true;
        }
        $foldername.val(foldername).attr({name:name,readonly:readonly}).change();
    });
    // 选中一级栏目的回调
    $column_list.on('click', 'tbody tr input[name="id"]', function(event) {
        var subChecked=function(obj){
                var checked=obj.prop("checked"),
                    $sub=$column_list.find('tbody tr input[name^="bigclass-"][value="'+obj.val()+'"]').parents('td').find('input[name="id"]').filter(function(index) {
                        return checked!=$(this).prop("checked");
                    }),
                    delay=0;
                if(!$sub.length){
                    if(obj.parents('tr').find('.btn-show-subcolumn').length){
                        obj.parents('tr').find('.btn-show-subcolumn').trigger('clicks');
                        delay=300;
                    }else{
                        return;
                    }
                }
                setTimeout(function(){
                    if(delay) $sub=$column_list.find('tbody tr input[name^="bigclass-"][value="'+obj.val()+'"]').parents('td').find('input[name="id"]').filter(function(index) {
                        return checked!=$(this).prop("checked");
                    });
                    $sub.prop({checked:checked});
                    if(parseInt(obj.parents('tr').data('classtype'))==1){
                        $sub.each(function(index, el) {
                            subChecked($(this));
                        });
                    }
                },delay);
            };
        subChecked($(this));
    });
    // 移动栏目
    $column_list.on('click', '.move-column-list a:not([data-uplv])', function(event) {
        metui.ajax({
            url: moveurl,
            data: {
                nowid: $(this).parents('tr').find('[name="id"]').val(),
                toid: $(this).data('id')
            }
        },function(result){
            $column_list.tabelAjaxFun(result);
        });
    });
    // 升为一级栏目
    var uplv=function(id,foldername){
            metui.ajax({
                url: moveurl,
                data: {nowid: id,uplv: 1,foldername:foldername}
            },function(result){
                $column_list.tabelAjaxFun(result);
            });
        };
    $column_list.on('click', '.move-column-list a[data-uplv]', function(event) {
        var $tr=$(this).parents('tr'),
            id=$tr.find('[name="id"]').val();
        if(parseInt($(this).data('top_column'))==2){
            metui.use('alertify',function(){
                var confirm_text='<h5>'+METLANG.column_inputcolumnfolder_v6+'</h5><span class="text-danger">'+METLANG.js56+'</span><br /><input name="foldername" required class="form-control mt-2 mb-0"/>';
                alertify.confirm(confirm_text, function (ev) {
                    uplv(id,$('.alertify .dialog [name="foldername"]').val());
                });
            })
        }else{
            uplv(id,$tr.find('[name*="foldername-"]').val());
        }
    });
    // 栏目增删后更新侧栏
    var $metadmin_sidebar_nav=$('.metadmin-sidebar-nav');
    function sidebarReload(){
        $metadmin_sidebar_nav.length && metui.ajax({
            url: M.url.adminurl+'sidebar_reload=1',
            dataType: 'html',
            success:function(result){
                if(result.indexOf('transition500')>0){
                    var $hr=$metadmin_sidebar_nav.find('hr:eq(0)'),
                        active_key=$metadmin_sidebar_nav.find('li.active').index('.metadmin-sidebar-nav li');
                    $hr.nextAll('li').remove();
                    $hr.after(result);
                    $metadmin_sidebar_nav.find('li:eq('+active_key+')').addClass('active');
                }
            }
        });
    }
    // 栏目编辑保存回调
    var column_details_modal='.column-details-modal';
    M.component.modal_call_status[column_details_modal]=[];
    metui.use('modal',function(){
        M.component.modal_options[column_details_modal]={
            callback:function(key,data){
                metui.use('form',function(){
                    var validate_order=$(key+' form').attr('data-validate_order');
                    if(!M.component.modal_call_status[key][validate_order]){
                        M.component.modal_call_status[key][validate_order]=1;
                        formSaveCallback(validate_order, {
                            true_fun: function() {
                                var id=$(key+' form [name="id"]').val(),
                                    $tr=$column_list.find('tbody input[name="id"][value="'+id+'"]').parents('tr'),
                                    classtype=parseInt($tr.data('classtype'));
                                if(classtype==3) id=$tr.data('bigclass');
                                $column_list.attr({'data-showcolumn':id});
                                window.column_refresh=1;
                            }
                        });
                    }
                });
            }
        };
    });
})();