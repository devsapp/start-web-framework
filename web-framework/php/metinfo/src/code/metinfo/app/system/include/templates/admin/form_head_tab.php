<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_ajax=1;
$no_bg=1;
$module_class='module='.$data['module'].'&class1='.$data['class1'].'&class2='.$data['class2'].'&class3='.$data['class3'];
$list_url=$data['module'].'/list/?'.$module_class;
$doclass=$data['module']=='job'?'manage':'admin';
if($data['module']=='feedback'||$data['module']=='job'){
	$list_url.='&c='.$data['module'].'_'.$doclass.'&a=do'.$data['module'].'_info';
}
if($data['module']=='job'){
	$list_url.='&jobid=';
}
$head_tab[0]['url']=$list_url;
$head_tab[1]['url']='parameter/list/?'.$module_class.'&c=parameter_admin&a=doparaset';
$head_tab[2]['url']=$data['module'].'/set/?'.$module_class.'&c='.$data['module'].'_'.$doclass.'&a=dosyset';
if($data['module']=='job'){
	$job_tab=array($head_tab[3]);
	unset($head_tab[3]);
	$head_tab=array_merge($job_tab,$head_tab);
}
?>
<include file="pub/head_tab"/>