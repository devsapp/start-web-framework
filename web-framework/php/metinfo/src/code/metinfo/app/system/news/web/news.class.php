<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('web');

class news extends web
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    public function donews()
    {
        global $_M;

        if ($this->listpage('news') == 'list') {
            //列表页缩略图尺寸
            $_M['config']['met_newsimg_x'] = $this->input['thumb_list_x'];
            $_M['config']['met_newsimg_y'] = $this->input['thumb_list_y'];
            $_M['config']['met_news_list'] = $this->input['list_length'];

            load::sys_class('handle', 'new')->redirectUrl($this->input); //伪静态时动态链接跳转
            $this->view('news', $this->input);
        } else {
            $this->doshownews();
        }
    }

    public function doshownews()
    {
        global $_M;
        $this->showpage('news');

        //详情页缩略图尺寸
        $_M['config']['met_newsdetail_x'] = $this->input['thumb_detail_x'];
        $_M['config']['met_newsdetail_y'] = $this->input['thumb_detail_y'];


        load::sys_class('handle', 'new')->redirectUrl($this->input); //伪静态时动态链接跳转
        $this->view('shownews', $this->input);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
