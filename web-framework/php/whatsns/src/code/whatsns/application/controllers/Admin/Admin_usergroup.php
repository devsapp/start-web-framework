<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_usergroup extends ADMIN_Controller {


    	function __construct() {
		parent::__construct ();
        $this->load->model('usergroup_model');
    }

    /*会员用户组列表*/
    function index($message='') {
        if(empty($message)) unset($message);
        $usergrouplist = $this->usergroup_model->get_list(2);
        include template('usergrouplist','admin');
    }

    /*系统用户组列表*/
    function system() {
        $usergrouplist = $this->usergroup_model->get_list(array(1,3));
        include template('systemgrouplist','admin');
    }

    /*添加会员组*/
    function add() {
        $grouptitle=trim($this->input->post ('grouptitle'));
        if($grouptitle) {
            $this->usergroup_model->add($grouptitle,2);
            $this->index('添加会员组成功！');
        }
    }

    /*删除会员组，如果本组有会员存在，则不可删除*/
    function remove() {
        $groupid =intval($this->uri->segment ( 3 ) );
        $this->usergroup_model->remove($groupid);
        $this->index('删除组成功！');
    }

    /*设置权限*/
    function regular() {
        $groupid =intval($this->uri->segment ( 3 ) );
        $group = $this->usergroup_model->get($groupid);
        if(null!==$this->input->post ('regular_code')) {
            $group['regulars']=implode(',',$this->input->post ('regular_code'));
            $group['canfreereadansser']=intval($this->input->post ('canfreereadansser'));
            $group['doarticle']=intval($this->input->post ('doarticle'));
            $group['articlelimits']=intval($this->input->post ('articlelimits'));
            $group['questionlimits']=intval($this->input->post ('questionlimits'));
            $group['answerlimits']=intval($this->input->post ('answerlimits'));
            $group['credit3limits']=intval($this->input->post ('credit3limits'));
            $this->usergroup_model->update($groupid,$group);
            $message='组权限设置成功！';
        }
        $this->cache->remove('usergroup');
        include template('editusergroup','admin');
    }


    /*编辑组名*/
    function edit() {
        $groupids =$this->input->post ('groupid');
        $grouptitles =$this->input->post ('grouptitle');
        $scorelowers =$this->input->post ('scorelower');
        $idcount=count($groupids);
        for($i=0;$i<$idcount;$i++) {
            $group = $this->usergroup_model->get($groupids[$i]);
            $group['grouptitle']=$grouptitles[$i];
            $group['creditslower']=$scorelowers[$i];
            $group['creditshigher']=isset($scorelowers[$i+1])?$scorelowers[$i+1]:999999999;
            $this->usergroup_model->update($groupids[$i],$group);
        }
        $this->index('用户组更新成功！');
    }
}
?>