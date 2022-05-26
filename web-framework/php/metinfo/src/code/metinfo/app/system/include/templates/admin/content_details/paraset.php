<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<h3 class='example-title'>
	<span class='d-inline-block' style="width:146px;">{$word.parameter}</span>
	<button type="button" class="btn btn-outline-primary btn-paraset" data-toggle="modal" data-target=".content-para-manage-modal" data-modal-title="{$word.parmanage}" data-modal-url="parameter/list/?c=parameter_admin&a=doparaset&module={$data.n}&id={$data.list.id}" data-modal-size="xl" data-modal-fullheight="1" data-modal-oktext="" data-modal-notext="{$word.close}">{$word.parmanage}</button>
	<button type="button" class="btn btn-outline-primary btn-content-para-refresh ml-2">
		<i class="fa-refresh mr-1"></i>
		{$word.refresh}
	</button>
</h3>
<div class="content-details-paralist" data-url="{$url.own_name}c={$data.n}_admin&a=dopara&id={$data.list.id}&class1={$data.list.class1}&class2={$data.list.class2}&class3={$data.list.class3}"></div>