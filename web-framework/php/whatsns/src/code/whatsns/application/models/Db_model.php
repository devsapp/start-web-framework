<?php

class Db_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function showtables() {
		$tablelist = array ();
		$query = $this->db->query ( "SHOW TABLES LIKE '" . $this->db->dbprefix . "%'" );
		foreach ( $query->result_array () as $table ) {
			$tablelist [] = $table ["Tables_in_" . $this->db->database . " (" . $this->db->dbprefix . "%)"];
		}
		return $tablelist;
	}

	function get_sqlfile_list($filedir) {
		$filelist = array ();
		$handle = opendir ( $filedir );
		while ( $filename = readdir ( $handle ) ) {
			if (! is_dir ( $filedir . $filename ) && '.' != $filename && '..' != $filename && ('.zip' == substr ( $filename, - 4 ) || '.sql' == substr ( $filename, - 4 ))) {
				$file ['filename'] = $filename;
				$file ['filepath'] = APPPATH . "data/db_backup/" . $file ['filename'];
				$filesize = (filesize ( $filedir . $filename ) / 1024);
				$size = explode ( ".", $filesize );
				$file ['filesize'] = $size [0] . " KB";
				$file ['filectime'] = tdate ( filectime ( $filedir . $filename ) );
				$filelist [] = $file;
			}
		}
		closedir ( $handle );
		return $filelist;
	}

	function show_table_status() {
		$statuslist = array ();
		$query = $this->db->query ( "SHOW TABLE STATUS LIKE '" . $this->db->dbprefix . "%'" );
		foreach ( $query->result_array () as $status ) {
			$statuslist [] = $status;
		}
		return $statuslist;
	}

	function check_table($table_name) {
		$query = $this->db->query ( "CHECK TABLE " . $table_name );
		return $query->result_array ();
	}

	function show_tables_like() {
		$tablelist = array ();
		$query = $this->db->query ( "SHOW TABLES  LIKE '" . $this->db->dbprefix . "%'" );
		foreach ( $query->result_array () as $table ) {

			$tablelist [] =$table["Tables_in_ask2 (ask_%)"];
		}

		return $tablelist;
	}




	function splitsql(&$sql) {
		$sqllist = array ();
		$num = 0;
		$sql = str_replace ( "\r", "\n", $sql );
		$sql = explode ( ";\n", trim ( $sql ) );
		foreach ( $sql as $query ) {
			$queries = explode ( "\n", trim ( $query ) );
			foreach ( $queries as $query ) {
				$sqllist [$num] .= $query [0] == "#" ? NULL : $query;
			}
			$num ++;
		}
		unset ( $sql );
		return ($sqllist);
	}

	function syntablestruct($sql, $version, $dbcharset) {
		if (strpos ( trim ( substr ( $sql, 0, 18 ) ), 'CREATE TABLE' ) === FALSE) {
			return $sql;
		}
		$sqlversion = strpos ( $sql, 'ENGINE=' ) === FALSE ? FALSE : TRUE;
		if ($sqlversion === $version) {
			return $sqlversion && $dbcharset ? preg_replace ( array ('/ character set \w+/i', '/ collate \w+/i', "/DEFAULT CHARSET=\w+/is" ), array ('', '', "DEFAULT CHARSET=$dbcharset" ), $sql ) : $sql;
		}
		if ($version) {
			return preg_replace ( array ('/TYPE=HEAP/i', '/TYPE=(\w+)/is' ), array ("ENGINE=MEMORY DEFAULT CHARSET=$dbcharset", "ENGINE=\\1 DEFAULT CHARSET=$dbcharset" ), $sql );
		} else {
			return preg_replace ( array ('/character set \w+/i', '/collate \w+/i', '/ENGINE=MEMORY/i', '/\s*DEFAULT CHARSET=\w+/is', '/\s*COLLATE=\w+/is', '/ENGINE=(\w+)(.*)/is' ), array ('', '', 'ENGINE=HEAP', '', '', 'TYPE=\\1\\2' ), $sql );
		}
	}

	function write_to_sql(&$sqldump, $dumpfile, $volume) {
		$sqldump = "# <?exit();?>\n" . "# Multi-Volume Data Dump Vol.$volume\n" . "# Version: ask2 3.7" . "\n" . "# Time: " . date ( "Y-m-d", $this->base->time ) . "\n" . "# Type: $type\n" . "# Table Prefix: " . $this->db->dbprefix . "\n" . "# Home: http://www.ask2.cn\n" . $sqldump;
		$dumpfilename = sprintf ( $dumpfile, $volume );
		$byte = writetofile ( $dumpfilename, $sqldump );
		return ($byte > 0);
	}

	function write_to_zip($backupfilename, $dumpfile, $volume) {
		require_once APPPATH . 'libraries/zip.class.php';
		$zip = new zip ();
		if (! $zip->chk_zip) {
			$this->message ( 'û�п���gzopen��' );
		}
		$zipfilename = $backupfilename . '.zip';
		$unlinks = '';
		for($i = 1; $i <= $volume; $i ++) {
			$filename = sprintf ( $dumpfile, $i );
			$fp = fopen ( $filename, "r" );
			$content = @fread ( $fp, filesize ( $filename ) );
			fclose ( $fp );
			$zip->add_File ( $content, basename ( $filename ) );
			$unlinks .= "@unlink('$filename');";
		}
		$fp = fopen ( $zipfilename, 'w' );
		if (@fwrite ( $fp, $zip->get_file () ) !== FALSE) {
			eval ( $unlinks );
		}
		unset ( $sqldump, $zip, $content );
	}

	function sqldumptable($table, $complete, $sizelimit, $startfrom = 0, $currsize = 0) {
		$sqlcompat = "";
		$db = $this->db;
		$offset = 300;
		$tabledump = '';
		$tablefields = array ();
		$sqlcharset = $this->db->char_set;
		$dumpcharset = $this->db->char_set;

		if ($table == $this->db->dbprefix . "session") {
			$result ['tabledump'] = "\n";
			$result ['startfrom'] = $startfrom;
			$result ['complete'] = $complete;
			return $result;
		}
		$query = $db->query ( "SHOW FULL COLUMNS FROM $table", 'SILENT' );
		if (! $query && $db->errno () == 1146) {
			return;
		} elseif (! $query) {
			$usehex = FALSE;
		} else {
			foreach ( $query->result_array () as $fieldrow ) {
				$tablefields [] = $fieldrow;
			}
		}
		if (! $startfrom) {
			$createtable = $db->query ( "SHOW CREATE TABLE $table", 'SILENT' );
			if (! $db->error ()) {
				$tabledump = "DROP TABLE IF EXISTS $table;\n";
			} else {
				return '';
			}
			$create = $db->fetch_row ( $createtable );

			if (strpos ( $table, '.' ) !== FALSE) {
				$tablename = substr ( $table, strpos ( $table, '.' ) + 1 );
				$create [1] = str_replace ( "CREATE TABLE $tablename", 'CREATE TABLE ' . $table, $create [1] );
			}
			$tabledump .= $create [1];

			if ($sqlcompat == 'MYSQL41' && $db->version () < '4.1') {
				$tabledump = preg_replace ( "/TYPE\=(.+)/", "ENGINE=\\1 DEFAULT CHARSET=" . $dumpcharset, $tabledump );
			}
			if ($db->version () > '4.1' && $sqlcharset) {
				$tabledump = preg_replace ( "/(DEFAULT)*\s*CHARSET=.+/", "DEFAULT CHARSET=" . $sqlcharset, $tabledump );
			}

			$tablestatus = $db->fetch_first ( "SHOW TABLE STATUS LIKE '$table'" );
			$tabledump .= ($tablestatus ['Auto_increment'] ? " AUTO_INCREMENT=$tablestatus[Auto_increment]" : '') . ";\n\n";
			if ($sqlcompat == 'MYSQL40' && $db->version () >= '4.1' && $db->version () < '5.1') {
				if ($tablestatus ['Auto_increment'] != '') {
					$temppos = strpos ( $tabledump, ',' );
					$tabledump = substr ( $tabledump, 0, $temppos ) . ' auto_increment' . substr ( $tabledump, $temppos );
				}
				if ($tablestatus ['Engine'] == 'MEMORY') {
					$tabledump = str_replace ( 'TYPE=MEMORY', 'TYPE=HEAP', $tabledump );
				}
			}
		}
		$tabledumped = 0;
		$numrows = $offset;
		$firstfield = $tablefields [0];
		while ( $currsize + strlen ( $tabledump ) + 500 < $sizelimit * 1000 && $numrows == $offset ) {
			$selectsql = "SELECT * FROM $table LIMIT $startfrom, $offset";
			$tabledumped = 1;
			$rows = $db->query ( $selectsql )->result_array ();
			$numfields = $db->num_fields ( $rows );
			$numrows = $db->num_rows ( $rows );
			while ( $row = $db->fetch_row ( $rows ) ) {
				$comma = $t = '';
				for($i = 0; $i < $numfields; $i ++) {
					$t .= $comma . ($usehex && ! empty ( $row [$i] ) && (strexists ( $tablefields [$i] ['Type'], 'char' ) || strexists ( $tablefields [$i] ['Type'], 'text' )) ? '0x' . bin2hex ( $row [$i] ) : '\'' . mysql_escape_string ( $row [$i] ) . '\'');
					$comma = ',';
				}
				if (strlen ( $t ) + $currsize + strlen ( $tabledump ) + 500 < $sizelimit * 1000) {
					$startfrom ++;
					$tabledump .= "INSERT INTO $table VALUES ($t);\n";
				} else {
					$complete = FALSE;
					break 2;
				}
			}
		}

		$result ['tabledump'] = $tabledump . "\n";
		$result ['startfrom'] = $startfrom;
		$result ['complete'] = $complete;
		return $result;
	}

	function databasesize() {
		$dbsize = 0;
		$query = $this->db->query ( "SHOW TABLE STATUS FROM `" . $this->db->database . "`" );
		foreach ( $query->result_array () as $table ) {
			$dbsize += $table ['Data_length'] + $table ['Index_length'];
		}
		return $dbsize;
	}

}
?>