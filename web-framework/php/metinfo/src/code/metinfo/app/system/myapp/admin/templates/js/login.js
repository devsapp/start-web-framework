/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module);
  metui.use(['form', 'formvalidation'], function() {
    var order = that.obj.find('form').attr('data-validate_order')
    validate[order].success(function(res) {
      metAjaxFun({
        result: res,
        true_fun: function() {
          let source = getCookie('app_href_source')
          var href = M.url.admin + '#/'+source;
          if(M.is_admin){
            if(source=='ui_set/package'){
              var $btn_syspackage=$('.metadmin-head-right a[data-target=".syspackage-modal"]');
              $btn_syspackage.attr({'data-modal-url':$btn_syspackage.attr('data-url'),'data-modal-title':$btn_syspackage.attr('data-title')}).trigger('clicks');
            }else{
              window.location.href=href;
            }
          }else{
            var new_source=source.indexOf('/?')?source.split('/?')[0]:source;
            var title=$('.pageset-head-nav [data-url="'+source+'"]').text()||$('.pageset-head-nav [data-url="'+new_source+'"]').text()||$('.pageset-nav-modal .nav-modal-item .met-headtab a[href="#/'+source+'"]').html();
            $('.pageset-nav-modal .modal-title').attr('data-title',title);
            $('.btn-pageset-common-page').attr({'data-url':source}).trigger('clicks');
          }
        }
      });
    });
  });
})();