<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
load::sys_func('file');
/**
 * 会员接口类
 */

class user_op
{
    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
        $this->lang = $_M['lang'];
    }

    public function getUserPlist($listid = '', $paraid = '')
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['user_list']} WHERE listid='{$listid}' AND paraid='{$paraid}'";
        return DB::get_one($query);
    }

    /**
     * 用户信息
     * @param $uid
     * @return mixed
     */
    public function get_user_info($uid)
    {
        global $_M;
        $sysuer = load::sys_class('user', 'new');
        $userinfo = $sysuer->get_user_by_id($uid);
        return $userinfo;
    }

    /**
     * 更改用户组
     * @param $uid
     * @param $group
     * @return mixed
     */
    public function modity_group($uid, $group)
    {
        global $_M;
        $sysuer = load::sys_class('user', 'new');
        $usre_group = $sysuer->editor_uesr_gorup($uid, $group);
        return $usre_group;
    }

    /**
     * 会员满减自动升级
     * @param $uid
     */
    public function checkPayGroup($uid)
    {
        global $_M;
        $user = load::sys_class('user', 'new')->get_user_by_id($uid);
        $paygroup = load::mod_class('user/sys_group', 'new');
        $pglist = $paygroup->get_paygroup_list_recharge();
        $payopen = $_M['config']['payment_open'];
        if ($pglist && $payopen) {
            $web_pay = load::mod_class('pay/pay_op', 'new');

            $payrecode = $web_pay->get_record($user, 1);
            $total = 0;
            foreach ($payrecode as $value) {
                if ($value['type'] == 1) {
                    $total = $value['price'] + $total;
                }
            }

            foreach ($pglist as $pgroup) {
                if ($pgroup['recharge_price'] <= $total) {
                    $groupnew = $pgroup;
                }

                if ($pgroup['groupid'] == $user['groupid']) {
                    $groupnow = $pgroup;
                }
            }

            if ($groupnew['recharge_price'] >= $groupnow['recharge_price']) {
                $res = $this->modity_group($user['id'], $groupnew['groupid']);
            }
        }
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.;
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
