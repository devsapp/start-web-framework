   {eval $user=$this->user;$setting=$this->setting;}
 {if $user['uid']==0} 
  <div class="no-login bb">
         <div class="title">
           <h5>{$setting['site_name']}</h5>
           <p>欢迎加入我们成为社区一员</p>
         </div>
         <p class="inst">您还没有登录，点击 <a href="javascript:login()">登录</a></p>
     </div>
      {else}
            <div class="user-info bb">
         <div class="user">
             <div class="figure"><a href="{url user/default}" target="_blank"><img src="{$user['avatar']}" alt=""></a></div>
             <p class="f-title">欢迎您，{$user['username']}</p>
         </div>
          <p class="inst">您已获得&nbsp;<span class="s1">{$user['supports']}</span>赞</p>
          
          <p class="inst">采纳率&nbsp;<span class="s1">{eval echo $this->user_model->adoptpercent ( $this->user );}</span>%</p>
           {if $setting['openwxpay']==1}
          <p class="inst">拥有现金&nbsp;<span class="s1">{eval echo doubleval($user['jine']/100);}</span>元</p>
            {/if}
           <p class="inst">拥有&nbsp;<span class="s1">{$user['credit2']}财富值</span></p>
       
        <div class="show">
             <a href="{url user/ask}" target="_blank"><span class="mypro">我的提问<br><font>{eval echo  returnarraynum ( $this->db->query ( getwheresql ( 'question', 'authorid=' . $this->user ['uid'] . $this->question_model->statustable [$status], $this->db->dbprefix ) )->row_array () ) ;}</font></span></a>
             <a href="{url user/answer}" target="_blank"><span>我的回答<br><font>{eval echo returnarraynum ( $this->db->query ( getwheresql ( 'answer', 'authorid=' . $this->user ['uid'] . $this->answer_model->statustable [$status], $this->db->dbprefix ) )->row_array () );}</font></span></a>
        </div>
      </div>
      
           {/if}

       {if $user['uid']!=0} 
      <div class="problems bb">
        <p class="iconshoucang"><i class="fa"></i>我收藏的问题&nbsp;:<a target="_blank" href="{url user/attention/question}"><font>{eval echo $this->user_model->rownum_attention_question ( $this->user ['uid'] );}</font></a></p>
        <p class="iconinvateme"><i class="fa"></i>邀请我回答的问题&nbsp;:<a href="{url user/invateme}" target="_blank"><font>{eval echo returnarraynum ( $this->db->query ( getwheresql ( 'question', " askuid=" . $user['uid'], $this->db->dbprefix ) )->row_array () );}</font></a></p>
       <p class="iconwenzhang"><i class="fa"></i><a target="_blank" href="{url topic/userxinzhi/$user['uid']}">我的文章</a></p>
            {if $setting['recharge_open']==1}   
        <p class="iconcaifu"><i class="fa"></i><a target="_blank" href="{url gift/default}">财富值兑换</a></p>
                 {/if}
            {if $setting['openwxpay']==1}
        <p class="iconjiaoyi"><i class="fa"></i><a target="_blank" href="{url user/userzhangdan}">交易明细</a></p>
        {/if}
      </div>
         {/if}