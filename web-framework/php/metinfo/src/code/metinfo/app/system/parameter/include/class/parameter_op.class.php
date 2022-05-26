<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * parameter标签类
 */

class parameter_op
{
    public $preg;

    public $parameter_database;

    /**
     * 初始化，继承类需要调用
     */
    public function __construct()
    {
        global $_M;
        if (defined('IN_ADMIN')) {
            #$this->preg = '/^info_([0-9]+)/';
            $this->preg = '/^para-([0-9]+)/';
        } else {
            $this->preg = '/^para([0-9]+)/';
        }
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
            case 'job':
                $mod = 6;
                break;
            case 'message':
                $mod = 7;
                break;
            case 'feedback':
                $mod = 8;
                break;
        }
        return $mod;
    }

    /**
     * 获取字段内容，前台产品，图片，下载模块使用
     * @param  string $module 表单模块类型(feedback, message, job)
     * @param  number $id 一级栏目
     * @return array            表单数组
     */
    public function insert($listid = '', $module = '', $paras = array())
    {
        global $_M;
        if (is_numeric($module)) {
            $mod = $module;
        } else {
            $mod = $this->name_to_num($module);
        }
        $list = array();

        foreach ($paras as $key => $val) {
            preg_match($this->preg, $key, $out);
            if ($out[1]) {
                if ($val) {
                    if (strstr($val, '|')) {
                        $list[$out[1]] = $val;
                    } else {
                        $list[$out[1]] .= $val . ',';
                    }
                } else {
                    $list[$out[1]] = $val;
                }
            }
        }


        foreach ($list as $key => $val) {
            $this->parameter_database->delete_list($listid, $key, $mod);
            $val = str_replace(array('|'), ',', $val);
            $val = trim($val, ',');
            $paramenter = $this->parameter_database->get_parameter_by_id($key);
            $paramenter_name = $paramenter['name'];
            $this->parameter_database->insert_list($listid, $key, $val, $paramenter_name, $mod);
        }
        return true;

        /*foreach ($list as $key => $val) {
            if (strstr($val, '|')) {
                $this->parameter_database->delete_list($listid, $key, $mod);
                foreach (explode('|', $val) as $v) {
                    $imgname = '';
                    $this->parameter_database->insert_list($listid, $key, $v, $imgname, $mod);
                }
            } else {
                $val = trim($val, ',');
                $this->parameter_database->update_list($listid, $key, $val, '', $mod);
            }
        }*/
    }

    /**
     * 获取字段内容，前台产品，图片，下载模块使用
     * @param  string $module 表单模块类型(feedback, message, job)
     * @param  number $id 一级栏目
     * @return array            表单数组
     */
    public function update($listid = '', $module = '', $paras = array())
    {
        global $_M;
        if (is_numeric($module)) {
            $mod = $module;
        } else {
            $mod = $this->name_to_num($module);
        }
        $list = array();

        foreach ($paras as $key => $val) {
            preg_match($this->preg, $key, $out);
            if ($out[1]) {
                if ($val) {
                    if (strstr($val, '|')) {
                        $list[$out[1]] = $val;
                    } else {
                        $list[$out[1]] .= $val . ',';
                    }
                } else {
                    $list[$out[1]] = $val;
                }
            }
        }

        foreach ($list as $key => $val) {
            $val = str_replace(array('|'), ',', $val);
            $val = trim($val, ',');
            $paramenter = $this->parameter_database->get_parameter_by_id($key);
            $paramenter_name = $paramenter['name'];
            $this->parameter_database->update_list($listid, $key, $val, $paramenter_name, $mod);
        }
        return true;

        /*foreach ($list as $key => $val) {
            $this->parameter_database->delete_list($listid, $key, $mod);
            if (strstr($val, '|')) {
                foreach (explode('|', $val) as $v) {
                    $imgname = '';
                    $this->parameter_database->insert_list($listid, $key, $v, $imgname, $mod);
                }
            } else {
                $val = trim($val, ',');
                $this->parameter_database->update_list($listid, $key, $val, '', $mod);
            }
        }*/
    }

    /**
     * 后台属性表单数据
     * @param string $listid
     * @param string $module
     * @param string $class1
     * @param string $class2
     * @param string $class3
     * @return array
     */
    public function paratem($listid = '', $module = '', $class1 = '', $class2 = '', $class3 = '')
    {
        global $_M;

        $paralist = $this->get_para_list($module, $class1, $class2, $class3);
        foreach ($paralist as $key => $para) {
            $list = $this->parameter_database->get_para_values($module, $para['id']);    //属性参数
            $paralist[$key]['list'] = $list;
            if ($para['type'] == 4 || $para['type'] == 2 || $para['type'] == 6) {
                $query = "SELECT * FROM {$_M['table']['plist']} WHERE listid = '{$listid}' AND paraid='{$para['id']}' AND module={$module} AND lang = '{$_M['lang']}'";
                $para_value = DB::get_one($query);
                $values = $para_value['info'];
            } else {
                $query = "SELECT * FROM {$_M['table']['plist']} WHERE listid = '{$listid}' AND paraid='{$para['id']}' AND module={$module} AND lang = '{$_M['lang']}'";
                $para_value = DB::get_one($query);
                $values = $para_value['info'];
            }

            $paralist[$key]['value'] = $values;
        }
        return $paralist;
        ##require PATH_WEB.'app/system/include/public/ui/admin/paratype.php';
    }

    public function get_para($listid, $module, $class1, $class2, $class3)
    {
        global $_M;
        $paralist = $this->get_para_list($module, $class1, $class2, $class3);
        $list = $this->parameter_database->get_list($listid, $module);

        foreach ($paralist as $val) {
            $para = $list[$val['id']];
            if ($val['type'] == 7) {
                $para7 = explode(",", $para['info']);
                $list['info_' . $val['id'] . '_1'] = $para7[0];
                $list['info_' . $val['id'] . '_2'] = $para7[1];
                if ($para7[2]) $list['info_' . $val['id'] . '_3'] = $para7[2];
            }

            if ($val['type'] == 4) {
                $parameter = $this->parameter_database->get_parameter_value($module, $listid, $val['id']);
                $value[] = $parameter['info'];
                $list['info_' . $val['id']] = implode('|', $value);
            } else {
                $list['info_' . $val['id']] = $para['info'];
            }

            if (!$para) {
                $this->parameter_database->insert_list($listid, $val['id'], '', '', $module);
            }
        }

        return $list;
    }

    public function get_para_list($module = '', $class1 = '', $class2 = '', $class3 = '')
    {
        global $_M;
        $re = $this->parameter_database->get_parameter($module, $class1, $class2, $class3);
        $paralists = array();
        foreach ($re as $val) {
            $val['list'] = $val['para_list'];
            if ($val['class1']) {
                if ($val['class1'] == $class1) {
                    if ($val['class2'] == 0 && $val['class3'] == 0) $paralists[] = $val;
                    if ($val['class2'] && $val['class2'] == $class2 && $val['class3'] == 0) $paralists[] = $val;
                    if ($val['class3'] && $val['class3'] == $class3) $paralists[] = $val;
                }
            } else {
                $paralists[] = $val;
            }
        }
        $re = $paralists;
        return $re;
    }

    /**
     * 删除属性规格
     * @param string $listid
     * @param string $module
     * @return mixed
     */
    public function del_plist($listid = '', $module = '')
    {
        global $_M;
        return $this->parameter_database->del_list($listid, $module);
    }

    //复制字段内容
    public function copy_para_list($module = '', $listid = '', $paraid = '', $tolistid = '', $toparaid = '', $tolang = '')
    {
        $para_list = load::mod_class('parameter/parameter_list_database', 'new');
        $para_list->construct($module);
        $list = $para_list->select_by_listid_paraid($listid, $paraid);
        if ($list['id']) {
            $list['id'] = '';
            $list['listid'] = $tolistid;
            $list['paraid'] = $toparaid ? $toparaid : $list['paraid'];
            $list['lang'] = $tolang;
            return $para_list->insert($list);
        }
    }

    //复制字段
    public function copy_parameter($classnow, $toclass1, $toclass2, $toclass3, $tolang)
    {
        $paras = $this->parameter_database->get_list_by_class_no_next($classnow);
        $global_para = array();
        foreach ($paras as $key => $val) {
            if ($val['class1'] == 0 && $toclass1 != 0) {
                continue;
            }
            $list = $val;
            $list['class1'] = $toclass1;
            $list['class2'] = $toclass2;
            $list['class3'] = $toclass3;
            $list['lang'] = $tolang;
            unset($list['id']);
            $id = $this->parameter_database->insert($list);
            $pids[$val['id']] = $id;
            if (in_array($val['type'], array(2, 4, 6))) {
                $options = $this->parameter_database->get_para_values($val['module'], $val['id']);
                if ($options) {
                    foreach ($options as $para) {
                        $option = array();
                        $option['pid'] = $id;
                        $option['value'] = $para['value'];
                        $option['module'] = $para['module'];
                        $option['order'] = $para['order'];
                        $option['lang'] = $tolang;
                        $this->parameter_database->add_para_value($option, $tolang);
                    }
                }
            }

        }
        return $pids;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
