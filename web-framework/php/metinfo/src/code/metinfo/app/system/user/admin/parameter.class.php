<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
load::sys_class('admin');

/** 会员属性 */
class parameter extends admin
{
    public $database;
    public $module;
    public $table;

    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->module = 10;
        $this->database = load::mod_class('parameter/parameter_database', 'new');
        $this->table = load::sys_class('tabledata', 'new');
    }

    //获取会员属性列表
    public function doGetParaList()
    {
        global $_M;
        $module = $this->module;
        $order = "no_order";
        $para_list = $this->json_para_list('', $order, $module);
        $type_options = $this->para_type();
        $access_options = $this->getAccessOption();

        foreach ($para_list as $key => $val) {
            $choice = "{$val['class1']}-{$val['class2']}-{$val['class3']}";
            $val['class'] = $choice;
            $val['type_options'] = $type_options;
            $val['class_options'] = load::mod_class('base/admin/base_admin', 'new')->class_option($module, $choice);
            $val['access_options'] = $access_options;
            $para_list[$key] = $val;
        }

        $this->table->rdata($para_list);
    }

    //获取选项
    public function doGetOptions()
    {
        global $_M;
        $module = $this->module;

        $data['type_options'] = $this->para_type();
        $data['class_options'] = load::mod_class('base/admin/base_admin', 'new')->class_option($module);
        $data['access_options'] = $this->getAccessOption();
        $this->success($data);
    }

    //会员组内容
    public function getAccessOption()
    {
        global $_M;
        $group = load::sys_class('group', 'new')->get_group_list();
        $list = array();
        $list[] = array('name' => $_M['word']['unrestricted'], 'val' => 0);
        foreach ($group as $key => $val) {
            $arr = array('name' => $val['name'], 'val' => $val['id']);
            $list[] = $arr;
        }
        $val['id'] = $val['id'] + 1;
        $list[] = array('name' => $_M['word']['metadmin'], 'val' => $val['id']);
        return $list;
    }

    //保存属性
    public function doSaveParas()
    {
        global $_M;
        if (!isset($_M['form']['data'])) {
            $this->error();
        }
        $data = $_M['form']['data'];
        $module = $this->module;
        foreach ($data as $value) {
            if (!$value['name']) {
                $this->error($_M['word']['wap_descript5_v6']);
            }
            $value['module'] = $module;
            if (isset($value['class'])) {
                $class = explode('-', $value['class']);
                $value['class1'] = $class[0];
                $value['class2'] = $class[1];
                $value['class3'] = $class[2];
            }
            $value['wr_oks'] = 1;
            $value['edit_ok'] = $value['edit_ok'] ? $value['edit_ok'] : 0;

            if ($value['id'] && is_number($value['id'])) {
                $this->update_para_list($value['id'], $value);
                $log_name = 'save';
            } else {
                $this->insert_para_list($value);
                $log_name = 'added';
            }

        }
        //写日志
        logs::addAdminLog('memberattribute', $log_name, 'jsok', 'doSaveParas');
        buffer::clearData($this->module, $_M['lang']);
        $this->success('', $_M['word']['jsok']);
    }


    /**
     * 修改属性
     * @param string $id 属性id
     * @param array $field 修改的字段
     * @param string $module 模块id
     */
    public function update_para_list($id = '', $field = array())
    {
        global $_M;
        if (!$id) {
            return false;
        }
        $field['id'] = $id;

        $options = $field['options'];

        $pid = array();//用来判断是否删除了值
        foreach ($options as $key => $option) {
            if ($option['id'] && is_numeric($option['id'])) {
                $this->database->update_para_value($option);
                $pid[] = $option['id'];
            } else {
                unset($option['id']);
                $option['module'] = $this->module;
                $option['pid'] = $id;
                // 往para表增加一条数据
                $paraid = $this->database->add_para_value($option);
                $options[$key]['id'] = $paraid;
                $pid[] = $paraid;
            }
        }

        $this->database->delete_para_value($id, $pid);
        if ($options) {
            $field['options'] = jsonencode($options);
        }

        $this->database->update_by_id($field);
    }

    /**
     * 新增属性
     * @param $field array 属性字段
     * @param $module string 模块id
     */
    public function insert_para_list($field = '')
    {
        global $_M;

        $options = $field['options'];
        $field['lang'] = $_M['lang'];

        $pid = $this->database->insert($field);

        foreach ($options as $key => $option) {
            $option['pid'] = $pid;
            $option['module'] = $this->module;
            $id = $this->database->add_para_value($option);
            if ($id) {
                $options[$key]['id'] = $id;
            } else {
                $options[$key]['id'] = 111;
            }

        }
        if ($options) {
            $field['options'] = jsonencode($options);
        }

        $field['id'] = $pid;
        $this->database->update_by_id($field);
        buffer::clearData($this->module, $_M['lang']);
    }

    //删除属性
    public function doDelParas()
    {
        global $_M;
        if (!isset($_M['form']['id'])) {
            $this->error();
        }
        $data = $_M['form']['id'];
        $module = $this->module;
        foreach ($data as $value) {
            if (!$value) {
                continue;
            }

            $this->database->del_by_id($value);
            $this->database->delete_para_value($value);
        }
        //写日志
        logs::addAdminLog('memberattribute', 'delete', 'jsok', 'doDelParas');
        buffer::clearData($this->module, $_M['lang']);
        $this->success('', $_M['word']['jsok']);
    }


    /**
     * 字段类型
     * @param string $id
     * @param string $type (1:简短文本|2:下拉|3:文本|4:多选|5:附件|6:单选|8:电话|9:邮箱|10:链接| 7:城市[弃用])
     * @param string $module
     * @return array
     */
    public function para_type($module = '')
    {
        global $_M;
        $module = intval($module);

        $res = array();
        $res[] = array('name' => $_M['word']['parameter1'], 'val' => 1);
        $res[] = array('name' => $_M['word']['parameter2'], 'val' => 2);
        $res[] = array('name' => $_M['word']['parameter3'], 'val' => 3);
        $res[] = array('name' => $_M['word']['parameter4'], 'val' => 4);
        $res[] = array('name' => $_M['word']['parameter6'], 'val' => 6);

        if (!in_array($module, array(3, 4, 5))) {
            $res[] = array('name' => $_M['word']['parameter8'], 'val' => 8);
            $res[] = array('name' => $_M['word']['parameter9'], 'val' => 9);
        }
        if ($module == 3) {
            $res[] = array('name' => $_M['word']['parameter10'], 'val' => 10);
        }

        if (in_array($module, array(6, 7, 8))) {
            $res[] = array('name' => $_M['word']['parameter5'], 'val' => 5);
        }

        return $res;
    }

    /**
     * 获取栏目属性
     * @param $where string 条件
     * @param $order string 排序
     * @param $module string 模块id
     * @return array
     */
    public function json_para_list($where = '', $order = '', $module = '')
    {
        global $_M;
        $where = "lang='{$_M['lang']}' and module = '{$module}' {$where}";
        $data = $this->database->table_json_list($where, $order);
        foreach ($data as $key => $value) {
            if ($value['type'] == 2 || $value['type'] == 4 || $value['type'] == 6) {
                $paralist = load::mod_class('parameter/parameter_database', 'new')->get_para_values($module, $value['id']);
                $para = array();
                foreach ($paralist as $k => $val) {
                    $para[$k]['id'] = $val['id'];
                    $para[$k]['value'] = $val['value'];
                    $para[$k]['order'] = $val['order'];
                }
                $value['options'] = $para ? $para : '';
            }
            $data[$key] = $value;
        }
        return $data;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
