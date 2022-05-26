<?php
require __DIR__ . '/vendor/autoload.php';

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\NlsCloudMeta\NlsCloudMeta;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

try {
    // Create Client
    AlibabaCloud::accessKeyClient('foo', 'bar')
                ->regionId('cn-hangzhou')
                ->asDefaultClient();
    // Chain calls and send RPC request
    $result = NlsCloudMeta::v20180518()
                          ->createToken()
                          ->regionId('cn-shanghai')
                          ->request();
} catch (ServerException $exception) {
    // Get server error message
    print_r($exception->getErrorMessage());
} catch (ClientException $e) {
    // Get client error message
    print_r($exception->getErrorMessage());
}
