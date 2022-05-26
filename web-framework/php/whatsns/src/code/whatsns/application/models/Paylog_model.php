<?php

class Paylog_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	function getone($type,$typeid,$fromuid,$touid){
		$one = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "paylog WHERE type='$type' and typeid=$typeid and touid=$touid and fromuid=$fromuid" )->row_array ();
		return $one;
	}
	function addlog($type, $typeid, $money, $openid = '', $fromuid = '', $touid = '') {
		$time = $this->base->time;
		$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='$type',typeid=$typeid,money=$money,openid='$openid',fromuid=$fromuid,touid=$touid,`time`=$time" );
		$id = $this->db->insert_id ();
		return $id;
	}
	function delete($id) {
		$this->db->query ( "DELETE FROM " . $this->db->dbprefix . "paylog WHERE `id` IN ('$id')" );
	}

	function selectbyfromuid($fromuid, $typeid) {
		$one = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "paylog WHERE type='myviewaid' and touid=$fromuid and typeid=$typeid" )->row_array ();
		return $one;
	}
	//查看当前回答偷看总人数
	function getviewanswersnum($type, $typeid) {
		$this->db->where ( array ('type' => $type, 'typeid' => $typeid ) )->from ( 'paylog' );
		return $this->db->count_all_results ();
	}
	function gettotalmoney($type, $typeid) {
		$model = $this->db->query ( "SELECT sum(money) as qian FROM " . $this->db->dbprefix . "paylog WHERE type='$type'and typeid=$typeid" )->row_array ();

		return $model ['qian'];
	}
	function getlist_bytype($type, $typeid, $start = 0, $limit = 20) {
		$recargelist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "paylog where type='$type' and typeid=$typeid and type not in('paysite_zhuanjia','paysite_xuanshang','paysite_toukan')  ORDER BY time DESC  LIMIT $start,$limit" );
		$suffix = '?';
		if ($this->base->setting ['seo_on']) {
			$suffix = '';
		}
		foreach ( $query->result_array () as $money ) {
			$money ['time'] = tdate ( $money ['time'] );
			switch ($money ['type']) {
				case 'viewaid' :
					$money ['operation'] = '用户付费偷看';
					$money ['money'] = "收入" . $money ['money'] . "元";
					$mod = $this->getanswer ( $money ['typeid'] );

					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['qid'], 2 );
					$money ['content'] = "偷看回答的问题:<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";

					break;
				case 'myviewaid' :
					$money ['operation'] = '我的偷看回答';
					$money ['money'] = "支出" . $money ['money'] . "元";
					$mod = $this->getanswer ( $money ['typeid'] );

					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['qid'], 2 );
					$money ['content'] = "付费偷看回答的问题:<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";

					break;
				case 'coursebuy' :
					$money ['operation'] = '购买课程';
					$course=$this->db->get_where('category',array('id'=>$money['typeid']))->row_array();
					$money ['money'] = "用户支付" . $money ['money'] . "元购买课程";
					$c_name=$course['name'];
					$money ['content'] = "购买课程[$c_name]";
					break;
				case 'wxqbuytaocan' :
					$money ['operation'] = '购买套餐';
					$taocan=$this->db->get_where('weixiaoqiang_taocanbuy',array('taocanid'=>$money['typeid']))->row_array();
					$money ['money'] = "用户支付" . $money ['money'] . "元购买套餐";
					$c_name=$taocan['taocanname'];
					$money ['content'] = "购买套餐[$c_name]";
					break;
				case 'usertixian' :
					$money ['operation'] = '用户提现申请';

					$money ['money'] = "支出" . $money ['money'] . "元";

					$money ['content'] = "来自用户提现申请";
					break;
				case 'topayarticle' :
					$money ['operation'] = '用户付费阅读';
					
					$money ['money'] = "支出" . $money ['money'] . "元";
					$mod = $this->gettopic ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'topic/getone/' . $mod ['id'], 2 );
					$money ['content'] = "您付费阅读了文章：<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					
					break;
				case 'payarticle' :
					$money ['operation'] = '用户付费阅读';
					
					$money ['money'] = "收入" . $money ['money'] . "元";
					
					$mod = $this->gettopic ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'topic/getone/' . $mod ['id'], 2 );
					$money ['content'] = "用户付费阅读了您的文章：<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					
					break;
				case 'vertify' :
					$money ['operation'] = '用户付费认证专家';
					
					$money ['money'] = "支出" . $money ['money'] . "元";
					
					$money ['content'] = "来自用户付费认证专家";
					break;
					
				case 'thusertixian' :
					$money ['operation'] = '返回用户提现金额';

					$money ['money'] = "收入" . $money ['money'] . "元";

					$money ['content'] = "返回用户提现金额到用户钱包里";
					break;
						case 'appbuy' :
					$money ['operation'] = '购买应用';
                   $money ['money'] = "支出" . $money ['money'] . "元";
					$money ['content'] = "来自应用商店付款付款";
					break;
				case 'chongzhi' :
					$money ['operation'] = '用户充值';

					$money ['money'] = "收入" . $money ['money'] . "元";

					$money ['content'] = "来自用户充值付款";
					break;
				case 'creditchongzhi' :
					$money ['operation'] = '用户充值财富值';
					$credit2 = $money ['money'] * $this->base->setting ['recharge_rate'];

					$money ['money'] = "获得" . $credit2 . "财富值";

					$money ['content'] = "来自用户财富值充值付款";
					break;
				case 'aid' :
					$money ['operation'] = '回答打赏';
					$mod = $this->getanswer ( $money ['typeid'] );
					$money ['money'] = "收入" . $money ['money'] . "元";
					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['qid'], 2 );
					$money ['content'] = "<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					break;
				case 'tid' :

					if ($money ['fromuid'] == 0) {
						$money ['operation'] = '网友打赏' . $money ['money'] . "元" . '-' . $money ['time'];
						$money ['url'] = "javascript:void(0)";
					} else {
						$_uid = $money ['fromuid'];
						$user = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE uid='$_uid'" )->row_array ();
						$money ['operation'] = $user ['username'] . '打赏' . $money ['money'] . "元" . '-' . $money ['time'];
						$money ['url'] = SITE_URL . $suffix . urlmap ( 'user/space/' . $money ['fromuid'], 2 ) . ".html";
					}

					$money ['avatar'] = get_avatar_dir ( $money ['fromuid'] );
					break;
				case 'wtxuanshang' :
					$money ['operation'] = '提问悬赏';
					$mod = $this->getquestion ( $money ['typeid'] );
					$money ['money'] = "支出" . $money ['money'] . "元";
					if ($mod == null) {
						$money ['content'] = "此悬赏问题被删除，问题qid=" . $money ['typeid'];
					} else {
						$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['id'], 2 );
						$money ['content'] = "悬赏标题-><a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					}
					break;
				case 'adoptqid' :
					$money ['operation'] = '回答被采纳';
					$money ['money'] = "收入" . $money ['money'] . "元";
					$mod = $this->getquestion ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['id'], 2 );
					$money ['content'] = "<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					break;
				case 'thqid' :
					$money ['operation'] = '问题被删除退还悬赏金额';
					$money ['money'] = "收入" . $money ['money'] . "元";

					$money ['content'] = "此删除问题qid=" . $money ['typeid'];
					break;
				case 'closeqid' :
					$money ['operation'] = '问题被关闭退还悬赏金额';
					$money ['money'] = "收入" . $money ['money'] . "元";
					$mod = $this->getquestion ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['id'], 2 );
					$money ['content'] = "关闭标题-><a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";

					break;
				case 'theqid' :
					$money ['operation'] = '退还对专家付费提问金额';
					$money ['money'] = "收入" . $money ['money'] . "元";
					$mod = $this->getquestion ( $money ['typeid'] );
					if ($mod == null) {
						$money ['content'] = "此问题被删除，问题qid=" . $money ['typeid'];
					} else {
						$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['id'], 2 );
						$money ['content'] = "标题-><a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					}

					break;
				case 'eqid' :
					$money ['operation'] = '用户对专家提问采纳收入';
					$money ['money'] = "收入" . $money ['money'] . "元";
					$mod = $this->getquestion ( $money ['typeid'] );
					if ($mod == null) {
						$money ['content'] = "此问题被删除，问题qid=" . $money ['typeid'];
					} else {
						$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['id'], 2 );
						$money ['content'] = "标题-><a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					}

					break;
			}

			$recargelist [] = $money;
		}
		return $recargelist;
	}

}

?>
