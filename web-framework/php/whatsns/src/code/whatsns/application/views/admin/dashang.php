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
<form action="index.php?admin_dashang/default{$setting['seo_suffix']}" method="POST">

<table class="table">

<tr>
     <td width="25%" ><label >
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
            <td width="25%">
             <button type="submit" style="margin-top:25px;"  class="btn btn-primary" name="submit">查询</button>
            </td>
</tr>

</table>

</form>
<table class="table">
	<tbody><tr class="header"><td>打赏列表&nbsp;&nbsp;&nbsp;</td></tr>

</tbody></table>
	<table class="table">
		<tr class="header" align="center">

			<td  >打赏人</td>
			<td >打赏人头像</td>
			<td >打赏金额</td>
			<td >打赏类型</td>
			<td >打赏标题</td>
			<td >被打赏人</td>
			<td >被打赏人uid</td>
			<td >打赏时间</td>
		</tr>
		<!--{loop $shanglist $shang}-->
		<tr align="center" class="smalltxt">

					<td  class="altbg2" align="center">{$shang['nickname']}</td>

					<td  class="altbg2" align="center">

					<img src="{$shang['headimgurl']}" width="45" height="45" />
					</td>
						<td  class="altbg2" align="center">{$shang['cash_fee']}元</td>
						<td  class="altbg2" align="center">{$shang['type']}</td>
					<td  class="altbg2" align="center">{$shang['model']['title']}</td>
					<td  class="altbg2" align="center">{$shang['model']['author']}</td>
					<td  class="altbg2" align="center">{$shang['model']['authorid']}</td>
						<td  class="altbg2" align="center">{$shang['format_time']}</td>
				</tr>
				<!--{/loop}-->
				   <!--{if $departstr}-->

        <!--{/if}-->
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

