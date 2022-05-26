<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('web');

class sitemap extends web
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
    }


    public function dositemap()
    {
        global $_M;
        $classnow = $this->input_class();
        $data = load::sys_class('label', 'new')->get('column')->get_column_id($classnow);
        $this->check($data['access']);
        $this->seo($data['name'], $data['keywords'], $data['description']);
        $this->seo_title($data['ctitle']);
        $this->view('sitemap', $this->input);

        #require_once $this->template('tem/sitemap', $this->input);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
