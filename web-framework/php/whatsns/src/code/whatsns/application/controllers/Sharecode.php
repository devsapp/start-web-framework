<?php
$useragent = $_SERVER ['HTTP_USER_AGENT'];
$wx = $this->fromcache ( 'cweixin' );

if (strstr ( $useragent, 'MicroMessenger' ) && $wx ['appsecret'] != '' && $wx ['appsecret'] != null && $wx ['winxintype'] != 2) {

	$appid = $wx ['appid'];
	$appsecret = $wx ['appsecret'];
	require FCPATH . '/lib/php/jssdk.php';
	$jssdk = new JSSDK ( $appid, $appsecret );
	$signPackage = $jssdk->GetSignPackage ();

}