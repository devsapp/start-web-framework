/*!
 * 招聘模块
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
	$(function(){
		// 招聘模块表单
		$(".met-job-cvbtn").click(function(){
			var $job_modal=$($(this).data('target'));
			$job_modal.find('form input[name="jobid"]').val($(this).data('jobid'));
		});
	});
})();