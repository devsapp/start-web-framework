<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('group');

class sys_group extends group
{
    /**
     * 更新付费用戶组
     * @param string $groupid
     * @param string $pricr
     * @param string $buyok
     * @param string $recharge_price
     * @param string $rechargeok
     */
    public function updatePayGroup($groupid = '', $pricr = '', $buyok = '', $recharge_price = '', $rechargeok = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['user_group_pay']} WHERE 
                        groupid = '{$groupid}' AND 
                        lang = '{$_M['lang']}'";
        $group_pay = DB::get_one($query);
        if ($group_pay) {
            $query = "UPDATE {$_M['table']['user_group_pay']} SET 
                            price = '{$pricr}', 
                            buyok = '{$buyok}',
                            recharge_price = '{$recharge_price}',
                            rechargeok = '{$rechargeok}' 
                            WHERE groupid = '{$groupid}' AND 
                            lang = '{$_M['lang']}'";
            DB::query($query);
        } else {
            $query = "INSERT INTO {$_M['table']['user_group_pay']} SET 
                            groupid = '{$groupid}',
                            recharge_price = '{$recharge_price}',
                            price = '{$pricr}',
                            buyok = '{$buyok}',
                            rechargeok = '{$rechargeok}',
                            lang = '{$_M['lang']}'";
            DB::query($query);
        }
    }

    /**
     * 删除付费用户组
     * @param string $groupid
     */
    public function deltePayGroup($groupid = '')
    {
        global $_M;
        $query = "DELETE FROM {$_M['table']['user_group_pay']} WHERE groupid='{$groupid}' and lang='{$_M['lang']}' ";
        DB::query($query);
        return;
    }

    public function get_paygroup_by_id($groupid)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['user_group_pay']} WHERE groupid = '{$groupid}'";
        return DB::get_one($query);
    }

    public function get_group_by_id($groupid)
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['user_group']} WHERE id = '{$groupid}'";
        return DB::get_one($query);
    }

    public function get_paygroup_list_buyok()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['user_group_pay']} WHERE buyok = 1 ORDER BY price ";
        $res = DB::get_all($query);
        foreach ($res as $val) {
            $query = "SELECT * FROM {$_M['table']['user_group']} WHERE id = '{$val['groupid']}' AND  lang ='{$_M['lang']}'";
            $ugroup = DB::get_one($query);
            if ($ugroup) {
                $val['name'] = $ugroup['name'];
                $val['access'] = $ugroup['access'];
                $paygroup_list[] = $val;
            }
        }
        return $paygroup_list;
    }

    public function get_paygroup_list_recharge()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['user_group_pay']} WHERE rechargeok = 1 ORDER BY recharge_price ";
        $res = DB::get_all($query);
        foreach ($res as $val) {
            $query = "SELECT * FROM {$_M['table']['user_group']} WHERE id = '{$val['groupid']}' AND  lang ='{$_M['lang']}'";
            $ugroup = DB::get_one($query);
            $val['name'] = $ugroup['name'];
            $val['access'] = $ugroup['access'];
            $paygroup_list[] = $val;
        }
        return $paygroup_list;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>