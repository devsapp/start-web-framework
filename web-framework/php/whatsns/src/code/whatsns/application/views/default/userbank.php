<!--{template header}-->






<!--用户中心-->


    <div class="container person">

        <div class="row " >
            <div class="col-xs-17 main">
            <!-- 用户title部分导航 -->
              <!--{template user_title}-->
             <!-- title结束标记 -->
       <!-- 内容页面 -->
    <div class="row" style="padding-top:0px">
                 <div class="" style="padding: 10px">
                     <div class="dongtai">
                         <p>
                             <strong class="font-18">我的银行</strong>
                         </p>

                         <hr>

{if $user['openid']==null||$user['openid']==''}
<div class="row">
<div class="col-md-24" style="text-align:center;">
<img src="{if isset($setting['weixin_logo'])}$setting['weixin_logo']{/if}" style="width:220px;height:220px;margin:0 auto;">
</div>
<div class="col-md-24" style="text-align:center;font-size:14px;font-weight:500">
<p class="text-danger">微信扫描上方二维码关注官网公众号，然后输入"账号绑定"，绑定成功后即可参与提现。</p>
</div>
</div>
{else}
<p class="mar-b-1 text-danger" style="text-align:left;font-size:18px;font-weight:500">您已经绑定微信收款账号</p>
{if isset($shenhe)&&$shenhe==1}
<button type="button" class="btn   btn-success" disabled >提现申请正在审核</button>
<hr>
{else}
<button type="button" class="btn   btn-success" data-toggle="modal" data-target="#myModal">申请提现</button>
<hr>
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
    <form id="askform" action="{url user/postrequestmoney}" method="POST"  onsubmit="return tijianshenqing()">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title">提现申请</h4>
      </div>
      <div class="modal-body">
        <p>您目前可提现账户余额&nbsp;<span style="font-size:20px;color:#e0233c">{echo $user['jine']/100;}元</span>。</p>
       <div><span>输入提现金额:</span><input style="height:30px;padding-left:20px;width:100px;margin-left:20px;" type="text" value="1" name="tixianjine" id="qxianjin"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button  type="submit" class="btn btn-success" >提交</button>
      </div>
      </form>
      <script>
    function tijianshenqing(){
    	  var _jine=parseFloat($.trim($("#qxianjin").val()));
    	  if(_jine<=0||_jine==''){
    		  alert("提现金额必须大于0");
    		  return false;
    	  }
    }
      </script>
    </div>
  </div>
</div>
{/if}

{/if}

  <p>您当前收益为：<font color="#FC6603">{$rmb}元</font>，可提现<span style="font-size:20px;color:#e0233c">{echo $user['jine']/100;}元</span>【累计提现{$haspaymoney}元】</p>
<p ><strong>（如果超过{if $setting['tixianjine']}$setting['tixianjine']{else}1{/if}元可提现，提现手续费=提现金额*{if $setting['tixianfeilv']}$setting['tixianfeilv']{else}0{/if})</strong></p>
                   <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>

            <th>  打赏金额(元)</th>
                <th>    打赏类型</th>
                <th>    打赏内容</th>
                 <th>    是否提现</th>
                  <th>    打赏时间</th>

          </tr>
        </thead>
        <tbody>
          <!--{loop $moenylist $index $money}-->
               <tr>
                <td>
              {$index}
              </td>

               <td>
               {$money['cash_fee']}
              </td>
              <td>
               {$money['operation']}
              </td>
               <td>
               {$money['content']}
              </td>
               <td>
               {$money['msg']}
              </td>
              <td>
               {$money['format_time']}
              </td>

             </tr>
                <!--{/loop}-->

        </tbody>
      </table>
      <div class="pages">$departstr</div>
      <!--{if $moenylist==null}-->
                  <p >暂无网友打赏记录</p>
                    <!--{/if}-->
                     </div>
                 </div>


             </div>
            </div>

            <!--右侧栏目-->
            <div class="col-xs-7  aside ">




                <!--导航列表-->

               <!--{template user_menu}-->

                <!--结束导航标记-->


                <div>

                </div>


            </div>

        </div>

    </div>




<!--用户中心结束-->

<!--{template footer}-->