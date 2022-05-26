<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin.class.php');
load::sys_class('nav.class.php');
load::sys_class('curl');
/** 站内锚文本 */
class anchor extends admin
{

    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    //获取站内锚文本
    public function doGetAnchor()
    {
        global $_M;
        $table = load::sys_class('tabledata', 'new');
        $where = "lang='{$_M['lang']}'";
        $anchor_data = $table->getdata($_M['table']['label'], '*', $where, 'id');

        $table->rdata($anchor_data);
    }

    //增加锚文本
    public function doSaveAnchor()
    {
        global $_M;
        if (!isset($_M['form']['data'])) {
            $this->error($_M['word']['js41']);
        }
        $data = $_M['form']['data'];
        foreach ($data as $value) {
            if (!$value['oldwords']) {
                $this->error($_M['word']['js41']);
            }
            if (isset($value['id']) && $value['id']) {
                //修改
                $query = "UPDATE {$_M['table']['label']} SET
							oldwords = '{$value['oldwords']}',
							newwords = '{$value['newwords']}',
							newtitle = '{$value['newtitle']}',
							url	     = '{$value['url']}',
							num	     = '{$value['num']}'
							WHERE id = '{$value['id']}' AND lang = '{$_M['lang']}'
						";
                $log_name = 'submit';
            } else {
                //新增
                $query = "INSERT INTO {$_M['table']['label']} SET
							oldwords = '{$value['oldwords']}',
							newwords = '{$value['newwords']}',
							newtitle = '{$value['newtitle']}',
							url	     = '{$value['url']}',
							num	     = '{$value['num']}',
						    lang = '{$_M['lang']}'
						";
                $log_name = 'anchor_textadd';
            }

            DB::query($query);
        }
        //写日志
        logs::addAdminLog('anchor_text', $log_name, 'jsok', 'doSaveAnchor');
        $this->success('', $_M['word']['jsok']);

    }

    //删除锚文本
    public function doDelAnchor()
    {
        global $_M;
        $id = isset($_M['form']['id']) ? $_M['form']['id'] : '';
        if (!$id) {
            $this->error('error');
        }

        foreach ($id as $value) {
            $query = "DELETE FROM {$_M['table']['label']} WHERE id='{$value}' AND lang='{$_M['lang']}' ";
            DB::query($query);
        }
        //写日志
        logs::addAdminLog('anchor_text', 'delete', 'jsok', 'doDelAnchor');
        $this->success('', $_M['word']['jsok']);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
