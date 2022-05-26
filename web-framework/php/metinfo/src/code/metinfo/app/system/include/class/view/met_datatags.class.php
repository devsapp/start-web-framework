<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

class met_datatags
{
    /**
     * 需要可视化的字段
     */
    public $fields = array('name', 'value', 'title', 'keywords', 'description', 'content', 'valueinfo', 'defaultvalue', 'imgurl', 'uip_default', 'uip_value', 'img_path', 'columnimg', 'icon', 'imgurls', 'info', 'content1', 'content2', 'content3', 'content4', 'position', 'img_title', 'img_des', 'namemark', 'weblogo', 'ctitle', 'indeximg', 'but_text', 'webname');
    /**
     * 需要可视化的表
     */
    public $tables = array('news', 'column', 'product', 'img', 'job', 'templates', 'ui_config', 'config', 'flash', 'column', 'language', 'download', 'parameter', 'link', 'flash_button', 'plist');

    public function __construct()
    {
        global $_M;
    }

    //添加可视化数据标签
    public function replace_sql_one($sql = '', $rs = array())
    {
        global $_M;
        if ($table = self::getTable($sql)) {
            if ($tableName = self::checkTable($table)) {
                foreach ($rs as $key => $v) {
                    if (self::checkField($key)) {

                        if (self::checkImg($key)) {
                            //图片字段
                            if (!$v) {
                                $default_img = str_replace('../', '', $_M['config']['met_agents_img']);
                                $v = $_M['config']['site'] . $default_img;
                            }
                            $rs[$key] = $v . "?met-id={$rs['id']}&met-table={$tableName}&met-field={$key}";
                        } else {

                            $rs[$key] = $v . "<m met-id={$rs['id']} met-table={$tableName} met-field={$key}></m>";
                        }

                    }
                }
            }
        }
        return $rs;
    }

    //添加可视化数据标签
    public function replace_sql_all($sql = '', $rs = array())
    {
        global $_M;
        if ($table = self::getTable($sql)) {
            if ($tableName = self::checkTable($table)) {
                foreach ($rs as $k => $v) {
                    $exception = array('met_agents_copyright', 'met_agents_copyright_foot', 'met_agents_copyright_foot1', 'met_agents_copyright_foot2','met_text_wate','met_alt');
                    if (in_array($v['name'],$exception)) {
                        continue;
                    }
                    foreach ($v as $key => $val) {
                        if (self::checkField($key)) {
                            if (self::checkImg($key)) {
                                if (!$val) {
                                    $default_img = str_replace('../', '', $_M['config']['met_agents_img']);
                                    $val = $_M['config']['site'] . $default_img;
                                }
                                // 图片字段
                                $rs[$k][$key] = $val . "?met-id={$rs[$k]['id']}&met-table={$tableName}&met-field={$key}";
                            } else {
                                if ($tableName == 'templates') {
                                    $rs[$k][$key] = $this->add_tag($val, $tableName, $key, $rs[$k]['id'], $rs[$k]['type']);
                                } elseif ($tableName == 'ui_config') {
                                    $rs[$k][$key] = $this->add_tag($val, $tableName, $key, $rs[$k]['id'], $rs[$k]['uip_type']);
                                }else{
                                    $rs[$k][$key] = $this->add_tag($val, $tableName, $key, $rs[$k]['id']);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $rs;
    }

    /*********还原数据标签*********/
    //去掉数据中的m标签
    /*public function replace_m($value = '')
    {
        global $_M;
        return preg_replace_callback("/<m[\s_a-zA-Z=\d->]+<\/m>/", function($match){
            return;
        }, $value);
    }

    //标签里的属性不添加m标签
    public function replace_attr($output = '')
    {
        global $_M;
        $that = $this;

        $new_output =  preg_replace_callback("/(alt|value|title|placeholder|data-name|data-title|data-fv-message|data-sub-html)=['\"]?([^\s\>]+)?(<m[\s_a-zA-Z=\d>-]+<\/m>)['\"]?/isu", function($match) use ($that){
            return $that->replace_m(trim($match[0]));
        }, $output);
        if($new_output){
            return $new_output;
        }else{
            return $output;
        }
    }*/
    /*********还原数据标签*********/

    /*********添加数据标签*********/
    //给值加上m标签
    public function add_tag($val = '', $table = '', $field = '', $id = '', $type = '')
    {
        global $_M;
        $number = "/[0-9_a-zA-Z<\x{4e00}-\x{9fa5}>]+/u";
        $string = "/[_a-zA-Z<\x{4e00}-\x{9fa5}>]+/u";
        $chinese = "/[<\x{4e00}-\x{9fa5}>]+/u";

        // 产品参数
        if ($table == 'plist' && $field == 'info') {
            if (preg_match($number, $val) && !is_numeric($val)) {
                return $val . "<m met-id={$id} met-table={$table} met-field={$field}></m>";
            }
        }

        if ($table == 'templates' || $table == 'config' || $table == 'language') {
            if ($field == 'name') {
                return $val;
            } else {
                if (preg_match($chinese, $val)) {
                    return $val . "<m met-id={$id} met-table={$table} met-field={$field}></m>";
                }

                if ($table == 'language') {
                    return $val . "<m met-id={$id} met-table={$table} met-field={$field}></m>";
                }

                if ($table == 'templates' && $field == 'value') {
                    //富文本字段
                    if ($type == 8) {
                        return $val . "<m met-id={$id} met-table={$table} met-field={$field}></m>";
                    }
                    if (preg_match($string, $val)) {
                        return $val . "<m met-id={$id} met-table={$table} met-field={$field}></m>";
                    }
                }

                return $val;
            }
        }

        if ($field == 'icon' || ($table == 'ui_config' && $type == 15)) {
            // 分类栏目标识
            $val = $val ? $val : "icon fa-pencil-square-o";
            return $val . " met-icon|{$id}|{$table}|{$field}";
        }

        // 其他字段碰到数字类型的值不添加m标签
        if (preg_match($string, $val) || strlen($val) >= 7) {
            return $val . "<m met-id={$id} met-table={$table} met-field={$field}></m>";
        }
        return $val;
    }

    // 要处理的表
    public function checkTable($table)
    {
        if (!is_file(PATH_WEB . 'config/config_db.php')) {
            return false;
        }

        @extract(parse_ini_file(PATH_WEB . 'config/config_db.php'));

        if (strpos($table, $tablepre) === false) {
            return false;
        }

        $table = str_replace($tablepre, '', $table);

        if (!in_array($table, $this->tables)) {
            return false;
        }

        return $table;
    }

    // 要处理的字段
    public function checkField($field)
    {

        if (in_array($field, $this->fields)) {
            return true;
        } else {
            return false;
        }
    }

    // 图片字段处理方式不一样
    public function checkImg($filed)
    {
        $img_fields = array('img_path', 'imgurl', 'columnimg', 'imgurls', 'weblogo', 'indeximg');
        return in_array($filed, $img_fields);
    }

    // 从语句中提取表名
    public function getTable($sql)
    {
        preg_match("/(from|FROM)\s+(\w+)/", $sql, $match);
        return isset($match[2]) ? $match[2] : false;
    }
    /*********添加数据标签*********/
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.