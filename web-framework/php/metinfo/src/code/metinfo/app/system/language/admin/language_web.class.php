<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');
load::sys_func('file');

/** 网站前台语言 */
class language_web extends admin
{
    public $syn;
    public $handle;
    public $column;

    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->handle = load::mod_class('language/class/language_handle', 'new');
        $this->syn = load::mod_class('language/class/language_database', 'new');
        $this->column = load::mod_class('column/column_label', 'new');
    }

    //获取网站语言
    public function doGetWebLanguage()
    {
        global $_M;

        $table = load::sys_class('tabledata', 'new');
        $where = "lang!='metinfo'";
        $language_data = $table->getdata($_M['table']['lang'], '*', $where, "no_order");

        $query = "SELECT value FROM {$_M['table']['config']} WHERE name='met_index_type' and lang='metinfo'";
        $met_index_type = DB::get_one($query);
        $met_index_type = $met_index_type['value'];
        $data['language_data'] = $language_data;
        $data['met_index_type'] = $met_index_type;
        $table->rdata($data);
    }

    //保存编辑语言设置
    public function doSaveEdite()
    {
        global $_M;
        $name = isset($_M['form']['name']) ? $_M['form']['name'] : '';
        $useok = isset($_M['form']['useok']) ? $_M['form']['useok'] : 0;
        $order = isset($_M['form']['order']) ? $_M['form']['order'] : 0;
        $mark = isset($_M['form']['mark']) ? $_M['form']['mark'] : '';
        $flag = isset($_M['form']['flag']) ? $_M['form']['flag'] : '';
        $link = isset($_M['form']['link']) ? $_M['form']['link'] : '';
        $newwindows = isset($_M['form']['newwindows']) ? $_M['form']['newwindows'] : 0;
        $met_index_type = isset($_M['form']['met_index_type']) ? $_M['form']['met_index_type'] : '';   //默认语言

        if ($link) {
            $link = trim($_M['form']['link'], '/') . '/';
        }
        if (!$name || !$mark || !$order) {
            //写日志
            logs::addAdminLog('langwebmanage', 'save', 'js41', 'doSaveEdite');
            $this->error($_M['word']['js41']);
        }

        $query = "SELECT no_order FROM {$_M['table']['lang']} WHERE no_order='{$order}' AND mark!='{$mark}' and lang！= 'metinfo'";
        if (DB::get_one($query)) {
            //写日志
            logs::addAdminLog('langwebmanage', 'edite', 'langnameorder', 'doSaveEdite');
            $this->error($_M['word']['langnameorder']);
        }

        $query = "UPDATE {$_M['table']['lang']} SET
				name          = '{$name}',
				useok         = '{$useok}',
				no_order      = '{$order}',
				mark          = '{$mark}',
				flag          = '{$flag}',
				newwindows    = '{$newwindows}',
				link          = '{$link}'
			    WHERE lang='{$mark}'";
        DB::query($query);

        if ($useok && $met_index_type) {
            $query = "UPDATE {$_M['table']['config']} SET value = '{$mark}' WHERE name='met_index_type'";
            DB::query($query);
        }
        //写日志
        logs::addAdminLog('langwebmanage', 'save', 'jsok', 'doSaveEdite');
        $this->success('', $_M['word']['jsok']);
    }

    //添加语言
    public function doAddLanguage()
    {
        global $_M;
        $name = isset($_M['form']['name']) ? $_M['form']['name'] : '';   //语言名称
        $useok = isset($_M['form']['useok']) ? $_M['form']['useok'] : 0;  //语言状态
        $order = isset($_M['form']['order']) ? $_M['form']['order'] : 0;  //排序
        $mark = isset($_M['form']['mark']) ? $_M['form']['mark'] : '';   //语言标识
        $flag = isset($_M['form']['flag']) ? trim($_M['form']['flag']) : '';   //国旗标志
        $link = isset($_M['form']['link']) ? $_M['form']['link'] : '';   //单独域名
        $newwindows = isset($_M['form']['newwindows']) ? $_M['form']['newwindows'] : 0;  //新窗口打开
        $autor = isset($_M['form']['autor']) ? $_M['form']['autor'] : '';  //选择语言
        $local_lang = isset($_M['form']['file']) ? $_M['form']['file'] : '';   //本地语言
        $theme_style = isset($_M['form']['theme_style']) ? $_M['form']['theme_style'] : '';     //网站主题风格
        $copy_config = isset($_M['form']['copy_config']) ? $_M['form']['copy_config'] : ''; //复制基本设置语言
        $met_index_type = isset($_M['form']['met_index_type']) ? $_M['form']['met_index_type'] : '';    //默认语言
        $content = isset($_M['form']['content']) ? $_M['form']['content'] : '';    //基本内容

        if (!$name) {
            //写日志
            logs::addAdminLog('langwebmanage', 'langadd', 'langnamenull', 'doAddLanguage');
            $this->error($_M['word']['langnamenull']);
        }
        if (!$mark) {
            //写日志
            logs::addAdminLog('langwebmanage', 'langadd', 'langselect1', 'doAddLanguage');
            $this->error($_M['word']['langselect1']);
        }

        $synchronous = $local_lang;
        if ($autor) {
            $mark = $autor;
            $lang = $autor;
        } else {
            $lang = $mark;
        }

        //检查排序或语言标识是否占用
        $query = "SELECT id FROM {$_M['table']['lang']} WHERE `no_order`='{$order}' AND lang!='metinfo'";
        $check_lang_order = DB::get_one($query);
        if ($check_lang_order['id']) {
            //写日志
            logs::addAdminLog('langwebmanage', 'langadd', 'langnameorder', 'doAddLanguage');
            $this->error($_M['word']['langnameorder']);
        }

        $query = "SELECT id FROM {$_M['table']['lang']} WHERE mark='{$mark}'  AND lang!='metinfo'";
        $check_lang = DB::get_one($query);
        if ($check_lang['id']) {
            //写日志
            logs::addAdminLog('langwebmanage', 'langadd', 'langexisted', 'doAddLanguage');
            if (!$autor) {
                $this->error($_M['word']['langnamerepeat']);
            } else {
                $this->error($_M['word']['langexisted']);
            }

        }

        $query = "SELECT met_webhtm,met_htmtype,met_weburl FROM {$_M['table']['lang']} WHERE mark='{$local_lang}'";
        $local_data = DB::get_one($query);

        //写入语言表
        $query = "INSERT INTO {$_M['table']['lang']} SET
					name          = '{$name}',
					useok         = '{$useok}',
					no_order      = '{$order}',
					mark          = '{$mark}',
					synchronous   = '{$synchronous}',
					flag          = '{$flag}',
					link          = '{$link}',
					newwindows    = '{$newwindows}',
					met_webhtm    = '{$local_data['met_webhtm']}',
					met_htmtype   = '{$local_data['$met_htmtype']}',
					met_weburl    = '{$local_data['met_weburl']}',
					lang          = '{$mark}'
				";
        DB::query($query);

        $this->syn->copyconfig($mark, $autor, $local_lang, $copy_config, $theme_style, $content);

        //修改模板的语言参数
        if ($theme_style) {
            $query = "SELECT value FROM {$_M['table']['config']} WHERE name ='met_skin_user' AND lang ='{$theme_style}'";
            $met_skin_user = DB::get_one($query);
            $query = "UPDATE {$_M['table']['config']} SET value='{$met_skin_user['value']}' WHERE name ='met_skin_user' AND lang ='{$lang}'";
            DB::query($query);
        } else {
            $query = "UPDATE {$_M['table']['config']} SET value='' WHERE name ='met_skin_user' AND lang ='{$lang}'";
            DB::query($query);
        }

        if ($met_index_type && $useok) {
            $met_index_type = $mark ? $mark : $autor;
            $query = "UPDATE {$_M['table']['config']} SET value = '{$met_index_type}' WHERE name='met_index_type'";
            DB::query($query);
        }

        //复制基本设置
        if ($copy_config) {
            $query = "SELECT name,access FROM {$_M['table']['user_group']} WHERE lang = '{$copy_config}'";
            $admin_list = DB::get_all($query);
            foreach ($admin_list as $key => $value) {
                $query = "INSERT INTO {$_M['table']['user_group']} SET name = '{$value['name']}',access='{$value['access']}',lang='{$autor}'";
                DB::query($query);
            }

            $query = "SELECT * FROM {$_M['table']['app_config']} WHERE lang = '{$_M['form']['langconfig']}' ";
            $app_config = DB::get_all($query);
            foreach ($app_config as $app_config_value) {
                $new_app_config = $app_config_value;
                $new_app_config['lang'] = $mark;
                unset($new_app_config['id']);
                $sql = get_sql($new_app_config);
                $query = "INSERT INTO {$_M['table']['app_config']} SET {$sql}";
                DB::query($query);
            }

        }

        //写日志
        logs::addAdminLog('langwebmanage', 'langadd', 'jsok', 'doAddLanguage');
        $this->success('', $_M['word']['jsok']);
    }

    //删除语言
    public function doDeleteLanguage()
    {
        global $_M;
        if (!isset($_M['form']['id'])) {
            $this->error($_M['word']['js41']);
        }

        $id = $_M['form']['id'];
        if (!$id) {
            $this->error($_M['word']['js41']);
        }

        $query = "SELECT lang FROM {$_M['table']['lang']}  WHERE lang!='metinfo' AND id='{$id}'";
        $lang_info = DB::get_one($query);
        if (!$lang_info) {
            //写日志
            logs::addAdminLog('langwebmanage', 'delete', 'js41', 'doDeleteLanguage');
            $this->error($_M['word']['js41']);
        }

        //唯一语言不可删除
        $query = "SELECT id FROM {$_M['table']['lang']} order by no_order where lang!='metinfo'";
        $lang_data = DB::get_all($query);
        if (count($lang_data) == 1) {
            //写日志
            logs::addAdminLog('langwebmanage', 'delete', 'langone', 'doDeleteLanguage');
            $this->error($_M['word']['langone']);
        }

        //默认语言不可删除
        if ($lang_info['lang'] == $_M['config']['met_index_type']) {
            //写日志
            logs::addAdminLog('langwebmanage', 'delete', 'langadderr5', 'doDeleteLanguage');
            $this->error($_M['word']['langadderr5']);
        }

        //替换数据表里带语言参数的数据
        $excepted = array(
            "lang_admin",
        );
        $query = "SELECT id FROM {$_M['table']['lang']} order by no_order where lang!='metinfo'";
        $lang_data = DB::get_all($query);
        if (count($lang_data) == 1) {
            //写日志
            logs::addAdminLog('langwebmanage', 'delete', 'langone', 'doDeleteLanguage');
            $this->error($_M['word']['langone']);
        }

        foreach ($_M['table'] as $key => $table_name) {
            if (!$table_name || in_array($key, $excepted)) {
                continue;
            }

            $query = "DELETE FROM {$table_name} WHERE lang ='{$lang_info['lang']}'";
            if ($table_name == "{$_M['config']['tablepre']}language") {
                $query .= " AND site ='0'";
            }
            DB::query($query);
        }

        //栏目处理
        $query = "SELECT id,releclass,classtype,lang,module,foldername,indeximg,columnimg,if_in FROM {$_M['table']['column']} where lang='{$lang_info['lang']}'";
        $column_data = DB::get_all($query);
        foreach ($column_data as $value) {
            $this->handle->delcolumn($value);
        }
        setcookie("admin_lang", '', 0, '/');

        //写日志
        logs::addAdminLog('langwebmanage', 'delete', 'physicaldelok', 'doDeleteLanguage');
        $this->success('', $_M['word']['physicaldelok']);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>