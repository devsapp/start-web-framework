<?php

class Inform_model extends  CI_Model{
    var $reasons= array(
            '含有反动的内容',
            '含有人身攻击的内容',
            '含有广告性质的内容',
            '涉及违法犯罪的内容',
            '含有违背伦理道德的内容',
            '含色情、暴力、恐怖的内容',
            '含有恶意无聊灌水的内容'
    );

      function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

    function get($qid) {
    	$qid=intval($qid);
    	$query = $this->db->get_where ( 'inform', array (
    			'qid' => $qid
    	) );
    	$m = $query->row_array ();
    	if ($m) {
    		return $m;
    	}else{
    		return null;
    	}
       
    }
    function getarticle($aid) {
    	$aid=intval($aid);
    	$query = $this->db->get_where ( 'inform', array (
    			'aid' => $aid
    	) );
    	$m = $query->row_array ();
    	if ($m) {
    		return $m;
    	}else{
    		return null;
    	}
    }
    function add($qid,$qtitle,$uid,$username,$aid,$title,$content,$keywords) {
    	$uid=intval($uid);
    	if($uid==0){
    		
    		return;
    	}
    	$qid=intval($qid);
    	$aid=intval($aid);
        $time = $this->base->time;
        $data=array("uid"=>$uid,"aid"=>intval($aid),"qid"=>intval($qid),"title"=>$title,"qtitle"=>$qtitle,"username"=>$username,"content"=>$content,"keywords"=>$keywords,"time"=>$time);
        $this->db->insert("inform",$data);
        $id=$this->db->insert_id ();
        if($qid&&$this->get($qid)!=null){
        	$this->update($title,$content,$keywords,$qid);
        }
        if($aid&&$this->getarticle($aid)!=null){
        	$this->updatearticle($title,$content,$keywords,$aid);
        }
        return $id;
    }
    function update($title,$content,$keywords,$qid) {
    	$this->db->where(array('qid'=>$qid))->set ( 'counts', 'counts+1', FALSE )->update('inform');
       
    }
    function updatearticle($title,$content,$keywords,$aid) {
    	$this->db->where(array('aid'=>$aid))->set ( 'counts', 'counts+1', FALSE )->update('inform');
    	

    }
    function get_list($start=0,$limit=10) {
        $informlist=array();
        $query=$this->db->query("SELECT * FROM ".$this->db->dbprefix."inform ORDER BY time DESC LIMIT $start,$limit");
        	foreach ( $query->result_array () as $inform ) {
            $inform['time']=tdate($inform['time'],3,0);
            switch ($inform['keywords']){
            	case '1':
            		$inform['keywords']="检举内容";
            		break;
            			case '2':
            				$inform['keywords']="检举用户";
            		break;
            		default:
            			$inform['keywords']="检举内容";
            			break;
            }
               switch ($inform['title']){
            	case '4':
            		$inform['title']="广告推广";
            		break;
            			case '5':
            				$inform['title']="恶意灌水";
            		break;
            		case '6':
            		$inform['title']="回答内容与提问无关";
            		break;
            			case '7':
            				$inform['title']="抄袭答案";
            		break;
            			case '8':
            				$inform['title']="其它";
            		break;
            		default:
            			$inform['title']="恶意灌水";
            			break;
            }
            $informlist[]=$inform;
        }
        return $informlist;
    }
    function get_reasons($keys){
        $strreason = '';
        foreach ($keys as $key){
            $strreason .=','. $this->reasons[$key];
        }
        return substr($strreason,1);
    }

    function remove_by_id($qids){
    	$this->db->where_in('id',explode(',', $qids))->delete('inform');
       
    }

}
?>
