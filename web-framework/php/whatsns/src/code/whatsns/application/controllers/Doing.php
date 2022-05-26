<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Doing extends CI_Controller {

    function __construct() {
       parent::__construct();
        $this->load->model("doing_model");
         $this->load->model("topic_model");
    }
/**

* 动态首页

* @date: 2018年7月6日 上午10:44:01

* @author: 61703

* @param: 空

* @return:

*/
    function index() {
        $navtitle = "问答动态";

        $type = 'atentto';
        $recivetype = $this->uri->segment ( 3 );
        if ($recivetype) {
            $type = $recivetype;
        }
        if (!$this->user['uid']) {
            $type = 'all';
        }
        $navtitletable = array(
            'all' => '问答动态',
            'my' => '我的动态',
            'atentto' => '关注的动态'
        );
        $navtitle = $navtitletable[$type];
        $page = max(1, intval($this->uri->segment ( 4 )));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $doinglist = $this->doing_model->list_by_type($type, $this->user['uid'], $startindex, $pagesize);
        $rownum = $this->doing_model->rownum_by_type($type, $this->user['uid']);
        $departstr = page($rownum, $pagesize, $page, "doing/default/$type");
        if ($type == 'atentto') {
            $recommendsize = $rownum ? 3 : 6;
            $recommandusers = $this->doing_model->recommend_user($recommendsize);
        }
       	$userarticle=$this->topic_model->get_user_articles(0,5);
        include template('doing');
    }

}

?>