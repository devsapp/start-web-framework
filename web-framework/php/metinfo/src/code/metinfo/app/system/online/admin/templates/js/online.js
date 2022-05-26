/**
 * 客服列表
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function() {
    var that = $.extend(true, {}, admin_module);
    // 参数列表
    M.component.commonList(function(that){
        return {
            ajax:{
                dataSrc:function(result){
                    var data=[];
                    if(result.data){
                        var del_url=that.own_name+'c=online&a=doSaveMenu&submit_type=del&allid=';
                        $.each(result.data, function(index, val) {
                            val.type=parseInt(val.type);
                            var item=[
                                    M.component.checkall('item',val.id)+M.component.formWidget('no_order-'+val.id,val.no_order),
                                    M.component.formWidget('name-'+val.id,val.name,'text',1),
                                    M.component.formWidget({
                                        name:'type-'+val.id,
                                        type:'select',
                                        value:val.type,
                                        data:[
                                            {value:0,name:'QQ'},
                                            {value:8,name:METLANG.enterprise_qq},
                                            {value:1,name:METLANG.online_taobaocs_v6},
                                            {value:2,name:METLANG.online_alics_v6},
                                            {value:3,name:METLANG.parameter8},
                                            {value:4,name:METLANG.unitytxt_71},
                                            {value:5,name:'Skype'},
                                            {value:6,name:'Facebook'},
                                            {value:7,name:METLANG.external_links}
                                        ]
                                    }),
                                    M.component.formWidget('value-'+val.id,val.value,val.type==4?'file':'text',1),
                                    M.component.formWidget({
                                        name:'icon-'+val.id,
                                        type:'icon',
                                        value:val.icon,
                                        btn_size:'sm',
                                        icon_class:'mb-1 mr-0'
                                    }),
                                    M.component.btn('del',{del_url:that.own_name+'c=online&a=dolistsave&submit_type=del&allid='+val.id})
                                ];
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
        dragsortFun[that.obj.find('table tbody').attr('data-dragsort_order')]=function(wrapper){
            wrapper.find('tr [name*="no_order-"]').each(function(index, el) {
                $(this).val($(this).parents('tr').index());
            });
        };
    });
    // 客服类型切换
    that.obj.find('#online-list tbody').on('change', '[name*="type-"]', function(event) {
        var value=parseInt($(this).val()),
            $tr=$(this).parents('tr'),
            $name=$tr.find('[name^="value-"]'),
            $td=$name.parents('td'),
            value_name=$name.attr('name');
        $td.html(M.component.formWidget({
            name: value_name,
            value: '',
            type: value == 4 ? 'file' : 'text',
            required:1,
            attr:value == 4?'data-drop-zone-enabled="false"':''
        }));
        $td.metCommon();
        $td.metFormAddField();
    });
})();