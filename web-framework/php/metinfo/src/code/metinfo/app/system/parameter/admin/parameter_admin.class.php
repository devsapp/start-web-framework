<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/admin/base_admin');

class parameter_admin extends base_admin
{
    /**
     * 初始化
     */

    function __construct()
    {
        global $_M;
        parent::__construct();
        $this->database = load::mod_class('parameter/parameter_database', 'new');
    }

    /*产品参数设置*/
    function doparaset()
    {
        global $_M;
        if (!is_numeric($_M['form']['module'])) {
            $module = load::sys_class('handle', 'new')->file_to_mod($_M['form']['module']);
        } else {
            $module = $_M['form']['module'];
        }
        $data['class2'] = $_M['form']['class2'] ? $_M['form']['class2'] : 0;
        $data['class3'] = $_M['form']['class3'] ? $_M['form']['class3'] : 0;
        $data['module_value'] = $module;
        $data['type_options'] = $this->para_type(1, $module);
        $data['class_options'] = $this->class_option($module, $_M['form']['class1'] . '-' . $data['class2'] . '-' . $data['class3']);
        if ($_M['form']['module'] != 'feedback') {
            $data['class_name'] = $data['class_options'][0]['name'];
        }
        $data['access_options'] = $this->access_option();

        return $data;
    }

    public function doparasave()
    {
        global $_M;
        $redata = array();

        $rs = $this->table_para($_M['form'], $module = $_M['form']['module']);

        $redata['status'] = 1;
        $redata['msg'] = $_M['word']['jsok'];
        $this->ajaxReturn($redata);
    }

    /**
     * 获取栏目参数列表
     */
    function dojson_para_list()
    {
        global $_M;
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $class2 = is_numeric($_M['form']['class2']) ? $_M['form']['class2'] : '';
        $class3 = is_numeric($_M['form']['class3']) ? $_M['form']['class3'] : '';
        $classnow = $class3 ? $class3 : ($class2 ? $class2 : $class1);
        $module = $_M['form']['module'];

        $order = "no_order";
        $where = '';
        switch ($module) {
            case 6:
                $where .= $class1 ? " AND (class1 = '{$class1}' OR class1 = '0')" : " AND class1 = 0";
                $where .= $class2 ? " AND (class2 = '{$class2}' OR class2 = '0')" : " AND class2 = 0";
                $where .= $class3 ? " AND (class3 = '{$class3}' OR class3 = '0')" : " AND class3 = 0";
                break;
            case 8:
                $where = " AND (class1 = '{$class1}' OR class1 = '0')";
                break;
            default:
                $where = '';
                break;
        }

        $paralist = $this->json_para_list($where, $order, $module);

        foreach ($paralist as $key => $val) {
            $choice = "{$val['class1']}-{$val['class2']}-{$val['class3']}";
            $val['value'] = $choice;

            $list = array();
            $list['id'] = $val['id'];
            $list['name'] = $val['name'];
            $list['description'] = $val['description'];
            $list['no_order'] = $val['no_order'];
            $list['type'] = $val['type'];
            $list['type_options'] = $this->para_type($val['type'], $module);
            $list['class'] = $choice;
            $list['class_options'] = $this->class_option($module, $choice);
            $list['access'] = $val['access'];
            $list['access_options'] = $this->access_option();
            $list['related_columns'] = $val['related_columns'];
            $list['related'] = $val['related'];
            if (in_array($val['type'], array(2, 4, 6))) {
                $list['options'] = $val['options'];
            }
            if (!in_array($module, array(3, 4, 5))) {
                $list['wr_ok'] = $val['wr_ok'];
            }

            /*if (!in_array($module, array(3, 4, 5))) {
                $list['wr_oks'] = $val['wr_oks'];
            }*/

            $rarray[] = $list;
        }
        $this->json_return($rarray);
    }

    /**
     * 添加属性参数
     */
    public function doparaaddlist()
    {
        global $_M;
        $class1 = is_numeric($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $class2 = is_numeric($_M['form']['class2']) ? $_M['form']['class2'] : '';
        $class3 = is_numeric($_M['form']['class3']) ? $_M['form']['class3'] : '';
        $module = $_M['form']['module'];

        $redata = array();
        $choice = "{$class1}-{$class2}-{$class3}";
        $redata['data']['para_type'] = $this->para_type('', $_M['form']['module']);
        $redata['data']['access'] = $this->access_option();
        $redata['data']['column_options'] = $this->class_option($module, $choice);
        $this->ajaxReturn($redata);
    }

//===========================================

    /**
     * 属性类型
     * @param string $type (1:简短文本|2:下拉|3:文本|4:多选|5:附件|6:单选|8:电话|9:邮箱|10:链接| 7:城市[弃用]) 默认选中类型
     * @param string $module 模块类型
     * @return array
     */
    public function para_type($type = '', $module = '')
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

        if (in_array($module, array(4, 6, 7, 8))) {
            $res[] = array('name' => $_M['word']['parameter5'], 'val' => 5);
        }

        /*foreach ($res as $key => $row) {
            if ($row['val'] == $type) {
                $res[$key]['checked'] = 1;
            }
        }*/
        return $res;
    }

    /**
     * 获取栏目属性
     * @param $where
     * @param $order
     * @param $module
     * @return array
     */
    public function json_para_list($where = '', $order = '', $module = '')
    {
        global $_M;
        $where = " lang='{$_M['lang']}' AND module = '{$module}' {$where}";
        $data = $this->database->table_json_list($where, $order);
        foreach ($data as $key => $value) {

            if ($value['type'] == 2 || $value['type'] == 4 || $value['type'] == 6) {
                $paralist = $this->database->get_para_values($module, $value['id']);
                $para = array();
                foreach ($paralist as $k => $val) {
                    $para[$k]['id'] = $val['id'];
                    $para[$k]['value'] = $val['value'];
                    $para[$k]['order'] = $val['order'];
                }
                $value['options'] = $para ? json_encode($para) : '';
            }

            $datalist[] = $value;
        }

        foreach ($datalist as $key => $val) {
            //属性类型列表
            $val['paratype_options'] = $this->para_type($val['type'], $module);
            //反馈关联产品
            $met_fd_related = load::mod_class('config/config_op', 'new')->getColumnConf($_M['form']['class1'], 'met_fd_related');
            if (($val['type'] == 2 || $val['type'] == 4 || $val['type'] == 6) && $module == 8 && $val['id'] == $met_fd_related) {
                $product_option = $this->class_option(3, $val['related']);
                foreach ($product_option as $key => $class) {
                    $product_option[0]['name'] = $_M['word']['associated_columns'];
                }
                #$val['related_columns'] = $this->class_option(3, $val['related']);
                $val['related_columns'] = $product_option;
            }
            $datas[] = $val;
        }
        return $datas;
    }

    public function json_return($data)
    {
        global $_M;
        //$this->table->rdata($data);
        $this->database->tabledata->rdata($data);
    }

    public function table_para($form = array(), $module = '')
    {
        global $_M;
        $list = explode(",", $form['allid']);
        foreach ($list as $id) {
            if ($id) {
                if ($form['submit_type'] == 'save') {
                    $info = array();
                    if ($form['class-' . $id]) {
                        $class = explode("-", $form['class-' . $id]);
                        $info['class1'] = $class[0];
                        $info['class2'] = $class[1];
                        $info['class3'] = $class[2];
                    }
                    $info['no_order'] = $form['no_order-' . $id] ?: 0;
                    $info['name'] = $form['name-' . $id];
                    $info['type'] = $form['type-' . $id];
                    //$info['wr_oks']   	 = $form['wr_oks-'.$id];
                    $info['wr_oks'] = 1;
                    $info['wr_ok'] = $form['wr_ok-' . $id];
                    $info['description'] = $form['description-' . $id];
                    $info['options'] = $info['type'] == 2 || $info['type'] == 4 || $info['type'] == 6 ? $form['options-' . $id] : '';
                    $info['module'] = $module;
                    $info['access'] = $form['access-' . $id];
                    $info['related'] = $form['related-' . $id];
                    if (is_number($id)) {
                        $this->update_para_list($id, $info, $module);
                    } else {
                        $this->insert_para_list($info, $module);
                    }
                } elseif ($form['submit_type'] == 'del') {
                    if (is_number($id)) {
                        $this->del_para_list($id, $module);
                    }
                }
            }
        }
        return true;
    }

    /**
     * 修改属性
     * @param string $id
     * @param array $field
     * @param string $module
     */
    public function update_para_list($id = '', $field = array(), $module = '')
    {
        global $_M;

        $field['id'] = $id;

        $options = json_decode(stripslashes($field['options']), true);

        $pid = array();//用来判断是否删除了值
        foreach ($options as $key => $option) {
            if (is_numeric($option['id'])) {
                $row = $this->database->update_para_value($option);
                $pid[] = $option['id'];
            } else {
                unset($option['id']);
                $option['module'] = $module;
                $option['pid'] = $id;
                // 往para表增加一条数据
                $paraid = $this->database->add_para_value($option);
                $options[$key]['id'] = $paraid;
                $pid[] = $paraid;
            }
        }

        $this->database->delete_para_value($id, $pid);

        $field['options'] = jsonencode($options);
        $this->database->update_by_id($field);

        cache::del("para/paralist_{$module}_{$_M['lang']}");
    }

    /**
     * 新增属性
     * @param $field
     * @param $module
     */
    public function insert_para_list($field = '', $module = '')
    {
        global $_M;

        $options = json_decode(stripslashes($field['options']), true);
        $field['lang'] = $_M['lang'];

        $pid = $this->database->insert($field);

        foreach ($options as $key => $option) {
            $option['pid'] = $pid;
            $option['module'] = $module;
            $id = $this->database->add_para_value($option);
            if ($id) {
                $options[$key]['id'] = $id;
            } else {
                $options[$key]['id'] = 111;
            }

        }

        $field['options'] = jsonencode($options);
        $field['id'] = $pid;
        $this->database->update_by_id($field);
        cache::del("para/paralist_{$module}_{$_M['lang']}");
    }

    public function del_para_list($id = '', $module = '')
    {
        global $_M;
        if (is_number($id)) {
            $this->database->del_by_id($id);
            $this->database->delete_para_value($id);
            cache::del("para/paralist_{$module}_{$this->lang}");
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
