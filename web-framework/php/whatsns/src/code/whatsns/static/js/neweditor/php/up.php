<?php
require_once  'Common.php';

use OSS\Http\RequestCore;
use OSS\Http\ResponseCore;
use OSS\OssClient;
use OSS\Core\OssException;

$bucket = Common::getBucketName();
$ossClient = Common::getOssClient();
if (is_null($ossClient)) exit(1);



 function listObjects($ossClient, $bucket,$prefix,$allowFiles, &$files = array())
{
   // $prefix = 'zhuanti/';
    $delimiter = '/';
    $nextMarker = '';
    $maxkeys = 1000;
    $options = array(
        'delimiter' => $delimiter,
        'prefix' => $prefix,
        'max-keys' => $maxkeys,
        'marker' => $nextMarker,
    );
    try {
        $listObjectInfo = $ossClient->listObjects($bucket, $options);
    } catch (OssException $e) {
       // printf(__FUNCTION__ . ": FAILED\n");
       // printf($e->getMessage() . "\n");
        return 'error';
    }
   // print(__FUNCTION__ . ": OK" . "\n");
    $objectList = $listObjectInfo->getObjectList(); // 文件列表
    $prefixList = $listObjectInfo->getPrefixList(); // 目录列表
  
  
    if (!empty($objectList)) {
     //   print("objectList:\n");
        foreach ($objectList as $objectInfo) {
          //  print($objectInfo->getKey() . "\n");
            $file=Common::getDomain().$objectInfo->getKey();
           if (preg_match("/\.(".$allowFiles.")$/i", $file)) {
                    $files[] = array(
                        'url'=> $file,
                        'mtime'=> filemtime($file)
                    );
                }
        }
    }
    if (!empty($prefixList)) {
       // print("prefixList: \n");
        foreach ($prefixList as $prefixInfo) {
           // print($prefixInfo->getPrefix() . "\n");
           listObjects($ossClient, $bucket,$prefixInfo->getPrefix(),$allowFiles,$files);
        }
    }
     return $files;
}
    
 function putObject($ossClient, $bucket,$object,$file)
{
   
    $content = file_get_contents($file);
    $options = array();
    try {
        $ossClient->putObject($bucket, $object, $content, $options);
    } catch (OssException $e) {
       // printf(__FUNCTION__ . ": FAILED\n");
       // printf($e->getMessage() . "\n");
        return 'error';
    }
   // print(__FUNCTION__ . ": OK" . "\n");
    return Common::getDomain().$object;
}
/**
 * 上传指定的本地文件内容
 *
 * @param OssClient $ossClient OssClient实例
 * @param string $bucket 存储空间名称
 * @return null
 */
function uploadFile($ossClient, $bucket,$object,$filePath)
{
  
    $options = array();

    try {
        $ossClient->uploadFile($bucket, $object, $filePath, $options);
    } catch (OssException $e) {
       // printf(__FUNCTION__ . ": FAILED\n");
       // printf($e->getMessage() . "\n");
        return 'error';
    }
   return Common::getDomain().$object;
}