<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active=isset($data['head_tab_active'])?$data['head_tab_active']:0;
$head_tab=array(
	array('title'=>"商业模板",'url'=>'app/met_template/ui'),
	array('title'=>"其他模板",'url'=>'app/met_template/other'),

);
if ($_M['config']['met_agents_metmsg'] == 1) {
    $head_tab[] = array('title' => "更多模板", 'url' => $_M['config']['templates_url'], 'target' => true);
}
$head_tab_ajax = 1;
?>
<include file="pub/head_tab" />