<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_gift extends ADMIN_Controller {

    	function __construct() {
		parent::__construct (  );
        $this->load->model('gift_model');
        $this->load->model('setting_model');
    }

    function index($msg = '') {
        $msg && $message = $msg;
        @$page = max(1, intval($this->uri->segment ( 3 ) ));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $giftlist = $this->gift_model->get_list($startindex, $pagesize);
        $giftnum = returnarraynum ( $this->db->query ( getwheresql ('gift','1=1' ,$this->db->dbprefix ) )->row_array () );
        $departstr = page($giftnum, $pagesize, $page, "admin_gift/index");
        $gift_range = unserialize($this->setting['gift_range']);
        include template('giftlist', 'admin');
    }

    function add() {
        if (null!==$this->input->post ('submit')) {
            $title =strip_tags( $this->input->post ('giftname'));
            $desrc = strip_tags($this->input->post ('giftdesrc'));
            $credit = intval($this->input->post ('giftprice'));
            $imgname =strip_tags( strtolower($_FILES['imgurl']['name']));
            if ('' == $title || !$credit) {
                $this->index('请正确填写礼品相关信息！');
                exit;
            }
            $type = substr(strrchr($imgname, '.'), 1);
            if (!isimage($type)) {
                $this->index('图片格式不支持，目前仅支持jpg、gif、png格式！');
                exit;
            }
            $filepath = '/data/attach/giftimg/gift' . random(6, 0) . '.' . $type;
            forcemkdir(FCPATH . '/data/attach/giftimg');
            if (move_uploaded_file($_FILES['imgurl']['tmp_name'], FCPATH . $filepath)) {
                $this->gift_model->add($title, $desrc, $filepath, $credit);
                $this->index('添加成功！');
            } else {
                $this->index('服务器忙，请稍后再试！');
            }
        } else {
            include template('addgift', 'admin');
        }
    }

    function edit() {
        $gid = intval($this->uri->segment ( 3 ) ) ? $this->uri->segment ( 3 )  : $this->input->post ('id');
        if (null!==$this->input->post ('submit')) {
            $title = $this->input->post ('giftname');
            $desrc = $this->input->post ('giftdesrc');
            $credit = intval($this->input->post ('giftprice'));
            $imgname = strtolower($_FILES['imgurl']['name']);
            if ('' == $title || !$credit) {
                $message = '请正确填写礼品相关信息';
                $type = 'errormsg';
                include template('addgift', 'admin');
                exit;
            }

            $type = substr(strrchr($imgname, '.'), 1);
            if (!empty($_FILES['imgurl']['tmp_name']) && (!isimage($type))) {
                $message = '图片格式不支持，目前仅支持jpg、gif、png格式！';
                $type = 'errormsg';
                include template('addgift', 'admin');
                exit;
            }


            $filepath = '/data/attach/giftimg/gift' . random(6, 0) . '.' . $type;
            forcemkdir(FCPATH . '/data/attach/giftimg');
            if (!empty($_FILES['imgurl']['tmp_name']) && (!move_uploaded_file($_FILES['imgurl']['tmp_name'], FCPATH . $filepath))) {
                $message = '服务器忙，请稍后再试！';
                $type = 'errormsg';
                include template('addgift', 'admin');
                exit;
            }
            empty($_FILES['imgurl']['tmp_name']) && $filepath = $this->input->post ('imgpath');


            $this->gift_model->update($title, $desrc, $filepath, $credit, $gid);
            $message = "修改成功!";
        }

        $gift = $this->gift_model->get($gid);
        include template('addgift', 'admin');
    }

    function addrange() {
        $rangelist = unserialize($this->setting['gift_range']);
        if (null!==$this->input->post ('submit')) {
            $ranges = $this->input->post ('gift_range');
            $rangesize = count($ranges);
            $giftrange = array();
            for ($i = 0; $i < $rangesize; $i++) {
                if ($i % 2 == 0 && ($ranges[$i] != NULL || $ranges[$i + 1] != NULL))
                    $giftrange[$ranges[$i]] = $ranges[$i + 1];
            }

            $rangelist = $giftrange;
            $this->setting['gift_range'] = serialize($giftrange);
            $this->setting_model->update($this->setting);
            $message = '设置成功！';
        }
        include template('giftrange', 'admin');
    }

    function note() {
        if (null!==$this->input->post ('submit')) {
            $this->setting['gift_note'] = $this->input->post ('note');
            $this->setting_model->update($this->setting);
            $message = '设置公告成功！';
        }
        include template('giftnote', 'admin');
    }

    function remove() {
        $message = '没有选择礼品！';
        if (null!==$this->input->post ('gid')) {
            $gids = implode(",", $this->input->post ('gid'));
            $this->gift_model->remove_by_id($gids);
            $message = '礼品删除成功！';
            unset($_GET);
        }
        $this->index($message);
    }

    function available() {
        if (null!==$this->input->post ('gid')) {
            $gids = implode(",", $this->input->post ('gid'));
            $this->gift_model->update_available($gids, $this->uri->segment ( 3 ) );
            $message = $this->uri->segment ( 3 )  ? '礼品设为可用成功!' : '礼品设置过期成功!';
             unset($_GET);
            $this->index($message);
        }
    }

    function log($msg = '') {
        @$page = max(1, intval($this->uri->segment ( 3 ) ));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $loglist = $this->gift_model->getloglist($startindex, $pagesize);

        $giftlognum = returnarraynum ( $this->db->query ( getwheresql ('giftlog','1=1' ,$this->db->dbprefix ) )->row_array () );
        $departstr = page($giftlognum, $pagesize, $page, "admin_gift/log");
        $msg && $message = $msg;
        $gift_range = unserialize($this->setting['gift_range']);
        include template("giftloglist", 'admin');
    }

    function csend() {
        if (null!==$this->input->post ('id')) {
            $this->load->model("message_model");
            $ids = implode(",", $this->input->post ('id'));
            $this->gift_model->update_gift_status($ids, $this->uri->segment ( 3 ) );
            $message = '礼品成功设置为已送出！';
            $msgfrom = $this->setting['site_name'] . '管理员';
            foreach ($this->input->post ('id') as $logid) {
                $giftlog = $this->gift_model->getlog($logid);
                $this->message_model->add($msgfrom, 0, $giftlog['uid'],'您在礼品商店兑换的商品"'.$giftlog['giftname'].'"已经发货了，请注意查收!','您在礼品商店兑换的商品"'.$giftlog['giftname'].'已经发货了，请注意查收!<br />如长时间未收到兑换商品请与管理员联系!"');
            }
            unset($this->get);
            $this->log($message);
        }
    }

    function search() {

        @$page = max(1, intval($this->uri->segment ( 5) ));
        $range = null!==$this->input->post ('pricerange') ? $this->input->post ('pricerange') : $this->uri->segment ( 3 ) ;
        $giftname = null!==$this->input->post ('giftname') ? $this->input->post ('giftname') : $this->uri->segment ( 4 ) ;
        $pagesize = 1;
        $startindex = ($page - 1) * $pagesize;
        $rangesql = '';
        $ranges = explode("-", $range);
        $giftlist = $this->gift_model->get_by_range_name($ranges, $giftname, $startindex, $pagesize);
        (count($ranges) > 1) && $rangesql = "AND `credit`>=$ranges[0] AND `credit`<=$ranges[1]";
        $rownum = returnarraynum ( $this->db->query ( getwheresql ('gift', " `title` LIKE '$giftname%' $rangesql", $this->db->dbprefix ) )->row_array () );
        $departstr = page($rownum, $pagesize, $page, "admin_gift/search/$range/$giftname");
        $gift_range = unserialize($this->setting['gift_range']);
        include template('giftlist', 'admin');
    }

    function logsearch() {
        $pricerange = null!==$this->uri->segment ( 3 )  ? $this->uri->segment ( 3 )  : $this->input->post ('pricerange');
        $giftname = null!==$this->uri->segment ( 4 )  ? $this->uri->segment ( 4 )  : $this->input->post ('giftname');
        $username = null!==$this->uri->segment ( 5)  ? $this->uri->segment ( 5)  : $this->input->post ('username');
        $datestart =null!==$this->uri->segment ( 6)  ? $this->uri->segment ( 6)  : $this->input->post ('srchregdatestart');
        $dateend =null!==$this->uri->segment ( 7)  ? $this->uri->segment ( 7)  : $this->input->post ('srchregdateend');
        @$page = max(1, intval($this->uri->segment ( 8) ));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $loglist = $this->gift_model->list_by_searchlog($pricerange, $giftname, $username, $datestart, $dateend, $startindex, $pagesize);
        $giftlognum = $this->gift_model->rownum_by_searchlog($pricerange, $giftname, $username, $datestart, $dateend);
        $departstr = page($giftlognum, $pagesize, $page, "admin_gift/logsearch/$pricerange/$giftname/$username/$datestart/$dateend");
        $gift_range = unserialize($this->setting['gift_range']);
        include template("giftloglist", 'admin');
    }

}

?>