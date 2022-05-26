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
    $_REQUEST['act'] = 'list';
}

/*------------------------------------------------------ */
//-- 获取新注册绑定用户数据列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 权限判断 */
    admin_priv('user_recommend');

    /* 模板赋值 */
    $smarty->assign('ur_here',      $_LANG['user_recommend']);
    $smarty->assign('full_page',    1);

    $tag_list = get_tag_list();
    $smarty->assign('tag_list',     $tag_list['tags']);
    $smarty->assign('filter',       $tag_list['filter']);
    $smarty->assign('record_count', $tag_list['record_count']);
    $smarty->assign('page_count',   $tag_list['page_count']);

    $sort_flag  = sort_flag($tag_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    /* 页面显示 */
    assign_query_info();
    $smarty->display('user_recommend.html');
}



/*------------------------------------------------------ */
//-- 翻页，排序
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'query')
{
    check_authz_json('tag_manage');

    $tag_list = get_tag_list();
    $smarty->assign('tag_list',     $tag_list['tags']);
    $smarty->assign('filter',       $tag_list['filter']);
    $smarty->assign('record_count', $tag_list['record_count']);
    $smarty->assign('page_count',   $tag_list['page_count']);

    $sort_flag  = sort_flag($tag_list['filter']);
    $smarty->assign($sort_flag['tag'], $sort_flag['img']);

    make_json_result($smarty->fetch('user_hitCounts.html'), '',
        array('filter' => $tag_list['filter'], 'page_count' => $tag_list['page_count']));
}



/*------------------------------------------------------ */
//-- 批量删除用户商品点击量
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'batch_drop')
{
//    admin_priv('tag_manage');

    if (isset($_POST['checkboxes']))
    {
        $count = 0;
        foreach ($_POST['checkboxes'] AS $key => $id)
        {
            $res = "update ecs_users set parent_id = 0 where user_id = (select user_id from ecs_user_recommend where recommend_id = $id)";
            $db->query($res);
            $sql = "DELETE FROM " .$ecs->table('user_recommend'). " WHERE recommend_id='$id'";
            $db->query($sql);

            $count++;
        }

        admin_log($count, 'remove', 'user_recommend');
        clear_cache_files();

        $link[] = array('text' => $_LANG['back_list'], 'href'=>'user_recommend.php?act=list');
        sys_msg(sprintf($_LANG['drop_success'], $count), 0, $link);
    }
    else
    {
        $link[] = array('text' => $_LANG['back_list'], 'href'=>'user_recommend.php?act=list');
        sys_msg($_LANG['no_select_tag'], 0, $link);
    }
}




/**
 * 获取标签数据列表
 * @access  public
 * @return  array
 */
function get_tag_list()
{
    $filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'v.visit_id' : trim($_REQUEST['sort_by']);
    $filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);



    $sql = "SELECT COUNT(*) FROM ".$GLOBALS['ecs']->table('user_visit_log');
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    $filter = page_and_size($filter);


    $sql = "select * from ecs_user_recommend
            order by recommend_id limit {$filter['start']},{$filter['page_size']}";

    $row = $GLOBALS['db']->getAll($sql);
    foreach($row as $k=>$v)
    {
        $row[$k]['recommend_id'] = htmlspecialchars($v['recommend_id']);
        $row[$k]['user_id'] = htmlspecialchars($v['user_id']);
        $row[$k]['user_name'] = htmlspecialchars($v['user_name']);
        $row[$k]['parent_id'] = htmlspecialchars($v['parent_id']);
        $row[$k]['recommend'] = htmlspecialchars($v['recommend']);
    }

    $arr = array('tags' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}


?>
