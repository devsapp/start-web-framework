<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$basic_admin_js_time = filemtime(PATH_PUBLIC_ADMIN.'js/basic_admin.js');
$lang_json_admin_js_time = filemtime(PATH_WEB.'cache/lang_json_admin_'.$_M['lang'].'.js');
?>
</body>
<script>window.MET={$data.met_para};</script>
<script src="{$url.site}cache/lang_json_admin_{$_M['langset']}.js?{$lang_json_admin_js_time}"></script>
<script src="{$url.public_admin}js/basic_admin.js?{$basic_admin_js_time}"></script>
</html>