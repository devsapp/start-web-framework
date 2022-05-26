<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 基础标签类
 */

class tag_label
{

    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
        $this->lang = $_M['lang'];
    }

    /**
     * 共用list标签
     * @param  string $mod 模块名称或id
     * @param  string $num 数量
     * @param  string $type com/news/all
     */
    public function get_list($mod, $num, $type, $order, $para = 0)
    {//新增字段调用参数
        global $_M;
        if (is_numeric($mod)) {
            $c = load::sys_class('label', 'new')->get('column')->get_column_id($mod);
            $module = load::sys_class('handle', 'new')->mod_to_file($c['module']);
        } else {
            $module = $mod;
        }
        if (load::sys_class('handle', 'new')->file_to_mod($module)) {
            if (in_array($module, array('feedback', 'member', 'sitemap', 'tags'))) {
                return false;
            }
            if (method_exists(load::sys_class('label', 'new')->get($module), 'get_module_list')) {
                return load::sys_class('label', 'new')->get($module)->get_module_list($mod, $num, $type, $order, $para);
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    /**
     * 共用page分页
     * @param  string $mod 模块名称或id
     * @param  string $page 分页
     */
    public function get_page($mod, $page)
    {
        global $_M;
        if (is_numeric($mod)) {
            $c = load::sys_class('label', 'new')->get('column')->get_column_id($mod);
            $module = load::sys_class('handle', 'new')->mod_to_file($c['module']);
        } else {
            $module = $mod;
        }
        if (load::sys_class('handle', 'new')->file_to_mod($module)) {
            if (in_array($module, array('feedback', 'member', 'sitemap', 'tags'))) {
                return false;
            }
            if (method_exists(load::sys_class('label', 'new')->get($module), 'get_list_page')) {
                return load::sys_class('label', 'new')->get($module)->get_list_page($mod, $page);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 分页按钮
     * @param string $classnow
     * @param string $pagenow
     * @param string $page_type
     * @return bool
     */
    public function get_page_html($classnow = '', $pagenow = '', $page_type = '')
    {
        global $_M;
        if (is_numeric($classnow)) {
            $c = load::sys_class('label', 'new')->get('column')->get_column_id($classnow);
            $module = load::sys_class('handle', 'new')->mod_to_file($c['module']);
        } else {
            $module = $classnow;
        }
        if (load::sys_class('handle', 'new')->file_to_mod($module)) {
            if (in_array($module, array('feedback', 'member', 'sitemap', 'tags'))) {
                return false;
            }
            if (method_exists(load::sys_class('label', 'new')->get($module), 'get_list_page_html')) {
                return load::sys_class('label', 'new')->get($module)->get_list_page_html($classnow, $pagenow, $page_type);
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param $classnow
     * @param $pagenow
     * @return bool
     */
    public function get_page_select($classnow, $pagenow)
    {
        global $_M;
        if (is_numeric($classnow)) {
            $c = load::sys_class('label', 'new')->get('column')->get_column_id($classnow);
            $module = load::sys_class('handle', 'new')->mod_to_file($c['module']);
        } else {
            $module = $classnow;
        }
        if (load::sys_class('handle', 'new')->file_to_mod($module)) {
            if (method_exists(load::sys_class('label', 'new')->get($module), 'get_list_page_select')) {
                return load::sys_class('label', 'new')->get($module)->get_list_page_select($classnow, $pagenow);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 搜索模块获取列表页面url
     * @param  string $mod 栏目id
     * @param  string $page 当前分页
     */
    public function get_list_page_url($classnow, $pagenow)
    {
        global $_M;
        if (is_numeric($classnow)) {
            $c = load::sys_class('label', 'new')->get('column')->get_column_id($classnow);
            $module = load::sys_class('handle', 'new')->mod_to_file($c['module']);
        } else {
            $module = $classnow;
        }
        if (load::sys_class('handle', 'new')->file_to_mod($module)) {
            if (method_exists(load::sys_class('label', 'new')->get($module), 'get_page_url')) {
                $pageinfo = load::sys_class('label', 'new')->get($module)->get_page_url($classnow, 1);
                return load::sys_class('label', 'new')->get($module)->handle->replace_list_page_url($pageinfo, $url);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
