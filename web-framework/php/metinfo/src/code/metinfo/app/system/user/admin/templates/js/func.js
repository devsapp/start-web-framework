/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)
  fetch()
  TEMPLOADFUNS[that.hash] = function() {
    fetch(1)
  }
  function fetch(refresh) {
    metui.request(
      {
        url: that.own_name + '&c=admin_set&a=doGetUserSetup'
      },
      function(result) {
        let data = result.data
        Object.keys(data).map(item => {
          if (item === 'met_member_register') {
            if (data[item] !== $(`[name="${item}"]`).val()) $(`[name="${item}"]`).click()
            return
          }
          if (item === 'met_member_idvalidate') {
            if (data[item] !== $(`[name="${item}"]`).val()) $(`[name="${item}"]`).click()
            return
          }
          if (item === 'met_member_agreement') {
            if (data[item] !== $(`[name="${item}"]`).val()) {
              $(`[name="${item}"]`).click()
            }
            return
          }

          if (item === 'met_member_vecan') {
            $(`#met_member_vecan-${data[item]}`).attr('checked', 'checked')
            return
          }
          if (item === 'met_login_box_position') {
            $(`#met_login_box_position-${data[item]}`).attr('checked', 'checked')
            return
          }
          if (item === 'met_member_bg_range') {
            $(`#met_member_bg_range-${data[item]}`).attr('checked', 'checked')
            return
          }

          $(`[name=${item}]`).attr('type') == 'file' ? $(`[name=${item}]`).attr('value', data[item]) : $(`[name=${item}]`).val(data[item])
        })
        $(`[name="met_member_agreement"]`)
          .off()
          .on('change', function(e) {
            if (e.target.checked) {
              $('.met_member_agreement').removeClass('hide')
            } else {
              $('.met_member_agreement').addClass('hide')
            }
          })

        if (!refresh) {
          that.obj.metCommon()
        }
      }
    )
  }
})()
