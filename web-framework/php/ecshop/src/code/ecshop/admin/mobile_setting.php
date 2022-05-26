<?php

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
include_once(ROOT_PATH."includes/cls_certificate.php");
$uri = $ecs->url();
$allow_suffix = array('gif', 'jpg', 'png', 'jpeg', 'bmp');

/*------------------------------------------------------ */
//-- 移动端应用配置
/*------------------------------------------------------ */
if ($_REQUEST['act']== 'list')
{
    $sql = "select * from ecs_banner order by id desc";
    $data = $db->getAll($sql);
    foreach($data as $k => $v){
        if ((strpos($v['img_src'], 'http') === false) || (strpos($v['img_src'], 'https') === false))
        {
            $data[$k]['img_src'] = $uri . $v['img_src'];
        }
    }
    $smarty->assign('playerdb', $data);
    $smarty->display('banner_config.html');
} elseif($_REQUEST['act']== 'del') {
    $id = (int)$_GET['id'];
    $sql = "delete from ecs_banner where id=".$id."";
    $db->query($sql);

    ecs_header("Location: mobile_setting.php?act=list\n");
    exit;
}
elseif ($_REQUEST['act'] == 'add')
{
    admin_priv('flash_manage');

    if (empty($_POST['step']))
    {
        $url = isset($_GET['url']) ? $_GET['url'] : 'http://';
        $src = isset($_GET['src']) ? $_GET['src'] : '';
        $sort = 0;
        $rt = array('act'=>'add','img_url'=>$url,'img_src'=>$src, 'img_sort'=>$sort);
        $rt = array('act'=>'add','img_url'=>$url,'img_src'=>$src, 'img_sort'=>$sort);
        $width_height = get_width_height();
        assign_query_info();
        if(isset($width_height['width'])|| isset($width_height['height']))
        {
            $smarty->assign('width_height', sprintf($_LANG['width_height'], $width_height['width'], $width_height['height']));
        }

        $smarty->assign('action_link', array('text' => $_LANG['go_url'], 'href' => 'mobile_setting.php?act=list'));
        $smarty->assign('rt', $rt);
        $smarty->assign('ur_here', $_LANG['add_picad']);
        $smarty->display('flashplay_add.htm');
    }
    elseif ($_POST['step'] == 2)
    {
        if (!empty($_FILES['img_file_src']['name']))   // 是否上传了图片  上传了 就进行处理
        {
            if(!get_file_suffix($_FILES['img_file_src']['name'], $allow_suffix))
            {
                sys_msg($_LANG['invalid_type']);
            }
            $name = date('Ymd');
            for ($i = 0; $i < 6; $i++)
            {
                $name .= chr(mt_rand(97, 122));
            }
            $img_file_src_name_arr = explode('.', $_FILES['img_file_src']['name']);
            $name .= '.' . end($img_file_src_name_arr);
            $target = ROOT_PATH . DATA_DIR . '/afficheimg/' . $name;
            if (move_upload_file($_FILES['img_file_src']['tmp_name'], $target))
            {
                $src = DATA_DIR . '/afficheimg/' . $name;
            }

        }
        elseif (!empty($_POST['img_src']))
        {
            if(!get_file_suffix($_POST['img_src'], $allow_suffix))
            {
                sys_msg($_LANG['invalid_type']);
            }
            $src = $_POST['img_src'];
            if ((strpos($_POST['img_src'], 'http') === false) || (strpos($_POST['img_src'], 'https') === false))
            {
                $src = get_url_image($src);
            }
        }
        else
        {  // 没有上传图片 也没有填写图片地址
            $links[] = array('text' => $_LANG['add_new'], 'href' => 'mobile_setting.php?act=add');
            sys_msg($_LANG['src_empty'], 0, $links);
        }

        if (empty($_POST['img_url']))
        {
            $links[] = array('text' => $_LANG['add_new'], 'href' => 'mobile_setting.php?act=add');
            sys_msg($_LANG['link_empty'], 0, $links);
        }
        $img_url = $_POST['img_url'];
        $app_url = $_POST['app_url'];
        $mp_url = $_POST['mp_url'];
        $ranking = $_POST['ranking'];

        $sql = "insert into ecs_banner set img_src = '".$src."',img_url = '".$img_url."',ranking = '".$ranking."',app_url = '".$app_url."',mp_url = '".$mp_url."' ";
        $res = $db->query($sql);
        sys_msg($_LANG['edit_ok'], 0, $links);
    }
}
elseif ($_REQUEST['act'] == 'edit')
{
    $id = (int)$_REQUEST['id']; //取得id
    $sql = "select * from ecs_banner where id= ".$id."";
    $res = $db->getRow($sql);
    if (empty($_POST['step']))
    {
        $res['act'] = 'edit';
        $smarty->assign('action_link', array('text' => $_LANG['go_url'], 'href' => 'mobile_setting.php?act=list'));
        $smarty->assign('rt', $res);
        $smarty->assign('ur_here', $_LANG['edit_picad']);
        $smarty->display('flashplay_add.htm');
    }
    elseif ($_POST['step'] == 2)
    {
        if (empty($_POST['img_url']))
        {
            //若链接地址为空
            $links[] = array('text' => $_LANG['return_edit'], 'href' => 'mobile_setting.php?act=edit&id=' . $id);
            sys_msg($_LANG['link_empty'], 0, $links);
        }

        if (!empty($_FILES['img_file_src']['name']))
        {
            if(!get_file_suffix($_FILES['img_file_src']['name'], $allow_suffix))
            {
                sys_msg($_LANG['invalid_type']);
            }
            //有上传
            $name = date('Ymd');
            for ($i = 0; $i < 6; $i++)
            {
                $name .= chr(mt_rand(97, 122));
            }
            $img_file_src_name_arr = explode('.', $_FILES['img_file_src']['name']);
            $name .= '.' . end($img_file_src_name_arr);
            $target = ROOT_PATH . DATA_DIR . '/afficheimg/' . $name;

            if (move_upload_file($_FILES['img_file_src']['tmp_name'], $target))
            {
                $src = DATA_DIR . '/afficheimg/' . $name;
            }
        }
        else if (!empty($_POST['img_src']))
        {
            $src =$_POST['img_src'];
            if ((strpos($_POST['img_src'], 'http') === false) || (strpos($_POST['img_src'], 'https') === false))
            {
                // $src = get_url_image($src);
            }
        }
        else
        {
            $links[] = array('text' => $_LANG['return_edit'], 'href' => 'mobile_setting.php?act=edit&id=' . $id);
            sys_msg($_LANG['src_empty'], 0, $links);
        }
        $id = filter_compile($_POST['id']);
        $img_url = filter_compile($_POST['img_url']);
        $app_url = filter_compile($_POST['app_url']);
        $mp_url = filter_compile($_POST['mp_url']);
        $ranking = filter_compile($_POST['ranking']);

        $sql = "update ecs_banner set img_src = '".$src."',img_url = '".$img_url."',ranking='".$ranking."',app_url = '".$app_url."',mp_url = '".$mp_url."' where id = ".$id." ";
        $res = $db->query($sql);
        $links[] = array('text' => $_LANG['go_url'], 'href' => 'mobile_setting.php?act=list');
        sys_msg($_LANG['edit_ok'], 0, $links);
    }
}elseif ($_REQUEST['act'] == 'end_time'){
    admin_priv('end_time');
    $sql = "select * from ecs_app_config";
    $data = $GLOBALS['db']->getAll($sql);
    foreach ($data as $k=>$v){
        if($v['k']=='end_time'){
            $end_time = $v['val'];
        }
        if($v['k']=='prompt'){
            $prompt = $v['val'];
        }
        if($v['k']=='yes_no'){
            $yes_no = $v['val'];
        }

    }
    $smarty->assign('end_time',$end_time);
    $smarty->assign('ur_here',$_LANG['end_time']);
    $smarty->assign('prompt',$prompt);
    $smarty->assign('yes_no',$yes_no);
    $smarty->display('end_time.htm');
}
elseif ($_REQUEST['act'] == 'end_tiem_edit'){

    $end_time = filter_compile($_POST['end_time']);
    $sql = "update ecs_app_config set val  ='".$end_time."' where k ='end_time'";
    $GLOBALS['db']->query($sql);
    $sql = "update ecs_app_config set val  ='".filter_compile($_POST['prompt'])."' where k ='prompt'";
    $GLOBALS['db']->query($sql);
    $sql = "update ecs_app_config set val  ='".filter_compile($_POST['yes_no'])."' where k ='yes_no'";
    $GLOBALS['db']->query($sql);
    $links[] = array('text' => "返回设置", 'href' => 'mobile_setting.php?act=end_time');
    sys_msg($_LANG['edit_ok'], 0, $links);
}

elseif ($_REQUEST['act'] == 'img_setting'){
    admin_priv('flash_manage');
    $sql = "select * from ecs_app_config";
    $data = $GLOBALS['db']->getAll($sql);
    foreach ($data as $k=>$v){
        if($v['k']=='version'){
            $version = $v['val'];
        }
        if($v['k']=='url'){
            $url = $v['val'];
        }
        if($v['k']=='day'){
            $day = $v['val'];
        }
        if($v['k']=='tel'){
            $tel = $v['val'];
        }
    }
    if(is_https()){
        $header =   "https://";
    }else{
        $header =   "http://";
    }
    $url = $header.$_SERVER['HTTP_HOST'].'/'.$url;
    $smarty->assign('url',$url);
    $smarty->assign('version',$version);
    $smarty->assign('tel',$tel);
    $smarty->assign('day',$day);
    $smarty->display('img_setting.htm');
}
elseif ($_REQUEST['act'] =='img_edit'){
    if(!empty($_FILES['img']['type'])){
        $path = dirname(__DIR__).'/images/';
        $file_name = md5(time()).'.jpg';
        $res = move_uploaded_file($_FILES['img']['tmp_name'],$path.$file_name);
        $sql = "update ecs_app_config set val='images/".$file_name."' where k='url'";
        $GLOBALS['db']->query($sql);
    }
    $version = filter_compile($_POST['version_name']);
    $sql = "update ecs_app_config set val  ='".$version."' where k ='version'";
    $GLOBALS['db']->query($sql);
    $sql = "update ecs_app_config set val  ='".filter_compile($_POST['day'])."' where k ='day'";
    $GLOBALS['db']->query($sql);
    $sql = "update ecs_app_config set val  ='".filter_compile($_POST['tel'])."' where k ='tel'";
    $GLOBALS['db']->query($sql);
    $links[] = array('text' => '返回设置', 'href' => 'mobile_setting.php?act=img_setting');
    sys_msg($_LANG['edit_ok'], 0, $links);

}
elseif ($_REQUEST['act'] =='prompt_image'){
    $sql = "select * from ecs_app_config";
    $data = $GLOBALS['db']->getAll($sql);
    foreach ($data as $k=>$v){
        if($v['k']=='prompt_image'){
            $prompt_image = $v['val'];
        }
        if($v['k']=='prompt_image_url'){
            $prompt_image_url = $v['val'];
        }
        if($v['k']=='prompt_image_status'){
            $prompt_image_status = $v['val'];
        }
        if($v['k']=='prompt_bonus_id'){
            $prompt_bonus_id = $v['val'];
        }

    }
    $smarty->assign('prompt_image',$prompt_image);
    $smarty->assign('prompt_image_url',$prompt_image_url);
    $smarty->assign('prompt_image_status',$prompt_image_status);
    $smarty->assign('prompt_bonus_id',$prompt_bonus_id);
    $smarty->display('prompt_image.htm');
}
elseif ($_REQUEST['act'] =='default_image'){
    $sql = "select * from ecs_app_config where k = 'default_image'";
    $data = $GLOBALS['db']->getRow($sql);
    $smarty->assign('default_image',$data['val']);
    $smarty->display('default_image.htm');
}
elseif ($_REQUEST['act'] =='up_default_image'){
    if(!empty($_FILES['default_image']['type'])){
        $path = dirname(__DIR__).'/images/';
        $file_name = md5(time()).'.jpg';
        $res = move_uploaded_file($_FILES['default_image']['tmp_name'],$path.$file_name);
        if(is_https()){
            $header =   "https://";
        }else{
            $header =   "http://";
        }

        $images = $header.$_SERVER['HTTP_HOST']."/"."images/".$file_name;
        $sql = "update ecs_app_config set val='".$images."' where k='default_image'";
        $GLOBALS['db']->query($sql);
    }
    if(!empty($_POST['default_image_url'])){
        $sql = "update ecs_app_config set val='".filter_compile($_POST['default_image_url'])."' where k='default_image'";
        $GLOBALS['db']->query($sql);
    }
    $links[] = array('text' => '返回设置', 'href' => 'mobile_setting.php?act=default_image');
    sys_msg($_LANG['edit_ok'], 0, $links);
}
elseif ($_REQUEST['act'] =='kefu'){
    $sql = "select * from ecs_app_config where k = 'kefu_tel'";
    $data = $GLOBALS['db']->getRow($sql);
    $smarty->assign('kefu_tel',$data['val']);
    $smarty->display('kefu.htm');
}
elseif ($_REQUEST['act'] =='up_kefu'){

    $sql = "update  ecs_app_config set val ='".filter_compile($_POST['kefu_tel'])."' where k = 'kefu_tel'";
    $GLOBALS['db']->getAll($sql);
    $links[] = array('text' => '返回设置', 'href' => 'mobile_setting.php?act=kefu');
    sys_msg($_LANG['edit_ok'], 0, $links);

}
elseif ($_REQUEST['act'] =='download'){
    $sql = "select * from ecs_app_config where k = 'appdownload'";
    $data = $GLOBALS['db']->getRow($sql);
    $smarty->assign('download',$data['val']);
    $smarty->display('download.htm');
}
elseif ($_REQUEST['act'] =='up_download'){

    $sql = "update  ecs_app_config set val ='".filter_compile($_POST['download'])."' where k = 'appdownload'";
    $GLOBALS['db']->getAll($sql);
    $links[] = array('text' => '返回设置', 'href' => 'mobile_setting.php?act=download');
    sys_msg($_LANG['edit_ok'], 0, $links);

}
elseif ($_REQUEST['act'] =='up_prompt_image'){

    if(!empty($_FILES['prompt_image']['type'])){
        $path = dirname(__DIR__).'/images/';
        $file_name = md5(time()).'.jpg';
        $res = move_uploaded_file($_FILES['prompt_image']['tmp_name'],$path.$file_name);
        if(is_https()){
            $header =   "https://";
        }else{
            $header =   "http://";
        }
        $images = $header.$_SERVER['HTTP_HOST']."/"."images/".$file_name;
        $sql = "update ecs_app_config set val='".$images."' where k='prompt_image'";
        $GLOBALS['db']->query($sql);
    }
    if(!empty($_POST['prompt_external_image'])){
        $sql = "update ecs_app_config set val='".filter_compile($_POST['prompt_external_image'])."' where k='prompt_image'";
        $GLOBALS['db']->query($sql);
    }
    $sql = "update ecs_app_config set val  ='".filter_compile($_POST['prompt_image_url'])."' where k ='prompt_image_url'";
    $GLOBALS['db']->query($sql);
    $sql = "update ecs_app_config set val  ='".filter_compile($_POST['prompt_image_status'])."' where k ='prompt_image_status'";
    $GLOBALS['db']->query($sql);
    $sql = "update ecs_app_config set val  ='".filter_compile($_POST['prompt_bonus_id'])."' where k ='prompt_bonus_id'";
    $GLOBALS['db']->query($sql);

    $links[] = array('text' => '返回设置', 'href' => 'mobile_setting.php?act=prompt_image');
    sys_msg($_LANG['edit_ok'], 0, $links);
}
elseif($_REQUEST['act'] == 'keywords'){
    /**
     * 热门关键词的查看
     */
    $sql = "select * from ecs_keywords order by count desc";
    $data = $db->query($sql);

    $smarty->assign('playerdb', $data);
    $smarty->display('keywords.html');
}
elseif($_REQUEST['act'] == 'keywords_del'){
    /**
     * 热门关键词的删除
     */
    $keywords = $_GET['keywords']; // 获得删除的值
    $sql = "delete from ecs_keywords where keyword ='".$keywords."'";
    $db->query($sql);

    ecs_header("Location: mobile_setting.php?act=keywords\n");
    exit;

}
elseif ($_REQUEST['act'] == 'logo_setting'){
    $sql = "select * from ecs_app_config where k = 'app_logo'";
    $data = $GLOBALS['db']->getRow($sql);
    $smarty->assign('app_logo',$data['val']);
    $smarty->display('logo_setting.html');
}
elseif ($_REQUEST['act'] == 'up_logo_setting'){
    if(!empty($_FILES['logo_image']['type'])){
        // 允许上传的图片后缀
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["logo_image"]["name"]);
        $extension = end($temp);        // 获取文件后缀名
        if ((($_FILES["logo_image"]["type"] == "image/gif")
                || ($_FILES["logo_image"]["type"] == "image/jpeg")
                || ($_FILES["logo_image"]["type"] == "image/jpg")
                || ($_FILES["logo_image"]["type"] == "image/pjpeg")
                || ($_FILES["logo_image"]["type"] == "image/x-png")
                || ($_FILES["logo_image"]["type"] == "image/png"))
            && ($_FILES["logo_image"]["size"] < 2*1024*1024)    // 小于 2M
            && in_array($extension, $allowedExts))
        {
            $path = dirname(__DIR__).'/images/';
            $file_name = md5(time()).'.jpg';
            $res = move_uploaded_file($_FILES['logo_image']['tmp_name'],$path.$file_name);
            if(is_https()){
                $header =   "https://";
            }else{
                $header =   "http://";
            }

            $images = $header.$_SERVER['HTTP_HOST']."/"."images/".$file_name;
            $sql = "update ecs_app_config set val ='".$images."' where k='app_logo'";
            $db->query($sql);
            $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=logo_setting');
            sys_msg("首页logo修改成功", 0, $links);
        }else {
            $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=logo_setting');
            sys_msg("图片只能为jpg,jpeg,png,pjpeg,x-png,gif", 0, $links);
        }
    }else {
        //使用外部链接
        $image_url = filter_compile($_POST['image_url']);
        $sql = "update ecs_app_config set val ='".$image_url."' where k='app_logo'";
        $GLOBALS['db']->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=logo_setting');
        sys_msg("首页logo修改成功", 0, $links);
    }
}

elseif ($_REQUEST['act'] == 'logo_other'){
    $sql = "select * from ecs_shop_config where code = 'shop_other'";
    $data = $GLOBALS['db']->getRow($sql);
    $smarty->assign('shop_other',$data['value']);
    $smarty->display('logo_other.html');
}
elseif ($_REQUEST['act'] == 'up_logo_other'){
    if(!empty($_FILES['logo_other']['type'])){

        // 允许上传的图片后缀
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["logo_other"]["name"]);
        $extension = end($temp);        // 获取文件后缀名
        if ((($_FILES["logo_other"]["type"] == "image/gif")
                || ($_FILES["logo_other"]["type"] == "image/jpeg")
                || ($_FILES["logo_other"]["type"] == "image/jpg")
                || ($_FILES["logo_other"]["type"] == "image/pjpeg")
                || ($_FILES["logo_other"]["type"] == "image/x-png")
                || ($_FILES["logo_other"]["type"] == "image/png"))
            && ($_FILES["logo_other"]["size"] < 2*1024*1024)    // 小于 2M
            && in_array($extension, $allowedExts))
        {

            $path = dirname(__DIR__).'/images/';
            $file_name = md5(time()).'.jpg';
            $res = move_uploaded_file($_FILES['logo_other']['tmp_name'],$path.$file_name);
            if(is_https()){
                $header =   "https://";
            }else{
                $header =   "http://";
            }
            $images = $header.$_SERVER['HTTP_HOST']."/"."images/".$file_name;
            $sql = "update ecs_shop_config set value='".$images."' where code='shop_other'";
            $GLOBALS['db']->query($sql);
            $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=logo_other');
            sys_msg("其它页logo修改成功", 0, $links);
        }else {
            $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=logo_other');
            sys_msg("图片只能为jpg,jpeg,png,pjpeg,x-png,gif", 0, $links);
        }
    }else {
        //使用外部链接
        $image_url = filter_compile($_POST['image_url']);
        $sql = "update ecs_shop_config set value='".$image_url."' where code='shop_other'";
        $GLOBALS['db']->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=logo_other');
        sys_msg("其它页logo修改成功", 0, $links);
    }
}

//物流配置
elseif ($_REQUEST['act'] == 'logistics'){
    $sql = "select value from  ecs_shop_config  WHERE code = 'logistics_trace'";
    $res = $GLOBALS['db']->getRow($sql);
    $result = unserialize($res['value']);//数据转换
    $smarty->assign('logistics',$result);
    $smarty ->display('logistics.html');
}
elseif ($_REQUEST['act'] == 'updata_logistics'){

    $logistics_userId = filter_compile($_POST['logistics_userId']);  //赋值
    $logistics_key = filter_compile($_POST['logistics_key']);
    $shippercode = filter_compile($_POST['shippercode']);
    $arr = array("logistics_userId" => $logistics_userId,"logistics_key" => $logistics_key,"shippercode" => $shippercode);
    $result = serialize($arr);//数据转换
    $sql = "update ecs_shop_config SET value='$result' WHERE code = 'logistics_trace'";
    $res = $GLOBALS['db']->query($sql);
    $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=logistics');
    sys_msg("修改成功", 0, $links);//sys_msg()是一个消息提示,自动跳转的方法
}

elseif ($_REQUEST['act'] == 'index_imgae_add'|| $_REQUEST['act']=='edit_index_imgae'){
    $data['act'] = 'save_index_imgae';
    if( $_REQUEST['act']=='edit_index_imgae'){
        $sql = "select * from ecs_index_prompt where id= '".$_GET['id']."'";
        $data = $GLOBALS['db']->getRow($sql);
        $data['act'] = 'update_index_imgae';
    }
    $smarty->assign('rt',$data);
    $smarty ->display('index_imgae_add.htm');
}
elseif ($_REQUEST['act'] == 'index_imgae'){
    $sql = "select * from ecs_index_prompt where 1";
    $data = $GLOBALS['db']->getAll($sql);
    foreach ($data as $key =>$val){
        if($val['status'] == 'true'){
            $data[$key]['status'] ='是';
        }else{
            $data[$key]['status'] ='否';
        }
    }
    $smarty->assign('playerdb',$data);
    $smarty ->display('index_imgae.html');
}

elseif ($_REQUEST['act'] == 'save_index_imgae' ||$_REQUEST['act']=='update_index_imgae'){
    if (!empty($_FILES['img_file_src']['name']))
    {
        if(!get_file_suffix($_FILES['img_file_src']['name'], $allow_suffix))
        {
            sys_msg($_LANG['invalid_type']);
        }
        //有上传
        $name = date('Ymd');
        for ($i = 0; $i < 6; $i++)
        {
            $name .= chr(mt_rand(97, 122));
        }
        $img_file_src_name_arr = explode('.', $_FILES['img_file_src']['name']);
        $name .= '.' . end($img_file_src_name_arr);
        $target = ROOT_PATH . DATA_DIR . '/afficheimg/' . $name;
        if (move_upload_file($_FILES['img_file_src']['tmp_name'], $target))
        {
            $src = DATA_DIR . '/afficheimg/' . $name;
        }

    } elseif (!empty($_POST['image_url']))
    {
        if(!get_file_suffix($_POST['image_url'], $allow_suffix))
        {
            sys_msg($_LANG['invalid_type']);
        }
        $src = filter_compile($_POST['image_url']);
    }else{
            // 没有上传图片 也没有填写图片地址
            $links[] = array('text' => '返回', 'href' => 'mobile_setting.php?act=index_imgae_add');
            sys_msg("请上传图片", 0, $links);
    }

    if(empty($_POST['img_text'])){
        $links[] = array('text' => '返回', 'href' => 'mobile_setting.php?act=index_imgae_add');
        sys_msg("请填写文字", 0, $links);
    }
    if($_REQUEST['act'] == 'update_index_imgae'){
        $sql = "update ecs_index_prompt  set   image_url='".$src."',image_prompt='".filter_compile($_POST['img_text'])."',sort='".filter_compile($_POST['sort'])."',status='".filter_compile($_POST['status'])."' where id = '".$_POST['id']."'";
    }else{
        $sql = "insert into ecs_index_prompt (image_url,image_prompt,sort,status,ctime) values  ('".$src."','".filter_compile($_POST['img_text'])."','".filter_compile($_POST['sort'])."','".filter_compile($_POST['status'])."','".time()."');";
    }
    if($GLOBALS['db']->query($sql)){
        $links[] = array('text' => '返回', 'href' => 'mobile_setting.php?act=index_imgae');
        sys_msg("设置成功", 0, $links);
    }else{
        $links[] = array('text' => '返回', 'href' => 'mobile_setting.php?act=index_imgae');
        sys_msg("设置失败", 0, $links);
    }

}
elseif ($_REQUEST['act'] == 'delete_index_imgae'){
    $sql = "delete  from   ecs_index_prompt  where id='".$_GET['id']."'";
    if($GLOBALS['db']->query($sql)){
        $links[] = array('text' => '返回', 'href' => 'mobile_setting.php?act=index_imgae');
        sys_msg("删除成功", 0, $links);
    }

}

elseif ($_REQUEST['act'] == 'pay_dispose'){

    //查找微信小程序支付配置
    $select = "select * from ecs_shop_config where code = 'small'";//查询语句
    $query =  $db->query($select);//执行一条语句
    $unser = mysqli_fetch_assoc($query);//转换成数组格式
    $result = unserialize($unser['value']);//数据转换
    $smarty->assign("pay",$result);

    //查找微信H5支付配置
    $hselect = "select * from ecs_shop_config where code = 'hfive'";
    $hquery =  $db->query($hselect);
    $hunser = mysqli_fetch_assoc($hquery);
    $hresult = unserialize($hunser['value']);

    $smarty->assign("hfivepay",$hresult);

    //查找微信APP支付配置
    $aselect = "select * from ecs_shop_config where code = 'app'";
    $aquery =  $db->query($aselect);
    $aunser = mysqli_fetch_assoc($aquery);
    $aresult = unserialize($aunser['value']);
    $smarty->assign("apppay",$aresult);

    //龙支付配置
    $aselect = "select * from ecs_shop_config where code = 'pay_ccb'";
    $ccb =  $db->query($aselect);
    $ccbser = mysqli_fetch_assoc($ccb);
    $ccbresult = unserialize($ccbser['value']);
    $smarty->assign("ccb",$ccbresult);

    //查找支付宝支付配置
    $zselect = "select * from ecs_shop_config where code = 'zhifu'";
    $zquery =  $db->query($zselect);
    $zunser = mysqli_fetch_assoc($zquery);
    $zresult = unserialize($zunser['value']);
    $smarty->assign("zhifupay",$zresult);
    $smarty ->display('pay_bold.html');
}
elseif ($_REQUEST['act'] == 'pay_input_one'){
    //微信小程序支付配置
    $pay_small_id = filter_compile($_POST['pay_small_id']);  //赋值
    $pay_small_sw = filter_compile($_POST['pay_small_sw']);
    $pay_small_key = filter_compile($_POST['pay_small_key']);
    $pay_small_secret = filter_compile($_POST['pay_small_secret']);
    $pay_small_home = filter_compile($_POST['pay_small_home']);
    $pay_small_gethome = filter_compile($_POST['pay_small_gethome']);
    $pay_small_is_use = filter_compile($_POST['is_use_small']);
    $arr = array("id" => $pay_small_id,"sw" => $pay_small_sw,"key" => $pay_small_key,"secret" => $pay_small_secret,"home" => $pay_small_home,"gethome" => $pay_small_gethome,"is_use" => $pay_small_is_use);
    $result = serialize($arr);//数据转换

    $select = "select * from ecs_shop_config where code = 'small'";//查询语句
    $res =  $db->query($select);
    $res = mysqli_fetch_assoc($res);
    if($pay_small_id == "" || $pay_small_sw == "" || $pay_small_key == "" || $pay_small_secret == "" || $pay_small_home == "" || $pay_small_gethome == ""){
        //如果文本框为空 弹出请全部填写后提交
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=pay_dispose');
        sys_msg("请全部填写后提交", 0, $links);
    }elseif (empty($res['code'])){//empty — 检查一个变量是否为空 如果不为空数据插入到数据库
        $sql = "insert into ecs_shop_config(parent_id,code,type,store_range,store_dir,value,sort_order) values('0','small','peizhi','','','$result','0')";
        $res = $db->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=pay_dispose');
        sys_msg("修改成功", 0, $links);
    }else{//如果数据库存在输入的该条数据 对此进行覆盖(修改)
        $sql = "update ecs_shop_config SET value='$result' WHERE code = 'small'";
        $res = $db->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=pay_dispose');
        sys_msg("修改成功", 0, $links);//sys_msg()是一个消息提示,自动跳转的方法
    }
}

elseif ($_REQUEST['act'] == 'pay_input_two'){
    //微信H5支付配置
    $pay_hfive_id = filter_compile($_POST['pay_hfive_id']);
    $pay_hfive_page = filter_compile($_POST['pay_hfive_page']);
    $pay_hfive_sw = filter_compile($_POST['pay_hfive_sw']);
    $pay_hfive_key = filter_compile($_POST['pay_hfive_key']);
    $pay_hfive_secret = filter_compile($_POST['pay_hfive_secret']);
    $pay_hfive_home = filter_compile($_POST['pay_hfive_home']);
    $pay_hfive_gethome = filter_compile($_POST['pay_hfive_gethome']);
    $pay_hfive_is_use = filter_compile($_POST['is_use_hfive']);
    $arr = array("hfiveid" => $pay_hfive_id,"hfivepage" => $pay_hfive_page,"hfivesw" => $pay_hfive_sw,"hfivekey" => $pay_hfive_key,
        "hfivesecret" => $pay_hfive_secret,"hfivehome"=>$pay_hfive_home,"hfivegethome"=>$pay_hfive_gethome,"is_use"=>$pay_hfive_is_use);
    $result = serialize($arr);
    $select = "select * from ecs_shop_config where code = 'hfive'";
    $res =  $db->query($select);
    $res = mysqli_fetch_assoc($res);
    if($pay_hfive_id == "" || $pay_hfive_page == "" || $pay_hfive_sw == "" ||  $pay_hfive_key == "" || $pay_hfive_secret == "" || $pay_hfive_home == "" || $pay_hfive_gethome == ""){
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=pay_dispose');
        sys_msg("请全部填写后提交", 0, $links);
    } elseif (empty($res['code'])){
        $sql = "insert into ecs_shop_config(parent_id,code,type,store_range,store_dir,value,sort_order) values('0','hfive','peizhi','','','$result','0')";
        $res = $db->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=pay_dispose');
        sys_msg("修改成功", 0, $links);
    }else{
        $sql = "update ecs_shop_config SET value='$result' WHERE code = 'hfive'";
        $res = $db->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=pay_dispose');
        sys_msg("修改成功", 0, $links);
    }
}

elseif ($_REQUEST['act'] == 'pay_input_three'){
    //微信APP支付配置
    $pay_app_id = filter_compile($_POST['pay_app_id']);
    $pay_app_sw = filter_compile($_POST['pay_app_sw']);
    $pay_app_key = filter_compile($_POST['pay_app_key']);
    $pay_app_secret = filter_compile($_POST['pay_app_secret']);
    $pay_app_home = filter_compile($_POST['pay_app_home']);
    $pay_app_gethome = filter_compile($_POST['pay_app_gethome']);
    $pay_app_is_use = filter_compile($_POST['is_use_app']);
    $arr = array("appid" => $pay_app_id,"appsw" => $pay_app_sw,"appkey" => $pay_app_key,"appsecret" => $pay_app_secret,"apphome" => $pay_app_home,"appgethome"=>$pay_app_gethome,"is_use"=>$pay_app_is_use);
    $result = serialize($arr);
    $select = "select * from ecs_shop_config where code = 'app'";
    $res =  $db->query($select);
    $res = mysqli_fetch_assoc($res);
    if($pay_app_id == "" || $pay_app_sw == "" || $pay_app_key == "" ||  $pay_app_secret == "" || $pay_app_home == "" || $pay_app_gethome == "" ){
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=pay_dispose');
        sys_msg("请全部填写后提交", 0, $links);
    } elseif (empty($res['code'])){
        $sql = "insert into ecs_shop_config(parent_id,code,type,store_range,store_dir,value,sort_order) values('0','app','peizhi','','','$result','0')";
        $res = $db->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=pay_dispose');
        sys_msg("修改成功", 0, $links);
    }else{
        $sql = "update ecs_shop_config SET value='$result' WHERE code = 'app'";
        $res = $db->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=pay_dispose');
        sys_msg("修改成功", 0, $links);
    }

}

elseif ($_REQUEST['act'] == 'pay_input_four'){
    //支付宝支付配置
    $pay_zhifu_id = filter_compile($_POST['pay_zhifu_id']);
    $pay_zhifu_wg = filter_compile($_POST['pay_zhifu_wg']);
    $pay_zhifu_appid = filter_compile($_POST['pay_zhifu_appid']);
    $pay_zhifu_sy = filter_compile($_POST['pay_zhifu_sy']);
    $pay_zhifu_gy = filter_compile($_POST['pay_zhifu_gy']);
    $pay_zhifu_home = filter_compile($_POST['pay_zhifu_home']);
    $pay_zhifu_gethome = filter_compile($_POST['pay_zhifu_gethome']);
    $alipay_h5_url = filter_compile($_POST['alipay_h5_url']);
    $pay_zhifu_is_use = filter_compile($_POST['is_use_zhifu']);
    $arr = array("zid" => $pay_zhifu_id,"zwg" => $pay_zhifu_wg,"zappid" => $pay_zhifu_appid,"zsy" => $pay_zhifu_sy,
        "zgy" => $pay_zhifu_gy,"zhome"=> $pay_zhifu_home,"zgethome"=>$pay_zhifu_gethome,"is_use"=>$pay_zhifu_is_use,'alipay_h5_url'=>$alipay_h5_url);
    $result = serialize($arr);
    $select = "select * from ecs_shop_config where code = 'zhifu'";
    $res =  $db->query($select);
    $res = mysqli_fetch_assoc($res);
    if($pay_zhifu_id == "" || $pay_zhifu_wg == "" || $pay_zhifu_appid == "" ||  $pay_zhifu_sy == "" || $pay_zhifu_gy == "" || $pay_zhifu_home == "" || $pay_zhifu_gethome == ""){
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=pay_dispose');
        sys_msg("请全部填写后提交", 0, $links);
    } elseif (empty($res['code'])){
        $sql = "insert into ecs_shop_config(parent_id,code,type,store_range,store_dir,value,sort_order) values('0','zhifu','peizhi','','','$result','0')";
        $res = $db->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=pay_dispose');
        sys_msg("修改成功", 0, $links);
    }else{
        $sql = "update ecs_shop_config SET value='$result' WHERE code = 'zhifu'";
        $res = $db->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=pay_dispose');
        sys_msg("修改成功", 0, $links);
    }
}
elseif ($_REQUEST['act'] == 'pay_input_ccb'){
    //支付宝支付配置
    $merchant = filter_compile($_POST['merchant']);
    $pos = filter_compile($_POST['pos']);
    $branch = filter_compile($_POST['branch']);
    $pub = filter_compile($_POST['pub']);
    $is_use_ccb = filter_compile($_POST['is_use_ccb']);
    $pay_ccb_url = filter_compile($_POST['pay_ccb_url']);

    $arr = array("merchant" => $merchant,"pos" => $pos,"branch" => $branch,"pub" => $pub,"is_use_ccb" => $is_use_ccb,'pay_ccb_url'=>$pay_ccb_url);
    $result = serialize($arr);
    $select = "select * from ecs_shop_config where code = 'pay_ccb'";
    $res =  $db->query($select);

    $res = mysqli_fetch_assoc($res);
    if($merchant == "" || $pos == "" || $branch == "" ||  $pub == ""){
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=pay_dispose');
        sys_msg("请全部填写后提交", 0, $links);
    } elseif (empty($res['code'])){
        $sql = "insert into ecs_shop_config(parent_id,code,type,store_range,store_dir,value,sort_order) values('0','pay_ccb','peizhi','','','$result','0')";
        $res = $db->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=pay_dispose');
        sys_msg("修改成功", 0, $links);
    }else{
        $sql = "update ecs_shop_config SET value='$result' WHERE code = 'pay_ccb'";
        $res = $db->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=pay_dispose');
        sys_msg("修改成功", 0, $links);
    }
}


elseif ($_REQUEST['act'] == 'app_update'){


    //查找app配置
    $select = "select * from ecs_app_update ";//查询语句
    $query =  $db->query($select);//执行一条语句
    $unser = mysqli_fetch_assoc($query);//转换成数组格式
//    把数据提交到页面
    $smarty->assign("app",$unser);
//    加载页面
    $smarty ->display('app_update.htm');



}

elseif ($_REQUEST['act'] == 'app_modify'){
    //微信小程序支付配置
    $app_name = filter_compile($_POST['app_name']);  //赋值
    $app_nowId = filter_compile($_POST['app_nowId']);
    $app_updateId = filter_compile($_POST['app_updateId']);
    $app_iosLink = filter_compile($_POST['app_iosLink']);
    $app_androidLink = filter_compile($_POST['app_androidLink']);

    $select = "select * from ecs_app_update ";//查询语句
    $res =  $db->query($select);
    $res = mysqli_fetch_assoc($res);
    if (empty($res['id'])){//empty — 检查一个变量是否为空 如果不为空插入到数据库
        $sql = "insert into ecs_app_update(name,nowId,updateId,iosLink,androidLink) values('$app_name','$app_nowId','$app_updateId','$app_iosLink','$app_androidLink')";
        $res = $db->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=app_update');
        sys_msg("修改成功", 0, $links);
    }else{//如果数据库存在输入的该条数据 对此进行覆盖(修改)
        $a = $res['id'];
        $sql = "update ecs_app_update SET name= '$app_name' ,nowId = '$app_nowId' ,updateId = '$app_updateId' ,iosLink = '$app_iosLink', androidLink = '$app_androidLink' WHERE id = $a";

        $res = $db->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=app_update');
        sys_msg("修改成功", 0, $links);//sys_msg()是一个消息提示,自动跳转的方法
    }
}

elseif ($_REQUEST['act'] == 'copyright_modify'){


    //查找app配置
    $select = "select * from ecs_copyright_modify ";//查询语句
    $query =  $db->query($select);//执行一条语句
    $unser = mysqli_fetch_assoc($query);//转换成数组格式
//    把数据提交到页面
    $smarty->assign("copyright",$unser);
//    加载页面
    $smarty ->display('copyright_modify.htm');



}

elseif ($_REQUEST['act'] == 'copyright_update'){
    //微信小程序支付配置
    $copyright_one = filter_compile($_POST['copyright_one']);  //赋值
    $copyright_two = filter_compile($_POST['copyright_two']);


    $select = "select * from ecs_copyright_modify ";//查询语句
    $res =  $db->query($select);
    $res = mysqli_fetch_assoc($res);
    if($copyright_one == "" || $copyright_two == ""  ){
        //如果文本框为空 弹出请全部填写后提交
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=copyright_modify');
        sys_msg("请全部填写后提交", 0, $links);
    }elseif (empty($res['id'])){//empty — 检查一个变量是否为空 如果不为空插入到数据库
        $sql = "insert into ecs_copyright_modify(copyright_one,copyright_two) values('$copyright_one','$copyright_two')";
        $res = $db->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=copyright_modify');
        sys_msg("修改成功", 0, $links);
    }else{//如果数据库存在输入的该条数据 对此进行覆盖(修改)
        $a = $res['id'];
        $sql = "update ecs_copyright_modify SET copyright_one= '$copyright_one' ,copyright_two = '$copyright_two' WHERE id = $a";

        $res = $db->query($sql);
        $links[] = array('text' => '取消等待，立即返回', 'href' => 'mobile_setting.php?act=copyright_modify');
        sys_msg("修改成功", 0, $links);//sys_msg()是一个消息提示,自动跳转的方法
    }
}











elseif($_REQUEST['act'] == 'keywords_add'){
    /**
     * 热门关键词的添加
     */
    if(!$_POST){

        $smarty->display('keywords_add.html');
    }else{
        $keywords = filter_compile($_POST['keywords']);
        $count = filter_compile($_POST['count']);
        if($keywords == '' || $count == ''){
            ecs_header("Location: mobile_setting.php?act=keywords\n");
            exit;
        }
        $sql = "insert into ecs_keywords set keyword='".$keywords."',count='".$count."'";
        $res = $db->query($sql);
        if(!$res){
            $links[] = array('text' => "添加失败", 'href' => 'mobile_setting.php?act=keywords');

            sys_msg($_LANG['edit_ok'], 0, $links);
        }
        $links[] = array('text' => "添加成功", 'href' => 'mobile_setting.php?act=keywords');

        sys_msg($_LANG['edit_ok'], 0, $links);
    }
}

function get_flash_xml()
{
    $flashdb = array();
    if (file_exists(ROOT_PATH . DATA_DIR . '/flash_data.xml'))
    {

        // 兼容v2.7.0及以前版本
        if (!preg_match_all('/item_url="([^"]+)"\slink="([^"]+)"\stext="([^"]*)"\ssort="([^"]*)"/', file_get_contents(ROOT_PATH . DATA_DIR . '/flash_data.xml'), $t, PREG_SET_ORDER))
        {
            preg_match_all('/item_url="([^"]+)"\slink="([^"]+)"\stext="([^"]*)"/', file_get_contents(ROOT_PATH . DATA_DIR . '/flash_data.xml'), $t, PREG_SET_ORDER);
        }

        if (!empty($t))
        {
            foreach ($t as $key => $val)
            {
                $val[4] = isset($val[4]) ? $val[4] : 0;
                $flashdb[] = array('src'=>$val[1],'url'=>$val[2],'text'=>$val[3],'sort'=>$val[4]);
            }
        }
    }
    return $flashdb;
}

function put_flash_xml($flashdb)
{
    if (!empty($flashdb))
    {
        $xml = '<?xml version="1.0" encoding="' . EC_CHARSET . '"?><bcaster>';
        foreach ($flashdb as $key => $val)
        {
            $xml .= '<item item_url="' . $val['src'] . '" link="' . $val['url'] . '" text="' . $val['text'] . '" sort="' . $val['sort'] . '"/>';
        }
        $xml .= '</bcaster>';
        file_put_contents(ROOT_PATH . DATA_DIR . '/flash_data.xml', $xml);
    }
    else
    {
        @unlink(ROOT_PATH . DATA_DIR . '/flash_data.xml');
    }
}

function get_url_image($url)
{
    $url_arr = explode('.', $url);
    $ext = strtolower(end($url_arr));
    if($ext != "gif" && $ext != "jpg" && $ext != "png" && $ext != "bmp" && $ext != "jpeg")
    {
        return $url;
    }

    $name = date('Ymd');
    for ($i = 0; $i < 6; $i++)
    {
        $name .= chr(mt_rand(97, 122));
    }
    $name .= '.' . $ext;
    $target = ROOT_PATH . DATA_DIR . '/afficheimg/' . $name;

    $tmp_file = DATA_DIR . '/afficheimg/' . $name;
    $filename = ROOT_PATH . $tmp_file;

    $img = file_get_contents($url);

    $fp = @fopen($filename, "a");
    fwrite($fp, $img);
    fclose($fp);

    return $tmp_file;
}

function get_width_height()
{
    $curr_template = $GLOBALS['_CFG']['template'];
    $path = ROOT_PATH . 'themes/' . $curr_template . '/library/';
    $template_dir = @opendir($path);

    $width_height = array();
    while($file = readdir($template_dir))
    {
        if($file == 'index_ad.lbi')
        {
            $string = file_get_contents($path . $file);
            $pattern_width = '/var\s*swf_width\s*=\s*(\d+);/';
            $pattern_height = '/var\s*swf_height\s*=\s*(\d+);/';
            preg_match($pattern_width, $string, $width);
            preg_match($pattern_height, $string, $height);
            if(isset($width[1]))
            {
                $width_height['width'] = $width[1];
            }
            if(isset($height[1]))
            {
                $width_height['height'] = $height[1];
            }
            break;
        }
    }

    return $width_height;
}

function get_flash_templates($dir)
{
    $flashtpls = array();
    $template_dir        = @opendir($dir);
    while ($file = readdir($template_dir))
    {
        if ($file != '.' && $file != '..' && is_dir($dir . $file) && $file != '.svn' && $file != 'index.htm')
        {
            $flashtpls[] = get_flash_tpl_info($dir, $file);
        }
    }
    @closedir($template_dir);
    return $flashtpls;
}

function get_flash_tpl_info($dir, $file)
{
    $info = array();
    if (is_file($dir . $file . '/preview.jpg'))
    {
        $info['code'] = $file;
        $info['screenshot'] = '../data/flashdata/' . $file . '/preview.jpg';
        $arr = array_slice(file($dir . $file . '/cycle_image.js'), 1, 2);
        $info_name = explode(':', $arr[0]);
        $info_desc = explode(':', $arr[1]);
        $info['name'] = isset($info_name[1])?trim($info_name[1]):'';
        $info['desc'] = isset($info_desc[1])?trim($info_desc[1]):'';
    }
    return $info;
}

function set_flash_data($tplname, &$msg)
{
    $flashdata = get_flash_xml();
    if (empty($flashdata))
    {
        $flashdata[] = array(
            'src' => 'data/afficheimg/20081027angsif.jpg',
            'text' => 'ECShop',
            'url' =>'http://www.ecshop.com'
        );
        $flashdata[] = array(
            'src' => 'data/afficheimg/20081027wdwd.jpg',
            'text' => 'wdwd',
            'url' =>'http://www.wdwd.com'
        );
        $flashdata[] = array(
            'src' => 'data/afficheimg/20081027xuorxj.jpg',
            'text' => 'ECShop',
            'url' =>'http://help.ecshop.com/index.php?doc-view-108.htm'
        );
    }
    switch($tplname)
    {
        case 'uproll':
            $msg = set_flash_uproll($tplname, $flashdata);
            break;
        case 'redfocus':
        case 'pinkfocus':
        case 'dynfocus':
            $msg = set_flash_focus($tplname, $flashdata);
            break;
        case 'default':
        default:
            $msg = set_flash_default($tplname, $flashdata);
            break;
    }
    return $msg !== true;
}

function set_flash_uproll($tplname, $flashdata)
{
    $data_file = ROOT_PATH . DATA_DIR . '/flashdata/' . $tplname . '/data.xml';
    $xmldata = '<?xml version="1.0" encoding="' . EC_CHARSET . '"?><myMenu>';
    foreach ($flashdata as $data)
    {
        $xmldata .= '<myItem pic="' . $data['src'] . '" url="' . $data['url'] . '" />';
    }
    $xmldata .= '</myMenu>';
    file_put_contents($data_file, $xmldata);
    return true;
}

function set_flash_focus($tplname, $flashdata)
{
    $data_file = ROOT_PATH . DATA_DIR . '/flashdata/' . $tplname . '/data.js';
    $jsdata = '';
    $jsdata2 = array('url' => 'var pics=', 'txt' => 'var texts=', 'link' => 'var links=');
    $count = 1;
    $join = '';
    foreach ($flashdata as $data)
    {
        $jsdata .= 'imgUrl' . $count . '="' . $data['src'] . '";' . "\n";
        $jsdata .= 'imgtext' . $count . '="' . $data['text'] . '";' . "\n";
        $jsdata .= 'imgLink' . $count . '=escape("' . $data['url'] . '");' . "\n";
        if ($count != 1)
        {
            $join = '+"|"+';
        }
        $jsdata2['url'] .= $join . 'imgUrl' . $count;
        $jsdata2['txt'] .= $join . 'imgtext' . $count;
        $jsdata2['link'] .= $join . 'imgLink' . $count;
        ++$count;
    }
    file_put_contents($data_file, $jsdata . "\n" . $jsdata2['url'] . ";\n" . $jsdata2['link'] . ";\n" . $jsdata2['txt'] . ";");
    return true;
}

function set_flash_default($tplname, $flashdata)
{
    $data_file = ROOT_PATH . DATA_DIR . '/flashdata/' . $tplname . '/data.xml';
    $xmldata = '<?xml version="1.0" encoding="' . EC_CHARSET . '"?><bcaster>';
    foreach ($flashdata as $data)
    {
        $xmldata .= '<item item_url="' . $data['src'] . '" link="' . $data['url'] . '" />';
    }
    $xmldata .= '</bcaster>';
    file_put_contents($data_file, $xmldata);
    return true;
}

/**
 *  获取用户自定义广告列表信息
 *
 * @access  public
 * @param
 *
 * @return void
 */
function ad_list()
{
    $result = get_filter();
    if ($result === false)
    {
        $aiax = isset($_GET['is_ajax']) ? $_GET['is_ajax'] : 0;
        $filter = array();
        $filter['sort_by'] = 'add_time';
        $filter['sort_order'] = 'DESC';

        /* 过滤信息 */
        $where = 'WHERE 1 ';

        /* 查询 */
        $sql = "SELECT ad_id, CASE WHEN ad_type = 0 THEN '图片'
                                   WHEN ad_type = 1 THEN 'Flash'
                                   WHEN ad_type = 2 THEN '代码'
                                   WHEN ad_type = 3 THEN '文字'
                                   ELSE '' END AS type_name, ad_name, add_time, CASE WHEN ad_status = 1 THEN '启用' ELSE '关闭' END AS status_name, ad_type, ad_status
                FROM " . $GLOBALS['ecs']->table("ad_custom") . "
                $where
                ORDER BY " . $filter['sort_by'] . " " . $filter['sort_order']. " ";

        set_filter($filter, $sql);
    }
    else
    {
        $sql    = $result['sql'];
        $filter = $result['filter'];
    }

    $row = $GLOBALS['db']->getAll($sql);

    /* 格式化数据 */
    foreach ($row AS $key => $value)
    {
        $row[$key]['add_time'] = local_date($GLOBALS['_CFG']['time_format'], $value['add_time']);
    }

    $arr = array('ad' => $row, 'filter' => $filter);

    return $arr;
}

/**
 * 修改自定义相状态
 *
 * @param   int     $ad_id       自定义广告 id
 * @param   int     $ad_status   自定义广告 状态 0，关闭；1，开启。
 * @access  private
 * @return  Bool
 */
function modfiy_ad_status($ad_id, $ad_status = 0)
{
    $return = false;

    if (empty($ad_id))
    {
        return $return;
    }

    /* 查询自定义广告信息 */
    $sql = "SELECT ad_type, content, url, ad_status FROM " . $GLOBALS['ecs']->table("ad_custom") . " WHERE ad_id = $ad_id LIMIT 0, 1";
    $ad = $GLOBALS['db']->getRow($sql);

    if ($ad_status == 1)
    {
        /* 如果当前自定义广告是关闭状态 则修改其状态为启用 */
        if ($ad['ad_status'] == 0)
        {
            $sql = "UPDATE " . $GLOBALS['ecs']->table("ad_custom") . " SET ad_status = 1 WHERE ad_id = $ad_id";
            $GLOBALS['db']->query($sql);
        }

        /* 关闭 其它自定义广告 */
        $sql = "UPDATE " . $GLOBALS['ecs']->table("ad_custom") . " SET ad_status = 0 WHERE ad_id <> $ad_id";
        $GLOBALS['db']->query($sql);

        /* 用户自定义广告开启 */
        $sql = "UPDATE " . $GLOBALS['ecs']->table("shop_config") . " SET value = 'cus' WHERE id =337";
        $GLOBALS['db']->query($sql);
    }
    else
    {
        /* 如果当前自定义广告是关闭状态 则检查是否存在启用的自定义广告 */
        /* 如果无 则启用系统默认广告播放器 */
        if ($ad['ad_status'] == 0)
        {
            $sql = "SELECT COUNT(ad_id) FROM " . $GLOBALS['ecs']->table("ad_custom") . " WHERE ad_status = 1";
            $ad_status_1 = $GLOBALS['db']->getOne($sql);
            if (empty($ad_status_1))
            {
                $sql = "UPDATE " . $GLOBALS['ecs']->table("shop_config") . " SET value = 'sys' WHERE id =337";
                $GLOBALS['db']->query($sql);
            }
            else
            {
                $sql = "UPDATE " . $GLOBALS['ecs']->table("shop_config") . " SET value = 'cus' WHERE id =337";
                $GLOBALS['db']->query($sql);
            }
        }
        else
        {
            /* 当前自定义广告是开启状态 关闭之 */
            /* 如果无 则启用系统默认广告播放器 */
            $sql = "UPDATE " . $GLOBALS['ecs']->table("ad_custom") . " SET ad_status = 0 WHERE ad_id = $ad_id";
            $GLOBALS['db']->query($sql);

            $sql = "UPDATE " . $GLOBALS['ecs']->table("shop_config") . " SET value = 'sys' WHERE id =337";
            $GLOBALS['db']->query($sql);
        }
    }

    return $return = true;
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
