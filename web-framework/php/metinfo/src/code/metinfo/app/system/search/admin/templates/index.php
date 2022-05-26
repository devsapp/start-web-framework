<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active = isset($data['head_tab_active']) ? $data['head_tab_active'] : 0;
$head_tab = array(
    array('title' => $word['mod11'], 'url' => 'search/global/?c=index&a=doGetGlobalSearch'),
    array('title' => $word['column_search'], 'url' => 'search/column/?c=index&a=doGetColumnSearch'),
    array('title' => $word['advanced_search'], 'url' => 'search/advanced/?c=index&a=doGetAdvancedSearch'),
);
$head_tab_ajax=$head_tab_reload = 1;
?>
<include file="pub/head_tab"/>