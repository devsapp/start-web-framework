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
      url: that.own_name + '&c=info&a=doGetInfo',
      type: 'GET',
      dataType: 'json',
      success: function(result) {
        let data = result.data
        Object.keys(data).map(item => {
          if (item === 'data_key') {
            that.obj.find(`form [name="met_ico"]`).attr(
              'data-url',
              that.obj.find(`form [name="met_ico"]`)
                .attr('data-url')
                .split('data_key=')[0] +
                'data_key=' +
                data[item]
            )
            return
          }
          if (item === 'met_footother') {
            that.obj.find(`form [name="met_footother"]`).html(data[item])
            return
          }
          if (item === 'met_copyright_type') {
            that.obj.find(`form [name="met_copyright_type"][value="${data[item]}"]`).click();
            return
          }
          if (item === 'agents') {
            data[item].map((item1,index) => {
              that.obj.find(`form [name="met_copyright_type"]`).eq(index).next('label').html(item1);
            })
            return
          }
          that.obj.find(`form [name=${item}]`).attr('type') == 'file' ? that.obj.find(`form [name=${item}]`).attr('value', data[item]) : that.obj.find(`form [name=${item}]`).val(data[item])
        })
        if (!refresh) {
          that.obj.metCommon()
        }
      }
    })
  }
})()
