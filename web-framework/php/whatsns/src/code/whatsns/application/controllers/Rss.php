<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
define("SHOWNUM", 100);
class Rss extends CI_Controller {

	var $whitelist;
	var $statusarray = array ('all' => '全部', '0' => '待审核', '1' => '待解决', '2' => '已解决', '4' => '悬赏', '9' => '已关闭' );
	function __construct() {
		$this->whitelist = "set,articlelist,tag,userspace,clist";
		parent::__construct ();
		$this->load->model ( 'category_model' );
		$this->load->model ( 'question_model' );
		$this->load->model ( 'answer_model' );
		$this->load->model ( "tag_model" );
		$this->load->model ( "topic_model" );
	}
    function set(){
    	file_get_contents(url("rss/list"));
    	echo SITE_URL."question.xml--生成成功<br>";
    	file_get_contents(url("rss/tag"));
    	echo SITE_URL."tag.xml--生成成功<br>";
    	file_get_contents(url("rss/userspace"));
    	echo SITE_URL."user.xml--生成成功<br>";
    	file_get_contents(url("rss/articlelist"));
    	echo SITE_URL."article.xml--生成成功<br><br>";
    	echo "全部xml生成成功";
    	exit();
    }
	/*
	分类下的RSS
	rss/category/1/1
    */
	function category() {

		$cid = null !== $this->uri->segment ( 3 ) ? intval ( $this->uri->segment ( 3 ) ) : 'all';
		$status = null !== $this->uri->segment ( 4 ) ? $this->uri->segment ( 4 ) : 'all';
		$category = $this->category_model->get ( $cid ); //得到分类信息
		$cfield = 'cid' . $category ['grade']; //查询条件
		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( $cfield, $cid, $status, 0, 20 ); //问题列表数据
		$this->writerss ( $questionlist, '分类' . $category ['name'] . $this->statusarray [$status] . '问题' );
	}
	/*
	列表下的RSS
	rss/list/1
    */
	function clist() {
		$status = null !== $this->uri->segment ( 3 ) ? $this->uri->segment ( 3 ) : 'all';
		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( '', 0, $status, 0, SHOWNUM ); //问题列表数据
		$this->writerss2 ( $questionlist, $this->statusarray [$status] . '问题' );
	}
	/*
	列表下的RSS
	rss/articlelist/1
    */
	function articlelist() {

		$topiclist = $this->topic_model->get_list ( 2, 0, SHOWNUM ); //文章列表数据
		$this->writerssarticle ( $topiclist, '最新文章资讯' );

	}
	//tag标签
	function tag() {

		$taglist = $this->tag_model->getalltaglist ( 0, SHOWNUM );
		
		$this->writetag ( $taglist, '站内标签' );
	}
	//用户
	function userspace() {

		$userlist = $this->user_model->get_active_list ( 0, SHOWNUM );
		$this->wirteuser ( $userlist, '用户空间' );
	}

	/*
	查看一个未解决问题的RSS
	rss/question/1
    */
	function question() {
		$qid = $this->uri->segment ( 3 );
		$question = $this->question_model->get ( $qid );
		$question ['category_name'] = $this->category [$question ['cid']];
		$answerlistarray = $this->answer_model->list_by_qid ( $qid );
		$answerlist = $answerlistarray [0];
		$items = array ();
		foreach ( $answerlist as $answer ) {
			$item ['id'] = $answer ['qid'];
			$item ['title'] = $question ['title'];
			$item ['description'] = $answer ['content'];
			$item ['category_name'] = $question ['category_name'];
			$item ['author'] = $answer ['author'];
			$item ['time'] = $answer ['time'];
			$items [] = $item;
		}
		$this->writerss ( $items, $question ['title'] . '所有回答' );
	}

	function writerss($items, $title) {

		header ( "Content-type: application/xml" );
		$suffix = '?';
		if ($this->setting ['seo_on']) {
			$suffix = '';
		}
		ob_start ();
		$fix = $this->setting ['seo_suffix'];
		echo "<?xml version=\"1.0\" encoding=\"" . 'UTF-8' . "\"?>\n" . "<rss version=\"2.0\">\n" . "  <channel>\n" . "    <title>" . $this->setting ['site_name'] . "</title>\n" . "    <link>" . SITE_URL . "</link>\n" . "    <description>" . $title . "</description>\n" . "    <copyright>Copyright(C) " . $this->setting ['site_name'] . "</copyright>\n" .

		"    <lastBuildDate>" . gmdate ( 'r', time() ) . "</lastBuildDate>\n" . "    <ttl>" . $this->setting ['rss_ttl'] . "</ttl>\n" . "    <image>\n" . "      <url>" . SITE_URL . "/css/default/logo.png</url>\n" . "      <title>" . $this->setting ['site_name'] . "</title>\n" . "      <link>" . SITE_URL . "</link>\n" . "    </image>\n";

		foreach ( $items as $item ) {
			if (! isset ( $item ['describtion'] )) {
				$item ['describtion'] = '';
			}
			$item ['description'] = strip_tags ( str_replace ( '&nbsp;', '', $item ['describtion'] ) );
			$item ['title'] = strip_tags ( str_replace ( '。', ',', $item ['title'] ) );
			echo "    <item>\n" . "      <title>" . htmlspecialchars ( $item ['title'] ) . "</title>\n" . "      <link>" . SITE_URL . $suffix . "q-$item[id]$fix</link>\n" . "      <description><![CDATA[$item[description]]]></description>\n" . "      <category>" . htmlspecialchars ( $item ['category_name'] ) . "</category>\n" . "      <author>" . htmlspecialchars ( $item ['author'] ) . "</author>\n" . "      <pubDate>" .date("Y-m-d H:i",$item ['time']) . "</pubDate>\n" . "    </item>\n";
		}

		echo "  </channel>\n" . "</rss>";


		
		$content = ob_get_contents (); //取得php页面输出的全部内容
		$fp = fopen ( FCPATH."catgory.xml", "w" );
		fwrite ( $fp, $content );
		fclose ( $fp );
	}
	function utf8_for_xml($string) {
		return preg_replace ( '/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string );
	}
	function wirteuser($items, $title) {
		header ( "Content-type: application/xml" );
		$suffix = '?';
		if ($this->setting ['seo_on']) {
			$suffix = '';
		}
		$fix = $this->setting ['seo_suffix'];
		ob_start ();
		
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" . "<urlset ".'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" '.'xmlns:mobile="http://www.baidu.com/schemas/sitemap-mobile/1/"'.">\n";
		
		foreach ( $items as $item ) {
			
			$item['time']=tdate($item['lastlogin']);
			$mpurl = url('user/space/' . $item ['uid']);
			echo " <url>" . "  <loc>" . $mpurl . "</loc>\n" .'<mobile:mobile type="'."htmladapt".'"/>'. " <lastmod>" . $item ['time'] . "</lastmod>\n" . " <changefreq>daily</changefreq>\n<priority>0.8</priority>\n" . " </url>\n";
		}
		echo "</urlset>\n";
		
		
		$content = ob_get_contents (); //取得php页面输出的全部内容
		$fp = fopen ( FCPATH."user.xml", "w" );
		fwrite ( $fp, $content );
		fclose ( $fp );
	}
	function writetag($items, $title) {
		header ( "Content-type: application/xml" );
		$suffix = '?';
		if ($this->setting ['seo_on']) {
			$suffix = '';
		}
		$fix = $this->setting ['seo_suffix'];
		ob_start ();
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" . "<urlset ".'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" '.'xmlns:mobile="http://www.baidu.com/schemas/sitemap-mobile/1/"'.">\n";
		
		foreach ( $items as $item ) {

			$item['time']=tdate($item['time']);
			$mpurl = url('tags/view/' . $item ['tagalias']);
			echo " <url>" . "  <loc>" . $mpurl . "</loc>\n" .'<mobile:mobile type="'."htmladapt".'"/>'. " <lastmod>" . $item ['time'] . "</lastmod>\n" . " <changefreq>daily</changefreq>\n<priority>0.8</priority>\n" . " </url>\n";
		}
		echo "</urlset>\n";
		
		$content = ob_get_contents (); //取得php页面输出的全部内容
		$fp = fopen ( FCPATH."tag.xml", "w" );
		fwrite ( $fp, $content );
		fclose ( $fp );
	}

	function writerss2($items, $title) {
		header ( "Content-type: application/xml" );
		$suffix = '?';
		if ($this->setting ['seo_on']) {
			$suffix = '';
		}
		$fix = $this->setting ['seo_suffix'];
		ob_start ();
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" . "<urlset ".'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" '.'xmlns:mobile="http://www.baidu.com/schemas/sitemap-mobile/1/"'.">\n";

		foreach ( $items as $item ) {
			if (! isset ( $item ['describtion'] )) {
				$item ['describtion'] = '';
			}
			$item ['description'] = strip_tags ( str_replace ( '&nbsp;', '', isset ( $item ['describtion'] ) ? $item ['describtion'] : '' ) );
			$item ['title'] = strip_tags ( str_replace ( '。', ',', $item ['title'] ) );

			$item ['title'] = $this->utf8_for_xml ( isset ( $item ['title'] ) ? $item ['title'] : '' );
			$item ['author'] = str_replace ( '&nbsp;', '', $item ['author'] );
			$viewurl = urlmap ( 'question/view/' . $item ['id'], 2 );
			$mpurl = SITE_URL . $this->setting ['seo_prefix'] . $viewurl . $this->setting ['seo_suffix'];
			echo " <url>" . "  <loc>" . $mpurl . "</loc>\n" .'<mobile:mobile type="htmladapt"/>'. "  <lastmod>" . @gmdate ( 'Y-n-j H:i', $item ['time'] ) . "</lastmod>\n" . " <changefreq>daily</changefreq>\n" . "  <priority>1.0</priority>\n"  . " </url>\n";
		}
		echo "</urlset>\n";
		$content = ob_get_contents (); //取得php页面输出的全部内容
		$fp = fopen ( FCPATH."question.xml", "w" );
		fwrite ( $fp, $content );
		fclose ( $fp );
	}

	function writerssarticle($items, $title) {
		header ( "Content-type: application/xml" );
		$suffix = '?';
		if ($this->setting ['seo_on']) {
			$suffix = '';
		}
		$fix = $this->setting ['seo_suffix'];
		ob_start ();
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" . "<urlset ".'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" '.'xmlns:mobile="http://www.baidu.com/schemas/sitemap-mobile/1/"'.">\n";
		
		foreach ( $items as $item ) {

			$viewurl = url ( 'topic/getone/' . $item ['id'] );

			// $item['viewtime']=tdate($item['viewtime']);
			
			echo " <url>" . "  <loc>" . $viewurl . "</loc>\n".'<mobile:mobile type="htmladapt"/>' . "  <lastmod>" . $item ['viewtime'] . "</lastmod>\n" . " <changefreq>daily</changefreq>\n" . "  <priority>1.0</priority>\n" . " </url>\n";
		}
		echo "</urlset>\n";
		$content = ob_get_contents (); //取得php页面输出的全部内容
		$fp = fopen ( FCPATH."article.xml", "w" );
		fwrite ( $fp, $content );
		fclose ( $fp );
	}
}
?>