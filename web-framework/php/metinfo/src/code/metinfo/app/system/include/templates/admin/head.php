<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$_M['form']['target'] && $body_class.=' p-3';
if(!$_M['form']['notab']){
	// 兼容老框架选项卡页面调用方法
	$head_tab = nav::get_nav();
	foreach ($head_tab as $key => $value) {
		$value['classnow'] && $head_tab_active=$key;
		$head_tab[$key]['target']=$value['target']=='_self'?0:1;
	}
}
?>
<include file="pub/header"/>
<?php
if(file_exists(PATH_OWN_FILE.'templates/css/'.$_M['form']['n'].'.css')){
    $own_css_filemtime = filemtime(PATH_OWN_FILE.'templates/css/'.$_M['form']['n'].'.css');
?>
<link href="{$url.own_tem}css/{$_M['form']['n']}.css?{$own_css_filemtime}" rel='stylesheet' type='text/css'>
<?php } ?>
<if value="$head_tab">
<include file="pub/head_tab"/>
</if>