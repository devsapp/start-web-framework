<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Gift extends CI_Controller {

     function __construct() {
      parent::__construct ();
        $this->load->model('gift_model');
        $this->load->model('user_model');
    }

    function index() {
    	$navtitle = "礼品商店";
        @$page = max(1, intval($this->uri->segment ( 3 )));
        $pagesize= 12;
        $startindex = ($page - 1) * $pagesize;
        $giftlist = $this->gift_model->get_list($startindex,$pagesize);
        $giftnum=returnarraynum ( $this->db->query ( getwheresql ( 'gift','1=1', $this->db->dbprefix ) )->row_array () );
        $departstr=page($giftnum, $pagesize, $page,"gift/default");
        $loglist = $this->gift_model->getloglist(0, 30);
        include template('giftlist');
    }

    function search() {
        $from = intval($this->uri->segment ( 3 ));
        $to = intval($this->uri->segment ( 4 ));
        @$page = max(1, intval($this->uri->segment ( 5 )));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $giftlist = $this->gift_model->get_by_range($from,$to,$startindex,$pagesize);
        $rownum=returnarraynum ( $this->db->query ( getwheresql ( 'gift'," `credit`>=$from AND `credit`<=$to", $this->db->dbprefix ) )->row_array () );
        $departstr=page($rownum, $pagesize, $page,"gift/search/$from/$to");
        $ranglist = unserialize($this->setting['gift_range']);
        include template('giftlist');
    }

    function add() {
    	if(!$this->user['uid']){
    		$this->message("登录后兑换礼品!",'gift/default');
    	}
        if(null!==$this->input->post ( 'realname')) {
            $realname =strip_tags( $this->input->post ( 'realname'));
            $email = strip_tags( $this->input->post ( 'email'));
            $phone =strip_tags(  $this->input->post ( 'phone'));
            $addr =strip_tags(  $this->input->post ( 'addr'));
            $postcode =strip_tags( $this->input->post ( 'postcode'));
            $qq =strip_tags(  $this->input->post ( 'qq'));
            $notes =strip_tags(  $this->input->post ( 'notes'));
            $gid =intval(strip_tags(  $this->input->post ( 'gid')));
            $param = array();
            if(''==$realname || ''==$email || ''==$phone||''==$addr||''==$postcode) {
                $this->message("为了准确联系到您，真实姓名、邮箱、联系地址（邮编）、电话不能为空！",'gift/default');
            }

            if (!preg_match("/^[a-z'0-9]+([._-][a-z'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/",$email)) {
                $this->message("邮件地址不合法!",'gift/default');
            }

            //if(($this->user['email'] != $email) && returnarraynum ( $this->db->query ( getwheresql ( 'user'," email='$email' ", $this->db->dbprefix ) )->row_array () )) {
               // $this->message("此邮件地址已经注册!",'gift/default');
            //}

            $gift = $this->gift_model->get($gid);
            if($this->user['credit2']<$gift['credit']) {
                $this->message("抱歉！您的财富值不足不能兑换该礼品!",'gift/default');
            }


            $this->gift_model->addlog($this->user['uid'],$gid,$this->user['username'],$realname,$this->user['email'],$phone,$addr,$postcode,$gift['title'],$qq,$notes,$gift['credit']);
            $this->credit($this->user['uid'],0,-$gift['credit']);//扣除财富值
            $this->message("礼品兑换申请已经送出等待管理员审核！","gift/default");
        }
    }

}
?>