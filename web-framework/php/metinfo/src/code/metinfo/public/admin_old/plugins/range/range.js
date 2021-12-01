define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');
		require('epl/range/jquery.nouislider.css');
		require('epl/range/jquery.nouislider.min');
	function range(m){
		var n=m.attr('name'),
			f=Number(m.val()),
			p=m.attr("data-rangestep")?Number(m.attr("data-rangestep")):1,
			min=Number(m.attr("data-rangemin")),
			max=Number(m.attr("data-rangemax")),
			ds=m.attr("data-rangdecimals")?Number(m.attr("data-rangdecimals")):0;
		m.before("<div id='range-slider-"+n+"' class='range-slider'></div>");
		$("#range-slider-"+n).noUiSlider({
			start: f,//默认值
			step: p,//拖动距离
			range: {
				'min': min, //最小值
				'max': max //最大值
			},
			serialization: {
				lower: [
				  $.Link({
					target: m //将值填充到指定元素
				  })
				],
				format: {
					decimals: ds,//保留小数点位数
					mark: '.'//小数点直接的间隔
				}
			}
		});
	}
	
	exports.func = function(d){
		d = d.find('.ftype_range .fbox input');
		d.each(function(){
			range($(this));
		});
	}
	
});
