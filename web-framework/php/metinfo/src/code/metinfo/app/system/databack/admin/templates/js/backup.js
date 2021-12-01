/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module),
      loop_ajax=function(url,btn){
        metui.request({
          url: url,
          success: function(result) {
            if (result.status == 0) callback(0,result.msg,btn);
            if (result.status === 1) callback(1,result.msg,btn);
            if (result.status === 2){
              loop_ajax(`${M.url.admin}?${result.call_back}`,btn);
              metAlert(METLANG.databacking+(result.piece?'正在备份数据分卷'+result.piece:'备份整站文件中')+'...','',1);
            }
          },
          error:function(result){
            (!result.status||result.status!=200)&&callback(0,METLANG.databackup4+METLANG.jsx10,btn);
          }
        })
      },
      callback=function(type,msg,btn){
        metAlert('',1);
        metui.use('alertify', function() {
          type?alertify.success(msg):alertify.error(msg);
        });
        type && (M.is_admin ? (window.location.href = `${M.url.admin}#/databack/?head_tab_active=1`) : that.obj.parents('.nav-modal-item').find('.met-headtab a:eq(1)').click());
        btn.find('.fa').remove()
        btn.removeAttr('disabled');
      };
  that.obj
  .find('.btn[data-action]')
  .click(function() {
    const btn = $(this);
    btn.append(`<i class="fa fa-spinner fa-spin ml-2"></i>`).attr('disabled', true);
    loop_ajax(that.own_name + 'c=index&a='+$(this).data('action'),btn);
    metAlert(METLANG.databacking,'',1);
  })
})();