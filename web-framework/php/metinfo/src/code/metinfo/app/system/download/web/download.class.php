<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('news/web/news');

class download extends news
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    public function dodownload()
    {
        global $_M;

        if ($this->listpage('download') == 'list') {
            $_M['config']['met_download_list'] = $this->input['list_length'];

            load::sys_class('handle', 'new')->redirectUrl($this->input); //伪静态时动态链接跳转
            $this->view('download', $this->input);
        } else {
            $this->doshowdownload();
        }
    }

    public function doshowdownload()
    {
        global $_M;
        $this->showpage('download');
        load::sys_class('handle', 'new')->redirectUrl($this->input); //伪静态时动态链接跳转
        $this->view('showdownload', $this->input);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
