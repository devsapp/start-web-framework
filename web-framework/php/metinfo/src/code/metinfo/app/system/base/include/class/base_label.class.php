<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 系统标签类
 */

class base_label
{

    public $lang;//语言
    public $page_num;//分页数
    public $database;//数据库
    public $handle;//处理

    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
        //$this->lang = $_M['lang'];
    }

    /**
     * 初始化，继承类需要调用
     * @param  string $mod 模块名称
     */
    public function construct($mod, $num)
    {
        global $_M;
        $this->mod = $mod;
        $this->database = load::mod_class($mod . '/' . $mod . '_database', 'new');
        $this->handle = load::mod_class($mod . '/' . $mod . '_handle', 'new');
        $this->page_num = $num;
    }

    /**
     * 按栏目获取列表数据
     * @param string $id 栏目id
     * @param string $rows 取的条数
     * @param string $type 调用内容com(推荐)／news(最新，已废除)//all（所有）
     * @param string $order 排序规则
     * @param int $para 是否获取参数信息
     * @return mixed
     */
    public function get_module_list($id = '', $rows = '', $type = '', $order = '', $para = 0)
    {
        global $_M;
        if (!$type) {
            $type = 'all';
        }
        $data = $this->database->get_list_by_class($id, 0, $rows, $type, $order);
        $data = $this->handle->para_handle($data);

        if ($para) {
            foreach ($data as $key => $val) {
                $data[$key]['para'] = load::mod_class('parameter/parameter_label', 'new')->get_parameter_contents($this->mod, $val['id'], $val['class1'], $val['class2'], $val['class3']);
                $data[$key]['para_url'] = load::mod_class('parameter/parameter_label', 'new')->get_parameter_contents($this->mod, $val['id'], $val['class1'], $val['class2'], $val['class3'], 10);
            }
        }
        return $data;
    }

    /**
     * 获取栏目列表页数据
     * @param string $id 栏目id
     * @param string $page 分页数
     * @param int $para 是否获取参数信息
     * @return mixed
     */
    public function get_list_page($id = '', $page = '', $para = 1)
    {
        global $_M;
        $page = is_numeric($page) ? $page : 1;
        $page = $page > 0 ? $page : 1;
        $page = $page - 1;
        $start = $this->page_num * $page;
        $rows = $this->page_num;
        //搜索信息
        $search = $this->search();
        if ($search['type']) {
            $type = $search['type'];
        }
        if ($search['order']) {
            $order = $search['order'];
        }
        $_M['config']['list_page_flag'] = 1;
        if (!$type) {
            $type = 'all';
        }

        //内容权限检测
        $data = $this->handle->para_handle(
            $this->database->get_list_by_class($id, $start, $rows, $type, $order)
        );

        //内容参数
        if ($para == 1 && in_array($this->mod, array('product', 'download', 'img', 'job'))) {
            foreach ($data as $key => $val) {
                $data[$key]['para'] = load::mod_class('parameter/parameter_label', 'new')->get_parameter_contents($this->mod, $val['id'], $val['class1'], $val['class2'], $val['class3']);
                $data[$key]['para_url'] = load::mod_class('parameter/parameter_label', 'new')->get_parameter_contents($this->mod, $val['id'], $val['class1'], $val['class2'], $val['class3'], 10);

                //兼容老模板问题
                foreach ($data[$key]['para'] as $key1 => $val2) {
                    $data[$key]['para' . $val2['id']] = $val2['value'];
                    $data[$key]['para' . $val2['id'] . 'name'] = $val2['name'];
                }
            }
        }

        return $data;
    }

    /**
     * 根据内容ID获取数据
     * @param $id        内容id
     * @param int $para 是否获取参数信息
     * @param int $nj 上一条下一条
     * @return mixed    返回内容数组
     */
    public function get_one_list_contents($id, $para = 1, $nj = 1)
    {
        global $_M;
        $one = $this->database->get_list_one_by_id($id);
        if (!$one || $one['recycle'] == 1) {
            abort();
            die();
        }

        $one = $this->handle->one_para_handle($one);

        //上一条 下一条
        if ($nj == 1) {
            $slim = true;
            $preinfo = $this->handle->one_para_handle(
                $this->database->get_pre($one), $slim
            );
            if ($preinfo) {
                $one['preinfo']['title'] = $preinfo['title'];
                $one['preinfo']['lang'] = $_M['word']['Previous_news'];
                $one['preinfo']['url'] = $preinfo['url'];
                $one['preinfo']['disable'] = '';
            } else {
                $one['preinfo']['disable'] = 'disable';
            }

            $nextinfo = $this->handle->one_para_handle(
                $this->database->get_next($one), $slim
            );
            if ($nextinfo) {
                $one['nextinfo']['title'] = $nextinfo['title'];
                $one['nextinfo']['lang'] = $_M['word']['Next_news'];
                $one['nextinfo']['url'] = $nextinfo['url'];
                $one['nextinfo']['disable'] = '';
            } else {
                $one['nextinfo']['disable'] = 'disable';
            }
        }

        //获取内容参数
        if ($para == 1) {
            $parameter_label = load::mod_class('parameter/parameter_label', 'new');
            $one['para'] = $parameter_label->get_parameter_contents($this->mod, $id, $one['class1'], $one['class2'], $one['class3']);
            $one['para_url'] = $parameter_label->get_parameter_contents($this->mod, $id, $one['class1'], $one['class2'], $one['class3'], 10);
        }

        $class = $one['class3'] ? $one['class3'] : ($one['class2'] ? $one['class2'] : $one['class1']);
        $class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($class);
        $add = '';
        $add = $class123['class1']['content'] ? $class123['class1']['content'] : $add;
        $add = $class123['class2']['content'] ? $class123['class2']['content'] : $add;
        $add = $class123['class3']['content'] ? $class123['class3']['content'] : $add;
        $add = $add ? '<div id="metinfo_additional">' . $add . '</div>' : '';

        //内容标签信息处理
        if ($one['tag']) {
            $tagObj = load::sys_class('label', 'new')->get('tags');

            if (!$_M['word']['tagweb']) {
                $_M['word']['tagweb'] = 'TAG';
            }
            $tagslist = $tagObj->getTagsByNews($one['tag'], $id);

            $one['taglist'] = $tagslist;

            $tagstr = "<div id=\"metinfo_tag\">{$_M['word']['tagweb']}:&nbsp";
            foreach ($tagslist as $key => $val) {
                $tagstr .= "&nbsp<a href=\"{$val['url']}\" target=\"_blank\">{$val['name']}</a>";
            }

            $tag_relations = $tagObj->getRelationList($one, $one['tag']);
            foreach ($tag_relations as $val) {
                if ($val['id'] != $one['id']) {
                    $one['tag_relations'][] = $val;
                }
                $tagstr .= "&nbsp<a href=\"{$val['url']}\" target=\"_blank\">{$val['name']}</a>";
            }

            $tagstr = $tagstr . '</div>';
            $one['tagstr'] = $tagstr;
            $one['tagname'] = $_M['word']['tagweb'] . ':';

        }

        $one = $this->get_add_contents($one, $add);
        return $one;
    }

    /**
     * @param string $id 栏目id
     * @param string $type url类型（动态，静态，伪静态）
     * @return mixed
     */
    public function get_page_url($id = '', $type = '')
    {
        return $this->handle->get_page_url($id, $type);
    }

    /**
     * 添加附加内容 （锚文本替换）
     * @param array $one 内容详情
     * @param string $add 附件内容
     * @return array
     */
    public function get_add_contents($one = array(), $add = '')
    {
        global $_M;
        $one['content'] = load::sys_class('label', 'new')->get('seo')->anchor_replace($one['content'] . $add);
        $one['content1'] = load::sys_class('label', 'new')->get('seo')->anchor_replace($one['content1'] . $add);
        $one['content2'] = load::sys_class('label', 'new')->get('seo')->anchor_replace($one['content2'] . $add);
        $one['content3'] = load::sys_class('label', 'new')->get('seo')->anchor_replace($one['content3'] . $add);
        $one['content4'] = load::sys_class('label', 'new')->get('seo')->anchor_replace($one['content4'] . $add);
        foreach ($one['contents'] as $key => $val) {
            $one['contents'][$key]['content'] = load::sys_class('label', 'new')->get('seo')->anchor_replace($val['content'] . $add);
        }
        return $one;
    }

    /**
     * 获取收索类型
     * @return array   news数组
     */
    public function search()
    {
        global $_M;
        $search_order = load::sys_class('label', 'new')->get('search')->get_order();

        if ($_M['form']['search'] && $_M['form']['search'] == 'tag') {
            $search_type = load::sys_class('label', 'new')->get('search')->tag_search();
        } else {
            $search_type = load::sys_class('label', 'new')->get('search')->search_info();
        }
        return array(
            'type' => $search_type,
            'order' => $search_order,
        );
    }

    /**
     * @param string $id
     * @param string $type
     * @return mixed
     */
    public function get_page_info_by_class($id = '', $type = '')
    {
        global $_M;
        //分页url
        if (method_exists($this->handle, 'get_page_url')) {
            $info['url'] = $this->handle->get_page_url($id, $type);
        }
        //搜索信息
        $search = $this->search();
        if ($search['type']) {
            $type = $search['type'];
        }

        #$info['count'] = ceil($this->database->get_page_count_by_class($id, $type) / $this->page_num);
        $lenght = $this->get_list_page_lenght($id);
        $info['count'] = ceil($this->database->get_page_count_by_class($id, $type) / $lenght);
        if (!$info['count']) {
            $info['count'] = 1;
        }
        return $info;
    }

    /**
     * 分页数据 返回HTML
     * @param $classnow 当前栏目ID
     * @param $pagenow  当前页码
     * @param $page_type    分页类型 内容/栏目
     * @return string
     */
    public function get_list_page_html($classnow, $pagenow, $page_type)
    {
        global $_M;
        $pagenow = is_numeric($pagenow) ? $pagenow : 1;
        if ($page_type == 1) {
            $column_label = load::sys_class('label', 'new')->get('column');
            $sub_conlumn = $column_label->get_column_by_type('son', $classnow);
            #$total = count($sub_conlumn);
            if ($sub_conlumn) {
                return;
            }
        }

        $pageinfo = $this->get_page_info_by_class($classnow);
        if ($_M['form']['search']) {
            $pageinfo['url'] .= load::sys_class('label', 'new')->get('search')->add_search_url();
        }
        $pagenow = $pagenow ? $pagenow : 1;
        $pageall = $pageinfo['count'];
        $url = $pageinfo['url'];
        $firestpage = $this->handle->replace_list_page_url($url, 1, $classnow);

        $text = "<div class='met_pager'>";
        if ($pagenow == 1) {     //$pagenow当前页面的码数
            if ($pageall != 0) {
                $text .= "<span class='PreSpan'>{$_M['word']['PagePre']}</span>";
            }
        } else {
            $text .= "<a href='" . $this->handle->replace_list_page_url($url, $pagenow - 1, $classnow) . "' class='PreA'>{$_M['word']['PagePre']}</a>";
        }
        if ($pageall > 7) {
            if ($pagenow > 4) {
                $firstPage = "<a href='" . $firestpage . "' class='firstPage'>1...</a>";
                if (($pageall - $pagenow) >= 4) {
                    $startnum = $pagenow - 3;
                    $endnum = $pagenow + 3;
                } else {
                    $startnum = $pageall - 6;
                    $endnum = $pageall;
                }
            } else {
                $startnum = 1;
                $endnum = 7;
            }
            if (($pageall - $pagenow) > 3) {
                $lastPage = "<a href='" . $this->handle->replace_list_page_url($url, $pageall, $classnow) . "' class='lastPage'>..." . $pageall . "</a>";
            }
        } else {
            $startnum = 1;
            $endnum = $pageall;
        }

        //首页
        $text .= $firstPage;

        for ($i = $startnum; $i <= $endnum; $i++) {
            $pageurl = $i == 1 ? $firestpage : $this->handle->replace_list_page_url($url, $i, $classnow);
            if ($i == $pagenow) {
                $page_stylenow = "class='Ahover'";
            }
            $text .= "<a href='" . $pageurl . "' $page_stylenow>" . $i . "</a>";
            $page_stylenow = '';
        }

        //末页
        $text .= $lastPage;
        if ($pagenow == $pageall) {
            $text .= "<span class='NextSpan'>{$_M['word']['PageNext']}</span>";
        } else {
            if ($pageall != 0) {
                $text .= "<a href='" . $this->handle->replace_list_page_url($url, $pagenow + 1, $classnow) . "' class='NextA'>{$_M['word']['PageNext']}</a>";
            }
        }
        list($pageurl, $pageexc) = explode('#page#', $url);
        $pageurls = explode('/', $pageurl);
        $search_str = '';
        if ($_M['form']['search'] || $_M['form']['searchword']) {
            if ($_M['form']['class1']) $search_str .= "&class1={$_M['form']['class1']}";
            if ($_M['form']['class2']) $search_str .= "&class2={$_M['form']['class2']}";
            if ($_M['form']['class3']) $search_str .= "&class3={$_M['form']['class3']}";
            $search_str .= "&search={$_M['form']['search']}";
            if ($_M['form']['search_module']) $search_str .= "&search_module={$_M['form']['search_module']}";
            if ($_M['form']['searchword']) $search_str .= "&searchword={$_M['form']['searchword']}";
            if ($_M['form']['content']) $search_str .= "&content={$_M['form']['content']}";
            if ($_M['form']['para']) {
                $para = rawurlencode($_M['form']['para']);
                $search_str .= "&para={$para}";
            }

            if ($_M['form']['specv']) {
                $para = rawurlencode($_M['form']['specv']);
                $search_str .= "&specv={$para}";
            }

            //价格区间
            if ($_M['form']['price_low']) {
                $price_low = rawurlencode($_M['form']['price_low']);
                $search_str .= "&price_low={$price_low}";
            }
            if ($_M['form']['price_top']) {
                $price_top = rawurlencode($_M['form']['price_top']);
                $search_str .= "&price_top={$price_top}";
            }

        } else {
            $classnow_info = load::sys_class('label', 'new')->get('column')->get_column_id($classnow);
            $search_str = "&class{$classnow_info['classtype']}={$classnow}";
        }

        if ($pageall != 0) {
            for ($i = 1; $i <= $pageall; $i++) {
                if ($i == $pagenow) {
                    if ($_M['form']['search'] && $_M['form']['searchword']) {
                        $url = $_M['url']['site'] . 'search/index.php';
                    } else {
                        $url = 'index.php';
                    }
                    $text .= "
					<span class='PageText'>{$_M['word']['PageGo']}</span>
					<input type='text' id='metPageT' data-pageurl='" . $url . "?lang={$_M['lang']}{$search_str}&page=" . "|" . $pageexc . "|" . $pageall . "' value='" . $i . "' />
					<input type='button' id='metPageB' value='" . $_M['word']['Page'] . "' />";
                }
            }
        }

        $text .= "
			</div>
		";
        return $text;
    }

    /**
     * 翻页数据 返回数组 未使用
     * @param $classnow
     * @param $pagenow
     * @return string
     */
    public function get_list_page_data($classnow, $pagenow)
    {
        global $_M;
        $pageinfo = $this->get_page_info_by_class($classnow);
        if ($_M['form']['search']) {
            $pageinfo['url'] .= load::sys_class('label', 'new')->get('search')->add_search_url();
        }
        $pagenow = $pagenow ? $pagenow : 1;
        $pageall = $pageinfo['count'];
        $url = $pageinfo['url'];
        $firestpage = $this->handle->replace_list_page_url($url, 1, $classnow);

        $page_list = array();
        $text = "<div class='met_pager'>";
        if ($pagenow == 1) {     //$pagenow当前页面的码数
            if ($pageall != 0) {
                $text .= "<span class='PreSpan'>{$_M['word']['PagePre']}</span>";
            }
        } else {
            $text .= "<a href='" . $this->handle->replace_list_page_url($url, $pagenow - 1, $classnow) . "' class='PreA'>{$_M['word']['PagePre']}</a>";
            $pre_row = array();
            $pre_row['name'] = $_M['word']['PagePre'];
            $pre_row['url'] = $this->handle->replace_list_page_url($url, $pagenow - 1, $classnow);
            $pre_row['class'] = "class='PreA'";
            $page_list[] = $pre_row;
        }

        if ($pageall > 7) {
            if ($pagenow > 4) {
                $firstPage = "<a href='" . $firestpage . "' class='firstPage'>1...</a>";
                $first_row = array();
                $first_row['name'] = "1...";
                $first_row['url'] = "$firestpage";
                $first_row['class'] = "class='firstPage'";

                if (($pageall - $pagenow) >= 4) {
                    $startnum = $pagenow - 3;
                    $endnum = $pagenow + 3;
                } else {
                    $startnum = $pageall - 6;
                    $endnum = $pageall;
                }
            } else {
                $startnum = 1;
                $endnum = 7;
            }
            if (($pageall - $pagenow) > 3) {
                $lastPage = "<a href='" . $this->handle->replace_list_page_url($url, $pageall, $classnow) . "' class='lastPage'>..." . $pageall . "</a>";
                $last_row = array();
                $last_row['name'] = "..{$pageall}";
                $last_row['url'] = "$this->handle->replace_list_page_url($url, $pageall, $classnow)";
                $last_row['class'] = "class='lastPage'";
            }
        } else {
            $startnum = 1;
            $endnum = $pageall;
        }

        $text .= $firstPage;
        $page_list[] = $first_row;

        for ($i = $startnum; $i <= $endnum; $i++) {
            $pageurl = $i == 1 ? $firestpage : $this->handle->replace_list_page_url($url, $i, $classnow);
            if ($i == $pagenow) {
                $page_stylenow = "class='Ahover'";
            }
            $text .= "<a href='" . $pageurl . "' $page_stylenow>" . $i . "</a>";
            $page_stylenow = '';
            $row = array();
            $row['name'] = $i;
            $row['url'] = $pageurl;
            $row['class'] = $page_stylenow;
            $page_list[] = $row;
        }
        $text .= $lastPage;
        $page_list[] = $last_row;

        if ($pagenow == $pageall) {
            $text .= "<span class='NextSpan'>{$_M['word']['PageNext']}</span>";
        } else {
            if ($pageall != 0) {
                $text .= "<a href='" . $this->handle->replace_list_page_url($url, $pagenow + 1, $classnow) . "' class='NextA'>{$_M['word']['PageNext']}</a>";
                $next_row = array();
                $next_row['name'] = $_M['word']['PageNext'];
                $next_row['url'] = $this->handle->replace_list_page_url($url, $pagenow + 1, $classnow);
                $next_row['name'] = "class='NextA'";
                $page_list[] = $next_row;
            }
        }
        list($pageurl, $pageexc) = explode('#page#', $url);
        $pageurls = explode('/', $pageurl);
        $search_str = '';
        if ($_M['form']['search'] || $_M['form']['searchword']) {
            if ($_M['form']['class1']) $search_str .= "&class1={$_M['form']['class1']}";
            if ($_M['form']['class2']) $search_str .= "&class2={$_M['form']['class2']}";
            if ($_M['form']['class3']) $search_str .= "&class3={$_M['form']['class3']}";
            $search_str .= "&search={$_M['form']['search']}";
            if ($_M['form']['searchword']) $search_str .= "&searchword={$_M['form']['searchword']}";
            if ($_M['form']['para']) {
                $para = rawurlencode($_M['form']['para']);
                $search_str .= "&para={$para}";
            }

            if ($_M['form']['specv']) {
                $para = rawurlencode($_M['form']['specv']);
                $search_str .= "&specv={$para}";
            }

            //价格区间
            if ($_M['form']['price_low']) {
                $price_low = rawurlencode($_M['form']['price_low']);
                $search_str .= "&price_low={$price_low}";
            }
            if ($_M['form']['price_top']) {
                $price_top = rawurlencode($_M['form']['price_top']);
                $search_str .= "&price_top={$price_top}";
            }


        } else {
            $classnow_info = load::sys_class('label', 'new')->get('column')->get_column_id($classnow);
            $search_str = "&class{$classnow_info['classtype']}={$classnow}";
        }

        if ($pageall != 0) {
            for ($i = 1; $i <= $pageall; $i++) {
                if ($i == $pagenow) {
                    if ($_M['form']['search'] && $_M['form']['searchword']) {
                        $url = $_M['url']['site'] . 'search/index.php';
                    } else {
                        $url = 'index.php';
                    }
                    $text .= "
					<span class='PageText'>{$_M['word']['PageGo']}</span>
					<input type='text' id='metPageT' data-pageurl='" . $url . "?lang={$_M['lang']}{$search_str}&page=" . "|" . $pageexc . "|" . $pageall . "' value='" . $i . "' />
					<input type='button' id='metPageB' value='" . $_M['word']['Page'] . "' />";
                    $button = array();
                    $button['input']['url'] = "{$url}?lang={$_M['lang']}{$search_str}&page=|{$pageexc}|{$pageall}";
                    $button['input']['value'] = $i;
                    $button['input']['id'] = "id='metPageT' ";
                    $button['button']['value'] = $_M['word']['Page'];
                    $button['button']['id'] = "id='metPageB";
                }
            }
        }

        $text .= "
			</div>
		";

        $redata = array();
        $redata['page_list'] = $page_list;
        $redata['page_button'] = $button;
        return $redata;
        #return $text;
    }

    /**
     * 共用list标签
     * @param  string $mod 模块名称或id
     * @param  string $num 数量
     * @param  string $type com/news/all
     */
    public function get_list_page_select($classnow, $pagenow)
    {
        global $_M;
        $c = load::sys_class('label', 'new')->get('column')->get_column_id($classnow);
        $module = load::sys_class('handle', 'new')->mod_to_file($c['module']);
        $select['load'] = $_M['word']['fliptext1'];
        $select['page'] = $pagenow;
        $select['url'] = $this->get_page_url($classnow) . '&ajax=1';
        return $select;
    }

    /**
     * 栏目列表页条数
     * @param string $classnow
     */
    protected function get_list_page_lenght($classnow = '')
    {
        global $_M;
        $c = load::sys_class('label', 'new')->get('column')->get_column_id($classnow);
        $column_lable = load::sys_class('label', 'new')->get('column');
        $c123 = $column_lable->get_class123_no_reclass($c['id']);

        //栏目配置分页条数及说略图尺寸信息
        $c_lev = $c['classtype'];

        //三级栏目
        if ($c_lev == 3) {
            //list_length
            $list_length = $c123['class3']['list_length'] ? $c123['class3']['list_length'] : ($c123['class2']['list_length'] ? $c123['class2']['list_length'] : ($c123['class1']['list_length'] ? $c123['class1']['list_length'] : 8));
        }

        //二级栏目将
        if ($c_lev == 2) {
            //list_length
            $list_length = $c123['class2']['list_length'] ? $c123['class2']['list_length'] : ($c123['class1']['list_length'] ? $c123['class1']['list_length'] : 8);

        }

        //一级栏目
        if ($c_lev == 1) {
            //list_length
            $list_length = $c123['class1']['list_length'] ? $c123['class1']['list_length'] : 8;
        }

        //分页条数
        $length = $list_length ? $list_length : 8;
        return $length;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
