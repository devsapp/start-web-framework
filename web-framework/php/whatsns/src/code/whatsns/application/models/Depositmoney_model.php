<?php

class Depositmoney_model extends CI_Model{



    function __construct() {
    	parent::__construct ();
        $this->load->database ();
    }



    function get($fromuid,$type,$typeid){
    	 $model= $this->db->query("SELECT * FROM " . $this->db->dbprefix . "user_depositmoney WHERE fromuid=$fromuid and type='$type' and typeid=$typeid and state=0")->row_array();
        return $model;
    }
    function add($fromuid,$needpay,$type,$typeid,$touid=0) {
         $time=time();
        $this->db->query("INSERT INTO `" . $this->db->dbprefix . "user_depositmoney` (`fromuid`,`needpay`,`type`,`typeid`,`touid`,`state`,`time`) VALUES ($fromuid,$needpay,'$type',$typeid,$touid,'0','{$time}')");
          $id = $this->db->insert_id();

        return $id;
    }

    function remove($fromuid,$type,$typeid) {
    	 $model= $this->db->query("SELECT * FROM " . $this->db->dbprefix . "user_depositmoney WHERE fromuid=$fromuid and type='$type' and typeid=$typeid and state=0")->row_array();
        if ($model) {
        	$money=$model['needpay']*100;
        	$needpay=$model['needpay'];
        	 $this->db->query("UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine+'$money' WHERE `uid`=$fromuid");
        	  $time=time();
            			   $this->db->query("INSERT INTO ".$this->db->dbprefix."paylog SET type='th$type',typeid=$typeid,money=$needpay,openid='',fromuid=0,touid=$fromuid,`time`=$time");
        }
        $this->db->query("DELETE FROM `" . $this->db->dbprefix . "user_depositmoney` WHERE fromuid=$fromuid and type='$type' and typeid=$typeid");

    }
  /*更新托管资金状态 */
    function update($fromuid,$type,$typeid){
    	$this->db->query("UPDATE " . $this->db->dbprefix . "user_depositmoney SET  `state`=1 WHERE fromuid=$fromuid and type='$type' and typeid=$typeid");
    }





}

?>