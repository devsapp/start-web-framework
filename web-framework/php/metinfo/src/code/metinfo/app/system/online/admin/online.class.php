<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin.class.php');
load::sys_class('nav.class.php');
load::sys_class('curl');
load::sys_class('cache');
/** 客服 */
class online extends admin
{
    function __construct()
    {
        global $_M;
        parent::__construct();
        $this->database = load::mod_class('online/online_database', 'new');
    }

    /**
     * 客服列表
     */
    public function doGetOnlinlist()
    {
        global $_M;
        $table = load::sys_class('tabledata', 'new');
        $where = "lang='{$_M['lang']}'";
        $list = $table->getdata($_M['table']['online'], '*', $where, "no_order");
        $table->rdata($list);
    }

    public function dolistsave()
    {
        global $_M;
        $redata = array();
        $list = explode(",", $_M['form']['allid']);

        foreach ($list as $id) {
            if ($id) {
                switch ($_M['form']['submit_type']) {
                    case 'save':
                        $sava_data = array();
                        $sava_data['id'] = $id;
                        $sava_data['no_order'] = $_M['form']['no_order-' . $id];
                        $sava_data['name'] = $_M['form']['name-' . $id];
                        $sava_data['value'] = $_M['form']['value-' . $id];
                        $sava_data['icon'] = $_M['form']['icon-' . $id];
                        $sava_data['type'] = $_M['form']['type-' . $id];
                        $sava_data['lang'] = $_M['lang'];

                        $res = self::saveOnline($sava_data);
                        break;
                    case 'del':
                        $res = $this->onlineDel($id);
                        break;
                }
            }
        }

        Cache::del("config/online_{$_M['lang']}");
        if ($this->error) {
            $this->error($this->error[0]);
        }

        $this->success('', $_M['word']['jsok']);
    }

    /**
     * @param array $online
     */
    public function saveOnline($online = array())
    {
        if (is_numeric($online['id'])) {
            $res = self::updateOnline($online);
        } else {
            unset($online['id']);
            $res = self::insertOnline($online);
        }
    }

    /**
     * 新增客服
     * @param array $save_data
     */
    private function insertOnline($save_data = array())
    {
        global $_M;
        $save_data['no_order'] = $save_data['no_order'] ? $save_data['no_order'] : 0;
        $save_data['type'] = $save_data['type'] ? $save_data['type'] : 0;

        //写日志
        logs::addAdminLog('onlone_onlinelist_v6', 'online_addkefu_v6', 'jsok', 'insertOnline');
        return $this->database->insert($save_data);
    }

    /**
     * 更新客服数据
     * @param array $save_data
     * @return mixed
     */
    private function updateOnline($save_data = array())
    {
        global $_M;
        $save_data['no_order'] = $save_data['no_order'] ? $save_data['no_order'] : 0;
        $save_data['type'] = $save_data['type'] ? $save_data['type'] : 0;

        //写日志
        logs::addAdminLog('onlone_onlinelist_v6', 'online_updatekefu_v6', 'jsok', 'updateOnline');
        return $this->database->update_by_id($save_data);
    }

    /**
     * 删除客服
     */
    public function onlineDel($id = '')
    {
        global $_M;
        if (is_numeric($id)) {
            //写日志
            logs::addAdminLog('onlone_onlinelist_v6', 'delete', 'jsok', 'doDeleteOnline');
            return $this->database->del_by_id($id);
        } else {
            $this->error[] = $_M['word']['js41'];
            return false;
        }
    }

    //获取客服列表
    public function doGetList()
    {
        global $_M;
        $table = load::sys_class('tabledata', 'new');
        $where = "lang='{$_M['lang']}'";
        $list = $table->getdata($_M['table']['online'], '*', $where, "no_order");

        $table->rdata($list);
    }

    //新增/修改客服OLD
    public function doSaveOnline()
    {
        global $_M;
        if (!isset($_M['form']['data'])) {
            $this->error($_M['word']['js41']);
        }
        $data = $_M['form']['data'];
        foreach ($data as $value) {
            $value['no_order'] = $value['no_order'] ? $value['no_order'] : 0;

            if (isset($value['id']) && $value['id']) {
                //修改
                $query = "UPDATE {$_M['table']['online']} SET
                        `name`      = '{$value['name']}',
                        `no_order`  = '{$value['no_order']}',
                        `qq`        = '{$value['qq']}',
                        `msn`       = '{$value['msn']}',
                        `taobao`    = '{$value['taobao']}',
                        `alibaba`   = '{$value['alibaba']}',
                        `skype`     = '{$value['skype']}'
                        WHERE `id` = '{$value['id']}' AND `lang` = '{$_M['lang']}'";
                $log_name = 'submit';
            } else {
                //新增
                if (!$value['name']) {
                    $this->error($_M['word']['js41']);
                }

                $query = "INSERT INTO {$_M['table']['online']} SET
                        `name`      = '{$value['name']}',
                        `no_order`  = '{$value['no_order']}',
                        `qq`        = '{$value['qq']}',
                        `msn`       = '{$value['msn']}',
                        `taobao`    = '{$value['taobao']}',
                        `alibaba`   = '{$value['alibaba']}',
                        `skype`     = '{$value['skype']}',
                        `lang`      = '{$_M['lang']}'
                        ";
                $log_name = 'online_addkefu_v6';
            }

            DB::query($query);
        }
        //写日志
        logs::addAdminLog('onlone_onlinelist_v6', $log_name, 'jsok', 'doSaveOnline');
        $this->success('', $_M['word']['jsok']);
    }

    //删除客服OLD
    public function doDeleteOnline()
    {
        global $_M;
        $id = isset($_M['form']['id']) ? $_M['form']['id'] : '';
        if (!$id) {
            //写日志
            logs::addAdminLog('onlone_onlinelist_v6', 'delete', 'js41', 'doDeleteOnline');
            $this->error($_M['word']['js41']);
        }

        foreach ($id as $value) {
            $query = "DELETE FROM {$_M['table']['online']} WHERE `id`='{$value}' and `lang`='{$_M['lang']}' ";
            DB::query($query);
        }

        //写日志
        logs::addAdminLog('onlone_onlinelist_v6', 'delete', 'jsok', 'doDeleteOnline');
        $this->success('', $_M['word']['jsok']);

    }

    /********************/
    //获取在线客服设置
    public function doGetSetup()
    {
        global $_M;
        $data = array();
        $data['met_online_type'] = isset($_M['config']['met_online_type']) ? $_M['config']['met_online_type'] : '';
        $data['met_online_x'] = isset($_M['config']['met_online_x']) ? $_M['config']['met_online_x'] : '';
        $data['met_online_y'] = isset($_M['config']['met_online_y']) ? $_M['config']['met_online_y'] : '';
        $data['met_onlinenameok'] = isset($_M['config']['met_onlinenameok']) ? $_M['config']['met_onlinenameok'] : '';
        $data['met_online_color'] = isset($_M['config']['met_online_color']) ? $_M['config']['met_online_color'] : '';
        $data['met_onlinetel'] = isset($_M['config']['met_onlinetel']) ? $_M['config']['met_onlinetel'] : '';
        $data['met_online_skin'] = isset($_M['config']['met_online_skin']) ? $_M['config']['met_online_skin'] : '1';
        $data['online_skin_options'] = $this->getSkinList();
        if($_M['form']['noajax']){
            return $data;
        }else{
            $this->success($data);
        }
    }

    /**
     * 获取
     */
    public function getSkinList()
    {
        global $_M;
        $online_temp_dir = PATH_WEB . "app/system/online/web/templates";
        $list = array(1, 2, 3, 4);

        $options = array();
        foreach ($list as $val) {
            $row = array();
            if (is_file($online_temp_dir . "/online_{$val}.php")) {
                $row['view'] = "../app/system/online/web/templates/view_{$val}.jpg";
                $row['name'] = $_M['word']['skinstyle'] . "{$val}";
                $row['value'] = $val;
                $options[] = $row;
            }
        }
        return $options;
    }

    //保存在线客服设置
    public function doSaveSetup()
    {
        global $_M;
        $_M['form']['met_onlinenameok'] = $_M['form']['met_onlinenameok'] ? 1 : 0;
        $configlist = array();
        $configlist[] = 'met_online_type';
        $configlist[] = 'met_online_x';
        $configlist[] = 'met_online_y';
        $configlist[] = 'met_online_color';
        $configlist[] = 'met_onlinetel';
        $configlist[] = 'met_onlinenameok';
        $configlist[] = 'met_online_skin';

        configsave($configlist);/*保存系统配置*/

        cache::del("online_{$_M['lang']}.inc");
        //写日志
        logs::addAdminLog('onlone_online_v6', 'submit', 'jsok', 'doSaveSetup');
        $this->success('', $_M['word']['jsok']);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>