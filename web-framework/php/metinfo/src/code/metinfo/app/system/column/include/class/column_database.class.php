<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('database');

/**
 * 系统标签类
 */

class column_database extends database
{

    /**
     * 初始化，继承类需要调用
     */
    public function __construct()
    {
        global $_M;
        $this->construct($_M['table']['column']);
    }

    public function table_para()
    {
        return 'name|foldername|filename|bigclass|samefile|module|no_order|wap_ok|wap_nav_ok|if_in|nav|ctitle|keywords|content|description|list_order|new_windows|classtype|out_url|index_num|access|indeximg|columnimg|isshow|lang|namemark|releclass|display|icon|nofollow|other_info|custom_info|text_size|text_color|thumb_list|thumb_detail|list_length|tab_name|tab_num';
    }

    /**
     * 为字段赋值
     * @param  string $lang 语言
     * @return array          栏目数组
     */
    public function get_all_column_by_lang($lang = '')
    {
        global $_M;
        $langsql = $this->get_lang($lang);
        $query = "SELECT * FROM {$this->table} WHERE {$langsql} ORDER BY no_order ASC, id DESC";
        $data = DB::get_all($query);

        if (defined('IN_ADMIN')) {
            $handle = load::sys_class('handle', 'new');
            foreach ($data as $key => $val) {
                $mod_name = $handle->mod_to_name($val['module']);
                $query = "SELECT parent_name,ui_name FROM {$_M['table']['ui_list']} WHERE ui_page = '{$mod_name}'";
                $uilist = DB::get_all($query);
                foreach ($uilist as $ui) {
                    $config = @file_get_contents(PATH_WEB . 'templates/' . $_M['config']['met_skin_user'] . '/ui/' . $ui['parent_name'] . '/' . $ui['ui_name'] . '/config.json');
                    if ($config) {
                        $uiconfig = json_decode($config, true);
                        if (isset($uiconfig['style'])) {
                            foreach ($uiconfig['style'] as $k => $v) {
                                $data[$key]['column_style'][$k] = $v;
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }

    public function get_column_by_id($id, $lang = '')
    {
        global $_M;
        $langsql = $this->get_lang($lang);
        $query = "SELECT * FROM {$this->table} WHERE {$langsql} AND id='{$id}' ";
        return DB::get_one($query);
    }

    public function get_column_by_filename($filename, $lang = '')
    {
        global $_M;
        $langsql = $this->get_lang($lang);
        $query = "SELECT * FROM {$this->table} WHERE {$langsql} AND filename='{$filename}'";
        return DB::get_one($query);
    }

    public function get_column_by_foldername($foldername, $lang = '')
    {
        global $_M;
        $langsql = $this->get_lang($lang);
        $query = "SELECT * FROM {$this->table} WHERE {$langsql} AND foldername='{$foldername}'";
        return DB::get_all($query);
    }

    public function get_column_by_module($module, $lang = '')
    {
        global $_M;
        $langsql = $this->get_lang($lang);
        $query = "SELECT * FROM {$_M['table']['column']} WHERE {$langsql} AND module='{$module}'";

        return DB::get_all($query);
    }

    public function get_first_column_by_module($module, $lang = '')
    {
        global $_M;
        $langsql = $this->get_lang($lang);
        $sql = "SELECT * FROM {$_M['table']['column']} WHERE  {$langsql} AND module = '{$module}' ORDER BY no_order";
        return DB::get_one($sql);
    }

    public function get_column_by_bigclass($bigclass, $lang = '')
    {
        global $_M;
        $langsql = $this->get_lang($lang);
        $query = "SELECT * FROM {$_M['table']['column']} WHERE {$langsql} AND bigclass='{$bigclass}'";

        return DB::get_all($query);
    }

    public function search_column($type = '', $lang ='', $mod = '' )
    {
        global $_M;
        $fields = array('name', 'ctitle', 'keywords', 'content', 'description');
        if (isset($type['title'])) {
            $type['name'] = $type['title'];
        }

        $search = array();
        foreach ($fields as $val) {
            if ($type[$val]['status'] && is_string($type[$val]['info']) && $type[$val]['info'] != '') {
                $search []= " {$val} like '%{$type[$val]['info']}%' ";
            }
        }


        $langsql = $this->get_lang($lang);
        $sql = "SELECT * FROM {$this->table} WHERE {$langsql} AND ";

        if (is_numeric($mod)) {
            $sql .= " module = '{$mod}' ";
        }

        if ($search) {
            $search_sql = ' AND (';
            $search_sql .= implode(' OR ', $search);
            $search_sql .= ') ';
            $sql .= $search_sql;
        }

        $sql .= "ORDER BY no_order ASC, id DESC";
        $data = DB::get_all($sql);
        return $data;
    }

    /*更新表数据*/
    public function up_table_data($table, $where)
    {
        global $_M;
        $query = "UPDATE {$table} {$where}";
        $result = DB::query($query);
        return $result;
    }

    /*删除表数据*/
    public function del_table_data($table, $where)
    {
        global $_M;
        $query = "delete from {$table} {$where}";
        DB::query($query);
    }

    /*获取数据*/
    public function getdata($table, $where, $type)
    {
        global $_M;
        $query = "select * from {$table} {$where}";
        if ($type) {
            $user = DB::get_one($query);
        } else {
            $user = DB::get_all($query);
        }

        return $user;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.; # Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
