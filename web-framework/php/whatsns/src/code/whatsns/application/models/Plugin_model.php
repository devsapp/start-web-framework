<?php
class Plugin_model extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	/**
	 *
	 * 获取条件中总记录
	 *
	 * @date: 2020年11月3日 下午4:02:48
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function gettotal($name = '') {
		if ($name == '') {
			$total = $this->db->count_all ( 'pluginlist' );
		} else {
			$query = $this->db->like ( 'name', $name )->from ( 'pluginlist' );
			$total = $this->db->count_all_results ();
		}
		return $total;
	}
	/**
	 *
	 * 插件安装日志列表
	 *
	 * @date: 2020年11月3日 下午1:23:09
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function get_list($name = '', $start = 0, $limit = 10) {
		$pluginlist = array ();
		if ($name == '') {
			
			$query = $this->db->order_by ( "id desc" )->limit ( $limit, $start )->get ( 'pluginlist' );
		} else {
			
			$query = $this->db->like ( 'name', $name )->order_by ( "id desc" )->limit ( $limit, $start )->get ( 'pluginlist' );
		}
		
		foreach ( $query->result_array () as $plugin ) {
			$plugin ['plugintime'] = date ( 'Y-m-d H:i:s', $plugin ['installtime'] ); // 安装时间
			$plugin ['pluginfilelist'] = json_decode ( $plugin ['filelist'], true ); // 插件包含文件列表

			if (! strstr ( $plugin ['manageurl'], "http://" ) && ! strstr ( $plugin ['manageurl'], "https://" )) {
				$plugin ['pluginurl'] = url ( $plugin ['manageurl'] );
			} else {
				$plugin ['pluginurl'] = $plugin ['manageurl']; // 插件管理访问地址
			}
			// data/tmp/zip/zip_1604380331/zip_1604380331.zip
			if (file_exists ( FCPATH . $plugin ['uploadfile'] )) {
				$plugin ['pluginfile'] = SITE_URL . $plugin ['uploadfile'];
				$dirinfo = pathinfo ( $plugin ['uploadfile'] );
				$plugin ['basename']=$dirinfo['basename'];
				
				$dir = $dirinfo ['dirname'];
				if (is_dir ( FCPATH . $dir )) {
					$plugin ['intalldir'] = FCPATH . $dir;
					$plugin ['backupdir'] = $plugin ['intalldir'] . "/backup";
					if (! is_dir ( $plugin ['backupdir'] )) {
						$plugin ['backupdir'] = 0;
					} else {
						$plugin ['backupdir'] = $dir . "/backup";
					}
					
					if (! file_exists ( $plugin ['backupdir'] . "/backup.zip" )) {
						$plugin ['backupzipfile'] = 0;
					} else {
						$plugin ['backupzipfile'] = SITE_URL . $dir . "/backup/backup.zip";
					}
				} else {
					$plugin ['intalldir'] = 0;
				}
			} else {
				$plugin ['pluginfile'] = 0;
				$plugin ['backupdir'] = 0; // 备份目录
				$plugin ['intalldir'] = 0; // 插件安装目录
				$plugin ['backupzipfile'] = 0; // 插件备份压缩包目录
			}
			
			$pluginlist [] = $plugin;
		}
		return $pluginlist;
	}
}

?>
