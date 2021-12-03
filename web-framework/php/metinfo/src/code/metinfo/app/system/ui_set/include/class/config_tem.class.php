<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

class config_tem
{

    public $no;//模板编号
    public $lang;//模板语言

    function __construct($no = '', $lang = '')
    {
        global $_M;
        $this->no = $no;
        $this->lang = $_M['lang'];
    }

    public function get_config($name = '')
    {
        global $_M;
        if (is_numeric($name)) {
            $query = "SELECT * FROM {$_M['table']['templates']} WHERE pos = '{$name}' AND lang='{$this->lang}' AND no = '{$this->no}' ";
        } else {
            $query = "SELECT * FROM {$_M['table']['templates']} WHERE bigclass = (SELECT id FROM {$_M['table']['templates']} WHERE lang='{$this->lang}' AND no = '{$this->no}' AND name='{$name}') AND lang='{$this->lang}' ORDER BY no_order";
        }

        return DB::get_all($query);
    }


    public function get_area($name = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['templates']} WHERE lang='{$this->lang}' AND no = '{$this->no}' AND name='{$name}'";
        return DB::get_one($query);
    }

    /**
     * 前端按区保存
     */
    public function save_config($config = array())
    {
        global $_M;
        foreach ($config as $key => $value) {
            $id = str_replace('_metinfo', '', $key);
            $query = "UPDATE {$_M['table']['templates']} SET value='{$value}' WHERE id='{$id}' AND lang='{$_M['lang']}' AND no='{$this->no}'";
            $row = DB::query($query);
        }
    }

    public function get_public_config()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['templates']} WHERE bigclass = (SELECT id FROM {$_M['table']['templates']} WHERE lang='{$this->lang}' AND no = '{$this->no}' AND name='global') ORDER BY no_order";
        return DB::get_all($query);
    }

    public function set_public_config($config = array())
    {
        global $_M;
        foreach ($config as $key => $value) {
            $id = str_replace('_metinfo', '', $key);
            $query = "UPDATE {$_M['table']['templates']} SET value='{$value}' WHERE id='{$id}' AND lang='{$_M['lang']}' AND no='{$this->no}'";
            $row = DB::query($query);
        }

        return array('status' => 1);
    }

    /*public function set_page_config($config = array())
    {
        global $_M;
        foreach ($config as $key => $val) {
            $query = "UPDATE {$_M['table']['config']} SET value='{$val}' WHERE name='{$key}' AND lang='{$_M['lang']}'";
            DB::query($query);
        }
        return array('status'=>1);
    }*/


    public function get_config_column($name = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['templates']} WHERE name = '{$name}' AND lang = '{$_M['lang']}' AND type = 1 AND no = '{$this->no}' ";
        $area = DB::get_one($query);
        $query = "SELECT * FROM {$_M['table']['templates']} WHERE type = 6 AND no = '{$this->no}' AND lang = '{$_M['lang']}' AND bigclass = '{$area['id']}' ";

        $column = DB::get_all($query);
        if (count($column) > 1) {
            return 2;
        }
        return DB::get_one($query);
    }

    public function list_data($name = '')
    {
        global $_M;
        $config = array();
        $data = $this->parse_config($this->get_config($name));
        $config['data'] = $data;
        $config['desc'] = $this->get_area($name);
        return $config;
    }

    /*******************************/
    public function parse_config($config = array())
    {
        global $_M;
        foreach ($config as $key => $val) {
            switch ($val['type']) {
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
            }
            #$data[] = $this->clear($re);
            if($re['value']==''){
                $re['value']=$re['defaultvalue'];
            }
            $data[] = $re;
        }
        return $data;

    }

    public function select($val = array())
    {
        global $_M;
        if ($val['style'] == 2) $val['style'] = 4;
        if ($val['style'] == 0) {
            return $val;
        } else {
            $val['ftype'] = "ftype_select";
            $option_style = $val['style'];
            $array = column_sorting(2);
            $met_class1 = $array['class1'];
            $met_class2 = $array['class2'];
            $met_class3 = $array['class3'];
            $val['selectd'] = '';
            $selectd = '';
            switch ($option_style) {
                case 1:
                    foreach ($met_class1 as $key => $val2) {
                        #if (!$val2['if_in'] && ($val2['module'] > 1 && $val2['module'] < 7)) {
                        if (!$val2['if_in'] && $val2['module'] < 7) {
                            $selectd .= $val2['name'] . '$T$' . $val2['id'] . '$M$';
                        }
                    }
                    $selectd = trim($selectd, '$M$');
                    $val['selectd'] = $selectd;
                    break;
                case 3:
                    foreach ($met_class1 as $key => $val2) {
                        $val2['cok'] = 0;
                        if (isset($met_class2[$val2['id']]) && count($met_class2[$val2['id']])) {
                            foreach ($met_class2[$val2['id']] as $key => $val6) {
                                if ($val6['module'] > 1 && $val6['module'] < 7) {
                                    $val2['cok'] = 1;
                                }
                            }
                        }
                        if (($val2['module'] > 1 && $val2['module'] < 7) || $val2['cok']) {
                            if (($val2['module'] < 2 || $val2['module'] > 6) && $val2['cok']) $disabled = 'disabled';

                            $selectd .= '==' . $val2['name'] . '==' . '$T$' . $val2['id'] . '$M$';

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

                    $selectd = trim($selectd, '$M$');
                    $val['selectd'] = $selectd;
                    break;
                case 4:
                    foreach ($met_class1 as $key => $val2) {
                        #if (($val2['module'] > 1 && $val2['module'] < 7)) {
                        if ($val2['module'] < 7) {
                            $selectd .= '==' . $val2['name'] . '==' . '$T$' . $val2['id'] . '$M$';
                            foreach ($met_class2[$val2['id']] as $key => $val3) {
                                $selectd .= $val3['name'] . '$T$' . $val3['id'] . '$M$';
                                foreach ($met_class3[$val3['id']] as $key => $val4) {
                                    $selectd .= '+' . $val4['name'] . '$T$' . $val4['id'] . '$M$';
                                }
                            }
                        }
                    }
                    $selectd = trim($selectd, '$M$');
                    $val['selectd'] = $selectd;
                    break;
            }

            return $val;

        }
    }

    /****************************/
    public function change_skin($skin_name)
    {
        global $_M;
        $this->update_lang_config($skin_name);
        $query = "UPDATE {$_M['table']['config']} SET value='{$skin_name}' WHERE name = 'met_skin_user' AND lang = '{$this->lang}'";
        return DB::query($query);
    }


    public function update_lang_config($skin_name = '')
    {
        global $_M;

        $query = "SELECT * FROM {$_M['table']['templates']} WHERE no = '{$skin_name}'";

        $res = DB::get_one($query);

        if ($res) {
            $lang = $res['lang'];
        } else {
            $lang = $_M['lang'];
        }

        $this->copy_tempates($skin_name = '', $lang = '');
    }

    public function copy_tempates($skin_name = '', $from_lang = '', $to_lang = '')
    {
        global $_M;
        if (!$to_lang) {
            $to_lang = $_M['lang'];
        }
        $query = "select * from {$_M['table']['templates']} where lang='{$from_lang}' and no='$skin_name' AND bigclass=0";
        $templates = DB::get_all($query);

        foreach ($templates as $key => $val) {
            $query = "SELECT id FROM {$_M['table']['templates']} WHERE name = '{$val['name']}' AND lang = '{$to_lang}' AND no = '{$skin_name}'";

            $has = DB::get_one($query);

            if (!$has) {
                $id = $val['id'];
                unset($val['id']);
                $parent = $val;
                $parent['lang'] = $to_lang;
                $this->insert_templates($parent);
                $cid = DB::insert_id();
                $query = "SELECT * FROM {$_M['table']['templates']} where lang='{$from_lang}' and no='{$skin_name}' AND bigclass={$id}";
                file_put_contents(PATH_WEB . 'cache/test.txt', $query . "\n", FILE_APPEND);
                $source = DB::get_all($query);
                foreach ($source as $k => $v) {
                    $sub = $v;
                    unset($v, $sub['id']);
                    $sub['bigclass'] = $cid;
                    $sub['lang'] = $to_lang;
                    $this->insert_templates($sub);
                    unset($sub);
                }
            }
        }
    }

    public function insert_templates($data = array())
    {
        global $_M;
        $sql = "";
        foreach ($data as $key => $value) {
            if (strstr($value, "'")) {
                $value = str_replace("'", "\'", $value);
            }
            $sql .= " {$key} = '{$value}',";
        }
        $sql = trim($sql, ',');
        $query = "INSERT INTO {$_M['table']['templates']} SET {$sql}";
        return DB::query($query);
    }

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