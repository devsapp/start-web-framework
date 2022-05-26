<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->

{if $user['openid']==null||$user['openid']==''}
<div class="row">
<div class="col-md-12" style="text-align:center;">
<img src="{$setting['weixin_logo']}" style="width:220px;height:220px;margin:0 auto;">
</div>
<div class="col-md-12" style="text-align:justify;font-size:13px;font-weight:500">
<p class="ui-txt-warning">长按二维码关注官网公众号，然后输入"账号绑定"，绑定成功后即可参与提现。</p>
</div>
</div>
{else}

{if $shenhe==1}
<div class="ui-btn-wrap">
    <button class="ui-btn ui-btn-danger active" disabled>
       提现申请正在审核
    </button>
    </div>

<hr>
{else}
 
<div class="ui-btn-wrap">
    <button class="ui-btn ui-btn-danger" onclick="showdialog()">
       申请提现
    </button>
    <button class="ui-btn ui-btn-primary" onclick="window.location.href='{url user/userzhangdan}'">
       查看对账流水
    </button>

</div>
        
        

<hr>


<div class="ui-dialog">
    <div class="ui-dialog-cnt">
      <header class="ui-dialog-hd ui-border-b">
                  <h3>提现申请</h3>
                  <i class="ui-dialog-close" data-role="button"></i>
              </header>
        <div class="ui-dialog-bd">
            <form id="askform" action="{SITE_URL}?user/postrequestmoney" method="POST"  >
            <div>
            <p>您目前可提现账户余额&nbsp;<span style="font-size:20px;color:#e0233c">{echo $user['jine']/100;}元</span>。</p>
       <div>
       <div>请输入提现金额：</div>
       <input style="height:20px;padding-left:20px;width:100px;border:none;border-bottom:solid 1px #777;background:transparent;" placeholder="输入提现金额" type="text" value="1" name="tixianjine" id="qxianjin">元</div> 
            </div>
             <button  type="submit" class="ui-btn ui-btn-primary" style="margin-top:10px;" >确认提现</button>
         </form>
        </div>
     
    </div>        
</div>
<script class="demo-script">


function hidedialog(){
	$(".ui-dialog").dialog("hide");
}
function showdialog(){
	$(".ui-dialog").dialog("show");
}
</script>

{/if}

{/if}
 
<h2 style="font-size:15px;">您当前收益为：<font color="#FC6603">{$rmb}元</font>，可提现<span style="font-size:20px;color:#e0233c">{echo $user['jine']/100;}元</span>【累计提现{$haspaymoney}元】</h2>
<p ><strong>（如果超过{if $setting['tixianjine']}$setting['tixianjine']{else}1{/if}元可提现，提现手续费=提现金额*{if $setting['tixianfeilv']}$setting['tixianfeilv']{else}0{/if})</strong></p>       
<table class="ui-table ui-border-tb">
    <thead>
    <tr><th>打赏金额</th><th>打赏类型</th><th>可提现否</th><th>打赏时间</th></tr>
    </thead>
    <tbody>
       <!--{loop $moenylist $index $money}-->
    <tr><td class="ui-txt-highlight"  style="font-size:13px;">  {$money['cash_fee']}元</td>
    <td style="font-size:13px;"> {$money['operation']}</td>
     <td style="font-size:13px;">
               {$money['msg']}
              </td>
              <td style="font-size:13px;"> {$money['format_time']}</td>
              </tr>
   <!--{/loop}--> 
    </tbody>
</table>
 <div class="pages">$departstr</div>
      <!--{if $moenylist==null}-->
                  <p >暂无网友打赏记录</p>
                    <!--{/if}-->
</section>
 
<!--{template footer}-->