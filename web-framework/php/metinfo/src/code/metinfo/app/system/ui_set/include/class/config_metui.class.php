<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

class config_metui
{
    public $config;
    public $lang;

    function __construct($lang = '')
    {
        global $_M;
        $this->lang = $lang;
    }

    /*读取配置*/
    public function get_config($block = '', $mid = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['style_config']} WHERE block_name = '{$block}' AND pid = '{$mid}' AND lang = '{$_M['lang']}' order by uip_hidden,uip_order";
        $config = DB::get_all($query);
        return $config;
    }


    // UI模式下获取全局变量
    public function get_public_config()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['ui_config']} WHERE parent_name = 'global' AND skin_name = '{$this->skin_name}' AND lang = '{$_M['lang']}' ORDER BY uip_order";
        return DB::get_all($query);

    }

    public function get_config_column($mid = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['ui_config']} WHERE pid = '{$mid}' AND lang = '{$_M['lang']}' AND uip_type = 6";
        $column = DB::get_all($query);
        if (count($column) > 1) {
            return 2;
        }
        return DB::get_one($query);
    }

    public function get_metui($block = '', $pid = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['style_list']} WHERE pid = '{$pid}' AND block_name = '{$block}'";
        return DB::get_one($query);
    }

    public function set_public_config($config = array())
    {
        global $_M;
        $public = $this->get_public_config();
        foreach ($public as $key => $val) {
            $id = $val['id'] . "_metinfo";
            $uip_value = $config[$id];
            if ($val['uip_value'] != $uip_value && $val['ui_type'] != 1) {
                $uip_value = mysqlcheck($uip_value);
                $query = "UPDATE {$_M['table']['ui_config']} SET uip_value = '{$uip_value}' WHERE id = {$val['id']}";
                DB::query($query);
            }
        }
        return array('status' => 1);
    }

    /*配置文件保存*/
    public function save_config($config = array())
    {
        global $_M;
        $ui_config = $this->get_config($config['mname'], $config['mid']);
        foreach ($ui_config as $key => $val) {
            $id = $val['id'] . "_metinfo";

            $uip_value = $config[$id];
            if ($val['uip_value'] != $uip_value && $val['ui_type'] != 1) {
                $uip_value = mysqlcheck($uip_value);
                $query = "UPDATE {$_M['table']['style_config']} SET uip_value = '{$uip_value}' WHERE id = {$val['id']} AND block_name = '{$config['mname']}' AND pid = '{$config['mid']}' AND lang = '{$_M['lang']}'";
                DB::query($query);
            }
        }
    }

    /**
     * 获取取款配置参数
     * @param string $block
     * @param string $mid
     * @return array
     */
    public function list_data($block = '', $mid = '')
    {
        global $_M;
        $config = array();
        $config['data'] = $this->parse_config($this->get_config($block, $mid));
        $config['desc'] = $this->get_metui($block, $mid);
        return $config;
    }

    public function get_ui($pid = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['style_list']} WHERE pid = '{$pid}' ";
        return DB::get_one($query);
    }

    public function parse_config($config = array())
    {
        global $_M;

        $html = array();
        foreach ($config as $key => $val) {
            switch ($val['uip_type']) {
                case 2:
                    #$re = $this->text($val);
                    $re = $val;
                    break;
                case 3:
                    #$re = $this->textarea($val);
                    $re = $val;
                    break;
                case 4:
                    #$re = $this->radio($val);
                    $re = $val;
                    break;
                case 5:
                    #$re = $this->checkbox($val);
                    $re = $val;
                    break;
                case 6:
                    $re = $this->select($val);
                    #$re = $val;
                    break;
                case 7:
                    #$re = $this->upload($val);
                    $re = $val;
                    break;
                case 8:
                    #$re = $this->editor($val);
                    $re = $val;
                    break;
                case 9:
                    #$re = $this->color($val);
                    $re = $val;
                    break;
                case 10:
                    #$re = $this->dateselect($val);
                    $re = $val;
                    break;
                case 11:
                    #$re = $this->slider($val);
                    $re = $val;
                    break;
                case 12:
                    #$re = $this->label($val);
                    $re = $val;
                    break;
                case 13://增加新组件类型（新模板框架v2）
                    #$re = $this->upload($val);
                    $re = $val;
                    break;
                case 14://
                    #$re = $this->socaillink($val);
                    $re = $val;
                    break;
                case 15://
                    #$re = $this->icon($val);
                    $re = $val;
                    break;
            }
            $html[] = $re;
        }
        return $html;
    }

    public function select($val = array())
    {
        global $_M;
        if ($val['uip_style'] == 2) $val['uip_style'] = 4;
        if ($val['uip_style'] == 0) {
            $val['ftype'] = "ftype_select";
            $val['uip_value'] = $val['uip_value'] == "" ? $val['uip_default'] : $val['uip_value'];
            return $val;
        } else {
            $val['ftype'] = "ftype_select";
            $option_style = $val['uip_style'];
            $array = column_sorting(2);
            $met_class1 = $array['class1'];
            $met_class2 = $array['class2'];
            $met_class3 = $array['class3'];
            $selectd = '';
            switch ($option_style) {
                case 1:
                    foreach ($met_class1 as $key => $val2) {
                        if (!$val2['if_in'] && ($val2['module'] > 1 && $val2['module'] < 7)) {
                            $selectd .= $val2['name'] . '$T$' . $val2['id'] . '$M$';
                        }
                    }
                    break;
                case 3:
                    foreach ($met_class1 as $key => $val2) {
                        $val2['cok'] = 0;
                        if (count($met_class2[$val2['id']])) {
                            foreach ($met_class2[$val2['id']] as $key => $val6) {
                                if ($val6['module'] > 1 && $val6['module'] < 7) {
                                    $val2['cok'] = 1;
                                }
                            }
                        }
                        if (($val2['module'] > 1 && $val2['module'] < 7) || $val2['cok']) {
                            if (($val2['module'] < 2 || $val2['module'] > 6) && $val2['cok']) $disabled = 'disabled';
                            $selectd .= $val2['name'] . '$T$' . $val2['id'] . '$M$';
                            foreach ($met_class2[$val2['id']] as $key => $val3) {
                                if (($val3['module'] >= 2 && $val3['module'] <= 6) && !$val3['if_in']) {
                                    $selectd .= $val3['name'] . '$T$' . $val3['id'] . '$M$';
                                    foreach ($met_class3[$val3['id']] as $key => $val4) {
                                        $selectd .= '+' . $val4['name'] . '$T$' . $val4['id'] . '$M$';
                                    }
                                }
                            }
                        }
                    }
                    for ($i = 2; $i < 6; $i++) {
                        if ($i != 4) {
                            $langmod1 = $_M['word']['mod' . $i];
                            $selectd .= '==' . $langmod1 . '==' . '$T$' . $i . '-md' . '$M$';
                        }
                    }
                    break;
                case 4:
                    foreach ($met_class1 as $key => $val2) {
                        if (($val2['module'] > 1 && $val2['module'] < 7)) {
                            $selectd .= '==' . $val2['name'] . '==' . '$T$' . $val2['id'] . '$M$';
                            foreach ($met_class2[$val2['id']] as $key => $val3) {
                                $selectd .= $val3['name'] . '$T$' . $val3['id'] . '$M$';
                                foreach ($met_class3[$val3['id']] as $key => $val4) {
                                    $selectd .= '+' . $val4['name'] . '$T$' . $val4['id'] . '$M$';
                                }
                            }
                        }
                    }
                    break;
            }
            $val['uip_select'] = $selectd;
            return $val;
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
