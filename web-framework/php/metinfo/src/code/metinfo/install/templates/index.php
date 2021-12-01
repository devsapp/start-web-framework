<!--<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
global $url_public,$siteurl;
$url_site='../';
$url_public=$url_site.'public/';
$action=$action?$action:'license';
$active[$action]='text-success';
echo <<<EOT
-->
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<meta name="robots" content="noindex,nofllow">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,minimal-ui">
<meta name="format-detection" content="telephone=no">
<title>MetInfo|米拓企业建站系统安装 - Powered by MetInfo</title>
<link href="{$url_site}favicon.ico" rel="shortcut icon" type="image/x-icon">
<link href="{$url_public}plugins/bootstrap/bootstrap-v4.3.1.min.css" rel='stylesheet' type='text/css'>
<style>
.install-process li span{font-family:Georgia,"Times New Roman","Bitstream Charter",Times,serif;}
</style>
</head>
<body>
<div class="bg-primary py-3">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-lg-10 col-xl-9 d-flex justify-content-between align-items-center">
				<a href="https://www.metinfo.cn" title='米拓企业建站系统' target="_blank"><img src="../public/images/logo-white.png" alt="MetInfo|米拓企业建站系统" height="30"/></a>
				<div class="text-white h5 mb-0">MetInfo|米拓企业建站系统 7.3.0 <font>全新安装</font></div>
			</div>
		</div>
	</div>
</div>
<!--
EOT;
if($action=='guide'){
	include self::template('guide');
}else{
echo <<<EOT
-->
<div class="container my-4">
	<ul class="list-inline text-center h6 mb-0 text-dark install-process">
		<li class="list-inline-item mr-5 {$active['license']}"><span class="h2 mb-0">1</span> 阅读使用协议</li>
		<li class="list-inline-item mr-5 {$active['inspect']}"><span class="h2 mb-0">2</span> 系统环境检测</li>
		<li class="list-inline-item mr-5 {$active['db_setup']}"><span class="h2 mb-0">3</span> 数据库设置</li>
		<li class="list-inline-item mr-5 {$active['adminsetup']}"><span class="h2 mb-0">4</span> 管理员设置</li>
		<li class="list-inline-item {$active['finished']}"><span class="h2 mb-0">5</span> 安装完成</li>
	</ul>
	<div class="row justify-content-center mt-4">
		<div class="col-12 col-lg-10 col-xl-9 text-dark">
<!--
EOT;
	switch($action){
		case 'license':
	        include self::template('license');
	        break;
		case 'inspect':
	        self::inspect();
	        break;
	    case 'db_setup':
	        self::db_setup();
	        break;
	    case 'adminsetup':
	        self::adminsetup();
	        break;
	    case 'finished':
	        include self::template('finished');
	        break;
	}
echo <<<EOT
-->
		</div>
	</div>
</div>
<!--
EOT;
}
echo <<<EOT
-->
<div class="text-center mb-3">Powered by <b><a href="https://www.metinfo.cn" target="_blank">MetInfo 7.3.0</a></b> &copy;2009-$nowyear &nbsp;<a href="https://www.mituo.cn" target="_blank">mituo.cn</a></div>
<!--
EOT;
if($action=='inspect' || $action=='adminsetup' || $action=='db_setup'){
echo <<<EOT
-->
<script src="{$url_public}plugins/jquery/jquery.min.js"></script>
<!--
EOT;
}
echo <<<EOT
-->
</body>
</html>
<!--
EOT;
?>