<!--{template header}-->
 <!-- 首页导航 --> 
{template index_nav}
<div class="layui-container" >

<div class="layui-row layui-col-space15"  >
<div class="layui-col-md8 " >
<div class="layui-card">
  <div class="layui-card-header">商品列表</div>
  <div class="layui-card-body">
  <!--{loop $giftlist $index $gift}-->
  <div class="layui-row">
  <div class="layui-col-md4">
  	<img src="{SITE_URL}{$gift['image']}" class="giftimage">
  </div>
  <div class="layui-col-md8">
  <div class="layui-card">
  <div class="layui-card-header">{$gift['title']}<span class="mar-l5 layui-badge " title="{$caifuzhiname}"><i class="layui-icon layui-icon-diamond font13 mar-r3"></i>{$gift['credit']}</span></div>
  <div class="layui-card-body">
   {eval echo clearhtml($gift['description'],500);}
  </div>
   <div class="layui-card-footer">
    <button type="button" class="layui-btn layui-btn-xs layui-btn-normal" onclick="exchange({$gift['id']}, {$gift['credit']});">立即兑换</button>
  </div>
</div>
  </div>
  </div>
    <!--{/loop}-->

  </div>
</div>




 {template page}


<div class="layui-card">
  <div class="layui-card-header">   温馨提示</div>
  <div class="layui-card-body">
     <div class="credit_note">
                <p>为了保证您所兑换的礼品能够及时送到，请您仔细阅读下列内容：</p>
                <p>1.请您填写详细的联系地址：省、市、区、县、村、路（街道号）、单位，注明您的邮编，真实姓名还有联系方式。</p>
                <div class="credit_note">
                    <p>详细地址示例： </p>
                    <p>a.单位地址</p>
                    <p>XX省XX市XX区XX路XX号 XX办公楼XX写字楼XX房间号XX公司<br>
                    </p>
                    <p>b.学校地址(请您一定要注明所在年级和班级)</p>
                    <p>XX省XX市XX区XX路XX号XX学校 XX年级XX班级<br>
                    </p>
                    <p>c.家庭地址(请您注明所在小区的楼号及门牌号)</p>
                    <p>XX省XX市XX区XX路XX号XX小区XX楼XX单元XX门牌号</p>
                </div>
                <p>2.由于快递公司所到地区有限，如果您的所在地快递不能到达，请在备注中注明，我们会为您转发EMS。</p>
                <p>3.如有任何问题，请及时<a href="mailto:{$setting['admin_email']}" target="_blank">联系我们</a>.</p>
            </div>
  </div>
</div>
</div>


<div class="layui-col-md4">
   <!--{if $user['uid']}-->
   <div class="fly-panel">
        <h3 class="fly-panel-title">我的{$caifuzhiname}</h3>
         <div class="layui-card-body">
                    <p>当前{$caifuzhiname}:<i class="layui-icon layui-icon-diamond font13 mar-r3"></i><font color="#FF6600">{$user['credit2']}</font></p>
                    <p class="font13 text-color-hui"><a href="{url rule/index}" target="_blank">如何获{$caifuzhiname}?</a></p>
         
         </div>
      </div>

        <!--{/if}-->



<div class="layui-card">
  <div class="layui-card-header">礼品公告</div>
  <div class="layui-card-body">
{$setting['gift_note']}
  </div>
</div>

    
   <div class="fly-panel">
        <h3 class="fly-panel-title">{$caifuzhiname}榜</h3>
         <div class="layui-card-body">
              <!--{eval $weekuserlist=$this->fromcache('alluserlist');}-->
                <!--{loop $weekuserlist $index $alluser}-->
                <!--{eval $index++;}-->
                   
                 <div class="displayblock"> <a href="{url user/space/$alluser['uid']}" target="_blank" class=" fl" >
                  <img class="defaultavatar" src="{eval echo get_avatar_dir({$alluser['uid']});}"/> <span >{$alluser['username']} </span></a>
                  <a title="{$alluser['credit2']}{$caifuzhiname}" class="   fr">
                   <span class="layui-badge layui-bg-orange">{$alluser['credit2']}{$caifuzhiname}</span></a>
                 
</div>  
<div class="clr"></div>
                <!--{/loop}-->
                
         </div>
      </div>
      



 <div class="fly-panel">
        <h3 class="fly-panel-title">兑换动态</h3>
          <div class="layui-card-body">
             <!--{if $loglist}-->
                <!--{loop $loglist $giftlog}-->
                <p class="duihuandesc"><a href="{url user/space/$giftlog['uid']}" target="_blank">{$giftlog['username']}</a> 刚刚兑换了礼品"{$giftlog['giftname']}"</p>
                <!--{/loop}-->
                <!--{/if}-->
         </div>
      </div>
    
  

</div>




</div>


</div>



     

 
        
<div id="tijiaolipin" >
<form class="layui-form"   action="{url gift/add}" method="post" style="margin-top:15px;">
<input type="hidden" name="gid"  id="gid" value="" />
   <div class="layui-form-item">
    <label class="layui-form-label">真实姓名</label>
    <div class="layui-input-inline">
      <input type="text" id="realname" name="realname" required lay-verify="required" placeholder="真实姓名" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">请务必填入真实姓名</div>
  </div>
      <div class="layui-form-item">
    <label class="layui-form-label">电子邮箱</label>
    <div class="layui-input-inline">
      <input type="text" id="email" name="email"   required lay-verify="required" placeholder="常用邮箱地址,此项必填" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">常用邮箱地址</div>
  </div>
  
     <div class="layui-form-item">
    <label class="layui-form-label">手机号码</label>
    <div class="layui-input-inline">
      <input type="text" id="phone" name="phone"  required lay-verify="required" placeholder="您的手机号码,此项必填" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">常用手机号码</div>
  </div>
       <div class="layui-form-item">
    <label class="layui-form-label">邮寄地址</label>
    <div class="layui-input-inline">
      <input type="text" id="addr" name="addr"  required lay-verify="required" placeholder="您的联系地址,此项必填" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">您的联系地址</div>
  </div>
  
     <div class="layui-form-item">
    <label class="layui-form-label">邮政编码</label>
    <div class="layui-input-inline">
      <input type="text"  id="postcode" name="postcode"   placeholder="邮政编码" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">可不填</div>
  </div>
  
   <div class="layui-form-item">
    <label class="layui-form-label">qq</label>
    <div class="layui-input-inline">
      <input type="text"  id="qq" name="qq"  placeholder="qq" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">其它备注信息</div>
  </div>
   <div class="layui-form-item">
    <label class="layui-form-label">备注</label>
    <div class="layui-input-inline">
      <input type="text" id="notes" name="notes"  placeholder="兑换备注" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">其它备注信息</div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit >立即提交</button>
    
    </div>
  </div>
</form>
 
<script>
//Demo
layui.use('form', function(){
  var form = layui.form;
  
 
});
</script>
</div>
<script type="text/javascript">

    function exchange(id, credit) {
    	
    var uid = "{$user['uid']}";
            var usercredit = "{$user['credit2']}";
            if (uid == 0) {
   window.location.href="{url user/login}";
            return false;
    }
    if (credit > usercredit){
    	layer.msg("抱歉!您的{$caifuzhiname}不够!");
            return false;
    }
    if(!confirm("确定兑换该礼品？完成兑换后会消耗您"+credit+"{$caifuzhiname}!")){
        return false;
    }
    document.getElementById("gid").value=id;
   
    layer.open({
	      type: 1,
	      title:'兑换礼品',
	      {if is_mobile()} area: ['90%', '560px'],{else}area: ['500px', '560px'],{/if}
	      shadeClose: true, //点击遮罩关闭
	      content: document.getElementById("tijiaolipin").innerHTML
	    });
 return ;
    }
  
</script>
<!--{template footer}-->