<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('news/web/news');

class img extends news
{

    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    public function doimg()
    {
        global $_M;
        if ($this->listpage('img') == 'list') {
            //列表页缩略图尺寸
            $_M['config']['met_imgs_x'] = $this->input['thumb_list_x'];
            $_M['config']['met_imgs_y'] = $this->input['thumb_list_y'];
            $_M['config']['met_img_list'] = $this->input['list_length'];

            load::sys_class('handle', 'new')->redirectUrl($this->input); //伪静态时动态链接跳转
            $this->view('img', $this->input);
        } else {
            $this->doshowimg();
        }
    }

    public function doshowimg()
    {
        global $_M;
        $this->showpage('img');
        //详情页缩略图尺寸
        $_M['config']['met_imgdetail_x'] = $this->input['thumb_detail_x'];
        $_M['config']['met_imgdetail_y'] = $this->input['thumb_detail_y'];

        load::sys_class('handle', 'new')->redirectUrl($this->input); //伪静态时动态链接跳转
        $this->view('showimg', $this->input);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
