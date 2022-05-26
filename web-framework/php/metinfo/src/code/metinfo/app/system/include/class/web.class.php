<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('common.class.php');
load::sys_func('web');

/**
 * 前台基类.
 */
class web extends common
{
    /**
     * 初始化.
     */
    /**
     * 获取url传递的参数.
     *
     * @var [type]
     */
    protected $input;

    public function __construct()
    {
        parent::__construct();
        global $_M;
        // 可视化窗口语言栏跳转后，整个可视化页面跳转到新语言
        if (strstr($_SERVER['HTTP_REFERER'], $_M['url']['admin_site']) && strstr($_SERVER['HTTP_REFERER'], 'n=ui_set')) {
            preg_match('/lang=(\w+)/', $_COOKIE['page_iframe_url'], $prev_lang);
            if ($prev_lang && $prev_lang[1] != $_M['lang']) {
                echo "<script>
                    parent.document.getElementsByClassName('page-iframe')[0].setAttribute('data-dynamic','{$_M['url']['web_site']}index.php?lang={$_M['lang']}');
                    parent.window.location.href='//'+parent.window.location.host+parent.window.location.pathname+'?lang={$_M['lang']}&n=ui_set';
                </script>";
                die;
            }
        }
        // 非可视化状态下地址栏带pageset=1的页面跳转
        if (!strstr($_SERVER['HTTP_REFERER'], $_M['url']['web_site']) && strstr($_SERVER['QUERY_STRING'], 'pageset=1')) {
            $http = $this->checkHttps();
            $location = $http . $_SERVER['HTTP_HOST'] . str_replace(array('&pageset=1', '?pageset=1'), '', $_SERVER['REQUEST_URI']);
            header('location:' . $location);
            die;
        }

        $this->tem_dir(); //确定模板根目录
        $this->load_domain(); //加载绑定域名的语言
        $this->load_language(); //语言加载
        // $this->load_publuc_data();//加载公共数据
        $this->sys_input();

        load::sys_class('user', 'new')->get_login_user_info(); //会员登录

        load::plugin('doweb'); //加载插件
        load::mod_class('user/user_url', 'new')->insert_m(); //会员模块url

        // 页面基本信息，应用页面专用
        if ($_M['config']['met_title_type'] == 0) {
            $this->add_input('page_title', '');
        } elseif ($_M['config']['met_title_type'] == 1) {
            $this->add_input('page_title', '-' . $_M['config']['met_keywords']);
        } elseif ($_M['config']['met_title_type'] == 2) {
            $this->add_input('page_title', '-' . $_M['config']['met_webname']);
        } elseif ($_M['config']['met_title_type'] == 3) {
            $this->add_input('page_title', '-' . $_M['config']['met_keywords'] . '-' . $_M['config']['met_webname']);
        }
    }

    /**
     * 重写common类的load_form方法，前台对提交的GET，POST，COOKIE进行安全的过滤处理.
     */
    protected function load_form()
    {
        global $_M;
        parent::load_form();
        if ($_M['form']['id'] != '' && !is_numeric($_M['form']['id'])) {
            $_M['form']['id'] = '';
        }
        if ($_M['form']['class1'] != '' && !is_numeric($_M['form']['class1'])) {
            $_M['form']['class1'] = '';
        }
        if ($_M['form']['class2'] != '' && !is_numeric($_M['form']['class2'])) {
            $_M['form']['class2'] = '';
        }
        if ($_M['form']['class3'] != '' && !is_numeric($_M['form']['class3'])) {
            $_M['form']['class3'] = '';
        }

        $_M['form']['content'] = load::sys_class('label', 'new')->get('tags')->getTagName($_M['form']['content']);
        $_M['form']['searchword'] = load::sys_class('label', 'new')->get('tags')->getTagName($_M['form']['searchword']);
    }

    /**
     * 重写common类的load_url_unique方法，获取前台特有URL.
     */
    protected function load_url_unique()
    {
        global $_M;
        $_M['url']['own_name'] = "{$_M['url']['web_site']}app/index.php?lang={$_M['lang']}&n=" . M_NAME . '&';
        $_M['url']['own_form'] = $_M['url']['own_name'] . 'c=' . M_CLASS . '&';
        if ((M_NAME == 'pay' || M_NAME == 'shop') && !strstr($_M['url']['own_tem'], '/met/')) {
            $_M['url']['own_tem'] .= 'met/';
        }
    }

    protected function load_domain()
    {
        global $_M;

        $domain = trim(str_replace($_SERVER['REQUEST_SCHEME'] . '://', '', $_M['url']['site']), '/');

        if ($domain) {
            foreach ($_M['langlist']['web'] as $key => $val) {
                if ($val['link'] == $domain) {
                    $_M['lang'] = $val['mark'];
                }
            }
        }
    }

    /**
     * 获取当前语言参数.
     */
    protected function load_language()
    {
        global $_M;
        $this->load_word($_M['lang'], 0);
        $this->load_template_lang();
    }

    /**
     * 获取前台模板的语言参数配置，存放在$_M['word']中，系统语言参数数组。
     */
    protected function load_template_lang()
    {
        global $_M;
        $tmpincfile = PATH_WEB . "templates/{$_M['config']['met_skin_user']}/metinfo.inc.php";
        if (is_file($tmpincfile)) {
            require $tmpincfile;
        }
        $_M['config']['metinfover'] = $metinfover;
        $_M['config']['temp_frame_version'] = $temp_frame_version;
        if ($template_type == 'tag') {
            $sys_compile = load::sys_class('view/sys_compile', 'new');
            $templates = $sys_compile->list_templates_config();
            $_M['word'] = array_merge($_M['word'], $templates);
        }
    }

    /**
     * input变量处理.
     */
    protected function sys_input()
    {
        global $_M;
        /*if ($_M['form']['pseudo_jump'] && $_M['form']['list']) {
            if (!is_numeric($_M['form']['metid'])) {
                $column = load::sys_class('label', 'new')->get('column')->get_column_by_filename($_M['form']['metid']);
                if ($column) {
                    $_M['form']['class' . $column['classtype']] = $column['id'];
                }
            }
        }*/
        $this->input['class1'] = $_M['form']['class1'];
        $this->input['class2'] = $_M['form']['class2'];
        $this->input['class3'] = $_M['form']['class3'];
        $this->input['classnow'] = $_M['form']['classnow'];
        $this->input['page'] = $_M['form']['page'] ? $_M['form']['page'] : 1;
        $this->input['id'] = isset($_M['form']['id']) ? intval($_M['form']['id']) : 0;
        $this->input['lang'] = isset($_M['form']['lang']) ? $_M['form']['lang'] : $_M['config']['met_index_type'];
        $this->input['synchronous'] = $_M['langlist']['web'][$this->input['lang']]['synchronous'];
        $column = load::sys_class('label', 'new')->get('column')->get_column_id($this->input['classnow']);

        $this->input['module'] = $column['module'] ? $column['module'] : 10001;

        //unset($_M['form']);
    }

    /**
     * 确定模板根目录.
     */
    protected function tem_dir()
    {
        global $_M;
        define('PATH_TEM', PATH_WEB . 'templates/' . $_M['config']['met_skin_user'] . '/'); //模板根目录
    }

    /**********模板*********/
    /**
     * 加载模板方法
     * @param string $file
     * @param $data
     */
    public function view($file = '', $data = array())
    {
        global $_M;
        if ($_M['config']['met_skin_user']) {
            parent::view($file, $data);
        } else {
            $cache = "<div class='' style='margin: 200px auto; text-align: center;'>
                        <span style='background-color: #ff8571;padding: 20px 20px'>{$_M['word']['notemptips']}</span>
                    </div>";
            echo $cache;
            die();
        }
    }

    /**
     * 模板文件 (兼容老应用  新方法$this->view('temp_name',$this->>input)).
     *
     * @param string $file 模板主文件
     * @param int $mod 标签数组
     */
    protected function template($file)
    {
        global $_M;
        if (!$_M['config']['metinfover'] || $_M['config']['metinfover'] == 'v1') {
            if ($_M['custom_template']['file']) {
                return parent::template($file);
            } else {
                $_M['custom_template']['file'] = $file;

                return parent::template('ui/metv5');
            }
        } else {
            return $this->view(parent::template($file), $this->input);
        }
    }

    /**
     * 应用兼容模式加载前台模板，会自动加载当前选定模板的顶部，尾部，左侧导航(可选)，只有内容主题可以自定义。
     *
     * @param string $content 页面主体内容部分调用的文件名，为自定的应用模板文件
     * @param int $left 收加载模板的左侧栏，2：加载会员左侧导航 1:加载一般页面左侧导航，0:不加载
     */
    protected function custom_template($content, $left)
    {
        global $_M;
        $_M['custom_template']['content'] = $content;
        $_M['custom_template']['left'] = $left;

        return $this->template('ui/app');
    }

    /**
     * 视频插件替换.
     *
     * @param string $preg 替换的正则规则
     * @param string $content 被替换内容
     */
    public function video_replace($preg, $content)
    {
        preg_match_all($preg, $content, $out);
        foreach ($out[1] as $key => $val) {
            preg_match_all('/width=(\'|")([0-9]+)(\'|")/', $val, $w_out);
            $width = $w_out[2][0];

            preg_match_all('/height=(\'|")([0-9]+)(\'|")/', $val, $h_out);
            $height = $h_out[2][0];

            preg_match_all('/poster=(\'|")(.+?)(\'|")/', $val, $poster_out);
            $poster = $poster_out[2][0];

            preg_match_all('/autoplay=(\'|")(.+?)(\'|")/', $val, $autoplay_out);
            $autoplay = $autoplay_out[2][0];
            if ($autoplay) {
                $autoplay = 'autoplay';
            }

            preg_match_all('/src=(\'|")(.+?)(\'|")/', $val, $src_out);
            $src = $src_out[2][0];

            preg_match_all('/style=(\'|")(.+?)(\'|")/', $val, $style_out);
            $style = $style_out[2][0];

            $str = "<video class=\"edui-upload-video vjs-default-skin video-js\" controls=\"\" poster=\"{$poster}\" {$autoplay} width=\"{$width}\" height=\"{$height}\" src=\"{$src}\" data-setup=\"{}\" style=\"{$style}\">
                <source src=\"{$src}\" type=\"video/mp4\"/>
            </video>";

            $content = str_replace($out[0][$key], $str, $content);
        }

        return $content;
    }

    /**********前台用户数据处理*********/
    /**
     * 前台权限检测.
     *
     * @param int 会员组编号
     * 如果会员拥有权限则，程序代码向后正常执行，如果没有则提示没有权限
     */
    protected function check($groupid = 0)
    {
        global $_M;
        $power = load::sys_class('user', 'new')->check_power($groupid);
        if ($power < 0) {
            $gourl = $_M['gourl'] ? base64_encode($_M['gourl']) : base64_encode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            $gourl = $gourl == -1 ? '' : $gourl;
            if ($_M['lang'] != $_M['config']['met_index_type']) {
                $lang = "&lang={$_M['lang']}";
            }
            if ($power == -2) {
                okinfo($_M['url']['site'] . 'member/index.php?gourl=' . $gourl . $lang, $_M['word']['systips1']);
            }
            if ($power == -1) {
                okinfo($_M['url']['site'] . 'index.php?lang=' . $_M['lang'], $_M['word']['systips2']);
            }
        }
    }

    /**
     * 获取用户信息
     * @param string $met_auth
     * @param string $met_key
     * @return mixed
     */
    protected function get_login_user_info($met_auth = '', $met_key = '')
    {
        global $_M;
        return load::sys_class('user', 'new')->get_login_user_info($met_auth, $met_key);
    }

    /**
     * 检测会员登陆状态 没登陆则跳转到用户登陆页面
     */
    public function checkUserLogin()
    {
        global $_M;
        $user = $this->get_login_user_info();
        if (!$user) {
            okinfo($_M['url']['site'] . 'member/login.php?');
            return false;
        }
        return $user;
    }

    /**********页面数据处理*********/
    /**
     * 当前栏目信息
     * @param int $id
     * @return mixed
     */
    protected function input_class($id = 0)
    {
        global $_M;
        $column_lable = load::sys_class('label', 'new')->get('column');

        if (!$id) {
            $REQUEST_URIs = explode('/', REQUEST_URI);
            if (in_array('tag', $REQUEST_URIs)) {
                $folder = $REQUEST_URIs[count($REQUEST_URIs) - 3];
                if ($id === 0) {
                    // 兼容老tag伪静态
                    $folder = 'search';
                }
            } else {
                $folder = $REQUEST_URIs[count($REQUEST_URIs) - 2];
            }

            $c = $column_lable->get_column_folder($folder);
            if ($c) {
                $id = $c['id'];
            }else{
                $mod = load::sys_class('handle', 'new')->file_to_mod($folder);
                if (in_array($mod, array(2, 3, 4, 5))) {
                    $c = $column_lable->get_first_column_by_module($mod, $_M['lang']);
                    $id = $c['id'];
                }
            }
        }

        //获取三级栏目信息
        $c123_releclass = $column_lable->get_class123_reclass($id);
        $this->add_input('releclass1', $c123_releclass['class1']['id']);
        $this->add_input('releclass2', $c123_releclass['class2']['id']);
        $this->add_input('releclass3', $c123_releclass['class3']['id']);
        $c123 = $column_lable->get_class123_no_reclass($id);
        $this->add_input('classnow', 0);
        $this->add_input('class1', $c123['class1']['id']);
        $this->add_input('class2', $c123['class2']['id']);
        $this->add_input('class3', $c123['class3']['id']);
        if ($c123['class3']['id']) {
            $classnow = $c123['class3']['id'];
        } else {
            if ($c123['class2']['id']) {
                $classnow = $c123['class2']['id'];
            } else {
                $classnow = $c123['class1']['id'];
            }
        }
        $this->add_input('classnow', $classnow);
        $c = $column_lable->get_column_id($classnow);

        //额外栏目信息
        if (in_array($c['module'], array(2, 3, 4, 5, 6, 7, 11))) {
            self::classExt($c);
        }

        //栏目
        $this->add_input('module', $c['module']);

        //此处修改
        return $c['id'];
    }

    /**
     * 额外栏目信息.
     *
     * @param array $c
     */
    protected function classExt($c = array())
    {
        global $_M;
        $class_ext = load::mod_class('column_handle.class.php', 'new')->classExt($c);

        //分页条数
        $list_length = $class_ext['list_length'] ? $class_ext['list_length'] : 8;
        $this->add_input('list_length', $list_length);

        //列表页说略图尺寸
        $thumb_list = explode('|', $class_ext['thumb_list']);
        $this->add_input('thumb_list_x', $thumb_list[0]);
        $this->add_input('thumb_list_y', $thumb_list[1]);

        //详情页说略图尺寸
        $thumb_detail = explode('|', $class_ext['thumb_detail']);
        $this->add_input('thumb_detail_x', $thumb_detail[0]);
        $this->add_input('thumb_detail_y', $thumb_detail[1]);

        //内容选项卡&&显示个数
        $this->add_input('tab_num', $class_ext['tab_num']);
        $tab_name = explode('|', $class_ext['tab_name']);
        $this->add_input('tab_name_0', $tab_name[0]);
        $this->add_input('tab_name_1', $tab_name[1]);
        $this->add_input('tab_name_2', $tab_name[2]);
        $this->add_input('tab_name_3', $tab_name[3]);
        $this->add_input('tab_name_4', $tab_name[4]);
    }

    /**
     * 详情页data数据
     * @param $module
     */
    public function showpage($module)
    {
        global $_M;
        define('SHOW_PAGE', true); //标记为详情页数据
        if ($_M['form']['pseudo_jump']) {
            if (!is_numeric($_M['form']['metid'])) {//根据静态页名称获取内容详情
                $custom = load::sys_class('label', 'new')->get($module)->database->get_list_by_filename($_M['form']['metid']);
                $_M['form']['metid'] = $custom['0']['id'];
            }
            $_M['form']['id'] = $_M['form']['metid'];
        }

        $data = load::sys_class('label', 'new')->get($module)->get_one_list_contents($_M['form']['id']);
        $data['updatetime'] = date($_M['config']['met_contenttime'], strtotime($data['original_updatetime']));
        $data['addtime'] = date($_M['config']['met_contenttime'], strtotime($data['original_addtime']));
        $classnow = $data['class3'] ? $data['class3'] : ($data['class2'] ? $data['class2'] : $data['class1']);
        $this->input_class($classnow);
        $class_info = load::sys_class('label', 'new')->get('column')->get_column_id($classnow);
        if ($class_info) {
            $this->add_input('bigclass', $class_info['bigclass']);
            $this->add_input('index_num', $class_info['index_num']);
        }

        //产品模块数据处理
        if ($module == 'product') {
            $data['contents'][] = array('title' => $this->input['tab_name_0'], 'content' => $data['content']);
            if ($this->input['tab_num'] > 1) {
                for ($i = 1; $i < $this->input['tab_num']; $i++) {
                    $data['contents'][] = array('title' => $this->input['tab_name_' . $i], 'content' => $data['content' . $i]);
                }
            }
        }

        //添加评论插件内容
        if ($_M['config']['comment_global_setup']) {
            $comment_data = load::app_class('met_comment/include/class/CommentHtml', 'new')->getcommentclass();
            if ($module == 'product') {
                foreach ($data['contents'] as $key => $value) {
                    $data['contents'][$key]['content'] .= $comment_data;
                }
            } elseif (in_array($module, array('news', 'img', 'download'))) {
                $data['content'] .= $comment_data;
            }
        }
        //静态页权限验证
        if ($data['access'] && $_M['form']['html_filename']) {
            $groupid = load::sys_class('auth', 'new')->encode($data['access']);
            $data['access_code'] = $groupid;
        } else {
            if ($_M['config']['met_access_open']) {
                load::app_class('met_access/include/WebAccess', 'new')->check($data['id'], 2, $module);
            } else {
                $this->check($data['access']);
            }
        }

        $this->add_array_input($data);
        $this->seo($data['title'], $data['keywords'], $data['description']);
        $this->seo_title($data['ctitle']);
    }

    /**
     * 列表data数据
     * @param $module
     * @return string
     */
    public function listpage($module)
    {
        global $_M;
        define('LIST_PAGE', true); //标记为列表页数据
        if ($_M['form']['pseudo_jump']) {//详情页
            if ($_M['form']['list'] != 1) {
                return 'show';
            } elseif ($_M['form']['list']) {//列表页
                if (!is_numeric($_M['form']['metid'])) {//根据静态页名称获取栏目信息
                    $column = load::sys_class('label', 'new')->get('column')->get_column_by_filename($_M['form']['metid']);
                    if ($column) {
                        $_M['form']['class' . $column['classtype']] = $column['id'];
                    }
                }
            }
        }
        $classnow = $_M['form']['class3'] ? $_M['form']['class3'] : ($_M['form']['class2'] ? $_M['form']['class2'] : $_M['form']['class1']);
        $classnow = $classnow ? $classnow : $_M['form']['metid'];
        if (!is_numeric($classnow)) {//根据栏目名称获取内容列表
            $custom = load::sys_class('label', 'new')->get('column')->get_column_folder($_M['form']['metid']);
            $classnow = $custom['0']['id'];
        }
        $classnow = $this->input_class($classnow);
        $data = load::sys_class('label', 'new')->get('column')->get_column_id($classnow);

        //静态页权限验证
        if ($data['access'] && $_M['form']['html_filename']) {
            $groupid = load::sys_class('auth', 'new')->encode($data['access']);
            $data['access_code'] = $groupid;
        } else {
            if ($_M['config']['met_access_open']) {
                load::app_class('met_access/include/WebAccess', 'new')->check($data['id'], 1, $module);
            } else {
                $this->check($data['access']);
            }
        }

        unset($data['id']);
        unset($data['list_length']);
        $this->add_array_input($data);
        $this->seo($data['name'], $data['keywords'], $data['description']);
        if ($_M['form']['search'] != 'tag') {
            $this->seo_title($data['ctitle']);
        }
        if (isset($_M['form']['search'])) {
            $_M['config']['met_product_page'] = 0;
        }
        $this->add_input('page', $_M['form']['page']);
        $this->add_input('list', 1);
        return 'list';
    }

    /**********SEO方法*********/
    /**
     * 对页面的class1进行处理.
     */
    protected function seo($title = '', $keywords = '', $description = '')
    {
        global $_M;
        // 标签聚合页面TDK
        if (isset($_M['form']['search'])) {
            $search_title = $_M['form']['searchword'] ? $_M['form']['searchword'] : $_M['form']['content'];
            if ($_M['form']['search'] == 'tag' || @$_GET['search'] == 'tag') {
                $tag = load::sys_class('label', 'new')->get('tags')->getTagInfo($_M['form']['content'], $this->input);
                if (!$tag) {
                    $tag = load::sys_class('label', 'new')->get('tags')->getTagInfo($_M['form']['searchword'], $this->input);
                }
                if ($tag) {
                    $search_title = $tag['title'] ? $tag['title'] : $tag['tag_name'];
                    if ($tag['title']) {
                        $_M['config']['met_title_type'] = 0;
                    }
                    if ($tag['keywords']) {
                        $keywords = $_M['config']['met_keywords'] = $tag['keywords'];
                    }

                    if ($tag['description']) {
                        $description = $_M['config']['met_keywords'] = $tag['description'];
                    }
                }
            }
            if ($this->input['module'] != 11 && $search_title) {
                if ($search_title) {
                    $title = $search_title . '-' . $title;
                }
            }
            if ($tag['title']) {
                if ($search_title) {
                    $title = $search_title;
                }
            }
        }
        switch ($_M['config']['met_title_type']) {
            case '0':
                $this->add_input('page_title', $title);
                break;
            case '1':
                $this->add_input('page_title', $title . '-' . $_M['config']['met_keywords']);
                break;
            case '2':
                $this->add_input('page_title', $title . '-' . $_M['config']['met_webname']);
                break;
            case '3':
                $this->add_input('page_title', $title . '-' . $_M['config']['met_keywords'] . '-' . $_M['config']['met_webname']);
                break;
        }
        if ($keywords) {
            $this->add_input('page_keywords', $keywords);
        } else {
            $this->add_input('page_keywords', $_M['config']['met_keywords']);
        }

        if ($description) {
            $this->add_input('page_description', $description);
        } else {
            $this->add_input('page_description', $_M['config']['met_description']);
        }
    }

    protected function seo_title($title = '')
    {
        if ($title) {
            $this->add_input('page_title', $title);
        }
    }

    /**********工具方法*********/
    /**
     * 添加input.
     *
     * @param string $key $key
     * @param string $val $val
     */
    protected function add_input($key, $val)
    {
        global $_M;
        $this->input[$key] = $val;
    }

    /**
     * 添加input.
     *
     * @param string $key $key
     * @param string $val $val
     */
    protected function add_array_input($data)
    {
        global $_M;
        foreach ($data as $key => $val) {
            $this->add_input($key, $val);
        }
    }

    /********************************/
    /**
     * 销毁 处理静态页生成
     */
    public function __destruct()
    {
        global $_M;
        $output = ob_get_contents();//读取缓冲区数据
        ob_end_clean(); //清空缓冲区

        $output = str_replace(array('<!--<!---->', '<!---->', '<!--fck-->', '<!--fck', 'fck-->', '', "\r"), '', $output);
        /*$output = $this->video_replace('/(<video.*?edui-upload-video.*?>).*?<\/video>/', $output);*/
        $output = $this->video_replace('/(<embed.*?edui-faked-video.*?>)/', $output);

        $output = load::plugin('dofooter_replace', 1, array('data' => $output));

        load::plugin('doend', 0, array('data' => $output));

        //标签数据处理.
        $compile = load::sys_class('view/sys_compile', 'new');
        $output = $compile->replace_attr($output);

        //生成静态页
        if ($_M['form']['html_filename'] && $_M['form']['metinfonow'] == $_M['config']['met_member_force']) {
            $filename = urldecode($_M['form']['html_filename']);
            if (stristr(PHP_OS, 'WIN')) {
                $filename = @iconv('utf-8', 'GBK', $filename);
            }
            if (stristr($filename, '.php')) {
                jsoncallback(array('suc' => 0));
            }

            if ($filename == '404.html') {//404页面生成
                $output = str_replace('../', $_M['url']['web_site'], $output);
                $output = str_replace(array('href=""', "href=''"), "href='{$_M['url']['web_site']}'", $output);
            } else {
                if (!$_M['config']['met_webhtm']) {//普通静态页面生成
                    jsoncallback(array('suc' => 0));
                }
            }

            if (file_put_contents(PATH_WEB . $filename, $output)) {
                jsoncallback(array('suc' => 1));
            } else {
                jsoncallback(array('suc' => 0));
            }
        } else {//输出内容
            echo $output;
        }

        @DB::close(); //关闭数据库连接
        exit;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
