/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)
  fetch(that)
  TEMPLOADFUNS[that.hash] = function() {
    fetch(that)
  }
})()
function fetch(that) {
  metui.request(
    {
      url: that.own_name + '&c=map&a=doGetSiteMap'
    },
    function(result) {
      let data = result.data
      Object.keys(data).map(item => {
        data[item]=parseInt(data[item]);
        if (item === 'met_sitemap_auto') {
          if (data[item] > 0 && $(`[name="${item}"]`).val() === '0') $(`[name="${item}"]`).click()
          return
        }
        if (item === 'met_sitemap_lang') {
            $(`#met_sitemap_lang-${data[item]}`).attr('checked', 'checked');
            that.obj.find('[class*="met-sitemap-"]').each(function(index, el) {
              var href=M.weburl+'sitemap';
              href+=data[item]||M.lang==$(this).data('met_index_type')?'':('_'+M.lang);
              href+='.'+$(this).data('type');
              $(this).html(href).attr({href:href});
            });
            return
        }
        if (data[item] > 0) {
          $(`[name=${item}]`).attr('checked', 'checked')
        }
      })
    }
  )
}
