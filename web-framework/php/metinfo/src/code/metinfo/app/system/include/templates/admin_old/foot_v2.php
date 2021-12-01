<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$basic_admin_js_time = filemtime(PATH_PUBLIC_WEB.'js/basic_admin.js');
$lang_json_admin_js_time = filemtime(PATH_WEB.'cache/lang_json_admin_'.$_M['lang'].'.js');
if(!$foot_no && !$_M['foot_no']){
	$foot = str_replace('$metcms_v',$c['metcms_v'], $c['met_agents_copyright_foot']);
	$foot = str_replace('$m_now_year',date('Y',time()), $foot);
?>
</div>
<?php } ?>
<button type="button" class="btn btn-icon btn-primary btn-squared met-scroll-top" hidden><i class="icon wb-chevron-up" aria-hidden="true"></i></button>
</body>
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
	"try_again":"{$word.try_again}"
};
MET['langset']="{$_M['langset']}";
MET['anyid']="{$_M['form']['anyid']}";
MET['met_editor']="{$c.met_editor}";
MET['met_keywords']="{$c.met_keywords}";
MET['met_alt']="{$c.met_alt}";
MET['url']['basepath']="{$url.site_admin}";
MET['url']['own_form']="{$url.own_form}";
MET['url']['own_name']="{$url.own_name}";
MET['url']['own']="{$url.own}";
MET['url']['own_tem']="{$url.own_tem}";
MET['url']['api']="{$url.api}";
</script>
<script src="{$url.public_web}js/basic_admin.js?{$basic_admin_js_time}"></script>
<script src="{$url.site}cache/lang_json_admin_{$_M['langset']}.js?{$lang_json_admin_js_time}"></script>
<?php if(file_exists(PATH_OWN_FILE.'templates/js/own.js')){
	$own_js_time = filemtime(PATH_OWN_FILE.'templates/js/own.js');
?>
<script src="{$url.own_tem}js/own.js?{$own_js_time}"></script>
<?php } ?>
</html>