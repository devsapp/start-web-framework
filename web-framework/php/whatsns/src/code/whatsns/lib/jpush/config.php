<?php
require  'autoload.php';

use JPush\Client as JPush;

$app_key = '6c66ace5fac55e5fce46ab00'; //极光那边申请的应用app_key
$master_secret ='d76c9b38fab75f255e598be6';//极光那边申请的应用master_secret
$registration_id = '';

$client = new JPush($app_key, $master_secret);
