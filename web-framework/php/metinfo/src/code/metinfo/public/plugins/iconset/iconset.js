/**
 * 图标设置弹框
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
    // 弹框参数
    M.component.modal_options['.met-icon-modal']={
        modalTitle:METLANG.column_choosicon_v6||'选择图标',
        modalSize:'xl',
        modalUrl:'#pub/icon_list',
        modalFullheight:1,
        modalFooter:'<div class="float-left"><button type="button" class="btn btn-warning back-iconlist" hidden>'+METLANG.back_icon_iibrary_list+'</button><span class="ml-2 text-danger">'+METLANG.choose_icon_tips+'</span></div>',
        modalRefresh:'one',
        callback:function(key){
            $(key).find('.back-iconlist').click();
            $(key).find('.icon-detail .icondemo-wrap').removeClass('checked');
        }
    };
    // 图标按钮初始化
    $.fn.metIconSet=function(){
        $(this).each(function(index, el) {
            var value=$(this).val(),
                btn_size=$(this).data('btn_size')||'',
                icon_class=$(this).data('icon_class')||'';
            $(this).after('<div class="d-inline-block met-icon-view position-relative h5 mb-0 px-1 mr-2 '+icon_class+(value?'':' hide')+'"><button type="button" class="btn btn-default position-absolute btn-icon-del"><i class="wb-trash"></i></button><i class="'+value+'" icon-value></i></div>'
                // +'<div class="btn-group btn-group-'+btn_size+'">'
                +'<div class="btn-group">'
                    +'<button type="button" class="btn btn-primary btn-icon-set" data-toggle="modal" data-target=".met-icon-modal">'+(METLANG.column_choosicon_v6||'选择图标')+'</button>'
                +'</div>');
        });
    }
    // 图标选择框-初始化
    $(document).on('click', '.btn-icon-set', function(event) {
        var $self=$(this);
        setTimeout(function(){
            var $icon_modal=$('.met-icon-modal');
            if(!$self.attr('id')) $self.attr({id:'iconset-'+new Date().getTime()});
            $icon_modal.find('.modal-footer button[data-ok]').attr({'data-id':$self.attr('id')});
        },100);
    });
    // 图标设置框-选择图标库
    $(document).on('click', '.met-icon-modal .iconchoose .iconchoose-href', function(event) {
        var $icon_modal=$('.met-icon-modal');
        $icon_modal.find('.icon-list').hide();
        $icon_modal.find('.icon-detail').attr({hidden:''});
        $icon_modal.find('.icon-detail[data-name='+$(this).data('icon')+'],.back-iconlist').removeAttr('hidden');
    });
    // 图标设置框-返回图标列表页
    $(document).on('click', '.met-icon-modal .back-iconlist', function(event) {
        var $icon_modal=$('.met-icon-modal');
        $(this).attr({hidden:''});
        $icon_modal.find('.icon-list').show();
        $icon_modal.find('.icon-detail').attr({hidden:''}).find('.icondemo-wrap').removeClass('active');
    });
    // 图标设置框-选择图标
    $(document).on('click', '.met-icon-modal .icon-detail .icondemo-wrap', function(event) {
        $('.met-icon-modal').find('.icon-detail .icondemo-wrap').removeClass('active');
        $(this).addClass('active');
    });
    // 图标设置框-保存
    $(document).on('click', '.met-icon-modal .modal-footer button[data-ok]', function(event) {
        var $icon_modal=$('.met-icon-modal'),
            $icon_active=$icon_modal.find('.icon-detail .icondemo-wrap.active'),
            $self=$(this);
        metui.use('alertify', function() {
            if($icon_active.length){
                var icon_active=$icon_active.parents('.icon-detail').data('prev')+$icon_active.data('name'),
                    $form_group=$('#'+$self.attr('data-id')).parents('.btn-group').parent();
                $icon_modal.modal('hide');
                (!$self.attr('data-obj') || $self.attr('data-obj').indexOf('pageset-iconset-')<0) && alertify.success(METLANG.jsok||'操作成功');
                if($form_group.length){
                    $form_group.find('input[type="hidden"][name][data-plugin="iconset"]').val(icon_active).trigger('change');
                    $form_group.find('.met-icon-view').removeClass('hide').find('i[icon-value]').attr({class:icon_active});
                }
            }else{
                alertify.error(METLANG.column_choosicon_v6||'请选择图标');
            }
        });
    });
    // 图标设置框-删除
    $(document).on('click', '.btn-icon-del', function(event) {
        var $form_group=$(this).parents('.met-icon-view').parent();
        if($form_group.find('input[type="hidden"][name][data-plugin="iconset"]').val()){
            $form_group.find('input[type="hidden"][name][data-plugin="iconset"]').val('').trigger('change');
            $form_group.find('.met-icon-view').addClass('hide').find('i[icon-value]').attr({class:''});
        }
    });
    $(document).on('hidden.bs.modal', '.met-icon-modal', function(event) {
        $('.modal-footer button[data-ok]',this).removeAttr('data-obj');
    });
})();