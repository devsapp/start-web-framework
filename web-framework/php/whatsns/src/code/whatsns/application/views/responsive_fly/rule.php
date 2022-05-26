 <!-- 公共头部--> 
{template header}
 <!-- 首页导航 --> 
{template index_nav}
<style>
<!--
input,input:hover{
border:none;
background:none;
}
-->
</style>
<div class="layui-container">
<!--内容部分--->
<div class="content-body" style="margin-top:20px;">
<div class="container bg-white " style="background: #fff;padding:10px;">
<div class="alert alert-warning">网站积分来源获取明细表,实际情况根据站长后台设置，"-"表示{$caifuzhiname}。</div>
 <table class="layui-table">

         <thead>
    <tr>
      <th  class="smalltxt" align="center">参数名称</th>
      <th align="center">经验值</th>
      <th align="center">{$caifuzhiname}</th>
    </tr>
  </thead>
    <tbody>
        <tr >
            <td    class="altbg1">用户注册获得:</td>
            <td   class="altbg2"><input readonly value="{$setting['credit1_register']}" type="text" name="credit1_register"></td>
            <td   class="altbg1"><input readonly value="{$setting['credit2_register']}" type="text" name="credit2_register"></td>
        </tr>
        <tr >
            <td class="altbg1">每日登录系统获得:</td>
            <td   class="altbg2"><input readonly value="{$setting['credit1_login']}" name="credit1_login" type="text" ></td>
            <td  class="altbg1"><input readonly value="{$setting['credit2_login']}" name="credit2_login" type="text"></td>
        </tr>
        <tr >
            <td  class="altbg1">提出问题获得:</td>
            <td  class="altbg2"><input readonly value="{$setting['credit1_ask']}" name="credit1_ask" type="text" ></td>
            <td  class="altbg1"><input readonly value="{$setting['credit2_ask']}" name="credit2_ask" type="text"></td>
        </tr>
        <tr >
            <td  class="altbg1">回答问题获得:</td>
            <td   class="altbg2"><input readonly value="{$setting['credit1_answer']}" name="credit1_answer" type="text" ></td>
            <td  class="altbg1"><input readonly value="{$setting['credit2_answer']}" name="credit2_answer" type="text"></td>
        </tr>
        <tr >
            <td  class="altbg1">回答被采纳:</td>
            <td   class="altbg2"><input readonly value="{$setting['credit1_adopt']}" name="credit1_adopt" type="text" ></td>
            <td   class="altbg1"><input readonly value="{$setting['credit2_adopt']}" name="credit2_adopt" type="text"></td>
        </tr>
        <tr >
            <td   class="altbg1">发短消息获得:</td>
            <td   class="altbg2"><input readonly value="{$setting['credit1_message']}" name="credit1_message" type="text" ></td>
            <td   class="altbg1"><input readonly value="{$setting['credit2_message']}" name="credit2_message" type="text"></td>
        </tr>
          <tr>
            <td  class="altbg1">发布文章获得:</td>
            <td   class="altbg2"><input readonly value="{$setting['credit1_article']}" name="credit1_article" type="text" ></td>
            <td  class="altbg1"><input readonly value="{$setting['credit2_article']}" name="credit2_article" type="text"></td>
        </tr>
          <tr >
            <td   class="altbg1">邀请注册获得:</td>
            <td   class="altbg2"><input readonly value="{$setting['credit1_invate']}" name="credit1_invate" type="text" ></td>
            <td   class="altbg1"><input readonly value="{$setting['credit2_invate']}" name="credit2_invate" type="text"></td>
        </tr>
        </tbody>
    </table>


</div>

</div>
</div>
 <!-- 公共底部 --> 
{template footer}