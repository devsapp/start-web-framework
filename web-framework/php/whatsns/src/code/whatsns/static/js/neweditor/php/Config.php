<?php

/**
 * Class Config
 *
 * 执行Sample示例所需要的配置，用户在这里配置好Endpoint，AccessId， AccessKey和Sample示例操作的
 * bucket后，便可以直接运行RunAll.php, 运行所有的samples
 */
final class Config
{
    const OSS_ACCESS_ID = 'XESOxhE9hcmDsoBT';
    const OSS_ACCESS_KEY = 'oXLmaQ9cwUxshQHg9uf4QPCphm85aO';
    const OSS_ENDPOINT = 'http://oss-cn-shanghai.aliyuncs.com';
      const OSS_DOMAIN = 'http://img.ask2.cn/';//请用反斜杠结尾 如 http://img.ask2.cn/
    const OSS_TEST_BUCKET = 'ask2wenda';
     const OPEN_OSS = '0';//1表示启用阿里云oss存储文件，0表示采用本地存储
}
