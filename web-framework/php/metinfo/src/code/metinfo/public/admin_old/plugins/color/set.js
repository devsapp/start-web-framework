define(function(require, exports, module) {

	var common = require('common');
	require('plugins/minicolors/jquery.minicolors.min.css');
	require('plugins/minicolors/jquery.minicolors.min');
	exports.func = function(d){
		d.find('.ftype_color .fbox input').minicolors();
	}
});