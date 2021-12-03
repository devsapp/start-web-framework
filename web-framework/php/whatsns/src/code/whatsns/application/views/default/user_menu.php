
            {if $user['vertify']['status']==1}
            
             
  
           <div class="standing">
  <div class="positions bb" id="rankScroll">
      <h3 class="title" style="float:none;color:#333;">认证信息</h3>
           <div class="" style="padding:0px 20px;">
   

 <div class="description">

    <div class="js-intro"  style="color:#908d08">
    {$user['vertify']['jieshao']}
    </div>


  </div>
  </div>

  </div>
  </div>
  

   {/if}
   
   
  
           <div class="standing">
  <div class="positions bb" id="rankScroll">
      <h3 class="title" style="float:none;color:#333;">个人介绍<i title="修改个人介绍" onclick="window.location.href='{url user/profile}'" class="fa fa-edit hand" style="margin-left:5px;"></i></h3>
           <div class="" style="padding:0px 20px;">
   

  <div class="description">
    <div class="js-intro">
{if $user['introduction']}{$user['introduction']}{else}暂无介绍{/if}
    </div>


  </div>
  </div>

  </div>
  </div>
  
  


  
   <div class="standing">
  <div class="positions bb" id="rankScroll">
      <h3 class="title" style="float:none;color:#333;">我的主页</h3>
  <ul class="list user-dynamic "  style="border:none;">
    <li>
      <a href="{url user/default}">
        <i class="fa fa-home"></i> <span>我的首页</span>
</a>    </li>
<li>
      <a href="{url user/attention/question}">
        <i class="fa fa-star-o"></i> <span>我的关注</span>
</a>    </li>
   <li>
      <a href="{url user/invatelist}">
        <i class="fa fa-heart-o"></i> <span>我的邀请</span>
</a>    </li>



                      <li>
      <a href="{url user/recommend}">
        <i class="fa fa-newspaper-o"></i> <span>为我推荐</span>
</a>    </li>
    <li>
      <a href="{url user/ask}">
        <i class="fa fa-question-circle-o"></i> <span>我的提问</span>
</a>    </li>

   <li>
      <a href="{url user/answer}">
        <i class="fa fa-commenting-o"></i> <span>我的回答</span>
</a>    </li>

   <li>
      <a href="{url topic/userxinzhi/$user['uid']}">
        <i class=" fa fa-rss-square"></i> <span>我的文章</span>
</a>    </li>
<li>
      <a href="{url user/follower}">
        <i class="fa fa-user"></i> <span>我的粉丝</span>
</a>    </li>



  
  <div class="clear"></div>


  </ul>

  </div>
  </div>
  

  
  
   <div class="standing">
  <div class="positions bb" id="rankScroll">
      <h3 class="title" style="float:none;color:#333;">我的财富</h3>
   <ul class="list user-dynamic " style="border:none;">
   <li>
      <a href="{url user/level}">
        <i class="fa fa-sort-amount-desc"></i> <span>我的等级</span>
</a>    </li>
  <li>
      <a href="{url user/myjifen}">
        <i class="fa fa-registered"></i> <span>财富等级</span>
</a>    </li>
       
  
  <div class="clear"></div>


  </ul>

  </div>
  </div>
  


  