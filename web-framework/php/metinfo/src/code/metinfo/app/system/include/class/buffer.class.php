<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

/**
 * Class cache
 */
class buffer
{

    public static function notAdmin()
    {
        global $_M;
        return !defined("IN_ADMIN") && !$_M['form']['pageset'];
    }

    public static function getTables()
    {
        global $_M;
        if (self::notAdmin()) {
            return Cache::get('config/tables');
        }
    }

    public static function setTables($data)
    {
        global $_M;
        Cache::put('config/tables', $data);
    }

    public static function getConfig($lang)
    {
        global $_M;
        if (self::notAdmin()) {
            return Cache::get("config/config_{$lang}");
        }
    }

    public static function clearConfig()
    {
        global $_M;

        foreach ($_M['langlist']['web'] as $key => $val) {
            Cache::del("config/config_{$val['mark']}");
            Cache::del("config/app_config_{$val['mark']}");
        }
        Cache::del("config/app_config_metinfo");

        return Cache::del("config/config_metinfo");
    }

    public static function setConfig($lang, $config)
    {
        global $_M;
        if (self::notAdmin()) {
            return Cache::put("config/config_{$lang}", $config);
        } else {
            self::clearConfig();
        }
    }

    public static function getAppConfig($lang)
    {
        global $_M;
        if (self::notAdmin()) {
            return Cache::get("config/app_config_{$lang}");
        }
    }

    public static function setAppConfig($lang, $config)
    {
        global $_M;
        if (self::notAdmin()) {
            return Cache::put("config/app_config_{$lang}", $config);
        }
    }

    public static function clearTemp()
    {
        deldir(PATH_WEB . 'cache/templates', 1);
    }

    public static function getPage($tplFile)
    {
        global $_M;
        return;
        if (self::notAdmin()) {
            if ($tplFile == 'index') {
                if (!file_exists(PATH_WEB . 'cache/data')) {
                    mkdir(PATH_WEB . 'cache/data/', 0777, true);
                }
                $file = PATH_WEB . 'cache/data/' . $_M['config']['met_skin_user'] . '_' . $tplFile . '_' . $_M['lang'] . '.php';
                if (!file_exists($file) || time() - filemtime($file) > 1800) {
                    return null;
                }
                $content = file_get_contents($file);
            }
            return $content;
        }
        return null;
    }

    public static function setPage($tplFile, $content)
    {
        global $_M;
        return;
        if (self::notAdmin()) {
            if ($tplFile == 'index') {
                if (!file_exists(PATH_WEB . 'cache/data')) {
                    mkdir(PATH_WEB . 'cache/data/', 0777, true);
                }
                file_put_contents(PATH_WEB . 'cache/data/' . $_M['config']['met_skin_user'] . '_' . $tplFile . '_' . $_M['lang'] . '.php', $content);
            }
        }
    }

    public static function getUiConfig($file)
    {
        global $_M;
        return false;
        if (self::notAdmin()) {
            return cache::get($file);
        }
    }

    public static function setUiConfig($file, $data)
    {
        global $_M;
        if (self::notAdmin()) {
            return cache::put($file, $data);
        }
    }

    public static function getColumn($lang)
    {
        global $_M;
        if (self::notAdmin()) {
            return cache::get("column_" . $lang);
        }
    }

    public static function setColumn($lang, $data)
    {
        global $_M;
        if (self::notAdmin()) {
            return cache::put("column_" . $lang, $data);
        }
    }

    public static function clearColumn($lang = '')
    {
        global $_M;
        $lang = $lang ? $lang : $_M['lang'];
        @unlink(PATH_WEB . "cache/column_" . $lang . ".php");
    }

    public static function getLang($type, $lang)
    {
        global $_M;
        if (self::notAdmin()) {
            return cache::get('lang_json_' . $type . $lang);
        }
    }

    public static function setLang($type, $lang, $data)
    {
        global $_M;
        if (self::notAdmin()) {
            return cache::put('lang_json_' . $type . $lang, $data);
        }
    }

    public static function getGroup($lang)
    {
        global $_M;
        if (self::notAdmin()) {
            return cache::get('data/group_' . $lang);
        }
    }

    public static function setGroup($lang, $data)
    {
        global $_M;
        if (self::notAdmin()) {
            return cache::put('data/group_' . $lang, $data);
        }
    }

    public static function clearGroup($lang)
    {
        global $_M;
        if ($lang != '') {
            Cache::del("data/group_{$lang}");
        } else {
            foreach ($_M['langlist']['web'] as $key => $val) {
                Cache::del("data/group_{$val['mark']}");
            }
        }
        return;
    }

    public static function getParaList($module, $lang)
    {
        global $_M;
        if (self::notAdmin()) {
            return cache::get('data/para_' . $module . '_' . $lang);
        }
    }

    public static function setParaList($module, $lang, $data)
    {
        global $_M;
        if (self::notAdmin()) {
            return cache::put('data/para_' . $module . '_' . $lang, $data);
        }
    }

    public static function clearData($module = '', $lang = '')
    {
        global $_M;
        if ($lang != '') {
            Cache::del("data/para_{$module}_{$lang}");
        } else {
            foreach ($_M['langlist']['web'] as $key => $val) {
                Cache::del("data/para_{$module}_{$val['mark']}");
            }
        }
        return;
    }

    public static function getTagConfig()
    {
        global $_M;
        if (self::notAdmin()) {
            return cache::get('config/tag_config_' . $_M['lang']);
        }
    }

    public static function setTagConfig($data)
    {
        global $_M;
        if (self::notAdmin()) {
            return cache::put('config/tag_config_' . $_M['lang'], $data);
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
