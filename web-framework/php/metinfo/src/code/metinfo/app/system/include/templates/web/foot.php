<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<script>
var MET=[];
MET['url']=[];
MET['langtxt'] = {
	"jsx15":"{$word.jsx15}",
	"js35":"{$word.js35}",
	"jsx17":"{$word.jsx17}",
	"formerror1":"{$word.formerror1}",
	"formerror2":"{$word.formerror2}",
	"formerror3":"{$word.formerror3}",
	"formerror4":"{$word.formerror4}",
	"formerror5":"{$word.formerror5}",
	"formerror6":"{$word.formerror6}",
	"formerror7":"{$word.formerror7}",
	"formerror8":"{$word.formerror8}",
	"js46":"{$word.js46}",
	"js23":"{$word.js23}",
	"checkupdatetips":"{$word.checkupdatetips}",
	"detection":"{$word.detection}",
	"try_again":"{$word.try_again}",
	"fileOK":"{$word.fileOK}",
};
MET['met_editor']="{$c.met_editor}";
MET['met_keywords']="{$c.met_keywords}";
MET['url']['own']="{$url.own}";
MET['url']['own_tem']="{$url.own_tem}";
MET['url']['api']="{$url.api}";
</script>
<include file="foot"/>
<if value="!$c['shopv2_open']">
<?php $app_js_time = filemtime(PATH_PUBLIC_WEB.'js/app.js'); ?>
<script src="{$url.public_web}js/app.js?{$app_js_time}"></script>
</if>
<?php if(file_exists(PATH_OWN_FILE.'templates/'.$url['app_tem'].'js/own.js') && !((M_NAME=='product' || M_NAME=='shop') && $c['shopv2_open'])){
	$own_js_time = filemtime(PATH_OWN_FILE.'templates/'.$url['app_tem'].'js/own.js');
?>
<script src="{$url.own_tem}js/own.js?{$own_js_time}"></script><?php } ?>