<?php
// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab_active = isset($data['head_tab_active']) ? $data['head_tab_active'] : 0;
$head_tab = array(
    array('title' => $word['safety_efficiency'], 'url' => 'safe/safe','reload'=>1),
    array('title' => $word['database_switch'], 'url' => 'safe/database'),
    array('title' => $word['operation_log'], 'url' => 'safe/logs/?nocommon=1'),
);
$head_tab_ajax = 1;
?>
<div class="met-safe">
    <include file="pub/head_tab" />
</div>