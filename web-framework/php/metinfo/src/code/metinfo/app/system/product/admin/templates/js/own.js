/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
define(function(require, exports, module) {
	var $ = jQuery = require('jquery');
	var common = require('common');

	if($(".product_index").length)require.async('own_tem/js/product_index');
	if($(".product_add").length)require.async('own_tem/js/product_add');
	if($(".product_para").length)require.async('own_tem/js/product_para');
	if($(".product_shop").length)require.async($(".product_shop").attr('data-url'));
	common.showMoreSet();
});