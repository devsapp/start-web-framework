<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Install extends CI_Controller {

	var $whitelist;
	function __construct() {
		$this->whitelist = "index";
		parent::__construct ();
		if (file_exists ( FCPATH . 'data/install.lock1' )) {
			exit ( "您已经安装过程序" );
		}
		$view_off = $this->getgpc ( 'view_off' );

		define ( 'VIEW_OFF', $view_off ? TRUE : FALSE );
		$this->load->helper ( 'language' );
		$this->lang->load ( 'install', 'english' );
	}
	function index() {
		$navtitle = $this->setting ['site_name'] . "安装步骤一";
		include template ( 'step1', 'install' );
	}
	function getgpc($k, $t = 'GP') {
		$t = strtoupper ( $t );
		switch ($t) {
			case 'GP' :
				isset ( $_POST [$k] ) ? $var = &$_POST : $var = &$_GET;
				break;
			case 'G' :
				$var = &$_GET;
				break;
			case 'P' :
				$var = &$_POST;
				break;
			case 'C' :
				$var = &$_COOKIE;
				break;
			case 'R' :
				$var = &$_REQUEST;
				break;
		}
		return isset ( $var [$k] ) ? $var [$k] : '';
	}
	function step2() {
		$navtitle = $this->setting ['site_name'] . "安装步骤二";
		$errormessage = '';
		$env_items = array ('os' => array ('c' => 'PHP_OS', 'r' => '不限制', 'b' => 'linux' ), 'php' => array ('c' => 'PHP_VERSION', 'r' => '5.3.7', 'b' => '5.3.7-7.2' ), 'attachmentupload' => array ('r' => '不限制', 'b' => '2M' ), 'gdversion' => array ('r' => '2.0', 'b' => '2.0' ), 'diskspace' => array ('r' => '30M', 'b' => '不限制' ) );
		$func_items = array ('mysqli_connect', 'fsockopen', 'gethostbyname', 'file_get_contents', 'xml_parser_create' );
		$dirfile_items = array ('config' => array ('type' => 'file', 'path' => './config.php' ), 'data' => array ('type' => 'dir', 'path' => './data' ), 'category' => array ('type' => 'dir', 'path' => './data/category' ), 'cache' => array ('type' => 'dir', 'path' => './data/cache' ), 'view' => array ('type' => 'dir', 'path' => './data/view' ), 'avatar' => array ('type' => 'dir', 'path' => './data/avatar' ), 'logs' => array ('type' => 'dir', 'path' => './data/logs' ), 'backup' => array ('type' => 'dir', 'path' => './data/backup' ), 'attach' => array ('type' => 'dir', 'path' => './data/attach' ), 'logo' => array ('type' => 'dir', 'path' => './data/attach/logo' ), 'banner' => array ('type' => 'dir', 'path' => './data/attach/banner' ), 'topic' => array ('type' => 'dir', 'path' => './data/attach/topic' ), 'upload' => array ('type' => 'dir', 'path' => './data/upload' ), 'ueditor' => array ('type' => 'dir', 'path' => './data/ueditor' ), 'tmp' => array ('type' => 'dir', 'path' => './data/tmp' ) );
		$this->env_check ( $env_items );
		$this->dirfile_check ( $dirfile_items );
		foreach ( $env_items as $key => $item ) {
			if ($key == 'php' && strcmp ( $item ['current'], $item ['r'] ) < 0) {

				$errormessage = "php版本太低，当前php版本" . $item ['current'];

			}

			$status = 1;
			if ($item ['r'] != '不限制') {
				if (intval ( $item ['current'] ) && intval ( $item ['r'] )) {
					if (intval ( $item ['current'] ) < intval ( $item ['r'] )) {
						$status = 0;
						$error_code = 31;

					}
				} else {
					if (strcmp ( $item ['current'], $item ['r'] ) < 0) {
						$status = 0;
						$error_code = 31;

					}
				}
			}

			$env_strbase .= "<tr>\n";
			$env_strbase .= "<td>" . $this->lang->line ( $key ) . "</td>\n";
			$env_strbase .= "<td class=\"padleft\">" . $item ['r'] . "</td>\n";
			$env_strbase .= "<td class=\"padleft\">" . $item ['b'] . "</td>\n";
			$env_strbase .= ($status ? "<td class=\"w pdleft1\">" : "<td class=\"nw pdleft1\">") . $item ['current'] . "</td>\n";
			$env_strbase .= "</tr>\n";

		}

		$env_str .= "<h2 class=\"title\">" . $this->lang->line ( 'env_check' ) . "</h2>\n";
		$env_str .= "<table class=\"tb table\" style=\"margin:20px 0 20px 55px;\">\n";
		$env_str .= "<tr>\n";
		$env_str .= "\t<th>" . $this->lang->line ( 'project' ) . "</th>\n";
		$env_str .= "\t<th class=\"padleft\">" . $this->lang->line ( 'ask_required' ) . "</th>\n";
		$env_str .= "\t<th class=\"padleft\">" . $this->lang->line ( 'ask_best' ) . "</th>\n";
		$env_str .= "\t<th class=\"padleft\">" . $this->lang->line ( 'curr_server' ) . "</th>\n";
		$env_str .= "</tr>\n";
		$env_str .= "</tr>\n";
		$env_str .= $env_strbase;
		$env_str .= "</table>\n";

		//目录环境检测
		foreach ( $dirfile_items as $key => $item ) {
			$tagname = $item ['type'] == 'file' ? 'File' : 'Dir';
			$variable = $item ['type'] . '_str';

			$$variable .= "<tr>\n";
			$$variable .= "<td>$item[path]</td><td class=\"w pdleft1\">" . lang ( 'writeable' ) . "</td>\n";
			if ($item ['status'] == 1) {
				$$variable .= "<td class=\"w pdleft1\">" . $this->lang->line ( 'writeable' ) . "</td>\n";
			} elseif ($item ['status'] == - 1) {
				$error_code = 31;
				$$variable .= "<td class=\"nw pdleft1\">" . $this->lang->line ( 'nodir' ) . "</td>\n";
			} else {
				$error_code = 31;
				$$variable .= "<td class=\"nw pdleft1\">" . $this->lang->line ( 'unwriteable' ) . "</td>\n";
			}
			$$variable .= "</tr>\n";

		}

		$env_str .= "<h2 class=\"title\">" . $this->lang->line ( 'priv_check' ) . "</h2>\n";
		$env_str .= "<table class=\"tb table\" style=\"margin:20px 0 20px 55px;width:90%;\">\n";
		$env_str .= "\t<tr>\n";
		$env_str .= "\t<th>" . $this->lang->line ( 'step1_file' ) . "</th>\n";
		$env_str .= "\t<th class=\"padleft\">" . $this->lang->line ( 'step1_need_status' ) . "</th>\n";
		$env_str .= "\t<th class=\"padleft\">" . $this->lang->line ( 'step1_status' ) . "</th>\n";
		$env_str .= "</tr>\n";
		$env_str .= $file_str;
		$env_str .= $dir_str;
		$env_str .= "</table>\n";
		foreach ( $func_items as $item ) {
			$status = function_exists ( $item );
			$func_str .= "<tr>\n";
			$func_str .= "<td>$item()</td>\n";
			if ($status) {
				$func_str .= "<td class=\"w pdleft1\">" . $this->lang->line ( 'supportted' ) . "</td>\n";
				$func_str .= "<td class=\"padleft\">" . $this->lang->line ( 'none' ) . "</td>\n";
			} else {
				$error_code = 31;
				$func_str .= "<td class=\"nw pdleft1\">" . $this->lang->line ( 'unsupportted' ) . "</td>\n";
				$func_str .= "<td><font color=\"red\">" . $this->lang->line ( 'advice_' . $item ) . "</font></td>\n";
			}
		}
		$env_str .= "<h2 class=\"title\">" . $this->lang->line ( 'func_depend' ) . "</h2>\n";
		$env_str .= "<table class=\"tb table\" style=\"margin:20px 0 20px 55px;width:90%;\">\n";
		$env_str .= "<tr>\n";
		$env_str .= "\t<th>" . $this->lang->line ( 'func_name' ) . "</th>\n";
		$env_str .= "\t<th class=\"padleft\">" . $this->lang->line ( 'check_result' ) . "</th>\n";
		$env_str .= "\t<th class=\"padleft\">" . $this->lang->line ( 'suggestion' ) . "</th>\n";
		$env_str .= "</tr>\n";
		$env_str .= $func_str;
		$env_str .= "</table>\n";

		include template ( 'step2', 'install' );
	}
	//数据库安装
	function step3() {
		$message='';
		$navtitle = $this->setting ['site_name'] . "安装步骤三-数据库安装";
		$form_db_init_items = array ('dbinfo' => array ('dbhost' => array ('type' => 'text', 'required' => 1, 'reg' => '/^.*$/', 'value' => array ('type' => 'string', 'var' => '127.0.0.1' ) ), 'dbname' => array ('type' => 'text', 'required' => 1, 'reg' => '/^.*$/', 'value' => array ('type' => 'string', 'var' => 'ask2' ) ), 'dbuser' => array ('type' => 'text', 'required' => 0, 'reg' => '/^.*$/', 'value' => array ('type' => 'string', 'var' => 'root' ) ), 'dbpw' => array ('type' => 'password', 'required' => 0, 'reg' => '/^.*$/', 'value' => array ('type' => 'string', 'var' => '' ) ), 'tablepre' => array ('type' => 'text', 'required' => 0, 'reg' => '/^.*$/', 'value' => array ('type' => 'string', 'var' => 'ask_' ) ) ), 'admininfo' => array ('ucadminname' => array ('type' => 'text', 'required' => 1, 'reg' => '/^.*$/', 'value' => array ('type' => 'string', 'var' => 'admin' ) ), 'ucfounderpw' => array ('type' => 'password', 'required' => 1, 'reg' => '/^.*$/' ), 'ucfounderpw2' => array ('type' => 'password', 'required' => 1, 'reg' => '/^.*$/' ), 'ucadminemail' => array ('type' => 'text', 'required' => 1, 'reg' => "/^[a-z'0-9]+([._-][a-z'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/", 'value' => array ('type' => 'string', 'var' => '' ) ) ) );
		if ($_POST ['dbname'] != null) {
			$this->load->dbutil ();
			$dbname = $this->input->post ( 'dbname' );
			if ($this->dbutil->database_exists ( $dbname )) {
				$message="数据库已经存在";
				include template ( 'step3', 'install' );
				exit();
			}
		}


		include template ( 'step3', 'install' );
	}
	function env_check(&$env_items) {
		foreach ( $env_items as $key => $item ) {
			if ($key == 'php') {
				$env_items [$key] ['current'] = PHP_VERSION;
			} elseif ($key == 'attachmentupload') {
				$env_items [$key] ['current'] = @ini_get ( 'file_uploads' ) ? ini_get ( 'upload_max_filesize' ) : 'unknow';
			} elseif ($key == 'gdversion') {
				$tmp = function_exists ( 'gd_info' ) ? gd_info () : array ();
				$env_items [$key] ['current'] = empty ( $tmp ['GD Version'] ) ? 'noext' : $tmp ['GD Version'];
				unset ( $tmp );
			} elseif ($key == 'diskspace') {
				if (function_exists ( 'disk_free_space' )) {
					$env_items [$key] ['current'] = floor ( disk_free_space ( FCPATH ) / (1024 * 1024) ) . 'M';
				} else {
					$env_items [$key] ['current'] = 'unknow';
				}
			} elseif (isset ( $item ['c'] )) {
				$env_items [$key] ['current'] = constant ( $item ['c'] );
			}

			$env_items [$key] ['status'] = 1;
			if ($item ['r'] != '不限制' && strcmp ( $env_items [$key] ['current'], $item ['r'] ) < 0) {
				$env_items [$key] ['status'] = 0;
			}
		}

	}
	function dir_writeable($dir) {
		$writeable = 0;
		if (! is_dir ( $dir )) {
			@mkdir ( $dir, 0777 );
		}
		if (is_dir ( $dir )) {
			if ($fp = @fopen ( "$dir/test.txt", 'w' )) {
				@fclose ( $fp );
				@unlink ( "$dir/test.txt" );
				$writeable = 1;
			} else {
				$writeable = 0;
			}
		}
		return $writeable;
	}
	function dirfile_check(&$dirfile_items) {
		foreach ( $dirfile_items as $key => $item ) {
			$item_path = $item ['path'];
			if ($item ['type'] == 'dir') {
				if (! $this->dir_writeable ( FCPATH . $item_path )) {
					if (is_dir ( FCPATH . $item_path )) {
						$dirfile_items [$key] ['status'] = 0;
						$dirfile_items [$key] ['current'] = '+r';
					} else {
						$dirfile_items [$key] ['status'] = - 1;
						$dirfile_items [$key] ['current'] = 'nodir';
					}
				} else {
					$dirfile_items [$key] ['status'] = 1;
					$dirfile_items [$key] ['current'] = '+r+w';
				}
			} else {
				if (file_exists ( FCPATH . $item_path )) {
					if (is_writable ( FCPATH . $item_path )) {
						$dirfile_items [$key] ['status'] = 1;
						$dirfile_items [$key] ['current'] = '+r+w';
					} else {
						$dirfile_items [$key] ['status'] = 0;
						$dirfile_items [$key] ['current'] = '+r';
					}
				} else {
					if ($this->dir_writeable ( dirname ( FCPATH . $item_path ) )) {
						$dirfile_items [$key] ['status'] = 1;
						$dirfile_items [$key] ['current'] = '+r+w';
					} else {
						$dirfile_items [$key] ['status'] = - 1;
						$dirfile_items [$key] ['current'] = 'nofile';
					}
				}
			}
		}
	}

}