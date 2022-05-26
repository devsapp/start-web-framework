<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
load::sys_class('admin');
load::sys_func('file');

//load::module()
class index extends admin
{
    protected $ver_allow;

    public function __construct()
    {
        global $_M, $adminurl;
        parent::__construct();
        $adminfile = $_M['config']['met_adminfile'];
        define('ADMIN_FILE', $adminfile);
        $this->ver_allow = '7.0.0';
    }

    public function doindex()
    {
        global $_M;
    }

    /*******************备份操作数据********************/
    /*数据库备份*/
    public function dopackdata()
    {
        global $_M;
        $this->dogetsql();
    }

    /*获取sql文件*/
    public function dogetsql()
    {
        global $_M;
        $tableid = isset($_M['form']['tableid']) ? $_M['form']['tableid'] : 0;
        $startfrom = isset($_M['form']['startfrom']) ? intval($_M['form']['startfrom']) : 0;
        $fileid = isset($_M['form']['fileid']) ? $_M['form']['fileid'] : 1;
        $allfile = isset($_M['form']['allfile']) ? $_M['form']['allfile'] : 0;
        $random = isset($_M['form']['random']) ? $_M['form']['random'] : random(6);
        $piece = isset($_M['form']['piece']) ? $_M['form']['piece'] : 0;
        //$tables     = isset($_M['form']['tables']) ? $_M['form']['tables'] : '';
        $localurl = $_M['config']['met_weburl'];
        $tablepre = $_M['config']['tablepre'];

        //if (!$tables) {
        $tables = self::getTableList($tablepre);
        //}

        $sizelimit = 2048;
        $sqldump = '';
        $tablenumber = count($tables);
        for ($i = $tableid - 1; $i < $tablenumber && strlen($sqldump) < $sizelimit * 1000; ++$i) {
            $sqldump .= $this->dosql_dumptable($tables[$i], $startfrom, strlen($sqldump));
            $startfrom = 0;
        }

        //生成.sql文件
        if (trim($sqldump)) {
            $version = 'version:' . $_M['config']['metcms_v'];
            $sqldump = "#MetInfo.cn Created {$version} \n#$localurl\n#$tablepre\n# --------------------------------------------------------\n\n\n" . $sqldump;
            $tableid = $i;
            $db_settings = parse_ini_file(PATH_CONFIG . 'config_db.php');
            //@extract($db_settings);
            $con_db_name = $db_settings['con_db_name'];
            $filename = $con_db_name . '_' . date('Ymd') . '_' . $random . '_' . $fileid . '.sql';
            ++$fileid;

            $backup = PATH_WEB . ADMIN_FILE . '/databack/';
            if (!file_exists($backup)) {
                mkdir($backup, 0777, true);
            }
            $bakfile = $backup . $filename;

            if (!is_writable($backup)) {
                turnover("{$_M['url']['own_form']}a=doindex", $_M['word']['setdbTip2'] . 'databack/' . $_M['word']['setdbTip3']);
            }
            file_put_contents($bakfile, $sqldump);

            if (!file_exists(PATH_WEB . ADMIN_FILE . 'databack/sql')) {
                @mkdir(PATH_WEB . ADMIN_FILE . '/databack/sql', 0777);
            }
        }

        if (trim($sqldump)) {//数据分卷
            $piece++;
            $redata = array();
            $url = "n=databack&c=index&a=dogetsql&lang={$_M['lang']}&tableid={$tableid}&fileid={$fileid}&startfrom={$this->startrow}&random={$random}&allfile={$allfile}&piece={$piece}";
            $redata['status'] = 2;
            $redata['call_back'] = $url;
            $redata['piece'] = $piece;
            $this->ajaxReturn($redata);
        }
        if ($allfile == 1) {//整站备份跳转
            $redata = array();
            $url = "n=databack&c=index&a=doallfile&lang={$_M['lang']}&sqldata=1";
            $redata['call_back'] = $url;
            $redata['status'] = 2;
            $this->ajaxReturn($redata);
        }
        //写日志
        logs::addAdminLog('dataexplain10', 'dataexplain10', 'setdbBackupOK', 'dopackdata');
        $redata = array();
        $redata['status'] = 1;
        $redata['piece'] = $piece;
        $redata['msg'] = $_M['word']['setdbBackupOK'];
        $this->ajaxReturn($redata);
    }

    /**
     * 生成数据表备份语句.
     *
     * @param $table         表名
     * @param int $startfrom 起始偏移
     * @param int $currsize 字符串长度
     *
     * @return string
     */
    public function dosql_dumptable($table = '', $startfrom = 0, $currsize = 0)
    {
        global $_M;
        if (!$table) {
            return;
        }
        $sizelimit = 2048;

        if (!isset($tabledump)) {
            $tabledump = '';
        }

        if (!$startfrom) {
            //生成创表语句
            $tabledump = "DROP TABLE IF EXISTS $table;\n";
            if ($_M['config']['db_type'] == 'mysql') {
                $createtable = DB::query("SHOW CREATE TABLE $table");
                $create = DB::fetch_row($createtable);
                $tabledump .= str_replace(strtolower($table), $table, $create[1]) . ";\n\n";
            } else {
                $res = DB::$link->query("PRAGMA table_info(${table})");
                $tabledump .= "CREATE TABLE `{$table}` (\n";
                while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
                    if ($row['name'] == 'id') {
                        $tabledump .= "`id` int(11) unsigned NOT NULL AUTO_INCREMENT,\n";
                        continue;
                    }
                    $type = str_replace('text(', 'varchar(', $row['type']);
                    $type = str_replace('integer(', 'int(', $type);
                    $notnull = $row['notnull'] ? '' : 'NOT NULL';
                    $default = $row['dflt_value'] == 'NULL' ? '' : "DEFAULT {$row['dflt_value']}";
                    if (trim($default) == 'DEFAULT') {
                        $default = '';
                    }
                    $tabledump .= "`{$row['name']}` {$type} {$notnull} {$default},\n";
                }
                $tabledump .= "PRIMARY KEY (`id`)\n";
                $tabledump .= ") ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;\n";
                $res->finalize();
            }
        }
        //剔除不备份的数据表
        $exclude = array(
            $_M['config']['tablepre'] . 'visit_day',
            $_M['config']['tablepre'] . 'visit_detail',
            $_M['config']['tablepre'] . 'visit_summary',
        );

        if (in_array($table, $exclude)) {
            return $tabledump;
        }

        $offset = 100;
        $numrows = $offset;

        while ($currsize + strlen($tabledump) < $sizelimit * 1000 && $numrows == $offset) {
            $rows = DB::query("SELECT * FROM {$table} LIMIT {$startfrom}, $offset");
            $numfields = DB::num_fields($rows);
            $numrows = DB::num_rows($rows);
            /*if ($numrows <= 0) {
                return;
            }*/
            while ($row = DB::fetch_row($rows)) {
                $comma = '';
                $tabledump .= "INSERT INTO $table VALUES(";
                for ($i = 0; $i < $numfields; ++$i) {
                    //剔除系统商城登录信息
                    if ($row[1] == 'met_secret_key') {
                        $row[2] = '';
                    }
                    //转义sql特殊字符
                    $tabledump .= $comma . "'" . DB::escapeString(DB::$link, $row[$i]) . "'";
                    $comma = ',';
                }

                $tabledump .= ");\n";
            }
            $startfrom = $startfrom + $offset;
        }

        $this->startrow = $startfrom;

        $tabledump .= "\n";

        return $tabledump;
    }

    /*获取所有数据表*/
    public function getTableList($tablepre = '')
    {
        global $_M;
        $mettables = explode('|', $_M['config']['met_tablename']);
        $i = 0;
        $mettables = array_unique($mettables);
        foreach ($mettables as $key => $val) {
            $tables[$i] = $tablepre . $val;
            ++$i;
        }

        return $tables;
    }

    /*删除数据库缓存文件*/
    public function cache_delete($file)
    {
        if (!$file) {
            global $_M;

            return @unlink(PATH_WEB . ADMIN_FILE . '/databack/' . $file);
        }

        return;
    }

    /*备份上传文件*/
    public function dopackupload()
    {
        global $_M;
        $redata = array();
        $upload_path = PATH_WEB . 'upload';
        $upload_back_path = PATH_WEB . ADMIN_FILE . '/databack/upload/';
        $zipname = $upload_back_path . $_M['config']['met_agents_backup'] . '_upload_' . date('YmdHis', time()) . '.zip';

        makedir($upload_back_path);

        //磁盘空间检测
        $file_total = file_size($upload_path);      //文件总大小
        $disk_total = self::checkDisk();            //磁盘可用空间

        if ($file_total > $disk_total) {
            //写日志
            logs::addAdminLog('databackup6', 'databackup1', 'setBackuoDiskFull', 'dopackupload');
            $this->error('磁盘空间不足');
        }

        $zip = new ZipArchive();
        $zip->open($zipname, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
        self::file_zip($zip, $upload_path, '');
        $zip->close();

        if (file_exists($zipname)) {
            //写日志
            logs::addAdminLog('databackup6', 'databackup6', 'setdbArchiveOK', 'dopackupload');

            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['setdbArchiveOK'];
            $this->ajaxReturn($redata);
        } else {
            //写日志
            logs::addAdminLog('databackup6', 'databackup6', 'setBackuoNo', 'dopackupload');

            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['setdbArchiveNo'];
            $redata['error'] = 'error';
            $this->ajaxReturn($redata);
        }
    }

    /*整站备份*/
    public function doallfile()
    {
        global $_M;
        if (!isset($_M['form']['sqldata'])) {
            //数据备份
            $_M['form']['allfile'] = 1;
            $this->dogetsql();
        }

        $db_settings = parse_ini_file(PATH_CONFIG . 'config_db.php');
        $con_db_name = $db_settings['con_db_name'];
        $web_back_path = PATH_WEB . ADMIN_FILE . '/databack/web';
        $web_zip = $web_back_path . '/' . $_M['config']['met_agents_backup'] . '_web_' . $con_db_name . '_' . date('YmdHis', time()) . '_' . random(6) . '.zip';
        makedir($web_back_path);

        //磁盘空间检测
        $file_total = file_size(PATH_WEB); //文件总大小
        $disk_total = self::checkDisk();            //磁盘可用空间
        if ($file_total > $disk_total) {
            //写日志
            logs::addAdminLog('databackup7', 'databackup7', 'setBackuoDiskFull', 'doallfile');
            $this->error('磁盘空间不足');
        }

        //创建整站压缩包
        $skip_list = scan_dir($web_back_path);
        //dd($skip_list);

        //$web_path = PATH_WEB;
        $web_path = substr(PATH_WEB, 0, -1);
        $zip = new ZipArchive();
        $zip->open($web_zip, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
        self:: file_zip($zip, $web_path, '', $skip_list);
        $zip->close();

        if (file_exists($web_zip)) {
            //写日志
            logs::addAdminLog('databackup7', 'databackup7', 'setdbArchiveOK', 'doallfile');

            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['setdbArchiveOK'];
            $this->ajaxReturn($redata);
        } else {
            //写日志
            logs::addAdminLog('databackup7', 'databackup7', 'setBackuoNo', 'doallfile');

            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['setdbArchiveNo'];
            $redata['error'] = 'error';
            $this->ajaxReturn($redata);
        }
    }

    /**
     * @param $zip
     * @param string $dir
     * @param string $skip_path
     * @param array $skip_list
     */
    public function file_zip($zip , $dir = '', $skip = '' , $skip_list = array())
    {
        global $_M;
        if (!$skip) {
            $skip = PATH_WEB;
        }

        if (strstr(strtoupper(PHP_OS), 'WIN')) {
            $skip = str_replace("\\", '/', $skip);
            $dir = str_replace("\\", '/', $dir);
        }

        $handler = opendir($dir);
        while (($filename = readdir($handler)) !== false) {
            if ($filename != "." && $filename != "..") {
                if (is_dir($dir . "/" . $filename)) {
                    //$zip->addEmptyDir($dir . '/' . $filename);
                    if ($skip != $dir . '/' . $filename) {
                        $new_dir = str_replace($skip, '', $dir . '/' . $filename);
                        $zip->addEmptyDir($new_dir);
                    }
                    self::file_zip($zip, $dir . "/" . $filename, $skip, $skip_list);
                } else {
                    //忽略文件列表
                    if (!in_array(str_replace($skip, '', $dir . '/' . $filename), $skip_list)) {
                        $zip->addFile($dir . "/" . $filename, str_replace($skip, '', $dir . '/' . $filename));
                    }
                }
            }
        }
        @closedir($handler);
    }

    /**
     * 获取磁盘信息
     * @return int
     */
    public function checkDisk()
    {
        $disk_total = byte_format(disk_free_space('.'), 2, "mb");
        return $disk_total;

    }

    /*******************备份操作********************/

    /*******************数据恢复********************/

    /**
     * 恢复数据列表.
     */
    public function dorecovery()
    {
        global $_M, $adminurl;
        $infos = $this->dogetfileattr();
        $zips = $this->dogetfilefix();

        $list = array_merge($infos, $zips);
        $new_list = array();
        foreach ($list as $row) {
            $new_list[] = $row;
        }
        $this->ajaxReturn($new_list);
    }

    /**
     * 获取备份数据文件属性.
     *
     * @return array
     */
    public function dogetfileattr()
    {
        global $_M;
        $sqlfiles = glob(PATH_WEB . ADMIN_FILE . '/databack/*.sql');
        if (is_array($sqlfiles)) {
            $prepre = '';
            $info = $infos = array();
            foreach ($sqlfiles as $id => $sqlfile) {
                preg_match("/(.*_)([0-9]+)\.sql/i", basename($sqlfile), $num);
                $info['filename'] = basename($sqlfile);
                $info['filesize'] = round(filesize($sqlfile) / (1024 * 1024), 2);
                $info['maketime'] = date('Y-m-d H:i:s', filemtime($sqlfile));
                $info['pre'] = $num[1];
                $info['number'] = $num[2];
                $info['type'] = 'sql';
                $info['typename'] = $_M['word']['database'];
                $info['time'] = strtotime($info['maketime']);

                if (!$id) {
                    $prebgcolor = '#E4EDF9';
                }
                if ($info['pre'] == $prepre) {
                    $info['bgcolor'] = $prebgcolor;
                } else {
                    $info['bgcolor'] = $prebgcolor == '#E4EDF9' ? '#F1F3F5' : '#E4EDF9';
                }
                $prebgcolor = $info['bgcolor'];
                $prepre = $info['pre'];
                $infos1[] = $info;
            }
        }

        foreach ($infos1 as $key => $val) {
            if ($val['number'] == 1) {
                $infos2[$val['pre']] = $val;
            } else {
                //分包文件
                $infos3[] = $val;
            }
        }

        foreach ($infos3 as $key => $val) {
            //统计分包文件信息
            ++$infos2[$val['pre']]['number'];
            $infos2[$val['pre']]['filesize'] += $val['filesize'];
        }
        $infos = $this->array_sort($infos2, 'time', 'we');

        foreach ($infos as $key => $val) {
            $infos[$key]['filename'] = $key . '1';
            $infos[$key]['error'] = '0';
            $infos[$key]['error_info'] = '';

            //检测本份数据系统版本
            $fp = @fopen(PATH_WEB . ADMIN_FILE . '/databack/' . $val['filename'], 'rb');
            $str = @fgets($fp);
            @fclose($fp);
            $import_version = trim(str_replace('#MetInfo.cn Created version:', '', $str));
            $infos[$key]['ver'] = $import_version;

            //检测导入数据版本
            if (version_compare($import_version, $this->ver_allow, '<')) {
                $infos[$key]['error'] = '2';
                $infos[$key]['error_info'] = $_M['word']['unitytxt_6'];
            }

            //检测备份文件数目
            $info_num = 1;
            while (file_exists(PATH_WEB . ADMIN_FILE . '/databack/' . $key . $info_num . '.sql')) {
                ++$info_num;
            }
            if ($info_num - 1 != $val['number']) {
                $infos[$key]['error'] = '1';
                $infos[$key]['error_info'] = $_M['word']['setdbLack'];
            }

            //是否可以导入数据
            if ($infos[$key]['error'] == 0) {
                //$infos[$key]['import_url']  = "{$_M['url']['own_form']}a=doimport&pre={$val['filename']}";
                $infos[$key]['import_url'] = "{$_M['url']['own_form']}a=doimport&pre={$val['pre']}";
            }
            $infos[$key]['del_url'] = "{$_M['url']['own_form']}a=dodelete&filenames={$val['pre']}";
            $infos[$key]['download_url'] = "{$_M['url']['own_form']}a=dodownload&file={$val['pre']}&type={$info['type']}";
        }

        return $infos;
    }

    /*获取备份文件数据*/
    public function dogetfilefix()
    {
        global $_M;
        /*upload files*/
        $sqlfiles = glob(PATH_WEB . ADMIN_FILE . '/databack/upload/*.zip');
        if (is_array($sqlfiles)) {
            $prepre = '';
            $info = $infos = array();
            foreach ($sqlfiles as $id => $sqlfile) {
                preg_match("/([a-z0-9_]+_[0-9]{8}_[0-9a-z]{4}_)([0-9]+)\.zip/i", basename($sqlfile), $num);
                $info['filename'] = basename($sqlfile);
                $info['filesize'] = round(filesize($sqlfile) / (1024 * 1024), 2);
                $info['maketime'] = date('Y-m-d H:i:s', filemtime($sqlfile));
                $info['pre'] = $num[1];
                $info['number'] = $num[2];
                $info['type'] = 'upload';
                $info['time'] = strtotime($num['maketime']);
                $info['typename'] = $_M['word']['uploadfile'];
                $info['unzip_url'] = "{$_M['url']['own_form']}a=dounzip_upload&file={$info['filename']}";
                $info['del_url'] = "{$_M['url']['own_form']}a=dodelete_zip&file={$info['filename']}&type={$info['type']}";
                $info['download_url'] = "{$_M['url']['own_form']}a=dodownload&file={$info['filename']}&type={$info['type']}";

                if (!$id) {
                    $prebgcolor = '#E4EDF9';
                }
                if ($info['pre'] == $prepre) {
                    $info['bgcolor'] = $prebgcolor;
                } else {
                    $info['bgcolor'] = $prebgcolor == '#E4EDF9' ? '#F1F3F5' : '#E4EDF9';
                }

                $infoupload[] = $info;
                $metinfodata[] = $info;
            }
        }

        /*web files*/
        $sqlfiles = glob(PATH_WEB . ADMIN_FILE . '/databack/web/*.zip');
        if (is_array($sqlfiles)) {
            $prepre = '';
            $info = $infos = array();
            foreach ($sqlfiles as $id => $sqlfile) {
                preg_match("/([a-z0-9_]+_[0-9]{8}_[0-9a-z]{4}_)([0-9]+)\.zip/i", basename($sqlfile), $num);
                $info['filename'] = basename($sqlfile);
                $info['filesize'] = round(filesize($sqlfile) / (1024 * 1024), 2);
                $info['maketime'] = date('Y-m-d H:i:s', filemtime($sqlfile));
                $info['pre'] = $num[1];
                $info['number'] = $num[2];
                $info['time'] = strtotime($num['maketime']);
                $info['typename'] = $_M['word']['webcompre'];
                $info['type'] = 'web';
                $info['del_url'] = "{$_M['url']['own_form']}a=dodelete_zip&file={$info['filename']}&type={$info['type']}";
                $info['download_url'] = "{$_M['url']['own_form']}a=dodownload&file={$info['filename']}&type={$info['type']}";

                if (!$id) {
                    $prebgcolor = '#E4EDF9';
                }
                if ($info['pre'] == $prepre) {
                    $info['bgcolor'] = $prebgcolor;
                } else {
                    $info['bgcolor'] = $prebgcolor == '#E4EDF9' ? '#F1F3F5' : '#E4EDF9';
                }

                $infoweb[] = $info;
                $metinfodata[] = $info;
            }
        }

        $metinfodata = $this->array_sort($metinfodata, 'time', 'we');

        return $metinfodata;
    }

    /*导入数据*/
    public function doimport()
    {
        global $_M;
        $admin = admin_information();
        if (strstr($admin['admin_op'], 'metinfo') === false) {
            $result['status'] = 0;
            $result['msg'] = $_M['word']['jsx38'];
            $this->ajaxReturn($result);
        }

        $pre = $_M['form']['pre'];
        $filename = $pre . '1.sql';
        $filepath = PATH_WEB . ADMIN_FILE . '/databack/' . $filename;

        if (file_exists($filepath)) {
            $sql = file_get_contents($filepath);
            if (stristr($sql, '#MetInfo.cn')) {
                $split = $this->dosql_split($sql);
                $info = $split['info'];
                $infos = explode('#', $info);
                $import_version = trim(str_replace('MetInfo.cn Created version:', '', $infos[1]));

                //检测导入数据版本
                if (version_compare($import_version, $this->ver_allow, '<')) {
                    $this->error($_M['word']['recoveryisntallinfo']);
                }

                // 用户临时数据 applist 语言 生成数据缓存
                $update_database = load::mod_class('update/update_database', 'new');
                $update_database->temp_data();

                $result['status'] = 1;
                //不覆盖管理员账号
                $result['import_1'] = "{$_M['url']['own_form']}a=dosql_execute&pre={$_M['form']['pre']}&admin_rewrite=1&fileid=1";
                //覆盖管理员账号
                $result['import_2'] = "{$_M['url']['own_form']}a=dosql_execute&pre={$_M['form']['pre']}&admin_rewrite=0&fileid=1";
                $this->ajaxReturn($result);
            }
        }

        $this->error($_M['word']['dataerror']);
    }

    public function dosql_execute()
    {
        global $_M;
        $admin = admin_information();
        $transfer = load::mod_class('databack/transfer', 'new');
        if (strstr($admin['admin_op'], 'metinfo') === false) {
            //写日志
            logs::addAdminLog('databackup2', 'setdbImportData', 'jsx38', 'dosql_execute');
            $result['status'] = 0;
            $result['msg'] = $_M['word']['jsx38'];
            $this->ajaxReturn($result);
        }
        if (!$_M['form']['fileid'] || !is_numeric($_M['form']['fileid'])) {
            //写日志
            logs::addAdminLog('databackup2', 'setdbImportData', 'dataerror', 'dosql_execute');
            $result['status'] = 0;
            $result['msg'] = $_M['word']['dataerror'];
            $result['error'] = 'no fileid';
            $this->ajaxReturn($result);
        }

        $fileid = $_M['form']['fileid'];
        $filename = $_M['form']['pre'] . $fileid . '.sql';
        $admin_rewrite = $_M['form']['admin_rewrite'] == '1' ? $_M['form']['admin_rewrite'] : '0';
        $old_version = $_M['form']['old_version'];
        $version = $_M['form']['version'] ? $_M['form']['version'] : $_M['config']['metcms_v'];
        $tablepre = $_M['config']['tablepre'];
        $filepath = PATH_WEB . ADMIN_FILE . '/databack/' . $filename;

        //当备份数据文件存在执行操作
        if (file_exists($filepath)) {
            $sql = file_get_contents($filepath);
            $split = $this->dosql_split($sql);
            $info = $split['info'];
            $sqls = $transfer->getQuery($sql);
            $infos = explode('#', $info);
            if ($infos[1] && !$old_version) {
                $old_version = trim(str_replace('MetInfo.cn Created version:', '', $infos[1]));
            }
            //备份数据文件站点地址
            $old_site = $infos[2];
            $upload_site = $old_site . 'upload';

            $localurl = $_M['config']['met_weburl'];
            if ($infos[3] && $tablepre != $infos[3]) {
                $sqlre1 = 1;
            }
            if ($infos[2] && $localurl != $infos[2]) {
                $sqlre2 = 1;
            }

            if (is_array($sqls)) {
                if ($_M['config']['db_type'] == 'sqlite') {
                    DB::$link->exec('begin;');
                }
                foreach ($sqls as $sql) {
                    //替换表前缀
                    if ($sqlre1 == 1) {
                        $sql = preg_replace(array('/^INSERT INTO ' . $infos[3] . '/', '/^DROP TABLE IF EXISTS ' . $infos[3] . '/', '/^CREATE TABLE `' . $infos[3] . '/'), array('INSERT INTO ' . $tablepre, 'DROP TABLE IF EXISTS ' . $tablepre, 'CREATE TABLE `' . $tablepre), $sql, 1);
                    }

                    //Sqlite 创表语句转换
                    if ($_M['config']['db_type'] == 'sqlite' && stristr($sql, 'CREATE TABLE')) {
                        $sql = $transfer->mysqlToSqlite($sql);
                    }

                    //不更新后台看栏目表
                    if (strstr($sql, $tablepre . 'admin_column')) {
                        continue;
                    }

                    //不更新管理员信息
                    if ($admin_rewrite == '1') {
                        if (strstr($sql, $tablepre . 'admin_table')) {
                            continue;
                        }
                    }

                    //替换资源文件绝对路径
                    $sql = str_replace($upload_site, '../upload', $sql);
                    $sql = trim($sql, ';');
                    if (!$sql) {
                        continue;
                    }
                    $sql .= ';';
                    if ($_M['config']['db_type'] == 'sqlite') {
                        $sql = str_replace("\\'", "''", $sql);
                    }

                    //不允许输出文件
                    if (strstr(strtolower($sql), 'outfile')) {
                        continue;
                    }

                    if ($_M['config']['db_type'] == 'sqlite') {
                        $sql = DB::escapeSqlite($sql);
                        $rs = DB::$link->exec($sql);
                    } else {
                        $res = DB::query($sql);
                    }
                }
                if ($_M['config']['db_type'] == 'sqlite') {
                    DB::$link->exec('commit;');
                }
            }

            ++$fileid;

            //写入管理员登录信息
            $this->dosave_met_cookie();
            //写日志
            logs::addAdminLog('databackup2', 'setdbImportData', 'jsok', 'dosql_execute');
            $redata['status'] = 2;
            $redata['call_url'] = "{$_M['url']['own_form']}a=dosql_execute&pre={$_M['form']['pre']}&admin_rewrite={$admin_rewrite}&fileid={$fileid}&version={$version}&old_version={$old_version}";
            $this->ajaxReturn($redata);
        } else {
            //更新系统版本信息
            $query = "UPDATE {$_M['table']['config']} SET value = '{$version}' WHERE name = 'metcms_v'";
            DB::query($query);

            //导入数据后执行数据迁移操作//  对比导入数据版本和当前版本字段并修复
            $update_database = load::mod_class('update/update_database', 'new');

            //对比数据字段
            $update_database->diff_fields($version);
            //恢复应用列表，secreat_key
            $update_database->recovery_data();
            //剔除不存在的applist记录
            $this->docheckapplsit();
            //恢复栏目文件
            $this->dorecover_column();
            //检测商城应用配置变更
            $update_database->check_shop();

            //非同版本数据迁移
            if ($version != $old_version) {
                //注册数据表
                $update_database->table_regist();
                //更新配置
                $update_database->add_config();

                if (version_compare($old_version, '7.0.0beta', '<')) {//6.1/6.2->7.0.0beta
                    //更改配置
                    $update_database->motify_config();
                    //更新栏目数据
                    $update_database->recovery_column();
                    //表单模块数据迁移
                    $update_database->recovery_form_seting();
                    //迁移客服数据
                    $update_database->recovery_online();
                    //更新友情链接数据
                    $update_database->recovery_link();
                    //更新新闻发布人
                    $update_database->recovery_news();
                    //更新applist
                    $update_database->update_app_list();
                    //tags数据迁移
                    $update_database->update_tags();
                    //更新语言
                    $update_database->update_language($version);
                }
                if (version_compare($old_version, '7.3.0', '<')) {//7.0.0beta->7.1.0
                    //更新语言
                    $update_database->update_language($version);
                }
            }

            //清除缩略图 缓存
            deldir('upload/thumb_src', 1);
            deldir('cache', 1);

            //写日志
            logs::addAdminLog('databackup2', 'setdbImportData', 'setdbImportOK', 'dosql_execute');
            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['setdbImportOK'];
            $this->ajaxReturn($redata);
        }
    }

    /**
     * 写入登录信息.
     */
    public function dosave_met_cookie()
    {
        global $_M;
        $metinfo_admin_name = get_met_cookie('metinfo_admin_name');
        $query = "select * from {$_M['table']['admin_table']} where admin_id='{$metinfo_admin_name}'";
        $user = DB::get_one($query);
        $usercooike = json_decode($user['cookie']);
        foreach ($usercooike as $key => $val) {
            $met_cookie[$key] = $val;
        }
        $met_cookie['time'] = time();
        $json = json_encode($met_cookie);
        $username = $met_cookie['metinfo_admin_id'] ? $met_cookie['metinfo_admin_id'] : $met_cookie['metinfo_member_id'];
        $query = "update {$_M['table']['admin_table']} set cookie='{$json}' where id='{$username}'";
        DB::query($query);
    }

    //解析sql文件
    public function dosql_split($sql)
    {
        global $_M;
        $db_charset = 'utf-8';
        if (DB::version() > '4.1' && $db_charset) {
            $sql = preg_replace('/TYPE=(InnoDB|MyISAM)( DEFAULT CHARSET=[^; ]+)?/', 'TYPE=\\1 DEFAULT CHARSET=' . $db_charset, $sql);
        }

        $sql = str_replace("\r", "\n", $sql);

        $ret = array();
        $num = 0;
        $queriesarray = explode(";\n", trim($sql));

        unset($sql);
        foreach ($queriesarray as $query) {
            $ret['sql'][$num] = '';
            $queries = explode("\n", trim($query));
            $queries = array_filter($queries);

            foreach ($queries as $query) {
                $str1 = substr($query, 0, 1);
                if ($str1 != '#' && $str1 != '-') {
                    $ret['sql'][$num] .= $query;
                } else {
                    $ret['info'] .= $query;
                }
            }
            ++$num;
        }

        return $ret;
    }

    /**
     * 信息数组排序.
     *
     * @param $arr
     * @param $keys
     * @param string $type
     *
     * @return array
     */
    public function array_sort($arr, $keys, $type = 'asc')
    {
        // dump($arr);
        // exit;
        $keysvalue = $new_array = array();
        foreach ($arr as $k => $v) {
            $keysvalue[$k] = $v[$keys];
        }
        if ($type == 'asc') {
            asort($keysvalue);
        } else {
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) {
            $new_array[$k] = $arr[$k];
        }

        return $new_array;
    }

    /*******************数据恢复********************/

    /**
     * 恢复栏目文件.
     */
    public function dorecover_column()
    {
        global $_M;
        $columnclass = load::mod_class('column/column_op', 'new');
        $columnclass->do_recover_column_files();
    }

    /**
     * 不插入app文件不存在的applist记录.
     */
    public function docheckapplsit()
    {
        global $_M;

        $query = "SELECT `m_name`,no FROM {$_M['table']['applist']}";
        $applist = DB::get_all($query);

        foreach ($applist as $app) {
            if ($app['no'] == 10080) {
                if (is_dir(PATH_SYS . 'pay')) {
                    continue;
                }
            }
            if (!is_dir(PATH_WEB . 'app/app/' . $app['m_name'])) {
                $query = "DELETE FROM {$_M['table']['applist']} WHERE `m_name`= '{$app['m_name']}'";
                DB::query($query);
            }
        }
    }

    /*生成zip*/
    public function dodownload()
    {
        global $_M;
        $file = $_M['form']['file'];
        $type = $_M['form']['type'];
        $back_url = $_M['url']['site_admin'] . 'databack/';
        $zip_path = PATH_WEB . ADMIN_FILE . '/databack/sql/';
        $sql_path = PATH_WEB . ADMIN_FILE . '/databack/';
        $sql_zip = $zip_path . $file . '.zip';
        switch ($type) {
            case 'sql':
                $zip_url = $back_url . 'sql/' . $file . '.zip';
                delfile($sql_zip);
                if (!file_exists($zip_path)) {
                    @mkdir($zip_path, 0777);
                }
                $zip = new ZipArchive();
                $status = $zip->open($sql_zip, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
                if (!$status) {
                    turnover("{$_M['url']['own_form']}a=dorecovery", $_M['word']['setdbArchiveNo']);
                }

                $sql_list = glob("{$sql_path}{$file}*.sql");
                foreach ($sql_list as $sql_file) {
                    if (file_exists($sql_file)) {
                        $file_name = basename($sql_file);
                        $zip->addFile($sql_file, $file_name);
                    }
                }
                $zip->close();
                $back_url = $zip_url;
                break;
            case 'upload':
                $back_url .= "upload/{$file}";
                break;
            case 'web':
                $back_url .= "web/{$file}";
                break;
            default:
                $back_url = $_M['url']['site_admin'];
                break;
        }
        //写日志
        logs::addAdminLog('databackup2', 'databackup3', 'jsok', 'dopackupload');
        header('location:' . $back_url);
        die;
    }

    //zip递归添加文件
    public function addFileToZip($path, $zip)
    {
        $handler = opendir($path); //打开当前文件夹由$path指定。
        while (($filename = readdir($handler)) !== false) {
            if ($filename != '.' && $filename != '..') {//文件夹文件名字为'.'和‘..'，不要对他们进行操作
                if (is_dir($path . '/' . $filename)) {// 如果读取的某个对象是文件夹，则递归
                    $zip->addEmptyDir(str_replace(PATH_WEB, 'web/', $path . '/' . $filename));
                    $this->addFileToZip($path . '/' . $filename, $zip);
                } else { //将文件加入zip对象
                    $zip->addFile($path . '/' . $filename, str_replace(PATH_WEB, 'web/', $path . '/' . $filename));
                    //$zip->addFile($path."/".$filename);
                }
            }
        }
        @closedir($path);

        return 1;
    }

    /*********删除文件操作**********/
    /*删除备份文件*/
    public function dodelete()
    {
        global $_M;
        $redata = array();
        if (substr_count(trim($_M['form']['filenames']), '../')) {
            //写日志
            logs::addAdminLog('databackup2', 'delete', 'Error', 'dodelete');

            $redata['status'] = 0;
            $redata['msg'] = 'Error';
            $redata['error'] = 'Error met2';
            $this->ajaxReturn($redata);
            die('met2');
        }

        $prefix = $_M['form']['filenames'];
        $ext = '.sql';

        $sqlfiles = glob(PATH_WEB . ADMIN_FILE . '/databack/*' . $ext);

        foreach ($sqlfiles as $id => $sqlfile) {
            $sqlfile = str_ireplace(PATH_WEB . ADMIN_FILE . '/databack/', '', $sqlfile);
            if (stripos($sqlfile, $prefix) !== false) {
                $filetype = trim(substr(strrchr($sqlfile, '.'), 1));
                if ($filetype == 'sql') {
                    $filenamearray = explode($ext, $sqlfile);
                    @unlink(PATH_WEB . ADMIN_FILE . '/databack/' . $sqlfile);
                    @unlink(PATH_WEB . ADMIN_FILE . '/databack/sql/' . $_M['config']['met_agents_backup'] . '_' . $filenamearray[0] . '.zip');
                }
            }
        }
        //写日志
        logs::addAdminLog('databackup2', 'delete', 'physicaldelok', 'dodelete');

        $redata['status'] = 1;
        $redata['msg'] = $_M['word']['physicaldelok'];
        $this->ajaxReturn($redata);
    }

    /*解压ZIP*/
    public function dounzip_upload()
    {
        global $_M;
        $redata = array();
        $file = $_M['form']['file'];
        $check_file = preg_match('/^\w+\.zip$/', $file);
        if (!$check_file) {
            //写日志
            logs::addAdminLog('databackup2', 'webupate7', 'webupate5', 'dounzip_upload');
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['webupate4'];
            $this->ajaxReturn($redata);
        }

        $zipname = PATH_WEB . ADMIN_FILE . '/databack/upload/' . $file;

        if (file_exists($zipname)) {
            //rename(PATH_WEB . 'upload', PATH_WEB . 'upload' . date('Ymd'));
            $zip = new ZipArchive();
            if ($zip->open($zipname) === true) {
                $zip->extractTo(PATH_WEB);
                $zip->close();
                //写日志
                logs::addAdminLog('databackup2', 'webupate7', 'webupate3', 'dounzip_upload');
                $redata['status'] = 1;
                $redata['msg'] = $_M['word']['webupate3'];
            } else {
                //写日志
                logs::addAdminLog('databackup2', 'webupate7', 'webupate4', 'dounzip_upload');
                $redata['status'] = 0;
                $redata['msg'] = $_M['word']['webupate4'];
            }
        } else {
            //写日志
            logs::addAdminLog('databackup2', 'webupate7', 'webupate5', 'dounzip_upload');
            $redata['status'] = 0;
            $redata['msg'] = $_M['word']['webupate5'];
        }
        $this->ajaxReturn($redata);
    }

    /*删除备份上传文件*/
    public function dodelete_zip()
    {
        global $_M;
        $file = $_M['form']['file'];
        $type = $_M['form']['type'] == 'upload' ? 'upload' : 'web';

        $file_name = basename($file,'.zip');
        $zipname = PATH_WEB . ADMIN_FILE . "/databack/{$type}/{$file_name}.zip";
        if (file_exists($zipname)) {
            @unlink($zipname);
            $redata['status'] = 1;
            $redata['msg'] = $_M['word']['physicaldelok'];
            $this->ajaxReturn($redata);
        }

        $redata = array();
        $redata['status'] = 0;
        $redata['msg'] = $_M['word']['setdbNotExist'];
        $this->ajaxReturn($redata);
    }

    /** 上传本份文件 slq ,zip */
    public function doUploadDataback()
    {
        global $_M;
        $redata = array();
        $formname = $_M['form']['formname'];
        $redata['order'] = $_M['form']['file_id'] ? $_M['form']['file_id'] : 0;

        $this->upfile = load::sys_class('upfile', 'new');
        //设置备份文件上传模式
        $this->upfile->set_upsql();
        $back = $this->upfile->upload($formname);

        if ($back['error']) {
            $redata['error'] = $back['msg'];
            $redata['msg'] = $back['msg'];
        } else {
            $path = $back['path'];
            $f_paht = str_replace('../', PATH_WEB, $path);

            if (file_exists($f_paht)) {
                $admin_dir = PATH_WEB . ADMIN_FILE . '/';
                $f_name = basename($f_paht);
                $f_type = array_pop(explode('.', $f_name));

                if ($f_type == 'zip') {
                    $random = random(5);
                    $tagdir = $admin_dir . 'databack/' . $random;
                    if (!is_dir($tagdir)) {
                        mkdir($tagdir);
                    }
                    $res = fzip_open($f_paht, $tagdir);
                    if ($res) {
                        $this->moveSqlFile($tagdir, $admin_dir . 'databack/');
                    }
                    if (is_file(PATH_WEB . 'upload/sql/' . $f_name)) {
                        delfile(PATH_WEB . 'upload/sql/' . $f_name);
                    }
                } elseif ($f_type == 'sql') {
                    $new_path = $admin_dir . 'databack/' . $f_name;
                    $res = movefile($f_paht, $new_path);
                }

                if ($res == true) {
                    $redata['msg'] = $_M['word']['uplaoderr1'];
                    $redata['filesize'] = round($back['size'] / 1024, 2);
                    //写日志
                    logs::addAdminLog('databackup2', 'unitytxt_70', 'uplaoderr1', 'dounzip_upload');
                } else {
                    $redata['error'] = $f_name . '__' . $_M['word']['jsx17'];
                    $redata['msg'] = $f_name . '__' . $_M['word']['jsx17'];
                    $redata['filesize'] = round($back['size'] / 1024, 2);
                    //写日志
                    logs::addAdminLog('databackup2', 'unitytxt_70', 'jsx17', 'dounzip_upload');
                }
            }
        }
        $this->ajaxReturn($redata);
    }

    /**
     * 移动备份SQL文件
     * @param $old_path
     * @param $target_path
     */
    protected function moveSqlFile($old_path, $target_path)
    {
        global $_M;
        $handle = opendir($old_path);
        while (false !== $file = (readdir($handle))) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $substr = substr($file, -4);
            if ($substr === '.sql') {
                movefile($old_path . '/' . $file, $target_path . $file);
            }
        }
        closedir($handle);
        if (is_dir($old_path)) {
            deldir($old_path);
        }
    }

    /*************数据打包方法***************/
    /**
     * 生成系统数据指纹
     */
    public function doGetSysDate()
    {
        global $_M;
        $action = $_M['form']['action'];
        echo "acrion : {$_M['form']['action']} <hr>";
        echo "
        <a href='{$_M['url']['site_admin']}?n=databack&c=index&a=doGetSysDate&action=sqldata'>系统数据库指纹</a><br>
        <a href='{$_M['url']['site_admin']}?n=databack&c=index&a=doGetSysDate&action=langdata'>系统语言指纹</a><br>
        <a href='{$_M['url']['site_admin']}?n=databack&c=index&a=doGetSysDate&action=configdata'>配置库指纹</a><br>
        ";

        if ($action =='sqldata') {
            $this->dogetTablesjson();
            die('Complete');
        }
        if ($action == 'langdata') {
            $this->dogetLangData();
            die('Complete');
        }
        if ($action == 'configdata') {
            $this->dogetconfigData();
            die('Complete');
        }
    }

    /** 获取系统数据表json */
    public function dogetTablesjson()
    {
        //return;
        global $_M;
        $table_list = $_M['table'];
        foreach ($table_list as $table) {
            //$query = "desc {$table}";
            $query = "SHOW FULL FIELDS FROM {$table}";
            $res = DB::get_all($query);
            $col = array();
            foreach ($res as $row) {
                $col[$row['Field']] = $row;
            }
            $tables[$table] = $col;
        }
        $tables = json_encode($tables, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $time = time();
        file_put_contents(PATH_WEB . "v{$_M['config']['metcms_v']}mysql.json", $tables);
        die('table_json_complete');
    }

    /**
     * 获取语言数据json.
     */
    public function dogetLangData()
    {
        //return;
        global $_M;
        $sql = "select `name`,`value`,`site`,`no_order`,`array`,`app`,`lang` FROM {$_M['table']['language']} WHERE app = '' OR app = 0 OR app = 1";
        $lang_list = DB::get_all($sql);

        $lang_cn = array();
        $lang_en = array();
        $lang_admin_cn = array();
        $lang_web_cn = array();
        $lang_admin_en = array();
        $lang_web_en = array();

        $lang_ini_cn_admin = "#\n";
        $lang_ini_cn_web = "#\n";
        $lang_ini_en_admin = "#\n";
        $lang_ini_en_web = "#\n";

        foreach ($lang_list as $lang) {
            if ($lang['lang'] == 'cn') {
                $lang_cn[$lang['name']] = $lang;

                if ($lang['site'] == 1) {
                    $lang_admin_cn[$lang['name']] = $lang;
                    $lang_ini_cn_admin .= "{$lang['name']}={$lang['value']}\n";
                } else {
                    $lang_web_cn[$lang['name']] = $lang;
                    $lang_ini_cn_web .= "{$lang['name']}={$lang['value']}\n";
                }
            } elseif ($lang['lang'] == 'en') {
                $lang_en[$lang['name']] = $lang;

                if ($lang['site'] == 1) {
                    $lang_admin_en[$lang['name']] = $lang;
                    $lang_ini_en_admin .= "{$lang['name']}={$lang['value']}\n";
                } else {
                    $lang_web_en[$lang['name']] = $lang;
                    $lang_ini_en_web .= "{$lang['name']}={$lang['value']}\n";
                }
            }
        }

        file_put_contents(PATH_WEB . "v{$_M['config']['metcms_v']}lang_cn.json", json_encode($lang_cn, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents(PATH_WEB . "v{$_M['config']['metcms_v']}lang_en.json", json_encode($lang_en, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents(PATH_WEB . "v{$_M['config']['metcms_v']}lang_admin_cn.json", json_encode($lang_admin_cn, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents(PATH_WEB . "v{$_M['config']['metcms_v']}lang_web_cn.json", json_encode($lang_web_cn, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents(PATH_WEB . "v{$_M['config']['metcms_v']}lang_admin_en.json", json_encode($lang_admin_en, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        file_put_contents(PATH_WEB . "v{$_M['config']['metcms_v']}lang_web_en.json", json_encode($lang_web_en, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        file_put_contents(PATH_WEB . "language_cn1.ini", $lang_ini_cn_admin);
        file_put_contents(PATH_WEB . "language_cn.ini", $lang_ini_cn_web);
        file_put_contents(PATH_WEB . "language_en1.ini", $lang_ini_en_admin);
        file_put_contents(PATH_WEB . "language_en.ini", $lang_ini_en_web);
        die('lang_json_complete');
    }

    /**
     * 系统系统标准配置
     */
    public function dogetconfigData()
    {
        global $_M;
        $sql = "select * FROM {$_M['table']['config']} WHERE (lang = 'cn' OR lang = 'metinfo') AND columnid = '0' AND flashid = 0";
        $list = DB::get_all($sql);

        $config_list = array();
        foreach ($list as $config) {
            $config_list[$config['name']] = $config;
        }

        file_put_contents(PATH_WEB . "v{$_M['config']['metcms_v']}config.json", json_encode($config_list, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        die('dogetconfigData');
    }

    public function doTry()
    {
        global $_M;
        $ver = $_M['form']['ver'];
        $sys_ver = $_M['config']['metcms_v'];

        $update_database = load::mod_class('update/update_database', 'new');

        $update_database->diff_fields($sys_ver);
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.;
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
