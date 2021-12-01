/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
  var that = $.extend(true, {}, admin_module)
  /*   that.div = $('.met-lang-setting')
  const beforeHTML = that.div.html()
  that.div.html(M.component.loader({ height: '300px', class_name: 'w-100' }))
  setTimeout(() => {
    that.div.html(beforeHTML)
    renderTable(that)
  }, 500) */
  renderTable(that)
  TEMPLOADFUNS[that.hash] = function() {
    /*     that.div.html(M.component.loader({ height: '300px', class_name: 'w-100' }))
    setTimeout(() => {
      that.div.html(beforeHTML)
      renderTable(that)
    }, 500) */
    renderTable(that)
  }
  function renderTable(that) {
    $.ajax({
      url: that.own_name + '&c=language_general&a=doGetGeneral',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        let data = result.data
        Object.keys(data).map(item => {
          if (data[item] > 0 && $(`[name="${item}"]`).val() === '0') $(`[name="${item}"]`).click()
          $(`[name=${item}]`).val(data[item])
        })
      }
    })
  }
})()
