<?php

// MetInfo Enterprise Content Management System
// Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');

class index extends admin
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    public function doindex()
    {
        global $_M;
        $data = array(
            'action' => 'listPartners',
            'pid' => intval($_M['form']['pid']),
        );
        $result = api_curl($_M['config']['met_api'], $data);
        $res = json_decode($result, true);
        if ($res['status'] == 200) {
            $data = array();
            foreach ($res['data']['data'] as $key => $val) {
                if (strstr($val['homepage'], '?')) {
                    $type = '&';
                } else {
                    $type = '?';
                }
                $res['data']['data'][$key]['homepage'] = $val['homepage'].$type.'metinfo_code='.$_M['config']['metinfo_code'];
            }
            $this->success($res['data'], $res['msg']);
        }
        $this->error();
    }

    public function doCategory()
    {
        global $_M;
        $data = array(
            'action' => 'listPartnerCategorys',
        );
        $result = api_curl($_M['config']['met_api'], $data);
        $res = json_decode($result, true);
        if ($res['status'] == 200) {
            $data = array();
            $this->success($res['data'], $res['msg']);
        }
        $this->error();
    }
}

// This program is an open source system, commercial use, please consciously to purchase commercial license.
// Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
