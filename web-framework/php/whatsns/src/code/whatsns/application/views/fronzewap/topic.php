<!--{template header}-->

     
                 <style>
.ui-container{
    background: #F6F6F6;
    min-height: 100vh;
    }
<!--
.payorder .active{
background: #0085ee;
    color: #fff;
}
-->
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
.more_link {
    text-align: center;
    margin-top: 10px;
    margin-bottom: 10px;
}
.more_link a {
    display: block;
    height: 30px;
    line-height: 32px;
    text-align: center;
    border: 1px solid #f8f8f8;
    background: #f8f8f8;
    color: #767676;
}
</style>
  
                        <div class="row">

        <div class="col-md-24">
             <div class="row">
                 <div class="">
                     <div class="" style="padding:15px;margin-bottom:15px;    background: #fff;">
                           <div>

                               <div class="course-filters">
                                   <div class="row filters-wrapper filter-categorys-wrapper no-margin">
                                       <div class="filter-title-wrapper col-sm-24 col-md-4">
                                           <span class="filter-title" >
          方向：
        </span>
                                       </div>
                                       <div class="filter-item-wrapper col-md-20">
                                          <a href="{url topic/default}">
                                         
                                           <span class="filter-item {if $catid=='all'||!$catid}active{/if}">
                                               全部
                                           </span>
                                           </a>
                                                 {eval  $catlist=$this->getlistbysql("select id,name,displayorder,grade from ".$this->db->dbprefix."category where iscourse=0 and isusearticle=1 and grade=1 and pid=0 order by displayorder desc  limit 0,100");}
        {if $catlist}
                  <!--{loop $catlist $index $cat}-->
                  {if $index<15}
                                          <a href="{url  topic/articlelist/$cat['id']}"> 
                                        {if isset($pid)&&$pid!=0}
                                           <span class="filter-item {if $pid==$cat['id']}active{/if}">
                                        
                                           {else}
                                             <span class="filter-item {if $catid==$cat['id']}active{/if}">
                                        
                                           {/if}
           {$cat['name']}

                                           </span></a>
                                           {/if}
                                              <!--{/loop}-->
                                              
                                                              <!--{loop $catlist $index $cat}-->
                  {if $index>=15}
                                          <a class="morecat"  href="{url  topic/articlelist/$cat['id']}"> 
                                        {if isset($pid)&&$pid!=0}
                                           <span class="filter-item {if $pid==$cat['id']}active{/if}">
                                        
                                           {else}
                                             <span class="filter-item {if $catid==$cat['id']}active{/if}">
                                        
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

                                   <div class="row filters-wrapper filter-categorys-wrapper no-margin">
                                       <div class="filter-title-wrapper col-sm-24 col-md-4">
                                           <span class="filter-title" >
          标签：
        </span>
                                       </div>
                                       <div class="filter-item-wrapper col-md-20">
                                       {if isset($catid)&&$catid!='all'}
                                         <a href="{url  topic/articlelist/$catid}">
                                         {else}
                                            <a href="{url topic/default}">
                                         {/if}
                                           <span class="filter-item {if $catid=='all'||!$catid}active{/if}">
                                               全部
                                           </span>
                                           </a>
                                           {if isset($pid)&&$pid!=0}
                                           
                                              {eval $_cid1=intval($pid); $subcatlist=$this->getlistbysql("select id,name,displayorder,grade from ".$this->db->dbprefix."category where  iscourse=0 and isusearticle=1 and grade=2  and pid=$_cid1 order by displayorder desc ");}
       
                                           {else}
                                           {if isset($catid)&&$catid!='all'}
                                            {eval $_cid1=intval($catid); $subcatlist=$this->getlistbysql("select id,name,displayorder,grade from ".$this->db->dbprefix."category where  iscourse=0 and isusearticle=1 and grade=2  and pid=$_cid1 order by displayorder desc ");}
       
                                           {else}
                                              {eval  $subcatlist=$this->getlistbysql("select id,name,displayorder,grade from ".$this->db->dbprefix."category where  iscourse=0 and isusearticle=1 and grade=2  order by displayorder desc ");}
       
                                           {/if}
                                           
                                           
                                           {/if}
                                                         
    
         <!--{loop $subcatlist $sindex $subcat}-->
         {if  $sindex<20}
                                   <a href="{url  topic/articlelist/$subcat['id']}"> 
                                    {if $catid==$subcat['id']}
                                    <span class="filter-item active">
                                    {else}
                                       <span class="filter-item">
{/if}
           {$subcat['name']}

                                           </span></a>
                                           {/if}
                                             <!--{/loop}-->
                                             
                                                <!--{loop $subcatlist $sindex $subcat}-->
         {if  $sindex>=20}
                                   <a class="moresubcat" href="{url  topic/articlelist/$subcat['id']}">  <span class="filter-item  {if $catid==$subcat['id']}active{/if}">

           {$subcat['name']}

                                           </span></a>
                                           {/if}
                                             <!--{/loop}-->
                                             
                                                                                               
                 {if count($subcatlist)>=20}
                  <div class="more_link showmoresub" style="width:90%;">
                                <a rel="nofollow">查看更多</a>
                            </div>
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
                        <!--最新文章-->
    <div class="au_side_box" style="padding:0px;margin:0px;">

     <!--导航-->
        <ul class="tab-head au_tabs">
            <li class="tab-head-item au_tab {if $typename=='new'}current{/if}" data-tag="tag-nosolve"><a href="{url topic/default}">最新</a></li>
             <li class="tab-head-item au_tab {if $typename=='hot'}current{/if}" data-tag="tag-solvelist"><a href="{url topic/weeklist}">热门</a></li>
            <li class="tab-head-item au_tab {if $typename=='top'}current{/if}" data-tag="tag-score"><a href="{url topic/hotlist}">推荐</a></li>
              

                {if 1==$setting['openwxpay'] }
            <li class="tab-head-item au_tab {if $typename=='pay'}current{/if}" data-tag="tag-shangjinscore"><a href="{url topic/paylist/money}">付费</a></li>
             {/if}
       
                     
        </ul>
                     {if $typename=='pay'}
        <div class="text-muted mb10 payorder" style="margin-left:12px;margin-top:5px;">排序：
                                <div class="btn-group btn-group-xs">
                                <a class="ui-label {if $readmode==3} active{/if}" href="{url topic/paylist/money}" role="button">人民币</a>
                                <a class="ui-label {if $readmode==2} active{/if}" href="{url topic/paylist/credit}" role="button">财富值</a>
    
                                </div>
                                </div>
                                 {/if}
        
           <div class="whatsns_list" style="background:#F6F6F6">
     <!--{loop $topiclist $index $topic}-->   


                       
                        <div class="whatsns_listitem">
         <div class="l_title"><h2><a href="{url topic/getone/$topic['id']}">
      {$topic['title']}</a></h2></div>

       <div class="whatsns_content">
  
 
   {if $topic['image']}
<div class="weui-flex">



   <div class="weui-flex__item"><div class="imgthumbbig"><a href="{url topic/getone/$topic['id']}"><img class="lazy" src="{SITE_URL}static/images/lazy.jpg" data-original="$topic['image']"></a></div></div>



</div>
 {/if}
 
 
         {if $topic['describtion']}
 <div class="whatsns_des">
 <span class="mtext" >{$topic['describtion']}</span>
 <div class="whatsns_readmore" onclick="window.location='{url topic/getone/$topic['id']}'">查看更多<i class="fa fa-angle-down"></i></div>
 </div>
  {/if}
       </div>
<div class="ask-bottom">
   
          <a href="{url topic/getone/$topic['id']}" class="" ><i class="fa fa-commentingicon"></i>{$topic['articles']} 个评论</a>
          <a href="{url topic/getone/$topic['id']}"  class=" "><i class="fa fa-qshoucang"></i>{$topic['likes']}个收藏</a>
               </div>
              </div>
                          <!--{/loop}-->    
  
</div>

             <div class="pages" style="margin-bottom:15px;">{$departstr}</div>
        </div>

 <!--{if $sublist }-->
   <!--热门主题-->
                    <div class="au_side_box" style="padding:7px;margin:0px;">

                        <div class="au_box_title">

                            <div>
                                <i class="fa fa-windows huang"></i>热门文章话题

                            </div>

                        </div>
                        <div class="au_side_box_content">
                            <ul>
                                  <!--{loop $sublist $index  $category1}-->
                                  {if $index<6}
                                <li {if $category1['miaosu']} data-toggle="tooltip" data-placement="bottom" title="" data-original-title=" {eval echo clearhtml($category1['miaosu']);}" {/if}>
                                    <div class="_smallimage">
                                      <a href="{eval echo getcaturl($category1['id'],'topic/catlist/#id#');}">  <img src="{$category1['image']}"></a>
                                    </div>
                                    <div class="_content">
                                      <div class="_rihgtc">
                                          <span class="subname">
                                           <a href="{eval echo getcaturl($category1['id'],'topic/catlist/#id#');}">{$category1['name']}</a>
                                          </span>
                                          <span class="_yuedu">{$category1['followers']}人关注</span>
                                          <p class="_desc" >
                                                 {eval echo clearhtml($category1['miaosu']);}

                                           </p>
                                      </div>

                                    </div>
                                </li>
                                {/if}
                                  <!--{/loop}-->
                            </ul>
                        </div>
                    </div>
                        <!--{/if}-->
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