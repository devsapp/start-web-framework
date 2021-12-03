<?php

/* 系统定时任务处理 */

class Crontab_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	/* 统计所有分类下的问题数目 */

	function sum_category_question($crontab, $force = 0) {
		$curtime = time ();
		if (($crontab ['lastrun'] + $crontab ['minute'] * 60) < $curtime || $force) {
			/* 第一步：统计每个分类下的问题数目 */
			$query = $this->db->query ( "SELECT c.id,c.pid,count(*) as num FROM " . $this->db->dbprefix . "question as q," . $this->db->dbprefix . "category as c WHERE c.id=q.cid AND q.status !=0 GROUP BY c.id" );
			//第二步:依次更新所有分类的问题数目
			foreach ( $query->result_array () as $category ) {
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "category SET questions=" . $category ['num'] . " WHERE `id`=" . $category ['id'] );
			}
			if ($crontab) {
				$nextrun = $curtime + $crontab ['minute'] * 60;
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "crontab SET lastrun=$curtime,nextrun=$nextrun WHERE id=" . $crontab ['id'] );
			}
			//第三步:更新缓存文件
			@unlink ( APPPATH . "data/cache/categorylist.php" );
			@unlink ( APPPATH . "data/cache/category.php" );
			@unlink ( APPPATH . "data/cache/crontab.php" );
		}
	}

}

?>
