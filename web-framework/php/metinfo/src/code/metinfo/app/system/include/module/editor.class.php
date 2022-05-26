<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

load::sys_class('admin');

class editor extends admin
{

    function __construct()
    {
        parent::__construct();
    }

    /*编辑器上传处理*/
    public function doeditor()
    {
        global $_M;
        $CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents(PATH_WEB . "app/system/include/module/editor/config.json")), true);
        $CONFIG['imagePathFormat'] = PATH_WEB . 'upload/' . $CONFIG['imagePathFormat'];
        $CONFIG['scrawlPathFormat'] = PATH_WEB . 'upload/' . $CONFIG['scrawlPathFormat'];
        $CONFIG['catcherPathFormat'] = PATH_WEB . 'upload/' . $CONFIG['catcherPathFormat'];
        $CONFIG['videoPathFormat'] = PATH_WEB . 'upload/' . $CONFIG['videoPathFormat'];
        $CONFIG['filePathFormat'] = PATH_WEB . 'upload/' . $CONFIG['filePathFormat'];
        $CONFIG['imageManagerListPath'] = PATH_WEB . 'upload/';
        $CONFIG['fileManagerListPath'] = PATH_WEB . 'upload/';

        //允许上传文件大小
        $file_maxsize = $_M['config']['met_file_maxsize'] * 1024 * 1000;
        $CONFIG['imageMaxSize'] = $file_maxsize;
        $CONFIG['videoMaxSize'] = $file_maxsize;
        $CONFIG['fileMaxSize'] = $file_maxsize;
        $CONFIG['scrawlMaxSize'] = $file_maxsize;
        $CONFIG['catcherMaxSize'] = $file_maxsize;

        //允许上传格式
        $allow_files = array();
        foreach (explode('|', $_M['config']['met_file_format']) as $val) {
            if ($val != '') {
                $ext = ".{$val}";
                $allow_files[] = $ext;
            }
        }
        if (is_array($allow_files) && $allow_files) {
            $CONFIG['imageAllowFiles'] = $allow_files;
            $CONFIG['videoAllowFiles'] = $allow_files;
            $CONFIG['fileAllowFiles'] = $allow_files;
            $CONFIG['fileManagerAllowFiles'] = $allow_files;
        }

        switch ($_M['form']['action']) {
            case 'config':
                $result = json_encode($CONFIG);
                break;
            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $result = include("editor/action_upload.php");
                break;
            /* 列出图片 */
            case 'listimage':
                $result = include("editor/action_list.php");
                break;
            /* 列出文件 */
            case 'listfile':
                $result = include("editor/action_list.php");
                break;
            /* 抓取远程文件 */
            case 'catchimage':
                $result = include("editor/action_crawler.php");
                break;
            default:
                $result = json_encode(array(
                    'state' => $_M['word']['rurlerror']
                ));
                break;
        }
        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state' => 'callback' . $_M['word']['paranouse']
                ));
            }
        } else {
            echo $result;
        }
        die();
    }

    public function __destruct()
    {
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>