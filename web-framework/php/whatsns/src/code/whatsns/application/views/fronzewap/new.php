<!--{template header}-->
<style>

 .recommend-collection {
	margin:10px;
}

.showmore{
    line-height:40px;
    color: #0084FF;
    background: rgba(0, 132, 255, 0.1);
    border: 1px solid rgba(0, 132, 255, 0.1);
    text-align:center;
        margin-bottom: 15px;
    }
    .showmore a{
    color: #0084FF;
    }
 .recommend-collection .collection {
	display: inline-block;
	margin: 0 8px 8px 0;
	min-height: 32px;
	background-color: #f7f7f7;
	border: 1px solid #dcdcdc;
	border-radius: 4px;
	vertical-align: top;
	overflow: hidden
}

 .recommend-collection .collection img {
	width: 32px
}

 .recommend-collection .collection .name {
	display: inline-block;
	padding: 0 11px 0 6px;
	font-size: 14px
}

 .recommend-collection .more-hot-collection {
	display: inline-block;
	margin-top: 7px;
	font-size: 14px;
	color: #787878
}

 .load-more {
	width: 100%;
	background-color: #a5a5a5
}

 .load-more:hover {
	background-color: #9b9b9b
}
.c_current {
    color: red;
}

 .morecat, .moresubcat{
display:none;
}

</style>
  <!-- 三级分类获取父级分类id 赋值给  $_cid-->
                                             {if $category['grade']==3}
                                              <!-- 三级分类id -->
                                          {eval $_cid_3=$category['id'];}
                                            <!-- 二级分类id -->
                                           {eval $_cid_2=$category['pid'];}
                                           <!-- 一级分类id -->
                                            {eval $_cid_1=$this->category[$_cid_2]['pid'];}
                                           {/if} 
                                                  {if $category['grade']==2}
                                              <!-- 当前分类 -->
                                          {eval $_cid_2=$category['id'];}
                                            <!-- 一级分类id -->
                                           {eval $_cid_1=$category['pid'];}
                                       
                                           {/if}
                                           
                                                   {if $category['grade']==1}
                                              <!-- 当前分类 -->
                                          {eval $_cid_1=$category['id'];}
                                 
                                       
                                           {/if}
                                           
     <div class="row">

        <div class="col-md-24">
             <div class="row">
                 <div class="">
                     <div class="" style="padding:0px;margin:15px;">
                           <div>

                                    <div class="course-filters">
                                   <div class="row filters-wrapper filter-categorys-wrapper no-margin">
                                       <div class="filter-title-wrapper col-sm-24 col-md-4">
                                           <span class="filter-title" >
          方向：
        </span>
                                       </div>
                                       <div class="filter-item-wrapper col-md-20">
                                          <a href="{url new/default}">
                                         
                                           <span class="filter-item {if $cid=='all'||!$cid}active{/if}">
                                               全部
                                           </span>
                                           </a>
                  {eval  $catlist=$this->getlistbysql("select id,name,displayorder,grade from ".$this->db->dbprefix."category where iscourse=0 and isuseask=1 and grade=1 and pid=0 order by displayorder desc  limit 0,100");}
        {if $catlist}
                  <!--{loop $catlist $index $cat}-->
                  {if $index<15}
                                          <a href="{url new/question/$paixu/$cat['id']}"> 
                                        {if isset($pid)&&$pid!=0}
                                           <span class="filter-item {if $pid==$cat['id']}active{/if} {if $_cid_1&&$_cid_1==$cat['id']}active{/if} ">
                                        
                                           {else}
                                             <span class="filter-item {if $cid==$cat['id']}active{/if}">
                                        
                                           {/if}
           {$cat['name']}

                                           </span></a>
                                           {/if}
                                              <!--{/loop}-->
                                     <!--{loop $catlist $index $cat}-->
                                       {if $index>=15}
                                         <a class="morecat" href="{url new/question/$paixu/$cat['id']}"> 
                                        {if isset($pid)&&$pid!=0}
                                           <span class="filter-item {if $pid==$cat['id']}active{/if}">
                                        
                                           {else}
                                             <span class="filter-item {if $cid==$cat['id']}active{/if}">
                                        
                                           {/if}
           {$cat['name']}

                                           </span></a>
                                         {/if}
                                            <!--{/loop}-->       
                                                     {if count($catlist)>=15}
                  <div class="more_link showmore" style="width:90%;">
                                <a rel="nofollow">查看更多</a>
                            </div>
                      {/if}
                      
                                         {/if}
                                       </div>
                                   </div>
  <!-- 二级分类 -->
                                   <div class="row filters-wrapper filter-categorys-wrapper no-margin">
                                       <div class="filter-title-wrapper col-sm-24 col-md-4">
                                           <span class="filter-title" >
          二级分类：
        </span>
                                       </div>
                                       <div class="filter-item-wrapper col-md-20">
                                       {if isset($_cid_1)}
                                              <a href="{url new/question/$paixu/$_cid_1}">
                                         {else}
                                            <a href="{url new/default}">
                                         {/if}
                                           <span class="filter-item {if $cid==$_cid_1}active{/if} ">
                                               全部
                                           </span>
                                           </a>
                                           {if $category['grade']==3}
                                          
                                           {eval $_pid=$category['pid'];$pid=$this->category[$_pid]['pid'];}
                                           
                                           {/if}
                                           {if isset($pid)&&$pid!=0}
                                           
                                              {eval $_cid1=intval($pid); $subcatlist=$this->getlistbysql("select id,name,displayorder,grade from ".$this->db->dbprefix."category where  iscourse=0 and isuseask=1 and grade=2  and pid=$_cid1 order by displayorder desc ");}
       
                                           {else}
                                           {if isset($cid)&&$cid!='all'}
                                            {eval $_cid1=intval($cid); $subcatlist=$this->getlistbysql("select id,name,displayorder,grade from ".$this->db->dbprefix."category where  iscourse=0 and isuseask=1 and grade=2  and pid=$_cid1 order by displayorder desc ");}
       
                                           {else}
                                              {eval  $subcatlist=$this->getlistbysql("select id,name,displayorder,grade from ".$this->db->dbprefix."category where  iscourse=0 and isuseask=1 and grade=2  order by displayorder desc ");}
       
                                           {/if}
                                           
                                           
                                           {/if}
                                                         
        {if $subcatlist}

         <!--{loop $subcatlist $sindex $subcat}-->
         {if  $sindex<20}
                                   <a href="{url new/question/$paixu/$subcat['id']}">  <span class="filter-item  {if $cid==$subcat['id']}active{/if} {if $_cid_2&&$_cid_2==$subcat['id']}active{/if}">

           {$subcat['name']}

                                           </span></a>
                                           
                                           {/if}
                                             <!--{/loop}-->
                                    
                                         <!--{loop $subcatlist $sindex $subcat}-->
         {if  $sindex>=20}
                                   <a class="moresubcat" href="{url new/question/$paixu/$subcat['id']}">  <span class="filter-item  {if $cid==$subcat['id']}active{/if}">

           {$subcat['name']}

                                           </span></a>
                                           
                                           {/if}
                                             <!--{/loop}-->
                                                                                  {if count($subcatlist)>=20}
                  <div class="more_link  showmoresub" style="width:90%;">
                                <a rel="nofollow">查看更多</a>
                            </div>
                      {/if}      
                                                  {/if}
                                      
                                       </div>
                                   </div>
                                
  <!-- 三级分类 -->
   <div class="row filters-wrapper filter-categorys-wrapper no-margin">
                                       <div class="filter-title-wrapper col-sm-24 col-md-4">
                                           <span class="filter-title" >
          三级分类：
        </span>
                                       </div>
                                     
                                       <div class="filter-item-wrapper col-md-20">
                                       {if isset($_cid_2)}
                                         <a href="{url new/question/$paixu/$_cid_2}">
                                         {else}
                                            <a href="{url new/default}">
                                         {/if}
                                           <span class="filter-item {if $cid==$_cid_2||$cid==$_cid_1}active{/if}">
                                               全部
                                           </span>
                                           </a>
                                       
                                             <!-- 如果有二级分类将二级分类赋值给当前三级分类的pid-->
                                            {if $_cid_2}
                                          
                                           {eval $_cid=$_cid_2;}
                                           
                                           {/if}
                                       <!-- 如果当前选择得是二级分类，列出二级分类相关得三级分类-->
                                           {if isset($_cid)&&$_cid!='all'}
                                          
                                            {eval $_cid1=intval($_cid); $subcatlist=$this->getlistbysql("select id,name,displayorder,grade from ".$this->db->dbprefix."category where  iscourse=0 and isuseask=1 and grade=3  and pid=$_cid1 order by displayorder desc ");}
       
                                           {else}
                                           <!-- 如果当前选择得是一级分类，列出全部二级分类相关得三级分类-->
                                                       <!-- 定义存储二级分类id值，用于三级分类查询使用 -->
                                           {eval $secondclass='';}
                                           <!-- 循环二级分类数组取出分类id -->
                                          {loop $subcatlist  $subcat}
                                          {eval $secondclass.=$subcat['id'].",";}
                                          {/loop}  
                                          <!-- 清除最后一个逗号 -->  
                                          {eval $secondclass.=trim($secondclass,",");}
                                              {eval  $subcatlist=$this->getlistbysql("select id,name,displayorder,grade from ".$this->db->dbprefix."category where  iscourse=0 and isuseask=1 and grade=3 and pid in ($secondclass)  order by displayorder desc ");}
       
                                           {/if}
                                           
                                         
                                                         
        {if $subcatlist}
         <!--{loop $subcatlist $sindex $subcat}-->
         {if  $sindex<20}
                                   <a href="{url new/question/$paixu/$subcat['id']}">  <span class="filter-item  {if $category['id']==$subcat['id']}active{/if}">

           {$subcat['name']}

                                           </span></a>
                                           
                                           {/if}
                                             <!--{/loop}-->
                                    
                                         <!--{loop $subcatlist $sindex $subcat}-->
         {if  $sindex>=20}
                                   <a class="moresubcat" href="{url new/question/$paixu/$subcat['id']}">  <span class="filter-item  {if $category['id']==$subcat['id']}active{/if}">

           {$subcat['name']}

                                           </span></a>
                                           
                                           {/if}
                                             <!--{/loop}-->
                                                                                  {if count($subcatlist)>=20}
                  <div class="more_link  showmoresub" style="width:90%;">
                                <a rel="nofollow">查看更多</a>
                            </div>
                      {/if}      
                                                  {/if}
                                      
                                       </div>
                                   </div>
                                   
                               </div>
                           </div>
                         <hr>

                        



                     </div>


                 </div>
             </div>
        </div>
    </div>
                    
<!--最新问题-->
<div class="au_side_box" style="padding:7px;margin:0px;">
   {if !$cid}
         <!--导航-->
        <ul class="tab-head au_tabs">
            <li class="tab-head-item au_tab {if $paixu==0}current{/if}" data-tag="tag-nosolve"><a href="{url new/default/0}">全部</a></li>
             <li class="tab-head-item au_tab {if $paixu==5}current{/if}" data-tag="tag-solvelist"><a href="{url new/default/5}">待解决</a></li>
            <li class="tab-head-item au_tab {if $paixu==4}current{/if}" data-tag="tag-score"><a href="{url new/default/4}">已解决</a></li>
                        <li class="tab-head-item au_tab {if $paixu==1}current{/if}" data-tag="tag-score"><a href="{url new/default/1}">财富悬赏</a></li>
      
                     
        </ul>
     {else} 
     
      <!--导航-->
        <ul class="tab-head au_tabs">
            <li class="tab-head-item au_tab {if $paixu==0}current{/if}" data-tag="tag-nosolve"><a href="{url new/question/0/$cid}">全部</a></li>
             <li class="tab-head-item au_tab {if $paixu==5}current{/if}" data-tag="tag-solvelist"><a href="{url new/question/5/$cid}">待解决</a></li>
            <li class="tab-head-item au_tab {if $paixu==4}current{/if}" data-tag="tag-score"><a href="{url new/question/4/$cid}">已解决</a></li>
                        <li class="tab-head-item au_tab {if $paixu==1}current{/if}" data-tag="tag-score"><a href="{url new/question/1/$cid}">财富悬赏</a></li>
      
                     
        </ul>
          {/if}
     <div class="au_side_box_content">
         <!--列表部分-->
 
      <div class="stream-list question-stream ">
   <!--{loop $questionlist $index $question}-->
      <section class="stream-list__item">
       {if $question['status']==2}
                <div class="qa-rank"><div class="answers answered solved ml10 mr10">
                {$question['answers']}<small>解决</small></div></div>     
                {else}
                {if $question['answers']>0}
                <div class="qa-rank"><div class="answers answered ml10 mr10">
                $question['answers']<small>回答</small></div>
                </div>
                   {else}
                   <div class="qa-rank"><div class="answers ml10 mr10">
                0<small>回答</small></div></div>
                {/if}
                
                
                {/if}
                   <div class="summary">
            <ul class="author list-inline">
                                           
                                                <li class="authorinfo">
                                          {if $question['hidden']==1}
                                            匿名用户
                      
                       {else} 
                          <a href="{url user/space/$question['authorid']}">{$question['author']} {if $question['author_has_vertify']!=false}<i class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  "  ></i>{/if}</a>
                      
                         {/if} 
                       
                        <span class="split"></span>
                        <a href="{url question/view/$question['id']}">{$question['format_time']}</a>
                                    </li>
            </ul>
            <h2 class="title"><a href="{url question/view/$question['id']}">
            
            {$question['title']}
            {if $question['price']>0}
            <span class="icon_price" ><i
	class="fa fa-database"></i>$question['price']</span>
	{/if}
	
	    {if $question['shangjin']>0}
	     <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="如果回答被采纳将获得 $question['shangjin']元，可提现" class="icon_hot"><i class="fa fa-hongbao mar-r-03"></i>悬赏$question['shangjin']元</span>
	     
          
	{/if}
	
	   {if $question['hasvoice']!=0}
         <span
	class="au_q_yuyin"><i class="fa fa-microphone"></i></span>
	{/if}
	
            </a></h2>
 <!--{if $question['tags']}-->
           <ul class="taglist--inline ib">
<!--{loop $question['tags'] $tag}-->
<li class="tagPopup authorinfo">
                        <a class="tag" href="{url tags/view/$tag['tagalias']}" >
                                                       {$tag['tagname']}
                        </a>
                    </li>
                    

                           
                <!--{/loop}-->
                 </ul>
                <!--{else}--><!--{/if}-->
                
              
                                   
                           
                                            </div>
    </section>
    <!--{/loop}-->
  
      
      </div>

    </div>
      <div class="pages">
                           {$departstr}
                        </div>
    </div>


  <div class="ui-col side " style="float: none;padding:7px;">
     <div class="widget-box pt0 " style="border:none;">
                        <h2 class="h4 widget-box__title" style="margin-bottom: 5px">热门标签</h2>
                        <ul class="taglist--inline multi">
                                <!--{eval $hosttaglist = $this->fromcache("hosttaglist");}-->
                                 <!--{loop $hosttaglist $index $rtag}-->
                                
                                                            <li class="tagPopup">
                                    <a class="tag" href="{url tags/view/$rtag['tagalias']}" >
                                                                          {if $rtag['tagimage']}  <img src="$rtag['tagimage']">{/if}
                                                                        {$rtag['tagname']}</a>
                                </li>
                                                <!--{/loop}-->          
                                                    </ul>
                    </div>
  </div>
  
  <div class="au_side_box" style="padding:0px;margin:0px;">

    <div class="au_box_title ws_mynewquestion" style="    padding: 7px;">

        <div>
            <i class="fa fa-file-text-o lv"></i>一周热点

        </div>

    </div>
    
     
      <div class="stream-list question-stream xm-tag tag-nosolve">
       <!--{eval $attentionlist = $this->fromcache("attentionlist");}-->
                                          <!--{loop $attentionlist $index $question}-->
      <section class="stream-list__item">
       {if $question['status']==2}
                <div class="qa-rank"><div class="answers answered solved ml10 mr10">
                {$question['answers']}<small>解决</small></div></div>     
                {else}
                {if $question['answers']>0}
                <div class="qa-rank"><div class="answers answered ml10 mr10">
                $question['answers']<small>回答</small></div>
                </div>
                   {else}
                   <div class="qa-rank"><div class="answers ml10 mr10">
                0<small>回答</small></div></div>
                {/if}
                
                
                {/if}
                   <div class="summary">
            <ul class="author list-inline">
                                           
                                                <li class="authorinfo">
                                          {if $question['hidden']==1}
                                            匿名用户
                      
                       {else} 
                              <a href="{url user/space/$question['authorid']}">
                          {$question['author']}{if $question['author_has_vertify']!=false}<i class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " ></i>{/if}
                          </a>
                      
                         {/if} 
                       
                        <span class="split"></span>
                        <a href="{url question/view/$question['id']}">{$question['format_time']}</a>
                                    </li>
            </ul>
            <h2 class="title"><a href="{url question/view/$question['id']}">{$question['title']}</a></h2>
 <!--{if $question['tags']}-->
           <ul class="taglist--inline ib">
<!--{loop $question['tags'] $tag}-->
<li class="tagPopup authorinfo">
                        <a class="tag" href="{url tags/view/$tag['tagalias']}" >
                                                       {$tag['tagname']}
                        </a>
                    </li>
                    

                           
                <!--{/loop}-->
                 </ul>
                <!--{else}--><!--{/if}-->
                
              
                                   
                           
                                            </div>
    </section>
    <!--{/loop}-->
  
      
      </div>
 
    </div>
<script type="text/javascript">
$(".showmore").click(function(){
	
if($(".showmore a").html()=="查看更多"){
	$(".morecat").css("display","inline-block")
	$(".showmore a").html("点击收起")
	}
else{
	$(".morecat").css("display","none")
	$(".showmore a").html("查看更多")
}
});
$(".showmoresub").click(function(){
	
	if($(".showmoresub a").html()=="查看更多"){
		$(".moresubcat").css("display","inline-block")
		$(".showmoresub a").html("点击收起")
		}
	else{
		$(".moresubcat").css("display","none")
		$(".showmoresub a").html("查看更多")
	}
	});
</script>
<!--{template footer}-->