<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_link extends ADMIN_Controller {

    	function __construct() {
		parent::__construct ();
        $this->load->model('link_model');
    }

    function index($message='') {
        if(empty($message)) unset($message);
        $linklist = $this->link_model->get_list(0,100);
        include template('linklist','admin');
    }

    function add() {
        if(null!==$this->input->post ('submit')) {
            $name = $this->input->post ('name');
            $desrc = $this->input->post ('descr');
            $url = $this->input->post ('url');
            $logo = $this->input->post ('logo');
            if(!$name || !$url) {
                $type='errormsg';
                $message = '链接名称或链接地址不能为空!';
                include template('addlink','admin');
                exit;
            }
            $this->link_model->add($name,$url,$desrc,$logo);
            $this->cache->remove('link');
            $this->index('链接添加成功！');
        }else {
            include template('addlink','admin');
        }
    }

    function edit() {
    	$lid = null!==$this->input->post ('lid')?intval($this->input->post ('lid')):intval($this->uri->segment ( 3 ));
        if(null!==$this->input->post ('submit')) {
            $name = $this->input->post ('name');
            $desrc = $this->input->post ('descr');
            $url = $this->input->post ('url');
            $logo = $this->input->post ('logo');
            if(!$name || !$url) {
                $type='errormsg';
                $message = '链接名称或链接地址不能为空!';
                $curlink = $this->link_model->get($lid);
                include template('addlink','admin');
            }
            $this->link_model->update($name,$url,$desrc,$logo,$lid);
            $this->cache->remove('link');
            $this->index('链接修改成功！');
        }else {
            $curlink = $this->link_model->get($lid);
            include template('addlink','admin');
        }
    }

    function remove() {
        $this->link_model->remove_by_id(intval($this->uri->segment ( 3 )));
        $this->cache->remove('link');
        $this->index('链接刪除成功！');
    }

    function reorder() {
        $orders = explode(",",$this->input->post ('order'));
        $hid = intval($this->input->post ('hiddencid'));
        foreach($orders as $order => $lid) {
            $this->link_model->order_link(intval($lid),$order);
        }
    }

}
?>