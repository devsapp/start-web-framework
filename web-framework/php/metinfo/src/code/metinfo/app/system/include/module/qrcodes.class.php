<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

class qrcodes
{
    public function doqrcodes()
    {
        require_once PATH_SYS_CLASS . 'phpqrcode/qrlib.php';

        if (!file_exists(PATH_CACHE . 'qrcache' . DIRECTORY_SEPARATOR)) {
            mkdir(PATH_CACHE . 'qrcache' . DIRECTORY_SEPARATOR);
        }

        if (!file_exists(PATH_CACHE . 'qrlog' . DIRECTORY_SEPARATOR)) {
            mkdir(PATH_CACHE . 'qrlog' . DIRECTORY_SEPARATOR);
        }

        $code = urldecode($_GET['url']);
        $size = $_GET['size'] ? $_GET['size'] : 10;
        $margin = $_GET['margin'] ? $_GET['margin'] : 1;
        QRcode::png($code, false, QR_ECLEVEL_L, $size, $margin);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>