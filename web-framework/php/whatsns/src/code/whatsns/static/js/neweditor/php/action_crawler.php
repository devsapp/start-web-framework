<?php
/**
 * 抓取远程图片
 * User: Jinqn
 * Date: 14-04-14
 * Time: 下午19:18
 */
set_time_limit(0);
include("Uploader.class.php");

/* 上传配置 */
$config = array(
    "pathFormat" => $CONFIG['catcherPathFormat'],
    "maxSize" => $CONFIG['catcherMaxSize'],
    "allowFiles" => $CONFIG['catcherAllowFiles'],
    "oriName" => "remote.png"
);
$fieldName = $CONFIG['catcherFieldName'];
 $watermark = $CONFIG['iswatermark']; 
/* 抓取远程图片 */
$list = array();
if (isset($_POST[$fieldName])) {
    $source = $_POST[$fieldName];
} else {
    $source = $_GET[$fieldName];
}
require 'up.php';
foreach ($source as $imgUrl) {
    $item = new Uploader($imgUrl, $config, "remote",$watermark);
    $info = $item->getFileInfo();
    

if(Common::getOpenoss()=='1'){
$diross=$info['url'];
$tmpfile=$info['url'];
$rootPath ="../../../..";
if(substr($info['url'], 0,1)=='/'){
	$diross=substr($info['url'], 1);
}
$info['url']=uploadFile($ossClient, $bucket,$diross,$rootPath.$info['url']);
if($info['url']!='error'){
	unlink($rootPath.$tmpfile);
}
}

    array_push($list, array(
        "state" => $info["state"],
        "url" => $info["url"],
        "size" => $info["size"],
        "title" => htmlspecialchars($info["title"]),
        "original" => htmlspecialchars($info["original"]),
        "source" => htmlspecialchars($imgUrl)
    ));
}

/* 返回抓取数据 */
return json_encode(array(
    'state'=> count($list) ? 'SUCCESS':'ERROR',
    'list'=> $list
));