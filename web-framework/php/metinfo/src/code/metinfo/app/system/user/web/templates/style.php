<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$loginbg = $c['met_member_bgimage']?"background:url(".$c['met_member_bgimage'].") center / cover no-repeat;":'';
?>
<style>
<if value="$c['met_member_bg_range']">.login-index<else/>.met-member</if>{background:url(../app/system/user/web/templates/img/user_login_bg.jpg) center / cover no-repeat;background:{$c.met_member_bgcolor};{$loginbg}}
</if>
</style>