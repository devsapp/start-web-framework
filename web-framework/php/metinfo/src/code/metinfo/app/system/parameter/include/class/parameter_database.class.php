<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('database');

/**
 * 字段数据库类
 */

class  parameter_database extends database
{

    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
        $this->construct($_M['table']['parameter']);
    }

    //获取list存放的表
    public function get_plist_table($module)
    {
        global $_M;
        switch ($module) {
            case 7:
                $table = $_M['table']['mlist'];
                break;
            case 8:
                $table = $_M['table']['flist'];
                break;
            case 10:
                $table = $_M['table']['user_list'];
                break;
            default:
                $table = $_M['table']['plist'];
                break;
        }
        return $table;
    }

    /**
     * 获取字段
     * @param  string $lang 语言
     * @param  string $module 模块（3:产品|4:下载|5:图片|6:简历|7:留言|8:反馈|10:会员）
     * @param  string $class1 一级栏目
     * @return array            字段数组
     */
    public function get_list($id = '', $module = '')
    {
        global $_M;
        $para_list = load::mod_class('parameter/parameter_list_database', 'new');
        $para_list->construct($module);
        $plist = $para_list->get_by_listid($id);
        foreach ($plist as $key => $val) {
            $relist[$val['paraid']] = $val;
        }
        return $relist;
    }

    /**
     * 添加
     * @param  string $lang 语言
     * @param  string $module 模块（3:产品|4:下载|5:图片|6:简历|7:留言|8:反馈|10:会员）
     * @param  string $class1 一级栏目
     * @return array            字段数组
     */
    public function insert_list($listid = '', $paraid = '', $info = '', $imgname = '', $module = '')
    {
        global $_M;
        $para_list = load::mod_class('parameter/parameter_list_database', 'new');
        $para_list->construct($module);
        return $para_list->add_para_value($listid, $paraid, $info, $imgname);
    }

    /**
     * 更新内容属性
     * @param string $listid 内容id
     * @param string $paraid 属性id
     * @param string $info 属性值
     * @param string $imgname 属性名称
     * @param string $module 模块（3:产品|4:下载|5:图片|6:简历|7:留言|8:反馈|10:会员）
     * @return mixed
     */
    public function update_list($listid = '', $paraid = '', $info = '', $imgname = '', $module = '')
    {
        global $_M;
        $para_list = load::mod_class('parameter/parameter_list_database', 'new');
        $para_list->construct($module);
        return $para_list->update_by_listid_paraid($listid, $paraid, $info, $imgname);
    }

    /**
     * 按内容id删除属性规格
     * @param string $listid
     * @param string $module
     * @return mixed
     */
    public function del_list($listid = '', $module = '')
    {
        global $_M;
        $para_list = load::mod_class('parameter/parameter_list_database', 'new');
        $para_list->construct($module);
        return $para_list->del_by_listid($listid);
    }

    /**
     * 按内容id 和属性id 删除属性规格
     * @param $listid
     * @param $paraid
     * @param $module
     * @return mixed
     */
    public function delete_list($listid, $paraid, $module)
    {
        $para_list = load::mod_class('parameter/parameter_list_database', 'new');
        $para_list->construct($module);
        return $para_list->delete_list_value($listid, $paraid);
    }

    /**
     * 获取字段
     * @param  string $lang 语言
     * @param  string $module 模块（3:产品|4:下载|5:图片|6:简历|7:留言|8:反馈|10:会员）
     * @param  string $class1 一级栏目
     * @param  string $class2 二级栏目
     * @param  string $class3 三级栏目
     * @return array            字段数组
     */
    public function get_parameter($module = '', $class1 = '', $class2 = '', $class3 = '')
    {
        global $_M;

        //获取指定模块属性
        if (!$class1 && !$class2 && !$class3) {
            $where = "WHERE {$this->langsql} AND module = '{$module}'";
            $query = "SELECT * FROM {$_M['table']['parameter']} {$where} ORDER BY no_order ASC, id DESC ";
            $paras = DB::get_all($query);
            return $paras;
        }

        //获取指点栏目熟悉
        $where = "WHERE {$this->langsql} AND (( module = '{$module}' AND class1 = 0) OR ( module = '{$module}'";
        if ($class1 && is_numeric($class1)) {
            $where .= " AND class1 = '{$class1}' ";
        } else {
            $where .= " AND class1 = '0' ";
        }
        if ($class2 && is_numeric($class2)) {
            $where .= " AND class2 = '{$class2}' ";
        } else {
            $where .= " AND class2 = '0' ";
        }
        if ($class3 && is_numeric($class3)) {
            $where .= " AND class3 = '{$class3}' ";
        } else {
            $where .= " AND class3 = '0' ";
        }
        $where .= " ) ";

        if ($class1 && is_numeric($class1)) {
            $where .= " OR (  module = '{$module}' AND class1 = '{$class1}' AND class2 = 0 AND class3 = 0 )  ";
        }

        if ($class2 && is_numeric($class2)) {
            $where .= " OR (  module = '{$module}' AND class1 = '{$class1}' AND class2 = '{$class2}' AND class3 = 0 )  ";
        }

        if ($class3 && is_numeric($class3)) {
            $where .= " OR (  module = '{$module}' AND class1 = '{$class1}' AND class2 = '{$class2}' AND class3 = '{$class3}' )  ";
        }

        $where .= ')';

        $query = "SELECT * FROM {$_M['table']['parameter']} {$where} ORDER BY no_order ASC, id DESC ";
        $paras = DB::get_all($query);

        return $paras;
    }

    //获取栏目下面的内容,返回内容不包含下级栏目内容

    /**
     * @param string $id 栏目id
     * @return array
     */
    public function get_list_by_class_no_next($id = '')
    {
        global $_M;
        if (is_numeric($id)) {
            $class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($id);
            $module = $class123['class1']['module'];
        } else {
            $module = load::sys_class('handle', 'new')->file_to_mod($id);
        }
        $sql = " {$this->langsql} AND module = '{$module}' ";

        if ($class123['class1']['id']) {
            if ($module == 6 || $module == 7) {
                $sql .= " AND (class1 = '{$class123['class1']['id']}' OR class1 = 0)";
            } else {
                $sql .= " AND class1 = '{$class123['class1']['id']}' ";
            }
        } else {
            $sql .= " AND ( class1 = '' OR class1 = '0' ) ";
        }

        if ($class123['class2']['id']) {
            $sql .= " AND class2 = '{$class123['class2']['id']}' ";
        } else {
            $sql .= " AND ( class2 = '' OR class2 = '0' ) ";
        }

        if ($class123['class3']['id']) {
            $sql .= " AND class3 = '{$class123['class3']['id']}' ";
        } else {
            $sql .= " AND ( class3 = '' OR class3 = '0' ) ";
        }

        $query = "SELECT * FROM {$_M['table']['parameter']} WHERE $sql ";
        return DB::get_all($query);
    }

    public function table_para()
    {
        return 'id|name|options|description|no_order|type|access|wr_ok|class1|class2|class3|module|lang|wr_oks|related|edit_ok';
    }


    /**
     * 获取属性规格
     * @param $module
     * @param $listid
     * @param $paraid
     * @param string $lang
     * @return array|void
     */
    public function get_parameter_value($module, $listid, $paraid, $lang = '')
    {
        global $_M;
        $lang = $lang ? $lang : $_M['lang'];
        $para_list = load::mod_class('parameter/parameter_list_database', 'new');
        $para_list->construct($module);
        $plist = $para_list->select_by_listid_paraid($listid, $paraid);
        return $plist;
    }

    public function get_parameter_by_id($id = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['parameter']} WHERE id = '{$id}'";
        $parameter = DB::get_one($query);
        return $parameter;
    }

    public function get_parameter_type($id = '')
    {
        global $_M;
        $parameter = self::get_parameter_by_id($id);
        return $parameter['type'];
    }

    public function get_para_value($paraid = '', $info = '')
    {
        $type = self::get_parameter_type($paraid);
        if ($type == 2 || $type == 4 || $type == 6) {
            return self::get_parameter_value_by_id($info);
        } else {
            return $info;
        }
    }

    public function get_parameter_value_by_id($id = '')
    {
        global $_M;
        $query = "SELECT `value` FROM {$_M['table']['para']} WHERE id = '{$id}'";
        $para = DB::get_one($query);
        return $para['value'];
    }

    public function update_para_value($option = '')
    {
        global $_M;
        $query = "UPDATE {$_M['table']['para']} SET value = '{$option['value']}',`order`='{$option['order']}' WHERE id = {$option['id']}";
        $row = DB::query($query);
        return $row;
    }

    /**
     * 获取属性选项
     * @param string $module 模块
     * @param string $pid 属性id
     * @return array
     */
    public function get_para_values($module = '', $pid = '', $lang = '')
    {
        global $_M;
        $lang = $lang ? $lang : $_M['lang'];
        $query = "SELECT * FROM {$_M['table']['para']} WHERE pid = '{$pid}' AND module = '{$module}' AND lang = '{$lang}' ORDER BY `order` ASC";
        return DB::get_all($query);
    }

    public function add_para_value($option = '', $lang = '')
    {
        global $_M;
        $lang = $lang ? $lang : $_M['lang'];
        $query = "SELECT * FROM {$_M['table']['para']} WHERE pid = {$option['pid']} AND value='{$option['value']}' AND module = {$option['module']} AND lang = '{$lang}'";
        $para = DB::get_one($query);

        if ($para) {
            return false;
        }

        $query = "INSERT INTO {$_M['table']['para']} SET pid = {$option['pid']},module = '{$option['module']}',`order`='{$option['order']}',value='{$option['value']}',lang='{$lang}'";
        $res = DB::query($query);

        if ($res) {
            return DB::insert_id();
        }
        return false;
    }

    public function delete_para_value($pid = '', $pids = array())
    {
        global $_M;
        if (!empty($pids)) {
            $paraid = implode(',', $pids);
            $query = "DELETE FROM {$_M['table']['para']} WHERE id NOT IN ($paraid) AND pid = {$pid}";
            return DB::query($query);
        } else {
            $query = "DELETE FROM {$_M['table']['para']} WHERE pid = {$pid}";
            return DB::query($query);
        }

    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
