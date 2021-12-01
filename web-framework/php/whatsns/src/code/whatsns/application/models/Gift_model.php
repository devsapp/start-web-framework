<?php


class Gift_model  extends  CI_Model{

function __construct() {
		 parent::__construct();
		$this->load->database ();
	}
    function get($id) {
    	$id=intval($id);
    	$query = $this->db->get_where ( 'gift', array (
    			'id' => $id
    	) );
    	$gift = $query->row_array ();
    	if ($gift) {
    		return $gift;
    	}else{
    		return null;
    	}
   
    }

    function get_list($start = 0, $limit = 10) {
        $giftlist = array();
        $query = $this->db->query("select * from " . $this->db->dbprefix . "gift order by time desc limit $start,$limit");
        foreach ( $query->result_array () as $gift ) {
            $gift['time'] = tdate($gift['time'], 3, 0);
            $giftlist[] = $gift;
        }
        return $giftlist;
    }

    function get_by_range($from, $to, $start = 0, $limit = 10) {
    	$from=doubleval($from);
    	$to=doubleval($to);
        $giftlist = array();
        $query = $this->db->query("SELECT * FROM " . $this->db->dbprefix . "gift WHERE `credit`>=$from AND `credit`<=$to ORDER BY `time` DESC LIMIT $start,$limit");
        foreach ( $query->result_array () as $gift ) {
            $gift['time'] = tdate($gift['time'], 3, 0);
            $giftlist[] = $gift;
        }
        return $giftlist;
    }

    function get_by_range_name($ranges, $name = '', $start = 0, $limit = 10) {
    	$name=addslashes($name);
        $giftlist = array();
        $rangesql = '';
        (count($ranges) > 1) && $rangesql = "AND `credit`>=$ranges[0] AND `credit`<=$ranges[1]";
        $query = $this->db->query("SELECT * FROM " . $this->db->dbprefix . "gift WHERE  `title` LIKE '$name%' $rangesql ORDER BY `time` DESC LIMIT $start,$limit");
        foreach ( $query->result_array () as $gift ) {
            $gift['time'] = tdate($gift['time'], 3, 0);
            $giftlist[] = $gift;
        }
        return $giftlist;
    }

    function add($title, $description, $image, $credit) {
    	$time=time();
    	$data=array(
    			'title'=>$title,
    			'description'=>$description,
    			'image'=>$image,
    			'credit'=>$credit,
    			'time'=>$time
    		
    			
    	);
    	$this->db->insert('gift',$data);

        return $this->db->insert_id();
    }

    function update($title, $desrc, $filepath, $credit, $id) {
    	$data=array(
    			'title'=>$title,
    			'description'=>$desrc,
    			'image'=>$filepath,
    			'credit'=>$credit
    	);
    	$this->db->where(array('id'=>$id))->update('gift',$data);
       
    }

    function remove_by_id($ids) {
    	$this->db->where_in('id',$ids)->delete('gift');
     
    }

    function update_available($id, $available) {
    	$data=array(
    			'available'=>$available
    		
    	);
    	$this->db->where(array('id'=>$id))->update('gift',$data);
    	

    }

    function addlog($uid, $gid, $username, $realname, $email, $phone, $address, $postcode, $giftname, $qq, $notes, $credit) {
        $time=time();
        $data=array(
        		'uid'=>$uid,
        		'gid'=>$gid,
        		'notes'=>$notes,
        		'email'=>$email,
        		'qq'=>$qq,
        		'phone'=>$phone,
        		'postcode'=>$postcode,
        		'address'=>$address,
        		'username'=>$username,
        		'realname'=>$realname,
        		'giftname'=>$giftname,
        		'credit'=>$credit,
        		'time'=>$time
        		
        );
        $this->db->insert('giftlog',$data);
    }

    function getlog($logid) {
    	$logid=intval($logid);
        return $this->db->query("SELECT * FROM " . $this->db->dbprefix . "giftlog WHERE id='$logid'")->row_array();
    }

    function getloglist($start = 0, $limit = 10) {
        $loglist = array();
        $query = $this->db->query("SELECT * FROM " . $this->db->dbprefix . "giftlog ORDER BY `time` DESC LIMIT $start,$limit");
        foreach ( $query->result_array () as $log ) {
            $log['time'] = tdate($log['time'], 3, 0);
            $loglist[] = $log;
        }
        return $loglist;
    }

    function update_gift_status($ids, $status = 1) {
    	$data=array(
    			'status'=>$status
    			
    	);
    	$this->db->where(array('id'=>$ids))->where('status!=',$status)->update('giftlog',$data);
    	
  
    }

    function list_by_searchlog($pricerange, $giftname, $username, $datestart, $dateend, $start = 0, $limit = 10) {
    	$giftname=addslashes($giftname);
    	$pricerange=addslashes($pricerange);
    	$sql = "SELECT * FROM `" . $this->db->dbprefix . "giftlog` WHERE 1=1 ";
        $giftname && $sql.=" AND `giftname` LIKE '$giftname%' ";
        $username && $sql.="AND `username` LIKE '$username%' ";
        $datestart && ($sql .= " AND `time` >= " . strtotime($datestart));
        $dateend && ($sql .=" AND `time` <= " . strtotime($dateend));
        if ($pricerange && ($pricerange != 'all')) {
            $ranges = explode("-", $pricerange);
            print_r($ranges);
            $sql.=" AND `credit`>" . intval($ranges[0]) . " AND `credit`<= " . intval($ranges[1]);
        }
        $sql.=" ORDER BY `time` DESC LIMIT $start,$limit";
        $giftloglist = array();
        $query = $this->db->query($sql);
        foreach ( $query->result_array () as $log ) {
            $log['time'] = tdate($log['time'], 3, 0);
            $giftloglist[] = $log;
        }
        return $giftloglist;
    }

    function rownum_by_searchlog($pricerange, $giftname, $username, $datestart, $dateend) {
    	$giftname=addslashes($giftname);
    	$pricerange=addslashes($pricerange);
        $condition = " 1=1 ";
        $giftname && $condition.=" AND `giftname` LIKE '$giftname%' ";
        $username && $condition.=" AND `username` LIKE '$username%' ";
        $datestart && ($condition .= " AND `time` >= " . strtotime($datestart));
        $dateend && ($condition .=" AND `time` <= " . strtotime($dateend));
        if ($pricerange && ($pricerange != 'all')) {
            $ranges = explode("-", $pricerange);
            $condition.=" AND `credit`>$ranges[0] AND `credit`<= $ranges[1] ";
        }

        $m= $this->db->query("select count(*) as num from ".$this->db->dbprefix."giftlog where $condition ")->row_array();
        return $m['num'];
    }

}

?>
