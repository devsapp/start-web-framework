<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$table_order = $table_order ? $table_order : $data['module'] . '-list';
$pagelength = $pagelength ? $pagelength : 20;
$class_name = $class_name ? $class_name : $data['module'] . '_admin';
$table_ajaxurl = $table_ajaxurl ? $table_ajaxurl : $url['own_name'] . 'c=' . $class_name . '&a=dojson_list';
$form_action = $form_action ? $form_action : $url['own_name'] . 'c=' . $class_name . '&a=dolistsave';
?>
<form method="POST" action="{$form_action}" data-submit-ajax='1'>
	<table class="table table-hover dataTable w-100 <if value="!$search_right">mt-2</if>" id="{$table_order}" data-ajaxurl="{$table_ajaxurl}" data-plugin="checkAll" data-datatable_order="#{$table_order}" data-table-pageLength="{$pagelength}">
		<thead>
			<tr>