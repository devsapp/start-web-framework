/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
;(function() {
	var that = $.extend(true, {}, admin_module),
		obj = that.obj
	$.ajax({
		url: that.own_name + '&c=imgmanager&a=doGetThumbs',
		type: 'GET',
		dataType: 'json',
		success: function(result) {
			let data = result.data

			Object.keys(data).map(item => {
				if (item === 'met_thumb_kind') {
					$(`#met_thumb_kind-${data[item]}`).attr('checked', 'checked')
					return
				}

				$(`[name=${item}]`).val(data[item])
			})
		},
	})

})()
