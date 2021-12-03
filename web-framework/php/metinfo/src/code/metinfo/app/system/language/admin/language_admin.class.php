<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');
load::sys_func('file');

/** 网站后台语言 */
class language_admin extends admin
{

    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->handle = load::mod_class('language/class/language_handle', 'new');
        $this->column = load::mod_class('column/column_label', 'new');
    }

    //获取后台语言列表
    public function doGetAdminLanguage()
    {
        global $_M;

        $table = load::sys_class('tabledata', 'new');
        $where = "lang!='metinfo'";
        $lang_list = $table->getdata($_M['table']['lang_admin'], '*', $where, "no_order");

        foreach ($lang_list as $key => $value) {
            if (!$value['login_time']) {
                $lang_list[$key]['login_time'] = $value['register_time'];
            }
            $lang_list[$key]['met_admin_type'] = isset($_M['config']['met_admin_type']) ? $_M['config']['met_admin_type'] : '';
        }

        $table->rdata($lang_list);
    }

    //添加后台语言
    public function doAddLanguage()
    {
        global $_M;
        if (!isset($_M['form']['mark']) || !isset($_M['form']['autor']) || !isset($_M['form']['name']) || !isset($_M['form']['useok']) || !isset($_M['form']['order'])) {
            $this->error($_M['word']['jsx10']);
        }

        $mark = $_M['form']['mark'];
        $order = $_M['form']['order'];
        $name = $_M['form']['name'];
        $useok = $_M['form']['useok'];
        $file = $_M['form']['file'];

        if (!$mark || !$name) {
            $this->error($_M['word']['js36']);
        }

        //检测语言是否已存在
        $query = "SELECT id FROM {$_M['table']['lang_admin']} WHERE mark = '{$mark}' OR lang = '{$mark}' OR no_order = '{$order}'";
        if (DB::get_one($query)) {
            //写日志
            logs::addAdminLog('langadmin', 'langadd', 'langexisted', 'doAddLanguage');
            $this->error($_M['word']['langexisted']);
        };

        //添加后台语言
        $query = "INSERT INTO {$_M['table']['lang_admin']} SET `name`='{$name}',`useok`='{$useok}',`mark`='{$mark}',`no_order`='{$order}',`synchronous`='{$file}',`lang`='{$mark}'";
        DB::query($query);

        //复制本地后台语言
        $query = "SELECT name,value,array,app FROM {$_M['table']['language']} WHERE lang='{$file}' AND `site`=1";
        $language_data = DB::get_all($query);
        foreach ($language_data as $key => $val) {
            $val['value'] = str_replace("'", "''", $val['value']);
            $val['value'] = str_replace("\\", "\\\\", $val['value']);
            $val['lang'] = $mark;
            $val['site'] = 1;
            unset($val['id']);
            $sql = get_sql($val);
            $query = "INSERT INTO {$_M['table']['language']} SET {$sql}";
            DB::query($query);
        }

        //默认语言
        if (isset($_M['form']['met_admin_type']) && $_M['form']['met_admin_type'] == 1 && $mark) {
            $query = "UPDATE {$_M['table']['config']} SET value = '{$mark}' WHERE name ='met_admin_type'";
            DB::query($query);
        } else {
            $query = "UPDATE {$_M['table']['config']} SET value = 'cn' WHERE name ='met_admin_type'";
            DB::query($query);
        }
        //写日志
        logs::addAdminLog('langadmin', 'langadd', 'jsok', 'doAddLanguage');
        $this->clear_lang_cache();
        $this->success('', $_M['word']['jsok']);
    }

    //清除语言缓存
    public function clear_lang_cache()
    {
        global $_M;
        if (file_exists(PATH_WEB . 'cache')) {
            $files = scandir(PATH_WEB . 'cache');
            foreach ($files as $val) {
                if (strstr($val, "lang")) {
                    delfile(PATH_WEB . 'cache/' . $val);
                }
            }
        }
    }

    //删除后台语言
    public function doDeleteLanguage()
    {
        global $_M;
        if (!isset($_M['form']['id'])) {
            $this->error($_M['word']['jsx10']);
        }
        $id = $_M['form']['id'];
        $query = "SELECT mark FROM {$_M['table']['lang_admin']} WHERE id = '{$id}'";
        $lang_data = DB::get_one($query);

        $met_admin_type = isset($_M['config']['met_admin_type']) ? $_M['config']['met_admin_type'] : '';
        if (!$met_admin_type) {
            $this->error($_M['word']['js36']);
        }

        if ($lang_data['mark'] == $met_admin_type) {
            //写日志
            logs::addAdminLog('langadmin', 'delete', 'langadderr5', 'doDeleteLanguage');
            $this->error($_M['word']['langadderr5']);
        }

        //删除后台语言
        $query = "DELETE FROM {$_M['table']['lang_admin']} WHERE lang='{$lang_data['mark']}'";
        DB::query($query);
        $query = "DELETE FROM {$_M['table']['language']} WHERE lang='{$lang_data['mark']}' AND site = 1";
        DB::query($query);
        $query = "UPDATE {$_M['table']['admin_table']} SET admin_login_lang = '' WHERE admin_login_lang ='{$lang_data['mark']}'";
        DB::query($query);

        setcookie("admin_lang", '', 0, '/');
        //写日志
        logs::addAdminLog('langadmin', 'delete', 'physicaldelok', 'doDeleteLanguage');
        $this->success('', $_M['word']['physicaldelok']);
    }

    //编辑
    public function doEditor()
    {
        global $_M;
        if (!isset($_M['form']['mark']) || !isset($_M['form']['met_admin_type']) || !isset($_M['form']['name']) || !isset($_M['form']['useok']) || !isset($_M['form']['order'])) {
            $this->error($_M['word']['jsx10']);
        }
        $name = $_M['form']['name'];
        $order = $_M['form']['order'];
        $mark = $_M['form']['mark'];
        if (!$mark || !$name) {
            $this->error($_M['word']['js41']);
        }

        //修改后台语言设置
        $query = "SELECT id FROM {$_M['table']['lang_admin']} WHERE (`name`='{$name}' OR `no_order`='{$order}') AND lang != '{$mark}'";
        if (DB::get_one($query)) {
            //写日志
            logs::addAdminLog('langadmin', 'editor', 'loginFail', 'doEditor');
            $this->error($_M['word']['loginFail']);
        }

        $query = "UPDATE {$_M['table']['lang_admin']} SET `name`='{$name}',`useok`='{$_M['form']['useok']}',`no_order`='{$order}' WHERE lang = '{$mark}'";
        DB::query($query);

        //默认语言
        if ($_M['form']['met_admin_type'] == 1 && $mark) {
            $query = "UPDATE {$_M['table']['config']} SET value = '{$mark}' WHERE name ='met_admin_type'";
            DB::query($query);
        } else {
            $query = "UPDATE {$_M['table']['config']} SET value = 'cn' WHERE name ='met_admin_type'";
            DB::query($query);
        }
        //写日志
        logs::addAdminLog('langadmin', 'editor', 'jsok', 'doEditor');
        $this->success('', $_M['word']['jsok']);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>