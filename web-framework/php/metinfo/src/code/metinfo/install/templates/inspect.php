<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
$disabled='';
echo <<<EOT
-->
<div class="p-4 border">
	<p>检查你的服务器是否支持安装MetInfo|米拓企业建站系统，请在继续安装前消除错误或警告信息。</p>
	<fieldset class="border pb-3 px-3 mt-3">
		<legend class="h6 text-primary w-auto px-1"><strong>环境/函数检测结果</strong></legend>
		<div class="row mb-0">
<!--
EOT;
foreach ($data as $val) {
	!$disabled && $val[1]=='danger' && $disabled='disabled';
echo <<<EOT
-->
			<div class='col-6 my-1'>{$val[0]}<span class="float-right text-{$val[1]}">{$val[2]}</span></div>
<!--
EOT;
}
echo <<<EOT
-->
			<div class="col-12 text-warning mt-1" id='api-check'>检测链接API服务器中....</div>
		</div>
	</fieldset>
	<fieldset class="border pb-3 px-3 mt-3">
		<legend class="h6 text-primary w-auto ml-2 px-1"><strong>文件和目录权限</strong></legend>
		<p style="text-indent:2em" class="mb-2">要能正常使用MetInfo|米拓企业建站系统，需要将几个文件/目录设置为 "可写"。下面是需要设置为"可写" 的目录清单，以及建议的 CHMOD 设置。</p>
		<p style="text-indent:2em">某些主机不允许你设置 CHMOD 777，要用666。先试最高的值，不行的话，再逐步降低该值。</p>
		<div class="row mb-0">
<!--
EOT;
foreach ($dirs as $val) {
	$thisurl=explode('..',$val['dir']);
	!$disabled && $val['status']=='danger' && $disabled='disabled';
echo <<<EOT
-->
			<div class='col-6 my-1'>{$thisurl[1]}<span class="float-right text-{$val['status']}">{$val['msg']}</span></div>
<!--
EOT;
}
echo <<<EOT
-->
		</div>
	</fieldset>
</div>
<div class="text-center mt-3">
	<a href="" class="btn btn-default">重新检查</a>
	<a href="index.php?action=db_setup" class="btn btn-success ml-3 btn-nextprocess $disabled">下一步</a>
</div>
<script language="javascript">
	setTimeout(function(){
		$('.btn-nextprocess').hasClass('disabled')?$('.btn-nextprocess').attr('disabled','1'):$('.btn-nextprocess').addClass('disabled');
		$.ajax({
			url: 'index.php?action=apitest',
			type: 'POST',
			success: function(data) {
				$('#api-check').removeClass('text-warning').addClass('text-'+(data=='ok'?'success':'danger')).html(data=='ok'?'API服务器链接正常，此服务器用于下载应用和在线更新程序':'API服务器链接不正常，无法在线下载应用和更新程序 <a href="https://www.mituo.cn/qa/2471.html" target="_blank">[帮助]</a>');
				data=='ok' && !$('.btn-nextprocess').attr('disabled') && $('.btn-nextprocess').removeClass('disabled');
			}
		});
	},500);
</script>
<!--
EOT;
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
