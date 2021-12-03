<!--{template header}-->
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/category.css" />
<link rel="stylesheet" media="all" href="{SITE_URL}static/css/widescreen/css/list.css" />
<style>
.main-wrapper {
    margin-bottom: 40px;
    background: #fafafa;
    margin-top: 0px;
}
<!--
.subnav-wrap .subnav-contentbox .subnav-content>li {
    padding-left: 0px;
    padding-right: 30px;
}
.index .main .recommend-collection .c_current{
color:#3280fc;
display: inline-block;
    margin: 0 18px 18px 0;
    min-height: 32px;
    background-color: #fff;
    border: 1px solid #3280fc;
    border-radius: 4px;
    vertical-align: top;
    overflow: hidden;
}
 .morecat, .moresubcat{
display:none;
}
.stream-list__item{
position:relative;
}
.imgjiesu{
position: absolute;
    right: 10px;
    top: 13px;
    width: 45px;
    height: 35px;
}
.jinxingzhong{
position: absolute;
    right: 15px;
    top: 13px;
    width: 35px;
    height: 35px;
}
-->
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
                                           
                                                        
<div class="container collection index" style="padding-top:20px;">

  <div class="row" style="padding-top:0px;margin:0px">
    <div class=" col-md-17   main bb" style="padding-top:10px;margin-top:0px;">
     
                    
                      <div class="row">

        <div class="col-md-24">
             <div class="row">
                 <div class="">
                     <div class="" style="padding:15px;margin:15px;">
                           <div>
  <!-- 一级分类 -->
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
                    
                    
    <div class="subnav-content-wrap" id="tab_anchor" style="height: 56px;">
            <div class="subnav-wrap" style="left: 0px;">
                <div class="top-hull">
                    <div class="subnav-contentbox">
                        <div class="tab-nav-container">
                            <ul class="subnav-content ">
                          {if !$cid}
                       <li {if $paixu==0}class="current"{/if}><a href="{url new/default}">全部问题</a></li>
                          <li {if $paixu==5}class="current"{/if}><a href="{url new/default/5}">待解决</a></li>
                    <li {if $paixu==4}class="current"{/if}><a href="{url new/default/4}">已解决</a></li>
                                <li {if $paixu==1}class="current"{/if}><a href="{url new/default/1}">财富悬赏</a></li>           
                                    
                  {if 1==$setting['openwxpay'] }
                   <li {if $paixu==2}class="current"{/if}><a href="{url new/default/2}">抢答悬赏</a></li>
                  
                  {/if} 
                   
                     {if $setting['mobile_localyuyin']==1}
                           <li {if $paixu==3}class="current"{/if}><a href="{url new/default/3}">语音回答</a></li>
                     
                     {/if}
                     
                       {else} 
                       
                              <li {if $paixu==0}class="current"{/if}><a href="{url new/question/0/$cid}">全部问题</a></li>
                          <li {if $paixu==5}class="current"{/if}><a href="{url new/question/5/$cid}">待解决</a></li>
                    <li {if $paixu==4}class="current"{/if}><a href="{url new/question/4/$cid}">已解决</a></li>
                                   <li {if $paixu==1}class="current"{/if}><a href="{url new/question/1/$cid}">财富悬赏</a></li>
                  {if 1==$setting['openwxpay'] }
                   <li {if $paixu==2}class="current"{/if}><a href="{url new/question/2/$cid}">抢答悬赏</a></li>
                  
                  {/if} 
                   
                     {if $setting['mobile_localyuyin']==1}
                           <li {if $paixu==3}class="current"{/if}><a href="{url new/question/3/$cid}">语音回答</a></li>
                     
                     {/if}
                     
                     
                      {/if}
               
                            </ul>
                            <div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 <div id="list-container">
 
     <div class="stream-list question-stream">
      
          <!--{loop $questionlist $index $question}-->
      <section class="stream-list__item">
                <div class="qa-rank">
              {if $question['answers']==0}
                <div class="answers ml10 mr10">
                {$question['answers']}<small>回答</small></div>
                {else}
                {if $question['status']==2}
                <div class="answers answered solved ml10 mr10">
                 {$question['answers']}<small>解决</small></div>
                {else}
                
                <div class="answers answered ml10 mr10">
                {$question['answers']}<small>回答</small></div>
                {/if}
                {/if}
                <div class="views  viewsword0to99"><span> {$question['views']}</span><small>浏览</small></div>
                </div>        <div class="summary">
            <ul class="author list-inline">
                                                <li>
                                                
        {if $question['hidden']!=1}
                                            <a href="{url user/space/$question['authorid']}">    {$question['author']}
                 {if $question['author_has_vertify']!=false}<i class="fa fa-vimeo {if $question['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $question['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}</a>
                      {else}
                      匿名用户
                      {/if}
                        <span class="split"></span>
                        <a href="{url question/view/$question['id']}" class="askDate" >{$question['format_time']}</a>
                                   {if $question['shangjin']!=0}
                      <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="如果回答被采纳将获得 {$question['shangjin']}元，可提现" class="icon_hot" ><i class="fa fa-hongbao mar-r-03"></i>悬赏$question['shangjin']元</span>
                    {/if}
                    
                           {if $question['price']>0}
            <span class="icon_price" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="悬赏 {$question['price']}财富值，采纳后可获得"><i
	class="fa fa-database"></i>$question['price']</span>
	{/if}
	
                                    </li>
                                     {if $question['shangjin']&&$question['status']==1}<img class="jinxingzhong" src="{SITE_URL}static/images/jinxingzhong.png"/> {/if}
                                     
                                    {if $question['shangjin']&&$question['status']==2}<img class="imgjiesu" src="{SITE_URL}static/images/yijiesu.png"/> {/if}
          
            </ul>
            <h2 class="title"><a href="{url question/view/$question['id']}">{$question['title']} </a></h2>

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
           <div class="pages">
                           {$departstr}
                        </div>
      </div>

        </div>
 <div class=" col-md-7 aside" style="margin-top:0px;">

 <!--{template sider_searchquestion}-->


 <!--{template sider_hotquestion}-->

    <div class="standing" style="margin-top:20px;">
  <div class="positions bb" id="rankScroll">
      <h3 class="title" style="float:none;" >热门标签</h3>
       <ul class="taglist--inline multi" style="padding:0px 20px 20px 20px;">
                                    <!--{eval $hosttaglist = $this->fromcache("hosttaglist");}-->
                              
                                          <!--{loop $hosttaglist $index $hottag}-->
                              
                                                            <li class="tagPopup">
                                    <a class="tag" href="{url tags/view/$hottag['tagalias']}" >
                                                                          {if $hottag['tagimage']}  <img src="$hottag['tagimage']">{/if}
                                                                        {$hottag['tagname']}</a>
                                </li>
                                                    <!--{/loop}-->         
                                                    </ul>
  </div>
  </div>
  

                    
   
            
 </div>
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