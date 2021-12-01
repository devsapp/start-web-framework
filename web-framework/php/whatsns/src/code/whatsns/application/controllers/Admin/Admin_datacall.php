<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_datacall extends ADMIN_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( 'datacall_model' );
		$this->load->model ( 'question_model' );
		$this->load->model ( 'category_model' );
	}

	function index() {
		$datacalllist = $this->datacall_model->get_list ();
		include template ( 'datacalllist', 'admin' );
	}

	function add() {
		if (null !== $this->input->post ( 'submit' )) {
			$expressionarr = array ();
			$expressionarr ['tpl'] = base64_encode ( $this->input->post ( 'tpl' ) );
			$expressionarr ['status'] = $this->input->post ( 'status' );
			$categorystr = '';
			if (null!== $this->input->post ( 'category1' ) ) {
				$categorystr .= intval ( $this->input->post ( 'category1' ) ) . ':';
			}
			if (null!== $this->input->post ( 'category2' ) ) {
				$categorystr .= intval ( $this->input->post ( 'category2' ) ) . ':';
			}
			if (null!== $this->input->post ( 'category2' ) ) {
				$categorystr .= intval ( $this->input->post ( 'category2' ) ) . ':';
			}
			$expressionarr ['category'] = $categorystr;
			$expressionarr ['cachelife'] = intval ( $this->input->post ( 'cachelife' ) );
			$expressionarr ['maxbyte'] = intval ( $this->input->post ( 'maxbyte' ) );
			$expressionarr ['start'] = $this->input->post ( 'start' );
			$expressionarr ['limit'] = $this->input->post ( 'limit' );
			$expression = serialize ( $expressionarr );
			$this->datacall_model->add ( trim ( $this->input->post ( 'title' ) ), $expression );
			$this->index ();
		} else {
			$categoryjs = $this->category_model->get_js ();
			$status_list = array (array ('all', '全部问题' ), array (1, '待解决' ), array (2, '已解决' ), array (4, '悬赏' ) );
			include template ( 'adddatacall', 'admin' );
		}

	}

	function remove() {
		if (null!== $this->input->post ( 'delete' ) ) {
			$ids = implode ( $this->input->post ( 'delete' ), "," );
			$this->datacall_model->remove_by_id ( $ids );
			$this->index ();
		}
	}

	function edit() {
		$id =null!== $this->uri->segment ( 3 )  ? intval ( $this->uri->segment ( 3 ) ) : intval ( $this->input->post ( 'id' ) );
		if (null !== $this->input->post ( 'submit' )) {
			$expressionarr = array ();
			$expressionarr ['tpl'] = trim ( base64_encode ( $this->input->post ( 'tpl' ) ) );
			$expressionarr ['status'] = $this->input->post ( 'status' );
			$categorystr = '';
			if (null!== $this->input->post ( 'category1' ) ) {
				$categorystr .= intval ( $this->input->post ( 'category1' ) ) . ':';
			}
			if (null!== $this->input->post ( 'category2' ) ) {
				$categorystr .= intval ( $this->input->post ( 'category2' ) ) . ':';
			}
			if (null!== $this->input->post ( 'category2' ) ) {
				$categorystr .= intval ( $this->input->post ( 'category2' ) ) . ':';
			}
			$expressionarr ['category'] = $categorystr;
			$expressionarr ['cachelife'] = intval ( $this->input->post ( 'cachelife' ) );
			$expressionarr ['maxbyte'] = intval ( $this->input->post ( 'maxbyte' ) );
			$expressionarr ['start'] = $this->input->post ( 'start' );
			$expressionarr ['limit'] = $this->input->post ( 'limit' );
			$expression = serialize ( $expressionarr );
			$this->datacall_model->update ( $id, trim ( $this->input->post ( 'title' ) ), $expression );
			$message = '设置编辑成功!';
		}
		$datacall = $this->datacall_model->get ( $id );
		if ($datacall) {
			$expressionarr = unserialize ( $datacall ['expression'] );
			$tpl = stripslashes ( base64_decode ( $expressionarr ['tpl'] ) );
			$cid1 = 0;
			$cid2 = 0;
			$cid3 = 0;
			if ('' != $expressionarr ['category']) {
				$category = explode ( ":", substr ( $expressionarr ['category'], 0, - 1 ) );
				isset ( $category [0] ) && $cid1 = $category [0];
				isset ( $category [1] ) && $cid2 = $category [1];
				isset ( $category [2] ) && $cid3 = $category [2];
			}
			$categoryjs = $this->category_model->get_js ();
			$status_list = array (array ('all', '全部问题' ), array (1, '待解决' ), array (2, '已解决' ), array (4, '悬赏' ) );
			include template ( 'editdatacall', 'admin' );
		}
	}

	//生成js代码
//<script type="text/javascript" src="http://www.ask.com/index.php?js/view/1"></script>
//此函数不存在，需要在后台用弹出div展示即可


}
?>