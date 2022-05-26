/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)
  that.obj.on('change','[name="global_search_range"]',function(e) {
    const checked = that.obj.find('#global_search_range_1').data('checked')
    const module_collapse = that.obj.find('#module-collapse')
    const column_collapse = that.obj.find('#column-collapse')
    module_collapse.removeClass('show')
    column_collapse.removeClass('show')
    const value = e.target.value
    if (value === 'module') module_collapse.addClass('show');
    if (value === 'column') column_collapse.addClass('show');
  });
  metui.use('dragsort',function(){
    dragsortFun[that.obj.find('[data-plugin="dragsort"]').attr('data-dragsort_order')]=function(wrapper,item){
      var global_search_weight='';
      wrapper.find('li').each(function() {
        global_search_weight+=(global_search_weight?'|':'')+$(this).data('module');
      });
      that.obj.find('[name="global_search_weight"]').val(global_search_weight);
    };
  });
})()
