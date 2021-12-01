<?php
class Dashang_model extends CI_Model{

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

    function get_list($start = 0, $limit = 10,$begintime=0,$endtime=0) {
        $mdlist = array();

         $query='';
         if($begintime>0){
         	 $query = $this->db->query("SELECT * FROM `".$this->db->dbprefix ."weixin_notify`  WHERE  time_end>=$begintime and time_end <=$endtime ORDER BY `time_end` DESC limit $start,$limit");

         }else{
         	 $query = $this->db->query("SELECT * FROM `".$this->db->dbprefix ."weixin_notify` ORDER BY `time_end` DESC limit $start,$limit");

         }


         	foreach ( $query->result_array () as $md ) {

            $md['format_time'] = tdate($md['time_end']);
            $md['cash_fee']=$md['cash_fee']/100;

            $arr=preg_split('_',  $md['attach']);


            $type=$arr[0];
             $md['type']=$type;
             $dashangren=$this->f_get($md['openid']);
             $md['nickname']=$dashangren['nickname'];
              $md['headimgurl']=$dashangren['headimgurl'];
            switch ($type){
            	case 'aid':
            		 $md['type']="打赏回答";
            		$md['model']=$this->getanswer($arr[1]);
            		break;
            			case 'qid':
            					 $md['type']="打赏提问";
            		break;
            			case 'chongzhi':
            					 $md['type']="用户充值";
            		break;
            			case 'creditchongzhi':
            					 $md['type']="用户财富积分充值";
            		break;
            			case 'tid':
            					 $md['type']="打赏文章";
            				$md['model']=$this->gettopic($arr[1]);
            		break;

            }

            switch (    $md['trade_trye']){
            	case "NATIVE":
            		$md['laiyuan']="扫码支付";
            		break;
            		case "JSAPI":
            			$md['laiyuan']="微信浏览器请求";
            		break;
            }

             $mdlist[] = $md;
        }


        return $mdlist;
    }
   /* 根据aid获取一个答案的内容，暂时无用 */

    function getanswer($id) {
        $answer= $this->db->query("SELECT * FROM " . $this->db->dbprefix . "answer WHERE id='$id'")->row_array();

         if ($answer) {

             $answer['title']=checkwordsglobal( $answer['title']);
              $answer['content']=checkwordsglobal( $answer['content']);
        }
        return $answer;
    }
function f_get($openid) {
         $model =  $this->db->query("SELECT * FROM " . $this->db->dbprefix . "weixin_follower where openid='$openid' limit 0,1")->row_array();


        return $model;
    }

    function gettopic($id) {
         $topic =  $this->db->query("SELECT * FROM " .  $this->db->dbprefix . "topic WHERE id='$id'")->row_array();

        if ($topic) {
            $topic['viewtime'] = tdate($topic['viewtime']);
            $topic['title'] = checkwordsglobal($topic['title']);

        }
        return $topic;
    }


}

?>
