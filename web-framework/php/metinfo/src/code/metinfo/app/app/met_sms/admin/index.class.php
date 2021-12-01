<?php

defined('IN_MET') or exit('No permission');
load::sys_class('admin');
class index extends admin
{
    public $sms;

    public function __construct()
    {
        global $_M;

        parent::__construct();
        nav::set_nav(1, '短信配置', $_M['url']['own_form'].'a=doindex');
        nav::set_nav(2, '短信群发', $_M['url']['own_form'].'a=domass');
        nav::set_nav(3, '发送记录', $_M['url']['own_form'].'a=dolog');
        $this->sms = load::own_class('met_sms', 'new');
    }

    public function doindex()
    {
    }

    public function dosave()
    {
        global $_M;
        $token = $_M['form']['met_sms_token'];
        if (!preg_match('/^[a-z0-9]{32}$/', $token)) {
            $this->error('发送码不正确');
        }
        $query = "UPDATE {$_M['table']['config']} SET value = '{$token}' WHERE name = 'met_sms_token'";
        DB::query($query);
        $this->success('', '保存成功');
    }

    public function domass()
    {
        global $_M;

        $sms = $this->sms->get_sms();

        if (!$sms) {
            $this->error('请配置正确的短信发送码');
        }
        $count = mb_strlen("退订回N【{$sms['signature']}】", 'utf-8');
        $current = mb_strlen($sms['test_content'], 'utf-8');
        $list['sms'] = $sms;
        $list['count'] = $count;
        $list['word'] = 64;
        $list['current'] = $current;

        $this->success($list);
    }

    public function doLogs()
    {
        global $_M;

        $table = load::sys_class('tabledata', 'new');
        $where = ' 1 = 1 ';
        $order = 'add_time DESC';

        $array = $this->sms->get_logs($_M['form']['start'], $_M['form']['length']);
        foreach ($array['data']['data'] as $key => $val) {
            $list = array();
            $list['time'] = date('Y-m-d H:i:s', $val['add_time']);
            $list['type'] = $val['type'] == 1 ? '用户通知' : '营销短信';
            $list['content'] = $val['content'];
            $list['number'] = count(explode(',', $val['phone'])) > 2 ? substr($val['phone'], 0, 30).'...' : $val['phone'];
            $list['result'] = $val['description'];
            $rarray[] = $list;
        }
        if (!$array['data']['total']) {
            $total = 0;
        } else {
            $total = $array['data']['total'];
        }
        $table->rarray['recordsTotal'] = $table->rarray['recordsFiltered'] = $total;
        $table->rdata($rarray);
    }

    public function domigrate()
    {
        global $_M;
        $res = $this->sms->migrate();
        if ($res['status'] == 0) {
            turnover("{$_M['url']['own_form']}a=doindex", $res['msg']);
        } else {
            turnover("{$_M['url']['own_form']}a=doindex", $res['data']);
        }
    }

    public function dosend()
    {
        global $_M;
        $sms_content = $_M['form']['sms_content'];
        $sms_phone = $_M['form']['sms_phone'];
        $res = $this->sms->custom_send($sms_phone, $sms_content);

        if ($res['status'] === 200) {
            $this->success($res['data'], $res['data']);
        } else {
            $this->error($res['msg']);
        }
    }
}
