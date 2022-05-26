<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('web');

class search extends web
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
    }
    
    public function dosearch()
    {
        global $_M;
        $classnow = $this->input_class();
        $_M['config']['met_search_list'] = $this->input['list_length'];
        $data = load::sys_class('label', 'new')->get('column')->get_column_id($classnow);
        $this->check($data['access']);

        if ($_M['form']['searchword']) {
            if (!preg_match('/^[<0-9a-zA-Z\x{4e00}-\x{9fa5}-\+_>\s]+$/u', $_M['form']['searchword'])) {
                $_M['form']['searchword'] = '';
            }
            if ($_M['form']['search'] != 'tag') {
                $_M['form']['search'] = 'search';
            } else {
                $_M['form']['searchword'] = load::sys_class('label', 'new')->get('tags')->getTagName($_M['form']['searchword']);
            }
            $this->seo($_M['form']['searchword'], $data['keywords'], $data['description']);
        } else {
            $this->seo($data['name']);
        }
        $this->seo_title($data['ctitle']);

        load::sys_class('handle', 'new')->redirectUrl($this->input);
        $this->add_input('searchword', $_M['form']['searchword']);

        $this->view('search', $this->input);

    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
