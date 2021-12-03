<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_weixin extends ADMIN_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( 'weixin_info_model' );
		$this->load->model ( 'weixin_setting_model' );
		$this->load->model ( 'setting_model' );
	}
	function setting() {

		if (null !== $this->input->post ( 'submit' )) {

			$wxname = strip_tags ( $this->input->post ( 'wxname' ) );
			$wxid = strip_tags ( $this->input->post ( 'wxid' ) );
			$weixin = strip_tags ( $this->input->post ( 'weixin' ) );
			$appid = strip_tags ( $this->input->post ( 'appid' ) );
			$appsecret = strip_tags ( $this->input->post ( 'appsecret' ) );
			$winxintype = strip_tags ( $this->input->post ( 'winxintype' ) );
			$id = $this->weixin_setting_model->add ( $wxname, $wxid, $weixin, $appid, $appsecret, $winxintype );
			if ($id > 0) {
				$message = '公众号设置成功!';
			}
		}
		$wx = $this->weixin_setting_model->get ();
		include template ( 'weixin_set', 'admin' );
	}
	function ticheng() {

		if ($_POST) {

			$this->setting ['weixin_fenceng_zuijia'] = doubleval ( $this->input->post ( 'weixin_fenceng_zuijia' ) )/100;
			$this->setting ['weixin_fenceng_answerother'] = doubleval ( $this->input->post ( 'weixin_fenceng_answerother' ) )/100;
			$this->setting ['weixin_fenceng_answersite'] = doubleval ( $this->input->post ( 'weixin_fenceng_answersite' ) )/100;
			$this->setting ['weixin_fenceng_hangjia'] = doubleval ( $this->input->post ( 'weixin_fenceng_hangjia' ) )/100;
			$this->setting ['weixin_fenceng_toutingpingtai'] = doubleval ( $this->input->post ( 'weixin_fenceng_toutingpingtai' ) )/100;
			$this->setting ['weixin_fenceng_toutingtiwen'] = doubleval ( $this->input->post ( 'weixin_fenceng_toutingtiwen' ) )/100;
			$this->setting ['weixin_fenceng_toutinghuida'] = doubleval ( $this->input->post ( 'weixin_fenceng_toutinghuida' ) )/100;
			$this->setting ['weixin_share_fencheng'] = doubleval ( $this->input->post ( 'weixin_share_fencheng' ) );
			
			$this->setting_model->update ( $this->setting );
			cleardir ( FCPATH . '/data/cache' ); //清除缓存文件
			$message = '分成设置成功!';

		}

		include template ( 'weixin_ticheng', 'admin' );
	}
	function tplset() {

		if (null !== $this->input->post ( 'submit' )) {

			$this->setting ['weixin_tpl_huida'] =  $this->input->post ( 'weixin_tpl_huida'  );
			$this->setting ['weixin_tpl_tixianjieguo'] = $this->input->post ( 'weixin_tpl_tixianjieguo'  );
			$this->setting ['weixin_tpl_caina'] = $this->input->post ( 'weixin_tpl_caina'  );
			$this->setting ['weixin_tpl_tixianshenqing'] =  $this->input->post ( 'weixin_tpl_tixianshenqing'  );
			$this->setting ['weixin_tpl_zixunexpert'] =  $this->input->post ( 'weixin_tpl_zixunexpert'  );
			$this->setting ['weixin_tpl_loginid'] =  $this->input->post ( 'weixin_tpl_loginid'  );
			
			$this->setting_model->update ( $this->setting );
			cleardir ( FCPATH . '/data/cache' ); //清除缓存文件
			$message = '消息模板设置成功!';

		}
		include template ( 'weixin_mubantongzhi', 'admin' );
	}
	function del() {

		if (null !== $this->input->post ( 'id' )) {
			$ids = implode ( ",", $this->input->post ( 'id' ) );

			$this->weixin_info_model->remove_by_id ( $ids );
			$message = '删除成功!';
		} else {
			$message = '您没选择需要删除的像!';
		}
		$keywordlist = $this->weixin_info_model->getkeywords ();

		include template ( 'weixin_keywords', 'admin' );
	}
	function deltuwen() {

		if (null !== $this->input->post ( 'id' )) {
			$ids = implode ( ",", $this->input->post ( 'id' ) );

			$_array_id = $this->input->post ( 'id' );

			$count = count ( $this->input->post ( 'id' ) );

			$_tmp_tid = Array ();
			$this->load->model ( "topic_model" );
			for($i = 0; $i < $count; $i ++) {

				$model = $this->weixin_info_model->getid ( $_array_id [$i] );

				unlink ( FCPATH . $model ['fmtu'] );
				array_push ( $_tmp_tid, $model ['wzid'] );
			}
			$_str_tid = implode ( ',', $_tmp_tid );

			$this->topic_model->remove ( $_str_tid );
			$this->weixin_info_model->remove_by_id ( $ids );
			$message = '删除成功!';
		} else {
			$message = '您没选择需要删除的像!';
		}
		$keywordlist = $this->weixin_info_model->gettuwenkeywords ();

		$this->load->model ( 'category_model' );
		$categoryjs = $this->category_model->get_js ();
		include template ( 'weixin_tuwen', 'admin' );
	}

	function getuserinfo() {
		$wx = $this->fromcache ( 'cweixin' );
		if (empty ( $wx ['appsecret'] ) || empty ( $wx ['appid'] )) {
			exit ( "公众号配置中 appid和appsecret没有填写，创建菜单必须认证公众号!" );
		}

		$openid = strip_tags ( $this->input->post ( 'openid' ) );
		$appid = $wx ['appid'];
		$appsecret = $wx ['appsecret'];
		require FCPATH . '/lib/php/jssdk.php';
		$model = new JSSDK ( $appid, $appsecret );
		$userinfo = $model->get_user_info ( $openid );

		if ($userinfo ['openid']) {
			$model = $this->weixin_info_model->f_get ( $userinfo ['openid'] );
			if ($model) {
				$this->weixin_info_model->f_update ( $userinfo );
			} else {
				$this->weixin_info_model->f_insert ( $userinfo );
			}
			//打印用户信息
			exit ( $userinfo ['nickname'] . "更新成功" );
		} else {
			exit ( '授权出错,请重新授权!' );
		}
	}
	function addwelcome() {
		if (null !== $this->input->post ( 'submit' )) {

			$unword = $this->input->post ( 'unword' ) ;
			$this->setting ['unword'] = $unword;
			$this->setting_model->update ( $this->setting );

			$wxword =  $this->input->post ( 'word' ) ;

			$id = $this->weixin_info_model->add ( $wxword );
			if ($id > 0) {
				$message = '关注回复设置成功!';
			}
		}
		$wx = $this->weixin_info_model->get ();
		include template ( 'weixin_welcome', 'admin' );
	}
	//获取粉丝数
	function getfollowers() {
		if ($this->input->post ( 'updatefensi' )) {

			require FCPATH . '/lib/php/jssdk.php';

			$wx = $this->weixin_setting_model->get ();

			if (empty ( $wx ['appsecret'] ) || empty ( $wx ['appid'] )) {
				exit ( "公众号配置中 appid和appsecret没有填写，创建菜单必须认证公众号!" );
			}

			$appid = $wx ['appid'];
			$appsecret = $wx ['appsecret'];

			$model = new JSSDK ( $appid, $appsecret );

			$users = $model->getuserlist ();

			echo json_encode ( $users );
			exit ();
		}

		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'weixin_follower', '1=1', $this->db->dbprefix ) )->row_array () );
		$muserlist = $this->weixin_info_model->f_list ( $startindex, $pagesize );

		$departstr = page ( $rownum, $pagesize, $page, "admin_weixin/getfollowers" );

		include template ( 'weixin_fensi', 'admin' );
	}
	function addtext() {
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		if (null !== $this->input->post ( 'btnup' )) {

			$caozuo = $this->input->post ( 'caozuo' );
			$showtype = $this->input->post ( 'showtype' );
			$systype = $this->input->post ( 'systype' );
			$name = $this->input->post ( 'txtname' );
			$content = $this->input->post ( 'txtcontent' );
			$id = $this->weixin_info_model->addkeywords ( $name, $content, $systype, $showtype );
			if ($id > 0) {
				$message = '关键词插入成功!';
			}
		}

		$keywordlist = $this->weixin_info_model->getkeywords ( $startindex, $pagesize );

		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'weixin_keywords', "title='' or title is null", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin_weixin/addtext" );
		include template ( 'weixin_keywords', 'admin' );
	}
	function addtuwen() {
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		if (null !== $this->input->post ( 'btnup' )) {

			$caozuo = $this->input->post ( 'caozuo' );
			$showtype = $this->input->post ( 'showtype' );
			$systype = $this->input->post ( 'systype' );
			$name = $this->input->post ( 'txtname' );
			$title = $this->input->post ( 'title' );
			$content = $this->input->post ( 'txtcontent' );
			$neirong = $this->input->post ( 'content' );
			$wburl = $this->input->post ( 'wburl' );
			$topicclass = $this->input->post ( 'topicclass' );

			$imgname = strtolower ( $_FILES ['fmtu'] ['name'] );
			if ('' == $title || '' == $content) {

				$this->index ( '请完整填写专题相关参数!', 'errormsg' );
				exit ();

			}

			$type = substr ( strrchr ( $imgname, '.' ), 1 );
			if (! isimage ( $type )) {

				$this->index ( '当前图片图片格式不支持，目前仅支持jpg、png格式！', 'errormsg' );
				exit ();
			}

			$_name = random ( 6, 0 );
			$upload_tmp_file = FCPATH . '/data/tmp/topic_fmtu_' . $_name . '.' . $type;

			$filepath = '/data/attach/topic/topic_fmtu_' . $_name . '.' . $type;
			forcemkdir ( FCPATH . '/data/attach/topic' );
			if (move_uploaded_file ( $_FILES ['fmtu'] ['tmp_name'], $upload_tmp_file )) {
				image_resize ( $upload_tmp_file, FCPATH . $filepath, 360, 240 );
				$aid = 0;
				if (! strstr ( $wburl, 'http:' )) {
					$this->load->model ( "topic_model" );
					$aid = $this->topic_model->addtopic ( $title, $neirong, $filepath, $this->user ['username'], $this->user ['uid'], 1, $topicclass );

				}

				$id = $this->weixin_info_model->addtuwen ( $name, $content, $systype, $showtype, $title, $neirong, $filepath, $wburl, $aid );
				if ($id > 0) {
					$message = '图文添加成功!';
				}
			} else {
				$message = '图文添加失败!';
			}

		}
		$keywordlist = $this->weixin_info_model->gettuwenkeywords ( $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'weixin_keywords', " title!='' ", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin_weixin/addtuwen" );
		$this->load->model ( 'category_model' );
		$categoryjs = $this->category_model->get_js ();
		include template ( 'weixin_tuwen', 'admin' );
	}
	function addnav() {

		if (null !== $this->input->post ( 'menu_name' )) {
			$menu_name = strip_tags ( $this->input->post ( 'menu_name' ) );
			$menu_type = strip_tags ( $this->input->post ( 'menu_type' ) );
			$menu_pid = intval ( $this->input->post ( 'menu_pid' ) );
			$menu_keyword = strip_tags ( $this->input->post ( 'menu_keyword' ) );
			$menu_link = strip_tags ( $this->input->post ( 'menu_link' ) );

			$id = $this->weixin_info_model->addmenu ( $menu_name, $menu_pid, $menu_type, $menu_keyword, $menu_link );
			if ($id > 0) {
				$message = '操作成功!';
			}
		}
		$menulist = $this->weixin_info_model->get_parentmenu (); //一级菜单
		$modellist = $this->weixin_info_model->get_menulist (); //全部菜单


		include template ( 'weixin_addnav', 'admin' );
	}
	function savetoken() {
		if ($this->input->post ( 'submit' )) {

			$openwxpay = strip_tags ( $this->input->post ( 'openwxpay' ) );
			$this->setting ['openwxpay'] = $openwxpay;
			$this->setting_model->update ( $this->setting );

			$token = strip_tags ( $this->input->post ( 'wxtoken' ) );
			$this->setting ['wxtoken'] = $token;
			$this->setting_model->update ( $this->setting );
			$message = 'Token设置更新成功！';

		}
		$wx = $this->weixin_setting_model->get ();
		include template ( 'weixin_set', 'admin' );
	}
	function delmenu() {

		$id = intval ( $this->uri->segment ( 3 ) );
		if ($id > 0) {
			$this->weixin_info_model->removemenu_by_id ( $id );
			$message = '操作成功!';
		}

		$modellist = $this->weixin_info_model->get_menulist (); //全部菜单
		$menulist = $this->weixin_info_model->get_parentmenu ();
		include template ( 'weixin_addnav', 'admin' );
	}
	function makemenu() {
		$wx = $this->weixin_setting_model->get ();

		if (empty ( $wx ['appsecret'] ) || empty ( $wx ['appid'] )) {
			exit ( "公众号配置中 appid和appsecret没有填写，创建菜单必须认证公众号!" );
		}
		$modellist = $this->weixin_info_model->get_menulist (); //全部菜单


		$appid = $wx ['appid'];
		$appsecret = $wx ['appsecret'];
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

		$output = $this->https_request ( $url );
		$jsoninfo = json_decode ( $output, true );

		$access_token = $jsoninfo ["access_token"];
		runlog ( 'menu', json_encode ( $modellist ) );
		$jsonmenu = $this->getmenus ( $modellist );

		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $access_token;
		$result = $this->https_request ( $url, $jsonmenu );

		if (strstr ( $result, 'ok' )) {
			exit ( "菜单生成成功!" );
		} else {

			exit ( "菜单生成失败，请检查微信公众号配置!" );
		}
	}
	function getmenus($models) {

		$menu = '{ "button":[';
		foreach ( $models as $key => $val ) {
			$sub = $models [$key] ['sublist'];
			if (null !== $sub && count ( $sub ) > 0) {
				$menu .= '{"name":"' . $models [$key] ['menu_name'] . '",' . '"sub_button":[';
				$temmenu = "";
				$tmpsubmodels = $models [$key] ['sublist'];
				foreach ( $tmpsubmodels as $k => $v ) {
					if ($tmpsubmodels [$k] ['menu_type'] == 'CLICK') {
						$temmenu .= '{"type":"click","name":"' . $tmpsubmodels [$k] ['menu_name'] . '","key":"' . $tmpsubmodels [$k] ['menu_keyword'] . '"},';
					}
					if ($tmpsubmodels [$k] ['menu_type'] == 'VIEW') {
						$temmenu .= '{"type":"view","name":"' . $tmpsubmodels [$k] ['menu_name'] . '","url":"' . $tmpsubmodels [$k] ['menu_link'] . '"},';
					}
				}
				$temmenu = trim ( $temmenu, ',' );
				$menu .= $temmenu . ']},';
			} else {
				if ($models [$key] ['menu_type'] == 'VIEW') {

					$menu .= '{"type":"view","name":"' . $models [$key] ['menu_name'] . '","url":"' . $models [$key] ['menu_link'] . '"},';

				}
				if ($models [$key] ['menu_type'] == 'CLICK') {
					$menu .= '{"type":"click","name":"' . $models [$key] ['menu_name'] . '","key":"' . $models [$key] ['menu_keyword'] . '"},';

				}

			}
		}
		$menu = trim ( $menu, ',' );
		$menu .= "]}";

		$menu = str_replace ( '"button":[,', '"button":[', $menu );
		//runlog('menufile1', $menu);


		return $menu;
	}
	function https_request($url, $data = null) {
		$curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_URL, $url );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE );
		if (! empty ( $data )) {
			curl_setopt ( $curl, CURLOPT_POST, 1 );
			curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data );
		}
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
		$output = curl_exec ( $curl );
		curl_close ( $curl );
		return $output;
	}
}