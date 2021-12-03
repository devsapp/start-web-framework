<!--{template header}-->

<style>
.index .main {
    padding-top: 15px;
    padding-right: 0;
}
.notepanel{
	padding:5px;
    margin-bottom:20px;
    margin-top: 10px;
text-align: left;
}
.myjifenshow{
	    margin-top: 10px;
	text-align: left;
}
.myjifenshow .helpjifen a{
color:#f12525;
}
</style>

<div class="container index   " >

<div class="row"  style="padding-top:0px;margin:0px">
<div class="col-md-17 main bb"  style="padding-bottom:20px;">

   <div class="recommend-collection">
           商品列表
          </div>
    <div class="split-line"></div>
<div class="details">
			
					<ul class="product">
						<!--{loop $giftlist $index $gift}-->
							<li data-id="{$gift['id']}">
								
									
									
										<div class="rank">
												
											<!-- 											<div class="new">NEW</div> -->
												
													<div>
														<div class="ranknum">{eval echo ++$index;}</div>
														<div class="score">财富 </div>
														<div class="num">{$gift['credit']}</div>
													</div>
										</div>
									
								
								<div class="showpro">
									<img src="{SITE_URL}{$gift['image']}"  width="260" height="195">
									
								</div>
								<div class="author">
									<div class="info">
										<div class="title ">
											{$gift['title']}
										</div>
										<div class="career">{eval echo clearhtml($gift['description'],500);}</div>
									</div>
							
								
								</div>
								<div class="showdetails">
									<div class="pick" onclick="exchange({$gift['id']}, {$gift['credit']});">
										立即兑换 &nbsp; <span></span>
									</div>
								</div>
								</li>
							<div  class="rank-details-covers">
							</div>
						  <!--{/loop}-->
						
					</ul>
				</div>


 <div class="pages">{$departstr}</div>

<div class="tiplist">

 <div class="recommend-collection">
        温馨提示
          </div>
    <div class="split-line"></div>
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


<div class="col-md-7 aside">
   <!--{if $user['uid']}-->



         <div class="standing">
  <div class="positions bb" id="rankScroll">
      <h3 class="title" style="float:none;color:#333;">我的财富值</h3>
         <div class="row myjifenshow" style="padding:0px 20px 20px 40px;">
                <div class="col-xs-4 clearfix" style="padding: 0px;margin-right:10px;">
                    <a target="_blank" href="{url user/default}" class="pic" style="position:relative;top:10px;"><img width="35" height="35" src="{$user['avatar']}"></a>
                  </div>
                  <div class="col-xs-18" style="padding: 0px;">
                    <p class="font-12"><a target="_blank" href="{url user/default}">{$user['username']}</a></p>
                    <p>当前财富值:<img style="position:relative;top:-2px;" src="{SITE_URL}static/css/default/gold.gif"><font color="#FF6600">{$user['credit2']}</font></p>
                    <p class="helpjifen"><a href="{url rule/index}" target="_blank">如何获得财富?</a></p>


                </div>
            </div>

  </div>
  </div>



        <!--{/if}-->




         <div class="standing">
  <div class="positions bb" id="rankScroll">
      <h3 class="title" style="float:none;color:#333;">礼品公告</h3>
     <div id="exchange_detail" class="exchange" style="padding:20px;">
    
      {$setting['gift_note']}
    
            </div>

  </div>
  </div>
  
  

           <div class="standing">
  <div class="positions bb" id="rankScroll">
      <h3 class="title" style="float:none;color:#333;">财富榜</h3>
        <ul class="list" style="padding:20px;">
                <!--{eval $weekuserlist=$this->fromcache('alluserlist');}-->
                <!--{loop $weekuserlist $index $alluser}-->
                <!--{eval $index++;}-->
                <li  class="li-a-title">

                    <a href="{url user/space/$alluser['uid']}" target="_blank" onmouseover="pop_user_on(this, '{$alluser[uid]}', 'text');"  onmouseout="pop_user_out();"> <span class="pull-left">{$alluser['username']} </span><a title="{$alluser['credit2']}财富值" class=" tag  pull-right">{$alluser['credit2']}财富值</a></a>

                </li>
                <!--{/loop}-->
            </ul>

  </div>
  </div>



           <div class="standing">
  <div class="positions bb" id="rankScroll">
      <h3 class="title" style="float:none;color:#333;">兑换动态</h3>
     <div id="exchange_detail" class="exchange" style="padding:20px;">
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

<div class="modal fade" id="dialogadopt">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">兑换信息填写</h4>
    </div>
    <div class="modal-body">

    <div id="exchangeform" title="兑换礼品" >
    <form class="form-horizontal" name="loginform"  action="{url gift/add}" method="post">
        <input type="hidden" name="gid"  id="gid" value="" />


         <div class="form-group">
          <label class="col-md-4 control-label">真实姓名</label>
          <div class="col-md-14">
             <input type="text" id="realname" name="realname" value="" placeholder="请务必写上真实姓名,此项必填" class="form-control">
          </div>
           <div class="col-md-6">
               <i class="text-danger mar-r-05">*</i>请务必填入真实姓名
            </div>

        </div>

         <div class="form-group">
          <label class="col-md-4 control-label">电子邮箱</label>
          <div class="col-md-14">
             <input type="text" id="email" name="email" value="" placeholder="常用邮箱地址,此项必填" class="form-control">
          </div>
            <div class="col-md-6">
               <i class="text-danger">*</i> 常用邮箱地址
            </div>

        </div>

            <div class="form-group">
          <label class="col-md-4 control-label">手机号码</label>
          <div class="col-md-14">
             <input type="text" id="phone" name="phone" value="" placeholder="您的手机号码,此项必填" class="form-control">
          </div>
           <div class="col-md-6">
              <i class="text-danger">*</i> 常用手机号码
            </div>

        </div>

       <div class="form-group">
          <label class="col-md-4 control-label">邮寄地址</label>
          <div class="col-md-14">
             <input type="text" id="addr" name="addr"   placeholder="您的联系地址,此项必填" class="form-control">
          </div>
           <div class="col-md-6">
                  <i class="text-danger">*</i> 您的联系地址
            </div>

        </div>
          <div class="form-group">
          <label class="col-md-4 control-label">邮政编码</label>
          <div class="col-md-14">
             <input type="text" id="postcode" name="postcode"  placeholder="邮政编码" class="form-control">
          </div>


        </div>

            <div class="form-group">
          <label class="col-md-4 control-label">QQ</label>
          <div class="col-md-14">
             <input type="text" id="qq" name="qq"  placeholder="qq" class="form-control">
          </div>


        </div>
      <div class="form-group">
          <label class="col-md-4 control-label">备注</label>
          <div class="col-md-14">
             <input type="text" id="notes" name="notes"   placeholder="兑换备注" class="form-control">
          </div>


        </div>
       <div class="form-group">
          <div class="col-md-18">
             <input type="submit" id="submit" class="btn btn-danger width-120" value="提&nbsp;交" data-loading="稍候...">
          </div>
        </div>


    </form>

</div>
    </div>

  </div>
</div>
</div>


<div class="modal fade" id="gift_desc">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">礼品详情描述</h4>
    </div>
    <div class="modal-body gift_content">

    </div>

  </div>
</div>
</div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        	if($("#exchange_detail").height()>250){
		$("#exchange_detail").height(250);
		$("#exchange_detail").css("overflow","hidden");
		var scroll=new s('exchange_detail',2000,30);
		scroll.bind();
		scroll.start();
	}
    });
            function s(zxdt, delay, speed){
                    this.rotator = $("#" + zxdt);
                    this.delay = delay || 1000;
                    this.speed = speed || 20;
                    this.tid = this.tid2 = this.firstp = null;
                    this.pause = false;
                    this.num = 0;
                    this.p_length = $("#exchange_detail p").length;
                    }
    s.prototype = {
    bind:function(){
    var o = this;
            this.rotator.hover(function(){o.end(); }, function(){o.start(); });
    },
            start:function(){
            this.pause = false;
                    if ($("#exchange_detail p").length == this.p_length){
            this.firstp = $("#exchange_detail p:first-child");
                    this.rotator.append(this.firstp.clone());
            }
            var o = this;
                    this.tid = setInterval(function(){o.rotation(); }, this.speed);
            },
            end:function(){
                    this.pause = true;
                    clearInterval(this.tid);
                    clearTimeout(this.tid2);
            },
            rotation:function(){
                    if (this.pause)return;
                    var o = this;
                    var firstp = $("#exchange_detail p:first-child");
                    this.num++;
                    this.rotator[0].scrollTop = this.num;
                    if (this.num == this.firstp[0].scrollHeight + 8){
                        clearInterval(this.tid);
                        this.firstp.remove();
                        this.num = 0;
                        this.rotator[0].scrollTop = 0;
                        this.tid2 = setTimeout(function m(){o.start(); }, this.delay);
                    }
            }
    }
    function show_desc(title, gid) {
    $("#gift_desc .modal-title").html(title + "详情");
            $("#gift_desc .gift_content").html($("#" + gid + "_desc").html());

            $("#gift_desc").modal("show");
    }
    function exchange(id, credit) {
    var uid = "{$user['uid']}";
            var usercredit = "{$user['credit2']}";
            if (uid == 0) {
    login();
            return false;
    }
    if (credit > usercredit){
            alert("抱歉!您的财富值不够!");
            return false;
    }
    if(!confirm("确定兑换该礼品？完成兑换后会消耗您"+credit+"财富值!")){
        return false;
    }
    $("#gid").val(id);

            $("#dialogadopt").modal("show");
    }
</script>
<!--{template footer}-->