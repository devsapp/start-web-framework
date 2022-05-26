<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_xiongzhang extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'topic_model' );
		$this->load->model ( 'question_model' );
		$this->load->model ( 'tag_model' );
	}
	/**
	 *
	 * 标签列表
	 *
	 * @date: 2018年12月20日 上午8:48:18
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function taglist() {
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 50;
		if ($this->setting ['xiongzhang_tuisongnum'] && $this->setting ['xiongzhang_tuisongnum'] != null) {
			$pagesize = $this->setting ['xiongzhang_tuisongnum'];
		}
		$startindex = ($page - 1) * $pagesize;
		$where = '';
		$taglist = $this->tag_model->getalltaglist ( $startindex, $pagesize, $where );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'tag', " 1=1 ", $this->db->dbprefix ) )->row_array () );
		$pages = @ceil ( $rownum / $pagesize );
		$departstr = page ( $rownum, $pagesize, $page, "admin_xiongzhang/taglist" );
		
		include template ( 'admin_xiongzhang_tag', 'admin' );
	}
	/**
	 *
	 * 文章列表
	 *
	 * @date: 2018年12月20日 上午8:46:32
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function topiclist() {
		$navtitle = "熊掌号文章推送列表";
		
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 50;
		if ($this->setting ['xiongzhang_tuisongnum'] && $this->setting ['xiongzhang_tuisongnum'] != null) {
			$pagesize = $this->setting ['xiongzhang_tuisongnum'];
		}
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', ' id>0 and state=1 ', $this->db->dbprefix ) )->row_array () );
		$pages = @ceil ( $rownum / $pagesize );
		$topiclist = $this->topic_model->get_list ( 2, $startindex, $pagesize );
		
		$departstr = page ( $rownum, $pagesize, $page, "admin_xiongzhang/topiclist" );
		include template ( "admin_xiongzhang_topic", "admin" );
	}
	/**
	 *
	 * 问题列表
	 *
	 * @date: 2018年12月20日 上午8:46:44
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function index($msg = '') {
		$msg && $message = $msg;
		// 获取已审核的问题列表
		$navtitle = "熊掌号推送";
		
		// 回答分页
		@$page = 1;
		
		@$page = max ( 1, intval ( $this->uri->rsegments [3] ) );
		$pagesize = 50;
		if ($this->setting ['xiongzhang_tuisongnum'] && $this->setting ['xiongzhang_tuisongnum'] != null) {
			$pagesize = $this->setting ['xiongzhang_tuisongnum'];
		}
		$startindex = ($page - 1) * $pagesize;
		$paixu = 0;
		
		$rownum = $this->question_model->rownum_by_cfield_cvalue_status ( '', 'all', 'all', $paixu ); // 获取总的记录数
		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( '', 'all', 'all', $startindex, $pagesize, $paixu ); // 问题列表数据
		
		$departstr = page ( $rownum, $pagesize, $page, "admin_xiongzhang/index" ); // 得到分页字符串
		
		include template ( "admin_xiongzhang", "admin" );
	}
	function tagnewtui() {
		$urls = array ();
		
		if (null !== $this->input->post ( 'tags' )) {
			// SITE_URL.$suffix."q-$item[id]$fix
			$qids = $this->input->post ( 'tags' );
			$q_size = count ( $qids );
			for($i = 0; $i < $q_size; $i ++) {
				
				array_push ( $urls, $this->url ( "tags/view/" . $qids [$i] ) );
			}
		} else {
			$this->message ( '您还没选择推送标签!' );
		}
		if (trim ( $this->setting ['xiongzhang_settingnewapi'] ) != '' && $this->setting ['xiongzhang_settingnewapi'] != null) {
			
			$api = $this->setting ['xiongzhang_settingnewapi'];
			
			$ch = curl_init ();
			$options = array (
					CURLOPT_URL => $api,
					CURLOPT_POST => true,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POSTFIELDS => implode ( "\n", $urls ),
					CURLOPT_HTTPHEADER => array (
							'Content-Type: text/plain' 
					) 
			);
			curl_setopt_array ( $ch, $options );
			$result = json_decode ( curl_exec ( $ch ), true );
			
			if (! $result ['success_realtime'] && $result ['success'] == 0) {
				$this->message ( '标签推送不成功，请检查当前站点域名是否已经绑定熊掌号!' );
				;
			}
			if ($result ['success_realtime'] && $result ['success_realtime'] != 0) {
				$this->message ( '标签推送成功!' );
				;
			}
		} else {
			$this->message ( '标签推送不成功，您还没设置熊掌号新增内容推送接口!' );
		}
	}
	function taghistorytui() {
		$urls = array (); //标签列表
		$questionurls = array (); //问题标签列表
		$articleurls = array (); //文章标签列表
		if (null !== $this->input->post ( 'tags' )) {
			// SITE_URL.$suffix."q-$item[id]$fix
			$qids = $this->input->post ( 'tags' );
			$q_size = count ( $qids );
			for($i = 0; $i < $q_size; $i ++) {
				array_push ( $urls, $this->url ( "tags/view/" . $qids [$i] ) );
				array_push ( $questionurls, $this->url  ( "tags/question/" . $qids [$i] ) );
				array_push ( $articleurls, $this->url  ( "tags/article/" . $qids [$i] ) );
			}
		} else {
			$this->message ( '您还没选择推送标签!' );
		}
		if (trim ( $this->setting ['xiongzhang_settinghistoryapi'] ) != '' && $this->setting ['xiongzhang_settinghistoryapi'] != null) {
			
			$api = $this->setting ['xiongzhang_settinghistoryapi'];
			
			$ch = curl_init ();
			//问题标签列表
			$options = array (
					CURLOPT_URL => $api,
					CURLOPT_POST => true,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POSTFIELDS => implode ( "\n", $questionurls ),
					CURLOPT_HTTPHEADER => array (
							'Content-Type: text/plain'
					)
			);
			curl_setopt_array ( $ch, $options );
			$result = json_decode ( curl_exec ( $ch ), true );
			//文章标签列表
			$options = array (
					CURLOPT_URL => $api,
					CURLOPT_POST => true,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POSTFIELDS => implode ( "\n", $articleurls ),
					CURLOPT_HTTPHEADER => array (
							'Content-Type: text/plain'
					)
			);
			curl_setopt_array ( $ch, $options );
			$result = json_decode ( curl_exec ( $ch ), true );
			//标签列表
			$options = array (
					CURLOPT_URL => $api,
					CURLOPT_POST => true,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POSTFIELDS => implode ( "\n", $urls ),
					CURLOPT_HTTPHEADER => array (
							'Content-Type: text/plain' 
					) 
			);
			curl_setopt_array ( $ch, $options );
			$result = json_decode ( curl_exec ( $ch ), true );
			
			if (! $result ['success_batch'] && $result ['success'] == 0) {
				$this->message ( '标签推送不成功，请检查当前站点域名是否已经绑定熊掌号!' );
				;
			}
			if ($result ['success_batch'] && $result ['success_batch'] != 0) {
				$this->message ( '标签推送成功!' );
				;
			}
			// $this->index ( '问题推送成功!' );
		} else {
			$this->message ( '标签推送不成功，您还没设置熊掌号历史内容推送接口!' );
		}
	}
	function topicnewtui() {
		$urls = array ();
		
		if (null !== $this->input->post ( 'qid' )) {
			// SITE_URL.$suffix."q-$item[id]$fix
			$qids = $this->input->post ( 'qid' );
			$q_size = count ( $qids );
			for($i = 0; $i < $q_size; $i ++) {
				array_push ( $urls, $this->url ( "topic/getone/" . $qids [$i] ) );
			}
		} else {
			$this->message ( '您还没选择推送文章!' );
		}
		if (trim ( $this->setting ['xiongzhang_settingnewapi'] ) != '' && $this->setting ['xiongzhang_settingnewapi'] != null) {
			
			$api = $this->setting ['xiongzhang_settingnewapi'];
			
			$ch = curl_init ();
			$options = array (
					CURLOPT_URL => $api,
					CURLOPT_POST => true,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POSTFIELDS => implode ( "\n", $urls ),
					CURLOPT_HTTPHEADER => array (
							'Content-Type: text/plain' 
					) 
			);
			curl_setopt_array ( $ch, $options );
			$result = json_decode ( curl_exec ( $ch ), true );
			
			if (! $result ['success_realtime'] && $result ['success'] == 0) {
				$this->message ( '文章推送不成功，请检查当前站点域名是否已经绑定熊掌号!' );
				;
			}
			if ($result ['success_realtime'] && $result ['success_realtime'] != 0) {
				$this->message ( '文章推送成功!' );
				;
			}
		} else {
			$this->message ( '文章推送不成功，您还没设置熊掌号新增内容推送接口!' );
		}
	}
	function topichistorytui() {
		$urls = array ();
		
		if (null !== $this->input->post ( 'qid' )) {
			// SITE_URL.$suffix."q-$item[id]$fix
			$qids = $this->input->post ( 'qid' );
			$q_size = count ( $qids );
			for($i = 0; $i < $q_size; $i ++) {
				array_push ( $urls, $this->url  ( "topic/getone/" . $qids [$i] ) );
			}
		} else {
			$this->message ( '您还没选择推送文章!' );
		}
		if (trim ( $this->setting ['xiongzhang_settinghistoryapi'] ) != '' && $this->setting ['xiongzhang_settinghistoryapi'] != null) {
			
			$api = $this->setting ['xiongzhang_settinghistoryapi'];
			
			$ch = curl_init ();
			$options = array (
					CURLOPT_URL => $api,
					CURLOPT_POST => true,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POSTFIELDS => implode ( "\n", $urls ),
					CURLOPT_HTTPHEADER => array (
							'Content-Type: text/plain' 
					) 
			);
			curl_setopt_array ( $ch, $options );
			$result = json_decode ( curl_exec ( $ch ), true );
			
			if (! $result ['success_batch'] && $result ['success'] == 0) {
				$this->message ( '文章推送不成功，请检查当前站点域名是否已经绑定熊掌号!' );
				;
			}
			if ($result ['success_batch'] && $result ['success_batch'] != 0) {
				$this->message ( '文章推送成功!' );
				;
			}
			// $this->index ( '问题推送成功!' );
		} else {
			$this->message ( '文章推送不成功，您还没设置熊掌号历史内容推送接口!' );
		}
	}
	function newtui() {
		$urls = array ();
		
		if (null !== $this->input->post ( 'qid' )) {
			// SITE_URL.$suffix."q-$item[id]$fix
			$qids = $this->input->post ( 'qid' );
			$q_size = count ( $qids );
			for($i = 0; $i < $q_size; $i ++) {
				array_push ( $urls, $this->url  ( "question/view/" . $qids [$i] ) );
			}
		
		} else {
			$this->message ( '您还没选择推送问题!' );
		}
		if (trim ( $this->setting ['xiongzhang_settingnewapi'] ) != '' && $this->setting ['xiongzhang_settingnewapi'] != null) {
			
			$api = $this->setting ['xiongzhang_settingnewapi'];
			
			$ch = curl_init ();
			$options = array (
					CURLOPT_URL => $api,
					CURLOPT_POST => true,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POSTFIELDS => implode ( "\n", $urls ),
					CURLOPT_HTTPHEADER => array (
							'Content-Type: text/plain' 
					) 
			);
			curl_setopt_array ( $ch, $options );
			$result = json_decode ( curl_exec ( $ch ), true );
			
			if (! $result ['success_realtime'] && $result ['success'] == 0) {
				$this->message ( '问题推送不成功，请检查当前站点域名是否已经绑定熊掌号!' );
				;
			}
			if ($result ['success_realtime'] && $result ['success_realtime'] != 0) {
				$this->message ( '问题推送成功!' );
				;
			}
		} else {
			$this->message ( '问题推送不成功，您还没设置熊掌号新增内容推送接口!' );
		}
	}
	function historytui() {
		$urls = array ();
		
		if (null !== $this->input->post ( 'qid' )) {
			// SITE_URL.$suffix."q-$item[id]$fix
			$qids = $this->input->post ( 'qid' );
			$q_size = count ( $qids );
			for($i = 0; $i < $q_size; $i ++) {
				array_push ( $urls, $this->url  ( "question/view/" . $qids [$i] ) );
			}
			
		} else {
			$this->message ( '您还没选择推送问题!' );
		}
		if (trim ( $this->setting ['xiongzhang_settinghistoryapi'] ) != '' && $this->setting ['xiongzhang_settinghistoryapi'] != null) {
			
			$api = $this->setting ['xiongzhang_settinghistoryapi'];
			
			$ch = curl_init ();
			$options = array (
					CURLOPT_URL => $api,
					CURLOPT_POST => true,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POSTFIELDS => implode ( "\n", $urls ),
					CURLOPT_HTTPHEADER => array (
							'Content-Type: text/plain' 
					) 
			);
			curl_setopt_array ( $ch, $options );
			$result = json_decode ( curl_exec ( $ch ), true );
			
			if (! $result ['success_batch'] && $result ['success'] == 0) {
				$this->message ( '问题推送不成功，请检查当前站点域名是否已经绑定熊掌号!' );
				;
			}
			if ($result ['success_batch'] && $result ['success_batch'] != 0) {
				$this->message ( '问题推送成功!' );
				;
			}
			// $this->index ( '问题推送成功!' );
		} else {
			$this->message ( '问题推送不成功，您还没设置熊掌号历史内容推送接口!' );
		}
	}
	function apiset() {
		$this->load->model ( 'setting_model' );
		if (null !== $this->input->post ( 'submit' )) {
			if (! trim ( $this->input->post ( 'newcontent' ) )) {
				$this->message ( "新增内容接口不能为空" );
			}
			if (! trim ( $this->input->post ( 'historycontent' ) )) {
				$this->message ( "历史内容接口不能为空" );
			}
			$this->setting ['xiongzhang_appid'] = trim ( $this->input->post ( 'xiongzhang_appid' ) );
			$this->setting ['xiongzhang_settingnewapi'] = trim ( $this->input->post ( 'newcontent' ) );
			$this->setting ['xiongzhang_settinghistoryapi'] = trim ( $this->input->post ( 'historycontent' ) );
			$this->setting ['xiongzhang_tuisongnum'] = intval ( trim ( $this->input->post ( 'xiongzhang_tuisongnum' ) ) );
			if ($this->setting ['xiongzhang_tuisongnum'] > 2000) {
				$this->message ( "推送内容数量最大一页2000条（熊掌号规定）。" );
			}
			$this->setting_model->update ( $this->setting );
			cleardir ( FCPATH . '/data/cache' ); // 清除缓存文件
			$this->index ( "配置成功" );
		}
	}
	/* 伪静态和html纯静态可以同时存在 */
	function url($var, $url = '') {
		global $setting;
		
		$location = 'index.php?' . $var . $setting ['seo_suffix'];
		if ((false === strpos ( $var, 'admin_' )) && $setting ['seo_on']) {
			$useragent = $_SERVER ['HTTP_USER_AGENT'];
			
			if (! strstr ( $useragent, 'MicroMessenger' )) {
				$location = $var . $setting ['seo_suffix'];
			} else {
				$location = 'index.php?' . $var . $setting ['seo_suffix'];
			}
		}
		
		$location = urlmap ( $location, 2 );
		if (config_item ( 'mobile_domain' )) {
			return config_item ( 'mobile_domain' ) . $location;
		} else {
			return config_item ( 'base_url' ) . $location;
		}
	}
}

?>