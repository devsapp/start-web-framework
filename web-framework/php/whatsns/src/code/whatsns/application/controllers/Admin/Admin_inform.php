<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_inform extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
        $this->load->model("inform_model");
    }

    function index($msg='') {
        @$page = max(1, intval($this->uri->segment ( 3 )));
        $pagesize=$this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $informlist = $this->inform_model->get_list($startindex,$pagesize);
        $informnum=returnarraynum ( $this->db->query ( getwheresql ('inform','1=1', $this->db->dbprefix ) )->row_array () );
        $departstr=page($informnum, $pagesize, $page,"admin_inform/index");
        $msg && $message=$msg;
        include template('informlist','admin');
    }


    function remove() {
    	if (null !== $this->input->post ( 'qid' )) {
            $qids = implode(",", $this->input->post ('qid'));
            $this->inform_model->remove_by_id($qids);
            $message='举报删除成功删除！';
            unset($_GET);
            $this->index($message);
        }

    }
}
?>