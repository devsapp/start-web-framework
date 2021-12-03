<?php
ini_set("display_errors","On");
error_reporting(E_ALL);
/**
 * ECSHOP 程序说明
 * ===========================================================
 * * 版权所有 2005-2018 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ==========================================================
 * $Author: wangleisvn $
 * $Id: lead.php 16131 2009-05-31 08:21:41Z wangleisvn $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . "includes/cls_certificate.php");
$uri          = $ecs->url();
$allow_suffix = array('gif', 'jpg', 'png', 'jpeg', 'bmp');

/*------------------------------------------------------ */
//-- 直播设置
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'index') {
    $selectSql = "SELECT * FROM " . $ecs->table('shop_config') . " WHERE code = 'live_setting'";
    $data      = $db->getRow($selectSql); // 查看是否存在

    $data_arr = unserialize($data['value']);
    $rt       = array('act' => 'add');

    $smarty->assign('rt', $rt);
    $smarty->assign('data', $data_arr);
    $smarty->display('live_setting.html');

} elseif ($_REQUEST['act'] == 'add') {
    $app_key    = filter_compile($_POST['app_key']);
    $app_secret = filter_compile($_POST['app_secret']);
    $is_open    = filter_compile($_POST['is_open']);
    $image_desc = filter_compile($_POST['image_desc']);

    // 账号密码不可为空
    if (empty($app_key) || empty($app_secret)) {
        sys_msg('配置不可为空', 1, $links);
    }
    $images = '';

    if($image_desc != '')
    {
        $images = $image_desc;
    }

    if (!empty($_FILES['image']['type'])) {

        // 允许上传的图片后缀
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp        = explode(".", $_FILES["image"]["name"]);
        $extension   = end($temp);        // 获取文件后缀名

        if ((($_FILES["image"]["type"] == "image/gif")
                || ($_FILES["image"]["type"] == "image/jpeg")
                || ($_FILES["image"]["type"] == "image/jpg")
                || ($_FILES["image"]["type"] == "image/pjpeg")
                || ($_FILES["image"]["type"] == "image/x-png")
                || ($_FILES["image"]["type"] == "image/png"))
            && ($_FILES["image"]["size"] < 2 * 1024 * 1024)    // 小于 2M
            && in_array($extension, $allowedExts)) {
            $path      = dirname(__DIR__) . '/images/';
            $file_name = md5(time()) . '.jpg';

            if(move_uploaded_file($_FILES['image']['tmp_name'], $path . $file_name))
            {

                if (is_https()) {
                    $header = "https://";
                } else {
                    $header = "http://";
                }

                $images = $header . $_SERVER['HTTP_HOST'] . "/" . "images/" . $file_name;
            }
        }
    }


    // 数据
    $aData = array(
        'app_key'    => trim($app_key),
        'app_secret' => trim($app_secret),
        'is_open'    => $is_open,
        'images'      => $images
    );


    // 登录成功 存储账号密码
    $selectSql = "SELECT * FROM " . $ecs->table('shop_config') . " WHERE code = 'live_setting'";
    $is_exit   = $db->getRow($selectSql); // 查看是否存在

    // 将数据转换
    $data = serialize($aData);
    if ($is_exit) {
        $sql = "UPDATE " . $ecs->table('shop_config') . " SET value = '" . $data . "' WHERE code = 'live_setting' ";

    } else {
        $sql = "INSERT INTO " . $ecs->table('shop_config') . " SET code = 'live_setting', value = '" . $data . "'";
    }

    $db->query($sql);


    sys_msg('配置成功', 0, $links);


}elseif ($_REQUEST['act'] == 'apple_login') {
    /**
     * apple登录配置
     */
    if(!$_POST){
        $open = 0;
        $selectSql = "SELECT * FROM " . $ecs->table('shop_config') . " WHERE code = 'apple_login'";
        $is_exit = $db->getRow($selectSql);
        if($is_exit) {
            $open = $is_exit['value'];
        }
        $smarty->assign('open', $open);
        $smarty->display('apple_login.htm');
    } else {
        $open = filter_compile($_POST['open']);


        $selectSql = "SELECT * FROM " . $ecs->table('shop_config') . " WHERE code = 'apple_login'";
        $is_exit = $db->getRow($selectSql);
        if ($is_exit) {
            $sql = "UPDATE " . $ecs->table('shop_config') . " SET value = '" . $open . "' WHERE code = 'apple_login' ";

        } else {
            $sql = "INSERT INTO " . $ecs->table('shop_config') . " SET code = 'apple_login', value = '" . $open . "'";
        }

        $db->query($sql);


        sys_msg('配置成功', 0, $links);
    }
}


/**
 * @param $sUrl
 * @param $aHeader
 * @param $aData
 * @return bool|string
 */
function http_post($sUrl, $aHeader, $aData)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $sUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($aData));
    $sResult = curl_exec($ch);
    if ($sError = curl_error($ch)) {
        die($sError);
    }
    curl_close($ch);
    return $sResult;
}

/**
 * PHP判断当前协议是否为HTTPS
 */
function is_https() {
    if ( !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return true;
    } elseif ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
        return true;
    } elseif ( !empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        return true;
    }
    return false;

}
?>