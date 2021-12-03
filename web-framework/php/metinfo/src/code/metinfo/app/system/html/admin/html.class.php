<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin.class.php');
load::sys_class('nav.class.php');
load::sys_func('file');

class html extends admin
{

    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    //获取静态页面设置
    public function doGetSetup()
    {
        global $_M;
        $list = array();
        $list['met_webhtm'] = isset($_M['config']['met_webhtm']) ? $_M['config']['met_webhtm'] : '';
        $list['met_htmway'] = isset($_M['config']['met_htmway']) ? $_M['config']['met_htmway'] : '';
        $list['met_htmlurl'] = isset($_M['config']['met_htmlurl']) ? $_M['config']['met_htmlurl'] : '';
        $list['met_htmtype'] = isset($_M['config']['met_htmtype']) ? $_M['config']['met_htmtype'] : '';
        $list['met_htmpagename'] = isset($_M['config']['met_htmpagename']) ? $_M['config']['met_htmpagename'] : '';
        $list['met_listhtmltype'] = isset($_M['config']['met_listhtmltype']) ? $_M['config']['met_listhtmltype'] : '';
        $list['met_htmlistname'] = isset($_M['config']['met_htmlistname']) ? $_M['config']['met_htmlistname'] : '';

        $this->success($list);
    }

    //保存静态页面设置
    public function doSaveSetup()
    {
        global $_M;
        $configlist = array();
        $configlist[] = 'met_webhtm';
        $configlist[] = 'met_htmway';
        $configlist[] = 'met_htmlurl';
        $configlist[] = 'met_htmtype';
        $configlist[] = 'met_htmpagename';
        $configlist[] = 'met_listhtmltype';
        $configlist[] = 'met_htmlistname';

        if (isset($_M['form']['met_htmtype'])) {
            $_M['form']['met_htmtype'] = $_M['form']['met_htmtype'] == 'htm' ? $_M['form']['met_htmtype'] : 'html';
        }

        //开启静态后关闭伪静态 && 删除重写文件
        if ($_M['form']['met_webhtm']) {
            $_M['config']['met_pseudo'] = 0;
            $query = "UPDATE {$_M['table']['config']} SET value = 0 WHERE name='met_pseudo'";
            DB::query($query);

            //删除重写文件
            if (file_exists(PATH_WEB . 'httpd.ini')) {
                @unlink(PATH_WEB . 'httpd.ini');
            }
            if (file_exists(PATH_WEB . '.htaccess')) {
                @unlink(PATH_WEB . '.htaccess');
            }
            if (file_exists(PATH_WEB . 'web.config')) {
                @unlink(PATH_WEB . 'web.config');
            }
        }

        configsave($configlist);/*保存系统配置*/

        if (file_exists(PATH_WEB . 'cache')) {
            deldir(PATH_WEB . 'cache', 1);
        }
        //写日志
        logs::addAdminLog('physicalstatic', 'submit', 'jsok', 'doSaveSetup');
        $this->success('', $_M['word']['jsok']);
    }

    //删除静态文件
    public function doDelHtml()
    {
        global $_M;
        $module = load::mod_class('column/column_op', 'new')->get_sorting_by_module(false);
        foreach ($module as $key => $val) {
            if ($key >= 1) {
                foreach ($val['class1'] as $keycalss1 => $valclass1) {
                    $files = traversal($valclass1['foldername'], 'html|htm');
                    foreach ($files as $fkey => $fval) {
                        delfile($fval);
                    }
                }
            }
        }
        $lang = load::mod_class('language/language_op', 'new')->get_lang();
        foreach ($lang as $key => $val) {
            delfile("index_{$val['mark']}.html");
            delfile("index_{$val['mark']}.htm");
        }
        delfile('index.html');
        delfile('index.htm');

        if (file_exists(PATH_WEB . 'cache')) {
            deldir(PATH_WEB . 'cache', 1);
        }
        //写日志
        logs::addAdminLog('physicalstatic', 'delete', 'jsok', 'doDelHtml');
        $this->success('', $_M['word']['jsok']);

    }

    //静态页面生成页面
    public function doGetHtml()
    {
        global $_M;
        buffer::clearConfig();
        $module = load::mod_class('column/column_op', 'new')->get_sorting_by_module(false, $_M['mark']);

        $list = array();
        $list['name'] = $_M['word']['htmAll'];
        $list['content']['name'] = $_M['word']['htmCreateAll'];
        $list['content']['url'] = "{$_M['url']['own_form']}&a=doCreatePage&all=1";
        $class1[] = $list;

        $list = array();
        $list['name'] = $_M['word']['seotips6'];
        $list['content']['name'] = $_M['word']['htmTip3'];
        $list['content']['url'] = "{$_M['url']['own_form']}&a=doCreatePage&index=1";
        $class1[] = $list;

        foreach ($module as $mod => $valm) {
            if (($mod >= 1 && $mod <= 8) || $mod == 12) {
                foreach ($valm['class1'] as $keyc1 => $valc1) {
                    $list = array();
                    $list['name'] = $valc1['name'];
                    $list['content']['name'] = $_M['word']['htmTip1'];
                    $list['content']['url'] = "{$_M['url']['own_form']}&a=doCreatePage&type=content&module={$valc1['module']}&class1={$valc1['id']}";
                    if (in_array($valc1['module'], array(2, 3, 4, 5, 6, 7)) && $_M['config']['met_webhtm'] == 2) {
                        $list['column']['name'] = $_M['word']['htmTip2'];
                        $list['column']['url'] = "{$_M['url']['own_form']}&a=doCreatePage&type=column&module={$valc1['module']}&class1={$valc1['id']}";
                    }
                    $class1[] = $list;
                }
            }
        }
        $this->success($class1);
    }

    /**********生成静态页面列表**********/

    /**
     * 获取静态页URL 生成静态页
     */
    public function doCreatePage()
    {
        global $_M;
        $all = isset($_M['form']['all']) ? $_M['form']['all'] : '';
        $index = isset($_M['form']['index']) ? $_M['form']['index'] : '';
        $list_page = isset($_M['form']['list_page']) ? $_M['form']['list_page'] : '';
        $module = isset($_M['form']['module']) ? $_M['form']['module'] : '';
        $type = isset($_M['form']['type']) ? $_M['form']['type'] : '';
        $class1 = isset($_M['form']['class1']) ? $_M['form']['class1'] : '';
        $content = isset($_M['form']['content']) ? $_M['form']['content'] : '';

        if ($all == 1 || $index == 1) {
            $pageinfo[] = $this->homepage();
        }
        $module_list = load::mod_class('column/column_op', 'new')->get_sorting_by_module(false, $_M['mark']);

        //列表页链接
        foreach ($module_list as $mod => $valm) {
            if (($all == 1 || $mod == $module) && in_array($mod, array(1, 2, 3, 4, 5, 6, 7, 8, 12))) {
                //内容页面
                if (($_M['config']['met_webhtm'] == 2 || $_M['config']['met_webhtm'] == 3) && ($type == 'column' || $all == 1 || $list_page == 1) && in_array($mod, array(2, 3, 4, 5, 6, 7))) {//循环栏目获取栏目分页链接
                    foreach ($valm['class1'] as $keyc1 => $valc1) {
                        if ($all == 1 || $valc1['id'] == $class1) {
                            $pageinfo[] = $this->getpage($valc1['id'], $valc1['module']);
                            foreach ($valm['class2'] as $keyc2 => $valc2) {
                                if ($valc2['bigclass'] == $valc1['id']) {
                                    $pageinfo[] = $this->getpage($valc2['id'], $valc2['module']);
                                }
                                foreach ($valm['class3'] as $keyc3 => $valc3) {
                                    if ($valc3['bigclass'] == $valc2['id']) {
                                        $pageinfo[] = $this->getpage($valc3['id'], $valc3['module']);
                                    }
                                }
                            }
                        }
                    }
                }

                //列表页面
                if ($type == 'content' || $all == 1) {
                    foreach ($valm['class1'] as $keyc1 => $valc1) {
                        if ($class1 && $class1 != $valc1['id']) {
                            continue;
                        }
                        if ($mod >= 2 && $mod <= 6) {
                            $pageinfo = array_merge((array)$pageinfo, (array)$this->getlist($valc1['id'], $valc1['module']));
                        } else {
                            if ($class1 == $valc1['id'] || $all == 1) {
                                $pageinfo = array_merge((array)$pageinfo, (array)$this->indexpage($valc1));
                                if ($mod == 1) {
                                    foreach ($valm['class2'] as $keyc2 => $valc2) {
                                        if ($valc2['bigclass'] == $valc1['id']) {
                                            $pageinfo = array_merge((array)$pageinfo, (array)$this->indexpage($valc2));
                                        }
                                        foreach ($valm['class3'] as $keyc3 => $valc3) {
                                            if ($valc3['bigclass'] == $valc2['id']) {
                                                $pageinfo = array_merge((array)$pageinfo, (array)$this->indexpage($valc3));
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                //内容管理添加或编辑内容时——重新生成列表页
                if ($content) {
                    if ($mod >= 2 && $mod <= 6) {
                        $pageinfo = array_merge((array)$pageinfo, (array)$this->getlist($class1, $module));
                    }
                }
            }
        }

        $pages = array();
        foreach ($pageinfo as $key => $val) {
            $mod = load::sys_class('handle', 'new')->mod_to_file($val['module']);
            if ($val['type'] == 'column') {
                $path = pathinfo($val['filename']);
                $html_dir = str_replace($_M['config']['met_weburl'], PATH_WEB, $path['dirname']);
                if (!file_exists($html_dir)) {
                    mkdir($html_dir, 0777, true);
                }
                $page = 1;
                while ($page <= $val['count']) {
                    $p = array();
                    $p['url'] = load::sys_class('label', 'new')->get($mod)->handle->replace_list_page_url($val['url'], $page, $val['id'], 1) . "&metinfonow={$_M['config']['met_member_force']}";
                    $p['filename'] = urlencode(
                        str_replace($_M['url']['web_site'],'',
                            load::sys_class('label', 'new')->get($mod)->handle->replace_list_page_url($val['filename'], $page, $val['id'], 3)
                        )
                    );
                    $p['url'] .= "&html_filename={$p['filename']}";
                    $p['url'] = str_replace('.php&', '.php?', $p['url']);
                    $page++;
                    $pages[] = $p;
                }
            } else {
                $p = array();
                $p['filename'] = urlencode(
                    str_replace($_M['url']['web_site'], '', $val['filename'])
                );
                $p['url'] .= $val['url'] . "&metinfonow={$_M['config']['met_member_force']}" . "&html_filename={$p['filename']}";
                $p['url'] = str_replace('.php&', '.php?', $p['url']);
                $pages[] = $p;
            }
        }
        $all = count($pages);

        foreach ($pages as $key => $val) {
            $now = $key + 1;
            $f = urldecode($val['filename']);
            $pages[$key]['suc'] = "<a target=\"_blank\" href=\"{$_M['url']['web_site']}{$f}\">{$f}{$_M['word']['physicalgenok']}</a>";
            $pages[$key]['fail'] = "<a target=\"_blank\" href=\"{$_M['url']['web_site']}{$f}\" style=\"color:red\">{$f}{$_M['word']['html_createfail_v6']}</a>";
        }
        //写日志
        logs::addAdminLog('physicalstatic', 'js54', 'jsok', 'doCreatePage');
        $this->success($pages);
    }

    /**
     * 获取内容页url
     * @param $id
     * @param $module
     * @return mixed
     */
    public function getpage($id = '', $module = '')
    {
        $mod = load::sys_class('handle', 'new')->mod_to_file($module);
        $list = load::sys_class('label', 'new')->get($mod)->get_page_info_by_class($id, 1);
        $page['id'] = $id;
        $page['url'] = $list['url'];
        $page['count'] = $list['count'];
        $h = load::sys_class('label', 'new')->get($mod)->get_page_info_by_class($id, 3);
        $page['filename'] = $h['url'];
        $page['module'] = $module;
        $page['type'] = 'column';
        return $page;
    }

    /**
     * 获取其他列表内容页url
     * @param $id
     * @param $module
     * @return array
     */
    public function getlist($id = '', $module = '')
    {
        $mod = load::sys_class('handle', 'new')->mod_to_file($module);
        $list = load::sys_class('label', 'new')->get($mod)->get_module_list($id);

        foreach ($list as $key => $val) {
            if ($val['links']) {
                continue;
            }
            $page = array();
            $page['url'] = load::sys_class('label', 'new')->get($mod)->handle->get_content_url($val, 1);
            $page['filename'] = load::sys_class('label', 'new')->get($mod)->handle->get_content_url($val, 3);
            $page['module'] = $module;
            $page['count'] = 0;
            $page['type'] = 'content';
            $redata[] = $page;
        }
        return $redata;
    }

    /**
     * 获取列表列表页url
     * @param string $content
     * @return array|null
     */
    public function indexpage($content = '')
    {
        if ($content['module'] == 0 || $content['isshow'] == 0) {
            return NULL;
        } else {
            $page['url'] = load::mod_class('column/column_handle', 'new')->url_full($content, 1);
            $page['count'] = 0;
            $page['filename'] = load::mod_class('column/column_handle', 'new')->url_full($content, 3);
            $page['module'] = $content['module'];
            $page['type'] = 'content';
            $re[] = $page;
            return $re;
        }
    }

    /**
     * 首页url
     * @return mixed
     */
    public function homepage()
    {
        global $_M;
        $page['url'] = $_M['url']['web_site'] . 'index.php?lang=' . $_M['lang'];
        $page['count'] = 0;
        $page['filename'] = 'index';
        if ($_M['config']['met_index_type'] != $_M['lang']) {
            $page['filename'] .= '_' . $_M['lang'];
        }
        $page['filename'] .= '.' . $_M['config']['met_htmtype'];
        $page['module'] = 0;
        $page['type'] = 'content';
        return $page;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
