<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

#load::sys_class('admin.class.php');
load::mod_class('base/admin/base_admin');
load::mod_class('ui_set/class/config_ui.class.php');
load::mod_class('ui_set/class/config_tem.class.php');
load::mod_class('ui_set/class/config_metui.class.php');
load::sys_func('file');

class index extends base_admin
{
    public $config;
    public $sys_ui_config;
    public $no;
    public $type;
    public $met_ui_config;

    function __construct()
    {
        global $_M;
        parent::__construct();
        $power = background_privilege();
        if (!($power['navigation'] == 'metinfo' || strstr($power['navigation'], '1802'))) {
            Header("Location: " . $_M['url']['site_admin']);
        }
        $this->no = $_M['form']['met_skin_user'] ? $_M['form']['met_skin_user'] : $_M['config']['met_skin_user'];

        $inc_file = PATH_WEB . "templates/{$this->no}/metinfo.inc.php";
        if (file_exists($inc_file)) {
            require $inc_file;
        }
        if ($template_type == 'ui') {
            $this->type = 'ui';
            $this->config = new config_ui($this->no, $_M['lang']);
        } else {
            $this->type = $template_type;
            $this->config = new config_tem($this->no, $_M['lang']);
        }
        $this->met_ui_config = new config_metui($_M['lang']);
    }

    function doindex()
    {
        global $_M;
        $this->checktem($this->no);

        //后台安全提示框
        $admin_folder_safe = $this->admin_folder_safe();
        // 应用列表
        $applist = array();
        $power = admin_information();
        $app = load::mod_class('myapp/myapp', 'new')->listApp();
        foreach ($app as $key => $value) {
            if ($value['install'] && $value['display'] == 2) {
                if (!strstr($power['admin_type'], 'a' . $value['no']) && !strstr($power['admin_type'], 'metinfo')) {
                    continue;
                }
                $value['url'] = $value['version'] ? str_replace($_M['url']['site_admin'] . '#/', '', $value['url']) : $_M['url']['adminurl'] . "n={$value['m_name']}&c={$value['m_class']}&a={$value['m_action']}";
                $applist[] = $value;
            }
        }
        // iframe地址
        $pageset_iframe_src = $_COOKIE['page_iframe_url'] ? $_COOKIE['page_iframe_url'] : $_M['url']['site'] . 'index.php?lang=' . $_M['lang'];
        preg_match('/lang=(\w+)/', $pageset_iframe_src, $lang);
        if ($_M['$lang'] != $lang[1]) {
            $pageset_iframe_src = str_replace($lang[0], 'lang=' . $_M['lang'], $pageset_iframe_src);
        }
        if (strpos($pageset_iframe_src, 'pageset=1') === false) {
            if (strpos($pageset_iframe_src, '?') !== false) {
                $pageset_iframe_src .= '&pageset=1';
            } else {
                $pageset_iframe_src .= '?pageset=1';
            }
        }
        if (!$_COOKIE['page_iframe_url'] || $_M['$lang'] != $lang[1]) {
            setcookie("page_iframe_url", $pageset_iframe_src, 0, '/');
        }

        $auth_data = parent::get_auth($power);
        $data = array(
            'admin_folder_safe' => $admin_folder_safe,
            'applist' => $applist,
            'pageset_iframe_src' => $pageset_iframe_src,
            'power' => $power,
            'auth' => $auth_data
        );

        $data['license'] = 1;
        $data['license_url'] = 'https://u.mituo.cn/api/metinfo/license';
        if (!file_exists(PATH_WEB . 'upload/file/license.html')) {
            $data['license'] = 0;
        }
        
        $sys_json = parent::sys_json();
        $data = array_merge($data, $sys_json);

        $this->view('app/index', $data);
    }

    //获取可视化栏目权限
    function get_auth($power = array())
    {
        global $_M;
        $data= parent::get_auth($power);

        return $data;
    }

    /*检测授权*/
    function checktem($file = '')
    {
        global $_M;
        $str = file_get_contents(PATH_WEB . 'templates/' . $file . '/index.php');
        preg_match('/authtemp\(\'([^;]+)\'\);/', $str, $out);
        if (!$out[1]) {
            $str = file_get_contents(PATH_WEB . 'templates/' . $file . '/config.php');
            preg_match('/authtemp\(\'([^;]+)\'\);/', $str, $out);
        }
        if ($out[1]) {
            $auth_domian = "met_muban_auth_" . $file;
            $muban_auth = explode(',', $_M['config'][$auth_domian]);
            $do_auth = 1;
            foreach ($muban_auth as $val) {
                if (stristr($_M['url']['site'], $val)) {
                    $do_auth = 0;
                }
            }
            if ($do_auth) {
                $curl = load::sys_class('curl', 'new');
                $curl->set('file', 'index.php?n=platform&c=temcheck&a=doagain_auth');
                $post = array('type' => 'tem', 'no' => $file, 'cmsver' => $_M['config']['metcms_v'], 'authtemp' => $out[1]);
                $data = $curl->curl_post($post);
                list($suc, $replace, $code, $foot, $domian) = explode('|', $data);
                $replace = PATH_WEB . 'templates/' . $file . '/' . $replace;
                if ($suc == 'suc') {
                    $str = file_get_contents($replace);
                    $str = preg_replace('/authtemp\(\'([^;]+)\'\);/', $code, $str);
                    file_put_contents($replace, $str);
                    $query = "SELECT * FROM {$_M['table']['config']} WHERE name = '{$auth_domian}' and lang='metinfo'";
                    if (DB::get_one($query)) {
                        $query = "update {$_M['table']['config']} SET value='{$domian}' WHERE name = '{$auth_domian}' and lang='metinfo'";
                        DB::query($query);
                    } else {
                        $query = "INSERT INTO {$_M['table']['config']} SET name='{$auth_domian}',value='{$domian}',lang='metinfo'";
                        DB::query($query);
                    }
                }
            }
        }
    }

    public function dochange_skin()
    {
        global $_M;
        $skin_name = $_M['form']['met_skin_user'];
        $change = $this->config->change_skin($skin_name);
        $this->ajaxReturn(array('status' => $change));
    }

    /**
     * 切换集成UI
     */
    public function dochangeUi()
    {
        global $_M;
        $redata = array();
        $mid = $_M['form']['mid'];
        $ui_name = $_M['form']['ui_name'];
        $ui_info = $this->config->changeUi($mid, $ui_name);
        if ($ui_info == true) {
            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['jsok'];
            $this->ajaxReturn($redata);
        }
    }

    /**
     * 获取区块参数、对应系统设置
     * @DateTime 2017-11-06
     */
    public function doset_area()
    {
        global $_M;
        $mid = $_M['form']['mid'];
        $urls = array(
            'member' => array(
                'url' => 'user',
                'head_tab_active' => 3
            ),
            'lang' => array(
                'url' => 'language',
                'head_tab_active' => 2
            ),
            'online' => array(
                'url' => 'online',
                'head_tab_active' => 1
            ),
            'message_form' => array(
                'url' => 'manage',
                'module' => 'message',
                'class1' => $_M['form']['classnow'],
                'head_tab_active' => 2
            ),
            'feedback' => array(
                'url' => 'manage',
                'module' => 'feedback',
                'class1' => $_M['form']['classnow'],
                'head_tab_active' => 2
            ),
            'search_global' => array(
                'title' => $_M['word']['mod11'],
                'url' => 'search/global/?c=index&a=doGetGlobalSearch'
            ),
            'search_column' => array(
                'title' => $_M['word']['column_search'],
                'url' => 'search/column/?c=index&a=doGetColumnSearch'
            ),
            'search_advanced' => array(
                'title' => $_M['word']['advanced_search'],
                'url' => 'search/advanced/?c=index&a=doGetAdvancedSearch'
            ),
        );
        $redata = array('status' => 1);
        if ($urls[$_M['form']['type']]) {
            $redata['data'] = $urls[$_M['form']['type']];
            $this->ajaxReturn($redata);
        }
        if ($urls[$_M['form']['mid']]) {
            $redata['data'] = $urls[$_M['form']['mid']];
            $this->ajaxReturn($redata);
        } else if (isset($mid)) {
            $ui_data = $this->config->list_data($mid);
            $redata['data'] = $ui_data;
            $redata['data']['template_type'] = $this->type;
            $this->ajaxReturn($redata);
        }
    }

    /**
     * 区块参数保存
     * @return [type] [description]
     */
    function doeditor()
    {
        global $_M;
        $this->config->save_config($_M['form']);
        self::_clear_cahce();
        $redata = array(
            'status' => 1,
            'msg' => $_M['word']['jsok']
        );
        $this->ajaxReturn($redata);
    }

    /**
     * 获取区块对应系统内容设置
     * @DateTime 2017-11-06
     * @return  string $url
     */
    public function doset_content()
    {
        global $_M;
        $mid = $_M['form']['mid'];
        $classnow = $_M['form']['classnow'];
        if ($_M['form']['module'] == 1) {
            $_M['form']['id'] = $classnow;
            $_M['form']['table'] = load::sys_class('handle', 'new')->mod_to_file($_M['form']['module']);
            // unset($classnow);
        } else {
            $_M['form']['table'] = load::sys_class('handle', 'new')->mod_to_file($_M['form']['module']);
        }
        $urls = array(
            'banner' => 'banner',
            'head_nav' => 'column',
            'head_seo' => 'seo',
            'foot_nav' => 'column',
            'foot' => 'webset',
            'member' => 'user',
            'lang' => 'language',
            'online' => 'online',
            'menu' => 'menu',
            'link' => array(
                'url' => 'seo',
                'head_tab_active' => 5
            ),
            'message_list' => array(
                'url' => 'manage',
                'module' => 'message',
                'class1' => $classnow,
                'head_tab_active' => 0
            ),
            'message_form' => array(
                'url' => 'manage',
                'module' => 'message',
                'class1' => $classnow,
                'head_tab_active' => 1
            ),
            'feedback' => array(
                'url' => 'manage',
                'module' => 'feedback',
                'class1' => $classnow,
                'head_tab_active' => 1
            )
        );

        $redata = array('status' => 1);
        if ($urls[$_M['form']['type']]) {
            $redata['data'] = $urls[$_M['form']['type']];
            $this->ajaxReturn($redata);
        }
        if ($urls[$_M['form']['mid']]) {
            $redata['data'] = $urls[$_M['form']['mid']];
            $this->ajaxReturn($redata);
        }
        if ($_M['form']['id']) {
            $id = $_M['form']['id'];
            $module = $_M['form']['table'] == 'column' ? 'about' : $_M['form']['table'];
            $url = "{$module}/edit/?module={$urls['module']}&c={$module}_admin&a=doeditor&id={$id}";
            if($_M['config']['shopv2_open'] && $module=='product'){
                $class = load::sys_class('label', 'new')->get('column')->get_class123_reclass($classnow);
                $url="{$_M['url']['adminurl']}n=product&c=product_admin&a=doeditor&id={$id}&select_class1={$class['class1']['id']}&select_class2={$class['class2']['id']}&select_class3={$class['class3']['id']}&app_type=shop";
            }
        } else {
            $res = $this->config->get_config_column($mid);
            if (!$res) {
                $cid = $classnow;
            } elseif (is_numeric($res)) {
                $redata['data'] = 'manage';
                $this->ajaxReturn($redata);
            } else {
                if (is_numeric($mid)) {
                    $cid = $res['uip_value'] ? $res['uip_value'] : $res['uip_default'];
                } else {
                    $cid = $res['value'] ? $res['value'] : $res['defaultvalue'];
                }
            }
            // $mod = load::sys_class('label', 'new')->get('column')->get_column_id($cid);
            $class = load::sys_class('label', 'new')->get('column')->get_class123_reclass($cid);
            $module = $class['class3']['module'] ? $class['class3']['module'] : ($class['class2']['module'] ? $class['class2']['module'] : $class['class1']['module']);
            $mod_name = load::sys_class('handle', 'new')->mod_to_file($module);
            $url = array(
                'url' => 'manage',
                'module' => $mod_name,
                'class1' => $class['class1']['id'],
                'class2' => $class['class2']['id'],
                'class3' => $class['class3']['id']
            );
        }
        if ($_M['form']['type'] == 'displayimgs') {
            $url .= '&displayimgs=1';
        }
        $redata['data'] = $url;
        $this->ajaxReturn($redata);
    }

    /**
     * 前台时间格式
     * @return [type] [description]
     */
    public function get_time()
    {
        global $_M;
        //列表页设置
        $m_now_time = time();
        $met_timetype = array(
            array('value' => 'Y-m-d H:i:s', 'name' => date('Y-m-d H:i:s', $m_now_time)),
            array('value' => 'Y-m-d', 'name' => date('Y-m-d', $m_now_time)),
            array('value' => 'Y/m/d', 'name' => date('Y/m/d', $m_now_time)),
            array('value' => 'Ymd', 'name' => date('Ymd', $m_now_time)),
            array('value' => 'Y-m', 'name' => date('Y-m', $m_now_time)),
            array('value' => 'Y/m', 'name' => date('Y/m', $m_now_time)),
            array('value' => 'Ym', 'name' => date('Ym', $m_now_time)),
            array('value' => 'm-d', 'name' => date('m-d', $m_now_time)),
            array('value' => 'm/d', 'name' => date('m/d', $m_now_time)),
            array('value' => 'md', 'name' => date('md', $m_now_time))
        );
        return $met_timetype;
    }

    /**
     * 前端通过表、字段、id来获取文本内容
     * @DateTime 2017-11-09
     * @return   json
     */
    public function doget_text_content()
    {
        global $_M;
        $table = $_M['form']['table'];
        $field = $_M['form']['field'];
        $id = $_M['form']['id'];

        $sys_compile = load::sys_class('view/sys_compile', 'new');
        $content = $sys_compile->get_field_text($table, $field, $id);

        $this->ajaxReturn($content);
    }


    /**
     * 前端更新指定数据内容
     * @DateTime 2017-11-09
     * @return json 更新结果状态
     */
    public function doset_text_content()
    {
        global $_M;
        $table = $_M['form']['table'];
        $field = $_M['form']['field'];
        $id = $_M['form']['id'];
        $text = $_M['form']['text'];
        $sys_compile = load::sys_class('view/sys_compile', 'new');
        $content = $sys_compile->set_field_text($table, $field, $id, $text);

        self::_clear_cahce();
        $this->ajaxReturn($content);
    }

    /**
     * 图片修改保存
     * @return [type] [description]
     */
    public function dosave_img()
    {
        global $_M;
        $id = $_M['form']['id'];
        $table = $_M['form']['table'];
        $field = $_M['form']['field'];
        $new_img = $_M['form']['new_img'];

        if (strpos($new_img, PATH_WEB) === false) {
            $sys_compile = load::sys_class('view/sys_compile', 'new');
            $update = $sys_compile->save_img_field($table, $field, $id, $new_img);

            if ($_M['config']['met_big_wate'] && ($table == 'product' || $table == 'news' || $table == 'img')) {
                $new_img = str_replace($_M['url']['site'], '', $new_img);
                $mark = load::sys_class('watermark', 'new');
                $mark->set_system_bigimg();
                $mark_res = $mark->create($new_img);

                if (!$mark_res['error']) {
                    if (!$mark_res['path']) {
                        $mark_res['path'] = $new_img;
                    }
                    $sys_compile->save_img_field($table, $field, $id, $mark_res['path']);
                }
            }
        }
        buffer::clearColumn();
        $this->success(intval($update), $_M['word']['jsok']);
    }

    /**
     * 获取模板公共参数
     * @return [type] [description]
     */
    public function doget_public_config()
    {
        global $_M;
        $redata = array();
        $data['config_list'] = $this->config->parse_config($this->config->get_public_config());
        $time_list = $this->get_time();
        $data['other_config_list'] = array(
            array(
                'type' => 'select',
                'name' => 'met_listtime',
                'value' => $_M['config']['met_listtime'],
                'data' => $time_list,
                'label' => $_M['word']['setskinListPage'] . $_M['word']['setskindatecontent']
            ),
            array(
                'type' => 'select',
                'name' => 'met_contenttime',
                'value' => $_M['config']['met_contenttime'],
                'data' => $time_list,
                'label' => $_M['word']['content'] . $_M['word']['setskindatecontent']
            ),
            array(
                'type' => 'radio',
                'name' => 'met_pnorder',
                'value' => $_M['config']['met_pnorder'] ? $_M['config']['met_pnorder'] : 0,
                'data' => array(
                    array(
                        'name' => $_M['word']['settopcolumns'],
                        'value' => 0
                    ),
                    array(
                        'name' => $_M['word']['setequivalentcolumns'],
                        'value' => 1,
                    )
                ),
                'label' => $_M['word']['page_range']
            )
        );
        $data['template_type'] = $this->type;

        $redata['status'] = 1;
        $redata['data'] = $data;
        $this->ajaxReturn($redata);
    }

    /**
     * 保存模板公共参数
     * @return [type] [description]
     */
    public function doset_public_config()
    {
        global $_M;
        $configs = array(
            'met_listtime' => $_M['form']['met_listtime'],
            'met_contenttime' => $_M['form']['met_contenttime'],
            'met_pnorder' => $_M['form']['met_pnorder']
        );
        $this->_set_page_config($configs);
        $update = $this->config->set_public_config($_M['form']);

        self::_clear_cahce();
        $this->ajaxReturn($update);
    }

    /**
     * 栏目样式配置页面配置
     * @return array
     */
    public function doGetClassInfo()
    {
        global $_M;
        $classnow = $_M['form']['classnow'];
        $redata = array();

        $class_label = load::mod_class('column/column_label', 'new');
        $c = $class_label->get_column_id($classnow);
        $redata['thumb_list'] = $c['thumb_list'];
        $redata['thumb_detail'] = $c['thumb_detail'];
        $redata['list_length'] = $c['list_length'] ? $c['list_length'] : '';
        $redata['tab_num'] = $c['tab_num'] ? $c['tab_num'] : 0;
        $redata['tab_name'] = $c['tab_name'];

        $data = load::mod_class('column_handle.class.php','new')->classExt($c);
        $redata['thumb_list_default'] = $data['thumb_list_default'];
        $redata['thumb_detail_default'] = $data['thumb_detail_default'];
        $redata['list_length_default'] = $data['list_length_default'];
        $redata['tab_num_default'] = $data['tab_num_default'];
        $redata['tab_name_default'] = $data['tab_name_default'];

        if(is_mobile()){
            $this->ajaxReturn(array('status' => 1, 'data'=>$redata));
        }
        return $redata;
    }

    /**
     * 保存页面配置
     */
    public function doset_page_config()
    {
        global $_M;
        //config中的数据统一用config_tem处理
        $form = $_M['form'];

        //修改全局配置
        $this->_set_page_config($form);

        //修改栏目配置
        $res = self::SaveClassInfo($form);

        if ($res == true) {
            $this->success('', $_M['word']['jsok']);
        } else {
            $this->error($_M['word']['dataerror']);
        }
    }

    /**
     * 保存全局配置
     * @param array $config
     * @return array
     */
    public function _set_page_config($config = array())
    {
        global $_M;
        foreach ($config as $key => $val) {
            $query = "UPDATE {$_M['table']['config']} SET value='{$val}' WHERE name='{$key}' AND lang='{$_M['lang']}'";
            DB::query($query);
        }

        buffer::clearConfig();
        return array('status' => 1);
    }

    /**
     * 保存栏目样式配置
     * @param string $classnow
     * @param string $thumb_x
     * @param string $thumb_y
     * @param string $list_length
     * @param int $list_type
     * @return bool
     */
    public function SaveClassInfo($data = array())
    {
        global $_M;
        $save_data = array();
        $classnow = $data['classnow'];
        if (is_numeric($classnow)) {
            $class_label = load::mod_class('column/column_label', 'new');
            $class = $class_label->get_column_id($classnow);
            $save_data['id'] = $classnow;

            if(isset($data['thumb_list_x'])){
                $save_data['thumb_list'] = "{$data['thumb_list_x']}|{$data['thumb_list_y']}";
                if (str_replace('|', '', $save_data['thumb_list']) == '') {
                    $save_data['thumb_list'] = '';
                }
            }
            if(isset($data['thumb_detail_x'])){
                $save_data['thumb_detail'] = "{$data['thumb_detail_x']}|{$data['thumb_detail_y']}";
                if (str_replace('|', '', $save_data['thumb_detail']) == '') {
                    $save_data['thumb_detail'] = '';
                }
            }
            if(isset($data['list_length'])){
                $save_data['list_length'] = $data['list_length'];
            }

            if ($class['module'] == 3) {
                if (!$data['tab_name_0'] && !$data['tab_name_1'] && !$data['tab_name_2'] && !$data['tab_name_3'] && !$data['tab_name_4']) {
                    $save_data['tab_name'] = '';
                } else {
                    $save_data['tab_name'] = "{$data['tab_name_0']}|{$data['tab_name_1']}|{$data['tab_name_2']}|{$data['tab_name_3']}|{$data['tab_name_4']}";
                    if (str_replace('|', '', $save_data['tab_name']) == '') {
                        $save_data['tab_name'] = '';
                    }
                }
                $save_data['tab_num'] = $data['tab_num'];
            }

            load::mod_class('column/class/column_database', 'new')->update_by_id($save_data);

            buffer::clearColumn();

            return true;
        }
        $this->error[] = 'no id';
        return false;
    }

    /**
     * 清除缓存
     * @return [type] [description]
     */
    public function doclear_cache()
    {
        global $_M;
        self::_clear_cahce();
        $this->ajaxReturn(array('status' => 1, 'msg' => $_M['word']['jsok']));
    }

    /**
     *
     */
    private function _clear_cahce()
    {
        global $_M;
        if (file_exists(PATH_WEB . 'cache')) {
            deldir(PATH_WEB . 'cache', 1);
        }

        if ($_M['config']['met_webhtm']) {
            //开启静态化后不清除模板缓存
            return;
        }

        $inc_file = PATH_WEB . "templates/{$this->no}/metinfo.inc.php";
        if (file_exists($inc_file)) {
            require $inc_file;
            if ($template_type) {
                deldir(PATH_WEB . 'templates/' . $_M['config']['met_skin_user'] . '/cache', 1);
            }
        }
        return;
    }

    /**
     * 清除缩略图
     */
    public function doClearThumb()
    {
        global $_M;
        if (file_exists(PATH_WEB . 'upload/thumb_src')) {
            deldir(PATH_WEB . 'upload/thumb_src');
        }
        $this->ajaxReturn(array('status' => 1, 'msg' => $_M['word']['jsok']));
    }

    /**
     * 可视化页面导航设置
     * @return [type] [description]
     */
    public function doapplist()
    {
        global $_M;
        $query = "select * from {$_M['table']['applist']}";
        $list = DB::get_all($query);
        $apphandle = load::mod_class('ui_set/class/config_app.class.php', 'new');
        $exception = array('0','50002');
        if (!$_M['config']['met_agents_sms']) {
            $exception[] = '10070';
        }
        foreach ($list as $value) {
            if ($value['display'] && !in_array($value['no'],$exception)) {
                $applist[] = $apphandle->standard($value);
            }
        }
        $data['applist'] = $applist;
        return $data;
    }

    /**
     * 可视化页面导航修改保存
     * @return [type] [description]
     */
    public function dosave_pageset_nav()
    {
        global $_M;
        $applist_show = explode(',', $_M['form']['applist']);
        $applist = $this->doapplist();
        foreach ($applist['applist'] as $key => $value) {
            $display = in_array($value[id], $applist_show) ? 2 : 1;
            $query = "update {$_M[table][applist]} set display='{$display}' where id='{$value[id]}'";
            DB::query($query);
        }
        $this->ajaxReturn(array('status' => 1, 'msg' => $_M['word']['jsok']));
    }

    /**
     * 取消系统安全提示
     */
    public function dono_uisetguide()
    {
        $configlist = array();
        $configlist[] = 'met_uiset_guide';
        configsave($configlist, array('met_uiset_guide' => 0));
        $this->success('');
        die('met_uiset_guide saved');
    }

    /**
     * 同意用户许可协议
     */
    public function doagreement()
    {
        global $_M;
        if ($_M['form']['license']) {
            $string = @file_get_contents('https://u.mituo.cn/api/metinfo/license');
            makedir(PATH_WEB . 'upload/file');
            file_put_contents(PATH_WEB . 'upload/file/license.html', $string);
        }
        $this->success('');
    }

    /**
     * 手机端获取系统插件开源许可协议
     */
    public function do_plugins_license()
    {
        global $_M;
        $data = $this->get_plugins_license();
        $this->success($data);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
