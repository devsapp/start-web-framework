<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_class('admin');
/** 会员组设置 */
class admin_group extends admin
{
    public $userclass;
    public $groupclass;

    public function __construct()
    {
        parent::__construct();
        global $_M;
        $this->groupclass = load::mod_class('user/sys_group', 'new');

    }

    //获取会员组
    public function doGetUserGroup()
    {
        global $_M;
        $where = " lang = '{$_M['lang']}' ";
        $table = load::sys_class('tabledata', 'new');
        $group_data = $table->getdata($_M['table']['user_group'], '*', $where, 'access');

        foreach ($group_data as $key => $value) {
            $query = "SELECT price,buyok,recharge_price,rechargeok FROM  {$_M['table']['user_group_pay']} WHERE groupid='{$value['id']}' AND lang = '{$_M['lang']}'";
            $payment = DB::get_one($query);

            if (!$payment) {
                $payment = array(
                    'price' => '0',
                    'buyok' => '0',
                    'recharge_price' => '0',
                    'rechargeok' => '0',
                );
            }
            $group_data[$key]['payment'] = $payment;
        }
        $data['group_data'] = $group_data;
        $data['payment_open'] = isset($_M['config']['payment_open']) ? $_M['config']['payment_open'] : '';

        $table->rdata($data);
    }

    //保存分组
    public function doSaveGroup()
    {
        global $_M;
        $data = isset($_M['form']['data']) ? $_M['form']['data'] : '';
        if (!$data) {
            $this->error();
        }
        foreach ($data as $value) {
            if (!$value['name']) {
                continue;
            }
            $value['access'] = $value['access'] ? $value['access'] : 0;
            if ($value['access'] < 1) {
                $this->error($_M['word']['usereadinfo']);
            }
            if (isset($value['id']) && $value['id']) {
                $log_name = 'save';

                if (!is_numeric($value['id'])) {
                    //写日志
                    logs::addAdminLog('membergroup', $log_name, 'dataerror', 'doSaveGroup');
                    $this->error($_M['word']['dataerror']);
                }
                //修改
                $this->update($value);
                //写日志
            } else {
                //新增
                $this->insert($value);
                $log_name = 'added';
            }

        }

        //写日志
        logs::addAdminLog('membergroup', $log_name, 'jsok', 'doSaveGroup');

        cache::del('user', 'file');
        buffer::clearGroup($_M['lang']);
        $this->success('', $_M['word']['jsok']);
    }

    //新增会员组
    public function insert($value)
    {
        global $_M;

        $recharge_price = isset($value['recharge_price']) ? $value['recharge_price'] : 0;
        $rechargeok = isset($value['rechargeok']) ? $value['rechargeok'] : 0;
        $price = isset($value['price']) ? $value['price'] : 0;
        $buyok = isset($value['buyok']) ? $value['buyok'] : 0;

        $query = "INSERT INTO {$_M['table']['user_group']} SET 
							name = '{$value['name']}',
							access = '{$value['access']}',
							lang  = '{$_M['lang']}'
							";
        DB::query($query);
        $group_id = DB::insert_id();

        $query = "INSERT INTO {$_M['table']['user_group_pay']} SET 
                            groupid = '{$group_id}' ,
                            price = '{$price}' ,
                            buyok = '{$buyok}',
                            recharge_price = '{$recharge_price}',
                            rechargeok = '{$rechargeok}',
                            lang = '{$_M['lang']}'";
        DB::query($query);

    }

    public function update($value)
    {
        global $_M;
        $query = "UPDATE {$_M['table']['user_group']} SET 
							name = '{$value['name']}',
							access = '{$value['access']}'
						WHERE id = '{$value['id']}' and lang = '{$_M['lang']}'
						";
        DB::query($query);

        $recharge_price = isset($value['recharge_price']) ? $value['recharge_price'] : 0;
        $rechargeok = isset($value['rechargeok']) ? $value['rechargeok'] : 0;
        $price = isset($value['price']) ? $value['price'] : 0;
        $buyok = isset($value['buyok']) ? $value['buyok'] : 0;
        $query = "SELECT id FROM {$_M['table']['user_group_pay']} WHERE groupid = '{$value['id']}' AND lang = '{$_M['lang']}'";
        if (DB::get_one($query)) {
            $query = "UPDATE {$_M['table']['user_group_pay']} SET 
                            price = '{$price}', 
                            buyok = '{$buyok}',
                            recharge_price = '{$recharge_price}',
                            rechargeok = '{$rechargeok}' 
                            WHERE groupid = '{$value['id']}' AND 
                            lang = '{$_M['lang']}'";
            DB::query($query);
        } else {
            $query = "INSERT INTO {$_M['table']['user_group_pay']} SET 
                            groupid = '{$value['id']}',
                            recharge_price = '{$recharge_price}',
                            price = '{$price}',
                            buyok = '{$buyok}',
                            rechargeok = '{$rechargeok}',
                            lang = '{$_M['lang']}'";
            DB::query($query);
        }

    }

    //删除会员组
    public function doDelGroup()
    {
        global $_M;
        $data = isset($_M['form']['id']) ? $_M['form']['id'] : '';
        if (!$data) {
            $this->error();
        }

        foreach ($data as $value) {
            $query = "DELETE FROM {$_M['table']['user_group']} WHERE id='{$value}' AND lang='{$_M['lang']}' ";
            DB::query($query);
        }
        //写日志
        logs::addAdminLog('membergroup', 'delete', 'jsok', 'doDelGroup');
        cache::del('user', 'file');
        $this->success('', $_M['word']['jsok']);
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>