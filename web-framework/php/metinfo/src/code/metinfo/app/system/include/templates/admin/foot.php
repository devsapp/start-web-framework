<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<if value="!$_M['form']['notab']">
<button type="button" class="btn btn-primary btn-squared met-scroll-top position-fixed" hidden><i class="icon wb-chevron-up" aria-hidden="true"></i></button>
<footer class="metadmin-foot mt-3 text-grey">{$data.copyright}</footer>
</if>
<include file="pub/footer"/>
<?php if(file_exists(PATH_OWN_FILE.'templates/js/'.$_M['form']['n'].'.js')){
	$own_js_time = filemtime(PATH_OWN_FILE.'templates/js/'.$_M['form']['n'].'.js');
?>
<script src="{$url.own_tem}js/{$_M['form']['n']}.js?{$own_js_time}"></script>
<?php } ?>