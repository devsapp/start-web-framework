<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<include file="metinfo.inc.php"/>
<?php $met_page=$template_type=='ui'?'index':''; ?>
<include file="head" page="$met_page"/>
<?php
$url['app_tem']=M_NAME=='pay'||M_NAME=='shop'?'met/':'';
if(file_exists(PATH_OWN_FILE.'templates/'.$url['app_tem'].'css/metinfo.css')){
	$own_metinfo_css_filemtime = filemtime(PATH_OWN_FILE.'templates/'.$url['app_tem'].'css/metinfo.css');
?>
<link href="{$_M['url']['own_tem']}css/metinfo.css?{$own_metinfo_css_filemtime}" rel='stylesheet' type='text/css'>
<?php } ?>