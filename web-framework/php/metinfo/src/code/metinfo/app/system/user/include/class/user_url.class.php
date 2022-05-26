<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 会员url类
 */
class user_url
{
    /**
     * 重写web类的load_url_unique方法，获取前台特有URL
     */
    public function insert_m()
    {
        global $_M;
        $lang = "?lang={$_M['lang']}";
        $_M['url']['member'] = $_M['url']['site'] . 'member/';
        $_M['url']['login'] = "{$_M['url']['member']}login.php{$lang}";
        $_M['url']['register'] = "{$_M['url']['member']}register_include.php{$lang}";
        $_M['url']['register_userok'] = "{$_M['url']['register']}&a=douserok";
        $_M['url']['getpassword'] = "{$_M['url']['member']}getpassword.php{$lang}";
        $_M['url']['paygroup'] = "{$_M['url']['member']}paygroup.php{$lang}";

        $_M['url']['user_home'] = "{$_M['url']['member']}index.php{$lang}";
        $_M['url']['profile'] = "{$_M['url']['member']}basic.php{$lang}";
        $_M['url']['profile_safety'] = "{$_M['url']['profile']}&a=dosafety";
        $_M['url']['pass_save'] = "{$_M['url']['profile']}&a=dopasssave";
        $_M['url']['emailedit'] = "{$_M['url']['profile']}&a=doemailedit";
        $_M['url']['maileditok'] = "{$_M['url']['profile']}&a=doemailok";
        $_M['url']['profile_safety_emailadd'] = "{$_M['url']['profile']}&a=dosafety_emailadd";
        $_M['url']['profile_safety_telok'] = "{$_M['url']['profile']}&a=dosafety_telok";
        $_M['url']['profile_safety_telvalid'] = "{$_M['url']['profile']}&a=dosafety_telvalid";
        $_M['url']['profile_safety_teladd'] = "{$_M['url']['profile']}&a=dosafety_teladd";
        $_M['url']['profile_safety_teledit'] = "{$_M['url']['profile']}&a=dosafety_teledit";
        $_M['url']['profile_safety_idvalid'] = "{$_M['url']['profile']}&a=dosafety_idvalid";


        $_M['url']['info_save'] = "{$_M['url']['profile']}&a=doinfosave";
        $_M['url']['valid_email_repeat'] = "{$_M['url']['profile']}&a=dovalid_email";
        $_M['url']['valid_email'] = "{$_M['url']['register']}&a=doemailvild";
        $_M['url']['valid_phone'] = "{$_M['url']['register']}&a=dophonecode";

        $_M['url']['login_check'] = "{$_M['url']['login']}&a=dologin";

        $_M['url']['register_save'] = "{$_M['url']['register']}&a=dosave";

        $_M['url']['password_email'] = "{$_M['url']['getpassword']}&a=doemail";
        $_M['url']['password_valid'] = "{$_M['url']['getpassword']}&a=dovalid";
        $_M['url']['password_telvalid'] = "{$_M['url']['getpassword']}&a=dotelvalid";
        $_M['url']['password_valid_phone'] = "{$_M['url']['getpassword']}&a=dophonecode";

        $_M['url']['login_out'] = "{$_M['url']['login']}&a=dologout";
        $_M['url']['login_other'] = "{$_M['url']['login']}&a=doother";
        $_M['url']['login_other_register'] = "{$_M['url']['login']}&a=dologin_other_register";
        $_M['url']['login_other_info'] = "{$_M['url']['login']}&a=dologin_other_info";
        $_M['url']['weixin_register'] = "{$_M['url']['login']}&a=doregistwxuser";
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
