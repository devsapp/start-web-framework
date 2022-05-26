<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_label');

/**
 * 搜索模块标签类
 */

class search_label extends base_label
{

    public $lang;//语言
    public $search_page;//语言

    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
        $this->lang = $_M['lang'];
        $this->construct('search', $_M['config']['met_search_list']);
    }

    /**
     * 获取全局搜索标签数组
     * @return array         搜索标签数组
     */
    public function get_search_form()
    {
        global $_M;
        $search['url'] = $_M['url']['site'] . 'search/index.php?lang=' . $this->lang;
        $search['para']['class1'] = 'class1';
        $search['para']['class2'] = 'class2';
        $search['para']['class3'] = 'class3';
        $search['para']['module'] = 'module';
        $search['para']['searchword'] = 'searchword';
        $search['lang']['searchword'] = $_M['form']['searchword'];
        $search['lang']['SearchInfo1'] = $_M['word']['SearchInfo1'];
        $search['lang']['SearchInfo2'] = $_M['word']['SearchInfo2'];
        $search['lang']['SearchInfo3'] = $_M['word']['SearchInfo3'];
        $search['lang']['SearchInfo4'] = $_M['word']['SearchInfo4'];
        $search['lang']['Empty'] = $_M['word']['Empty'];
        return $search;
    }

    /**
     * 传统收索
     * @return string
     */
    public function get_search_form_html()
    {
        global $_M;
        $field = 'searchword';
        $searchword = '';
        if (isset($_M['form'][$field]) && $_M['form'][$field] != '') {
            $searchword = load::sys_class('label', 'new')->get('tags')->getTagName($_M['form'][$field]);
        }

        $search = $this->get_search_form();
        $str = <<<EOT
        <form method='get' class="page-search-form" role="search" action='{$search['url']}'>
            <input type='hidden' name='lang' value='{$this->lang}' />
            <div class="input-search input-search-dark">
                <button type="submit" class="input-search-btn"><i class="icon wb-search" aria-hidden="true"></i></button>
                <input
                type="text"
                class="form-control input-lg"
                name="{$search['para']['searchword']}"
                value="{$searchword}"
                placeholder="{$search['lang']['SearchInfo1']}"
                >
            </div>
        </form>
EOT;
        return $str;
    }

    /**
     * 获取详细搜索选项
     * @return array         搜索标签数组
     */
    public function get_search_opotion($type, $classnow, $page)
    {
        global $_M;
        if ($type == 'page') {//模块列表页面搜索
            $url = load::sys_class('label', 'new')->get('tag')->get_list_page_url($classnow, $page) . '&search=search';
            if ($_M['config']['met_pseudo']) {
                $url = preg_replace("/(tag)\/[\w-]+/", 'index.php?', $url);
            }
            //模糊搜索框
            $search['form']['action'] = $url . '&search=search&order=com';
            $search['form']['input_name'] = "content";
            $search['form']['input_name_all'] = "all";
            $search['form']['content'] = load::sys_class('label', 'new')->get('tags')->getTagName($_M['form']['content']);

            //排序
            $order_url = $url;
            if ($_M['form']['content']) {
                $order_url .= "&content={$_M['form']['content']}";
            }
            if ($_M['form']['para']) {
                $para = urlencode($_M['form']['para']);
                $order_url .= "&para=" . $para;
            }
            $search['order']['com']['name'] = $_M['word']['listcom'];
            $search['order']['com']['url'] = $order_url . '&order=com';
            $search['order']['hit']['name'] = $_M['word']['listhot'];
            $search['order']['hit']['url'] = $order_url . '&order=hit';
            $search['order']['new']['name'] = $_M['word']['listnew'];
            $search['order']['new']['url'] = $order_url . '&order=new';
            $order_para['order'] = $search['order'];
            $search['order'] = load::plugin('search_order', 1, $order_para);//加载插件
            //字段搜索选项
            #dump($_M['form']);
            #dump($_M['form']['para']);
            $para_url = $url;
            if ($_M['form']['order']) {
                $para_url = $url . "&order={$_M['form']['order']}";
            }
            $class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($classnow);
            $paras = load::sys_class('label', 'new')->get('parameter')->get_para($class123['class1']['module'], $class123['class1']['id'], $class123['class2']['id']);

            //$paraurl = json_decode(load::sys_class('auth', 'new')->decode($_M['form']['para']), true);
            $paraurl = json_decode(base64_decode($_M['form']['para']), true);

            if (!$_M['config']['shopv2_para']) {
                $parameter_database = load::mod_class('parameter_database', 'new');
                foreach ($paras as $key => $val) {
                    if(!in_array($val['type'] ,array(2,4,6))) {
                        continue;
                    }

                    $id = $val['id'];
                    $urlnow = $paraurl;
                    $urlnow[$id] = '';
                    $search['para'][$key]['name'] = $val['name'];
                    $search['para'][$key]['id'] = $id;
                    $p['name'] = $_M['word']['weball'];
                    $p['url'] = $para_url . "&para=" . urlencode(base64_encode(json_encode($urlnow)));
                    $p['id'] = 0;
                    $search['para'][$key]['list'][] = $p;

                    $parameters = $parameter_database->get_para_values($class123['class1']['module'], $val['id']);
                    foreach ($parameters as $v) {
                        $urlnow = $paraurl;
                        $urlnow[$id] = $v['id'];
                        $p['name'] = $v['value'];
                        $p['id'] = $v['id'];
                        $p['url'] = $para_url . "&para=" . urlencode(base64_encode(json_encode($urlnow)));
                        $search['para'][$key]['list'][] = $p;
                    }
                }

                //选中
                foreach ($search['para'] as $pkey => $pval) {
                    if ($paraurl[$pval['id']]) {
                        foreach ($pval['list'] as $skey => $sval) {
                            if ($sval['id'] == $paraurl[$pval['id']]) {
                                $search['para'][$pkey]['list'][$skey]['check'] = 'para_select_option';
                            }
                        }
                    } else {
                        $search['para'][$pkey]['list'][0]['check'] = 'para_select_option';
                    }
                }
            } else {
                $search['para'] = load::app_class('shop/include/class/shop_search', 'new')->getSpeclist($type, $classnow, $page);
            }


            //语言
            $search['lang']['searchword'] = $_M['form']['searchword'];
            $search['lang']['SearchInfo1'] = $_M['word']['SearchInfo1'];
            $search['lang']['SearchInfo2'] = $_M['word']['SearchInfo2'];
            $search['lang']['SearchInfo3'] = $_M['word']['SearchInfo3'];
            $search['lang']['SearchInfo4'] = $_M['word']['SearchInfo4'];
            $search['lang']['Empty'] = $_M['word']['Empty'];


            foreach ($search['para'] as $val) {
                $para_array[] = $val;
            }
            $search['para'] = $para_array;
        }
        return $search;
    }

    /**
     * 获取详细搜索选项 HTML
     * @param $type
     * @param $classnow
     * @param $page
     * @return string
     */
    public function get_search_opotion_html($type, $classnow, $page)
    {
        $info = $this->get_search_opotion($type, $classnow, $page);
        $str = '';
        $str .= <<<EOT

EOT;
        return $str;
    }

    /**
     * 全局收索
     * @param $data
     * @return string
     */
    public function get_search_global($data)
    {
        global $_M;
        $search_range = $_M['config']['global_search_range'];//全局搜索
        $search_type = $_M['config']['global_search_type'];//全局搜索
        $search_placeholder = $_M['word']['SearchInfo1'];
        $module = $_M['config']['global_search_module'];
        $cid = $_M['config']['global_search_column'];
        $field = 'searchword';
        $searchword = '';
        $add = '';

        if ($search_range == 'all') {
            $url = $_M['url']['site'] . 'search/index.php?lang=' . $this->lang;
        }

        if ($search_range == 'module') {
            $module_name = load::sys_class('handle', 'new')->mod_to_file($module);
            $url = $_M['url']['site'] . "{$module_name}/index.php?lang=" . $this->lang;
            $field = 'content';//到模块列表页搜索时的字段
            $add .= "<input type=\"hidden\" name=\"search\" value=\"search\" />";
            $add .= "<input type=\"hidden\" name=\"search_module\" value=\"{$module}\" />";
        }

        if ($search_range == 'column') {
            $column = load::sys_class('label', 'new')->get('column')->get_column_id($cid);
            $url = $_M['url']['site'] . "{$column['foldername']}/index.php?lang=" . $this->lang;
            $field = 'content'; //到栏目列表页搜索时的字段
            $add .= "<input type=\"hidden\" name=\"search\" value=\"search\" />";
            $add .= "<input type=\"hidden\" name=\"class1\" value=\"{$cid}\" />";
        }

        if (isset($_M['form'][$field]) && $_M['form'][$field] != '') {
            $searchword = load::sys_class('label', 'new')->get('tags')->getTagName($_M['form'][$field]);
        }

        $form = <<<EOT
        <form method="get" class="page-search-form" role="search" action="{$url}" m-id="search_global" m-type="nocontent">
            <input type="hidden" name="lang" value="{$this->lang}" />
            <input type="hidden" name="stype" value="{$search_type}" />
            {$add}
            <div class="input-search input-search-dark">
                <button type="submit" class="input-search-btn"><i class="icon wb-search" aria-hidden="true"></i></button>
                <input
                type="text"
                class="form-control input-lg"
                name="{$field}"
                value="{$searchword}"
                placeholder="{$search_placeholder}"
                >
            </div>
        </form>
EOT;
        return $form;
    }

    /**
     * 栏目收索
     * @param $data
     * @return string
     */
    public function get_search_column($data)
    {
        global $_M;
        $search_range = $_M['config']['column_search_range']; //当前栏目
        $search_type = $_M['config']['column_search_type'];//搜索类型限制：0为所有内容，1为标题，2为内容，3为内容加标题

        $add = '';//增加到search表单中的隐藏字段
        $field = 'content';//搜索字段名，全局搜索是searchword,栏目里搜索是content
        $searchword = '';
        if (isset($_M['form'][$field]) && $_M['form'][$field] != '') {
            $searchword = load::sys_class('label', 'new')->get('tags')->getTagName($_M['form'][$field]);
        }

        $search_placeholder = $_M['word']['columnSearchInfo'];//搜索框默认提示的内容
        $class_value = $data['classnow'];//搜索栏目的值
        $module = $data['module'];
        $module_name = load::sys_class('handle', 'new')->mod_to_file($module);
        $url = $_M['url']['site'] . "{$module_name}/index.php?lang=" . $this->lang;
        $add .= "<input type=\"hidden\" name=\"search\" value=\"search\" />";

        if ($search_range == 'current') {
            $class = "class" . $data['classtype'];
        } else {
            $class = 'class1';
            $class_value = $data['class1'];
        }

        $add .= "<input type=\"hidden\" name=\"{$class}\" value=\"{$class_value}\" />";

        $form = <<<EOT
        <form method="get" class="page-search-form" role="search" action="{$url}" m-id="search_column" m-type="nocontent">
            <input type="hidden" name="lang" value="{$this->lang}" />
            <input type="hidden" name="stype" value="{$search_type}" />
            {$add}
            <div class="input-search input-search-dark">
                <button type="submit" class="input-search-btn"><i class="icon wb-search" aria-hidden="true"></i></button>
                <input
                type="text"
                class="form-control input-lg"
                name="{$field}"
                value="{$searchword}"
                placeholder="{$search_placeholder}"
                >
            </div>
        </form>
EOT;
        return $form;
    }

    /**
     * 高级收索
     * @param $data
     * @return string
     */
    public function get_search_advanced($data)
    {
        global $_M;
        $add = '';//增加到search表单中的隐藏字段
        $field = 'searchword';
        $searchword = '';
        if (isset($_M['form'][$field]) && $_M['form'][$field] != '') {
            $searchword = load::sys_class('label', 'new')->get('tags')->getTagName($_M['form'][$field]);
        }

        $search_placeholder = $_M['word']['advancedSearchInfo'];//搜索框默认提示的内容
        $module = $data['module'];
        if ($module == 10001) {
            $module_name = 'search';
        } else {
            $module_name = load::sys_class('handle', 'new')->mod_to_file($module);
        }
        $url = $_M['url']['site'] . "{$module_name}/index.php?lang=" . $this->lang;
        $add .= "<input type=\"hidden\" name=\"search\" value=\"search\" />";

        $add .= "<div data-plugin='select-linkage' data-select-url=\"{$_M['url']['site']}include/open.php?a=doctun&lang={$this->lang}&module={$module}\">
            <select name=\"class1\" class=\"form-control m-r-5 prov\"></select>
            <select name=\"class2\" class=\"form-control m-r-5 city\"></select>
            <select name=\"class3\" class=\"form-control m-r-5 dist\"></select>
        </div>";

        if ($_M['config']['advanced_search_type']) {
            $add .= "<div class=\"advanced_search_type\">
            <select name=\"stype\" class=\"form-control m-r-5 \" data-checked=\"0\">
            <option value=\"0\">{$_M['word']['weball']}</option>
            <option value=\"1\">{$_M['word']['Title']}</option>
            <option value=\"2\">{$_M['word']['Content']}</option>
            <option value=\"3\">{$_M['word']['Content']}+{$_M['word']['Title']}</option>
            </select>
        </div>";
        }

        $form = <<<EOT
        <form method="get" class="page-search-form" role="search" action="{$url}" m-id="search_advanced" m-type="nocontent">
            <input type="hidden" name="lang" value="{$this->lang}" />
            {$add}
            <div class="input-search input-search-dark">
                <button type="submit" class="input-search-btn"><i class="icon wb-search" aria-hidden="true"></i></button>
                <input
                type="text"
                class="form-control input-lg"
                name="{$field}"
                value="{$searchword}"
                placeholder="{$search_placeholder}"
                >
            </div>
        </form>
EOT;
        return $form;
    }

    /**
     * 集合标签收索
     * @return array
     */
    public function tag_search()
    {
        global $_M;
        // 如果是标签搜索,按全站内容搜索
        $_M['form']['stype'] = 0;
        if ($_M['form']['content']) {
            $word = $_M['form']['content'];
        }elseif ($_M['form']['searchword']) {
            $word = $_M['form']['searchword'];
        }
        $word = load::sys_class('label', 'new')->get('tags')->getTagName($word);
        if ($_M['config']['tag_show_range']) {
            // 如果限制了只显示带TAG的信息
            return array('type' => 'tag', 'tag' => array(
                'status' => 1, //搜索tag
                'info' => $word,
            ));
        }

        $type = $this->get_search_type($_M['form']['stype'], $word);
        $type['type'] = 'tag';
        return $type;
    }

    /**
     * 获取搜索form html
     * @return array         搜索标签数组
     */
    public function get_search_list($str)
    {
        global $_M;
        $str = load::sys_class('label', 'new')->get('tags')->getTagName($str);
        $page = $_M['form']['page'] > 0 ? $_M['form']['page'] : 1;
        $page = $page - 1;
        $start = $this->page_num * $page;
        $end = $start + $this->page_num;
        $id = $_M['form']['class3'] ? $_M['form']['class3'] : ($_M['form']['class2'] ? $_M['form']['class2'] : $_M['form']['class1']);
        if ($_M['form']['search'] == 'tag') {
            $type = $this->tag_search();
        }else{
            $type = $this->get_search_type($_M['form']['stype'], $str);
        }
        $order = array(
            'type' => 'array',
            'status' => '1',
        );
        if ($str) {
            $module = intval($_M['form']['module']);
            $table = load::sys_class('handle', 'new')->mod_to_name($module);
            if ($table) {
                if ($module != 1) {
                    $content = load::sys_class('label', 'new')->get($table)->get_module_list($id, '', $type, $order);
                    $all = $content;
                } else {
                    $about = load::sys_class('label', 'new')->get('about')->column_list($type);
                    foreach ($about as $key => $val) {
                        $about[$key]['title'] = $val['name'];
                    }
                    $all = $about;
                }
            } else {
                $arr = array();
                $about = load::sys_class('label', 'new')->get('about')->column_list($type);
                foreach ($about as $key => $val) {
                    $about[$key]['title'] = $val['name'];
                }
                $arr[1] = $about;
                $arr[2] = $news = load::sys_class('label', 'new')->get('news')->get_module_list($id, '', $type, $order);
                $arr[3] = $product = load::sys_class('label', 'new')->get('product')->get_module_list($id, '', $type, $order);
                $arr[4] = $download = load::sys_class('label', 'new')->get('download')->get_module_list($id, '', $type, $order);
                $arr[5] = $img = load::sys_class('label', 'new')->get('img')->get_module_list($id, '', $type, $order);
                $arr[6] = $job = load::sys_class('label', 'new')->get('job')->get_module_list($id, '', $type, $order);

                if ($_M['config']['global_search_weight']) {//全局搜索模块排序
                    $global_search_weight = explode('|', $_M['config']['global_search_weight']);
                    $all = array();
                    foreach ($global_search_weight as $mod) {
                        if (is_array($arr[$mod]) && isset($arr[$mod]) && $arr[$mod]) {
                            $all = array_merge((array)$all ,(array)$arr[$mod]);
                        }
                    }
                }else{
                    $all = array_merge((array)$about, (array)$news, (array)$product, (array)$img, (array)$download, (array)$job );
                }
            }

            $this->search_page = count($all);
            foreach ($all as $key => $val) {
                if ($key >= $start && $key < $end) {
                    $search[] = $val;
                }
            }
        }

        foreach ($search as $key => $val) {
            $list = array();
            $list['title'] = $this->handle->get_keyword_str($val['title'], $str, 50, 0, 1);
            $list['ctitle'] = $val['title'];
            $list['content'] = $this->handle->get_keyword_str(html_entity_decode(strip_tags($val['content']), ENT_QUOTES, 'UTF-8'), $str, 75, 0);
            $list['url'] = str_replace('../', $_M['url']['web_site'], $val['url']);
            $list['updatetime'] = $val['updatetime'];
            $list['imgurl'] = $val['imgurl'];
            $return[] = $list;
        }

        $count = is_array($return) ? count($return) : 0;
        if ($count == 0 && $str) {
            $list = array();
            $list['title'] = "{$_M['word']['SearchInfo3']}[<em style='font-style:normal;'>$str</em>]{$_M['word']['SearchInfo4']}";
            $list['content'] = '';
            $list['url'] = '';
            $list['updatetime'] = date('Y-m-d H:i:s');
            $return[] = $list;
        }
        return $return;
    }

    /**
     * 获取收索检索字段信息
     * @param int $stype
     * @param $word
     * @return array
     */
    public function get_search_type($stype = 0, $word)
    {
        global $_M;
        $type = array('type' => 'array');
        switch ($stype) {
            case 0:
                $fields = array('ctitle', 'title', 'keywords', 'description', 'para', 'content', 'tag', 'specv');
                foreach ($fields as $val) {
                    $type[$val]['status'] = 1;
                    $type[$val]['info'] = $word;
                }
                break;
            case 1:
                $type['title']['status'] = 1;
                $type['title']['info'] = $word;
                break;
            case 2:
                $type['content']['status'] = 1;
                $type['content']['info'] = $word;
                break;
            case 3:
                $type['title']['status'] = 1;
                $type['title']['info'] = $word;
                $type['content']['status'] = 1;
                $type['content']['info'] = $word;
        }
        return $type;
    }

    /**
     * 收索列表分页信息
     * @return mixed
     */
    public function get_page_info_by_class($id = '', $type = '')
    {
        global $_M;
        // 搜索列表分页
        $stype = isset($_M['form']['stype']) ? "&stype={$_M['form']['stype']}" : '';
        if ($_M['form']['search'] == 'tag') {
            if ($_M['config']['met_pseudo']) {
                $url = "search/tag/{$_M['form']['searchword']}";
                if ($_M['lang'] != $_M['config']['met_index_type']) {
                    $url .= "-" . $_M['lang'];
                }
                $url .= '-#page#';
            } else {
                $url = "search/index.php?search=tag&searchword={$_M['form']['searchword']}{$stype}&module={$_M['form']['module']}&lang={$_M['lang']}&page=#page#";
            }
        } else {
            $url = "search/index.php?search={$_M['form']['search']}&searchword={$_M['form']['searchword']}{$stype}&module={$_M['form']['module']}&lang={$_M['lang']}&page=#page#";
        }
        $info['url'] = $this->handle->url_transform($url);
        $info['count'] = ceil($this->search_page / $this->page_num);
        return $info;
    }

    /**
     * 搜索列表排序
     * @return mixed
     */
    public function get_order()
    {
        global $_M;
        $order['type'] = 'array';
        switch ($_M['form']['order']) {
            case 'com':
                $order['status'] = '6';
                break;
            case 'new':
                $order['status'] = '1';
                break;
            case 'hit':
                $order['status'] = '3';
                break;
            case 'sales':
                $order['status'] = '8'; //商品销量
                break;
            default:
                $order['status'] = '';
                break;
        }
        return $order;
    }

    public function search_info()
    {
        global $_M;

        if ($_M['form']['search']) {
            if ($_M['form']['title'] || $_M['form']['content'] || $_M['form']['searchword']) {
                if ($_M['form']['content']) {
                    $word = $_M['form']['content'];
                } else {
                    $word = $_M['form']['searchword'];
                }
                $type = $this->get_search_type(0, $word);
                return $type;
            } elseif ($_M['form']['para']) {
                //$paratmp = json_decode(load::sys_class('auth', 'new')->decode($_M['form']['para']), true);
                $paratmp = json_decode(base64_decode($_M['form']['para']), true);
                foreach ($paratmp as $key => $val) {
                    $para[] = array(
                        'id' => $key,
                        'info' => $val,
                    );
                }
                $type = array(
                    'type' => 'array',
                    'title' => array(
                        'status' => 0,//title搜索
                    ),
                    'content' => array(
                        'status' => 0,//内容搜索
                    ),
                    'tag' => array(
                        'status' => 0,//tag搜索
                    ),
                    'specv' => array(
                        'status' => 0,//规格搜索
                    ),
                    'para' => array(
                        'status' => 1,//系统属性搜索
                        'precision' => 0,
                        'info' => $para,
                    ),
                );
                return $type;
            } elseif ($_M['form']['specv'] || $_M['form']['price_low'] || $_M['form']['price_top']) {
                $shop_search = load::app_class('shop/include/class/shop_search', 'new');
                if (method_exists($shop_search,'getSearchType')) {
                    $specv = $shop_search->getSearchType($_M['form']['specv']);    //new
                }else{
                    $specv = json_decode(load::sys_class('auth', 'new')->decode($_M['form']['specv']), true); //old
                }

                 $type = array(
                    'type' => 'array',
                    'title' => array(
                        'status' => 0,//开启搜索
                    ),
                    'content' => array(
                        'status' => 0,//开启搜索
                    ),
                    'tag' => array(
                        'status' => 0,//开启搜索
                    ),
                    'para' => array(
                        'status' => 0,//开启搜索
                    ),
                    'specv' => array(
                        'status' => 1,//开启搜索
                        'precision' => 0,
                        'info' => $specv
                    )
                );
                return $type;
            }
        }
    }

    //添加搜索选项，当前只能向动态页面添加
    public function add_search_url()
    {
        global $_M;

        if ($_M['form']['search'] && $_M['form']['search'] == 'tag' && !$_M['form']['stype']) {
            // 如果不是按搜索走的TAG，不添加参数
            return;
        }
        $str = '';

        if ($_M['form']['search']) {
            $str .= "&search=search";
            if ($_M['form']['search_module']) {
                $str .= "&search_module={$_M['form']['search_module']}";
            }
            if ($_M['form']['order']) {
                $str .= "&order={$_M['form']['order']}";
            }
            if ($_M['form']['title']) {
                $str .= "&title={$_M['form']['title']}";
            }
            if ($_M['form']['content']) {
                $str .= "&content={$_M['form']['content']}";
            }
            if ($_M['form']['para']) {
                $para = rawurlencode($_M['form']['para']);
                $str .= "&para={$para}";
            }
            if ($_M['form']['specv']) {
                $specv = rawurlencode($_M['form']['specv']);
                $str .= "&specv={$specv}";
            }
            //价格区间
            if ($_M['form']['price_low']) {
                $price_low = rawurlencode($_M['form']['price_low']);
                $str .= "&price_low={$price_low}";
            }
            if ($_M['form']['price_top']) {
                $price_top = rawurlencode($_M['form']['price_top']);
                $str .= "&price_top={$price_top}";
            }
        }
        return $str;
    }

    public function get_module_list($id = '', $rows = '', $type = '', $order = '', $para = 0)
    {
        return;
    }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
