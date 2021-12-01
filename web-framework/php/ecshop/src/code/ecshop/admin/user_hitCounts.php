<?php

/**
 * ECSHOP 后台商品用户点击统计
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
//-- 获取用户商品点击数据列表
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'list')
{
    /* 权限判断 */
//    admin_priv('tag_manage');

    /* 模板赋值 */
    $smarty->assign('ur_here',      $_LANG['user_hitCounts']);
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
    $smarty->display('user_hitCounts.html');
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
            $sql = "DELETE FROM " .$ecs->table('user_visit_log'). " WHERE visit_id='$id'";
            $db->query($sql);

            $count++;
        }

        admin_log($count, 'remove', 'user_hitCounts');
        clear_cache_files();

        $link[] = array('text' => $_LANG['back_list'], 'href'=>'user_hitCounts.php?act=list');
        sys_msg(sprintf($_LANG['drop_success'], $count), 0, $link);
    }
    else
    {
        $link[] = array('text' => $_LANG['back_list'], 'href'=>'user_hitCounts.php?act=list');
        sys_msg($_LANG['no_select_tag'], 0, $link);
    }
}

/*------------------------------------------------------ */
//-- 删除标签
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'remove')
{
    include_once(ROOT_PATH . 'includes/cls_json.php');
    $json = new JSON;

    $id = intval($_GET['id']);

    /* 获取删除的浏览记录 */
    $sql = "select v.visit_id,u.user_name,g.goods_name,v.hitCounts,v.addTime,v.platform from ecs_user_visit_log v
            INNER JOIN ecs_users u on v.user_id = u.user_id inner join ecs_goods g on v.goods_id=g.goods_id where v.visit_id = $id";
    $visit_code = $db->getOne($sql);
    $visit_code = serialize($visit_code);

    $sql = "DELETE FROM " .$ecs->table('user_visit_log'). " WHERE visit_id = '$id'";
    $result = $GLOBALS['db']->query($sql);
    if ($result)
    {
        /* 管理员日志 */
        admin_log(addslashes($visit_code), 'remove', 'user_hitCounts');

        $url = 'user_hitCounts.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
        ecs_header("Location: $url\n");
        exit;
    }
    else
    {
        make_json_error($db->error());
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

    $sql = "select COUNT(*) from ecs_user_visit_log v
            INNER JOIN ecs_users u on v.user_id = u.user_id inner join ecs_goods g on v.goods_id=g.goods_id";
    $filter['record_count'] = $GLOBALS['db']->getOne($sql);

    $filter = page_and_size($filter);


    $sql = "select v.visit_id,u.user_name,g.goods_name,v.hitCounts,v.addTime,v.platform from ecs_user_visit_log v
            INNER JOIN ecs_users u on v.user_id = u.user_id inner join ecs_goods g on v.goods_id=g.goods_id
            order by {$filter['sort_by']} {$filter['sort_order']} limit {$filter['start']},{$filter['page_size']}";

    $row = $GLOBALS['db']->getAll($sql);
    foreach($row as $k=>$v)
    {
        $row[$k]['user_name'] = htmlspecialchars($v['user_name']);
        $row[$k]['goods_name'] = htmlspecialchars($v['goods_name']);
        $row[$k]['hitCounts'] = htmlspecialchars($v['hitCounts']);
        $row[$k]['addTime'] = htmlspecialchars($v['addTime']);
    }

    $arr = array('tags' => $row, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    return $arr;
}

/**
 * 取得标签的信息
 * return array
 */

function get_tag_info($tag_id)
{
    $sql = 'SELECT t.tag_id, t.tag_words, t.goods_id, g.goods_name FROM ' . $GLOBALS['ecs']->table('tag') . ' AS t' .
        ' LEFT JOIN ' . $GLOBALS['ecs']->table('goods') . ' AS g ON t.goods_id=g.goods_id' .
        " WHERE tag_id = '$tag_id'";
    $row = $GLOBALS['db']->getRow($sql);

    return $row;
}

?>
