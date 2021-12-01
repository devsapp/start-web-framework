<!--{template header}-->

<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;打赏记录查询</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->

<ol class="mb10">
	  	<p>◆ 给同一个实名用户付款，单笔单日限额2W/2W</p>
		<p>◆ 给同一个非实名用户付款，单笔单日限额2000/2000</p>
		<p>◆ 一个商户同一日付款总额限额100W</p>
        <li>◆ 仅支持商户号已绑定的APPID； </li>
        <li>◆ 针对付款的目标用户，已微信支付实名认证的用户可提供校验真实姓名的功能，未实名认证的用户无法校验，企业可根据自身业务的安全级别选择验证类型； </li>
        <li>◆ 付款金额必须小于或等于商户当前可用余额的金额； </li>
        <li>◆ 已付款的记录，企业可通过企业付款查询查看相应数据。 </li>
      </ol>
      <a class="btn btn-primary" href="{SITE_URL}index.php?admin_tixian{$setting['seo_suffix']}">返回提现审核列表</a>
<table class="table">
	<tbody><tr class="header"><td>打赏列表&nbsp;&nbsp;&nbsp;<span style="font-size:20px;">$touser['username']-【申请提现金额{eval echo $tixianfei['jine'];}元】</span>&nbsp;&nbsp;&nbsp;<a  href="{SITE_URL}index.php?admin_tixian/queren/{$uid}{$setting['seo_suffix']}" class="btn btn-primary">确认提现请求</a>
	&nbsp;&nbsp;&nbsp;<a title="提现不合规，驳回提现请求" href="{SITE_URL}index.php?admin_tixian/deletetixian/{$uid}{$setting['seo_suffix']}" class="btn btn-primary">驳回提现请求</a>
	</td></tr>

</tbody></table>
	<table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>

            <th>  金额(元)</th>
                <th>    类型</th>
                <th>    内容</th>

                  <th>    时间</th>

          </tr>
        </thead>
        <tbody>

          <!--{loop $moenylist $index $money}-->

               <tr>
                <td>
              {$index}
              </td>

               <td>
                    {if $money['type']=='thusertixian' }
              退还提现金额-托管金额返还 {$money['money']}
               {/if}
                    {if $money['type']=='usertixian' }
              支出提现金额-资金托管 {$money['money']}
               {/if}
               {if $money['type']=='wtxuanshang' }
               支出 {$money['money']}

               {/if}
                {if $money['type']=='thqid' }
               退还 {$money['money']}
               {/if}
                {if $money['type']=='chongzhi' }
               充值 {$money['money']}
               {/if}
                 {if $money['type']=='aid' }
               回答得现金 {$money['money']}
               {/if}
                   {if $money['type']=='tid' }
               发布文章得现金 {$money['money']}
               {/if}
                  {if $money['type']=='thetid' }
              退还付费提问现金 {$money['money']}
               {/if}
                 {if $money['type']=='etid' }
              付费支出提问现金 {$money['money']}
               {/if}
              </td>
              <td>
                {$money['operation']}
              </td>
               <td>
               {$money['content']}
              </td>

              <td>
               {$money['time']}
              </td>

             </tr>
                <!--{/loop}-->

        </tbody>
      </table>
      <div class="pages">$departstr</div>

<!--{template footer}-->

