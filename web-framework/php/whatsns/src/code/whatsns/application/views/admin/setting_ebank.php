<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;财富充值</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert  alert-warning">{$message}</div>
<!--{/if}-->

<a class="btn btn-success" href="https://www.ask2.cn/article-14778.html" target="_blank">查看配置教程</a>
<form action="index.php?admin_setting/ebank{$setting['seo_suffix']}" method="post">
    <a name="基本设置"></a>
    <table class="table">

        <tr class="header">
            <td colspan="2">参数配置</td>
        </tr>
        <tr>
            <td width="45%"><b>开启财富充值：</b><br><span class="smalltxt">关闭后网站将没有财富充值的功能</span></td>
            <td>
                <input class="radio" type="radio" {if 1==$setting['recharge_open'] }checked{/if}  value="1" name="recharge_open" />是&nbsp;&nbsp;
                       <input class="radio" type="radio" {if 0==$setting['recharge_open'] }checked{/if}  value="0" name="recharge_open" />否
            </td>
        </tr>
        <tr>
            <td width="45%"><b>充值汇率:</b><br><span class="smalltxt">以人名币1元为单位，例如 1元=10财富值</span></td>
            <td>1元 = <input type="text" class="txt" name="recharge_rate" value="{$setting['recharge_rate']}" size="8"/> 财富值</td>
        </tr>
        <tr class="header">
            <td colspan="2">支付宝及时到账配置</td>
        </tr>
        <tr>
            <td width="45%"><b>收款企业支付宝账号：</b><br><span class="smalltxt">您网站的收款支付宝账号，确保正确有效</span></td>
            <td><input type="text" class="txt" name="alipay_seller_email" value="{$setting['alipay_seller_email']}"/></td>
        </tr>
        <tr>
            <td width="45%"><b>合作者身份 (partnerID):</b><br><span class="smalltxt">支付宝签约用户请在此处填写支付宝分配给你的合作者身份，签约用户的手续费按照你与支付宝官方的签约协议为准,请咨询0571-88158090</span></td>
            <td><input type="text" class="txt" name="alipay_partner" value="{$setting['alipay_partner']}"/></td>
        </tr>
        <tr>
            <td width="45%"><b>交易安全校验码 (key):</b><br><span class="smalltxt">支付宝签约用户可以在此处填写支付宝分配给你的交易安全校验码，此校验码你可以到支付宝官方的商家服务功能处查看</span></td>
            <td><input type="password" class="txt" name="alipay_key" value="{$setting['alipay_key']}"/></td>
        </tr>
    </table>
    <br>
    <center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
</form>
<br>
<!--{template footer}-->