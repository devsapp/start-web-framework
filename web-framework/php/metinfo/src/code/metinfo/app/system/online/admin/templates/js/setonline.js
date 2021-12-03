/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
    var that = $.extend(true, {}, admin_module);
    that.obj.on('change', 'select[name="met_online_skin"]', function(event) {
        var view = $('option[value="' + $(this).val() + '"]', this).data('view')
        $(this).parents('dd').find('>a').attr('href', view).find('img').attr('src', view);
    });
})();