<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

class config_ui
{
    public $config;
    public $no;
    public $lang;
    public $skin_name;

    /**
     * config_ui constructor.
     * @param string $no 模板编号
     * @param string $lang 语言
     */
    function __construct($no = '', $lang = '')
    {
        global $_M;
        $this->no = $no;
        $this->lang = $lang;
        $this->skin_name = $no;
        if ($_M['form']['mid'] >= 10000) {
            $this->skin_name = 'system';
        }
    }

    /*读取配置*/
    public function get_config($mid = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['ui_config']} WHERE pid = '{$mid}' AND lang = '{$_M['lang']}' AND skin_name = '{$this->skin_name}' order by uip_hidden,uip_order";
        $config = DB::get_all($query);
        return $config;
    }


    // UI模式下获取全局变量
    public function get_public_config()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['ui_config']} WHERE parent_name = 'global' AND skin_name = '{$this->no}' AND lang = '{$_M['lang']}' ORDER BY uip_order";
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

    /**
     * 获取UI区块信息
     * @param string $pid
     * @return array
     */
    public function get_ui($pid = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['ui_list']} WHERE installid = '{$pid}' AND skin_name = '{$this->skin_name}' ";
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
        $ui_config = $this->get_config($config['mid']);
        foreach ($ui_config as $key => $val) {
            $id = $val['id'] . "_metinfo";

            $uip_value = $config[$id];
            if ($val['uip_value'] != $uip_value && $val['ui_type'] != 1) {
                $uip_value = mysqlcheck($uip_value);
                $query = "UPDATE {$_M['table']['ui_config']} SET uip_value = '{$uip_value}' WHERE id = {$val['id']}";
                DB::query($query);
            }
        }
    }

    /**
     * 获取UI区块配置
     * @param string $mid
     * @return array
     */
    public function list_data($mid = '')
    {
        global $_M;
        $config = array();
        $ui_info = $this->get_ui($mid);
        $ui_config = $this->parse_config($this->get_config($mid));

        //不允许关闭带版权标识的区块
        $sql = "SELECT * FROM {$_M['table']['ui_list']} WHERE skin_name = '{$_M['config']['met_skin_user']}' AND ui_page = 'foot' AND parent_name = 'foot_info'";
        $foot_info = DB::get_one($sql);
        if ($foot_info) {
            $ui_page = array('foot_info');
        }else{
            $ui_page = array('foot_nav', 'foot_info');
        }
        if (in_array($ui_info['parent_name'], $ui_page)) {
            foreach ($ui_config as $key => $row) {
                if ($row['uip_name'] == 'ui_show') {
                    unset($ui_config[$key]);
                }
            }
        }
        //以下区块不允许关闭//

        $config['desc'] = $ui_info;
        $config['data'] = $ui_config;
        $config['met_ui_list'] = $this->getMetuiList($config['desc']['parent_name']);
        return $config;
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
            if($re['uip_value']==''){
                $re['uip_value']=$re['uip_default'];
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
                        if (!$val2['if_in'] && $val2['module'] < 8) {
                            $selectd .= $val2['name'] . '$T$' . $val2['id'] . '$M$';
                        }
                    }
                    break;
                case 3:
                    foreach ($met_class1 as $key => $val2) {
                        $val2['cok'] = 0;
                        if (is_array($met_class2[$val2['id']]) && count($met_class2[$val2['id']])) {
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
                        if ($val2['module'] <= 8) {
                            $selectd .= '==' . $val2['name'] . '==' . '$T$' . $val2['id'] . '$M$';
                            foreach ($met_class2[$val2['id']] as $key => $val3) {
                                if ($val3['module'] <= 8) {
                                    $selectd .= $val3['name'] . '$T$' . $val3['id'] . '$M$';
                                    foreach ($met_class3[$val3['id']] as $key => $val4) {
                                        $selectd .= '+' . $val4['name'] . '$T$' . $val4['id'] . '$M$';
                                    }
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

    /*************集成UI方法**************/
    /**
     * 获取集成UI列表
     * @return array
     */
    public function getMetuiList($parent_name = '')
    {
        global $_M;
        $ui_list = array();

        //模板默认UI
        $query = "SELECT * FROM {$_M['table']['ui_list']} WHERE skin_name = '{$this->no}' AND parent_name = '{$parent_name}' ORDER BY ui_order";
        $temp_ui = db::get_one($query);
        if ($temp_ui) {
            $temp_ui['view'] = "{$_M['url']['site']}templates/{$_M['config']['met_skin_user']}/ui/{$parent_name}/{$temp_ui['ui_name']}/view.jpg";
            $temp_ui['ui_title'] = $temp_ui['ui_title'] . " ({$_M['word']['default']})";
            $temp_ui['ui_name'] = '0';
            $ui_list[] = $temp_ui;
        }

        //集成UI
        $query = "SELECT * FROM {$_M['table']['ui_list']} WHERE skin_name = 'system' AND parent_name = '{$parent_name}' ORDER BY ui_order";
        $list = DB::get_all($query);
        if ($list) {
            foreach ($list as $key => $ui) {
                $ui['view'] = "{$_M['url']['site']}app/app/met_template/style/{$parent_name}/{$ui['ui_name']}/view.jpg";
                $ui_list[] = $ui;
            }
            return $ui_list;
        }
        return;

    }

    /**
     * 切换集成UI
     * @param string $mid installid/pid
     * @param string $ui_name ui名称
     * @return bool
     */
    public function changeUi($mid = '', $ui_name = '')
    {
        global $_M;
        if ($mid == '') {
            return false;
        }

        $ui_info = self::get_ui($mid);
        if ($ui_info['parent_name']) {
            $config_name = "met_style_{$ui_info['parent_name']}";
            $query = "UPDATE {$_M['table']['config']} SET `value` = '{$ui_name}' WHERE `name` = '{$config_name}' AND lang = '{$_M['lang']}'";
            DB::query($query);
            return true;
        }
    }

    /******************/
    /**
     * 更换模板
     * @param $skin_name
     * @return mixed
     */
    public function change_skin($skin_name)
    {
        global $_M;

        $this->update_lang_config($skin_name);
        $query = "UPDATE {$_M['table']['config']} SET value='{$skin_name}' WHERE name = 'met_skin_user' AND lang = '{$_M['lang']}'";
        return DB::query($query);
    }

    /**
     * 更新当前语言下的模板配置
     * @param string $skin_name
     * @return bool
     */
    public function update_lang_config($skin_name = '')
    {
        global $_M;

        $query = "SELECT * FROM {$_M['table']['ui_config']} WHERE skin_name = '{$skin_name}' AND lang != '{$_M['lang']}'";

        $res = DB::get_one($query);

        if ($res) {
            $lang = $res['lang'];
        } else {
            $lang = $_M['lang'];
        }


        $query = "SELECT * FROM {$_M['table']['ui_config']} WHERE lang = '{$lang}' AND skin_name = '{$skin_name}'";
        $config = DB::get_all($query);


        foreach ($config as $v) {
            $query = "SELECT id FROM {$_M['table']['ui_config']} WHERE uip_key = '{$v['uip_key']}' AND lang = '{$_M['lang']}' AND skin_name = '{$skin_name}' AND parent_name = '{$v['parent_name']}' AND ui_name = '{$v['ui_name']}' AND pid = {$v['pid']}";
            $has = DB::get_one($query);

            if (!$has) {
                $new = $v;
                unset($new['id'], $new['uip_value']);
                $new['lang'] = $_M['lang'];
                $insert = $this->get_sql($new);
                $query = "INSERT INTO {$_M['table']['ui_config']} SET {$insert}";
                $row = DB::query($query);
                if (!$row) {
                    return false;
                }
            }
        }
    }

    /**
     * @param array $data
     * @return string
     */
    public function get_sql($data = array())
    {
        global $_M;

        $sql = "";
        foreach ($data as $key => $value) {
            $sql .= " {$key} = '{$value}',";
        }
        return trim($sql, ',');
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
