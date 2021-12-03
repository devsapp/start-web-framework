<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 友情链接标签类
 */

class link_label
{

    public $lang;//语言

    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
        $this->lang = $_M['lang'];
    }

    /**
     * 获取友情链接指定条目数据
     * @return array
     */
    public function get_link_list($classnow = '')
    {
        global $_M;

        return load::mod_class('link/link_handle', 'new')->para_handle(
            load::mod_class('link/link_database', 'new')->get_link_list_by_lang($this->lang, 0, 0, '', $classnow)
        );
    }

    /**
     * 获取友情链接字段表单(此功能未开放)
     * @return array         友情链接表单数组
     */
    public function get_link_form()
    {
        global $_M;
        $link_form = array();
        //$link_form['config']['form_url'] = load::mod_class('link/link_handle', 'new')->get_addlink_form_url();
        $link_form['config']['title'] = $_M['word']['ApplyLink'];
        $link_form['config']['class'] = "v52fmbx";
        $link_form['para'][] = array(
            'title' => $_M['word']['OurWebName'],
            'class' => 'ftype_input',
            'html' => $_M['config']['met_linknam'],
        );
        $link_form['para'][] = array(
            'title' => $_M['word']['OurWebLOGO'],
            'class' => 'ftype_input',
            'html' => "<img src='{$_M['config']['met_logo']}' alt='{$_M['word']['OurWebName']}' title='{$_M['word']['OurWebName']}' />",
        );
        $link_form['para'][] = array(
            'title' => $_M['word']['OurWebKeywords'],
            'class' => 'ftype_input',
            'html' => $_M['config']['met_keywords'],
        );
        $link_form['para'][] = array(
            'title' => $_M['word']['OurWebName'],
            'class' => 'ftype_input',
            'html' => $_M['config']['met_linkname'],
        );
        $link_form['para'][] = array(
            'title' => $_M['word']['YourWebName'],
            'class' => 'ftype_input',
            'html' => "<input name='webname' type='text' placeholder='{$_M['word']['YourWebName']}' data-required=1 />",
        );
        $link_form['para'][] = array(
            'title' => $_M['word']['YourWebUrl'],
            'class' => 'ftype_radio',
            'html' => "<label><input name='link_type' type='radio' data-required=1 value='0' checked />{$_M['word']['TextLink']}</label>
			<label><input name='link_type' type='radio' value='1' />{$_M['word']['PictureLink']}</label>",
        );
        $link_form['para'][] = array(
            'title' => $_M['word']['YourWebLOGO'],
            'class' => 'ftype_input',
            'html' => "<input name='weblogo' type='text' placeholder='{$_M['word']['YourWebLOGO']}' value='http://' />",
        );
        $link_form['para'][] = array(
            'title' => $_M['word']['YourWebKeywords'],
            'class' => 'ftype_input',
            'html' => "<input name='info' type='text' placeholder='{$_M['word']['YourWebKeyword']}' value='http://' />",
        );
        $link_form['para'][] = array(
            'title' => $_M['word']['Contact'],
            'class' => 'ftype_textarea',
            'html' => "<textarea name='contact' placeholder='{$_M['word']['Contact']}' /></textarea>",
        );

        return $link_form;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
