<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * parameter标签类
 */

class parameter_label
{

    public $lang;

    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
        $this->parameter_database = load::mod_class('parameter/parameter_database', 'new');
    }

    public function name_to_num($module)
    {
        switch ($module) {
            case 'product':
                $mod = 3;
                break;
            case 'download':
                $mod = 4;
                break;
            case 'img':
                $mod = 5;
                break;
            case 'message':
                $mod = 7;
                break;
            case 'job':
                $mod = 6;
                break;
            case 'feedback':
                $mod = 8;
                break;
        }
        return $mod;
    }

    public function get_para($module, $class1, $class2)
    {
        $mod = is_numeric($module) ? $module : $this->name_to_num($module);
        return load::mod_class('parameter/parameter_database', 'new')->get_parameter($mod, $class1, $class2);
    }

    /**
     * 获取字段提交表单，前台留言，反馈，招聘模块使用
     * @param string $module 表单模块类型(feedback, message, job)
     * @param string $class1 一级栏目
     * @param string $class2 二级栏目
     * @param string $class3 三级栏目
     * @return array
     */
    public function get_parameter_form($module = '', $class1 = '', $class2 = '', $class3 = '')
    {
        global $_M;
        $classnow = $class3 ? $class3 : ($class2 ? $class2 : $class1);
        $mod = $this->name_to_num($module);
        $parameter_database = load::mod_class('parameter/parameter_database', 'new');
        $parameter = $parameter_database->get_parameter($mod, $class1, $class2, $class3);
        $userclass = load::sys_class('user', 'new');

        $parameter_list = array();
        foreach ($parameter as $key => $row) {
            $list = $parameter_database->get_para_values($mod, $row['id']);
            $row['para_list'] = $list;
            //属性权限检测
            $power = $userclass->check_power($row['access']);
            if ($power > 0) {
                $parameter_list[] = $row;
            }
        }

        $paras = load::mod_class('parameter/parameter_handle', 'new')->para_handle_formation($parameter_list);
        return $paras;
    }

    /**
     * 获取字段内容，前台产品，图片，下载模块使用
     * @param  string $module 表单模块类型(feedback, message, job)
     * @param  number $id 一级栏目
     * @return array            表单数组
     */
    public function get_parameter_contents($module, $id, $class1, $class2, $class3, $type = 0)
    {
        global $_M;
        $mod = $this->name_to_num($module);
        $parameter_database = load::mod_class('parameter/parameter_database', 'new');
        $parameter = $parameter_database->get_parameter($mod, $class1, $class2, $class3);
        $list = $parameter_database->get_list($id, $mod);
        $userclass = load::sys_class('user', 'new');

        $relist = array();
        foreach ($parameter as $key => $val) {
            //参数权限控制
            if ($_M['config']['access_type'] == 2) {
                $power = $userclass->check_power($val['access']);
                if ($power < 0) {
                    continue;
                }
            }

            if ($type) {
                if ($val['type'] != $type) {
                    continue;
                }
            } else {
                //链接类型
                if ($val['type'] == 10) {
                    continue;
                }
            }

            if (
                ($val['class1'] == 0) ||
                ($val['class1'] == $class1 && $val['class2'] == 0) ||
                ($val['class1'] == $class1 && $val['class2'] == $class2 && $val['class3'] == 0) ||
                ($val['class1'] == $class1 && $val['class2'] == $class2 && $val['class3'] == $class3)
            ) {
                if ($val['type'] == 5) {//附件
                    if ($list[$val['id']]['info']) {
                        $url = load::sys_class('handle', 'new')->url_transform($list[$val['id']]['info']);
                        $value = "<a target='_blank' href='{$url}'>{$_M['word']['downloadtext1']}</a>";
                    } else {
                        $value = '';
                    }
                } elseif ($val['type'] == 2 || $val['type'] == 4 || $val['type'] == 6) {//单选、多选、下拉
                    $value = '';
                    $info = $list[$val['id']]['info'];
                    $para_ids = array();
                    if (strstr($info, ',')) {
                        $para_ids = explode(',', $info);
                    } else {
                        $para_ids[] = $info;
                    }
                    foreach ($para_ids as $para_id) {
                        $para_value = $parameter_database->get_parameter_value_by_id($para_id);
                        if ($para_value) {
                            $value .= "," . $para_value;
                        }
                    }
                    $value = trim($value, ',');
                } else {
                    $value = $list[$val['id']]['info'];
                }

                $value = trim($value, ',');
                $para = array();
                $para['id'] = $val['id'];
                $para['name'] = $val['name'];
                if ($val['type'] == 10) {
                    $para['value'] = $val['access'] ? $userclass->check_power_link($value, $val['access']) : $value;
                } else {
                    $para['value'] = $val['access'] ? $userclass->check_power_script($value, $val['access']) : $value;
                }

                $relist[] = $para;
            }
        }

        if ($type == 10) {
            $feedback = load::mod_class('feedback/feedback_database', 'new');
            //在线询价
            $inquiry = $feedback->get_inquiry();
            if ($inquiry) {
                $fd_column = load::mod_class('column/column_database', 'new')->get_column_by_id($inquiry['columnid']);

                $one_title = '';
                if ($id) {
                    $mod_db_class = $this->database = load::mod_class($module . '/' . $module . '_database', 'new');
                    if (method_exists($mod_db_class, 'get_list_one_by_id')) {
                        $one_data = $mod_db_class->get_list_one_by_id($id);
                    }
                    $one_title = urlencode($one_data['title']);
                }

                $para = array();
                $para['id'] = 0;
                $para['name'] = $_M['word']['feedbackinquiry'];
                $para['value'] = $_M['url']['web_site'] . "{$fd_column['foldername']}/index.php?fdtitle={$one_title}&lang={$_M['lang']}";

                $relist[] = $para;
            }
        }
        return $relist;
    }


    /**
     * 获取字段搜索sql语句
     * @param  string $module 模块类型
     * @param  string /array  $info    被搜索信息
     * @return string                 sql语句
     */
    public function get_search_list_sql($module, $precision, $info)
    {
        global $_M;
        if (!is_array($info)) {
            if ($precision) {
                $sql = "SELECT listid FROM {$_M['table']['plist']} WHERE info = '{$info}'";
            } else {
                $mod = load::sys_class('handle', 'new')->file_to_mod($module);
                $sql = "SELECT listid FROM {$_M['table']['plist']} WHERE info like '%{$info}%' AND module = '{$mod}'";
            }
        } else {
            $listid = $list = array();
            $para_num = 0;        
            foreach ($info as $key => $val) {
                if (!$val['info']) {
                    continue;
                }
                $p_query = "SELECT id,type,name FROM {$_M['table']['parameter']} WHERE id='{$val['id']}'";
                $parameter = DB::get_one($p_query);
                if ($parameter['type'] == 4) {
                    $query = "SELECT listid FROM {$_M['table']['plist']} WHERE paraid='{$val['id']}' AND (info = '{$val['info']}' OR info LIKE '%,{$val['info']}' OR info LIKE '%,{$val['info']},%' OR info LIKE '{$val['info']},%')";
                } else {
                    $query = "SELECT listid FROM {$_M['table']['plist']} WHERE paraid='{$val['id']}' AND info = '{$val['info']}'";
                }
                $para_num++;


                $res = DB::get_all($query);
                foreach ($res as $v) {
                    array_push($listid, $v['listid']);
                }
            }

            if ($para_num == 0) {
                return 'all';
            } else {
                $listid = array_count_values($listid);
                foreach ($listid as $key => $val) {
                    if ($val >= $para_num) {
                        $list[] = $key;
                    }
                }
                $list = $list ? $list : array();
                return $list;
            }
        }

        return $sql;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
