<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_db extends CI_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( 'db_model' );
	}

	/*数据库备份*/
	function backup() {
		set_time_limit ( 0 );
		$filedir = FCPATH . "/data/db_backup/";
		if (! $this->input->post ( 'backupsubmit' ) && ! $this->uri->segment ( 10 )) {
			$sqlfilename = date ( "Ymd", $this->time ) . "_" . random ( 8 );
			$tables = $this->db_model->showtables ();
			forcemkdir ( $filedir );
			$filename = $this->db_model->get_sqlfile_list ( $filedir );
			include template ( 'dbbackup', 'admin' );
		} else {
			$sqldump = '';
			$type = null !== $this->input->post ( 'type' ) ? $this->input->post ( 'type' ) : $this->uri->segment ( 3 );
			$sqlfilename = null !== $this->input->post ( 'sqlfilename' ) ? $this->input->post ( 'sqlfilename' ) : rawurldecode ( $this->uri->segment ( 4 ) );
			$sizelimit = null !== $this->input->post ( 'sizelimit' ) ? $this->input->post ( 'sizelimit' ) : intval ( $this->uri->segment ( 5 ) );
			$tableid = intval ( $this->uri->segment ( 6 ) );
			$startfrom = intval ( $this->uri->segment ( 7 ) );
			$volume = intval ( $this->uri->segment ( 8 ) ) + 1;
			$compression = null !== $this->input->post ( 'compression' ) ? $this->input->post ( 'compression' ) : intval ( $this->uri->segment ( 9 ) );
			$backupfilename = $filedir . $sqlfilename;
			$backupsubmit = 1;
			$tables = array ();
			if (substr ( trim ( ini_get ( 'memory_limit' ) ), 0, - 1 ) < 32 && substr ( trim ( ini_get ( 'memory_limit' ) ), 0, - 1 ) > 0) {
				@ini_set ( 'memory_limit', '32M' );
			}
			if (! is_mem_available ( $sizelimit * 1024 * 3 )) {
				$this->message ( $sizelimit . 'KB 大于PHP程序可用值,请设置较小分卷大小值', 'index.php?admin_db/backup' );
			}
			switch ($type) {
				case "full" :
					$tables = $this->db_model->showtables ();
					break;
				case "stand" :
					$tables = array ($this->db->dbprefix . "category", $this->db->dbprefix . "question", $this->db->dbprefix . "answer", $this->db->dbprefix . "user", $this->db->dbprefix . "setting" );
					break;
				case "min" :
					$tables = array ($this->db->dbprefix . "question", $this->db->dbprefix . "answer" );
					break;
				case "custom" :
					if (! ( bool ) $this->input->post ( 'tables' )) {
						$tables = $this->cache->read ( 'backup_tables', '0' );
					} else {
						$tables = $this->input->post ( 'tables' );
						$this->cache->write ( 'backup_tables', $tables );
					}
					break;
			}
			if ($sizelimit < 512) {
				$this->message ( '文件大小限制不要小于512K', 'BACK' );
			}
			if (count ( $tables ) == 0) {
				$this->message ( '请先选择数据表!', 'BACK' );
			}
			if (! file_exists ( $filedir )) {
				forcemkdir ( $filedir );
			}
			if (! iswriteable ( $filedir )) {
				$this->message ( '/data/db_backup 文件夹不可写!', 'index.php?admin_db-backup' );
			}
			if (in_array ( $this->db->dbprefix . "usergroup", $tables )) {
				$num = array_search ( $this->db->dbprefix . "usergroup", $tables );
				$tables [$num] = $tables [0];
				$tables [0] = $this->db->dbprefix . "usergroup";
			}
			if (in_array ( $this->db->dbprefix . "user", $tables )) {
				$num = array_search ( $this->db->dbprefix . "user", $tables );
				if ($tables [0] == $this->db->dbprefix . "usergroup") {
					$tables [$num] = $tables [1];
					$tables [1] = $this->db->dbprefix . "user";
				} else {
					$tables [$num] = $tables [0];
					$tables [0] = $this->db->dbprefix . "user";
				}
			}
			$complete = TRUE;
			for(; $complete && $tableid < count ( $tables ) && strlen ( $sqldump ) + 500 < $sizelimit * 1000; $tableid ++) {
				$result = $this->db_model->sqldumptable ( $tables [$tableid], $complete, $sizelimit, $startfrom, strlen ( $sqldump ) );
				$sqldump .= $result ['tabledump'];
				$complete = $result ['complete'];
				if ($complete) {
					$startfrom = 0;
				} else {
					$startfrom = $result ['startfrom'];
				}
			}
			$dumpfile = $backupfilename . "_%s" . '.sql';
			! $complete && $tableid --;
			if (trim ( $sqldump )) {
				$result = $this->db_model->write_to_sql ( $sqldump, $dumpfile, $volume );
				if (! $result) {
					$this->message ( '无法写入sql文件,请返回', 'BACK' );
				} else {
					$url = "index.php?admin_db/backup/$type/" . rawurlencode ( $sqlfilename ) . "/$sizelimit/$tableid/$startfrom/$volume/$compression/$backupsubmit";
					$this->message ( "<image src='" . SITE_URL . "static/css/default/loading.gif'><br />第 " . $volume . ' 个文件已经完成!正在进入下一个备份!' . "<script type=\"text/javascript\">setTimeout(\"window.location.replace('$url');\", 2000);</script>", 'BACK' );
				}
			} else {
				$volume --;
				if ($compression && is_mem_available ( $sizelimit * 1024 * 3 * $volume )) {
					$this->db_model->write_to_zip ( $backupfilename, $dumpfile, $volume );
				}
				$this->cache->remove ( 'backup_tables' );
				$this->message ( '数据备份成功！', 'admin_db/backup' );
			}
		}
	}
	function backupdb() {
		$this->load->dbutil ();

		$backup = $this->dbutil->backup ();

		$this->load->helper ( 'file' );
		write_file ( '/path/to/mybackup.gz', $backup );

		$this->load->helper ( 'download' );
		force_download ( 'mybackup.gz', $backup );
	}

	/*数据库导入*/
	function import() {
		set_time_limit ( 0 );
		if (substr ( trim ( ini_get ( 'memory_limit' ) ), 0, - 1 ) < 32 && substr ( trim ( ini_get ( 'memory_limit' ) ), 0, - 1 ) > 0) {
			@ini_set ( 'memory_limit', '32M' );
		}
		$filename = str_replace ( '*', '.', $this->uri->segment ( 3 ) );
		$filenum = $this->uri->segment ( 4 ) ? $this->uri->segment ( 4 ) : 1;
		$filedir = "./data/db_backup/";
		$filetype = $this->uri->segment ( 5 ) ? $this->uri->segment ( 5 ) : substr ( $filename, - 3 );
		if ($filetype != 'zip' && $filetype != 'sql') {
			$this->message ( '文件格式不正确', 'BACK' );
		} else {
			if ($filenum == 1) {
				if ($filetype == 'zip') {
					require_once FCPATH . '/lib/zip.class.php';
					$zip = new zip ();
					if (! $zip->chk_zip) {
						$this->message ( 'chkziperror', '' );
					}
					$zip->Extract ( $filedir . $filename, $filedir );
					$filename = substr ( $filename, 0, - 4 ) . "_1.sql";
				} else {
					$num = strrpos ( $filename, "_" );
					$filename = substr ( $filename, 0, $num ) . "_1.sql";
				}
			}
			if (file_exists ( $filedir . $filename )) {
				$sqldump = readfromfile ( $filedir . $filename );
				preg_match ( '/#\sVersion:\sask2\s([^\n]+)\n/i', $sqldump, $tversion );

				$sqlquery = $this->db_model->splitsql ( $sqldump );
				unset ( $sqldump );
				foreach ( $sqlquery as $sql ) {
					$sql = $this->db_model->syntablestruct ( trim ( $sql ), true, 'UTF-8' );
					if ($sql != '') {
						$this->db->query ( $sql );

		//if (($sqlerror = $this->db->error ()) && $this->db->errno () != 1062) {
					//	$this->db->halt ( 'MySQL Query Error', $sql );
					//}
					}
				}
				if ($filetype == 'zip') {
					@unlink ( $filedir . $filename );
				}
				$filenum ++;
				$num = strrpos ( $filename, "_" );
				$filename = str_replace ( '.', '*', substr ( $filename, 0, $num ) . "_" . $filenum . ".sql" );
				$this->message ( "<image src='" . base_url () . "static/css/default/loading.gif'><br />" . '第 ' . ($filenum - 1) . ' 个文件已经完成!正在进入下一个备份!', "admin_db/import/$filename/$filenum/$filetype" );
			} else {
				$this->cache->remove ( 'import_files' );
				$this->message ( '导入数据成功!', 'admin_db/backup' );
			}
		}
	}

	/*删除备份文件*/
	function remove() {
		$filename = $this->uri->segment ( 3 );
		$filename = str_replace ( '*', '.', $filename );
		$filedir = FCPATH . "/data/db_backup/" . $filename;
		if (! iswriteable ( $filedir ))
			$this->message ( '文件不可写!', 'admin_db/backup' );
		if (file_exists ( $filedir )) {
			unlink ( $filedir );
			$this->message ( '删除文件成功!', 'admin_db/backup' );
		}
	}

	/*表列表*/
	function tablelist() {
		$dbversion = $this->db->version();
		$ret = $list = array ();
		$chip = 0;
		$ret = $this->db_model->show_table_status ();
		$count = count ( $ret );
		for($i = 0; $i < $count; $i ++) {
			$res = $this->db_model->check_table ( $ret [$i] ['Name'] );
			$type = $dbversion > '4.1' ? $ret [$i] ['Engine'] : $ret [$i] ['Type'];
			$chartset = $dbversion > '4.1' ? $ret [$i] ['Collation'] : 'N/A';
			$tablelist [] = array ('table' => $ret [$i] ['Name'], 'type' => $type, 'rec_num' => $ret [$i] ['Rows'], 'rec_index' => sprintf ( " %.2f KB", $ret [$i] ['Data_length'] / 1024 ), 'rec_chip' => $ret [$i] ['Data_free'], 'status' => $res ['Msg_text'], 'chartset' => $chartset );
			$chip += $ret [$i] ['Data_free'];
			if ($tablelist [$i] ['table'] == $this->db->dbprefix . "session") {
				$session_chip = $list [$i] ['rec_chip'];
				$tablelist [$i] ['rec_chip'] = "0";
				$tablelist [$i] ['status'] = "OK";
			}
		}
		$number = $chip - $session_chip;
		include template ( 'dboptimize', 'admin' );
	}

	/*数据库优化*/
	function optimize() {
		$this->load->dbutil ();
		$tables = $this->db_model->show_tables_like ();
		$message = '';
		foreach ( $tables as $table ) {
			if (! $this->dbutil->optimize_table ( substr ( $table, strlen ( $this->db->dbprefix ) ) )) {
				$message .= '表 ' . $table . ' 优化失败<br>';
			} else {
				$message .= '表 ' . $table . ' 优化成功<br>';
			}
		}
		$this->message ( $message, 'admin_db/tablelist' );
	}
	//优化数据库
	function databaseoptimize() {
		$this->load->dbutil ();
		$result = $this->dbutil->optimize_database ();

		if ($result !== FALSE) {
			$this->message ( '数据库优化成功', 'admin_db/tablelist' );
		} else {
			$this->message ( '数据库优化失败', 'admin_db/tablelist' );
		}
	}
	/*数据库修复*/
	function repair() {
		$this->load->dbutil ();
		$tables = $this->db_model->show_tables_like ();
		$message = '';
		foreach ( $tables as $table ) {

			if (! $this->dbutil->repair_table ( substr ( $table, strlen ( $this->db->dbprefix ) ) )) {
				$message .= '表 ' . $table . ' 修复失败<br>';
			} else {
				$message .= '表 ' . $table . ' 修复成功<br>';
			}
		}

		$this->message ( $message, 'admin_db/tablelist' );
	}

	/*数据库SQL执行*/
	function sqlwindow() {
		if (null !== $this->input->post ( 'sqlsubmit' )) {
			echo '<meta http-equiv="Content-Type" content="text/html;charset=' . ASK2_CHARSET . '">';
			$sql = trim ( stripslashes ( $this->input->post ( 'sqlwindow' ) ) );
			$sqltype = $this->input->post ( 'sqltype' );
			if ('' == $sql) {
				echo 'SQL语句为空！';
			} elseif (eregi ( "drop(.*)table", $sql ) || eregi ( "drop(.*)database", $sql )) {
				echo 'drop语句不允许在这里执行。';
			} elseif (eregi ( "^select ", $sql )) {
				$query = $this->db->query ( $sql );
				if (! $query) {
					echo 'SQL语句执行失败！';
				} else {
					$num = $this->db->num_rows ( $query );
					if ($num <= 0) {
						echo '运行SQL：' . $sql . '，无返回记录！';
					} else {
						echo '运行SQL：' . $sql . '，共有' . $num . '条记录，最大返回50条！';
						$j = 0;
						foreach ( $query->result_array () as $row ) {
							$j ++;
							if ($j > 50) {
								break;
							}
							echo '<p style=" background-color:#d3e8fd;">' . '记录：' . $j . '</p>';
							foreach ( $row as $k => $v ) {
								echo "<font color='red'>{$k} : </font>{$v}<br/>\r\n";
							}
						}

					}
				}
			} else {
				if (1 == $sqltype) {
					$sql = str_replace ( "\r", "", $sql );
					$sqls = split ( ";[ \t]{0,}\n", $sql );
					$i = 0;
					foreach ( $sqls as $q ) {
						$q = trim ( $q );
						if ($q == "") {
							continue;
						}
						if (( bool ) $this->db->query ( $q )) {
							$i ++;
							echo $q . '<br/>';
							echo 'SQL语句执行成功！';
						} else {
							echo '执行： <font color="blue">' . $q . '</font> 出错';
						}
					}
				} else {
					if ($query = $this->db->query ( $sql )) {
						echo 'SQL语句执行成功！';
					} else {
						echo 'SQL语句执行失败！';
					}
				}
			}
			exit ();
		}
		include template ( 'sqlwindow', 'admin' );
	}

	/*下载备份*/
	function downloadfile() {
		$filename = str_replace ( '*', '.', $this->uri->segment ( 3 ) );
		header ( 'content-disposition: attachment; filename=' . $filename );
		echo readfromfile ( 'data/db_backup/' . $filename );
	}

}
?>