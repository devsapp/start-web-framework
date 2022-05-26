<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('web');

class paygroup extends web
{
    public function __construct()
    {
        global $_M;
        parent::__construct();
        $this->no = 10;    //app_no 100以内为系统预留编号; 用户模块编号10
        $this->paygroup_list = load::mod_class('user/sys_group', 'new')->get_paygroup_list_buyok();
        $this->load_url_unique();
    }

    public function dopaygroup()
    {
        global $_M;
        $data = array();
        $payclass = load::mod_class('pay/pay_op', 'new');
        $paygroup_list = $this->paygroup_list;
        foreach ($paygroup_list as $value) {
            if ($value['groupid'] == $_M['form']['groupid']) {
                $pricestr = $payclass->price_str($value['price']);
                $out_trade_no = $payclass->getRid();
                $group_data = array('groupid' => $value['groupid'], 'price' => $value['price']);
                $data['subject'] = "{$_M['word']['userbuy']}-{$value['name']} [$pricestr]";
                $data['body'] = "{$_M['word']['userbuylist']}-{$out_trade_no}";
                $data['total_fee'] = $value['price'];
                $data['out_trade_no'] = $out_trade_no;
                $data['callback_url'] = "{$_M['url']['profile']}";
                $data['sys_callback'] = "{$_M['url']['paygroup']}&a=dochangepaygroup";
                $data['no'] = $this->no;
                $data['attach'] = base64_encode(jsonencode($group_data));
            }
        }
        $payhtml = $payclass->createPayForm($data);
        echo $payhtml;
        die();
    }

    public function dochangepaygroup()
    {
        global $_M;
        $payclass = load::mod_class('pay/pay_op', 'new');
        $data = $payclass->de_code($_M['form']['codestr']);
        if ($data['no'] != $this->no) {
            return false;
        }
        $paygroup = json_decode(base64_decode($data['attach']), true);

        if (bccomp((float)$data['total_fee'], (float)$paygroup['price']) !== 0) {
            return false;
        } else {
            if ($data['total_fee'] != $paygroup['price']) {
                return false;
            }
        }
        $group_class = load::mod_class('user/user_op', 'new');

        $group_class->modity_group($data['uid'], $paygroup['groupid']);

    }

    public function load_url_unique()
    {
        global $_M;
        $_M['url']['form'] = $_M['url'][''];
    }
}


# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.