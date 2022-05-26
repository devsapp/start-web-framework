<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_sitelog extends ADMIN_Controller {

    	function __construct() {
		parent::__construct ();
        $this->load->model('sitelog_model');
    }

    function index($message='') {
        if(empty($message)) unset($message);

          @$page = max(1, intval($this->uri->segment ( 3 ) ));
        $pagesize = 100;
        $startindex = ($page - 1) * $pagesize;
       $loglist = $this->sitelog_model->get_list($startindex,$pagesize);
        $rownum = returnarraynum ( $this->db->query ( getwheresql ( "site_log"," 1=1", $this->db->dbprefix ) )->row_array () );
        $departstr = page($rownum, $pagesize, $page, "admin_sitelog/default");

        include template('sitelog','admin');
    }
    function delete(){
    	    if (null!==$this->input->post ('submit')) {

    	    	if($this->user['grouptype']!=1){
    	    		 $this->index('只有网站创始人才能有权限删除日志，防止恶意后台用户操作！');
    	    	}
    	    	$starttime= strtotime($this->input->post ('srchdatestart'));
    	    	$endtime= strtotime($this->input->post ('srchdateend'));
    	    	$this->sitelog_model->delete($starttime,$endtime);
    	    	 $this->index('日志刪除成功！');



    	}

    }


}
?>