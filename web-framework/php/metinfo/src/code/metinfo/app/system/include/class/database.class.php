<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 数据库操作共用类.
 */
class database
{
    public $table;
    public $langsql;

    /**
     * 初始化模型编号.
     *
     * @param string $module 模型编号
     * @param string $table 数据表名称
     */
    public function construct($table = '')
    {
        global $_M;
        $this->table = $table;
        $this->langsql = " lang = '{$_M['lang']}' ";
    }

    public function set_lang($lang = '')
    {
        global $_M;
        if ($lang) {
            if ($lang == '#all') {
                $this->langsql = ' 1 = 1 ';
            } else {
                $this->langsql = " lang = '{$lang}' ";
            }
        } else {
            $this->langsql = " lang = '{$_M['lang']}' ";
        }
    }

    public function get_lang($lang = '')
    {
        global $_M;
        if ($lang) {
            if ($lang == '#all') {
                return ' 1 = 1 ';
            } else {
                return " lang = '{$lang}' ";
            }
        } else {
            return " lang = '{$_M['lang']}' ";
        }
    }

    /**
     * 用id取数据.
     *
     * @param string $id
     *
     * @return array 数组
     */
    public function get_list_one_by_id($id = '')
    {
        global $_M;
        $query = "SELECT * FROM {$this->table} WHERE id = '{$id}'";

        return DB::get_one($query);
    }

    /**
     * 用id取数据.
     *
     * @param string $id
     *
     * @return array 数组
     */
    public function get_all($sql = '')
    {
        global $_M;
        $query = "SELECT * FROM {$this->table} WHERE  {$this->langsql} ";
        $query .= $sql;
        return DB::get_all($query);
    }

    /**
     * 更新.
     *
     * @param array $list 需要更新字段
     *
     * @return bool 更新是否成功
     */
    public function update_by_id($list = array())
    {
        $sql = $this->update_sql($list);
        $query = "UPDATE {$this->table} SET $sql WHERE id = '{$list['id']}'";

        return DB::query($query);
    }

    public function update_sql($list = array())
    {
        $sql = '';
        foreach ($list as $key => $val) {
            if ($key != 'id') {
                if ($this->is_para($key)) {
                    $sql .= " $key = '{$val}',";
                }
            }
        }
        $sql = trim($sql, ',');

        return $sql;
    }

    /**
     * 获取列表内容页面数据（产品，图片，下载，新闻模块使用）.
     *
     * @param string $id id
     *
     * @return number 插入的id
     */
    public function insert($list = array())
    {
        global $_M;
        $save_data = array();
        foreach ($list as $key => $val) {
            if ($key != 'id') {
                if ($this->is_para($key)) {
                    $save_data[$key] = $val;
                }
            }
        }

        return DB::insert($this->table, $save_data);
    }

    /**
     * 删除.
     *
     * @param string $id id
     *
     * @return bool 删除是否成功
     */
    public function del_by_id($id = '')
    {
        $query = "DELETE FROM {$this->table} WHERE id = '{$id}'";

        return DB::query($query);
    }

    /**
     * 保存修改sql.
     *
     * @param array $where 条件
     * @param array $order 排序
     *
     * @return bool json数组
     */
    public function table_json_list($where = '', $order = '')
    {
        global $_M;
        $this->tabledata = load::sys_class('tabledata', 'new');
        $data = $this->tabledata->getdata($this->table, '*', $where, $order);

        return $data;
    }

    /**
     * 返回json数据.
     *
     * @param array $data 条件
     */
    public function table_return($data = array())
    {
        global $_M;
        if (!isset($this->tabledata)) {
            $this->tabledata = load::sys_class('tabledata', 'new');
        }
        $this->tabledata->rdata($data);
    }

    public function table_para()
    {
        return false;
    }

    public function is_para($key = '')
    {
        $para_str = $this->table_para();
        if (!$para_str) {
            return true;
        } else {
            if (strstr('|' . $para_str . '|', '|' . $key . '|') && $key != 'id') {
                return true;
            } else {
                return false;
            }
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
