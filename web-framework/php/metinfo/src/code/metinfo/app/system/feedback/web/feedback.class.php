<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('web');

class feedback extends web
{
    private $conlum_configs;

    public function __construct()
    {
        global $_M;
        parent::__construct();
    }

    public function dofeedback()
    {
        global $_M;
        if ($_M['form']['action'] == 'add') {
            $this->check_field();
            $this->add($_M['form']);
        } else {
            $config_op = load::mod_class('config/config_op', 'new');
            $classnow = $this->input_class($_M['form']['id']);
            $this->add_input('id', $classnow);
            if ($classnow) {
                $this->load_config($_M['lang'], $classnow);
            }
            $data = load::sys_class('label', 'new')->get('column')->get_column_id($classnow);
            $this->add_array_input($data);
            unset($data['id']);

            //静态页权限验证
            if ($data['access'] && $_M['form']['html_filename']) {
                $groupid = load::sys_class('auth', 'new')->encode($data['access']);
                $data['access_code'] = $groupid;
            } else {
                $this->check($data['access']);
            }

            $class_config = $config_op->getColumnConfArry($classnow);
            if ($class_config['met_fdtable']) {
                $this->seo($class_config['met_fdtable'], $data['keywords'], $data['description']);
            } else {
                $this->seo($data['name'], $data['keywords'], $data['description']);
            }
            $this->seo_title($data['ctitle']);
            // $this->seo_title($_M['config']['met_fdtable']);
            $this->add_input('fdtitle', $data['name']);
            if ($_M['form']['fdtitle']) {//产品询价
                $this->input['url'] = $this->input['url'] . "?fdtitle={$_M['form']['fdtitle']}";
            }else{
                load::sys_class('handle', 'new')->redirectUrl($this->input); //伪静态时动态链接跳转
            }

            $this->template('tem/feedback');
        }
    }

    public function add($info)
    {
        global $_M;
        $classnow = $info['id'];
        if (!$classnow) {
            okinfo(HTTP_REFERER, $_M['word']['dataerror']);
        }

        $conlum_configs = $this->getClsaaConfig($classnow);
        $config_op = load::mod_class('config/config_op', 'new');

        if (!$conlum_configs['met_fd_ok']) {
            okinfo(-1, $_M['word']['Feedback5']);
        }

        //图形验证码
        if ($_M['config']['met_memberlogin_code']) {
            if (!load::sys_class('pin', 'new')->check_pin($_M['form']['code'], $_M['form']['random'])) {
                okinfo(-1, $_M['word']['membercode']);
            }
        }

        if ($this->checkword() && $this->checktime() && $this->checkToken($info['id'])) {
            foreach ($_FILES as $key => $value) {
                if ($value['tmp_name']) {
                    $this->upfile = load::sys_class('upfile', 'new');
                    $ret = $this->upfile->upload($key); //上传文件
                    if ($ret['path'] != '') {
                        $info[$key] = $ret['path'];
                    } else {
                        okinfo('javascript:history.back();', "{$_M['word']['opfailed']} [{$ret['error']}]");
                    }
                }
            }
            $user = $this->get_login_user_info();
            $fromurl = $_M['form']['referer'] ? $_M['form']['referer'] : HTTP_REFERER;
            $ip = getip();
            $addtime = date('Y-m-d H:i:s', time());

            $fdtable = $conlum_configs['met_fdtable'];
            if ($fdtable && $fdtable != $_M['form']['fdtitle']) {
                $title = "{$_M['form']['fdtitle']} - {$fdtable} ($addtime)";
            } else {
                $title = "{$_M['form']['fdtitle']} ({$addtime})";
            }

            if (load::sys_class('label', 'new')->get('feedback')->insert_feedback($info['id'], $info, $title, $user['username'], $fromurl, $addtime, $ip)) {
                $this->notice_by_emial($info, $fromurl, $title, $addtime);

                $this->notice_by_sms($title);
            }
            load::sys_class('session', 'new')->set('submit', time());
            okinfo(HTTP_REFERER, $_M['word']['Feedback4']);
        }
    }

    /**
     * 获取栏目配置信息
     * @param string $class
     * @return mixed
     */
    public function getClsaaConfig($class = '')
    {
        global $_M;
        if (!$this->conlum_configs) {
            $config_op = load::mod_class('config/config_op', 'new');
            $config = $config_op->getColumnConfArry($class);
            $this->conlum_configs = $config;
            return $config;
        } else {
            return $this->conlum_configs;
        }
    }

    /*字段关键词过滤*/
    public function checkword()
    {
        global $_M;
        $met_fd_word = DB::get_one("select * from {$_M['table']['config']} where lang ='{$_M['form']['lang']}' and  name= 'met_fd_word' and columnid = 0");
        $met_fd_word_arr = explode("|", $met_fd_word['value']);
        if ($met_fd_word['value'] == '') {
            return true;
        }

        $para_list = load::mod_class('parameter/parameter_database', 'new')->get_parameter(8);
        $content = '';
        foreach ($para_list as $key => $val) {
            $para = "para" . $val['id'];
            $content = $content . "-" . $_M['form'][$para];
        }

        foreach ($met_fd_word_arr as $key => $word) {
            if ($word == '') {
                continue;
            }

            if (strstr($content, $word)) {
                okinfo('javascript:history.back();', $word);
                die();
            }
        }
        return true;
    }

    /**
     * 表单提交时间检测
     * @return bool
     */
    public function checktime()
    {
        global $_M;
        $classnow = $_M['form']['id'];
        $ip = getip();
        $ipok = DB::get_one("select * from {$_M['table']['feedback']} where ip='$ip' order by addtime desc");
        if ($ipok) {
            $time1 = strtotime($ipok['addtime']);
        } else {
            $time1 = 0;
        }

        $submit = load::sys_class('session', 'new')->get('submit');
        $time2 = time();
        $timeok = (float)($time2 - $time1);
        $timeok2 = (float)($time2 - $submit);
        $config_op = load::mod_class('config/config_op', 'new');
        $conlum_configs = $config_op->getColumnConfArry($classnow);

        if ($timeok <= $conlum_configs['met_fd_time'] && $timeok2 <= $conlum_configs['met_fd_time']) {
            $fd_time = "{$_M['word']['Feedback1']}" . $conlum_configs['met_fd_time'] . "{$_M['word']['Feedback2']}";
            okinfo('javascript:history.back();', $fd_time);
        } else {
            return true;
        }
    }

    /**
     * @param string $id
     * @return bool
     */
    public function checkToken($id = '')
    {
        return true;
        global $_M;
        if ($_M['config']['met_webhtm']) {
            return true;
        }
        $s_token = load::sys_class('session', 'new')->get("fd_form_token_{$id}");
        $form_token = $_M['form']['form_token'];
        if (!$form_token || $s_token != $form_token) {
            okinfo('javascript:history.back();', 'forbidden');
        }
        return true;
    }

    /*通过邮箱通知*/
    public function notice_by_emial($info, $fromurl, $title, $addtime)
    {
        global $_M;
        $mail = load::sys_class('jmail', 'new');

        $body = '<table>';
        $body = $body . "<b>{$_M['word']['AddTime']}</b>:" . $addtime . "<br>";
        $body = $body . "<b>{$_M['word']['SourcePage']}</b>:" . $fromurl . "<br>";
        $body = $body . "<b>IP</b>:" . getip() . "<br>";
        $j = 0;
        $fd_para = load::mod_class('parameter/parameter_database', 'new')->get_parameter(8, $info['id']);
        foreach ($fd_para as $key => $val) {
            $j++;
            if ($j > 1) {
                $bt = '';
            }
            if ($val['type'] != 4) {
                $para = $info[$val['para']];
            } else {
                $para = "";
                for ($i = 1; $i <= $info[$val['para']]; $i++) {
                    $para1 = "para" . $val['id'];
                    $para2 = $info['$para1'];
                    $para = ($para2 != "") ? $para . $para2 . "-" : $para;
                }
                $para = substr($para, 0, -1);
            }
            $para = strip_tags($para);
            if ($val['type'] == 4) {
                $count = is_array($val['para_list']) ? count($val['para_list']) : 0;
                for ($i = 1; $i <= $count; $i++) {
                    if ($info['para' . $val['id'] . '_' . $i]) {
                        $info['para' . $val['id']] = $info['para' . $val['id'] . '_' . $i];
                    }
                }
            }
            if ($val['type'] != 5) {
                $body = $body . '<tr><td class="l"><b>' . $val['name'] . '</b></td><td class="r">:' . $info['para' . $val['id']] . '</td>' . $bt . '</tr>' . "\n";
            } else {
                $para_url = str_replace('../', $_M['url']['web_site'], $info['para' . $val['id']]);
                $body = $body . '<tr><td class="l"><b>' . $val['name'] . '</b></td><td class="r">:' . $para_url . '</td>' . $bt . '</tr>' . "\n";
            }
            $body .= '</table>';
        }

        $classnow = $info['id'];
        $conlum_configs = $this->getClsaaConfig($classnow);

        //管理员邮件通知
        $met_fd_type = explode('#@met@#', $conlum_configs['met_fd_type']);  //通知方式
        if (in_array(1, $met_fd_type)) {
            $met_fd_to = explode('|', $conlum_configs['met_fd_to']);
            foreach ($met_fd_to as $email) {
                $mail->send_email($email, $title, $body);
            }
        }

        //用户员邮件通知
        $cvto = "para" . $conlum_configs['met_fd_email'];
        $cvto = $info[$cvto]; //用戶接收郵箱
        if ($conlum_configs['met_fd_back'] == 1 && $cvto) {
            $mail->send_email($cvto, $conlum_configs['met_fd_title'], $conlum_configs['met_fd_content']);
        }
    }

    /*通过短信通知*/
    public function notice_by_sms($title)
    {
        global $_M;
        $classnow = $_M['form']['id'];
        $conlum_configs = $this->getClsaaConfig($classnow);

        //管理员短信通知
        $met_fd_type = explode('#@met@#', $conlum_configs['met_fd_type']);
        if (in_array(2, $met_fd_type) && $conlum_configs['met_fd_admin_tel'] || 1) {
            $str = str_replace("http://", "", $_M['config']['met_weburl']);
            $strdomain = explode("/", $str);
            $domain = $strdomain[0];
            #$message="您网站[{$domain}]您收到了新的反馈[{$job_list[position]}]，请尽快登录网站后台查看";
            $message = "{$_M['word']['reMessage1']}[{$domain}]{$_M['word']['newFeedback']}[{$title}]{$_M['word']['reMessage2']}";
            $met_fd_admin_tel = explode('|', $conlum_configs['met_fd_admin_tel']);
            foreach ($met_fd_admin_tel as $tel) {
                load::sys_class('sms', 'new')->sendsms($tel, $message);
            }
        }

        //用户短信通知
        $met_fd_sms_tell = 'para' . $conlum_configs['met_fd_sms_tell'];
        $user_tel = $_M['form'][$met_fd_sms_tell];
        if ($conlum_configs['met_fd_sms_back'] && $user_tel && $conlum_configs['met_fd_sms_content']) { //用户短信回复
            load::sys_class('sms', 'new')->sendsms($user_tel, $conlum_configs['met_fd_sms_content']);
        }
    }

    /*检测后台设置的字段*/
    public function check_field()
    {
        global $_M;
        $id = $_M['form']['id'];
        $config_op = load::mod_class('config/config_op', 'new');
        $feedbackcfg = $config_op->getColumnConfArry($id);

        $met_fd_email = $_M['form']['para' . $feedbackcfg['met_fd_email']];
        $met_fd_sms_tell = $_M['form']['para' . $feedbackcfg['met_fd_sms_tell']];
        $met_fd_class = $_M['form']['para' . $feedbackcfg['met_fd_class']];
        $met_fd_back = $feedbackcfg['met_fd_back'];

        $class123 = $class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($id);
        $paralist = load::mod_class('parameter/parameter_database', 'new')->get_parameter('8', $class123['class1']['id'], $class123['class2']['id'], $class123['class3']['id']);
        foreach ($paralist as $key => $val) {
            $para[$val['id']] = $val;
        }

        $paraarr = array();
        $form = array_merge($_M['form'], $_FILES);
        foreach (array_keys($form) as $vale) {
            if (strstr($vale, 'para')) {
                if (strstr($vale, '_')) {
                    $arr = explode('_', $vale);
                    $paraarr[] = str_replace('para', '', $arr[0]);
                } else {
                    $paraarr[] = str_replace('para', '', $vale);
                }
            }
        }

        //必填属性验证
        foreach (array_keys($para) as $val) {
            if ($para[$val]['wr_ok'] == 1 /*&& in_array($val, $paraarr)*/) {
                if ($para[$val]['type'] == 5) {
                    if ($_FILES['para' . $val]['name'] == '' || !$_FILES['para' . $val]['size']) {
                        $info = "【{$para[$val]['name']}】" . $_M['word']['noempty'];
                        okinfo('javascript:history.back();', $info);
                    }
                } else {
                    if ($_M['form']['para' . $val] == '') {
                        $info = "【{$para[$val]['name']}】" . $_M['word']['noempty'];
                        okinfo('javascript:history.back();', $info);
                    }
                }

            }
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
