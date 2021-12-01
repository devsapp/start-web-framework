<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Interfacequestion extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "getnewquestion";
		parent::__construct ();
		$this->load->model ( 'category_model' );
		$this->load->model ( 'question_model' );
	}
	// 获取最新问题
	function getnewquestion() {
		@$page = max ( 1, intval ( $_POST ['datapage'] ) );
		$pagesize = $this->setting ['list_indexnosolve'];
		$startindex = ($page - 1) * $pagesize; // 每页面显示$pagesize条
		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( '', 0, 'all', $startindex, $pagesize );
		// 渲染数据
		$str = '';
		foreach ( $questionlist as $question ) {
			$avatar = '';
			$author = '';
			$questiondescription = clearhtml ( $question ['description'],50 );
			$jiav='';
			$url=url("question/view/".$question['id']);
			if ($question['author_has_vertify']!=false){
				$jiav='<i class="fa fa-vimeo ';
				if ($question['author_has_vertify'][0]=='0'){
					$jiav.='v_person'; 
				}else{
               $jiav.='v_company';
}
$jiav.='" data-toggle="tooltip" data-placement="right" title=""></i>';
				
			}
			
			if ($question ['hidden'] == 1) {
				$avatar = SITE_URL . 'static/css/default/avatar.gif';
				$author = '匿名用户';
			} else {
				$avatar = $question ['avatar'];
				$author = $question ['author'];
			}
			$imgsrc = '';
			if (count ( $question ['images'] [1] ) > 0) {
			
				$imgsrc .= '<div class="weui-flex">';
				if (count ( $question ['images'] [1] ) > 1) {
					$index=0;
					
					foreach ( $question ['images'] [1] as $img ) {
						if($index<=2){
						$imgsrc .= '
      <div class="weui-flex__item"><div class="imgthumbsmall"><img src="' . $img . '"></div></div>
    
 ';
						}
						$index++;
					}
				} else {
					if ( count ( $question ['images'] [1] ) <= 1) {
						foreach ( $question ['images'] [1] as $img ) {
							$imgsrc .= '
      <div class="weui-flex__item"><div class="imgthumbbig"><a href="'.$url.'"><img src="' . $img . '"></a></div></div>
      		
 ';
						}
					}
				}
				$imgsrc .= ' </div>';
			}
			$str .= '<div class="qlist">
<div class="title weui-flex">
    <div>
            <img src="' . $avatar . '">
            </div>
    <div class="weui-flex__item">
                 <span class="author">' . $author .$jiav. ' </span>
                </div>

</div>
    <p class="qtitle"><a href="'.$url.'">' . $question ['title'] . '</a></p>
   
' . $imgsrc . '
 <p class="description"><a href="'.$url.'">

 ' . $questiondescription . '
</a></p>
    <p class="meta">
       <span>
          <i class="icon_huida"></i>' . $question ['answers'] . '  </span>
        <span>
           <i class="icon_liulan"></i> ' . $question ['views'] . '      </span>
     <span class="fr_gengduo" onclick="shownoview(this)">
           <i class="icon_more"></i> 
       </span>
       <div class="noview hideel" dataid="' . $question ['id'] . '" onclick="hidecontent(this)">
       不感兴趣
       </div>
    </p>
</div>';
		}
		if ($str == '') {
			echo '0';
		} else {
			echo $str;
		}
		
		exit ();
	}
}