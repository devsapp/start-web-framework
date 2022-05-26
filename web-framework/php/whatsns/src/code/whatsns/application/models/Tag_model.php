<?php
class Tag_model extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	function get_by_qid($qid) {
		$qid=intval($qid);
		$taglist = array ();
		$query = $this->db->query ( "select at.id,at.tagname,at.tagalias from " . $this->db->dbprefix . "tag as at," . $this->db->dbprefix . "tag_item as ati where ati.tagid=at.id and ati.typeid=$qid and ati.itemtype='question'  LIMIT 0,10" );
		foreach ( $query->result_array () as $tag ) {
			$taglist [] = $tag;
		}
		return $taglist;
	}
	function get_by_tagalias($tagalias) {
		$tagalias=addslashes($tagalias);
		$query = $this->db->get_where ( 'tag', array (
				'tagalias' => $tagalias
		) );
		$tag = $query->row_array ();
		
		
		return $tag;
	}
	function get_by_tagname($tagname) {
		$tagname=addslashes($tagname);
	
		$query = $this->db->get_where ( 'tag', array (
				'tagname' => $tagname
		) );
		$tag = $query->row_array ();
		return $tag;
	}
	/**
	
	* 获取站内全部标签
	
	* @date: 2018年11月7日 下午3:21:13
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function getalltaglist( $start, $limit,$where=''){
		$mlist = array ();
		$query = $this->db->query ( "SELECT  * FROM `" . $this->db->dbprefix . "tag` where 1=1 $where ORDER BY id DESC LIMIT $start,$limit" );
		foreach ( $query->result_array () as $tag ) {
			$mlist[]=$tag;
		}
		return $mlist;
	}
	/**
	
	* 热门标签列表
	
	* @date: 2018年11月7日 下午10:09:46
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function gethotalltaglist( $start, $limit){
		$mlist = array ();
		$query = $this->db->query ( "SELECT  * FROM `" . $this->db->dbprefix . "tag`  ORDER BY tagquestions DESC LIMIT $start,$limit" );
		foreach ( $query->result_array () as $tag ) {
			$mlist[]=$tag;
		}
		return $mlist;
	}
	/**
	 *
	 * 获取标签id下的相关文章和问题
	 *
	 * @date: 2018年11月7日 下午2:27:34
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function getlistbytagid($tagid, $start, $limit, $type = 'all') {
		$mlist = array ();
		$where = '';
		if ($type == 'question') {
			$where = " and itemtype='question' ";
		}
		if ($type == 'article') {
			$where = " and itemtype='article' ";
		}
		$query = $this->db->query ( "SELECT distinct typeid,itemtype,time,cid FROM `" . $this->db->dbprefix . "tag_item` WHERE tagid in ($tagid) $where ORDER BY time DESC LIMIT $start,$limit" );

		foreach ( $query->result_array () as $tag ) {
			if ($tag ['itemtype'] == 'question') {
				
				$question = $this->getquestionbyqid ( $tag ['typeid'] );
				$tag ['title'] = $question ['title'];
				$tag['image']=getfirstimg(htmlspecialchars_decode($question['description']));
				$tag['miaosu']=clearhtml(htmlspecialchars_decode($question['description']));
				$tag ['author'] = $question ['author'];
				$tag ['authorid'] = $question ['authorid'];
				$tag ['avatar'] = get_avatar_dir ( $question ['authorid'] );
				$tag ['nums'] = $question ['answers'];
				$tag ['typename'] = "回答";
				$tag ['typekey'] = "问答";
				$tag ['questionid'] = $question ['id'];
				$tag ['answers'] = $question ['answers'];
				$tag ['views'] = $question ['views']; 
				$tag ['attentions'] = $question ['attentions'];
				$tag ['addtime'] = tdate ( $question ['time'] );
				$tag ['url'] = url ( 'question/view/' . $question ['id'] );
				$tag ['taglist'] = $this->gettaglistbytypeid ( $tag ['typeid'], $tag ['itemtype'] );
			}
			if ($tag ['itemtype'] == 'article') {
				$article = $this->gettopic ( $tag ['typeid'] );
				$tag ['title'] = $article ['title'];
				$tag['image']=getfirstimg(htmlspecialchars_decode($article['describtion']));
				$tag['miaosu']=clearhtml(htmlspecialchars_decode($article['describtion']));
				$tag ['author'] = $article ['author'];
				$tag ['authorid'] = $article ['authorid'];
				$tag ['avatar'] = get_avatar_dir ( $article['authorid'] );
				$tag ['nums'] = $article ['articles'];
				$tag ['addtime'] = tdate ( $article ['viewtime'] );
				$tag ['typename'] = "评论";
				$tag ['typekey'] = "文章";
				$tag ['articleid'] = $article ['id'];
				$tag ['articles'] = $article ['articles'];
				$tag ['views'] = $article ['views'];
				$tag ['url'] = url ( 'topic/getone/' . $article ['id'] );
				$tag ['taglist'] = $this->gettaglistbytypeid ( $tag ['typeid'], $tag ['itemtype'] );
			}
			if($tag['authorid']){
				$mlist [] = $tag;
			}
			
		}
		return $mlist;
	}
	function gettopic($id) {
		$id = intval ( $id );
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic WHERE id='$id'" );
		$topic = $query->row_array ();
		return $topic;
	}
	function getquestionbyqid($id) {
		$id = intval ( $id );
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "question WHERE id='$id'" );
		$question = $query->row_array ();
		return $question;
	}
	/**
	
	* 根据类型id和类型获取标签列表用途描述
	
	* @date: 2018年11月7日 下午8:41:56
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function gettaglistbytypeid($qid, $itemtype) {
		$taglist = array ();
		$query = $this->db->query ( "select at.id,at.tagname,at.tagalias from " . $this->db->dbprefix . "tag as at," . $this->db->dbprefix . "tag_item as ati where ati.tagid=at.id and ati.typeid=$qid and ati.itemtype='$itemtype'  LIMIT 0,5" );
		foreach ( $query->result_array () as $tag ) {
			$taglist [] = $tag;
		}
		return $taglist;
	}
	/**
	 *
	 * 获取分类id下相关标签
	 *
	 * @date: 2018年11月7日 下午2:30:39
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function gettaglistbycid($cid, $start = 0, $limit = 11) {
		$cid=intval($cid);
		$taglist = array ();
		
		$query = $this->db->query ( "select distinct at.id,at.tagname,at.tagalias,at.tagquestions from " . $this->db->dbprefix . "tag as at," . $this->db->dbprefix . "tag_item as ati where ati.tagid=at.id and ati.cid=$cid order by at.tagquestions desc  LIMIT $start,$limit" );
	
		foreach ( $query->result_array () as $tag ) {
			$taglist [] = $tag;
		}
		return $taglist;
	}
	function list_by_name($name) {
		return $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "question_tag` WHERE name='$name'" )->row_array ();
	}
	function getname_by_pinyin($pinyin) {
		$tag = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "question_tag` WHERE pinyin='$pinyin'" )->row_array ();
		
		return $tag ['name'];
	}
	function list_by_countname($name) {
		$name=addslashes($name);
		return $this->db->query ( "SELECT count(*) as sum FROM `" . $this->db->dbprefix . "question_tag` WHERE name='$name'" )->row_array ();
	}
	function list_by_tagname($tagname, $start = 0, $limit = 100) {
		$tagname=addslashes($tagname);
		$taglist = array ();
		$query = $this->db->query ( "SELECT  distinct name ,qid FROM `" . $this->db->dbprefix . "question_tag` WHERE name like '%$tagname%'  ORDER BY qid DESC LIMIT $start,$limit" );
		foreach ( $query->result_array () as $tag ) {
			$tag ['count'] = $this->list_by_countname ( $tag ['name'] );
			$taglist [] = $tag;
		}
		return $taglist;
	}
	function gettalistbytagname($tagname,$start = 0, $limit = 10){
		$tagname=addslashes($tagname);
		$mlist = array ();
		$query=$this->db->select(array('tagname','tagalias','id'))->order_by("tagname asc")->like("tagname",$tagname)->or_like('tagalias',$tagname)->limit($limit,$start)->get('tag');

	
		foreach ( $query->result_array () as $tag ) {
			$tag['url']=url('tags/view/'.$tag['tagalias']);
			$mlist[]=$tag;
		}
		return $mlist;
	}
	function get_list($start = 0, $limit = 100) {
		$taglist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "question_tag ORDER BY qid DESC LIMIT $start,$limit" );
		foreach ( $query->result_array () as $tag ) {
			$tag ['time'] = tdate ( $tag ['time'] );
			$taglist [] = $tag;
		}
		return $taglist;
	}
	function rownum() {
		$m = $this->db->query ( "SELECT count(name) as num FROM " . $this->db->dbprefix . "question_tag GROUP BY name" )->row_array ();
		return $m ['num'];
	}
	function getquestion($id) {
		$id=intval($id);
		$question = $this->db->query ( "SELECT id,title,cid,authorid FROM " . $this->db->dbprefix . "question WHERE id='$id'" )->row_array ();
		if ($question) {
			
		}
	}
	function multi_add($namelist, $qid) {
		if (empty ( $namelist ))
			return false;
		//获取问题
			$question=$this->getquestion($qid);
			$existdatas=array();
	  foreach ( $namelist as $name ) {
	  	$name=preg_replace ( '# #', '', $name ); 
			//通过标签名称查询标签是否存在
			$tagbyname=$this->get_by_tagname($name);
			if($tagbyname){
				//存在就获取tagid
				$tagid=$tagbyname['id'];
				$cid=$question['cid'];
				$authorid=$question['authorid'];
				//插入标签文章表
				$data=array(
						'tagid' => $tagid,
						'typeid' => $qid ,
						'cid' =>$cid,
						'itemtype'=>'question',
						'time'=>time(),
						'uid'=>$authorid
				);
				array_push($existdatas, $data);
			}else{
				$tagname=$name;
				$tagalias=$this->getPinyin($tagname);
				//判断别名是否存在
				$tagbyalias=$this->get_by_tagalias($tagalias);
				
				if($tagbyalias){
					$tagalias=$tagbyalias['tagalias'].time();
				}
			
				// 标签首字母
				$tagfisrtchar = strtoupper ( preg_replace ( '# #', '', $this->getfirstchar ( $tagname ) ) ); // 标签首字母
				
				$tagalias=preg_replace ( '# #', '', $tagalias ); 
				$data=array('tagfisrtchar'=>$tagfisrtchar,'time'=>time(),'tagname'=>$tagname,'tagalias'=>$tagalias,'title'=>$tagname,'keywords'=>$tagname);
				$this->db->insert ( 'tag', $data );
				$tagid = $this->db->insert_id ();
		
				$cid=$question['cid'];
				$authorid=$question['authorid'];
				//插入标签文章表
				$data=array(
						'tagid' => $tagid,
						'typeid' => $qid ,
						'cid' =>$cid,
						'itemtype'=>'question',
						'time'=>time(),
						'uid'=>$authorid
				);
				
				array_push($existdatas, $data);
				
			}
		}
		if(count($existdatas)>0){
			
			$this->db->insert_batch('tag_item', $existdatas);
		}
		//$this->db->query ( substr ( $insertsql, 0, - 1 ) );
	}
	function multi_addquestion($namelist, $qid,$cid,$uid) {
		if (empty ( $namelist ))
			return false;
			$this->db->query ( "DELETE FROM " . $this->db->dbprefix . "tag_item WHERE `typeid`=$qid and itemtype='question' " );
			$datas=array();
			foreach ( $namelist as $name ) {
				//htmlspecialchars ( $name ) 
				$data=array(
						'tagid' => $name,
						'typeid' => $qid ,
						'cid' =>$cid,
						'itemtype'=>'question',
						'time'=>time(),
						'uid'=>$uid
				);
				array_push($datas, $data);
			}
	
			
			$this->db->insert_batch('tag_item', $datas);
		
	}
	function multi_addarticle($namelist, $aid,$cid,$uid) {
		if (empty ( $namelist ))
			return false;
			$this->db->query ( "DELETE FROM " . $this->db->dbprefix . "tag_item WHERE `typeid`=$aid and itemtype='article' " );
			$datas=array();
			foreach ( $namelist as $name ) {
	
				//htmlspecialchars ( $name )
				$data=array(
						'tagid' => $name,
						'typeid' => $aid ,
						'cid' =>$cid,
						'itemtype'=>'article',
						'time'=>time(),
						'uid'=>$uid
				);
				array_push($datas, $data);
			}
			
			
			$this->db->insert_batch('tag_item', $datas);
			
	}
	function remove_by_name($names) {

		$this -> db ->where_in('name',$names)->delete('question_tag');
	
	}
	/**
	
	* 根据标签id删除标签
	
	* @date: 2018年11月7日 下午4:20:45
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function remove_by_id($ids) {
		
	
		$this -> db ->where_in('id',$ids)->delete('tag');
	    //删除标签相关问题
		$this -> db ->where_in('tagid',$ids)->delete('tag_item');
	
		
	}
	function addtag($tagname,$tagalias,$title,$description,$keywords,$tagimage){
		$data=array('time'=>time(),'tagfisrtchar'=>$this->getfirstchar($tagalias),'tagimage'=>$tagimage,'tagname'=>$tagname,'tagalias'=>$tagalias,'title'=>$title,'keywords'=>$keywords,'description'=>$description);
		$this->db->insert ( 'tag', $data );
		$id = $this->db->insert_id ();
		return $id;
	}
	function updatetag($tagid,$tagname,$tagalias,$title,$description,$keywords,$tagimage){
		$data=array('time'=>time(),'tagfisrtchar'=>$this->getfirstchar($tagalias),'tagimage'=>$tagimage,'tagname'=>$tagname,'tagalias'=>$tagalias,'title'=>$title,'keywords'=>$keywords,'description'=>$description);
		$this->db->where ( 'id', $tagid );
		$this->db->update ( 'tag', $data );
		
	}
	function getfirstchar($s0) {
		$firstchar_ord = ord ( strtoupper ( $s0 {0} ) );
		if (($firstchar_ord >= 65 and $firstchar_ord <= 91) or ($firstchar_ord >= 48 and $firstchar_ord <= 57))
			return $s0 {0};
			$s = iconv ( "UTF-8", "gb2312", $s0 );
			$asc = ord ( $s {0} ) * 256 + ord ( $s {1} ) - 65536;
			if ($asc >= - 20319 and $asc <= - 20284)
				return "a";
				if ($asc >= - 20283 and $asc <= - 19776)
					return "b";
					if ($asc >= - 19775 and $asc <= - 19219)
						return "c";
						if ($asc >= - 19218 and $asc <= - 18711)
							return "d";
							if ($asc >= - 18710 and $asc <= - 18527)
								return "e";
								if ($asc >= - 18526 and $asc <= - 18240)
									return "f";
									if ($asc >= - 18239 and $asc <= - 17923)
										return "g";
										if ($asc >= - 17922 and $asc <= - 17418)
											return "h";
											if ($asc >= - 17417 and $asc <= - 16475)
												return "j";
												if ($asc >= - 16474 and $asc <= - 16213)
													return "k";
													if ($asc >= - 16212 and $asc <= - 15641)
														return "l";
														if ($asc >= - 15640 and $asc <= - 15166)
															return "m";
															if ($asc >= - 15165 and $asc <= - 14923)
																return "m";
																if ($asc >= - 14922 and $asc <= - 14915)
																	return "o";
																	if ($asc >= - 14914 and $asc <= - 14631)
																		return "p";
																		if ($asc >= - 14630 and $asc <= - 14150)
																			return "q";
																			if ($asc >= - 14149 and $asc <= - 14091)
																				return "r";
																				if ($asc >= - 14090 and $asc <= - 13319)
																					return "s";
																					if ($asc >= - 13318 and $asc <= - 12839)
																						return "t";
																						if ($asc >= - 12838 and $asc <= - 12557)
																							return "w";
																							if ($asc >= - 12556 and $asc <= - 11848)
																								return "x";
																								if ($asc >= - 11847 and $asc <= - 11056)
																									return "y";
																									if ($asc >= - 11055 and $asc <= - 10247)
																										return "z";
																										return null;
	}
	private $_outEncoding = "GB2312";
	public function getPinyin($str, $pix = ' ', $code = 'gb2312') {
		$_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha" . "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|" . "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er" . "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui" . "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang" . "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang" . "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue" . "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne" . "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen" . "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang" . "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|" . "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|" . "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu" . "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you" . "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|" . "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";
		$_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990" . "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725" . "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263" . "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003" . "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697" . "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211" . "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922" . "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468" . "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664" . "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407" . "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959" . "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652" . "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369" . "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128" . "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914" . "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645" . "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149" . "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087" . "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658" . "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340" . "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888" . "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585" . "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847" . "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055" . "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780" . "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274" . "|-10270|-10262|-10260|-10256|-10254";
		$_TDataKey = explode ( '|', $_DataKey );
		$_TDataValue = explode ( '|', $_DataValue );
		$data = (PHP_VERSION >= '5.0') ? array_combine ( $_TDataKey, $_TDataValue ) : $this->_Array_Combine ( $_TDataKey, $_TDataValue );
		arsort ( $data );
		reset ( $data );
		$str = $this->safe_encoding ( $str );
		$_Res = '';
		for($i = 0; $i < strlen ( $str ); $i ++) {
			$_P = ord ( substr ( $str, $i, 1 ) );
			if ($_P > 160) {
				$_Q = ord ( substr ( $str, ++ $i, 1 ) );
				$_P = $_P * 256 + $_Q - 65536;
			}
			$_Res .= $this->_Pinyin ( $_P, $data ) . $pix;
		}
		return preg_replace ( "/[^a-z0-9" . $pix . "]*/", '', $_Res );
	}
	private function _Pinyin($_Num, $_Data) {
		if ($_Num > 0 && $_Num < 160)
			return chr ( $_Num );
			elseif ($_Num < - 20319 || $_Num > - 10247)
			return '';
			else {
				foreach ( $_Data as $k => $v ) {
					if ($v <= $_Num)
						break;
				}
				return $k;
			}
	}
	function safe_encoding($string) {
		$encoding = "UTF-8";
		for($i = 0; $i < strlen ( $string ); $i ++) {
			if (ord ( $string {$i} ) < 128)
				continue;
				if ((ord ( $string {$i} ) & 224) == 224) { // 第一个字节判断通过
					$char = $string {++ $i};
					if ((ord ( $char ) & 128) == 128) { // 第二个字节判断通过
						$char = $string {++ $i};
						if ((ord ( $char ) & 128) == 128) {
							$encoding = "UTF-8";
							break;
						}
					}
				}
				if ((ord ( $string {$i} ) & 192) == 192) { // 第一个字节判断通过
					$char = $string {++ $i};
					if ((ord ( $char ) & 128) == 128) { // 第二个字节判断通过
						$encoding = "GB2312";
						break;
					}
				}
		}
		if (strtoupper ( $encoding ) == strtoupper ( $this->_outEncoding ))
			return $string;
			else
				return iconv ( $encoding, $this->_outEncoding, $string );
	}
	private function _Array_Combine($_Arr1, $_Arr2) {
		for($i = 0; $i < count ( $_Arr1 ); $i ++)
			$_Res [$_Arr1 [$i]] = $_Arr2 [$i];
			return $_Res;
	}
}

?>
