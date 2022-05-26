<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * 反馈标签类
 */

class language_label
{

    public $lang;//语言

    /**
     * 初始化
     */
    public function __construct()
    {
        global $_M;
        $this->lang = $_M['lang'];
    }

    /**
     * 获取语言导航
     * $flag int 如果等于1则返回所有语言
     * @return array 返回语言导航数组
     */
    public function get_lang()
    {
        global $_M;
        $return = array();
        if (!isset($_M['langlist']['web'])) {
            return $return;
        }

        foreach ($_M['langlist']['web'] as $key => $val) {
            if (!isset($val['useok']) || !$val['useok']) {
                continue;
            }

            // 站点在3种语言以下不显示当前语言
//            if(count($_M['langlist']['web']) < 3 && $_M['lang'] == $val['mark']){
//                continue;
//            }
            if (!isset($val['synchronous']) || !$val['synchronous']) {
                $val['synchronous'] = str_replace('.gif', '', $val['flag']);
            }

            $config = load::mod_class('config/config_database', 'new');
            // 其他语言的伪静态是否开启
            $pseudo = $config->get_value('met_pseudo', $val['mark']);

            $sys_compile = load::sys_class('view/sys_compile', 'new');
            $pseudo = $sys_compile->replace_m($pseudo);

            if ($pseudo && !$_M['form']['pageset']) {
                $url_mark = 'index-' . $val['mark'] . '.html';
            } else {
                $url_mark = 'index.php?lang=' . $val['mark'];
            }

            // 是否为默认语言
            /*if ($_M['config']['met_index_type'] == $val['lang'] && !$_M['form']['pageset']) {
                if ($_M['lang'] == $val['lang']) {
                    $url_mark = '';
                } else {
                    $url_mark = './';
                }
            }*/

            if ($val['link'] && !$_M['form']['pageset']) {

                $val['met_weburl'] = $val['link'];
                $url_mark = "";
            } else {
                $val['met_weburl'] = $_M['url']['web_site'];
            }

            $return[$val['mark']] = array(
                'name' => $val['name'],
                'iconname' => $this->iconvga(str_replace('.gif', '', $val['flag'])),
                'met_weburl' => $val['met_weburl'] . $url_mark,
                'mark' => $val['mark'],
                'useok' => 1,//兼容老版本系统
                'synchronous' => $val['synchronous'],//兼容老版本系统
                'newwindows' => $val['newwindows'],
                'flag' => $_M['url']['public_images'] . 'flag/' . $val['flag']
                #'flag' => $val['met_weburl'] . 'public/images/flag/' . $val['flag'],
            );

        }

        //可视化管理员权限
        if ($_M['form']['pageset'] == 1) {
            load::sys_func('admin');
            $met_amdin = admin_information();
            $admin_lang_ok = $met_amdin['langok'];
            if ($admin_lang_ok == 'metinfo') {
                return $return;
            } else {
                $admin_lang_list = explode('-', $admin_lang_ok);
                $redata = array();
                foreach ($admin_lang_list as $admin_lang) {
                    $redata[$admin_lang] = $return[$admin_lang];
                }
                return $redata;
            }
        }

        return $return;
    }

    /*国旗转换*/
    public function iconvga($lang)
    {
        switch ($lang) {
            case 'sq':
                $vga = 'al';
                break;
            case 'ar':
                $vga = 'sa';
                break;
            case 'az':
                $vga = 'az';
                break;
            case 'ga':
                $vga = 'ie';
                break;
            case 'et':
                $vga = 'ee';
                break;
            case 'be':
                $vga = 'by';
                break;
            case 'bg':
                $vga = 'bg';
                break;
            case 'pl':
                $vga = 'pl';
                break;
            case 'fa':
                $vga = 'ir';
                break;
            case 'af':
                $vga = 'za';
                break;
            case 'da':
                $vga = 'dk';
                break;
            case 'de':
                $vga = 'de';
                break;
            case 'ru':
                $vga = 'ru';
                break;
            case 'fr':
                $vga = 'fr';
                break;
            case 'tl':
                $vga = 'ph';
                break;
            case 'fi':
                $vga = 'fi';
                break;
            case 'ht':
                $vga = 'ht';
                break;
            case 'ko':
                $vga = 'kr';
                break;
            case 'nl':
                $vga = 'nl';
                break;
            case 'gl':
                $vga = 'es';
                break;
            case 'ca':
                $vga = 'es';
                break;
            case 'cs':
                $vga = 'cz';
                break;
            case 'hr':
                $vga = 'hr';
                break;
            case 'la':
                $vga = 'it';
                break;
            case 'lv':
                $vga = 'lv';
                break;
            case 'lt':
                $vga = 'lt';
                break;
            case 'ro':
                $vga = 'ro';
                break;
            case 'mt':
                $vga = 'mt';
                break;
            case 'ms':
                $vga = 'id';
                break;
            case 'mk':
                $vga = 'mk';
                break;
            case 'no':
                $vga = 'no';
                break;
            case 'pt':
                $vga = 'pt';
                break;
            case 'ja':
                $vga = 'jp';
                break;
            case 'sv':
                $vga = 'se';
                break;
            case 'sr':
                $vga = 'rs';
                break;
            case 'sk':
                $vga = 'sk';
                break;
            case 'sl':
                $vga = 'si';
                break;
            case 'sw':
                $vga = 'tz';
                break;
            case 'th':
                $vga = 'th';
                break;
            case 'cy':
                $vga = 'wls';
                break;
            case 'uk':
                $vga = 'ua';
                break;
            case 'iw':
                $vga = '';
                break;
            case 'el':
                $vga = 'gr';
                break;
            case 'eu':
                $vga = 'es';
                break;
            case 'es':
                $vga = 'es';
                break;
            case 'hu':
                $vga = 'hu';
                break;
            case 'it':
                $vga = 'it';
                break;
            case 'yi':
                $vga = 'de';
                break;
            case 'ur':
                $vga = 'pk';
                break;
            case 'id':
                $vga = 'id';
                break;
            case 'en':
                $vga = 'gb';
                break;
            case 'vi':
                $vga = 'vn';
                break;
            case 'zh-TW':
                $vga = 'cn';
                break;
            case 'cn':
                $vga = 'cn';
                break;
        }
        return $vga;
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
