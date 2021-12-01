<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::mod_class('base/base_label');

class job_label  extends base_label
{
    public function __construct()
    {
        global $_M;
        $this->construct('job', $_M['config']['met_job_list']);
    }

    /**
     * 获取简历表单字段
     * @param string $id
     */
    public function get_module_form($id = '')
    {
        global $_M;
        if ($id && is_numeric($id)) {
            $data = $this->get_one_list_contents($id);    //获取职位信息
            $classnow = $data['class3'] ? $data['class3'] : ($data['class2'] ? $data['class2'] : $data['class1']);
            $return['para'] = load::mod_class('parameter/parameter_label', 'new')->get_parameter_form('job', $data['class1'], $data['class2'], $data['class3']);
            $return['config']['url'] = load::mod_class('job/job_handle', 'new')->module_form_url($classnow);
            $return['config']['url'] .= '?id=' . $classnow;
            $return['config']['classnow'] .= $classnow;
            $return['config']['lang']['submit'] = $_M['word']['Submit'];
            $return['config']['lang']['cvtitle'] = $_M['word']['cvtitle'];
            $return['config']['lang']['cancel'] = $_M['word']['cancel'];
            $return['config']['lang']['title'] = '';
            return $return;
        }
        return;
    }

    /**
     * 获取简历字段表单
     * @return array         简历表单数组
     */
    public function get_module_form_html($id = '')
    {
        global $_M;
        //cxrf_token
        $form_token = random('5');
        load::sys_class('session', 'new')->set("job_form_token_{$id}", $form_token);

        $job = $this->get_module_form($id);
        $str = '';
        $str .= <<<EOT
		<form method='POST' class="met-form met-form-validation"  enctype="multipart/form-data" action='{$job['config']['url']}'>
		<input type="hidden" name="id" value="{$job['config']['classnow']}">
		<input type="hidden" name="lang" value="{$_M['lang']}">
		<input type="hidden" name="jobid" value="{$id}">
		<input type='hidden' name='form_token' value='{$form_token}' />
EOT;
        foreach ($job['para'] as $key => $val) {
            $str .= <<<EOT
		{$val['type_html']}

EOT;
        }
        $str .= <<<EOT
		<div class="form-group m-b-0">
		    <button type="submit" class="btn btn-primary btn-squared">{$job['config']['lang']['submit']}</button>
		    <button type="button" class="btn btn-default btn-squared m-l-5" data-dismiss="modal">{$job['config']['lang']['cancel']}</button>
	  	</div>
		</form>
EOT;
        return $str;
    }

    /**
     * 获取单条news
     * @param  string $id 内容id
     * @return array                一个列表页面数组
     */
    public function insert_cv($jobid, $paras, $customerid = '', $ip = '')
    {
        global $_M;
        if (!$jobid) {
            return false;
        }
        $data['jobid'] = $jobid;
        $data['ip'] = $ip ? $ip : IP;
        $data['customerid'] = $customerid;
        $data['addtime'] = date('Y-m-d H:i:s', time());
        $data['lang'] = $_M['form']['lang'];
        $jid = load::mod_class('job/jobcv_database', 'new')->insert($data);
        if ($jid) {
            if (load::mod_class('parameter/parameter_op', 'new')->insert($jid, 'job', $paras)) {
                return true;
            }
        }
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>
