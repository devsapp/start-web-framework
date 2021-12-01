<?php
class Duizhang_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function get_list($start = 0, $limit = 10, $begintime = 0, $endtime = 0, $username = '', $whereselectoption = '') {
		global $setting;
		$recargelist = array ();

		$query = '';
		$where_username = '';
		$_touid = 0;
		$timebetween = '';
		if ($username != '') {
			$_user = $this->get_by_username ( $username );
			if ($_user) {
				$_touid = $_user ['uid'];
				$where_username = ' and touid =' . $_user ['uid'];
			}

		}
		if ($begintime > 0) {
			$timebetween = " and time>=$begintime and time <=$endtime ";
		}
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "paylog` where 1=1   $where_username $whereselectoption $timebetween ORDER BY `time` DESC limit $start,$limit" );

		$suffix = '?';
		if ($setting ['seo_on']) {
			$suffix = '';
		}
		foreach ( $query->result_array () as $money ) {
			$money ['time'] = tdate ( $money ['time'] );
			$money ['touser'] = $this->get_by_uid ( $money ['touid'] );

			$money ['fromuser'] = $money ['fromuid'] != 0 ? $this->get_by_uid ( $money ['fromuid'] ) : null;
			switch ($money ['type']) {
				case 'shoudongchonzhi' :
					$money ['operation'] = '管理员手动修改用户金额';
					
					$money ['money'] = "后台修改金额" . $money ['money'] . "元";
					
					$money ['content'] = "后台管理员手动修改用户金额";
					break;
				case 'confirmtixian' :
					$money ['operation'] = '管理员审核提现请求';
					
					$money ['money'] = "用户微信零钱收到" . $money ['money'] . "元";
					
					$money ['content'] = "后台管理员确认用户提现请求";
					break;
				case 'coursevipchonzhi' :
					$money ['operation'] = 'VIP充值';
					$course_vip=$this->db->get_where('course_vip',array("id"=>$money['typeid']))->row_array();
					$money ['shouru'] = "用户支付" . $money ['money'] . "元购买VIP";
					
					
					$money ['content'] = "充值办理vip".$course_vip['cardtype'];
					
					break;
				case 'wxqbuytaocan' :
					$money ['operation'] = '购买套餐';
					$taocan=$this->db->get_where('weixiaoqiang_taocanbuy',array('taocanid'=>$money['typeid']))->row_array();
					$money ['money'] = "用户支付" . $money ['money'] . "元购买套餐";
					$c_name=$taocan['taocanname'];
					$money ['content'] = "购买套餐[$c_name]";
					break;
				case 'viewaid' :
					$money ['operation'] = '用户付费偷看';
					$money ['money'] = "收入" . $money ['money'] . "元";
					$mod = $this->getanswer ( $money ['typeid'] );

					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['qid'], 2 );
					$money ['content'] = "偷看回答的问题:<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";

					break;
				case 'myviewaid' :
					$money ['operation'] = $money ['touser'] ['username'] . '的偷看回答';
					$money ['money'] = "支出" . $money ['money'] . "元";
					$mod = $this->getanswer ( $money ['typeid'] );

					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['qid'], 2 );
					$money ['content'] = "付费偷看回答的问题:<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";

					break;
						case 'appbuy' :
					$money ['operation'] = '购买应用';
                   $money ['money'] = "支出" . $money ['money'] . "元";
					$money ['content'] = "来自应用商店付款付款";
					break;
				case 'usertixian' :
					$money ['operation'] = '用户提现申请';

					$money ['money'] = "支出" . $money ['money'] . "元";

					$money ['content'] = "来自用户提现申请";
					break;
				case 'appbuyshouhuo' :
					$money ['operation'] = '应用商店购买商品';
					
					$money ['money'] = "支出" . $money ['money'] . "元";
					
					$money ['content'] = "来自应用商店消费";
					break;
					
				case 'vertify' :
					$money ['operation'] = '用户认证';
					
					$money ['money'] = "支出" . $money ['money'] . "元";
					
					$money ['content'] = "来自用户认证费用";
					break;
				case 'payarticle' :
					$money ['operation'] = '用户付费阅读';
					
					$money ['money'] = "收入" . $money ['money'] . "元";
					
					$mod = $this->gettopic ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'topic/getone/' . $mod ['id'], 2 );
					$money ['content'] = "用户付费阅读了您的文章：<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					
					break;
				case 'topayarticle' :
					$money ['operation'] = '用户付费阅读';
					
					$money ['money'] = "支出" . $money ['money'] . "元";
					$mod = $this->gettopic ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'topic/getone/' . $mod ['id'], 2 );
					$money ['content'] = "您付费阅读了文章：<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					
					break;
					
				case 'paysite_xuanshang' :
					$money ['operation'] = '用户【' . $money ['touser'] ['username'] . '】的回答被采纳网站提成收入';
					$mod = $this->getquestion ( $money ['typeid'] );
					$money ['money'] = "平台收取提成" . $money ['money'] . "元";
					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['id'], 2 );
					$money ['content'] = "<font color='red'>来源悬赏标题-><a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a></font>";

					break;
				case 'paysite_toukan' :
					$money ['operation'] = '付费偷看用户【' . $money ['touser'] ['username'] . '】回答，网站提成收入';
					$mod = $this->getanswer ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['qid'], 2 );

					$money ['money'] = "平台收取提成" . $money ['money'] . "元";
					$money ['content'] = "<font color='red'>来源问题---<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a></font>";

					break;
				case 'paysite_zhuanjia' :
					$money ['operation'] = '付费对' . '用户【' . $money ['touser'] ['username'] . '】提问网站提成收入';
					$mod = $this->getquestion ( $money ['typeid'] );
					$money ['money'] = "平台收取提成" . $money ['money'] . "元";

					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['id'], 2 );
					$money ['content'] = "<font color='red'>来源付费问题-><a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a></font>";

					break;
				case 'coursebuy' :
					$money ['operation'] = '购买课程';
					$course=$this->db->get_where('category',array('id'=>$money['typeid']))->row_array();
					$money ['money'] = "用户支付" . $money ['money'] . "元购买课程";
					$c_name=$course['name'];
					$money ['content'] = "购买课程[$c_name]";
					break;
				case 'thusertixian' :
					$money ['operation'] = '返回用户提现金额';

					$money ['money'] = "收入" . $money ['money'] . "元";

					$money ['content'] = "返回用户提现金额到用户钱包里";
					break;
				case 'chongzhi' :
					$money ['operation'] = '用户充值';

					$money ['money'] = "收入" . $money ['money'] . "元";

					$money ['content'] = "来自用户充值付款";
					break;
				case 'creditchongzhi' :
					$money ['operation'] = '用户财富积分充值';
					$credit2 = $money ['money'] * $setting ['recharge_rate'];

					$money ['money'] = "获得" . $credit2 . "积分";

					$money ['content'] = "来自用户财富积分充值付款";
					break;
				case 'aid' :
					$money ['operation'] = '回答打赏';
					$mod = $this->getanswer ( $money ['typeid'] );
					$money ['money'] = "收入" . $money ['money'] . "元";
					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['qid'], 2 );
					$money ['content'] = "<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					break;
				case 'tid' :
					$money ['operation'] = '文章打赏';
					$money ['money'] = "收入" . $money ['money'] . "元";
					$mod = $this->gettopic ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'topic/getone/' . $mod ['id'], 2 );
					$money ['content'] = "<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";

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
				case 'closeqid' :
					$money ['operation'] = '问题被关闭退还悬赏金额';
					$money ['money'] = "收入" . $money ['money'] . "元";
					$mod = $this->getquestion ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['id'], 2 );
					$money ['content'] = "关闭标题-><a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";

					break;
				case 'fufeitiwen' :
					$money ['operation'] = '付费提问';
					$mod = $this->getquestion ( $money ['typeid'] );
					$money ['money'] = "支出" . $money ['money'] . "元";
					if ($mod == null) {
						$money ['content'] = "此付费问题被删除，问题qid=" . $money ['typeid'];
					} else {
						$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['id'], 2 );
						$money ['content'] = "付费提问标题-><a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					}
					break;
				case 'eqid' :
					$money ['operation'] = '【' . $money ['fromuser'] ['username'] . '】对专家【' . $money ['touser'] ['username'] . '】提问';
					$mod = $this->getquestion ( $money ['typeid'] );
					$money ['money'] = "专家收入" . $money ['money'] . "元";
					if ($mod == null) {
						$money ['content'] = "此付费对专家提问的问题被删除，问题qid=" . $money ['typeid'];
					} else {
						$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['id'], 2 );
						$money ['content'] = "对专家提问标题-><a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
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
			}

			$recargelist [] = $money;
		}
		return $recargelist;
	}
	function getlastpaylog($start, $limit) {
		global $setting;
		$recargelist = array ();

		$query = '';

		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "paylog` where type!='usertixian' and type not in('paysite_zhuanjia','paysite_xuanshang','paysite_toukan')   ORDER BY `time` DESC limit $start,$limit" );

		$suffix = '?';
		if ($setting ['seo_on']) {
			$suffix = '';
		}
		foreach ( $query->result_array () as $money ) {
			//$fromuser=$this->getuser($money['touid']);
			// $money['cash_fee'] = $money['money']/100;


			// $money['fromusername'] =$fromuser['username'];
			$money ['time'] = tdate ( $money ['time'] );
			$money ['touser'] = $this->get_by_uid ( $money ['touid'] );
			$money ['author_has_vertify'] = get_vertify_info ( $money ['touid'] ); //用户是否认证
			$money ['fromuser'] = $money ['fromuid'] != 0 ? $this->get_by_uid ( $money ['fromuid'] ) : null;
			switch ($money ['type']) {
				case 'viewaid' :
					$money ['operation'] = '用户付费偷看';
					$money ['money'] = "收入" . $money ['money'] . "元";
					$mod = $this->getanswer ( $money ['typeid'] );

					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['qid'], 2 );
					$money ['content'] = "偷看回答的问题:<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";

					break;
				case 'myviewaid' :
					$money ['operation'] = $money ['touser'] ['username'] . '的偷看回答';
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
						case 'appbuy' :
					$money ['operation'] = '购买应用';
                   $money ['money'] = "支出" . $money ['money'] . "元";
					$money ['content'] = "来自应用商店付款付款";
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
				case 'thusertixian' :
					$money ['operation'] = '返回用户提现金额';

					$money ['money'] = "收入" . $money ['money'] . "元";

					$money ['content'] = "返回用户提现金额到用户钱包里";
					break;
				case 'chongzhi' :
					$money ['operation'] = '用户充值';

					$money ['money'] = "收入" . $money ['money'] . "元";

					$money ['content'] = "来自用户充值付款";
					break;
				case 'creditchongzhi' :
					$money ['operation'] = '用户财富积分充值';
					$credit2 = $money ['money'] * $setting ['recharge_rate'];

					$money ['money'] = "获得" . $credit2 . "积分";

					$money ['content'] = "来自用户财富积分充值付款";
					break;
				case 'aid' :
					$money ['operation'] = '回答打赏';
					$mod = $this->getanswer ( $money ['typeid'] );
					$money ['money'] = "收入" . $money ['money'] . "元";
					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['qid'], 2 );
					$money ['content'] = "<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					break;
				case 'tid' :
					$money ['operation'] = '文章打赏';
					$money ['money'] = "收入" . $money ['money'] . "元";
					$mod = $this->gettopic ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'topic/getone/' . $mod ['id'], 2 );
					$money ['content'] = "<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";

					break;
				case 'appbuyshouhuo' :
					$money ['operation'] = '应用商店购买商品';
					
					$money ['money'] = "支出" . $money ['money'] . "元";
					
					$money ['content'] = "来自应用商店消费";
					break;
					
				case 'vertify' :
					$money ['operation'] = '用户认证';
					
					$money ['money'] = "支出" . $money ['money'] . "元";
					
					$money ['content'] = "来自用户认证费用";
					break;
				case 'payarticle' :
					$money ['operation'] = '用户付费阅读';
					
					$money ['money'] = "收入" . $money ['money'] . "元";
					
					$mod = $this->gettopic ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'topic/getone/' . $mod ['id'], 2 );
					$money ['content'] = "用户付费阅读了您的文章：<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					
					break;
				case 'topayarticle' :
					$money ['operation'] = '用户付费阅读';
					
					$money ['money'] = "支出" . $money ['money'] . "元";
					$mod = $this->gettopic ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'topic/getone/' . $mod ['id'], 2 );
					$money ['content'] = "您付费阅读了文章：<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					
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
				case 'fufeitiwen' :
					$money ['operation'] = '付费提问';
					$mod = $this->getquestion ( $money ['typeid'] );
					$money ['money'] = "支出" . $money ['money'] . "元";
					if ($mod == null) {
						$money ['content'] = "此付费问题被删除，问题qid=" . $money ['typeid'];
					} else {
						$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['id'], 2 );
						$money ['content'] = "付费提问标题-><a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					}
					break;
				case 'coursevipchonzhi' :
					$money ['operation'] = 'VIP充值';
					$course_vip=$this->db->get_where('course_vip',array("id"=>$money['typeid']))->row_array();
					$money ['shouru'] = "用户支付" . $money ['money'] . "元购买VIP";
					$c_name=$course['name'];
					
					$money ['content'] = "充值办理vip".$course_vip['cardtype'];
					
					break;
				case 'closeqid' :
					$money ['operation'] = '问题被关闭退还悬赏金额';
					$money ['money'] = "收入" . $money ['money'] . "元";
					$mod = $this->getquestion ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['id'], 2 );
					$money ['content'] = "关闭标题-><a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";

					break;
				case 'eqid' :
					$money ['operation'] = '【' . $money ['fromuser'] ['username'] . '】对专家【' . $money ['touser'] ['username'] . '】提问';
					$mod = $this->getquestion ( $money ['typeid'] );
					$money ['money'] = "专家收入" . $money ['money'] . "元";
					if ($mod == null) {
						$money ['content'] = "此付费对专家提问的问题被删除，问题qid=" . $money ['typeid'];
					} else {
						$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['id'], 2 );
						$money ['content'] = "对专家提问标题-><a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
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
			}

			$recargelist [] = $money;
		}
		return $recargelist;
	}
	/**
	
	* 显示网站收入动态
	
	* @date: 2019年7月4日 下午5:27:46
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function getshouru($start,$limit){
		global $setting;
		$recargelist = array ();
		
		$query = '';
		
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "paylog` where  type  in('adoptqid','eqid','payarticle','tid','viewaid','coursebuy','aid')   ORDER BY `time` DESC limit $start,$limit" );
		
		$suffix = '?';
		if ($setting ['seo_on']) {
			$suffix = '';
		}
		foreach ( $query->result_array () as $money ) {
			//$fromuser=$this->getuser($money['touid']);
			// $money['cash_fee'] = $money['money']/100;
			
			
			// $money['fromusername'] =$fromuser['username'];
			$money ['time'] = tdate ( $money ['time'] );
			$money ['touser'] = $this->get_by_uid ( $money ['touid'] );
			$money ['author_has_vertify'] = get_vertify_info ( $money ['touid'] ); //用户是否认证
			$money ['fromuser'] = $money ['fromuid'] != 0 ? $this->get_by_uid ( $money ['fromuid'] ) : null;
			$money['isvip']=$this->getvipbyuid($money ['touid']);
			switch ($money ['type']) {
				case 'viewaid' :
					$money ['operation'] = '用户付费偷看';
					$money ['shouru'] = "收入" . $money ['money'] . "元";
					$mod = $this->getanswer ( $money ['typeid'] );
					
					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['qid'], 2 );
					$money ['content'] = "偷看回答的问题:<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					
					break;
				
				case 'coursebuy' :
					$money ['operation'] = '购买课程';
					$course=$this->db->get_where('category',array('id'=>$money['typeid']))->row_array();
					$money ['shouru'] = "用户支付" . $money ['money'] . "元购买课程";
					$c_name=$course['name'];
					$viewurl = config_item('course_url')."course/view/".$course['id'];
					$money ['content'] = "<a href='" . $viewurl . ".html'>" ."购买课程[$c_name]". "</a>";
				
					break;
				case 'wxqbuytaocan' :
					$money ['operation'] = '购买套餐';
					$taocan=$this->db->get_where('weixiaoqiang_taocanbuy',array('taocanid'=>$money['typeid']))->row_array();
					$money ['money'] = "用户支付" . $money ['money'] . "元购买套餐";
					$c_name=$taocan['taocanname'];
					$money ['content'] = "购买套餐[$c_name]";
					break;
				case 'coursevipchonzhi' :
					$money ['operation'] = 'VIP充值';
					$course_vip=$this->db->get_where('course_vip',array("id"=>$money['typeid']))->row_array();
					$money ['shouru'] = "用户支付" . $money ['money'] . "元购买VIP";
					$c_name=$course['name'];
					
					$money ['content'] = "充值办理vip".$course_vip['cardtype'];
					
					break;
				case 'aid' :
					$money ['operation'] = '回答打赏';
					$mod = $this->getanswer ( $money ['typeid'] );
					$money ['shouru'] = "收入" . $money ['money'] . "元";
					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['qid'], 2 );
					$money ['content'] = "<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					break;
				case 'tid' :
					$money ['operation'] = '文章打赏';
					$money ['shouru'] = "收入" . $money ['money'] . "元";
					$mod = $this->gettopic ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'topic/getone/' . $mod ['id'], 2 );
					$money ['content'] = "<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					
					break;
				
				case 'payarticle' :
					$money ['operation'] = '用户付费阅读';
					
					$money ['shouru'] = "收入" . $money ['money'] . "元";
					
					$mod = $this->gettopic ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'topic/getone/' . $mod ['id'], 2 );
					$money ['content'] = "用户付费阅读了您的文章：<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					
					break;
				
				case 'eqid' :
					$money ['operation'] = '【' . $money ['fromuser'] ['username'] . '】对专家【' . $money ['touser'] ['username'] . '】提问';
					$mod = $this->getquestion ( $money ['typeid'] );
					$money ['shouru'] = "专家收入" . $money ['money'] . "元";
					if ($mod == null) {
						$money ['content'] = "此付费对专家提问的问题被删除，问题qid=" . $money ['typeid'];
					} else {
						$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['id'], 2 );
						$money ['content'] = "对专家提问标题-><a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					}
					break;
				case 'adoptqid' :
					$money ['operation'] = '回答被采纳';
					$money ['shouru'] = "收入" . $money ['money'] . "元";
					$mod = $this->getquestion ( $money ['typeid'] );
					$viewurl = SITE_URL . $suffix . urlmap ( 'question/view/' . $mod ['id'], 2 );
					$money ['content'] = "<a href='" . $viewurl . ".html'>" . $mod ['title'] . "</a>";
					break;
				
			}
			
			$recargelist [] = $money;
		}
		return $recargelist;
	}
	/**
	
	* 获取用户是否充值过vip
	
	* @date: 2019年5月13日 下午3:51:39
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function getvipbyuid($uid){
		$query = $this->db->order_by("vipouttime desc")->get_where ( 'course_vip_user', array (
				'authorid' => $uid
		) );
		$vipuser = $query->row_array ();
		if ($vipuser) {
			$vipouttime=$vipuser['vipouttime'];
			if($vipouttime<time()){
				return 0;
			}else{
				switch ($vipuser['viptype']){
					case 1:
						$vipuser['viptypename']="月卡";
						break;
					case 2:
						$vipuser['viptypename']="季卡";
						break;
					case 3:
						$vipuser['viptypename']="年卡";
						break;
				}
				$vipuser['fouttime']=date('Y年m月d日',$vipuser['vipouttime']);
				return $vipuser;
			}
		}else{
			return 0;
		}
	}
	function get_by_username($username) {
		$user = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE username='$username' or email='$username' or phone='$username'" )->row_array ();
		return $user;
	}
	function get_by_uid($uid) {
		$user = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE uid='$uid'" )->row_array ();
		$user ['avatar'] = get_avatar_dir ( $uid );

		return $user;
	}
	function getanswer($id) {
		$answer = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "answer WHERE id='$id'" )->row_array ();

		if ($answer) {

			$answer ['title'] = checkwordsglobal ( $answer ['title'] );
			$answer ['content'] = checkwordsglobal ( $answer ['content'] );
		}
		return $answer;
	}
	function getmysummoneybytouid($touid) {

		$mrmb = $this->db->query ( "SELECT sum(cash_fee) as rmb FROM " . $this->db->dbprefix . "weixin_notify WHERE touid=$touid and haspay=0 " )->row_array();
		//$mrmb=intval($mrmb)/100;
		return $mrmb;

	}
	function gethasmysummoneybytouid($touid) {

		$mrmb = $this->db->query ( "SELECT sum(cash_fee) as rmb FROM " . $this->db->dbprefix . "weixin_notify WHERE touid=$touid and haspay=1 " )->row_array();
		//$mrmb=intval($mrmb)/100;
		return $mrmb;

	}
	function getquestion($id) {
		$question = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "question WHERE id='$id'" )->row_array();
		if ($question) {

			$question ['title'] = checkwordsglobal ( $question ['title'] );

		}
		return $question;
	}
	function gettopic($id) {
		$topic = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic WHERE id='$id'" )->row_array();

		if ($topic) {

			$topic ['title'] = checkwordsglobal ( $topic ['title'] );

		}
		return $topic;
	}

}

?>
