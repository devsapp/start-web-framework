<!--{template header}-->
<ul class="tab-head mynavlist" >
    {eval  $catlist=$this->getlistbysql("select id,name,displayorder,grade from ".$this->db->dbprefix."category where iscourse=0 and isusearticle=1 and grade=1 and pid=0 order by displayorder asc  limit 0,100");}
      
    
                                             <li class="tab-head-item {if $catid=='all'||!$catid }current{/if}"><a  href="{eval echo  str_replace('.html','',url('seo/index'));}" >全部</a></li>
                                             

                  <!--{loop $catlist $index $cat}-->
               
                  
                      <li class="tab-head-item {if $pid==$cat['id']||$catid==$cat['id']}current{/if}"><a  href="{eval echo getcaturl($cat['id'],'seo/index/#id#');}" title="{$cat['name']}">{$cat['name']}</a></li>
               
                    <!--{/loop}-->
                    
  
</ul>
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
                                      
                                   <div class="row filters-wrapper filter-categorys-wrapper no-margin">
                                   
                                       <div class="filter-item-wrapper col-md-24">
                                     {if isset($pid)&&$pid!=0}
                                     {eval $_ccid=$pid;}
                                     {else}
                                      {eval $_ccid=$catid;}
                                     {/if}
                                         <a href="{eval echo getcaturl($_ccid,'seo/index/#id#');}">
                                        
                                          
                                        
                                           <span class="filter-item ui-label {if $catid=='all'||!$catid ||!$pid}active{/if}">
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
                                   <a href="{eval echo getcaturl($subcat['id'],'seo/index/#id#');}"> 
                                    {if $catid==$subcat['id']}
                                    <span class="filter-item active">
                                    {else}
                                       <span class="filter-item  ui-label">
{/if}
           {$subcat['name']}

                                           </span></a>
                                           {/if}
                                             <!--{/loop}-->
                                             
                                                <!--{loop $subcatlist $sindex $subcat}-->
         {if  $sindex>=20}
                                   <a class="moresubcat" href="{eval echo getcaturl($subcat['id'],'seo/index/#id#');}">  <span class="filter-item   ui-label {if $catid==$subcat['id']}active{/if}">

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
            <li class="tab-head-item au_tab {if $paixu=='new'}current{/if}" data-tag="tag-nosolve"><a href="{eval echo getcaturl($catid,'seo/index/#id#/new');}">最新</a></li>
             <li class="tab-head-item au_tab {if $paixu=='weeklist'}current{/if}" data-tag="tag-solvelist"><a href="{eval echo getcaturl($catid,'seo/index/#id#/weeklist');}">热门</a></li>
            <li class="tab-head-item au_tab {if $paixu=='hotlist'}current{/if}" data-tag="tag-score"><a href="{eval echo getcaturl($catid,'seo/index/#id#/hotlist');}">推荐</a></li>
              

                {if 1==$setting['openwxpay']|| $this->setting['openalipay']==1 }
            <li class="tab-head-item au_tab {if $paixu=='money'}current{/if}" data-tag="tag-shangjinscore"><a href="{eval echo getcaturl($catid,'seo/index/#id#/money');}">付费</a></li>
             {/if}
        <li class="tab-head-item au_tab {if $paixu=='credit'}current{/if}" data-tag="tag-score"><a href="{eval echo getcaturl($catid,'seo/index/#id#/credit');}">财富</a></li>
              
                     
        </ul>
                   
        
           <div class="whatsns_list" style="background:#F6F6F6">
     <!--{loop $topiclist $index $topic}-->   


                       
                        <div class="whatsns_listitem">
         <div class="l_title"><h2><a href="{url topic/getone/$topic['id']}">
      {$topic['title']}</a></h2></div>
   {if $topic['image']&&!strstr($topic['image'],'default.jpg')}
       <div class="whatsns_content" style="margin-top:10px;">
  
 

<div class="weui-flex">



   <div class="weui-flex__item"><div class="imgthumbbig"><a href="{url topic/getone/$topic['id']}"><img   src="$topic['image']"></a></div></div>



</div>

 
 
     
       </div>
        {/if}
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
                                      <a href="{eval echo getcaturl($category1['id'],'seo/index/#id#');}">  <img src="{$category1['image']}"></a>
                                    </div>
                                    <div class="_content">
                                      <div class="_rihgtc">
                                          <span class="subname">
                                           <a href="{eval echo getcaturl($category1['id'],'seo/index/#id#');}">{$category1['name']}</a>
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