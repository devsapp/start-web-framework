<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$_M['form']['pageset']=1;
if($_M['word']['metinfo']){
    $met_title.='-'.$_M['word']['metinfo'];
}
$is_lte_ie9=strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 9")!==false || strpos($_SERVER["HTTP_USER_AGENT"],"MSIE 8")!==false;
if($is_lte_ie9){
    $basic_admin_css_filemtime_1 = filemtime(PATH_PUBLIC_WEB.'css/basic_admin-lteie9-1.css');
    $basic_admin_css_filemtime_2 = filemtime(PATH_PUBLIC_WEB.'css/basic_admin-lteie9-2.css');
}else{
    $basic_admin_css_filemtime = filemtime(PATH_PUBLIC_WEB.'css/basic_admin.css');
}
?>
<!DOCTYPE HTML>
<html class="{$_M['html_class']}">
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<meta name="robots" content="noindex,nofllow">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,minimal-ui">
<meta name="format-detection" content="telephone=no">
<title>{$met_title}</title>
<meta name="generator" content="MetInfo {$c.metcms_v}" data-variable="{$url.site}|{$_M['lang']}|{$c.met_skin_user}||||">
<link href="{$url.site}favicon.ico" rel="shortcut icon" type="image/x-icon">
<?php
if($is_lte_ie9){
?>
<link href="{$url.public_web}css/basic_admin-lteie9-1.css?{$basic_admin_css_filemtime_1}" rel="stylesheet" type="text/css">
<link href="{$url.public_web}css/basic_admin-lteie9-2.css?{$basic_admin_css_filemtime_2}" rel="stylesheet" type="text/css">
<?php
}else{
?>
<link href="{$url.public_web}css/basic_admin.css?{$basic_admin_css_filemtime}" rel='stylesheet' type='text/css'>
<?php
}
if(file_exists(PATH_OWN_FILE.'templates/css/metinfo.css')){
    $own_metinfo_css_filemtime = filemtime(PATH_OWN_FILE.'templates/css/metinfo.css');
?>
<link href="{$url.own_tem}css/metinfo.css?{$own_metinfo_css_filemtime}" rel='stylesheet' type='text/css'>
<?php } ?>
</head>
<!--['if lte IE 9']>
<div class="text-xs-center m-b-0 bg-blue-grey-100 alert">
    <button type="button" class="close" data-dismiss="alert">
        <span aria-hidden="true">×</span>
    </button>
    {$word.browserupdatetips}
</div>
<!['endif']-->
<body class="{$_M['body_class']}">
<?php
if(!$head_no && !$_M['head_no']) {
    $privilege = background_privilege();
    if (!$_M['form']['pageset']) {
        $met_agents_metmsg = $c['met_agents_metmsg'] ? '' : 'hidden';
        $msecount = DB::counter($_M['table']['infoprompt'], "WHERE (lang='" . $_M['lang'] . "' or lang='metinfo') and see_ok='0'", "*");
        $navigation = $privilege['navigation'];
        $arrlanguage = explode('|', $navigation);
        if (in_array('metinfo', $arrlanguage) || in_array('1002', $arrlanguage)) {
            $langprivelage = 1;
        } else {
            $langprivelage = 0;
        }
        if ($_M['form']['iframeurl']) {
            function get($str)
            {
                $data = array();
                $parameter = explode('&', end(explode('?', $str)));
                foreach ($parameter as $val) {
                    $tmp = explode('=', $val);
                    $data[$tmp['0']] = $tmp['1'];
                }
                return $data;
            }

            $str = $_M['form']['iframeurl'];
            $data = get($str);
            $_M['form']['anyid'] = $data['anyid'];
            $_M['form']['n'] = $data['n'];
        }
        $lang_name = $_M['langlist']['web'][$_M['lang']]['name'];
        $adminnav = get_adminnav();
        $adminapp = load::mod_class('myapp/class/getapp', 'new');
        $adminapplist = $adminapp->get_app();
        if ($_M['form']['anyid'] == '44') {
            foreach ($adminapplist as $key => $val) {
                if ($val['m_name'] == $_M['form']['n']) {
                    $nav_3 = $val;
                    $nav_3 ['name'] = get_word($val['appname']);
                    break;
                }
            }
            if (!$nav_3) $nav_3 = $adminnav[$_M['form']['anyid']];
        } else {
            $nav_3 = $adminnav[$_M['form']['anyid']];
        }
        if (!$_M['form']['anyid']) $weizhi = '<li class="breadcrumb-item">' . $_M['word']['background_page'] . '</li>';
        if ($adminnav[$adminnav[$_M['form']['anyid']]['bigclass']]['name']) {
            if ($_M['form']['anyid'] == 44 && M_NAME != 'myapp') $adminnav[$adminnav[$_M['form']['anyid']]['bigclass']]['name'] = '<a href="' . $adminnav['44']['url'] . '">' . $adminnav['44']['name'] . '</a>';
            $fenlei = '<li class="breadcrumb-item">' . $adminnav[$adminnav[$_M['form']['anyid']]['bigclass']]['name'] . '</li>';
        }
        $weizhi = '<li class="breadcrumb-item"><a href="' . $nav_3['url'] . '">' . $nav_3['name'] . '</a></li>';
        ?>
        <header class="metadmin-head navbar h-50">
            <div class="container-fluid h-100p">
                <div class="h-100p vertical-align pull-xs-left hidden-md-down">
                    <div class="breadcrumb m-b-0 p-0 vertical-align-middle">
                        <li class='breadcrumb-item'>{$lang_name}</li>
                        {$fenlei}
                        {$weizhi}
                    </div>
                </div>
                <div class="metadmin-head-right pull-xs-right h-100p vertical-align">
                    <div class="vertical-align-middle">
                        <?php
                        $power = admin_information();
                        if ($power['admin_group'] == '10000' || $power['admin_group'] == '3') {
                            ?>
                            <div class="btn-group" {$met_agents_metmsg}>
                                <button class="btn btn-default" data-toggle="modal" data-target="#functionEncy">
                                    <i class="fa fa-pie-chart"></i>
                                    <span class="hidden-sm-down">{$word.funcCollection}</span>
                                </button>
                            </div>
                        <?php } ?>
                        <div class="btn-group" {$met_agents_metmsg}>
                            <a href="https://www.metinfo.cn/bangzhu/index.php?ver=metcms" class="btn btn-default"
                               target="_blank">
                                <i class="fa fa-life-ring"></i>
                                <span class="hidden-sm-down">{$word.indexbbs}</span>
                            </a>
                        </div>
                        <div class="btn-group" {$met_agents_metmsg}>
                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="fa fa-bookmark"></i>
                                <span class="hidden-sm-down">{$word.indexcode}</span>
                            </button>
                            <ul class="dropdown-menu animate animate-reverse dropdown-menu-right text-xs-center">
                                <?php
                                if ($c['met_agents_metmsg'] == 1) {
                                    $auth = load::mod_class('system/class/sys_auth', 'new');
                                    $otherinfoauth = $auth->have_auth();
                                    if (!$otherinfoauth) {
                                        ?>
                                        <li class="dropdown-item">
                                            <a href="https://www.metinfo.cn/web/product.htm" target="_blank"
                                               class='block'>{$word.sys_authorization2}</a>
                                        </li>
                                        <li class="dropdown-item">
                                            <a class="btn btn-primary"
                                               href='{$url.adminurl}&n=system&c=authcode&a=doindex'>{$word.sys_authorization1}</a>
                                        </li>
                                    <?php } else { ?>
                                        <li class="dropdown-item">
                                            <button class="btn btn-info" type="submit">{$otherinfoauth['info1']}
                                            </button>
                                        </li>
                                        <li class="dropdown-item">
                                            <a class="nobo block" href="{$url.adminurl}&n=system&c=authcode&a=doindex">{$word.entry_authorization}</a>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="fa fa-globe"></i>
                                <span class="hidden-sm-down">{$lang_name}</span>
                            </button>
                            <ul class="dropdown-menu animate animate-reverse dropdown-menu-right">
                                <?php
                                foreach ($_M['user']['langok'] as $key => $val) {
                                    $url_now = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
                                    if (!strstr($url_now, "lang=")) {
                                        $val['url'] = $_M['url']['site_admin'] . "index.php?lang=" . $val['mark'];
                                    } else {
                                        $val['url'] = str_replace(array("lang=" . $_M['lang'], "lang%3D" . $_M['lang']), array("lang=" . $val['mark'], "lang%3D" . $val['mark']), $url_now);
                                    }
                                    if (strstr($c['met_weburl'], 'https')) {
                                        $val['url'] = str_replace('http', 'https', $val['url']);
                                    }
                                    ?>
                                    <li class="dropdown-item"><a href="{$val.url}&switch=1"
                                                                 class='block'>{$val.name}</a></li>
                                <?php } ?>
                                <li class="dropdown-item">
                                    <a href='{$url.adminurl}anyid=10&n=language&c=language_admin&a=dolangadd'
                                       class="btn btn-primary"><i
                                                class="fa fa-plus"></i>{$word.added}{$word.langweb}</a>
                                </li>
                            </ul>
                        </div>
                        <?php if (!$c['met_agents_switch']) { ?>
                            <div class="btn-group">
                                <a class="btn btn-default" href='{$url.adminurl}n=system&c=news&a=doindex'>
                                    <i class="fa fa-bell-o"></i>
                                    <span class="tag tag-pill up tag-danger bg-red-600">{$msecount}</span>
                                </a>
                            </div>
                        <?php } ?>
                        <div class="btn-group">
                            <button class="btn btn-default dropdown-toggle" type="button" id="adminuser"
                                    data-toggle="dropdown">
                                {$_M['user']['admin_name']}
                            </button>
                            <ul class="dropdown-menu animate animate-reverse dropdown-menu-right">
                                <li class="dropdown-item"><a
                                            href="{$url.adminurl}n=admin&c=admin_admin&a=doeditor_info">{$word.modify_information}</a>
                                </li>
                                <li class="dropdown-item"><a target="_top"
                                                             href="{$url.adminurl}n=login&c=login&a=dologinout">{$word.indexloginout}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="modal fade" id="functionEncy">
            <div class="modal-dialog modal-lg modal-primary">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">{$word.funcCollection}</h4>
                    </div>
                    <div class="modal-body">
                        <include file='sys_admin/function_ency'/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{$word.close}</button>
                    </div>
                </div>
            </div>
        </div>
    <?php } else if (M_ACTION == 'dofunction_ency') { ?>
        <include file='sys_admin/function_ency'/>
        <?php
    }
    if (M_ACTION != 'dofunction_ency') {
?>
<div class="metadmin-main container-fluid m-y-10">
    <?php
        $navlist = nav::get_nav();
        if($navlist){
    ?>
    <ul class="stat-list nav nav-tabs m-b-10 border-none">
        <?php
            foreach($navlist as $key => $val){
                $val['classnow']=$val['classnow']?'active':'';
        ?>
        <li class="nav-item"><a class='nav-link {$val.classnow}' title="{$val.title}" href="{$val.url}" target="{$val.target}">{$val.title}</a></li>
        <?php } ?>
    </ul>
<?php
        }
    }
}
?>