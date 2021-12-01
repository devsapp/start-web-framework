/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module),
    obj = that.obj
  init()

  TEMPLOADFUNS[that.hash] = function() {
    init(1)
  }
  function init(refresh) {
    $.ajax({
      url: that.own_name + '&c=seo&a=doGetParameter',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        let data = result.data
        Object.keys(data).map(item => {
          if ($.inArray(item, ['met_title_type','tag_search_type','tag_show_range'])>=0) {
            that.obj.find('[name="'+item+'"][value="'+data[item]+'"]').click()
            return
          }
          if (item === 'met_301jump'||item === 'met_copyright_nofollow'||item === 'met_https') {
            if (parseInt(data[item]) && $(`[name="${item}"]`).val() === '0') $(`[name="${item}"]`).click()
            return
          }
          $(`[name=${item}]`).val(data[item])
        })
        if (!refresh) {
          obj.metCommon()
          metui.use('form', function() {
            var validate_order = obj.find('.info-form').attr('data-validate_order')
            formSaveCallback(validate_order, {
              true_fun: function(result) {
                M.met_keywords = obj.find('.info-form [name="met_keywords"]').val()
                M.met_alt = obj.find('.info-form [name="met_alt"]').val()
                M.met_atitle = obj.find('.info-form [name="met_atitle"]').val()
                M.is_admin ? window.location.reload() : null
              }
            })
          })
        }
      }
    })
  }
})()
