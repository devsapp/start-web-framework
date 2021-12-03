define(function(require, exports, module) {

	var $ = require('jquery');
	var common = require('common');
	require('plugins/time/jquery.datetimepicker.min.css');
	require('plugins/time/jquery.datetimepicker');
	exports.func = function(d){
		d = d.find('.ftype_day .fbox input');
		d.each(function(){
			$(this).datetimepicker({
				lang:'ch',
				timepicker:$(this).attr("data-day-type")==2?true:false,
				format:$(this).attr("data-day-type")==2?'Y-m-d H:i:s':'Y-m-d'
			});
		});
	}
});