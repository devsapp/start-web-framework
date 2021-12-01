<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Topicdata extends CI_Controller {
	var $whitelist;
     function __construct() {
     	 $this->whitelist="";
       parent::__construct();
        $this->load->model("topdata_model");
    }
  function pushindex(){
    	$id=intval($this->uri->segment ( 3 ));
    	$type=htmlspecialchars($this->uri->segment ( 4 ));
    	$this->topdata_model->add($id,$type);
       	  cleardir(FCPATH . 'data/cache'); //清除缓存文件
    	$this->message("首页顶置成功!");
    }
  function cancelindex(){

    	$id=intval($this->uri->segment ( 3 ));
    	$type=htmlspecialchars($this->uri->segment ( 4 ));
    	$this->topdata_model->remove($id,$type);
    	  cleardir(FCPATH . 'data/cache'); //清除缓存文件
    	$this->message("取消首页顶置成功!");
    }



}