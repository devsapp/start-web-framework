<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 页面跳转
 */
function turnover($url = '', $text = '', $success=1)
{
    global $_M;
    if (!$text) {
        $text = $_M['word']['jsok'];
    }
    if ($text == 'No prompt') {
        $text = '';
    }

    $text = urlencode($text);
    echo("<script type='text/javascript'>location.href='{$url}&turnovertext={$text}&turnovertype=".$success."';</script>");
    exit;
}

/**
 * 获取当前管理员信息
 * @return array  $user 返回记录当前管理员信息和有权限操作的栏目的数组
 */
function admin_information()
{
    global $_M;
    met_cooike_start();
    $met_admin_table = $_M['table']['admin_table'];
    $met_column = $_M['table']['column'];
    $metinfo_admin_name = get_met_cookie('metinfo_admin_name');
    $query = "SELECT * from {$_M['table']['admin_table']} WHERE admin_id = '{$metinfo_admin_name}'";
    $user = DB::get_one($query);
    $query = "SELECT id,name from {$_M['table']['column']} WHERE access <= '{$user['usertype']}' AND lang = '{$_M['lang']}'";
    $column = DB::get_all($query);
    $user['column'] = $column;
    return $user;
}

/**
 * 获取当前管理员的权限
 * @return array  $privilege 返回记录当前管理员管理功能权限的数组（metinfo--后台所有功能管理权限;s开头--系统功能;c开头--为内容管理中，前台栏目管理权限;a开头--应用管理权限）
 */
function background_privilege()
{
    global $_M;
    if (!$_M['privilege']) {
        $metinfo_admin_name = $_M['user']['admin_name'];
        $query = "SELECT * from {$_M['table']['admin_table']} WHERE admin_id = '{$metinfo_admin_name}'";
        $user = DB::get_one($query);
        $privilege = array();
        $privilege['admin_op'] = $user['admin_op'];
        if (strstr($user['langok'], "metinfo")) {
            $privilege['langok'] = $_M['langlist']['web'];
        } else {
            $langok = explode('-', $user['langok']);
            foreach ($langok as $key=>$val) {
                if ($val) {
                    $privilege['langok'][$val] = $_M['langlist']['web'][$val];
                }
            }
        }
        if (strstr($user['admin_type'], "metinfo")) {
            $privilege['navigation'] = "metinfo";
            $privilege['column'] = "metinfo";
            $privilege['application'] = "metinfo";
            $privilege['see'] = "metinfo";
        } else {
            $allidlist = explode('-', $user['admin_type']);
            foreach ($allidlist as $key=>$val) {
                if (strstr($val, "s")) {
                    $privilege['navigation'].= str_replace('s', '', $val)."|";
                }
                if (strstr($val, "c")) {
                    $privilege['column'].= str_replace('c', '', $val)."|";
                }
                if (strstr($val, "a")) {
                    $privilege['application'].= str_replace('a', '', $val)."|";
                }
                if ($val == 9999) {
                    $privilege['see'] = "metinfo";
                }
            }
            $privilege['navigation'] = trim($privilege['navigation'], '|');
            $privilege['column'] = trim($privilege['column'], '|');
            $privilege['application'] = trim($privilege['application'], '|');
        }
        $_M['privilege'] = $privilege;
    }
    return $_M['privilege'];
}

/**
 * 获取当前管理员有权限操作的栏目信息
 * @return array  $column 返回记录当前管理员有权限操作的栏目信息的数组
 */
function operation_column($lang = '')
{
    global $_M;
    $lang = $lang ? $lang : $_M['lang'];
    $jurisdiction = background_privilege();
    if ($jurisdiction['column'] == "metinfo") {
        $query = "SELECT * from {$_M['table']['column']} WHERE lang = '{$lang}' AND module < 100 ORDER BY no_order ASC, id DESC";
        $admin_column = DB::get_all($query);
    } else {
        $column_id = explode('|', $jurisdiction['column']);
        $i = 0;
        $sql_id = '';
        foreach ($column_id as $key => $val) {
            if ($val) {
                if ($i == 0) {
                    $sql_id = "AND (id = '{$val}' ";
                } else {
                    $sql_id .= "OR id = '{$val}' ";
                }
            }
            $i++;
        }
        $sql_id .= ")";
        $query = "SELECT * from {$_M['table']['column']} WHERE lang = '{$lang}'{$sql_id} AND module < 100 ORDER BY no_order ASC, id DESC";
        $admin_column_1 = DB::get_all($query);
        $query = "SELECT * from {$_M['table']['column']} WHERE lang = '{$lang}' AND classtype!=1 AND releclass=0 AND module < 100 ORDER BY no_order ASC, id DESC";
        $admin_column_2 = DB::get_all($query);
        foreach ($admin_column_1 as $key => $val) {
            $admin_column[] = $val;
        }
        foreach ($admin_column_2 as $key => $val) {
            $admin_column[] = $val;
        }
    }
    foreach ($admin_column as $key => $val) {
        $column[$val['id']] = $admin_column[$key];
    }
    return $column;
}

/**
 * 是否有权限操作
 * @param  int    $type		1；按模块生成;2：按栏目生成
 * @return array  $column	返回把记录当前管理员有权限操作的栏目信息的数组按模块归类或栏目归类整理后的数组
 */
function is_have_power($now = '')
{
    $power = background_privilege();
    $a = substr($now, 0, 1);
    switch ($a) {
        case 's':
            $list = $power['navigation'];
        break;
        case 'a':
        $list = $power['application'];
        break;
        case 'c':
            $list = $power['column'];
        break;
    }
    $p = str_replace($a, '', $now);
    if (!$list) {
        return false;
    }
    if ($list == 'metinfo' || strstr("|{$list}|", "|{$p}|")) {
        return true;
    } else {
        return false;
    }
}

/**
 * 对当前管理员有权限操作的栏目信息进行整理；
 * @param  int    $type		1；按模块生成;2：按栏目生成
 * @return array  $column	返回把记录当前管理员有权限操作的栏目信息的数组按模块归类或栏目归类整理后的数组
 */
function column_sorting($type = '', $lang = '')
{
    global $_M;
    $lang = $lang ? $lang : $_M['lang'];
    $information = operation_column($lang);
    if ($type == 1) {
        foreach ($information as $key=>$val) {
            if ($val['releclass'] != 0) {
                $sorting[$val['module']]['class1'][$key] = $information[$key];
                $column_classtype[] = $val['id'];
            } else {
                if ($val['classtype'] == 1) {
                    $sorting[$val['module']]['class1'][$key] = $information[$key];
                }
                if ($val['classtype'] == 2) {
                    $sorting[$val['module']]['class2'][$key] = $information[$key];
                }
            }
        }
        foreach ($information as $key=>$val) {
            $i = 0;
            if ($val['classtype'] == 3) {
                foreach ($column_classtype as $key1=>$val1) {
                    if ($val['bigclass'] == $val1) {
                        $i = 1;
                    }
                }
                if ($i == 1) {
                    $sorting[$val['module']]['class2'][$key] = $information[$key];
                } else {
                    $sorting[$val['module']]['class3'][$key] = $information[$key];
                }
            }
        }
    } else {
        foreach ($information as $key=>$val) {
            if ($val['classtype'] == 1) {
                $sorting['class1'][$key] = $information[$key];
            }
            if ($val['classtype'] == 2) {
                $sorting['class2'][$val['bigclass']][$key] = $information[$key];
            }
            if ($val['classtype'] == 3) {
                $sorting['class3'][$val['bigclass']][$key] = $information[$key];
            }
        }
    }
    ksort($sorting);
    return $sorting;
}

/**
 * 获取后台导航栏目数组
 * @return array 返回记录后台导航栏目信息的数组
 */
function get_adminnav()
{
    global $_M;
    $jurisdiction = background_privilege();
    $query = "select * from {$_M['table']['admin_column']} order by type desc,list_order";
    $sidebarcolumn = DB::get_all($query);
    $bigclass = array();

    foreach ($sidebarcolumn as $key => $val) {
        if (!is_strinclude($jurisdiction['navigation'], $val['field']) && $jurisdiction['navigation'] != 'metinfo' && $val['field']!=0) {
            continue;
        }
        //需要清理，下面的代码，有些栏目已经多余
        if (($val['name'] == 'lang_dlapptips2')) {//官方商城
            continue;
        }
        //
        $val['name'] = get_word($val['name']);
        $val['info'] = get_word($val['info']);
        $bigclass[$val['bigclass']] = 1;
        $adminnav[$val['id']] = $val;
    }
    return $adminnav;
}

/**
 * 获取应用列表
 */
function get_applist()
{
    global $_M;
    $query = "select * from {$_M['table']['applist']} order by no";
    $app_list = DB::get_all($query);
    foreach ($app_list as $app) {
        $app['url'] = "{$_M['url']['site_admin']}index.php?lang={$_M['form']['lang']}&n={$app['m_name']}&c={$app['m_class']}&a={$app['m_action']}";
        $applist[$app['id']] = $app;
    }
    return $applist;
}

/**
 * 向met_tablename中插入表名
 * @param string $tablename 表名称
 */
function add_table($tablenames = '')
{
    global $_M;
    $list = explode('|', $tablenames);
    foreach ($list as $key=>$val) {
        $tablename = $val;
        if (strpos("|{$_M['config']['met_tablename']}|", "|{$tablename}|") === false) {
            $_M['config']['met_tablename'] = "{$_M['config']['met_tablename']}|{$tablename}";
            $query = "UPDATE {$_M['table']['config']} SET value = '{$_M['config']['met_tablename']}' WHERE name='met_tablename'";
            DB::query($query);
            $_M['table'][$tablename] = $_M['config']['tablepre'].$tablename;
        }
    }
}

/**
 * 删除met_tablename中的表名
 * @param string $tablename 表名称
 */
function del_table($tablenames = '')
{
    global $_M;
    $list = explode('|', $tablenames);
    foreach ($list as $key=>$val) {
        $tablename = $val;
        if (strpos("|{$_M['config']['met_tablename']}|", "|{$tablename}|") !== false) {
            $_M['config']['met_tablename'] = trim(str_replace("|{$tablename}|", '|', "|{$_M['config']['met_tablename']}|"), '|');
            $query = "UPDATE {$_M['table']['config']} SET value = '{$_M['config']['met_tablename']}' WHERE name='met_tablename'";
            DB::query($query);
            unset($_M['table'][$tablename]);
        }
    }
}

/**
 * 保存config表配置
 * @param array $config 需要保存的配置的Name数组
 * @param array $config 需要保存的配置的value数组，键值为Name
 * @param array $config 需要保存的配置的语言
 */
function configsave($config = array(), $have = array(), $lang = '')
{
    global $_M;
    if (!$lang) {
        $lang = $_M['lang'];
    }
    if (!$have) {
        $have = $_M['form'];
    }
    $c = copykey($have, $config);
    foreach ($c as $key => $val) {
        $value = mysqlcheck($have[$key]);
        if ($key == 'flash_10001' && $have['mobile'] == '1') {
            if (isset($_M['config'][$key]) && $value != $_M['config'][$key] && (isset($have[$key]) or (isset($have[$key]) && !$have[$key]))) {
                $query = "update {$_M['table']['config']} SET mobile_value = '{$value}' WHERE name = '{$key}' and (lang='{$lang}' or lang='metinfo')";
                DB::query($query);
            }
        } else {
            if (isset($_M['config'][$key]) && $value != $_M['config'][$key] && (isset($have[$key]) or (isset($have[$key]) && !$have[$key]))) {
                $query = "update {$_M['table']['config']} SET value = '{$value}' WHERE name = '{$key}' and (lang='{$lang}' or lang='metinfo')";
                DB::query($query);
            }
        }
    }
    buffer::clearConfig();
}

/**
 * 保存应用配置
 * @param array $config  需要保存的配置的Name数组
 * @param string $app_pre 应用名前缀
 * @param string $have   需要保存的配置的value数组，键值为Name
 * @param string $lang   需要保存的配置的语言
 */
function appconfigsave($config = array(), $appno = '', $have = '', $lang = '')
{
    global $_M;
    if ($lang == '') {
        $lang = $_M['lang'];
    }
    if ($have == '') {
        $have = $_M['form'];
    }
    $c = copykey($have, $config);
    foreach ($c as $key => $val) {
        $value = mysqlcheck($have[$key]);
        if ($appno) {
            $query = "SELECT * FROM {$_M['table']['app_config']} WHERE appno='{$appno}' AND name = '{$key}' AND lang = '{$lang}'";
            if (!DB::get_one($query)) {
                $query = "INSERT INTO {$_M['table']['app_config']} SET appno='{$appno}', name = '{$key}', value = '{$val}', lang='{$lang}'";
                DB::query($query);
            } else {
                if (isset($_M['config'][$key])&&$value!=$_M['config'][$key]&&(isset($have[$key])or(isset($have[$key]) && !$have[$key]))) {
                    $query = "update {$_M['table']['app_config']} SET value = '{$value}' WHERE appno='{$appno}' AND name = '{$key}' AND lang='{$lang}'";
                    DB::query($query);
                }
            }
        }
    }
    buffer::clearConfig();
}

/**
 * 保存config表配置
 * @param string $config Name数组
 */
function mysqlcheck($str)
{
    global $_M;
    $str = stripslashes($str);
    $str = str_replace("'", "''", $str);
    $str = str_replace("\\", "\\\\", $str);
    return $str;
}

function setDbConfig($config)
{
    global $_M;
    $file = PATH_CONFIG . 'config_db.php';
    $db = parse_ini_file($file);
    foreach ($config as $key => $val) {
        $db[$key] = $val;
    }
    if (!isset($db['db_type'])) {
        $db['db_type'] = 'mysql';
        $db['db_name'] = 'config/metinfo.db';
    }
    $string = "<?php\n/*\n";
    foreach ($db as $key => $val) {
        $string .= "{$key} = \"{$val}\"\n";
    }
    $string .= '*/?>';
    $fp = fopen($file, 'w+');
    fputs($fp, $string);
    fclose($fp);
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
