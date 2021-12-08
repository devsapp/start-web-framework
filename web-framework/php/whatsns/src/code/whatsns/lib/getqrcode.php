<?php
error_reporting(E_ERROR);
require_once 'phpqrcode/phpqrcode.php';
$url = urldecode($_GET["data"]);
$size =isset($_GET["size"]) ? $_GET["size"]:5;
QRcode::png($url,false,"H",$size,2);
