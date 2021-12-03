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
<form action="index.php?admin_duizhang/index{$setting['seo_suffix']}" method="POST">

<table class="table">

<tr>
     <td width="15%" ><label >
用户名:</label>
             <div class="input-group " >
            <input  class="form-control " size="16" id="username" name="username" value="{$username}" >

          </div>

             </td>  <td width="25%" >
                       <label >
类型刷选:</label>
             <div class="input-group " >

             <select name="selectoption" class="form-control">
                        <option value="0">--不限--</option>
                       <option value="1"{if isset($selectoption)} {if $selectoption == 1}selected{/if}{/if}>--现金充值--</option>
                         <option value="5" {if isset($selectoption)}{if $selectoption == 5}selected{/if}{/if}>--积分充值--</option>
                              <option value="6" {if isset($selectoption)}{if $selectoption == 6}selected{/if}{/if}>--回答被采纳--</option>
                       <option value="2" {if isset($selectoption)}{if $selectoption == 2}selected{/if}{/if}>--打赏--</option>
                       <option value="3" {if isset($selectoption)}{if $selectoption == 3}selected{/if}{/if}>--悬赏提问--</option>
                        <option value="4"{if isset($selectoption)} {if $selectoption == 4}selected{/if}{/if}>--付费提问--</option>
                    </select>
          </div> </td>
     <td width="15%" ><label >
查询日期:</label>
             <div class="input-group date form-date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
            <input  class="form-control " size="16" id="timestart" name="srchdatestart" value="{if isset($srchdatestart)}$srchdatestart{/if}"  readonly="">
            <span class="input-group-addon"><span class="icon-remove"></span></span>
            <span class="input-group-addon"><span class="icon-calendar"></span></span>
          </div>
             </td>
              <td width="25%">
               <label>
  到</label>
               <div class="input-group date form-date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
            <input  class="form-control " size="16"  id="timeend" name="srchdateend" value="{if isset($srchdateend)}$srchdateend{/if}" readonly="">
            <span class="input-group-addon"><span class="icon-remove"></span></span>
            <span class="input-group-addon"><span class="icon-calendar"></span></span>

          </div>

              </td>


</tr>

</table>
     <button type="submit" style="margin-top:25px;"  class="btn btn-primary" name="submit">查询</button>

</form>
<table class="table">
	<tbody><tr class="header"><td>打赏列表&nbsp;&nbsp;&nbsp;</td></tr>

</tbody></table>
	<table class="table">
		<tr class="header" align="center">

			<th>编号</th>
          <th>    用户id</th>
           <th>    用户名</th>
            <th>  金额(元)</th>
                <th>    类型</th>
                <th>    内容</th>
  <th>    备注</th>
                  <th>    时间</th>
		</tr>
		<!--{loop $shanglist $shang}-->

               <tr>
                <td>
             {$shang['id']}
              </td>
               <th>     {$shang['touid']}</th>
                   <th>     {$shang['touser']['username']}</th>
               <td>
               {$shang['money']}
              </td>
              <td>
               {$shang['operation']}
              </td>
               <td>
               {$shang['content']}
              </td>
  <td>
               {$shang['beizhu']}
              </td>
              <td>
               {$shang['time']}
              </td>

             </tr>


				<!--{/loop}-->

	</table>
   <div class="pages">{$departstr}</div>
       <link href="{SITE_URL}static/css/dist/lib/datetimepicker/datetimepicker.min.css" rel="stylesheet">
  <script src="{SITE_URL}static/css/dist/lib/datetimepicker/datetimepicker.min.js"></script>
<br>
<script>
$(".form-date").datetimepicker(
	    {
	    	weekStart: 1,
	        todayBtn:  1,
	        autoclose: 1,
	        todayHighlight: 1,
	        startView: 2,
	        forceParse: 0,
	        showMeridian: 1,
	        format: "yyyy-mm-dd hh:ii"
	    });
</script>
<!--{template footer}-->

