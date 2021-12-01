<?php

/**
 * ECSHOP 后台分享注册用户管理
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');

/* act操作项的初始化 */
$_REQUEST['act'] = trim($_REQUEST['act']);
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'my_subordinates';
}

/*------------------------------------------------------ */
//-- 移动端我的下级显示配置
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list') {
    /**
     * 移动端我的下级显示配置
     */
    if(!$_POST){
        $open = 0;
        $selectSql = "SELECT * FROM " . $ecs->table('shop_config') . " WHERE code = 'my_subordinates'";
        $is_exit = $db->getRow($selectSql);
        if($is_exit) {
            $open = $is_exit['value'];
        }
        $smarty->assign('open', $open);
        $smarty->display('my_subordinates.htm');
    } else {
        $open = filter_compile($_POST['open']);

        $selectSql = "SELECT * FROM " . $ecs->table('shop_config') . " WHERE code = 'my_subordinates'";
        $is_exit = $db->getRow($selectSql);
        if ($is_exit) {
            $sql = "UPDATE " . $ecs->table('shop_config') . " SET value = '" . $open . "' WHERE code = 'my_subordinates' ";
        } else {
            $sql = "INSERT INTO " . $ecs->table('shop_config') . " SET code = 'my_subordinates', value = '" . $open . "'";
        }
        $db->query($sql);


        sys_msg('配置成功', 0, $links);
    }
}

?>
