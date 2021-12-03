<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_tab[0]['title']=$word['cvmanagement'];
$head_tab[1]['title']=$word['cvset'];
$head_tab[2]['title']=$word['indexcv'];
$head_tab[3] = array(
    'title' => $word['jobmanagement'],
    'url' => 'job/position_list/?module=' . $data['module'] . '&class1=' . $data['class1'] . '&class2=' . $data['class2'] . '&class3=' . $data['class3'],
);
?>
<include file="pub/form_head_tab"/>