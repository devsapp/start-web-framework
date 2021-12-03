<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Note extends CI_Controller {

	function __construct() {
		$this->whitelist = "clist";
		parent::__construct ();
		$this->load->model ( "note_model" );
		$this->load->model ( "note_comment_model" );
	}

	/* 前台查看公告列表 */

	function clist() {
		$navtitle = "本站公告列表";
		$seo_description = "发布" . $this->setting ['site_name'] . "最新公告，包括问答升级，维护更新，修改，以及重大变更。";
		$seo_keywords = "公告";
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'note', ' 1=1', $this->db->dbprefix ) )->row_array () );
		
		$notelist = $this->note_model->get_list ( $startindex, $pagesize );
		$this->load->model ( 'topdata_model' );
		if (! isset ( $this->setting ['list_topdatanum'] )) {
			$topdatalist = $this->topdata_model->get_list ( 0, 3, " where type='note' " );
		} else {
			$topdatalist = $this->topdata_model->get_list ( 0, $this->setting ['list_topdatanum'], " where type='note' " );
		}
		$departstr = page ( $rownum, $pagesize, $page, "note/clist" );
		include template ( 'notelist' );
	}
	/* 浏览公告 */

	function view() {
		$navtitle = '查看公告';
		$page = max ( 1, intval ( $this->uri->segment ( 4 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'note', ' 1=1', $this->db->dbprefix ) )->row_array () );

		$note = $this->note_model->get ( $this->uri->segment ( 3 ) );
		if ($note ['title'] == '') {
			header ( 'HTTP/1.1 404 Not Found' );
			header ( "status: 404 Not Found" );
			echo '<!DOCTYPE html><html><head><meta charset=utf-8 /><title>404-您访问的页面不存在</title>';
			echo "<style>body { background-color: #ECECEC; font-family: 'Open Sans', sans-serif;font-size: 14px; color: #3c3c3c;}";
			echo ".nullpage p:first-child {text-align: center; font-size: 150px;  font-weight: bold;  line-height: 100px; letter-spacing: 5px; color: #fff;}";
			echo ".nullpage p:not(:first-child) {text-align: center;color: #666;";
			echo "font-family: cursive;font-size: 20px;text-shadow: 0 1px 0 #fff;  letter-spacing: 1px;line-height: 2em;margin-top: -50px;}";
			echo ".nullpage p a{margin-left:10px;font-size:20px;}";
			echo '</style></head><body> <div class="nullpage"><p><span>4</span><span>0</span><span>4</span></p><p>抱歉，站内公告不存在！⊂((δ⊥δ))⊃<a href="/">返回主页</a></p></div></body></html>';
			exit ();
		}
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'note_comment', " noteid=" . $note ['id'], $this->db->dbprefix ) )->row_array () );
		;
		$commentlist = $this->note_comment_model->get_by_noteid ( $note ['id'], $startindex, $pagesize );

		$departstr = page ( $rownum, $pagesize, $page, "note/view/" . $note ['id'] );
		$this->note_model->update_views ( $note ['id'] );
		$seo_title = $note ['title'] . ' - ' . $navtitle . ' - ' . $this->setting ['site_name'];
		$is_followedauthor = $this->user_model->is_followed ( $note ['authorid'], $this->user ['uid'] );
		$seo_description = $seo_title;
		$seo_keywords = $note ['title'];
		include template ( 'note' );
	}

	function addcomment() {
		if (null !== $this->input->post ( 'submit' )) {

			if ($this->user ['uid'] == 0) {
				
				$this->message ( '游客无权限评论！' ,'user/login');
			}
			if ($this->user ['isblack'] == 1) {
				$this->message ( '黑名单用户无法评论！', 'BACK' );
			}
			if (trim ( $this->input->post ( 'content' ) ) == '') {
				$this->message ( '评论不能为空！' );
			}
			if (isset ( $this->setting ['code_ask'] ) && $this->setting ['code_ask'] == '1' && $this->user ['credit1'] < $this->setting ['jingyan']) {
				if (strtolower ( trim ( $this->input->post ( 'code' ) ) ) != $this->user_model->get_code ()) {
					
					$message ['message'] = "验证码错误!";
					echo json_encode ( $message );
					exit ();
				}
			}
			$noteid = intval ( $this->input->post ( 'noteid' ) );
			$mycomment = $this->note_model->getbyuid ( $this->user ['uid'], $noteid );

			if ($mycomment) {
				$this->message ( "您已经评论过了!", "note/view/" . $noteid );
			}
			$this->note_comment_model->add ( $noteid, $this->input->post ( 'content' ) );
			$this->note_model->update_comments ( $noteid );
			$this->message ( "评论添加成功!", "note/view/" . $noteid );
		}
	}

	function deletecomment() {
		if ($this->user ['uid'] == 0) {
			
			$this->message ( '游客无权限评论！' ,'user/login');
		}
		$commentid = intval ( $this->uri->segment ( 4 ) );
		$noteid = intval ( $this->uri->segment ( 3 ) );
		$this->note_comment_model->remove ( $commentid, $noteid );
		$this->message ( "评论删除成功", "note/view/$noteid" );
	}

}

?>