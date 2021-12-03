<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');
load::sys_func('file');

/** 语言通用设置 */
class language_general extends admin
{
    public $syn;

    public function __construct()
    {
        global $_M;
        $this->syn = load::mod_class('language/language_database', 'new');
        parent::__construct();
    }

    //获取国旗标志
    public function doGetNationalFlag()
    {
        global $_M;
        $dir = PATH_PUBLIC . 'images/flag';
        $handle = opendir($dir);
        $url = $_M['url']['public_images'] . 'flag/';
        while (false !== $file = (readdir($handle))) {
            if ($file !== '.' && $file != '..') {
                $flags[] = $file;
            }
        }
        closedir($handle);
        $k = count($flags);
        $data = array();
        for ($i = 0; $i < $k; $i++) {
            $data[] = $url . $flags[$i];
        }

        $this->success($data);
    }


    //获取语言通用设置
    public function doGetGeneral()
    {
        global $_M;
        $data = array();

        $data['met_admin_type_ok'] = isset($_M['config']['met_admin_type_ok']) ? (int)$_M['config']['met_admin_type_ok'] : 0;
        $data['met_lang_mark'] = isset($_M['config']['met_lang_mark']) ? (int)$_M['config']['met_lang_mark'] : 0;
        $data['met_ch_lang'] = isset($_M['config']['met_ch_lang']) ? (int)$_M['config']['met_ch_lang'] : 0;

        $this->success($data);
    }


    //语言数据更新
    public function doSave()
    {
        global $_M;
        //保存配置信息
        $configlist = array();
        $configlist[] = 'met_ch_lang';
        $configlist[] = 'met_lang_mark';
        $configlist[] = 'met_admin_type_ok';
        configsave($configlist);
        //写日志
        logs::addAdminLog('indexlang', 'save', 'jsok', 'doSave');
        $this->success('', $_M['word']['jsok']);
    }


    //导出语言包
    public function doExportPack()
    {
        global $_M;

        if (!isset($_M['form']['editor']) || !$_M['form']['editor']) {
            $this->error($_M['word']['js41']);
        }

        $editor = $_M['form']['editor'];
        $site = isset($_M['form']['site']) ? $_M['form']['site'] : '';
        $appno = $_M['form']['appno'] ? $_M['form']['appno'] : '';
        $filename = PATH_WEB . 'cache/language_' . $site . '_' . $editor . '.ini';
        if (!$editor || !$site) {
            $this->error($_M['word']['js41']);
        }

        delfile($filename);

        //获取后台语言包
        $this->get_pack($appno, $site, $editor);

        $filename = realpath($filename);
        header("");
        Header("Content-type:  application/octet-stream ");
        Header("Accept-Ranges:  bytes ");
        Header("Accept-Length: " . filesize($filename));
        header("Content-Disposition:  attachment;  filename=language_{$site}_" . $appno . '_' . $editor . ".ini");
        //写日志
        $log_name = $_M['form']['site'] ? 'langadmin' : 'langweb';
        logs::addAdminLog($log_name, 'language_outputlang_v6', 'jsok', 'doExportPack');
        readfile($filename);
    }

    //获取语言包
    public function get_pack($appno = '', $site = '', $editor = '')
    {
        global $_M;
        $sql = $appno ? " AND app = '{$appno}' " : " AND app = 0 ";
        $language_data = array();
        if ($site == 'admin') {
            $query = "SELECT name,value FROM {$_M['table']['language']} WHERE lang='{$editor}' AND site ='1' {$sql}";
            $language_data = DB::get_all($query);
            $lang_pack_url = PATH_WEB . 'cache/language_admin_' . $editor . '.ini';
        } else if ($site == 'web') {
            $query = "SELECT name,value FROM {$_M['table']['language']} WHERE lang='{$editor}' AND site ='0' {$sql}";
            $language_data = DB::get_all($query);
            $lang_pack_url = PATH_WEB . 'cache/language_web_' . $editor . '.ini';
        }

        foreach ($language_data as $key => $val) {
            file_put_contents($lang_pack_url, $val['name'] . '=' . $val['value'] . PHP_EOL, FILE_APPEND);
        }
    }

    //批量替换语言数据
    public function doBatchReplace()
    {
        global $_M;
        if (!isset($_M['form']['textarea']) || !isset($_M['form']['editor']) || !isset($_M['form']['site'])) {
            $this->error($_M['word']['jsx10']);
        }

        $update_data = preg_replace("/\'/", "''", $_M['form']['textarea']);
        $editor = $_M['form']['editor'];
        $log_name = $_M['form']['site'] ? 'langadmin' : 'langweb';
        $site = $_M['form']['site'] == 'admin' ? 1 : 0;
        $appno = isset($_M['form']['appno']) ? $_M['form']['appno'] : '';

        if (!$update_data || !$editor) {
            //写日志
            logs::addAdminLog($log_name, 'language_batchreplace_v6', 'js41', 'doBatchReplace');
            $this->error($_M['word']['js41']);
        }

        $sql = $appno ? " AND app = '{$appno}' " : '';
        $insert_sql = $appno ? " , app = '{$appno}' " : '';

        $language_list = explode(PHP_EOL, $update_data);
        foreach ($language_list as $key => $value) {
            $language_data = explode('=', $value);
            $query = "SELECT id FROM {$_M['table']['language']} WHERE name='{$language_data[0]}' AND lang='{$editor}' AND site ='{$site}' {$sql}";

            if (DB::get_one($query)) {
                $query = "UPDATE {$_M['table']['language']} SET value='{$language_data[1]}' WHERE name='{$language_data[0]}' AND lang='{$editor}' AND site ='{$site}' {$sql}";
            } else {
                $query = "INSERT INTO {$_M['table']['language']} SET value='{$language_data[1]}',site='{$site}',name='{$language_data[0]}',lang='{$editor}' {$insert_sql}";
            }
            DB::query($query);
        }
        //写日志
        logs::addAdminLog($log_name, 'language_batchreplace_v6', 'jsok', 'doBatchReplace');
        $this->success('', $_M['word']['jsok']);

    }


    //同步系统语言数据
    public function doSynLanguage()
    {
        global $_M;
        if (!isset($_M['form']['editor']) || !isset($_M['form']['site']) || !$_M['form']['editor'] || !$_M['form']['site']) {
            $this->error($_M['word']['jsx10']);
        }

        $editor = $_M['form']['editor'];
        $new_lang_type = $_M['form']['site'];
        $post = array('lang' => $editor, 'type' => $new_lang_type, 'action' => 'updateLanguage');
        $site = $new_lang_type == 'admin' ? 1 : 0;
        $file_basicname = PATH_WEB . $_M['config']['met_adminfile'] . '/update/lang/lang_' . $new_lang_type . '_' . $editor . '.ini';
        $sys_result = $this->syn->syn_lang($post, $file_basicname, $editor, $site);
        $log_name = $_M['form']['site'] == 'admin' ? 'langadmin' : 'langweb';

        if ($sys_result == 1) {
            $this->clear_lang_cache();
            //写日志
            logs::addAdminLog($log_name, 'unitytxt_9', 'jsok', 'doSynLanguage');
            $this->success('', $_M['word']['jsok']);
        }
        //写日志
        logs::addAdminLog($log_name, 'unitytxt_9', 'langadderr4', 'doSynLanguage');
        $this->error($_M['word']['langadderr4']);

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

    //获取应用语言
    public function doGetAppList()
    {
        global $_M;
        if (!isset($_M['form']['site']) || !isset($_M['form']['editor'])) {
            $this->error($_M['word']['jsx10']);
        }

        $query = "SELECT id,no,appname FROM {$_M['table']['applist']} WHERE `no` > 0 AND `mlangok`=1 ORDER BY id ASC";
        $app_list = DB::get_all($query);

        $this->success($app_list);
    }

    //搜索语言参数
    public function doSearchParameter()
    {
        global $_M;
        if (!isset($_M['form']['word']) || !isset($_M['form']['site']) || !isset($_M['form']['editor'])) {
            $this->error('empty');
        }

        $site = $_M['form']['site'] == 'admin' ? 1 : 0;
        $no = $_M['form']['appno'] ? $_M['form']['appno'] : 0;
        $editor = $_M['form']['editor'];
        $word = $_M['form']['word'];

        $query = "SELECT name,value FROM {$_M['table']['language']} WHERE `value` like '%{$word}%' AND `app`='{$no}' AND `site`='{$site}' AND `lang`='{$editor}'";
        $language_data = DB::get_all($query);

        $this->success($language_data);
    }

    //编辑语言参数
    public function doModifyParameter()
    {
        global $_M;
        $site = $_M['form']['site'] == 'admin' ? 1 : 0;
        $no = isset($_M['form']['appno']) ? $_M['form']['appno'] : 0;
        $editor = $_M['form']['editor'];
        $data = $_M['form']['data'];
        $log_name = $_M['form']['site'] == 'admin' ? 'langadmin' : 'langweb';

        if (!$editor) {
            //写日志
            logs::addAdminLog($log_name, 'langwebeditor', 'js41', 'doModifyParameter');
            $this->error($_M['word']['js41']);
        }

        foreach ($data as $name => $value) {
            $query = "SELECT * FROM {$_M['table']['language']} WHERE site='{$site}' AND app='{$no}' AND lang='{$editor}' AND name = '{$name}' ORDER BY no_order";
            $word = DB::get_one($query);

            if (isset($word['value']) && $value != '') {
                $value  = stripslashes($value);
                $value  = preg_replace("/\'/", "''", $value);
                $query = "UPDATE {$_M['table']['language']} SET value='{$value}' WHERE id='{$word['id']}'";
                DB::query($query);
            }
        }

        //清除语言缓存
        $this->clear_lang_cache();
        //写日志
        logs::addAdminLog($log_name, 'langwebeditor', 'jsok', 'doModifyParameter');
        $this->success('', $_M['word']['jsok']);
    }


    //删除没用的语言
    public function dodel_many_language()
    {
        global $_M;
        $dir = PATH_WEB . 'app/system';

        $lang_file = fopen(PATH_WEB . 'install/config_en.sql', 'r+');
        if (!$lang_file) {
            echo '错误';
            exit();
        }
        while (!feof($lang_file)) {
            $line = fgets($lang_file);
            preg_match("/null\, \'(\w+)\'/u", $line, $mat);

            if (!$mat[1] || strstr($line, '50002') || !strstr($line, 'met_language')) {
                continue;
            }
            $file_name = $this->createZip(opendir($dir), $dir, $mat[1]);
            if (!$file_name) {

                $select = DB::get_one("SELECT id FROM met_admin_column WHERE name='lang_{$mat[1]}'");
                if ($select) {
                    continue;
                }
                $len = strlen($line);
                fseek($lang_file, ftell($lang_file) - $len);
                fwrite($lang_file, str_pad('', $len, ' '));
            }
        }
        fclose($lang_file);
    }

    function createZip($openFile, $sourceAbso, $lang)
    {
        while (($file = readdir($openFile)) != false) {
            if ($file == "." || $file == "..")
                continue;

            /*源目录路径(绝对路径)*/
            $sourceTemp = $sourceAbso . '/' . $file;
            if (is_dir($sourceTemp)) {
                $flag = $this->createZip(opendir($sourceTemp), $sourceTemp, $lang);
                if ($flag) {
                    return $flag;
                }
            }
            if (is_file($sourceTemp) && (strstr($sourceTemp, '.js') || strstr($sourceTemp, '.php'))) {
                $read = file_get_contents($sourceTemp);
                if (strstr($sourceTemp, '.js')) {
                    preg_match("/METLANG\.{$lang}/", $read, $preg_matches);
                    if ($preg_matches) {
                        return $preg_matches[0];
                    }

                }
                if (strstr($sourceTemp, '.php')) {
                    preg_match("/\_M\[\'word\'\]\[\'{$lang}\'\]/", $read, $preg_matches);
                    if (!$preg_matches) {
                        preg_match("/\_M\[word\]\[{$lang}\]/", $read, $preg_matches);
                        if (!$preg_matches) {
                            preg_match("/word\.{$lang}/", $read, $preg_matches);
                            if (!$preg_matches) {
                                preg_match("/word\[\'{$lang}\'\]/", $read, $preg_matches);
                                if (!$preg_matches) {
                                    preg_match("/word\[{$lang}\]/", $read, $preg_matches);
                                }
                            }

                        }
                    }

                    if ($preg_matches) {
                        return $preg_matches[0];
                    }
                }

            }
        }
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>