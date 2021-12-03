<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Pccaiji_question extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "index,clist,selectlist,add";
		parent::__construct ();

		$this->load->model ( 'category_model' );
		$this->load->model ( 'question_model' );
		$this->load->model ( 'answer_comment_model' );
		$this->load->model ( 'answer_model' );
		$this->load->model ( 'doing_model' );
		$this->load->model ( 'user_model' );
		if ($this->setting ['xunsearch_open']) {
			require_once $this->setting ['xunsearch_sdk_file'];
			$xs = new XS ( 'question' );
			$this->search = $xs->search;
			$this->index = $xs->index;
		}
	}
	function clist() {

		$cid = intval ( $this->uri->segment ( 3 ) ) ? $this->uri->segment ( 3 ) : 'all';
		$navlist = $this->category_model->list_by_pid ( 0 ); //获取导航
		$cat_string = '';
		foreach ( $navlist as $nav ) {
			$cat_string = $cat_string . ',' . $nav ['name'] . '|' . $nav ['id'];
		}
		echo $cat_string;

	}
	function add() {
		$code = $this->setting ['hct_logincode'] != null ? $this->setting ['hct_logincode'] : rand ( 111111, 9999999 );
		if ($this->input->post ( 'title' ) != null) {

			$question = $this->question_model->get_by_title ( $this->input->post ( 'title' ) );

			$cid = $this->input->post ( 'classid' );
			$title = $this->input->post ( 'title' ); //问题标题
			$content = $_POST ['miaosu']; //问题描述
			$author = $this->input->post ( 'author' ); //问题作者
			$answercontent = $_POST ['answercontent']; //回答内容
			$guanjianci = $_POST['guanjianci']; //关键词-new
			$splitname = $_POST ['splitname']; //回答分隔符


			if ($splitname == '') {
				echo "分隔字符串不能为空";
				exit ();
			}

			$answercontentarr = array ();
			if ($answercontent != '') {
				$answercontentarr = explode ( $splitname, $answercontent );
			}

            $guanjiancikey = array(); //分割关键词
            if ($guanjianci != '') {
				//如果存在多个关键词就拆分
				if(strpos($guanjianci,$splitname)!== false){
					$guanjiancikey = explode($splitname, $guanjianci);
				}else{
					//如果只有一个关键词就插入数组
					array_push($guanjiancikey,$guanjianci);
				}
                
            }
			
			if ($code != $this->input->post ( 'questionvalue' )) {
				echo '没有发布权限!';
				exit ();
			}

			if ($question != null) {
				echo '问题已存在，发布时间为' . date ( 'Y-m-d', $question ['time'] );
				exit ();
			} else {
				//将数据插入问题表
				$userlist = $this->user_model->get_caiji_list ( 0, 100 );
				if (count ( $userlist ) <= 0) {

					echo '没有可用的马甲用户，先去用户管理设置马甲';
					exit ();
				}
				$user = $this->user_model->get_by_username ( $author );

				if (! $user) {
					$hduid = $this->user_model->caijiadd ( $author, '123456', rand ( 1111111, 99999999 ) . "@qq.com" );
					$q_uid = intval ( $hduid );
					$q_username = $author;
				} else {
					$q_uid = $user ['uid'];
					$q_username = $user ['username'];
				}
				if ($author == '') {
					$mwtuid = array_rand ( $userlist, 1 );
					$q_uid = $userlist [$mwtuid] ['uid'];
					$q_username = $userlist [$mwtuid] ['username'];
				}
				$randnum = rand ( 30, 70 );//随机30-70分钟前发布问题
				$qtime = strtotime ( "-$randnum minute" );

				$views = rand ( 300, 2000 );
				$cat = $this->category_model->get ( $cid );
				switch ($cat ['grade']) {
					case 1 :
						$cid1 = $cid; //顶级分类
						$cid2 = 0;
						$cid3 = 0;
						break;
					case 2 :
						$cid2 = $cid;
						//查找父亲级的分类
						$cat1 = $this->category_model->get ( $cat ['pid'] );
						$cid1 = $cat1 ['id'];
						$cid3 = 0;
						break;
					case 3 :
						$cid3 = $cid;
						//查找父亲级的分类
						$cat2 = $this->category_model->get ( $cat ['pid'] );
						$cid2 = $cat2 ['id'];
						//查找父亲级的分类
						$cat1 = $this->category_model->get ( $cat2 ['pid'] );
						$cid1 = $cat1 ['id'];
						break;
					default :
						$cid1 = $cid;
						$cid2 = 0;
						$cid3 = 0;
						break;
				}
				$qid = $this->addquestion ( $title, $content, '', $cid, $qtime, $views, $q_uid, $q_username, $cid1, $cid2, $cid3 );
				if($qid){
					//关键词插入开始
					$guanjiancicount = count($guanjiancikey);
					if ($guanjiancicount == 1) {
						$keytime = time();
						$this->addguanjianci($qid, $guanjiancikey[0], $keytime, '',$cid,$q_uid);
						
					} elseif ($guanjiancicount > 1) {
						for ($i = 0; $i < $guanjiancicount; $i++) {
							$keytime = time();
							$this->addguanjianci($qid, $guanjiancikey[$i], $keytime, '',$cid,$q_uid);
						}
					}
					
					
					if ($qid <= 0) {
						
						echo '提交问题失败';
						exit ();
					} else {
						
						//随机多少人关注问题
						$numuser = rand ( 3, 5 );
						for($i = 0; $i <= $numuser; $i ++) {
							$auid = array_rand ( $userlist, 1 );
							$_uid = $userlist [$auid] ['uid'];
							$_username = $userlist [$auid] ['username'];
							$this->attention_question ( $qid, $_uid, $_username );
						}
						$commentarr = array ('真给力', "谢谢你", '非常感谢你', '你真是个大好人', '你真的帮了我大忙', '高手留个联系方式吧', '大神......' );
						$comment = $commentarr [array_rand ( $commentarr, 1 )];
						$answercount = count ( $answercontentarr );
						if($answercount == 1){
							$mwtuid = array_rand ( $userlist, 1 );
							$b_uid = $userlist [$mwtuid] ['uid'];
							$b_username = $userlist [$mwtuid] ['username'];
							$randnum = rand ( 3, 30 ); //随机3-30分钟前回答问题
							$qbesttime = strtotime ( "-$randnum minute" );
							$aid=$this->addanswer ( $qid, $title, $answercontentarr[0], $qbesttime, $b_uid, $b_username );
							$answer = $this->answer_model->get ( $aid );
							$ret = $this->answer_model->adopt ( $qid, $answer );
							if ($ret) {
								$this->answer_comment_model->add ( $aid, $comment, $b_uid, $b_username );
								$this->doing_model->add ( $b_uid, $b_username, 8, $qid, $comment, $aid, $hduid, $title );
							}
							
							echo '发布成功';
							exit ();
						}elseif ($answercount > 1) {
							$aid=0;
							for($i = 0; $i < $answercount; $i ++) {
								$mwtuid = array_rand ( $userlist, 1 );
								$b_uid = $userlist [$mwtuid] ['uid'];
								$b_username = $userlist [$mwtuid] ['username'];
								$randnum = rand ( 3, 30 ); //随机3-30分钟前回答问题
								$qbesttime = strtotime ( "-$randnum minute" );
								$aid=$this->addanswer ( $qid, $title, $answercontentarr[$i], $qbesttime, $b_uid, $b_username );
							}
							$answer = $this->answer_model->get ( $aid );
							if($answer){
								$ret = $this->answer_model->adopt ( $qid, $answer );
								if ($ret) {
									$this->answer_comment_model->add ( $aid, $comment, $b_uid, $b_username );
									$this->doing_model->add ( $b_uid, $b_username, 8, $qid, $comment, $aid, $hduid, $title );
								}
							}
							
							echo '发布成功';
							exit ();
						} else {
							echo '发布成功,没有回答';
							exit ();
						}
					}
				}else{
					echo '发布失败，问题插入失败了';
					exit ();
				}
               
             
			}
		}
	}
	//关注问题
	function attention_question($qid, $user_uid, $user_username) {
		$uid = $user_uid;
		$username = $user_username;
		$is_followed = $this->question_model->is_followed ( $qid, $uid );
		if ($is_followed) {
			$this->user_model->unfollow ( $qid, $uid );
		} else {
			$this->user_model->follow ( $qid, $uid, $username );
		}
	}
	function rand_time($a, $b) {
		$a = strtotime ( $a );
		$b = strtotime ( $b );
		return date ( "Y-m-d H:m:s", mt_rand ( $a, $b ) );
	}
	function selectlist() {
		echo ("<select>");
		$cid = intval ( $this->uri->segment ( 3 ) ) ? $this->uri->segment ( 3 ) : 'all';
		$navlist = $this->category_model->list_by_grade (); //获取导航
		$cat_string = '';
		foreach ( $navlist as $nav ) {

			echo "<option value='" . $nav ['id'] . "'>" . $nav ['name'] . "</option>";
			if ($nav ['sublist'] != null) {
				foreach ( $nav ['sublist'] as $nav1 ) {
					echo "<option value='" . $nav1 ['id'] . "'>--" . $nav1 ['name'] . "</option>";
				}
			}

		}
		echo ("</select>");

	}
	/* 插入问题到question表 */

	function addquestion($title, $description, $zuijiadaan, $cid, $qtime, $views, $uid, $username, $cid1 = 0, $cid2 = 0, $cid3 = 0, $status = 1, $shangjin = 0, $askfromuid = 0) {
		$overdue_days = intval ( $this->setting ['overdue_days'] );
		$creattime = $qtime;
		$hidanswer = 0;
		$price = 0;
		$answers = 0;
		if ($zuijiadaan != '') {
			$answers = 1;
		}
		$endtime = $this->time + $overdue_days * 86400;
        $ip=getip();
		(! strip_tags ( $description, '<img>' )) && $description = '';
		/* 分词索引 */
		$dataquestion=array('views'=>$views,'cid'=>$cid,'cid1'=>$cid1,'cid2'=>$cid2,'cid3'=>$cid3,'askuid'=>$askuid,'authorid'=>$uid,'shangjin'=>$shangjin,'author'=>$username,'title'=>$title,'description'=>$description,'price'=>$price,'time'=>$creattime,'endtime'=>$endtime,'hidden'=>$hidanswer,'status'=>$status,'ip'=>$ip);
		//$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "question SET views='$views',cid='$cid',cid1='$cid1',cid2='$cid2',cid3='$cid3',askuid='$askfromuid',authorid='$uid',shangjin='$shangjin',author='$username',title='$title',description='$description',price='$price',time='$creattime',endtime='$endtime',hidden='$hidanswer',status='$status',ip='$ip'" );
		$this->db->insert('question',$dataquestion);
		//runlog('insersql',$this->db->last_query());
		$qid = $this->db->insert_id ();
		if ($this->setting ['xunsearch_open'] && $qid) {
			$question = array ();
			$question ['id'] = $qid;
			$question ['cid'] = $cid;
			$question ['cid1'] = $cid1;
			$question ['cid2'] = $cid2;
			$question ['cid3'] = $cid3;
			$question ['author'] = $username;
			$question ['authorid'] = $uid;
			$question ['answers'] = $answers;
			$question ['price'] = $price;
			$question ['attentions'] = 1;
			$question ['shangjin'] = $shangjin;
			$question ['status'] = $status;
			$question ['time'] = $creattime;
			$question ['title'] = checkwordsglobal ( $title );
			$question ['description'] = checkwordsglobal ( $description );
			$doc = new XSDocument ();
			$doc->setFields ( $question );
			$this->index->add ( $doc );
		}
		$cid1 = intval ( $cid1 );
		$cid2 = intval ( $cid2 );
		$cid3 = intval ( $cid3 );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "category SET questions=questions+1 WHERE  id IN ($cid1,$cid2,$cid3) " );
		$uid && $this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET questions=questions+1 WHERE  uid =$uid" );
		return $qid;
	}
	/* 添加答案 */

	function addanswer($qid, $title, $content, $qbesttime, $uid, $username, $status = 1, $chakanjine = 0) {
		$content = checkwordsglobal ( $content );

		$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "answer SET qid='$qid',title='$title',author='$username',authorid='$uid',time='$qbesttime',content='$content',reward=$chakanjine,status=$status,ip='{$this->ip}'" );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "question SET  answers=answers+1   WHERE id=" . $qid );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET answers=answers+1 WHERE  uid =$uid" );
		$aid = $this->db->insert_id ();
		return $aid;
	}
	
    //添加关键词
	function addguanjianci($aid, $name, $keytime, $pinyin,$cid=0,$authorid=0) {
    	$tagalias=$this->getPinyin($name);
    	
    	$tagalias = preg_replace ( '# #', '',$tagalias ); // 标签别名
    	//查看是否存在该标签
    	$tag = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "tag` WHERE tagname='$name'" )->row_array ();
    	
    	if($tag){
    		$id=$tag['id'];
    	}else{
    		$data=array('tagfisrtchar'=>$this->getfirstchar($tagalias),'tagimage'=>'','tagname'=>$name,'tagalias'=>$tagalias,'title'=>$name,'keywords'=>$name,'description'=>'');
    		$this->db->insert ( 'tag', $data );
    		$id = $this->db->insert_id ();
    	}
    
    	$data=array(
    			'tagid' => $id,
    			'typeid' => $aid ,
    			'cid' =>$cid,
    			'itemtype'=>'question',
    			'time'=>time(),
    			'uid'=>$authorid
    	);
    	$this->db->insert ( 'tag_item', $data );
    	$tagitemid = $this->db->insert_id ();
        //$this->db->query("INSERT INTO " . $this->db->dbprefix . "question_tag SET qid='$aid',name='$name',time='$keytime',pinyin='' ");
        //$aid = $this->db->insert_id();
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