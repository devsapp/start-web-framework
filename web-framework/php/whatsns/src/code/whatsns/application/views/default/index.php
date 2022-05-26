<!--{template header}-->
  
    <main id="main">
        <div id="banner" class="content posrel">
          
     {template c_indextopinfo}
            <div class="banner-con clearfix">
                <div class="banner-left fl">
            
                    {template c_indexbanner}
                    <ul class="list bg-fff tc">
                          {eval $indexcatnum= isset($setting['list_indextopiccat'])&&$setting['list_indextopiccat']>0 ? intval($setting['list_indextopiccat']):6;}
      {eval  $huatilist=$this->getlistbysql("select id,name,displayorder,grade,dir from ".$this->db->dbprefix."category where iscourse=0 and isuseask=1 and grade=1 and pid=0 order by displayorder asc  limit 0,$indexcatnum");}
        {if $huatilist}
        
           <!--{loop $huatilist $index $huati}-->
         
         
            <li ><a href="{eval echo getcaturl($huati['id'],'topic/catlist/#id#');}">
                        <img src="{eval echo get_cid_dir($huati['id']);}" width="55" height="55">
                            <p class="p1 medium">{$huati['name']}</p>
                           
                        </a></li>
                        
          
            <!--{/loop}-->
         {/if}
         
                     
       
                        <li><a href="{url category/viewtopic/question}">
                         <img src="{SITE_URL}static/css/widescreen/css/index/img/banner-more.png" width="35" height="35" style="margin-top: 10px;">
                                <p class="p1 medium">全部</p>
                        </a></li>
                    </ul>
                </div>
                <div class="banner-right fr">
                  {template c_indexrightadimg}
                </div>
            </div>
            <div class="qrcode-wrap">

            </div>
        </div>
        <div class="same-content">
            <div id="answers" class="content clearfix">
                <div class="same-list-left fl  clearfix">
                    <div class="same-list-menu  clearfix">
                        <div class="menu-title fl clearfix">精选问答</div>
                        <ul class="menu-fun-list fl clearfix">
                           <li class=" active fl second-theme">最新问题</li>
                             <li class="fl second-theme">待解决</li>
                                  {if 1==$setting['openwxpay']||$this->setting['openalipay']==1 }
                            <li class=" fl second-theme">现金悬赏</li>
                            {/if}
                            <li class="fl second-theme">推荐问题</li>
                         
                     
                     {if $setting['mobile_localyuyin']==1}
                            <li class="fl second-theme">语音问答</li>
                          {/if}
                        </ul>
                    </div>
                             <ul class="same-list-main bg-fff clearfix show">
                                                               {eval  $indexquestiontilist=$this->getlistbysql("select id,status,title,shangjin,answers,cid from ".$this->db->dbprefix."question where status!=0  order by time desc  limit 0,10");}
        {if $indexquestiontilist}
        
           <!--{loop $indexquestiontilist $index $question}-->
                        <li class="fl clearfix">
                          <a href="{url question/view/$question['id']}"  class="title medium ellipsis" title="$question['title']">{eval echo clearhtml($question['title'],30);}</a>
                            <div class="list-bottom medium">
                               {if $question['shangjin']>0} <p class="price fl ">￥{$question['shangjin']}</p>{/if}
                                <p class="personalNum fl color-999">{$question['answers']} 人已参与回答</p>
                               {eval $qc= $this->category[$question['cid']];}
                               {if $qc}
                                <a href="{eval echo getcaturl($qc['id'],'category/view/#id#');}" class="tag fl small color-666">{$qc['name']}</a>
                                {/if}
                            </div>
                        </li>
                           <!--{/loop}-->
         {/if}

		
                            </ul>
                             <ul class="same-list-main bg-fff clearfix">
                                             {eval  $indexquestiontilist=$this->getlistbysql("select id,status,title,shangjin,answers,cid,hasvoice from ".$this->db->dbprefix."question where status=1  order by answers desc  limit 0,10");}
        {if $indexquestiontilist}
        
           <!--{loop $indexquestiontilist $index $question}-->
                        <li class="fl clearfix">
                            <a href="{url question/view/$question['id']}" class="title medium ellipsis">{$question['title']}</a>
                            <div class="list-bottom medium">
                            {if $question['shangjin']>0} <p class="price fl ">￥{$question['shangjin']}</p>{/if}
                                <p class="personalNum fl color-999">{$question['answers']} 人已参与回答</p>
                               {eval $qc= $this->category[$question['cid']];}
                               {if $qc}
                                <a href="{eval echo getcaturl($qc['id'],'category/view/#id#');}" class="tag fl small color-666">{$qc['name']}</a>
                                {/if}
                            </div>
                        </li>
                           <!--{/loop}-->
         {/if}
                                    </ul>
                                     {if 1==$setting['openwxpay']||$this->setting['openalipay']==1 }
                    <ul class="same-list-main bg-fff clearfix ">
                         {eval  $jingxuantilist=$this->getlistbysql("select id,status,title,shangjin,answers,cid from ".$this->db->dbprefix."question where status!=0 and shangjin>0 order by shangjin desc  limit 0,10");}
        {if $jingxuantilist}
        
           <!--{loop $jingxuantilist $index $question}-->
                        <li class="fl clearfix">
                             <a href="{url question/view/$question['id']}"  class="title medium ellipsis">{$question['title']}</a>
                            <div class="list-bottom medium">
                                <p class="price fl ">￥{$question['shangjin']}</p>
                                <p class="personalNum fl color-999">{$question['answers']} 人已参与回答</p>
                               {eval $qc= $this->category[$question['cid']];}
                               {if $qc}
                                <a href="{eval echo getcaturl($qc['id'],'category/view/#id#');}" class="tag fl small color-666">{$qc['name']}</a>
                                {/if}
                            </div>
                        </li>
                           <!--{/loop}-->
         {/if}
                    </ul>
  {/if}
                    <ul class="same-list-main bg-fff clearfix">
                                         {eval  $indexquestiontilist=$this->getlistbysql("select id,status,title,shangjin,answers,cid from ".$this->db->dbprefix."question where status=6  order by answers desc  limit 0,10");}
        {if $indexquestiontilist}
        
           <!--{loop $indexquestiontilist $index $question}-->
                        <li class="fl clearfix">
                            <a href="{url question/view/$question['id']}"  class="title medium ellipsis">{$question['title']}</a>
                            <div class="list-bottom medium">
                            {if $question['shangjin']>0} <p class="price fl ">￥{$question['shangjin']}</p>{/if}
                                <p class="personalNum fl color-999">{$question['answers']} 人已参与回答</p>
                               {eval $qc= $this->category[$question['cid']];}
                               {if $qc}
                                <a href="{eval echo getcaturl($qc['id'],'category/view/#id#');}" class="tag fl small color-666">{$qc['name']}</a>
                                {/if}
                            </div>
                        </li>
                           <!--{/loop}-->
         {/if}
                        </ul>

               
   {if $setting['mobile_localyuyin']==1}
                            <ul class="same-list-main bg-fff clearfix">
             {eval  $indexquestiontilist=$this->getlistbysql("select id,status,title,shangjin,answers,cid,hasvoice from ".$this->db->dbprefix."question where status!=0 and hasvoice!=0  order by answers desc  limit 0,10");}
        {if $indexquestiontilist}
        
           <!--{loop $indexquestiontilist $index $question}-->
                        <li class="fl clearfix">
                         <a href="{url question/view/$question['id']}"  class="title medium ellipsis">{$question['title']}</a>
                            <div class="list-bottom medium">
                            {if $question['shangjin']>0} <p class="price fl ">￥{$question['shangjin']}</p>{/if}
                                <p class="personalNum fl color-999">{$question['answers']} 人已参与回答</p>
                               {eval $qc= $this->category[$question['cid']];}
                               {if $qc}
                                <a href="{eval echo getcaturl($qc['id'],'category/view/#id#');}" class="tag fl small color-666">{$qc['name']}</a>
                                {/if}
                            </div>
                        </li>
                           <!--{/loop}-->
         {/if}
                                </ul>

                       {/if}          
                </div>
             

                <div class="same-list-right fr" style="max-width: 280px;">
  
  
                 {template c_indexrightvipimg}
               {template c_indexpaydoing}    
                </div>
            </div>
        </div>
        <!-- 推荐专家列表 -->
        {template c_indextuijianzhuanjia}
            <script type="text/javascript">
                    $(function() {
                        var j = 0; //初始变量
                        var i = 0; //初始变量
                        //分类tap
                        $('.second-kc').hover(function() {
                            j = $(this).index(); //当前索引
                            $(this).addClass('active').siblings().removeClass('active');
                            $('.optimumCourses-list').eq(j).addClass('show').siblings().removeClass('show');
                        });

                        
                        //分类tap
                        $('.second-theme').hover(function() {
                            i = $(this).index(); //当前索引
                            $(this).addClass('active').siblings().removeClass('active');
                            $('.same-list-main').eq(i).addClass('show').siblings().removeClass('show');
                        });
                    });
                </script>
    
        <!-- 推荐文章列表 -->
        {template c_indextuijianwenzhang}
    </main>
  <!--{template footer}-->