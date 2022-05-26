<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 系统标签类
 */

class language_database
{

    /** 复制数据表内语言数据
     * @param $mark string 语言标识
     * @param $autor string 选择语言
     * @param $local_lang string 同步本地语言
     * @param $copy_config string 复制基本设置语言
     * @param $theme_style string 网站主题风格
     * @param $content string 复制基本内容的语言种类（cn）
     */
    public function copyconfig($mark = '', $autor = '', $local_lang = '', $copy_config = '', $theme_style = '', $content = '')
    {
        global $_M;
        $result = 0;
        if ($autor) {
            $lang = $autor;
        } else {
            $lang = $mark;
        }

        if ($local_lang) {
            $query = "SELECT * FROM {$_M['table']['language']} WHERE site='0' AND lang='{$local_lang}'";
            $languages = DB::get_all($query);
            foreach ($languages as $key => $val) {
                $val['value'] = str_replace("'", "''", $val['value']);
                $val['value'] = str_replace("\\", "\\\\", $val['value']);
                $val['lang'] = $lang;
                unset($val['id']);
                $sql = get_sql($val);
                $query = "INSERT INTO {$_M['table']['language']} SET {$sql}";
                DB::query($query);
            }
            $result = 1;
        }

        //复制配置表中相关语言数据
        if ($copy_config) {
            $query = "SELECT name,value,columnid,flashid FROM {$_M['table']['config']} WHERE lang='{$copy_config}' AND columnid= 0 AND flashid= 0";
        } else {
            //默认复制中文配置数据
            $query = "SELECT name,value,columnid,flashid FROM {$_M['table']['config']} WHERE lang='cn' AND columnid= 0 AND flashid= 0";
        }
        $configs = DB::get_all($query);
        foreach ($configs as $key => $val) {
            $val['value'] = str_replace("'", "''", $val['value']);
            $val['value'] = str_replace("\\", "\\\\", $val['value']);
            if ($copy_config) {
                $query = "INSERT INTO {$_M['table']['config']} SET name='{$val['name']}',value='{$val['value']}',columnid='{$val['columnid']}',flashid='{$val['flashid']}',lang='{$lang}'";
                DB::query($query);
                //手机版数据
                if ($val['flashid'] == 10000 || $val['flashid'] == 10001) {
                    $query = "INSERT INTO {$_M['table']['config']} SET name='{$val['name']}',value='{$val['value']}',mobile_value='{$val['mobile_value']}',columnid='{$val['columnid']}',flashid='{$val['flashid']}',lang='{$lang}'";
                    DB::query($query);
                }
            } else {
                $query = "INSERT INTO {$_M['table']['config']} SET name='{$val['name']}',value='',columnid='{$val['columnid']}',flashid='{$val['flashid']}',lang='{$lang}'";
                DB::query($query);
            }
        }
        $copy_table = array('app_config', 'ifmember_left', 'other_info', 'online', 'pay_config');
        foreach ($copy_table as $value) {
            self::copy_lang($value, $copy_config, $lang);
        }

        //复制栏目内容
        if ($content) {
            $column_label = load::mod_class('column/column_label', 'new');
            $columnlist = $column_label->get_column_by_classtype($content);
            if (function_exists('array_column')) {
                $column_allids = array_column($columnlist, 'id');
            } else {
                foreach ($columnlist as $value) {
                    $column_allids[] = $value['id'];
                }
            }

            //重置本地源语言栏目数据
            load::sys_class('label', 'new')->get('column')->get_column($local_lang);
            //复制栏目数据
            foreach ($columnlist as $key => $val) {
                load::mod_class('column/column_op', 'new')->copy_column($val['id'], $local_lang, $lang, 1, $column_allids);
            }

            //复制banner内容
            $query = "SELECT * FROM {$_M['table']['flash']} WHERE (module ='metinfo' or module=',10001,') AND lang ='{$content}'";
            $flash_data = DB::get_all($query);
            foreach ($flash_data as $key => $val) {
                $val['lang'] = $lang;
                unset($val['id']);
                $sql = get_sql($val);
                $query = "INSERT INTO {$_M['table']['flash']} SET {$sql}";
                DB::query($query);
            }
        }

        //复制Ui内容
        if ($theme_style) {
            $query = "SELECT value FROM {$_M['table']['config']} WHERE name='met_skin_user' AND lang ='{$theme_style}'";
            $config_ui = DB::get_one($query);
            $query = "SELECT * FROM {$_M['table']['ui_config']} WHERE skin_name ='{$config_ui['value']}' AND lang ='{$theme_style}'";
            $ui_list = DB::get_all($query);
            if ($ui_list) {
                foreach ($ui_list as $key => $val) {
                    $val['lang'] = $lang;
                    unset($val['id']);
                    $sql = get_sql($val);
                    $query = "INSERT INTO {$_M['table']['ui_config']} SET {$sql}";
                    DB::query($query);
                }
            } else {
                // 6.1修改复制标签模板的配置
                $skin_name = $config_ui['value'];
                $from_lang = $theme_style;
                load::mod_class('ui_set/class/config_tem.class.php');
                $tem = new config_tem($skin_name, $from_lang);

                $tem->copy_tempates($skin_name, $from_lang, $lang);
            }
        }

        return $result;
    }

    /** 同步系统语言
     * @param $post array 请求系统参数
     * @param $filename string 语言配置文件路径
     * @param $mark string 语言标识
     * @param $site
     * @return bool|int
     */
    public function syn_lang($post, $filename, $mark, $site)
    {
        global $_M;
        $linetra = '';
        $curl_result = json_decode(api_curl($_M['config']['met_api'], $post), true);

        if ($curl_result['status'] != 200) {
            return false;
        }
        $this->filetest($filename);
        file_put_contents($filename, $curl_result);

        $no_order_l = 0;
        $no_order_s = 0;
        if (file_exists($filename)) {
            $fp = @fopen($filename, "r");
            while ($conf_line = @fgets($fp, 1024)) {
                if (substr($conf_line, 0, 1) == "#") {
                    $no_order_l++;
                    $array_l = 0;
                    $no_order_s = 0;
                    $array = $array_l;
                    $no_order = $no_order_l;
                    $line = preg_replace("/^#/", "", $conf_line);
                } else {
                    $no_order_s++;
                    $array_s = $no_order_l;
                    $line = $conf_line;
                    $array = $array_s;
                    $no_order = $no_order_s;
                }
                if (trim($line) == "") {
                    continue;
                }
                $linearray = explode('=', $line);
                $linenum = count($linearray);
                if ($linenum == 2) {
                    list($name, $value) = explode('=', $line);
                } else {
                    for ($i = 0; $i < $linenum; $i++) {
                        $linetra = $i ? $linetra . "=" . $linearray[$i] : $linearray[$i] . 'metinfo_';
                    }
                    list($name, $value) = explode('metinfo_=', $linetra);
                }
                $value = str_replace("\"", "&quot;", $value);
                list($value, $valueinfo) = explode('/*', $value);
                $name = str_replace('\\', '', daddslashes(trim($name), 1, 'metinfo'));
                $value = str_replace("'", "''", $value);
                $value = str_replace("\\", "\\\\", $value);
                $value = trim($value, "\n");
                $value = trim($value, "\r");
                $value = trim($value, "\r");
                $value = str_replace('\\n', ',', $value);
                $query1 = "SELECT id FROM {$_M['table']['language']} WHERE name='{$name}' AND site='{$site}' AND lang='{$mark}'";
                $result = DB::get_one($query1);
                if ($result) {
                    $query = "UPDATE {$_M['table']['language']} SET value='{$value}' WHERE name='{$name}' AND site='{$site}' AND lang='{$mark}'";
                } else {
                    $query = "INSERT INTO {$_M['table']['language']} SET name='{$name}',value='{$value}',site='{$site}',no_order='{$no_order}',array='{$array}',lang='{$mark}'";
                }
                DB::query($query);
            }
            fclose($fp);
        }
        unlink($filename);
        return 1;
    }

    function link_error($str)
    {
        switch ($str) {
            case 'Timeout' :
                return -6;
                break;
            case 'NO File' :
                return -5;
                break;
            case 'Please update' :
                return -4;
                break;
            case 'No Permissions' :
                return -3;
                break;
            case 'No filepower' :
                return -2;
                break;
            case 'nohost' :
                return -1;
                break;
            Default;
                return 1;
                break;
        }
    }

    function curl_post($post, $timeout = 30)
    {
        global $_M;
        if (get_extension_funcs('curl') && function_exists('curl_init') && function_exists('curl_setopt') && function_exists('curl_exec') && function_exists('curl_close')) {
            $curlHandle = curl_init();
            curl_setopt($curlHandle, CURLOPT_URL, 'http://app.metinfo.cn/file/lang/lang.php');
            curl_setopt($curlHandle, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
            curl_setopt($curlHandle, CURLOPT_REFERER, $_M['config']['met_weburl']);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($curlHandle, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($curlHandle, CURLOPT_POST, 1);
            curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $post);
            $result = curl_exec($curlHandle);

            curl_close($curlHandle);
            if (substr($result, 0, 7) == 'metinfo') {
                return substr($result, 7);
            } else {
                return $result;
            }

        }
    }

    function filetest($dir)
    {
        @clearstatcache();
        if (file_exists($dir)) {
            $str = file_get_contents($dir);
            if (strlen($str) == 0) return 0;
            $return = file_put_contents($dir, $str);
        } else {
            $fileexist = '';
            $filedir = explode('/', dirname($dir));
            $flag = 0;
            foreach ($filedir as $key => $val) {
                if ($val == '..') {
                    $fileexist .= "../";
                } else {
                    if ($flag) {
                        $fileexist .= '/' . $val;
                    } else {
                        $fileexist .= $val;
                        $flag = 1;
                    }
                    if (!file_exists($fileexist)) {
                        @mkdir($fileexist, 0777);
                    }
                }
            }
            $filename = $fileexist . '/' . basename($dir);
            if (strstr(basename($dir), '.')) {
                $fp = @fopen($filename, "w+");
                @fclose($fp);
            } else {
                @mkdir($filename, 0777);
            }
            $return = file_put_contents($dir, 'metinfo');
        }
        return $return;
    }

    /**
     * 复制内容到其他语言
     * @DateTime 2018-07-18
     * @param    [type]     $table     表名，不要加前缀
     * @param    [type]     $from_lang 从哪个语言复制
     * @param    [type]     $to_lang   复制到哪个语言
     */
    public function copy_lang($table, $from_lang, $to_lang)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table'][$table]} WHERE lang = '{$from_lang}'";
        $from = DB::get_all($query);
        foreach ($from as $new) {
            unset($new['id']);
            $new['lang'] = $to_lang;
            $sql = get_sql($new);
            $query = "INSERT INTO {$_M['table'][$table]} SET {$sql}";
            DB::query($query);
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
