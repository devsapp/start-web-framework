<!--{template header}-->
<style>
<!--
.ui-table td{
line-height:50px;
}

-->
</style>
<!--内容部分--->
<div class="content-body" >
<div class="container bg-white " style="background: #fff;padding:10px;">

           <div class="ui-tips ui-tips-warn">
    <i></i><span> 网站积分来源获取明细表,实际情况根据站长后台设置，"-"表示扣分。</span>
</div>

 <table class="ui-table ui-border-tb">
        <thead>
          <tr>
          
         
          
                <th>    参数名称</th>
                <th>    经验值</th>
                
                  <th>   财富值</th>
                  
          </tr>
        </thead>
        <tbody>
  <tr >
            <td   >用户注册获得:</td>
            <td   >{$setting['credit1_register']}</td>
            <td  >{$setting['credit2_register']}</td>
        </tr>
          <tr >
            <td>每日登录系统获得:</td>
            <td   >{$setting['credit1_login']}</td>
            <td >{$setting['credit2_login']}</td>
        </tr>
        <tr >
            <td >提出问题获得:</td>
            <td  >{$setting['credit1_ask']}</td>
            <td >{$setting['credit2_ask']}</td>
        </tr>
        <tr >
            <td >回答问题获得:</td>
            <td   >{$setting['credit1_answer']}</td>
            <td >{$setting['credit2_answer']}</td>
        </tr>
        <tr >
            <td >回答被采纳:</td>
            <td   >{$setting['credit1_adopt']}</td>
            <td  >{$setting['credit2_adopt']}</td>
        </tr>
        <tr >
            <td  >发短消息获得:</td>
            <td   >{$setting['credit1_message']}</td>
            <td  >{$setting['credit2_message']}</td>
        </tr>
          <tr>
            <td >发布文章获得:</td>
            <td   >{$setting['credit1_article']}</td>
            <td >{$setting['credit2_article']}</td>
        </tr>
          <tr >
            <td  >邀请注册获得:</td>
            <td   >{$setting['credit1_invate']}</td>
            <td  >{$setting['credit2_invate']}</td>
        </tr>
        </tbody>
      </table>
      



</div>

</div>

