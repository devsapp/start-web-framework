/* 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved. */
define(function(require, exports, module) {

	var $ = jQuery = require('jquery');
	var common = require('common');

	$(document).on('change',"select.paratype",function(){
		var value = $(this).val();
		if(value==2||value==4||value==6){
			$(this).parents("tr").find("button").removeClass("none");
		}else{
			$(this).parents("tr").find("button").addClass("none");
		}
	});

	$(document).on('click',"button.paraoption",function(){
		var md = $('#myModal'),id = $(this).data('id');
		md.find(".modal-body dt").html($("input[name='name-"+id+"']").val());
		md.find(".modal-body dd .fbox").html('<input name="options" data-inname="options-'+id+'" type="hidden" data-label="$|$" value="'+$("input[name='options-"+id+"']").val()+'">');
		common.AssemblyLoad(md);
		md.modal('toggle');
	});

	$(document).on('click',"#myModal button.btn-primary",function(){
		var option = $("#myModal").find("input[name='options']"),name = $("input[name='"+option.data('inname')+"']");
		name.val(option.val());
		name.parents("tr").find("input[name='id']").attr("checked",true);
		$('#myModal').modal('hide');
	});

});