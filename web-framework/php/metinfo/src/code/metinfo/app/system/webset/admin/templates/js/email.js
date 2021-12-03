/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)
  init()
  TEMPLOADFUNS[that.hash] = function() {
    init()
  }
  function init() {
    $.ajax({
      url: that.own_name + '&c=email&a=doGetEmail',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        let data = result.data
        Object.keys(data).map(item => {
          if (item === 'met_fd_way') {
            $(`#radio_${data[item]}`).attr('checked', 'checked')
            return
          }
          $(`[name=${item}]`).val(data[item])
        })
      }
    })
  }
})()
