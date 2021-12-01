<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active=isset($data['head_tab_active'])?$data['head_tab_active']:0;
$admin = admin_information();
if (!strstr($admin['admin_type'],'s1800') && !strstr($admin['admin_type'],'metinfo')){
    $head_tab=array(
        array('title' => $word['myapps'], 'url' => 'myapp/myapp'),
        array('title' => $word['columnmore'],'url'=>$_M['config']['app_url'],'target'=>"1")
    );
}else {
    $head_tab = array();
    $head_tab[] = array('title' => $word['myapps'], 'url' => 'myapp/myapp');
    if ($_M['config']['met_agents_metmsg'] == 1) {
        $head_tab[] = array('title' => $word['freeapp'], 'url' => 'myapp/free');
        $head_tab[] = array('title' => $word['businessapp'], 'url' => 'myapp/business');
        $head_tab[] = array('title' => $word['chargeapp'], 'url' => 'myapp/charge');
        $head_tab[] = array('title' => $word['columnmore'], 'url' => $_M['config']['app_url'], 'target' => "1");
    }
}
$head_tab_ajax = 1;
?>
<include file="pub/head_tab"/>