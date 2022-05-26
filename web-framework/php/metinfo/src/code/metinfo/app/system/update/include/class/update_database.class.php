<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
load::sys_class('database');
/**
 * 更新迁移数据
 */
class update_database extends database
{
    /**
     * @var string
     */
    private $version;

    /**
     * @var
     */
    private $colum_label;

    public function __construct()
    {
        global $_M;
        $this->version = '7.3.0';
        $this->colum_label = load::sys_class('label', 'new')->get('column');
        $this->tables = load::mod_class('databack/tables', 'new');
    }

    public function update_system($version)
    {
        global $_M;
        //检测新增数据表和字段
        $this->diff_fields($version);

        //强制更新表字段
        $this->alter_table($version);

        //注册数据表
        $this->table_regist();

        //恢复用户数据
        $this->recovery_data();

        //更新配置
        $this->add_config();

        //商城开关
        $this->check_shop();

        if (version_compare($version, '7.0.0beta', '<')) {//6.1/6.2->7.0.0beta
            //表单模块数据迁移
            $this->recovery_form_seting();

            //更新online数据
            $this->recovery_online();

            // 更新友情链接数据
            $this->recovery_link();

            //更新新闻发布人
            $this->recovery_news();

            //更新栏目信息
            $this->recovery_column();

            //更新后台栏目
            $this->update_admin_column();

            //更新applist
            $this->update_app_list();

            //更新tags
            $this->update_tags();

            //更新语言
            $this->update_language($version);
        } elseif (version_compare($version, '7.3.0', '<')) {//7.0.0beta->7.3.0
            //更新语言
            $this->update_language($version);
        }
    }

    /**
     * 对比数据库机构
     * @param $version
     */
    public function diff_fields($version)
    {
        global $_M;
        $this->tables->version = $version;
        $diffs = $this->tables->get_diff_tables();
        if (isset($diffs['table'])) {
            foreach ($diffs['table'] as $table => $detail) {
                $sql = "CREATE TABLE IF NOT EXISTS `{$table}` (";
                foreach ($detail as $k => $v) {
                    if ($k == 'id') {
                        $sql .= "`{$k}` {$v['Type']} {$v['Extra']} ,";
                    } else {
                        $sql .= "`{$k}` {$v['Type']} ";

                        if ($v['Default'] === null) {
                            $sql .= " DEFAULT NULL ";
                        } else {
                            $sql .= " DEFAULT '{$v['Default']}' ";
                        }

                        $sql .= "  {$v['Extra']} ,";
                    }
                }
                $sql .= "PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
                DB::query($sql);
                add_table(str_replace($_M['config']['tablepre'], '', $table));
            }
        }

        if (isset($diffs['field'])) {
            foreach ($diffs['field'] as $table => $v) {
                foreach ($v as $field => $f) {
                    $sql = "ALTER TABLE `{$table}` ADD COLUMN `{$field}`  {$f['Type']} ";

                    if ($f['Default'] === null) {
                        $sql .= " Default NULL ";
                    } else {
                        $sql .= " Default '{$f['Default']}' ";
                    }
                    DB::query($sql);
                }
            }
        }
    }

    /**
     * 更新表字段默认值
     * @param $version
     */
    public function alter_table($version)
    {
        global $_M;
        $this->tables->version = $version;
        $base = $this->tables->get_base_table();
        if (!$base) {
            return;
        }

        foreach ($base as $table_name => $table) {
            $table_name_now = str_replace('met_', $_M['config']['tablepre'], $table_name);
            $sql = "ALTER TABLE `{$table_name_now}` ";
            foreach ($table as $key => $field) {
                if ($key == 'id') {
                    continue;
                }

                $sql .= " MODIFY COLUMN `{$field['Field']}` {$field['Type']} ";
                if ($field['Default'] === null) {
                    $sql .= " DEFAULT NULL ";
                } else {
                    $sql .= " DEFAULT '{$field['Default']}' ";
                }
                $sql .= ',';
            }
            $sql = trim($sql, ',') . ';';
            DB::query($sql);
        }
    }

    /**
     * 注册数据表
     */
    public function table_regist()
    {
        global $_M;
        add_table('flash_button');
        add_table('tags');
        add_table('admin_logs');
        add_table('menu');
        add_table('weixin_reply_log');
    }

    /**
     * 备份用户临时数据
     * @return array
     */
    public function temp_data()
    {
        global $_M;

        $data = array();
        $data['met_secret_key'] = $_M['config']['met_secret_key'];
        $data['last_version'] = $_M['config']['metcms_v'];
        $data['tablename'] = $_M['config']['met_tablename'];

        $query = "SELECT * FROM {$_M['table']['applist']}";
        $data['applist'] = DB::get_all($query);

        //用户数据缓存
        Cache::put('temp_data', $data);
        return $data;
    }

    /**
     * 恢复用户数据
     */
    public function recovery_data()
    {
        global $_M;
        if (file_exists(PATH_WEB . 'cache/temp_data.php')) {
            $data = Cache::get('temp_data');
            add_table($data['tablename']);

            //恢复注册数据表
            $query = "SELECT value FROM {$_M['table']['config']} WHERE name = 'met_tablename'";
            $config = DB::get_one($query);
            $_Mettables = explode('|', $config['value']);
            foreach ($_Mettables as $key => $val) {
                $_M['table'][$val] = $_M['config']['tablepre'] . $val;
            }

            //恢复用户TOKEN
            $query = "UPDATE {$_M['table']['config']} SET value = '{$data['met_secret_key']}' WHERE name = 'met_secret_key'";
            DB::query($query);

            //恢复系统版本
            $query = "UPDATE {$_M['table']['config']} SET value = '{$data['last_version']}' WHERE name = 'metcms_v'";
            DB::query($query);

            //恢复应用列表数据
            foreach ($data['applist'] as $app) {
                $query = "SELECT id FROM {$_M['table']['applist']} WHERE m_name='{$app['m_name']}'";
                if (!DB::get_one($query) && file_exists(PATH_WEB . 'app/app/' . $app['m_name'])) {
                    unset($app['id']);
                    $sql = self::get_sql($app);
                    $query = "INSERT INTO {$_M['table']['applist']} SET {$sql}";
                    DB::query($query);
                }
            }
        }

        //删除临时数据文件
        Cache::del('temp_data');
    }

    /**
     * 表单模块数据迁移
     */
    public function recovery_form_seting()
    {
        global $_M;
        //job
        foreach (array_keys($_M['langlist']['web']) as $lang) {
            //栏目初始化
            $this->colum_label->get_column($lang);

            $query = "SELECT * FROM {$_M['table']['column']} WHERE lang = '{$lang}' AND module = 6";
            $jobs = DB::get_all($query);
            if ($jobs) {
                foreach ($jobs as $job) {
                    self::recovery_job($job, $lang);
                }
            }

            //message
            $query = "SELECT * FROM {$_M['table']['column']} WHERE lang = '{$lang}' AND module = 7";
            $message = DB::get_one($query);
            if ($message) {
                self::recovery_message($message);
            }

            //feedback
            $query = "SELECT * FROM {$_M['table']['column']} WHERE lang = '{$lang}' AND module = 8";
            $feedbacks = DB::get_all($query);
            if ($feedbacks) {
                foreach ($feedbacks as $fd) {
                    self::recovery_feedback($fd);
                }
            }
        }
    }

    /**
     * 更新job配置
     */
    public function recovery_job($data = array(), $lang = '')
    {
        global $_M;
        if ($data && $lang) {
            //跟新内容层级关系
            #$class123 = $this->colum_label->get_class123_reclass($data['id']);
            #$query = "UPDATE {$_M['table']['job']} SET class1 = '{$class123['class1']['id']}' , class2 = '{$class123['class2']['id']}', class3 = '{$class123['class3']['id']}'";
            $query = "UPDATE {$_M['table']['job']} SET class1 = '{$data['id']}' , class2 = '0', class3 = '0' WHERE lang = '{$lang}'";
            DB::query($query);

            //更新表单配置
            $array = array();
            $array[] = array('met_cv_time', '120');
            $array[] = array('met_cv_image', '');
            $array[] = array('met_cv_showcol', '');
            $array[] = array('met_cv_emtype', '1');
            $array[] = array('met_cv_type', '');
            $array[] = array('met_cv_to', '');
            $array[] = array('met_cv_job_tel', '');
            $array[] = array('met_cv_back', '');
            $array[] = array('met_cv_email', '');
            $array[] = array('met_cv_title', '');
            $array[] = array('met_cv_content', '');
            $array[] = array('met_cv_sms_back', '');
            $array[] = array('met_cv_sms_tell', '');
            $array[] = array('met_cv_sms_content', '');

            $config_op = load::mod_class('config/config_op', 'new');
            $column_config = $config_op->getColumnConfArry($data['id']);

            foreach ($array as $row) {
                $name = $row[0];
                $value = $column_config[$name] ? $column_config[$name] : $row[1];
                $cid = $data['id'];
                $lang = $data['lang'];
                self::update_config($name, $value, $cid, $lang);
            }

            //删除无用配置
            $query = "DELETE FROM {$_M['table']['config']} WHERE name LIKE '%met_cv%' AND lang = '{$data['lang']}' AND columnid = '0'";
            DB::query($query);
        }
        return;
    }

    /**
     * 更新message配置
     */
    public function recovery_message($data = array())
    {
        global $_M;
        if ($data) {
            $array = array();
            $array[] = array('met_msg_ok', '');
            $array[] = array('met_msg_time', '120');
            $array[] = array('met_msg_name_field', '');
            $array[] = array('met_msg_content_field', '');
            $array[] = array('met_msg_show_type', '1');
            $array[] = array('met_msg_type', '1');
            $array[] = array('met_msg_to', '');
            $array[] = array('met_msg_admin_tel', '');
            $array[] = array('met_msg_back', '');
            $array[] = array('met_msg_email_field', '');
            $array[] = array('met_msg_title', '');
            $array[] = array('met_msg_content', '');
            $array[] = array('met_msg_sms_back', '');
            $array[] = array('met_msg_sms_field', '');
            $array[] = array('met_msg_sms_content', '');

            $config_op = load::mod_class('config/config_op', 'new');
            $column_config = $config_op->getColumnConfArry($data['id']);

            foreach ($array as $row) {
                $name = $row[0];
                $value = $column_config[$name] ? $column_config[$name] : $row[1];
                $cid = $data['id'];
                $lang = $data['lang'];
                self::update_config($name, $value, $cid, $lang);
            }
        }
    }

    /**
     * 更新feedback配置
     */
    public function recovery_feedback($data = array())
    {
        global $_M;
        if ($data) {
            $column = $this->colum_label->get_column_id($data['id']);
            $met_fdtable = $column['name']; //反馈表单名称

            $array = array();
            $array[] = array('met_fd_ok', '');
            $array[] = array('met_fdtable', $met_fdtable);
            ###$array[] = array('met_fd_class', '');
            $array[] = array('met_fd_time', '120');
            $array[] = array('met_fd_related', '');
            $array[] = array('met_fd_showcol', '');
            $array[] = array('met_fd_inquiry', '');
            $array[] = array('met_fd_type', '');
            $array[] = array('met_fd_to', '');
            $array[] = array('met_fd_admin_tel', '');
            $array[] = array('met_fd_back', '');
            $array[] = array('met_fd_email', '');
            $array[] = array('met_fd_title', '');
            $array[] = array('met_fd_content', '');
            $array[] = array('met_fd_sms_back', '');
            $array[] = array('met_fd_sms_tell', '');
            $array[] = array('met_fd_sms_content', '');

            $config_op = load::mod_class('config/config_op', 'new');
            $column_config = $config_op->getColumnConfArry($data['id']);

            foreach ($array as $row) {
                $name = $row[0];
                $value = $column_config[$name] ? $column_config[$name] : $row[1];
                $cid = $data['id'];
                $lang = $data['lang'];
                self::update_config($name, $value, $cid, $lang);
            }
        }
    }

    /**
     * 更新online数据
     */
    public function recovery_online()
    {
        global $_M;
        /*if(file_exists(PATH_WEB.'cache/temp_online.php')){
        $data = Cache::get('temp_online');
        }*/

        $query = "SELECT * FROM {$_M['table']['online']}";
        $data = DB::get_all($query);

        //清空online表
        #$query = "TRUNCATE TABLE {$_M['table']['online']} ";
        $query = "DELETE FROM {$_M['table']['online']} ";
        DB::query($query);
        $query = "ALTER TABLE `{$_M['table']['online']}`
                    DROP COLUMN `qq`,
                    DROP COLUMN `msn`,
                    DROP COLUMN `taobao`,
                    DROP COLUMN `alibaba`,
                    DROP COLUMN `skype`;
                    ";
        DB::query($query);

        foreach (array_keys($_M['langlist']['web']) as $lang) {
            //客服默认样式
            self::update_config('met_online_skin', 3, 0, $lang);
            //插入新客服数据
            self::onlineInsert($data, $lang);
        }
        return;
    }

    /**
     * 插入新客服数据
     * @param array $online_list
     * @param string $lang
     */
    private function onlineInsert($online_list = array(), $lang = '')
    {
        global $_M;
        foreach ($online_list as $online) {
            if ($online['lang'] == $lang) {
                if ($online['qq']) {
                    $name = $online['name'];
                    $no_order = $online['no_order'];
                    $value = $online['qq'];
                    $icon = 'icon fa-qq';
                    $type = '0';
                    $query = "INSERT INTO {$_M['table']['online']} (name,no_order,lang,value,icon,type) VALUES ('{$name}','{$no_order}','{$lang}','{$value}','{$icon}','{$type}')";
                    DB::query($query);
                }
                if ($online['msn']) {
                    $name = $online['name'];
                    $no_order = $online['no_order'];
                    $value = $online['sms'];
                    $icon = 'icon fa-facebook';
                    $type = '6';
                    $query = "INSERT INTO {$_M['table']['online']} (name,no_order,lang,value,icon,type) VALUES ('{$name}','{$no_order}','{$lang}','{$value}','{$icon}','{$type}')";
                    DB::query($query);
                }
                if ($online['taobao']) {
                    $name = $online['name'];
                    $no_order = $online['no_order'];
                    $value = $online['taobao'];
                    $icon = 'icon fa-comment';
                    $type = '1';
                    $query = "INSERT INTO {$_M['table']['online']} (name,no_order,lang,value,icon,type) VALUES ('{$name}','{$no_order}','{$lang}','{$value}','{$icon}','{$type}')";
                    DB::query($query);
                }
                if ($online['alibaba']) {
                    $name = $online['name'];
                    $no_order = $online['no_order'];
                    $value = $online['alibaba'];
                    $icon = 'icon fa-comment';
                    $type = '2';
                    $query = "INSERT INTO {$_M['table']['online']} (name,no_order,lang,value,icon,type) VALUES ('{$name}','{$no_order}','{$lang}','{$value}','{$icon}','{$type}')";
                    DB::query($query);
                }
                if ($online['skype']) {
                    $name = $online['name'];
                    $no_order = $online['no_order'];
                    $value = $online['skype'];
                    $icon = 'icon fa-skype';
                    $type = '5';
                    $query = "INSERT INTO {$_M['table']['online']} (name,no_order,lang,value,icon,type) VALUES ('{$name}','{$no_order}','{$lang}','{$value}','{$icon}','{$type}')";
                    DB::query($query);
                }

            }
        }
    }

    /**
     * 更新友情链接数据
     */
    public function recovery_link()
    {
        global $_M;
        $query = "UPDATE {$_M['table']['link']} SET module = ',10001,'";
        DB::query($query);

    }

    /**
     * 更新友情链接数据
     */
    public function recovery_news()
    {
        global $_M;
        $query = "SELECT * FROM {$_M['table']['news']}";
        $news_list = DB::get_all($query);
        foreach ($news_list as $news) {
            if ($news['issue']) {
                $query = "UPDATE {$_M['table']['news']} SET publisher = '{$news['issue']}' WHERE id = {$news['id']}";
                DB::query($query);
            }
        }
        return;
    }

    /**
     * 更新栏目数据
     */
    public function recovery_column()
    {
        return;
        global $_M;
        foreach (array_keys($_M['langlist']['web']) as $lang) {
            $query = "SELECT * FROM {$_M['table']['column']} WHERE lang = '{$lang}' ";
            $column_list = DB::get_all($query);
            foreach ($column_list as $column) {
                if ($column['module'] == 2) {
                    $list_length = $_M['config']['met_news_list'];
                }
                if ($column['module'] == 3) {
                    $list_length = $_M['config']['met_product_list'];
                }
                if ($column['module'] == 4) {
                    $list_length = $_M['config']['met_download_list'];
                }
                if ($column['module'] == 5) {
                    $list_length = $_M['config']['met_img_list'];
                }
                if ($column['module'] == 6) {
                    $list_length = $_M['config']['met_job_list'];
                }
                if ($column['module'] == 7) {
                    $list_length = $_M['config']['met_message_list'];
                }
                if ($column['module'] == 11) {
                    $list_length = $_M['config']['met_search_list'];
                }

                $list_length = $list_length ? $list_length : 8;

                $query = "UPDATE {$_M['table']['column']} SET list_length = '{$list_length}' WHERE id = {$column['id']}";
                DB::query($query);

            }
        }
    }

    /**
     * 更新语言
     */
    public function update_language($version)
    {
        global $_M;
        self::update_admin_lang($version);
        self::update_web_lang($version);
    }

    /**
     * 更新后台语言
     * @param $version
     */
    public function update_admin_lang($version)
    {
        global $_M;
        //添加管理员语言
        $query = "SELECT * FROM {$_M['table']['lang_admin']} WHERE lang = 'cn' AND mark = 'cn'";
        $res = DB::get_one($query);
        if (!$res) {
            $query = "INSERT INTO {$_M['table']['lang_admin']} SET name = '简体中文', useok = 1, no_order = 1, mark = 'cn', synchronous = 'cn',  link = '', lang = 'cn' ";
            DB::query($query);
        }

        //本地指纹
        $path_cn = __DIR__ . "/v{$version}lang_admin_cn.json";
        $path_en = __DIR__ . "/v{$version}lang_admin_en.json";
        //$lang_json_cn = "https://www.metinfo.cn/upload/json/v{$version}lang_cn.json";
        //$lang_json_en = "https://www.metinfo.cn/upload/json/v{$version}lang_en.json";

        $sql = "SELECT * FROM {$_M['table']['lang_admin']} ";
        $admin_lang_list = DB::get_all($sql);
        foreach ($admin_lang_list as $row) {
            $lang = $row['lang'];
            //语言
            if ($lang != 'en') {
                $path = $path_cn;
            } else {
                $path = $path_en;
            }

            //获取语言对照文件
            $lang_json = file_get_contents($path);
            $lang_data = json_decode($lang_json, true);

            if (is_array($lang_data)) {
                $sql = "DELETE FROM {$_M['table']['language']} WHERE lang = '{$lang}' AND  site = 1 AND app = 0 ";
                DB::query($sql);
                foreach ($lang_data as $lang_row) {
                    if ($lang_row['site'] == 1) {
                        self::add_language($lang_row);
                    }
                }
            }
        }
    }

    /**
     * 更新前台语言
     * @param $version
     */
    public function update_web_lang($version)
    {
        global $_M;
        //本地指纹
        $path_cn = __DIR__ . "/update_7.3.0/v{$version}lang_web_cn.json";
        $path_en = __DIR__ . "/update_7.3.0/v{$version}lang_web_en.json";

        $sql = "SELECT * FROM {$_M['table']['lang']} ";
        $web_lang_list = DB::get_all($sql);
        foreach ($web_lang_list as $row) {
            $lang = $row['lang'];
            //语言
            if ($lang != 'en') {
                $path = $path_cn;
            } else {
                $path = $path_en;
            }

            //获取语言对照文件
            $lang_json = file_get_contents($path);
            $lang_data = json_decode($lang_json, true);

            if (is_array($lang_data)) {
                $query = "SELECT `id`,`name` FROM {$_M['table']['language']} WHERE lang = '{$lang}' AND site = '0'";
                $web_lang = DB::get_all($query);

                $old_lang_index = array();
                foreach ($web_lang as $lang_item) {
                    $old_lang_index[] = $lang_item['name'];
                }

                $new_lang_index = array_keys($lang_data);
                $diff_lang_idnex = array_diff($new_lang_index, $old_lang_index);

                foreach ($diff_lang_idnex as $name) {
                    if ($lang_data[$name]['site'] == 0) {
                        self::add_language($lang_data[$name]);
                    }
                }

                //js语言
                $js_word = array('confirm', 'cancel');
                foreach ($js_word as $word) {
                    $sql = "UPDATE {$_M['table']['language']} SET app = 1 WHERE name = '{$word}' AND site = 0";
                    DB::query($sql);
                }
            }
        }
    }

    /**
     * 更新后台栏目数据
     */
    public function update_admin_column()
    {
        global $_M;
        $admin_column_list = self::admin_column_list();
        if (is_array($admin_column_list)) {
            //清空老数据表
            ##$query = "TRUNCATE TABLE {$_M['table']['admin_column']} ";
            $query = "DELETE FROM {$_M['table']['admin_column']} ";
            DB::query($query);

            foreach ($admin_column_list as $row) {
                $sql = get_sql($row);
                $query = "INSERT INTO {$_M['table']['admin_column']} SET {$sql}";
                DB::query($query);
            }
        }
    }

    /**
     * @return array
     */
    protected function admin_column_list()
    {
        global $_M;
        $list = array(
            0 =>
                array(
                    'id' => '1',
                    'name' => 'lang_administration',
                    'url' => 'manage',
                    'bigclass' => '0',
                    'field' => '1301',
                    'type' => '1',
                    'list_order' => '0',
                    'icon' => 'manage',
                    'info' => '',
                    'display' => '1',
                ),
            1 =>
                array(
                    'id' => '2',
                    'name' => 'lang_htmColumn',
                    'url' => 'column',
                    'bigclass' => '0',
                    'field' => '1201',
                    'type' => '1',
                    'list_order' => '1',
                    'icon' => 'column',
                    'info' => '',
                    'display' => '1',
                ),
            2 =>
                array(
                    'id' => '3',
                    'name' => 'lang_feedback_interaction',
                    'url' => '',
                    'bigclass' => '0',
                    'field' => '1202',
                    'type' => '1',
                    'list_order' => '2',
                    'icon' => 'feedback-interaction',
                    'info' => '',
                    'display' => '1',
                ),
            3 =>
                array(
                    'id' => '4',
                    'name' => 'lang_seo_set_v6',
                    'url' => 'seo',
                    'bigclass' => '0',
                    'field' => '1404',
                    'type' => '1',
                    'list_order' => '3',
                    'icon' => 'seo',
                    'info' => '',
                    'display' => '1',
                ),
            4 =>
                array(
                    'id' => '5',
                    'name' => 'lang_appearance',
                    'url' => 'app/met_template',
                    'bigclass' => '0',
                    'field' => '1405',
                    'type' => '1',
                    'list_order' => '4',
                    'icon' => 'template',
                    'info' => '',
                    'display' => '1',
                ),
            5 =>
                array(
                    'id' => '6',
                    'name' => 'lang_myapp',
                    'url' => 'myapp',
                    'bigclass' => '0',
                    'field' => '1505',
                    'type' => '1',
                    'list_order' => '5',
                    'icon' => 'application',
                    'info' => '',
                    'display' => '1',
                ),
            6 =>
                array(
                    'id' => '7',
                    'name' => 'lang_the_user',
                    'url' => '',
                    'bigclass' => '0',
                    'field' => '1506',
                    'type' => '1',
                    'list_order' => '6',
                    'icon' => 'user',
                    'info' => '',
                    'display' => '1',
                ),
            7 =>
                array(
                    'id' => '8',
                    'name' => 'lang_safety',
                    'url' => '',
                    'bigclass' => '0',
                    'field' => '1200',
                    'type' => '1',
                    'list_order' => '7',
                    'icon' => 'safety',
                    'info' => '',
                    'display' => '1',
                ),
            8 =>
                array(
                    'id' => '9',
                    'name' => 'lang_multilingual',
                    'url' => 'language',
                    'bigclass' => '0',
                    'field' => '1002',
                    'type' => '1',
                    'list_order' => '8',
                    'icon' => 'multilingualism',
                    'info' => '',
                    'display' => '1',
                ),
            9 =>
                array(
                    'id' => '10',
                    'name' => 'lang_unitytxt_39',
                    'url' => '',
                    'bigclass' => '0',
                    'field' => '1100',
                    'type' => '1',
                    'list_order' => '9',
                    'icon' => 'setting',
                    'info' => '',
                    'display' => '1',
                ),
            10 =>
                array(
                    'id' => '11',
                    'name' => 'cooperation_platform',
                    'url' => 'partner',
                    'bigclass' => '0',
                    'field' => '1508',
                    'type' => '1',
                    'list_order' => '10',
                    'icon' => 'partner',
                    'info' => '',
                    'display' => '1',
                ),
            11 =>
                array(
                    'id' => '21',
                    'name' => 'lang_mod8',
                    'url' => 'feed_feedback_8',
                    'bigclass' => '3',
                    'field' => '1509',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'feedback',
                    'info' => '',
                    'display' => '1',
                ),
            12 =>
                array(
                    'id' => '22',
                    'name' => 'lang_mod7',
                    'url' => 'feed_message_7',
                    'bigclass' => '3',
                    'field' => '1510',
                    'type' => '2',
                    'list_order' => '1',
                    'icon' => 'message',
                    'info' => '',
                    'display' => '1',
                ),
            13 =>
                array(
                    'id' => '23',
                    'name' => 'lang_mod6',
                    'url' => 'feed_job_6',
                    'bigclass' => '3',
                    'field' => '1511',
                    'type' => '2',
                    'list_order' => '2',
                    'icon' => 'recruit',
                    'info' => '',
                    'display' => '1',
                ),
            14 =>
                array(
                    'id' => '24',
                    'name' => 'lang_customerService',
                    'url' => 'online',
                    'bigclass' => '3',
                    'field' => '1106',
                    'type' => '2',
                    'list_order' => '3',
                    'icon' => 'online',
                    'info' => '',
                    'display' => '1',
                ),
            15 =>
                array(
                    'id' => '25',
                    'name' => 'lang_indexlink',
                    'url' => 'link',
                    'bigclass' => '4',
                    'field' => '1406',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'link',
                    'info' => '',
                    'display' => '0',
                ),
            16 =>
                array(
                    'id' => '26',
                    'name' => 'lang_member',
                    'url' => 'user',
                    'bigclass' => '7',
                    'field' => '1601',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'member',
                    'info' => '',
                    'display' => '1',
                ),
            17 =>
                array(
                    'id' => '27',
                    'name' => 'lang_managertyp2',
                    'url' => 'admin/user',
                    'bigclass' => '7',
                    'field' => '1603',
                    'type' => '2',
                    'list_order' => '1',
                    'icon' => 'administrator',
                    'info' => '',
                    'display' => '1',
                ),
            18 =>
                array(
                    'id' => '28',
                    'name' => 'lang_safety_efficiency',
                    'url' => 'safe',
                    'bigclass' => '8',
                    'field' => '1004',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'safe',
                    'info' => '',
                    'display' => '1',
                ),
            19 =>
                array(
                    'id' => '29',
                    'name' => 'lang_data_processing',
                    'url' => 'databack',
                    'bigclass' => '8',
                    'field' => '1005',
                    'type' => '2',
                    'list_order' => '1',
                    'icon' => 'databack',
                    'info' => '',
                    'display' => '1',
                ),
            20 =>
                array(
                    'id' => '30',
                    'name' => 'lang_upfiletips7',
                    'url' => 'webset',
                    'bigclass' => '10',
                    'field' => '1007',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'information',
                    'info' => '',
                    'display' => '1',
                ),
            21 =>
                array(
                    'id' => '31',
                    'name' => 'lang_indexpic',
                    'url' => 'imgmanage',
                    'bigclass' => '10',
                    'field' => '1003',
                    'type' => '2',
                    'list_order' => '1',
                    'icon' => 'picture',
                    'info' => '',
                    'display' => '1',
                ),
            22 =>
                array(
                    'id' => '32',
                    'name' => 'lang_banner_manage',
                    'url' => 'banner',
                    'bigclass' => '10',
                    'field' => '1604',
                    'type' => '2',
                    'list_order' => '2',
                    'icon' => 'banner',
                    'info' => '',
                    'display' => '1',
                ),
            23 =>
                array(
                    'id' => '33',
                    'name' => 'lang_the_menu',
                    'url' => 'menu',
                    'bigclass' => '10',
                    'field' => '1605',
                    'type' => '2',
                    'list_order' => '3',
                    'icon' => 'bottom-menu',
                    'info' => '',
                    'display' => '1',
                ),
            24 =>
                array(
                    'id' => '34',
                    'name' => 'lang_checkupdate',
                    'url' => 'update',
                    'bigclass' => '37',
                    'field' => '1104',
                    'type' => '2',
                    'list_order' => '4',
                    'icon' => 'update',
                    'info' => '',
                    'display' => '0',
                ),
            25 =>
                array(
                    'id' => '35',
                    'name' => 'lang_appinstall',
                    'url' => 'appinstall',
                    'bigclass' => '6',
                    'field' => '1800',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'appinstall',
                    'info' => '',
                    'display' => '0',
                ),
            26 =>
                array(
                    'id' => '36',
                    'name' => 'lang_dlapptips6',
                    'url' => 'appuninstall',
                    'bigclass' => '6',
                    'field' => '1801',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'appuninstall',
                    'info' => '',
                    'display' => '0',
                ),
            27 =>
                array(
                    'id' => '37',
                    'name' => 'lang_top_menu',
                    'url' => 'top_menu',
                    'bigclass' => '0',
                    'field' => '1900',
                    'type' => '1',
                    'list_order' => '0',
                    'icon' => 'top_menu',
                    'info' => '',
                    'display' => '0',
                ),
            28 =>
                array(
                    'id' => '38',
                    'name' => 'lang_clearCache',
                    'url' => 'clear_cache',
                    'bigclass' => '37',
                    'field' => '1901',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'clear_cache',
                    'info' => '',
                    'display' => '0',
                ),
            29 =>
                array(
                    'id' => '39',
                    'name' => 'lang_funcCollection',
                    'url' => 'function_complete',
                    'bigclass' => '37',
                    'field' => '1902',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'function_complete',
                    'info' => '',
                    'display' => '0',
                ),
            30 =>
                array(
                    'id' => '40',
                    'name' => 'lang_environmental_test',
                    'url' => 'environmental_test',
                    'bigclass' => '37',
                    'field' => '1903',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'environmental_test',
                    'info' => '',
                    'display' => '0',
                ),
            31 =>
                array(
                    'id' => '41',
                    'name' => 'lang_navSetting',
                    'url' => 'navSetting',
                    'bigclass' => '6',
                    'field' => '1904',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'navSetting',
                    'info' => '',
                    'display' => '0',
                ),
            32 =>
                array(
                    'id' => '42',
                    'name' => 'lang_style_settings',
                    'url' => 'style_settings',
                    'bigclass' => '5',
                    'field' => '1905',
                    'type' => '2',
                    'list_order' => '0',
                    'icon' => 'style_settings',
                    'info' => '',
                    'display' => '0',
                ),
        );
        return $list;
    }

    /**
     * 更新applist
     */
    public function update_app_list()
    {
        global $_M;
        $query = "UPDATE {$_M['table']['applist']} SET display = '1' WHERE no = '50002'";
        DB::query($query);
    }

    /**
     * 更新系统配置
     */
    public function add_config()
    {
        global $_M;
        foreach (array_keys($_M['langlist']['web']) as $lang) {
            //shearch
            self::update_config('global_search_range', 'all', 0, $lang);
            self::update_config('global_search_type', '0', 0, $lang);
            self::update_config('global_search_module', '2', 0, $lang);
            self::update_config('global_search_column', '3', 0, $lang);
            self::update_config('global_search_weight', '1|2|3|4|5|6', 0, $lang);
            self::update_config('column_search_range', 'parent', 0, $lang);
            self::update_config('column_search_type', '0', 0, $lang);
            self::update_config('advanced_search_range', 'all', 0, $lang);
            self::update_config('advanced_search_type', '1', 0, $lang);
            self::update_config('advanced_search_column', '3', 0, $lang);
            self::update_config('advanced_search_linkage', '1', 0, $lang);
            //tags
            self::update_config('tag_show_range', '0', 0, $lang);
            self::update_config('tag_show_number', '4', 0, $lang);
            self::update_config('tag_search_type', 'module', 0, $lang);
            //logs
            self::update_config('met_logs', '0', 0, $lang);
            //logo
            self::update_config('met_logo_keyword', "{$_M['config']['met_webname']}", 0, $lang);
            //user
            self::update_config('met_login_box_position', '', 0, $lang);
            //safe
            self::update_config('access_type', '1', 0, $lang);
            self::update_config('met_auto_play_pc', '0', 0, $lang);
            self::update_config('met_auto_play_mobile', '0', 0, $lang);
            //member
            self::update_config('met_weixin_gz_token', '', 0, $lang);
            self::update_config('met_auto_register', '', 0, $lang);
            self::update_config('met_member_agreement', '', 0, $lang);
            self::update_config('met_member_agreement_content', '', 0, $lang);
            self::update_config('met_member_bg_range', '', 0, $lang);
            self::update_config('met_login_box_position', '', 0, $lang);
            self::update_config('met_new_registe_email_notice', '', 0, $lang);
            self::update_config('met_to_admin_email', '', 0, $lang);
            self::update_config('met_new_registe_sms_notice', '', 0, $lang);
            self::update_config('met_to_admin_sms', '', 0, $lang);
            //webset
            self::update_config('met_icp_info', '', 0, $lang);

            if ($lang == 'cn') {
                self::update_config('met_data_null', '没有找到数据', 0, $lang);
                self::update_config('met_404content', '404错误，页面不见了。。。', 0, $lang);
            } else {
                self::update_config('met_404content', '404 error, the page is gone. . .', 0, $lang);
                self::update_config('met_data_null', 'The page is gone', 0, $lang);
            }
        }

        //global
        self::update_config('met_api', 'https://u.mituo.cn/api/client', 0, 'metinfo');
        self::update_config('met_301jump', '0', 0, 'metinfo');
        self::update_config('disable_cssjs', '0', 0, 'metinfo');
        self::update_config('met_uiset_guide', '1', 0, 'metinfo');
        self::update_config('met_copyright_nofollow', '1', 0, 'metinfo');
        self::update_config('met_https', '0', 0, 'metinfo');
        self::update_config('met_copyright_type', '0', 0, 'metinfo');
        self::update_config('met_agents_copyright_foot1', '本站基于 <b><a href=https://www.metinfo.cn target=_blank title=CMS>米拓企业建站系统搭建 $metcms_v</a></b> &copy;2008-$m_now_year', 0, 'metinfo');
        self::update_config('met_agents_copyright_foot2', '技术支持：<b><a href=https://www.mituo.cn target=_blank title=CMS>米拓建站 $metcms_v</a></b> &copy;2008-$m_now_year', 0, 'metinfo');
        //global-agents
        self::update_config('met_agents_type', '1', 0, 'metinfo');
        self::update_config('met_agents_pageset_logo', '1', 0, 'metinfo');
        self::update_config('met_agents_update', '1', 0, 'metinfo');
        self::update_config('met_agents_linkurl', '', 0, 'metinfo');
        //fonts
        self::update_config('met_text_fonts', '../public/fonts/Cantarell-Regular.ttf', 0, 'metinfo');
    }

    /**
     * 配置变更
     */
    public function motify_config()
    {
        global $_M;
        //met_agents_type 前台版权标识
        $query = "SELECT * FROM {$_M['table']['config']} WHERE name='met_agents_type' AND lang = 'metinfo' ORDER BY ID DESC";
        $met_agents_type = DB::get_one($query);
        $query = "DELETE FROM {$_M['table']['config']} WHERE name='met_agents_type' AND lang = 'metinfo'";
        DB::query($query);

        if (!$met_agents_type || $met_agents_type['value'] == '0') {
            self::update_config('met_agents_type', '1', 0, 'metinfo');
        } elseif ($met_agents_type['value'] == '2') {
            self::update_config('met_agents_type', '0', 0, 'metinfo');
        } else {
            self::update_config('met_agents_type', '1', 0, 'metinfo');
        }

        //met_agents_logo_login 后台登陆logo
        $query = "SELECT * FROM {$_M['table']['config']} WHERE name='met_agents_logo_login' AND lang = 'metinfo' ORDER BY ID DESC";
        $met_agents_logo_login = DB::get_one($query);
        if (!$met_agents_logo_login || !strstr($met_agents_logo_login['value'], 'upload')) {
            self::update_config('met_agents_logo_login', '../public/images/login-logo.png', 0, 'metinfo');
        }

        //met_agents_logo_index 后台logo
        $query = "SELECT * FROM {$_M['table']['config']} WHERE name='met_agents_logo_index' AND lang = 'metinfo' ORDER BY ID DESC";
        $met_agents_logo_index = DB::get_one($query);
        if (!$met_agents_logo_index || !strstr($met_agents_logo_index['value'], 'upload')) {
            self::update_config('met_agents_logo_index', '../public/images/logo.png', 0, 'metinfo');
        }

        //调用字体文件
        $query = "DELETE FROM {$_M['table']['config']} WHERE name='met_text_fonts'";
        DB::query($query);
        self::update_config('met_text_fonts', '../public/fonts/Cantarell-Regular.ttf', 0, 'metinfo');
    }

    /**
     * tags数据迁移
     */
    public function update_tags()
    {
        global $_M;

        $tags = load::sys_class('label', 'new')->get('tags');
        $modules = array(2 => 'news', 3 => 'product', 4 => 'download', 5 => 'img');
        foreach ($modules as $mod => $table) {
            $query = "SELECT * FROM {$_M['table'][$table]} WHERE tag != '' AND tag IS NOT NULL AND recycle = 0";
            $list = DB::get_all($query);
            foreach ($list as $v) {
                if (!trim($v['tag'])) {
                    continue;
                }
                $tagStr = $v['tag'];
                $_M['lang'] = $v['lang'];
                $tags->updateTags($tagStr, $mod, $v['class1'], $v['id'], 1);
            }
        }
    }

    /*****************************商城及支付接口应用更新******************************/
    public function check_shop()
    {
        global $_M;
        if (!file_exists(PATH_WEB . 'app/app/shop')) {
            $query = "DELETE FROM {$_M['table']['applist']} WHERE no = 10043";
            DB::query($query);

            $query = "DELETE FROM {$_M['table']['app_config']} WHERE appno = 10043";
            DB::query($query);

            $query = "DELETE FROM {$_M['table']['app_plugin']} WHERE no = 10043";
            DB::query($query);
        } else {
            $file = PATH_WEB . 'app/app/shop/admin/install.class.php';
            if (file_exists($file)) {
                include $file;
                $install = new install();
                if (method_exists($install, 'appcheke')) {
                    $install->appcheke();
                }
            }
        }

        /*if (!file_exists(PATH_WEB . 'app/system/pay')) {
            $query = "DELETE FROM {$_M['table']['applist']} WHERE no = 10080";
            DB::query($query);
            $query = "DELETE FROM {$_M['table']['app_config']} WHERE appno = 10080";
            DB::query($query);
            $query = "DELETE FROM {$_M['table']['pay_config']}";
            DB::query($query);
        } else {
            $file = PATH_WEB . 'app/system/pay/admin/install.class.php';
            if (file_exists($file)) {
                include $file;
                $install = new install();
                if (method_exists($install, 'appcheke')) {
                    $install->appcheke();
                }
            }
        }*/
    }

    /*****************************工具方法******************************/
    /**
     * 更新配置
     * @param $name
     * @param $value
     * @param $cid
     * @param $lang
     */
    private function update_config($name, $value, $cid, $lang)
    {
        global $_M;
        $query = "SELECT id FROM {$_M['table']['config']} WHERE  name='{$name}' AND lang = '{$lang}'";
        $config = DB::get_one($query);
        if (!$config) {
            $query = "INSERT INTO {$_M['table']['config']} (name,value,mobile_value,columnid,flashid,lang)VALUES ('{$name}', '{$value}', '', '{$cid}', '0', '{$lang}')";
            DB::query($query);
        } else {
            $query = "UPDATE {$_M['table']['config']} SET name = '{$name}',value = '{$value}', columnid = '{$cid}' ,lang = '{$lang}' WHERE id = '{$config['id']}'";
            DB::query($query);
        }
    }

    /**
     * 更新 插入语言
     * @param array $lang_data
     */
    private function add_language($lang_data = array())
    {
        global $_M;
        $name = $lang_data['name'];
        $value = $lang_data['value'];
        $site = $lang_data['site'];
        $lang = $lang_data['lang'];
        $js = $lang_data['array'] ? 1 : 0;
        $app = $lang_data['app'];

        if ($site == 1) {
            $query = "INSERT INTO {$_M['table']['language']} (id, name, value, site, no_order, array, app, lang) VALUES (null, '{$name}', '{$value}', {$site}, 0, '{$js}', {$app}, '{$lang}');";
            $res = DB::query($query);
        }

        if ($site == 0) {
            $query = "INSERT INTO {$_M['table']['language']} (id, name, value, site, no_order, array, app, lang) VALUES (null, '{$name}', '{$value}', {$site}, 0, '{$js}', {$app}, '{$lang}');";
            $res = DB::query($query);
        }
        return;
    }

    /**
     * 获取sql
     * @param $data
     * @return string
     */
    public function get_sql($data)
    {
        global $_M;
        $sql = "";
        foreach ($data as $key => $value) {
            if (strstr($value, "'")) {
                $value = str_replace("'", "\'", $value);
            }
            $sql .= " {$key} = '{$value}',";
        }
        return trim($sql, ',');
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
