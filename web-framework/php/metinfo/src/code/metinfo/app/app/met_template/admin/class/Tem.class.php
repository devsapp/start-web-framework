<?php

// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

class Tem
{
    /**
     * 获取模板列表.
     *
     * @return array
     */
    public function listTemplates()
    {
        global $_M;

        $online = $this->getOnlineTemplates();
        $local = $this->getLocalTemplates();
        $data = array_merge($online, $local);
        $temlist = array();
        foreach ($data as $skin_name => $view) {
            $temp = array();
            $temp['skin_name'] = $skin_name;
            $temp['view'] = $view;
            $has = $this->getSkin($skin_name);

            if ($has) {
                if ($_M['config']['met_skin_user'] == $skin_name) {
                    $temp['enable'] = 1;
                } else {
                    $temp['enable'] = 0;
                }
                $temp['version'] = $has['ver'] ? $has['ver'] : '1.0';
            } else {
                if (file_exists(PATH_WEB.'templates/'.$skin_name.'/ui.json')) {
                    $temp['import'] = 1;
                } else {
                    $temp['install'] = 1;
                }
            }

            $temlist[] = $temp;
        }

        return $temlist;
    }

    public function updateUiList($skin_name = '')
    {
        global $_M;
        $tem_path = PATH_WEB.'templates/'.$skin_name;
        $ui_json = $tem_path.'/ui.json';
        $uilist = array();
        if (!file_exists($ui_json)) {
            error('模板配置文件不存在');
        }

        $config = json_decode(file_get_contents($ui_json), true);
        if (!$config) {
            error('模板配置文件不正确');
        }

        foreach ($config['page'] as $page) {
            foreach ($page as $key => $val) {
                $ui = $val;
                $ui['skin_name'] = $skin_name;
                $ui['ui_installtime'] = $val['ui_edittime'] = time();
                $query = "SELECT * FROM {$_M['table']['ui_list']} WHERE installid = '{$val['installid']}' AND parent_name = '{$val['parent_name']}' AND ui_name = '{$val['ui_name']}' AND skin_name = '{$skin_name}'";
                $has = DB::get_one($query);
                if (!$has) {
                    unset($ui['config']);
                    DB::insert($_M['table']['ui_list'], $ui);
                    foreach ($val['config'] as $c) {
                        $c['skin_name'] = $skin_name;
                        $c['lang'] = $_M['lang'];
                        $query = "SELECT * FROM {$_M['table']['ui_config']} WHERE pid = '{$c['pid']}' AND parent_name = '{$c['parent_name']}' AND ui_name = '{$c['ui_name']}' AND skin_name = '{$skin_name}' AND lang = '{$_M['lang']}'";
                        $hasConfig = DB::get_one($query);
                        if (!$hasConfig) {
                            DB::insert($_M['table']['ui_config'], $c);
                        }
                    }
                }
            }
        }
    }

    /**
     * 导入模板
     *
     * @param $skin_name
     *
     * @return array
     */
    public function import($skin_name = '')
    {
        global $_M;

        $tem_path = PATH_WEB.'templates/'.$skin_name;
        $ui_json = $tem_path.'/ui.json';
        $uilist = array();
        if (!file_exists($ui_json)) {
            error('模板配置文件不存在');
        }
        $this->clearUI($skin_name);
        $config = json_decode(file_get_contents($ui_json), true);
        if (!$config) {
            error('模板配置文件不正确');
        }
        foreach ($config['page'] as $page) {
            foreach ($page as $key => $val) {
                if (!file_exists($tem_path.'/ui/'.$val['parent_name'].'/'.$val['ui_name'])) {
                    $uilist[] = $val['parent_name'].'/'.$val['ui_name'];
                }
                $ui = $val;
                $ui['skin_name'] = $skin_name;
                $ui['ui_installtime'] = $val['ui_edittime'] = time();
                unset($ui['config']);
                DB::insert($_M['table']['ui_list'], $ui);
                foreach ($val['config'] as $c) {
                    $c['skin_name'] = $skin_name;
                    $c['lang'] = $_M['lang'];
                    DB::insert($_M['table']['ui_config'], $c);
                }
            }
        }

        foreach ($config['global'] as $g) {
            unset($g['id']);
            $g['skin_name'] = $skin_name;
            $g['lang'] = $_M['lang'];
            DB::insert($_M['table']['ui_config'], $g);
        }
        self::downloadParse();
        $this->createSkin($skin_name);

        return $uilist;
    }

    /**
     * 导入UI.
     *
     * @param $skin_name
     */
    public function importUi($skin_name = '')
    {
        global $_M;
        $json = PATH_WEB.'templates/'.$skin_name.'/ui.json';
        $uiconfig = json_decode(file_get_contents($json), true);
        foreach ($uiconfig['page'] as $page) {
            foreach ($page as $key => $val) {
                $ui = $val;
                unset($ui['config']);
                $this->updateUi($skin_name, $ui);
            }
        }
    }

    /**
     * ui升级.
     *
     * @param $skin_name
     * @param $ui
     *
     * @return string
     */
    public function updateUi($skin_name = '', $ui = array())
    {
        global $_M;

        $ui_json = PATH_WEB.'templates/'.$skin_name.'/ui/'.$ui['parent_name'].'/'.$ui['ui_name'].'/install.json';

        if (!file_exists($ui_json)) {
            return $ui_json.'不存在';
        }

        $json = json_decode(file_get_contents($ui_json), true);

        $version = $json['ui']['ui_version'];
        $ui['ui_version'] = $version;

        $query = "SELECT * FROM {$_M['table']['ui_list']} WHERE skin_name = '{$skin_name}' AND parent_name = '{$ui['parent_name']}' AND ui_name= '{$ui['ui_name']}'";

        $has = DB::get_one($query);

        if ($has) {
            $query = "UPDATE {$_M['table']['ui_list']} SET ui_version='{$ui['ui_version']}' WHERE parent_name = '{$ui['parent_name']}' AND ui_name='{$ui['ui_name']}' AND skin_name = '{$skin_name}'";
            DB::query($query);
            $pid = $ui['installid'];
        } else {
            $pid = $ui['installid'];
        }

        foreach ($json['config'] as $key => $val) {
            $query = "SELECT * FROM {$_M['table']['ui_config']} WHERE uip_key = '{$val['uip_key']}' AND parent_name = '{$val['parent_name']}' AND ui_name = '{$val['ui_name']}' AND skin_name = '{$skin_name}' AND pid = {$pid} AND lang = '{$_M['lang']}'";
            $uiconfig = DB::get_one($query);
            if ($uiconfig) {
                $query = "UPDATE {$_M['table']['ui_config']} SET uip_type='{$val['uip_type']}',uip_name='{$val['uip_name']}',uip_title='{$val['uip_title']}',uip_order={$val['uip_order']},uip_select='{$val['uip_select']}',uip_hidden='{$val['uip_hidden']}',uip_default='{$val['uip_default']}',lang='{$_M['lang']}',uip_description='{$val['uip_description']}' WHERE id = {$uiconfig['id']}";
                DB::query($query);
            } else {
                $val['lang'] = $_M['lang'];
                $val['skin_name'] = $skin_name;
                $val['pid'] = $pid;
                $row = DB::insert($_M['table']['ui_config'], $val);
                if (!$row) {
                    return DB::error();
                }
            }
        }
    }

    /**
     * 下载UI文件.
     *
     * @param $skin_name
     * @param $ui_name
     * @param int $update
     *
     * @return array
     */
    public function downloadUI($skin_name = '', $ui_name = '', $update = 0)
    {
        global $_M;
        $ui_path = PATH_WEB.'templates/'.$skin_name.'/ui/'.$ui_name;
        if (!file_exists($ui_path)) {
            mkdir($ui_path, 0777, true);
        } else {
            if (!$update) {
                return array('ui_name' => $ui_name);
            }
        }
        $data = array(
            'action' => 'downloadUI',
            'skin_name' => $skin_name,
            'ui_name' => $ui_name,
        );

        $result = api_curl($_M['config']['met_api'], $data);

        $res = json_decode($result, true);

        if ($res['status'] != 200) {
            file_put_contents(PATH_WEB.'cache/test.txt', var_export($result, true), FILE_APPEND);
            error($res['msg']);
        }

        $cache = PATH_WEB.'cache/ui';
        if (!file_exists($cache)) {
            mkdir($cache, 0777, true);
        }

        $cache_zip = $cache.'/'.str_replace('/', '#', $ui_name).'.zip'; //ui缓存

        file_put_contents($cache_zip, base64_decode($res['data']));
        $zip = new ZipArchive();
        if ($zip->open($cache_zip) === true) {
            $zip->extractTo($ui_path);
            $zip->close();
        }

        return array('ui_name' => $ui_name);
    }

    /**
     * 检测UI解析类.
     *
     * @return bool
     */
    public function checkUiParse()
    {
        global $_M;
        $ui = PATH_ALL_APP.'met_template/include/class/ui_tag.class.php';

        return file_exists($ui);
    }

    /**
     * 从线上下载安装模板
     */
    public function install($skin_name = '')
    {
        global $_M;

        $this->downloadTemplate($skin_name);

        // 模板文件下载完先导入
        $local_ui = $this->import($skin_name);

        // 从模板配置文件中导入UI数据
        $this->importUi($skin_name);

        return $local_ui;
    }

    public function enable($skin_name = '', $status = 1)
    {
        global $_M;
        // $this->update($skin_name);

        $status = $this->setCurrentSkin($skin_name);
        $this->copyUiConfig($skin_name);
        if (file_exists(PATH_CACHE.'templates')) {
            // 防止删错
            deldir(PATH_CACHE);
        }

        return $status;
    }

    /**
     * 切换到新语言启用模板，复制一份uiconfig配置到当前语言
     */
    public function copyUiConfig($skin_name = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['ui_config']} WHERE skin_name = '{$skin_name}' AND lang = '{$_M['lang']}'";
        $has = DB::get_one($query);
        if ($has) {
            return;
        }
        $query = "SELECT * FROM {$_M['table']['ui_config']} WHERE skin_name = '{$skin_name}' AND lang != '{$_M['lang']}'";
        $config = DB::get_one($query);
        if ($config) {
            $lang = $config['lang'];
            $query = "SELECT * FROM {$_M['table']['ui_config']} WHERE skin_name = '{$skin_name}' AND lang = '{$lang}'";
            $configs = DB::get_all($query);
            foreach ($configs as $val) {
                unset($val['id']);
                $val['lang'] = $_M['lang'];
                $row = DB::insert($_M['table']['ui_config'], $val);
                if (!$row) {
                    die(DB::error());
                }
            }
        }
    }

    public function delete($skin_name = '')
    {
        global $_M;
        $this->deleteSkin($skin_name);

        return true;
    }

    /**
     * 检测模板和UI是否需要升级.
     */
    public function check($skin_name = '')
    {
        global $_M;

        // 检测模板是否可以升级
        $ver = $this->checkTemplateUpdate($skin_name);
        if ($ver) {
            return $ver;
        }

        // 检测是否有UI需要升级
        $uilist = $this->checkUiUpdate($skin_name);

        return $uilist;
    }

    public function update($skin_name = '')
    {
        global $_M;

        $ver = $this->checkTemplateUpdate($skin_name, '1.0');
        if ($ver) {
            $this->downloadTemplate($skin_name);
            $this->updateUiList($skin_name);
            $this->updateSkinVersion($skin_name, $ver);
        }

        $uilist = $this->checkUiUpdate($skin_name);
        foreach ($uilist as $key => $val) {
            $this->downloadUI($skin_name, $val, 1);
        }
        sleep(1);
        $this->importUi($skin_name);

        return true;
    }

    /**
     * 检测是否有UI需要升级.
     *
     * @param $skin_name
     *
     * @return bool|mixed
     */
    public function checkUiUpdate($skin_name = '')
    {
        global $_M;
        $uilist = $this->listSkinUi($skin_name);
        if (!$uilist) {
            $uilist = $this->uiList($skin_name);
        }
        $tem_path = PATH_WEB.'templates/'.$skin_name;
        $data = array();

        foreach ($uilist as $key => $val) {
            if (is_numeric($key)) {
                $uiname = $val['parent_name'].'/'.$val['ui_name'];
                $version = $val['ui_version'];
            } else {
                $uiname = $key;
                $version = $val;
            }

            if (!file_exists($tem_path.'/ui/'.$uiname.'/install.json')) {
                $data[$uiname] = -1;
            } else {
                $data[$uiname] = $version;
            }
        }

        if (!$data) {
            return false;
        }

        $string = base64_encode(json_encode($data));
        $data['action'] = 'checkUiUpdate';
        $data['skin_name'] = $skin_name;
        $data['string'] = $string;
        $result = api_curl($_M['config']['met_api'], $data);
        $res = json_decode($result, true);
        if ($res['status'] != 200) {
            return false;
        }

        $result = json_decode(base64_decode($res['data']), true);

        return $result;
    }

    /**
     * 获取模板UI列表.
     *
     * @param $skin_name
     *
     * @return array
     */
    public function listSkinUi($skin_name = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['ui_list']} WHERE skin_name = '{$skin_name}'";

        return DB::get_all($query);
    }

    /**
     * 获取线上模板UI列表.
     *
     * @param $skin_name
     *
     * @return mixed
     */
    public function uiList($skin_name = '')
    {
        global $_M;
        $data = array(
            'action' => 'uiList',
            'skin_name' => $skin_name,
        );
        $result = api_curl($_M['config']['met_api'], $data);
        $res = json_decode($result, true);
        if ($res['status'] != 200) {
            error($res['msg']);
        }

        return json_decode(base64_decode($res['data']), true);
    }

    /**
     * 下载演示数据.
     *
     * @param $skin_name
     * @param $piece
     *
     * @return mixed
     */
    public function downloadData($skin_name = '', $piece = '')
    {
        global $_M;
        // return array('status'=>200,'total'=>3,'piece'=>2);
        $skin_zip = PATH_WEB.'cache/'.$skin_name.'.zip';
        if (!$piece && file_exists($skin_zip)) {
            @unlink($skin_zip);
        }
        $data = array(
            'action' => 'downloadShowData',
            'skin_name' => $skin_name,
            'piece' => $piece,
        );
        $result = api_curl($_M['config']['met_api'], $data);
        $res = json_decode($result, true);

        if ($res['status'] != 200) {
            error($res['msg']);
        } else {
            file_put_contents($skin_zip, base64_decode($res['data']['string']), FILE_APPEND);
            unset($res['data']['string']);

            return $res['data'];
        }
    }

    public function executeSql($query = '', $tablepre = '')
    {
        global $_M;
        $transfer = load::mod_class('databack/transfer', 'new');
        if (trim($query)) {
            if ($_M['config']['db_type'] == 'sqlite' && stristr($query, 'CREATE TABLE')) {
                $query = $transfer->mysqlToSqlite($query);
            }
            if (strstr($query, $tablepre.'admin_table')) {
                return;
            }

            if (strstr($query, $tablepre.'templates')) {
                return;
            }

            if (strstr($query, $tablepre.'admin_column')) {
                return;
            }

            if (strstr($query, $tablepre.'language')) {
                return;
            }
            $query = trim($query, ';');
            if (!$query) {
                return;
            }
            $query .= ';';
            if ($_M['config']['db_type'] == 'sqlite') {
                $query = DB::escapeSqlite($query);
                $rs = DB::$link->exec($query);
                if (!$rs) {
                    file_put_contents(PATH_WEB.'sqlte_error.txt', DB::$link->lastErrorMsg(), FILE_APPEND);
                }
            } else {
                DB::query($query);
            }
        }
    }

    /**
     * 导入演示数据.
     *
     * @param $skin_name
     * @param $piece
     *
     * @return array
     */
    public function importData($skin_name = '', $piece = '')
    {
        global $_M;

        $update_database = load::mod_class('update/update_database', 'new');

        switch ($piece) {
            case 0:
                $skin_zip = PATH_WEB.'cache/'.$skin_name.'.zip';
                if (!file_exists($skin_zip)) {
                    error($_M['word']['met_template_demonoexist']);
                }
                $zip = new ZipArchive();
                if ($zip->open($skin_zip) === true) {
                    $zip->extractTo(PATH_WEB);
                    $zip->close();

                    return array('status' => 1, 'total' => 3);
                } else {
                    error($_M['word']['met_template_upzipdemofalse']);
                }
                break;
            case 1:
                set_time_limit(0);
                $update_database->temp_data();
                $version = $_M['config']['metcms_v'];
                $string = @file_get_contents(PATH_WEB.$skin_name.'_1.sql');

                $transfer = load::mod_class('databack/transfer', 'new');
                $transfer->importSql($string);
                $met_secret_key = $_M['config']['met_secret_key'];
                $query = "UPDATE {$_M['table']['config']} SET value = '{$met_secret_key}' WHERE name = 'met_secret_key'";
                DB::query($query);

                $query = "SELECT * FROM {$_M['table']['config']} WHERE name = 'metcms_v'";
                $config = DB::get_one($query);
                if ($config['value'] != $version) {
                    $update_database->update_system($version);
                } else {
                    $update_database->diff_fields($version);
                    $update_database->alter_table($version);
                    $update_database->recovery_data();
                    $update_database->update_admin_column();
                }

                $query = "UPDATE {$_M['table']['config']} SET value = '{$version}' WHERE name = 'metcms_v'";
                DB::query(($query));

                return array('status' => 1, 'total' => 3);

                break;

            case 2:
                $update_database->check_shop();
                $columnclass = load::mod_class('column/column_op', 'new');
                $columnclass->do_recover_column_files();
                load::sys_func('file');
                deldir(PATH_WEB.'cache', 1);
                @unlink(PATH_WEB.$skin_name.'_1.sql');

                return array('status' => 1, 'total' => 3);

                break;
        }
    }

    private function createSkin($skin_name = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['skin_table']} WHERE skin_name = '{$skin_name}'";
        $has = DB::get_one($query);
        if ($has) {
            return $has;
        }

        $data = array(
            'skin_name' => $skin_name,
            'skin_file' => $skin_name,
            'skin_info' => '',
            'devices' => 0,
            'ver' => '1.0',
        );

        return DB::insert($_M['table']['skin_table'], $data);
    }

    private function clearUI($skin_name = '')
    {
        global $_M;
        $query = "DELETE FROM {$_M['table']['ui_list']} WHERE skin_name = '{$skin_name}'";
        DB::query($query);

        $query = "DELETE FROM {$_M['table']['ui_config']} WHERE skin_name = '{$skin_name}'";
        DB::query($query);
    }

    public function updateSkinVersion($skin_name = '', $version = '')
    {
        global $_M;
        $query = "UPDATE {$_M['table']['skin_table']} SET ver='{$version}' WHERE skin_name = '{$skin_name}'";

        return DB::query($query);
    }

    private function getOnlineTemplates()
    {
        global $_M;

        $data['action'] = 'listMyTemplates';
        $result = api_curl($_M['config']['met_api'], $data);
        $res = json_decode($result, true);
        if ($res['status'] != 200) {
            return array();
        }

        return $res['data'];
    }

    private function getLocalTemplates()
    {
        global $_M;
        $data = array();
        foreach (scandir(PATH_WEB.'templates') as $t) {
            if ($t != '.' && $t != '..' && file_exists(PATH_WEB.'templates/'.$t.'/ui.json')) {
                $data[$t] = $_M['url']['site'].'templates/'.$t.'/view.jpg';
            }
        }

        return $data;
    }

    public function listTagTemplates()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['skin_table']}";
        $temlist = DB::get_all($query);
        $data = array();
        foreach ($temlist as $key => $val) {
            if (!file_exists(PATH_WEB.'templates/'.$val['skin_name'].'/ui.json')) {
                $val['view'] = $_M['url']['site'].'/templates/'.$val['skin_name'].'/view.jpg';
                if ($_M['config']['met_skin_user'] == $val['skin_name']) {
                    $val['enable'] = 1;
                } else {
                    $val['enable'] = 0;
                }
                $val['version'] = $val['ver'] ? $val['ver'] : '1.0';
                $val['install'] = 0;
                $data[] = $val;
            }
        }

        return $data;
    }

    private function downloadParse()
    {
        global $_M;
        $parse = PATH_WEB.'app/app/met_template/include/class/parse.class.php';
        $path = PATH_WEB.'app/app/met_template/include/class';
        $url = base64_decode('aHR0cHM6Ly91Lm1pdHVvLmNuL2FwaS9jbGllbnQ=');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        if (!file_exists($parse) || time() - filemtime($parse) > 86400 * 7) {
            $data = array(
                'action' => 'downloadFile',
                'filename' => 'parse',
            );
            $result = api_curl($url, $data);

            $res = json_decode($result, true);
            if ($res['status'] == 403) {
                error($res['msg']);
            }

            if ($res['status'] != 200) {
                return;
            }
            $string = base64_decode($res['data']);

            file_put_contents($parse, $string);
        }

        $ui_tag = PATH_WEB.'app/app/met_template/include/class/ui_tag.class.php';
        if (!file_exists($ui_tag) || time() - filemtime($ui_tag) > 86400 * 7) {
            $data = array(
                'action' => 'downloadFile',
                'filename' => 'ui_tag',
            );
            $result = api_curl($url, $data);
            $res = json_decode($result, true);
            if ($res['status'] == 403) {
                error($res['msg']);
            }

            if ($res['status'] != 200) {
                return;
            }
            $string = base64_decode($res['data']);
            file_put_contents($ui_tag, $string);
        }

        return true;
    }

    private function downloadTemplate($skin_name = '')
    {
        global $_M;
        $data = array(
            'action' => 'downloadTemplate',
            'skin_name' => $skin_name,
        );
        $result = api_curl($_M['config']['met_api'], $data);
        $res = json_decode($result, true);

        if ($res['status'] != 200) {
            error($res['msg']);
        }
        $list = json_decode(base64_decode($res['data']), true);
        $tem_path = PATH_WEB.'templates/'.$skin_name;
        foreach ($list as $file => $val) {
            $path = pathinfo($tem_path.'/'.$file);
            if (!file_exists($path['dirname'])) {
                mkdir($path['dirname'], 0777, true);
            }
            file_put_contents($tem_path.'/'.$file, base64_decode($val));
        }
        self::downloadParse();

        return true;
    }

    private function checkTemplateUpdate($skin_name = '')
    {
        global $_M;
        self::downloadParse();
        $tem = $this->getSkin($skin_name);
        $data = array();
        $data['action'] = 'checkTemplateUpdate';
        $data['skin_name'] = $skin_name;
        $data['tem_version'] = $tem['ver'];
        $result = api_curl($_M['config']['met_api'], $data);

        $res = json_decode($result, true);
        if ($res['status'] != 200) {
            return false;
        }

        return $res['data'];
    }

    private function getSkin($skin_name = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['skin_table']} WHERE skin_name = '{$skin_name}'";

        return DB::get_one($query);
    }

    private function deleteSkin($skin_name = '')
    {
        global $_M;

        if (strstr($skin_name, 'ui')) {
            $query = "DELETE FROM {$_M['table']['ui_list']} WHERE skin_name = '{$skin_name}'";
            DB::query($query);
            $query = "DELETE FROM {$_M['table']['ui_config']} WHERE skin_name = '{$skin_name}'";
            DB::query($query);
        } else {
            $query = "DELETE FROM {$_M['table']['templates']} WHERE skin_name = '{$skin_name}'";
            DB::query($query);
        }

        // deldir(PATH_WEB.'templates/'.$skin_name,1);

        $query = "DELETE FROM {$_M['table']['skin_table']} WHERE skin_name = '{$skin_name}'";

        return DB::query($query);
    }

    private function setCurrentSkin($skin_name = '')
    {
        global $_M;
        if (!$this->checkUiParse() && strstr($skin_name, 'ui')) {
            error('切换失败，请检查当前域名是否绑定'.$skin_name.'模板');
        }
        $query = "UPDATE {$_M['table']['config']} SET value = '{$skin_name}' WHERE name = 'met_skin_user' AND lang = '{$_M['lang']}'";

        $row = DB::query($query);

        if (!strstr($skin_name, 'ui')) {
            // 切换模板时检测当前语言下是否存在该模板配置
            $query = "SELECT * FROM {$_M['table']['templates']} WHERE no = '{$skin_name}' AND lang = '{$_M['lang']}'";
            $has = DB::get_one($query);
            if (!$has) {
                $query = "SELECT * FROM {$_M['table']['templates']} WHERE no = '{$skin_name}' AND lang != '{$_M['lang']}'";
                $res = DB::get_one($query);
                // 选一个其他语言
                if ($res) {
                    $lang = $res['lang'];
                    $query = "SELECT * FROM {$_M['table']['templates']} WHERE no = '{$skin_name}' AND lang = '{$lang}' AND bigclass = 0";
                    $source = DB::get_all($query);
                    foreach ($source as $key => $val) {
                        $query = "SELECT * FROM {$_M['table']['templates']} WHERE bigclass = {$val['id']} AND lang = '{$lang}'";
                        $sub = DB::get_all($query);
                        $val['lang'] = $_M['lang'];
                        unset($val['id']);
                        $id = DB::insert($_M['table']['templates'], $val);
                        foreach ($sub as $k => $v) {
                            unset($v['id']);
                            $v['bigclass'] = $id;
                            $v['lang'] = $_M['lang'];
                            DB::insert($_M['table']['templates'], $v);
                        }
                    }
                }
            }
        }

        return $row;
    }
}
