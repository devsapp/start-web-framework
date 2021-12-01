<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 基础标签类
 */

class seo_label
{

    public $lang;
    public $str_list;

    public function __construct()
    {
        global $_M;
        $this->lang = $_M['lang'];
        $query = "SELECT * FROM {$_M['table']['label']} where lang='{$_M['lang']}' order BY char_length(oldwords) DESC";
        $result = DB::get_all($query);
        $str_list_temp = array();
        $str_list = array();
        foreach ($result as $list) {
            if (!$list['newwords']) {
                $list['newwords'] = $list['oldwords'];
            }
            if (!$list['newtitle']) {
                $list['newtitle'] = $list['newwords'];
            }
            $str_list_temp[0] = $list['oldwords'];
            if ($list['url']) {
                $str_list_temp[1] = "<a title='{$list['newtitle']}' target='_blank' href='{$list['url']}' class='seolabel'>{$list['newwords']}</a>";
            } else {
                $str_list_temp[1] = $list['newwords'];
            }
            $str_list_temp[2] = $list['num'];
            $str_list[] = $str_list_temp;
        }

        $this->str_list = $str_list;
    }

    /**
     * 锚文本替换
     */
    public function anchor_replace($content)
    {
        global $_M;
        $str = $this->str_list;
        foreach ($str as $k => $val) {
            $val[3] = html_entity_decode($val[0], ENT_QUOTES, 'UTF-8');
            $val[3] = str_replace(array('\\', '/', '.', '$', '^', '*', '(', ')', '-', '[' . ']' . '{', '}', '|', '?', '+'), array('\\\\', '\/', '\.', '\$', '\^', '\*', '\(', '\)', '\-', '\[' . '\]' . '\{', '\}', '\|', '\?', '\+'), $val[3]);
            if ($val[2] != 0) {
                $tmp1 = explode("<", $content);
                $num = $val[2];
                foreach ($tmp1 as $key => $item) {
                    $tmp2 = explode(">", $item);
                    if (sizeof($tmp2) > 1 && strlen($tmp2[1]) > 0) {
                        if (substr($tmp2[0], 0, 1) != "a" && substr($tmp2[0], 0, 1) != "A" && substr($tmp2[0], 0, 6) != 'script' && substr($tmp2[0], 0, 6) != 'SCRIPT') {
                            $valnum = substr_count($tmp2[1], $val[0]);
                            if ($num - $valnum >= 0) {
                                $num = $num - $valnum;
                            } else {
                                $valnum = $num;
                                $num = 0;
                            }
                            $tmp2[1] = preg_replace("/" . $val[3] . "/", $val[1], $tmp2[1], $valnum);
                            $tmp1[$key] = implode(">", $tmp2);
                        }
                    }
                }
                $content = implode("<", $tmp1);
            }
        }
        //$met_atitle = '';
        //$met_alt = '';
        $met_atitle = $_M['config']['met_atitle'];
        $met_alt = $_M['config']['met_alt'];

        $tmp1 = explode("<", $content);
        foreach ($tmp1 as $key => $item) {
            $tmp2 = explode(">", $item);
            if (substr($tmp2[0], 0, 1) == "a" || substr($tmp2[0], 0, 1) == "A") {
                $tmp2[0] = str_replace(array("title=''", "title=\"\""), '', $tmp2[0]);
                if (!strpos($tmp2[0], 'title')) {
                    $tmp2[0] .= " title=\"$met_atitle\"";
                }
                $tmp1[$key] = implode(">", $tmp2);
            }
            if (substr($tmp2[0], 0, 3) == "img" || substr($tmp2[0], 0, 3) == "IMG") {
                $tmp2[0] = str_replace(array("title=''", "title=\"\""), '', $tmp2[0]);
                $tmp2[0] = str_replace(array("alt=''", "alt=\"\""), '', $tmp2[0]);
                if (!strpos($tmp2[0], 'alt')) {
                    $tmp2[0] .= " alt=\"$met_alt\"";
                }
                if (!strpos($tmp2[0], 'title')) {
                    $tmp2[0] .= " title=\"$met_alt\"";
                }
                $tmp1[$key] = implode(">", $tmp2);
            }
        }
        $content = implode("<", $tmp1);

        $content = contnets_replace($content);

        return $content;
    }


    public function sitemaplist($lang)
    {
        global $_M;
        $_M['config']['sitemap'] = true;

        $get_webname = DB::get_one("select value from {$_M['table']['config']} where name='met_webname' and lang='{$lang}'");
        $met_webname = $get_webname['value'];

        $get_pseudo = DB::get_one("select value from {$_M['table']['config']} where name='met_pseudo' and lang='{$lang}'");
        $met_pseudo = $get_pseudo['value'];

        $get_webhtm = DB::get_one("select value from {$_M['table']['config']} where name='met_webhtm' and lang='{$lang}'");
        $met_webhtm = $get_webhtm['value'];

        $type = load::sys_class('handle', 'new')->url_type('', 0, $met_pseudo, $met_webhtm);

        $met_langok = load::sys_class('label', 'new')->get('language')->get_lang();

        $sitemaplist[] = array(
            'updatetime' => date($_M['config']['met_listtime']),
            'title' => $met_webname,
            'url' => $met_langok[$lang]['met_weburl'],
            'priority' => 1
        );

        //栏目URL
        $colunm = load::sys_class('label', 'new')->get('column');
        $colunm->lang = $lang;
        $colunm->column = array();
        $colunm->get_column($lang);
        $c = $colunm->get_all_list();
        $class1list = '';
        foreach ($c as $key => $val) {
            if ($val['display']) {
                continue;
            }
            if ($val['module'] == 9) {
                continue;
            }
            //过滤外部模块
            if ($_M['config']['met_sitemap_not2'] == 1 && $val['out_url']) {
                continue;
            }
            //过滤不显示在导航的一级栏目
            if ($_M['config']['met_sitemap_not1']) {
                if ($val['classtype'] == 1 && !$val['nav']) {
                    continue;
                }
            }

            $class1list .= '-' . $val['id'] . '-';
            if ($val['module'] == 6) $job_flag = 1;
            if ($val['name']) {
                $sitemaplist[] = array(
                    'updatetime' => date($_M['config']['met_listtime']),
                    'title' => $val['name'],
                    'url' => $colunm->handle->get_content_url($val, $type),
                );
            }
        }

        //内容URL
        $module_array = array('news', 'product', 'img', 'download', 'job');
        $fields = array(
            'news' => array('id', 'title', 'class1', 'class2', 'class3', 'class1', 'lang', 'updatetime', 'addtime', 'links', 'access', 'filename', 'displaytype'),
            'product' => array('id', 'title', 'class1', 'class2', 'class3', 'class1', 'lang', 'updatetime', 'addtime', 'links', 'access', 'filename', 'displaytype'),
            'img' => array('id', 'title', 'class1', 'class2', 'class3', 'class1', 'lang', 'updatetime', 'addtime', 'links', 'access', 'filename'),
            'download' => array('id', 'title', 'class1', 'class2', 'class3', 'class1', 'lang', 'updatetime', 'addtime', 'links', 'access', 'filename', 'displaytype'),
            'job' => array('id', 'position', 'class1', 'class2', 'class3', 'class1', 'lang', 'updatetime', 'addtime', 'access', 'filename', 'displaytype'),
        );

        foreach ($module_array as $mod) {
            if ($mod == 'job' && !$job_flag) {
                continue;
            }

            $field = implode(',', $fields[$mod]);
            $sql = "SELECT {$field} FROM {$_M['table'][$mod]} WHERE lang = '{$lang}'";
            if($mod != 'job'){
                $sql .= ' AND recycle = 0 ';
            }
            $c = DB::get_all($sql);
            $handle = load::mod_class('base/base_handle', 'new');
            /*$content = load::sys_class('label', 'new')->get($mod);
            $content->database->set_lang($lang);
            $c = $content->get_module_list();*/

            foreach ($c as $key => $val) {
                if (strpos($class1list, '-' . $val['class1'] . '-') === false && $val != 'job') {
                    continue;
                }
                if (!$val['displaytype']) {
                    continue;
                }

                if ($_M['config']['met_sitemap_not2'] == 1 && $val['links']) {
                    continue;
                }

                $handle->construct($mod);
                $sitemaplist[] = array(
                    'updatetime' => $val['updatetime'],
                    'title' => $val['title'],
                    'url' => $handle->get_content_url($val, $type),
                    //'url' => $content->handle->get_content_url($val, $type),
                );
            }
        }

        return $sitemaplist;
    }

    public function site_map()
    {
        global $_M;
        if ($_M['form']['pageset']) {
            $pageset = $_M['form']['pageset'];
            $_M['form']['pageset'] = '';
        }

        if ($_M['config']['met_sitemap_html'] || $_M['config']['met_sitemap_xml'] || $_M['config']['met_sitemap_txt']) {
            if ($_M['config']['met_sitemap_lang']) {
                $sitemaplist = array();
                $met_langok = load::sys_class('label', 'new')->get('language')->get_lang();
                foreach ($met_langok as $key => $val) {
                    $sitemaplist_temp = $this->sitemaplist($val['mark']);
                    $sitemaplist = array_merge((array)$sitemaplist, (array)$sitemaplist_temp);
                }
            } else {
                $sitemaplist = $this->sitemaplist($_M['lang']);
            }
            $met_sitemap_max = 100000;

            /*html网站地图*/
            if ($_M['config']['met_sitemap_html']) {
                $config_save = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
                $config_save .= "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
                $config_save .= "<head>\n";
                $config_save .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
                $config_save .= "<title>{$_M['config']['met_webname']}</title>\n";
                $config_save .= "</head>\n";
                $config_save .= "<body>\n";
                $config_save .= "<ul>\n";
                $i = 0;
                foreach ($sitemaplist as $key => $val) {
                    $i++;
                    $val['updatetime'] = date("Y-m-d", strtotime($val['updatetime']));
                    $config_save .= "<li><a href='" . $val['url'] . "' title='" . $val['title'] . "' target='_blank'>" . $val['title'] . "</a><span>" . $val['updatetime'] . "</span></li>\n";
                    if ($i >= $met_sitemap_max) {
                        break;
                    }
                }
                $config_save .= "</ul>\n</body>";

                $sitemap_hz = '.html';
                if ($_M['config']['met_sitemap_lang']) {
                    $sitemapname = PATH_WEB . 'sitemap' . $sitemap_hz;
                } else {
                    if ($_M['lang'] == $_M['config']['met_index_type']) {
                        $sitemapname = PATH_WEB . 'sitemap' . $sitemap_hz;
                    } else {
                        $sitemapname = PATH_WEB . "sitemap_{$_M['lang']}" . $sitemap_hz;
                    }
                }
                $fp = fopen($sitemapname, 'w');
                fputs($fp, $config_save);
                fclose($fp);
            }

            /*xml网站地图*/
            if ($_M['config']['met_sitemap_xml']) {
                $i = 0;
                $sitemaptext = '';
                foreach ($sitemaplist as $key => $val) {
                    $val['url'] = str_replace('../', '', $val['url']);
                    $val['url'] = str_replace('&', '&amp;', $val['url']);
                    $val['url'] = str_replace("'", '&apos;', $val['url']);
                    $val['url'] = str_replace('"', '&quot;', $val['url']);
                    $val['url'] = str_replace('>', '&gt;', $val['url']);
                    $val['url'] = str_replace('<', '&lt;', $val['url']);
                    $val['url'] = str_replace('..html', '.html', $val['url']);
                    $val['url'] = str_replace('..htm', '.htm', $val['url']);
                    $i++;
                    $val['updatetime'] = date("Y-m-d", strtotime($val['updatetime']));
                    $val['priority'] = $val['priority'] ? $val['priority'] : '0.5';
                    $sitemaptext .= "<url>\n";
                    $sitemaptext .= "<loc>{$val['url']}</loc>\n";
                    $sitemaptext .= "<priority>{$val['priority']}</priority>\n";
                    $sitemaptext .= "<lastmod>{$val['updatetime']}</lastmod>\n";
                    $sitemaptext .= "<changefreq>weekly</changefreq>\n";
                    $sitemaptext .= "</url>\n";
                    if ($i >= $met_sitemap_max) {
                        break;
                    }
                }

                if ($_M['config']['met_webhtm'] || $_M['config']['met_pseudo']) {
                    if ($_M['config']['met_sitemap_lang']) {
                        $tags = array();
                        $met_langok = load::sys_class('label', 'new')->get('language')->get_lang();
                        foreach ($met_langok as $key => $val) {
                            load::sys_class('label', 'new')->get('column')->get_column($val['mark']);
                            $tags_lang = load::sys_class('label', 'new')->get('tags')->get_tags_list(array(), $val['mark']);
                            $tags = array_merge((array)$tags, (array)$tags_lang);
                        }
                    } else {
                        $tags = load::sys_class('label', 'new')->get('tags')->get_tags_list();
                    }
                    ##$tags = load::sys_class('label','new')->get('tags')->get_tags_list();
                    foreach ($tags as $val) {
                        $val['url'] = str_replace('../', '', $val['url']);
                        $val['url'] = str_replace('&', '&amp;', $val['url']);
                        $val['url'] = str_replace("'", '&apos;', $val['url']);
                        $val['url'] = str_replace('"', '&quot;', $val['url']);
                        $val['url'] = str_replace('>', '&gt;', $val['url']);
                        $val['url'] = str_replace('<', '&lt;', $val['url']);
                        $val['url'] = str_replace('..html', '.html', $val['url']);
                        $val['url'] = str_replace('..htm', '.htm', $val['url']);
                        $sitemaptext .= "<url>\n";
                        $sitemaptext .= "<loc>{$val['url']}</loc>\n";
                        $sitemaptext .= "<priority>0.5</priority>\n";
                        $sitemaptext .= "<lastmod>" . date('Y-m-d') . "</lastmod>\n";
                        $sitemaptext .= "<changefreq>weekly</changefreq>\n";
                        $sitemaptext .= "</url>\n";
                    }
                }

                $config_save = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
                $config_save .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
                $config_save .= $sitemaptext;
                $config_save .= "</urlset>";

                $sitemap_hz = '.xml';
                if ($_M['config']['met_sitemap_lang']) {
                    $sitemapname = PATH_WEB . 'sitemap' . $sitemap_hz;
                } else {
                    if ($_M['lang'] == $_M['config']['met_index_type']) {
                        $sitemapname = PATH_WEB . 'sitemap' . $sitemap_hz;
                    } else {
                        $sitemapname = PATH_WEB . "sitemap_{$_M['lang']}" . $sitemap_hz;
                    }
                }
                $fp = fopen($sitemapname, 'w');
                fputs($fp, $config_save);
                fclose($fp);
            }

            /*Txt网站地图*/
            if ($_M['config']['met_sitemap_txt']) {
                $config_save = "";
                $i = 0;
                foreach ($sitemaplist as $key => $val) {
                    $i++;
                    $val['url'] = str_replace('..html', '.html', $val['url']);
                    $val['url'] = str_replace('..htm', '.htm', $val['url']);
                    $config_save .= "{$val['url']}" . "\r\n";
                    if ($i >= $met_sitemap_max) {
                        break;
                    }
                }
                if ($_M['config']['met_webhtm'] || $_M['config']['met_pseudo']) {
                    if ($_M['config']['met_sitemap_lang']) {
                        $tags = array();
                        $met_langok = load::sys_class('label', 'new')->get('language')->get_lang();
                        foreach ($met_langok as $key => $val) {
                            load::sys_class('label', 'new')->get('column')->get_column($val['mark']);
                            $tags_lang = load::sys_class('label', 'new')->get('tags')->get_tags_list(array(), $val['mark']);
                            $tags = array_merge((array)$tags, (array)$tags_lang);
                        }
                    } else {
                        $tags = load::sys_class('label', 'new')->get('tags')->get_tags_list();
                    }
                    ##$tags = load::sys_class('label', 'new')->get('tags')->get_tags_list();
                    foreach ($tags as $val) {
                        $config_save .= "{$val['url']}" . "\r\n";
                    }
                }
                if (stristr(PHP_OS, "WIN")) {
                    $config_save = @iconv("utf-8", "GBK", $config_save);
                }

                $sitemap_hz = '.txt';
                if ($_M['config']['met_sitemap_lang']) {
                    $sitemapname = PATH_WEB . 'sitemap' . $sitemap_hz;
                } else {
                    if ($_M['lang'] == $_M['config']['met_index_type']) {
                        $sitemapname = PATH_WEB . 'sitemap' . $sitemap_hz;
                    } else {
                        $sitemapname = PATH_WEB . "sitemap_{$_M['lang']}" . $sitemap_hz;
                    }
                }
                $fp = fopen($sitemapname, 'w');
                fputs($fp, $config_save);
                fclose($fp);
            }
        }
        if ($pageset) {
            $_M['form']['pageset'] = $pageset;
        }
        $this->sitemap_robots();
        $this->html404();
        return true;
    }

    function sitemap_robots($sitemaptype = 0)
    {
        global $_M;
        if (!$sitemaptype) {
            $sitemaptype = $_M['config']['met_sitemap_xml'] ? 'xml' : ($_M['config']['met_sitemap_txt'] ? 'txt' : 0);
        }
        $suffix = $sitemaptype;
        $met_weburl_de = $_M['url']['web_site'];

        if (file_exists(PATH_WEB . 'robots.txt')) {
            $robots = file_get_contents(PATH_WEB . 'robots.txt');
        } else {
            $robots = "User-agent: *\n";
            $robots .= "Disallow: /app/\n";
            $robots .= "Disallow: /admin/\n";
            $robots .= "Disallow: /cache/\n";
            $robots .= "Disallow: /config/\n";
            $robots .= "Disallow: /include/\n";
            $robots .= "Disallow: /public/\n";
            $robots .= "Disallow: /install/\n";
            $robots .= "Disallow: /templates/\n";
            $robots .= "Disallow: /upload/\n";
            $robots .= "Disallow: /member/\n";
            $robots .= "Disallow: /wap/templates/\n";
            $robots .= "Sitemap: ";
        }

        if ($suffix) {
            if (stripos($robots, 'Sitemap: ') === false) {
                $robots .= "\nSitemap: {$met_weburl_de}sitemap.{$suffix}";
            } else {
                $robots = preg_replace('/Sitemap:.*/', "Sitemap: {$met_weburl_de}sitemap.{$suffix}", $robots);
            }
        } else {
            $robots = preg_replace("/Sitemap:.*/", "", $robots);
        }
        $robots = str_replace("\n\n", "\n", $robots);
        file_put_contents(PATH_WEB . 'robots.txt', $robots);
    }

    function html404()
    {
        global $_M;
        $param = array(
            'lang' => $_M['config']['met_index_type'],
            'm' => 'include',
            'c' => 'page404',
            'a' => 'dohtml',
            'metinfonow' => $_M['config']['met_member_force'],
            'html_filename' => '404.html'
        );

        foreach ($param as $name => $value) {
            $tmp[] = "{$name}={$value}";
        }
        $param_str = implode('&', $tmp);
        $url = $_M['url']['web_site'] . "app/system/entrance.php?{$param_str}";
        buffer::clearConfig();
        buffer::clearTemp();
        file_get_contents($url);
        return true;

        /*$curl = load::sys_class('curl', 'new');
        $curl->set('host', $_M['url']['web_site']);
        $curl->set('file', 'app/system/entrance.php');
        $curl->set('ignore', 1);
        buffer::clearConfig();
        $curl->curl_post($param);
        return true;*/
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
