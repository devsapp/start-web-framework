<?php

/**
 * ECSHOP 广告处理文件
 * ============================================================================
 * * 版权所有 2005-2018 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: affiche.php 17217 2011-01-19 06:29:08Z liubo $
*/

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');


/* act 操作项的初始化*/
$_GET['act'] = !empty($_GET['act']) ? trim($_GET['act']) : '';
assign_template();
if ($_GET['act'] == 'zhuanti1')
{
    $sql  = "select a.position_id,a.position_name,b.ad_link,b.ad_code from ecs_ad_position a left join ecs_ad b on a.position_id = b.position_id where a.position_name like '%pc专题1-图%' and b.enabled ='1'";
    $data = $GLOBALS['db']->getAll($sql);
    foreach ($data as $k=>$v){
        $data[$k]['ad_code'] = 'http://'.$_SERVER['HTTP_HOST'].'/data/afficheimg/'.$v['ad_code'];
    }
    $smarty->assign('data1', $data[0]);
    $smarty->assign('data2', $data[1]);
    $smarty->assign('data3', $data[2]);
    $smarty->assign('data4', $data[3]);
   $smarty->display('special1.dwt');
}
elseif ($_GET['act'] == 'zhuanti2')
{
    $sql  = "select a.position_id,a.position_name,b.ad_link,b.ad_code from ecs_ad_position a left join ecs_ad b on a.position_id = b.position_id where a.position_name like '%pc专题2-图%' and b.enabled ='1'";
    $data = $GLOBALS['db']->getAll($sql);
    foreach ($data as $k=>$v){
        $data[$k]['ad_code'] = 'http://'.$_SERVER['HTTP_HOST'].'/data/afficheimg/'.$v['ad_code'];

    }
    $sql = "select goods_id,goods_img,shop_price,goods_name,market_price from ecs_goods where 1  order by virtual_sales desc limit 0,4";
    $goods_data = $GLOBALS['db']->getAll($sql);
    $smarty->assign('goods_data', $goods_data);
    $smarty->assign('image1', $data[0]);
    $smarty->assign('image2', $data[1]);
    $smarty->assign('image3', $data[2]);
    $smarty->assign('image4', $data[3]);
    $smarty->assign('image5', $data[4]);
    $smarty->assign('image6', $data[5]);
   $smarty->display('special2.dwt');
}
else
{
    $sql  = "select a.position_id,a.position_name,b.ad_link,b.ad_code from ecs_ad_position a left join ecs_ad b on a.position_id = b.position_id where a.position_name like '%pcspecial图%' and b.enabled ='1'";
    $data = $GLOBALS['db']->getAll($sql);
    foreach ($data as $k=>$v){
        $data[$k]['ad_code'] = 'http://'.$_SERVER['HTTP_HOST'].'/data/afficheimg/'.$v['ad_code'];
    }
    $smarty->assign('data', $data);
    $smarty->display('special.dwt');
}
