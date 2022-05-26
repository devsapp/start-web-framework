/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module),
    obj = that.obj
  $.ajax({
    url: that.own_name + '&c=imgmanager&a=doGetWaterMark',
    type: 'GET',
    dataType: 'json',
    success: function(result) {
      let data = result.data
      Object.keys(data).map(item => {
        if (item === 'met_wate_class') {
          $(`#met_wate_class-${data[item]}`).attr('checked', 'checked')
          $(`.met_wate_class-${data[item]}`).removeClass('hide')
          return
        }
        if (item === 'met_watermark') {
          $(`#met_watermark-${data[item]}`).attr('checked', 'checked')
          return
        }
        if (item === 'met_big_wate' || item === 'met_thumb_wate') {
          data[item] > 0 ? $(`#${item}`).attr('checked', 'checked') : null
          return
        }
        $(`[name=${item}]`).attr('type') == 'file' ? $(`[name=${item}]`).attr('value', data[item]) : $(`[name=${item}]`).val(data[item])
      })
      that.obj.metCommon()
    }
  })
  $('[name="met_wate_class"').change(function(e) {
    const value = e.target.value
    const other = value === '2' ? '1' : '2'
    $(`.met_wate_class-${value}`).removeClass('hide')
    $(`.met_wate_class-${other}`).addClass('hide')
  })
})()
