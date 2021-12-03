<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

/**
 * 前台标签库
 * Class met_tag
 */
load::sys_class('view/tag');

class sys_tag extends tag
{
    // 必须包含config属性 不可修改
    public $config = array(
        'met_meta' => array('block' => 0, 'level' => 0),
        'met_foot' => array('block' => 0, 'level' => 0),
        'met_ui' => array('block' => 0, 'level' => 0),
    );

    //模板头部标签
    public function _met_meta($attr, $content, &$met)
    {
        global $_M;
        /**
         * 系统UI scc js解析
         */
        // load::sys_class('view/met_compile', 'new')->parse_met_ui();
        $_M['html_plugin']['head_script']=str_replace($_M['url']['web_site'],$_M['url']['site'],$_M['html_plugin']['head_script']);
        $_M['html_plugin']['foot_script']=str_replace($_M['url']['web_site'],$_M['url']['site'],$_M['html_plugin']['foot_script']);
        $php = '
<?php
$metinfover_v2=$c["metinfover"]=="v2"?true:false;
$lang_json_file_ok=1;
if(!$lang_json_file_ok){
    echo "<meta http-equiv=' . "'refresh'" . " content='0'" . '/>";
}
$html_hidden=$lang_json_file_ok?"":"hidden";
if(!$data["module"] || $data["module"]==10){
    $nofollow=1;
}
$user_name=$_M["user"]?$_M["user"]["username"]:"";
if(!$oxh_no){
    $html_class.="oxh";
}
$favicon_filemtime = filemtime(PATH_WEB."favicon.ico");
?>
<!DOCTYPE HTML>
<html class="{$html_class} met-web" {$html_hidden}>
<head>
<meta charset="utf-8">
<?php if($nofollow){ ?>
<meta name="robots" content="noindex,nofllow" />
<?php } ?>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,minimal-ui">
<meta name="format-detection" content="telephone=no">
<title>{$data.page_title}</title>
<meta name="description" content="{$data.page_description}">
<meta name="keywords" content="{$data.page_keywords}">
<meta name="generator" content="MetInfo {$c.metcms_v}" data-variable="{$url.site}|{$_M["lang"]}|{$data.synchronous}|{$c.met_skin_user}|{$data.module}|{$data.classnow}|{$data.id}" data-user_name="{$user_name}">
<?php if($data["access_code"]){ ?>
<meta name="access_code" content="{$data.access_code}">
<?php } ?>
<link href="{$url.site}favicon.ico?{$favicon_filemtime}" rel="shortcut icon" type="image/x-icon">
<?php
if($lang_json_file_ok){
    if(!$c["disable_cssjs"]){
        $basic_css_name=$metinfover_v2?"":"_web";
        if($c["temp_frame_version"]=="v2") $basic_css_name.="_v2";
        $basic_css_filemtime = filemtime(PATH_PUBLIC_WEB."css/basic".$basic_css_name.".css");
?>
<link rel="stylesheet" type="text/css" href="{$url.public_web}css/basic{$basic_css_name}.css?{$basic_css_filemtime}">
<?php
    }
    if($metinfover_v2){
        if(is_file(PATH_TEM."cache/metinfo.css")){
            $common_css_time = filemtime(PATH_TEM."cache/metinfo.css");
?>
<link rel="stylesheet" type="text/css" href="{$url.site}templates/{$c.met_skin_user}/cache/metinfo.css?{$common_css_time}">
<?php
        }
        if($met_page){
            if($met_page == 404) $met_page = "show";
            $page_css = PATH_TEM."cache/".$met_page."_".$_M["lang"].".css";
            if(!is_file($page_css)){
                $sys_compile = load::sys_class(\'view/sys_compile\', \'new\');
                if ($sys_compile->template_type == \'tag\') {
                    $sys_compile->parse_page($met_page);
                }else{
                    include_once PATH_ALL_APP . "met_template/include/class/parse.class.php";
                    $parse = new parse();
                    $parse->parse_page($met_page);
                }
            }
            $page_css_time = filemtime($page_css);
?>
<link rel="stylesheet" type="text/css" href="{$url.site}templates/{$c.met_skin_user}/cache/{$met_page}_{$_M["lang"]}.css?{$page_css_time}">
<?php
        }
    }
    if(is_mobile() && $c["met_headstat_mobile"]){
?>
{$c.met_headstat_mobile}' . "\n" . '
<?php }else if(!is_mobile() && $c["met_headstat"]){?>
{$c.met_headstat}' . "\n" . '
<?php
    }
    if($_M["html_plugin"]["head_script"]){
?>
{$_M["html_plugin"]["head_script"]}' . "\n" . '
<?php } ?>
<style>
body{
<?php if($g["bodybgimg"]){ ?>
    background-image: url({$g.bodybgimg}) !important;background-position: center;background-repeat: no-repeat;background-size:cover;
<?php } ?>
    background-color:{$g.bodybgcolor} !important;font-family:{$g.met_font} !important;}
h1,h2,h3,h4,h5,h6{font-family:{$g.met_font} !important;}
</style>
<script>(function(){var t=navigator.userAgent;(t.indexOf("rv:11")>=0||t.indexOf("MSIE 10")>=0)&&document.write("<script src=\"{$url.public_plugins}html5shiv.min.js\"><\/script>")})();</script>
</head>
<!--[if lte IE 9]>
<div class="text-xs-center m-b-0 bg-blue-grey-100 alert">
    <button type="button" class="close" aria-label="Close" data-dismiss="alert">
        <span aria-hidden="true">×</span>
    </button>
    {$word.browserupdatetips}
</div>
<![endif]-->
<body <?php if($body_class){ ?>class="{$body_class}"<?php } ?>>
<?php } ?>';

        return $php;
    }

    //模板底部标签
    public function _met_foot($attr, $content, &$met)
    {
        global $_M;
        $php = '
<?php if($lang_json_file_ok){ ?>
<input type="hidden" name="met_lazyloadbg" value="{$g.lazyloadbg}">
<?php if($data["module"]==3&&$data["id"]){ ?>
<textarea name="met_product_video" data-playinfo="{$c.met_auto_play_pc}|{$c.met_auto_play_mobile}" hidden>{$data.video}</textarea>
<?php
    }
    if($c["shopv2_open"]){
        $data["shop_goods"]=$data["shop_goods"]?$data["shop_goods"]:0;
?>
<script>
var jsonurl="{$url.shop_cart_jsonlist}",
    totalurl="{$url.shop_cart_modify}",
    delurl="{$url.shop_cart_del}",
    price_prefix="{$c.shopv2_price_str_prefix}",
    price_suffix="{$c.shopv2_price_str_suffix}",
    shop_goods={$data.shop_goods};
</script>
<?php
    }
    $met_lang_time = filemtime(PATH_WEB."cache/lang_json_".$_M["lang"].".js");
?>
<script src="{$url.site}cache/lang_json_{$_M["lang"]}.js?{$met_lang_time}"></script>
<?php
}
if(!$c["disable_cssjs"]){
    if(is_file(PATH_TEM."cache/metinfo.js")){
        $common_js_time = filemtime(PATH_TEM."cache/metinfo.js");
        $metpagejs="metinfo.js?".$common_js_time;
    }
    if($met_page){
        $page_js_time = filemtime(PATH_TEM."cache/".$met_page."_".$_M["lang"].".js");
        $metpagejs=$met_page."_".$_M["lang"].".js?".$page_js_time;
    }
    $basic_js_name=$metinfover_v2?"":"_web";
    if($c["temp_frame_version"]=="v2") $basic_js_name.="_v2";
    $basic_js_time = filemtime(PATH_PUBLIC_WEB."js/basic".$basic_js_name.".js");
?>
<script src="{$url.public_web}js/basic{$basic_js_name}.js?{$basic_js_time}" data-js_url="{$url.site}templates/{$c.met_skin_user}/cache/{$metpagejs}" id="met-page-js"></script>
<?php
}
if($lang_json_file_ok){
    if($c["shopv2_open"]){
        $shop_js_filemtime = filemtime(PATH_ALL_APP."shop/web/templates/met/js/own.js");
        if(($metinfover_v2=="v2" && $template_type) || $metinfover_v2!="v2"){
            $app_js_filemtime = filemtime(PATH_PUBLIC_WEB."js/app.js");
?>
<script src="{$url.public_web}js/app.js?{$app_js_filemtime}"></script>
<?php } ?>
<script src="{$url.shop_ui}js/own.js?{$shop_js_filemtime}"></script>
<?php
    }
    if(is_mobile() && $c["met_footstat_mobile"]){
?>
{$c.met_footstat_mobile}' . "\n" . '
<?php }else if(!is_mobile() && $c["met_footstat"]){?>
{$c.met_footstat}' . "\n" . '
<?php
    }
    if($_M["html_plugin"]["foot_script"]){
?>
{$_M["html_plugin"]["foot_script"]}' . "\n" . '
<?php
    }
}
?>
</body>
</html>';

        return $php;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.