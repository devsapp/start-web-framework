<!--{template header}-->

<style>
.main-wrapper {
    margin-bottom: 40px;
    background: #fafafa;
     margin-top: 15px;
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
.wbimgthumb{
float:left;
width:160px;
height:120px;
margin-right:10px;
}
.wbimgthumb img{
width:100%;
height:100%:
}
.list-inline li .fa{
margin-right:5px;
}
.list-inline li .fa-eye{
position:relative;
top:-2px;
}
-->
.stream-list__item .summary {

    overflow: hidden;
}
</style>

<div class="container index">

          
          <div class="container" style="margin-top:10px;">
            
                    
          <div class="row">
          
            <div class="col-md-17 main bb" style="margin-top:0px;"> 
              
                    
                        <div class="row">

        <div class="col-md-24">
             <div class="row">
                 <div class="">
                     <div class="" style="padding:15px;margin:15px;">
                           <div>

                               <div class="course-filters">
                                   <div class="row filters-wrapper filter-categorys-wrapper no-margin">
                                       <div class="filter-title-wrapper col-sm-24 col-md-4">
                                           <span class="filter-title" >
          方向：
        </span>
                                       </div>
                                       <div class="filter-item-wrapper col-md-20">
                                          <a href="{url seo/index}">
                                         
                                           <span class="filter-item {if $catid=='all'||!$catid}active{/if}">
                                               全部
                                           </span>
                                           </a>
                                                 {eval  $catlist=$this->getlistbysql("select id,name,displayorder,grade from ".$this->db->dbprefix."category where iscourse=0 and isusearticle=1 and grade=1 and pid=0 order by displayorder desc  limit 0,100");}
        {if $catlist}
                  <!--{loop $catlist $index $cat}-->
                  {if $index<15}
                                          <a href="{eval echo getcaturl($cat['id'],'seo/index/#id#');}"> 
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
                                          <a class="morecat"  href="{eval echo getcaturl($cat['id'],'seo/index/#id#');}"> 
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
                                         <a href="{eval echo getcaturl($catid,'seo/index/#id#');}">
                                         {else}
                                            <a href="{url seo/index}">
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
                                   <a href="{eval echo getcaturl($subcat['id'],'seo/index/#id#');}"> 
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
                                   <a class="moresubcat" href="{eval echo getcaturl($subcat['id'],'seo/index/#id#');}">  <span class="filter-item  {if $catid==$subcat['id']}active{/if}">

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
    
            <div class="">
      
            <div class="subnav-content-wrap" id="tab_anchor" style="height: 56px;">
            <div class="subnav-wrap" style="left: 0px;">
                <div class="top-hull">
                    <div class="subnav-contentbox">
                        <div class="tab-nav-container">
                            <ul class="subnav-content ">
                                                 <li class="{if $paixu=='new'}current{/if}"><a href="{eval echo getcaturl($catid,'seo/index/#id#/new');}">最新文章</a></li>
                          <li class="{if $paixu=='weeklist'}current{/if}"><a href="{eval echo getcaturl($catid,'seo/index/#id#/weeklist');}">热门文章</a></li>
                    <li class="{if $paixu=='hotlist'}current{/if}"><a href="{eval echo getcaturl($catid,'seo/index/#id#/hotlist');}">推荐文章</a></li>

                    {if 1==$setting['openwxpay'] }
                                       <li class="{if $paixu=='money'}current{/if}"><a href="{eval echo getcaturl($catid,'seo/index/#id#/money');}">付费专栏</a></li>
                    {/if}
                                <li class="{if $paixu=='credit'}current{/if}"><a href="{eval echo getcaturl($catid,'seo/index/#id#/credit');}">财富阅读</a></li>
                                          
                                      
                            </ul>
                            <div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    
              <div class="stream-list blog-stream">
                        <!--{loop $topiclist $nindex $topic}-->
              <section class="stream-list__item">
              <div class="blog-rank stream__item">
              <div class="stream__item-zan   btn btn-default mt0">
              <span class="stream__item-zan-icon"></span>
              <span class="stream__item-zan-number">{$topic['articles']}</span>
              </div></div>
              <div class="summary">
              <h2 class="title blog-type-common blog-type-1">
              <a href="{url topic/getone/$topic['id']}">
              {$topic['title']}
                   {if $topic['readmode']==3}
                      <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="支付{$topic['price']}元可以查看全文" class="icon_hot" style="color:#fff;"><i class="fa fa-cny mar-r-03"></i>$topic['price']元阅读</span>
                    {/if}
                       {if $topic['readmode']==2}
                      <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="支付{$topic['price']}财富值可以查看全文" class="icon_hot" style="color:#fff;"><i class="fa fa-database mar-r-03"></i>$topic['price']财富值</span>
                    {/if}
              </a></h2>
              <ul class="author list-inline">
              <li>
              <a href="{url user/space/$topic['authorid']}">
              <img class="avatar-24 mr10 " src="{$topic['avatar']}" alt=" {$topic['author']}">
              </a>
              <span style="vertical-align:middle;">
              <a href="{url user/space/$topic['authorid']}"> {$topic['author']}</a>
                    
                    发布于
                                            <a href="{eval echo getcaturl($topic['articleclassid'],'seo/index/#id#');}">{$topic['category_name']}</a>
                                        
                                      
                                            </span>
                                            </li>
 
      
       <li>
        <span style="vertical-align:middle;">
        <i class="fa fa-eye"></i>{$topic['views']}次浏览
        </span>
       </li>
       
        <li>
        <span style="vertical-align:middle;">
        <i class="fa fa-star"></i>{$topic['likes']}人收藏
        </span>
       </li>
       
          
        <li>
        <span style="vertical-align:middle;">
        <i class="fa fa-clock-o"></i>{$topic['viewtime']}
        </span>
       </li>
       
      </ul>
      <p class="excerpt wordbreak ">
      <div class="wbimgthumb">
         <img src="$topic['image']"  />
      </div>
   
       {if $topic['price']!=0}
                         <div class="box_toukan ">

  {eval echo clearhtml($topic['freeconent']);}
  {if $topic['readmode']==2}
											<a href="{url topic/getone/$topic['id']}"  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topic['price']&nbsp;&nbsp;财富值……</a>
{/if}
  {if $topic['readmode']==3}
											<a href="{url topic/getone/$topic['id']}" class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;更多阅读需支付&nbsp;$topic['price']&nbsp;&nbsp;元……</a>
{/if}

										</div>
                   {else}
                     {eval echo clearhtml($topic['describtion'],150);}
                    {/if}

  
  </p>
      </div>
      </section>
        <!--{/loop}-->
              </div>
                  <div class="pages">
    $departstr
    </div>
        </div>
          </div>
              
    
     
            <div class="col-md-7 aside" style="padding-top: 0px;margin-top:0px;">
         <!--{template sider_searcharticle}-->
         <div class=" alert alert-success tipwrite">
                <p>发布经验，赚取财富值，去财富商城兑换礼品！</p>
                <a href="{url user/addxinzhi}" class="btn btn-success btn-block mt-10">写文章</a>
            </div>
                <!--{template sider_author}-->
              
    
     <!--{template sider_hotarticle}-->
              
  
    
        <div class="standing" style="margin-top:20px;">
  <div class="positions bb" id="rankScroll">
      <h3 class="title" style="float:none;" >热门标签</h3>
       <ul class="taglist--inline multi" >
                                    <!--{eval $hosttaglist = $this->fromcache("hosttaglist");}-->
                              
                                          <!--{loop $hosttaglist $index $hottag}-->
                              
                                                            <li class="tagPopup">
                                    <a style="color: #0084FF;" class="tag" href="{url tags/view/$hottag['tagalias']}" >
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