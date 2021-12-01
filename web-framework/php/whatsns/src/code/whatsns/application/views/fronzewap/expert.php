<!--{template header}-->
    <style>
        body{
            background: #f1f5f8;
        }
        .hot-expert.expert-list .ever {
    font-size: 13px;
}
.go-to-ask, .add-focus, .hot-expert.expert-list footer span, .be-expert i {
    font-size: 13px;
    padding: 0 20px;
    border: 1px solid #387AEB;
    color: #387AEB;
}
    </style>
    <div class="expertcatlist" style="margin-top:10px;">
<div class="tabs-wrapper">
        <div class="tabs-mark-group plm ptm">
            <div class="title">所有分类：</div>

            <ul class="content list-unstyled list-inline" style="text-align:left;">
                <li class="classify">
                  <label class="label">{$category['name']}</label>
                </li>

                <li class="classify">
                </li>

                <li class="classify">
                </li>

            </ul>

        </div>

        <div class="tabs-group">
            <div class="title">分类:</div>
            <ul class="content clearfix">
             <li {if $category['id']=='all'}class="active" {/if}><a class="nav-link" href="{url expert/default/all/all}">全部</a></li>


          <!--{loop $sublist $index $cat}-->



           <li {if $category['id']==$cat['id']}class="active" {/if}><a class="nav-link" href="{url expert/default/$cat['id']/all}">{$cat['name']}</a></li>


                <!--{/loop}-->







            </ul>
        </div>



 {if $setting['openwxpay']==1}

        <div class="tabs-group ">
            <div class="title">条件:</div>
            <ul class="content clearfix ordercondition">
                <li {if $status=='all'}class="active" {/if}><a class="nav-link tag" href="{url expert/default/$category['id']/all}">全部</a></li>
                <li {if $status=='1'}class="active" {/if}><a class="nav-link tag" href="{url expert/default/$category['id']/1}">付费</a></li>
                <li {if $status=='2'}class="active" {/if}><a class="nav-link tag" href="{url expert/default/$category['id']/2}">免费</a></li>

            </ul>
        </div>
           {/if}
    </div>
 </div>
      <!--专家列表-->
      
      <section class="hot-expert expert-list white-box" id="quickout">
	<header>
		<h2>站内专家</h2>
	</header>
	<ul class="load-ul">
	      <!--{loop $expertlist $expert}-->
    <li class="clearfix"><a href="{url user/space/$expert['uid']}">
    {if $expert['mypay']}
    
     <span class="go-to-ask payask">咨询￥{$expert['mypay']}元</span>
          {else}
               <span class="go-to-ask">咨询</span>
                  {/if}  
				<figure class="member head-v">
					<img src="{$expert['avatar']}" alt="">
				</figure> <header>{$expert['username']}</header>
				<section>
					<p class="content">  {$expert['signature']}</p>
					<p class="ever">采纳率{eval echo $this->user_model->adoptpercent ( $expert );}%，回答{$expert['answers']}个，获得{$expert['supports']}赞</p>
				</section>
		</a></li>
      <!--{/loop}-->
	</ul>
	
</section>

                      
                  <div class="pages">{$departstr}</div>   
                  

 

<!--{template footer}-->