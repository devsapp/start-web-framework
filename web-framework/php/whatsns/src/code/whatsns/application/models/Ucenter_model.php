<?php

class Ucenter_model extends CI_Model {
	function ucentermodel() {
		parent::__construct ();
		$this->load->database ();
		$this->load->model ( 'user_model' );

	}

	/* 同步uc注册 */

	function login($username, $password) {
		include FCPATH . 'data/ucconfig.inc.php';
		! defined ( 'UC_API' ) && define ( 'UC_API', '1' );
		require_once FCPATH . 'uc_client/client.php';
		$tuser = $this->user_model->get_by_username ( $username );
		$ucenter_user = uc_get_user ( $username );
		if (! $ucenter_user && ($tuser ['username'] == $username && md5 ( $password ) == $tuser ['password'])) {
			$uid = uc_user_register ( $tuser ['username'], $password, $tuser ['email'] );
			if ($this->setting ["ucenter_setuid_byask"]) {
				uc_update_uid_byusername ( $tuser ['username'], $tuser ['uid'] );
				$uid = $tuser ['uid'];
			} else {
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET uid=$uid WHERE uid=" . $tuser ['uid'] );
			}

		}
		//通过接口判断登录帐号的正确性，返回值为数组
		list ( $uid, $username, $password, $email ) = uc_user_login ( $username, $password );
		if ($uid > 0) {
			$user = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE uid='$uid'" )->row_array ();
			if (! $user) {
				$this->user_model->add ( $username, $password, $email, $uid );
			}
			if ($user ['password'] != $password) {
				$password = md5 ( trim ( $password ) );
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET password='$password' WHERE uid=$uid" );
			}
			$this->user_model->refresh ( $uid );
			//生成同步登录的代码
			$ucsynlogin = uc_user_synlogin ( $uid );
			return 'ok';
		} elseif ($uid == - 1) {
			return '用户不存在,或者被删除!';
		} elseif ($uid == - 2) {
			return '密码错误!';
		} else {
			return '未定义!';
		}
	}

	/* 同步uc注册 */

	function ajaxlogin($username, $password) {
		include FCPATH . 'data/ucconfig.inc.php';
		! defined ( 'UC_API' ) && define ( 'UC_API', '1' );
		require_once FCPATH . 'uc_client/client.php';
			
		$tuser = $this->user_model->get_by_username ( $username );
		$ucenter_user = uc_get_user ( $username );
			
		if (! $ucenter_user && ($tuser ['username'] == $username && md5 ( trim ( $password ) ) == $tuser ['password'])) {

			$uid = uc_user_register ( $tuser ['username'], $password, $tuser ['email'] );
			
			if ($this->setting ["ucenter_setuid_byask"]) {
				uc_update_uid_byusername ( $tuser ['username'], $tuser ['uid'] );
				$uid = $tuser ['uid'];
			} else {
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET uid=$uid WHERE uid=" . $tuser ['uid'] );
			}

		}

		//通过接口判断登录帐号的正确性，返回值为数组
		list ( $uid, $username, $password, $email ) = uc_user_login ( $username, $password );
		if ($uid > 0) {

			$user = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE uid='$uid'" )->row_array ();
			if (! $user) {
				$this->user_model->add ( $username, $password, $email, $uid );
			}
			if ($user ['password'] != $password) {
				$password = md5 ( trim ( $password ) );
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET password='$password' WHERE uid=$uid" );
			}
			$this->user_model->refresh ( $uid );
	
			//生成同步登录的代码
		    $ucsynlogin = uc_user_synlogin ( $uid );
					
			return 'ok|'.$ucsynlogin;
		} elseif ($uid == - 1) {
			return '用户不存在,或者被删除!';
		} elseif ($uid == - 2) {
			return '密码错误!';
		} else {
			return '未定义!';
		}
	}

	/* 同步uc注册 */

	function register() {
		include FCPATH . 'data/ucconfig.inc.php';
		! defined ( 'UC_API' ) && define ( 'UC_API', '1' );
		require_once FCPATH . 'uc_client/client.php';
		$activeuser = uc_get_user ( $this->input->post ( 'username' ) );
		if ($activeuser) {
			return '该用户无需注册，请直接登录!';
		}

		$uid = uc_user_register ( $this->input->post ( 'username' ), $this->input->post ( 'password' ), $this->input->post ( 'email' ) );
		if ($uid <= 0) {
			if ($uid == - 1) {
				return '用户名不合法';
			} elseif ($uid == - 2) {
				return '包含要允许注册的词语';
			} elseif ($uid == - 3) {
				return '用户名已经存在';
			} elseif ($uid == - 4) {
				return 'Email 格式有误';
			} elseif ($uid == - 5) {
				return 'Email 不允许注册';
			} elseif ($uid == - 6) {
				return '该 Email 已经被注册';
			} else {
				return '未定义';
			}
		} else {
			$this->user_model->add ( $this->input->post ( 'username' ), $this->input->post ( 'password' ), $this->input->post ( 'email' ), $uid );
			$this->user_model->refresh ( $uid );
			$ucsynlogin = uc_user_synlogin ( $uid );
			return 'ok';
		}
	}
	/* 同步uc注册 */

	function ajaxregister($username, $password, $email, $frominvatecode = '', $flag = 1) {
		include FCPATH . 'data/ucconfig.inc.php';
		! defined ( 'UC_API' ) && define ( 'UC_API', '1' );
		require_once FCPATH . 'uc_client/client.php';
		$activeuser = uc_get_user ( $username );
		if ($activeuser) {
			return '该用户无需注册，请直接登录!';
		}

		$uid = uc_user_register ( $username, $password, $email );
		if ($uid <= 0) {
			if ($uid == - 1) {
				return '用户名不合法';
			} elseif ($uid == - 2) {
				return '包含要允许注册的词语';
			} elseif ($uid == - 3) {
				return '用户名已经存在';
			} elseif ($uid == - 4) {
				return 'Email 格式有误';
			} elseif ($uid == - 5) {
				return 'Email 不允许注册';
			} elseif ($uid == - 6) {
				return '该 Email 已经被注册';
			} else {
				return '未定义';
			}
		} else {

			if ($this->setting ["ucenter_setuid_byask"]) {
				$tbuid = $this->user_model->add ( $username, $password, $email );
				if($uid>$tbuid){
					//如果uc那边的uid比问答的uid大，那么就同步uc的
					$this->db->where(array('uid'=>$tbuid))->update('user',array('uid'=>$uid));
				$uid=$tbuid;
				}else{
					//如果问答的uid比uc的大就同步问答的
						uc_update_uid_byusername ( $username, $uid );
				}
			
			} else {
				$this->user_model->add ( $username, $password, $email, $uid );
			}
			if ($frominvatecode != '') {
				$this->user_model->updateinvatecode ( $uid, $frominvatecode );
			}
			if ($flag == 1) {
				$this->user_model->refresh ( $uid );
				$ucsynlogin = uc_user_synlogin ( $uid );
			}

			return 'ok';
		}
	}
	/* 同步uc退出系统 */

	function logout() {
		include FCPATH . 'data/ucconfig.inc.php';
		! defined ( 'UC_API' ) && define ( 'UC_API', '1' );
		require_once FCPATH . 'uc_client/client.php';
		$this->user_model->logout ();
		$ucsynlogout = uc_user_synlogout ();
		echo $ucsynlogout;
		return 'ok';
	}
	/* 同步uc退出系统 */

	function ajaxlogout() {
		include FCPATH . 'data/ucconfig.inc.php';
		! defined ( 'UC_API' ) && define ( 'UC_API', '1' );
		require_once FCPATH . 'uc_client/client.php';
		$ucsynlogout = uc_user_synlogout ();
		echo $ucsynlogout;
		$this->user_model->logout ();
		return 'ok';

	}

	/**
	 * 兑换积分
	 * @param  integer $uid 用户ID
	 * @param  integer $fromcredits 原积分
	 * @param  integer $tocredits 目标积分
	 * @param  integer $toappid 目标应用ID
	 * @param  integer $amount 积分数额
	 * @return boolean
	 */
	function exchange($uid, $fromcredits, $tocredits, $toappid, $amount) {
		include FCPATH . 'data/ucconfig.inc.php';
		! defined ( 'UC_API' ) && define ( 'UC_API', '1' );
		require_once FCPATH . 'uc_client/client.php';
		$ucresult = uc_credit_exchange_request ( $uid, $fromcredits, $tocredits, $toappid, $amount );
		return $ucresult;
	}

	/* 提出问题feed */

	function ask_feed($qid, $title, $description) {
		include FCPATH . 'data/ucconfig.inc.php';
		! defined ( 'UC_API' ) && define ( 'UC_API', '1' );
		require_once FCPATH . 'uc_client/client.php';
		global $setting;
		$feed = array ();
		$feed ['icon'] = 'thread';
		$feed ['title_template'] = '<b>{author} 在 {app} 发出了问题求助</b>';
		$feed ["title_data"] = array ("author" => '<a href="space.php?uid=' . $this->base->user ['uid'] . '">' . $this->base->user ['username'] . '</a>', "app" => '<a href="' . SITE_URL . '">' . $setting ['site_name'] . '</a>' );
		$feed ['body_template'] = '<b>{subject}</b><br>{message}';
		$feed ["body_data"] = array ("subject" => '<a href="' . SITE_URL . $setting ['seo_prefix'] . 'question/view/' . $qid . $setting ['seo_suffix'] . '">' . $title . '</a>', "message" => $description );
		uc_feed_add ( $feed ['icon'], $this->base->user ['uid'], $this->base->user ['username'], $feed ['title_template'], $feed ['title_data'], $feed ['body_template'], $feed ['body_data'] );
	}

	/* 回答问题feed */

	function answer_feed($question, $content) {
		include FCPATH . 'data/ucconfig.inc.php';
		! defined ( 'UC_API' ) && define ( 'UC_API', '1' );
		require_once FCPATH . 'uc_client/client.php';
		global $setting;
		$feed = array ();
		$feed ['icon'] = 'post';
		$feed ['title_template'] = '<b>{author} 在 {app} 回答了{asker} 的问题</b>';
		$feed ["title_data"] = array ("author" => '<a href="space.php?uid=' . $this->base->user ['uid'] . '">' . $this->base->user ['username'] . '</a>', "asker" => '<a href="space.php?uid=' . $question ['authorid'] . '">' . $question ['author'] . '</a>', "app" => '<a href="' . SITE_URL . '">' . $setting ['site_name'] . '</a>' );
		$feed ['body_template'] = '<b>{subject}</b><br>{message}';
		$feed ["body_data"] = array ("subject" => '<a href="' . SITE_URL . $setting ['seo_prefix'] . 'question/view/' . $question ['id'] . $setting ['seo_suffix'] . '">' . $question ['title'] . '</a>', "message" => $content );
		uc_feed_add ( $feed ['icon'], $this->base->user ['uid'], $this->base->user ['username'], $feed ['title_template'], $feed ['title_data'], $feed ['body_template'], $feed ['body_data'] );
	}

	function set_avatar($uid) {
		include FCPATH . 'data/ucconfig.inc.php';
		! defined ( 'UC_API' ) && define ( 'UC_API', '1' );
		require_once FCPATH . 'uc_client/client.php';
		return uc_avatar ( $uid );
	}
  function uc_user_delete($uid){
  	include FCPATH . 'data/ucconfig.inc.php';
		! defined ( 'UC_API' ) && define ( 'UC_API', '1' );
		require_once FCPATH . 'uc_client/client.php';
		return uc_user_delete ( $uid );
  }
	function uppass($username, $oldpw, $newpw, $email, $ignoreoldpw = 0) {
		include FCPATH . 'data/ucconfig.inc.php';
		! defined ( 'UC_API' ) && define ( 'UC_API', '1' );
		require_once FCPATH . 'uc_client/client.php';
		uc_user_edit ( $username, $oldpw, $newpw, $email, $ignoreoldpw );
	}

}

?>
