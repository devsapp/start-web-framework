<!--{template header}-->
<style>
    body{
        background: #f1f5f8;;
    }
</style>
  <!--商品列表-->
    <div class="au_gift_list">

  <!--{loop $giftlist $gift}-->
        <div class="ui-row-flex ui-whitespace au_gift_list_item">
            <div class="ui-col">
                 <div class="au_gift_img">
                                    <img src="{SITE_URL}{$gift['image']}" onclick="show_desc('{$gift[title]}', {$gift['id']});">
                               </div>
            </div>
            <div class="ui-col ui-col-2 ws_gift_right">
            <div class="hide" id="{$gift['id']}_desc">$gift['description']</div>
                   <p class="au_gift_name">{$gift['title']}</p>
                               <p class="au_gift_desc">
                                    {eval echo clearhtml($gift['description']);}
                               </p>
                               <p>
                                   售价：<span class="au_gift_price">{$gift['credit']}财富值</span>
                               </p>
                               <div class="au_gift_btn_duihuan"  onclick="exchange({$gift['id']}, {$gift['credit']});">立即兑换</div>
                           
            </div>
        </div>
                           
  <!--{/loop}-->
 <div class="pages">{$departstr}</div>
        </div>
 <!--温馨提示-->
    <div class="ui-row-flex ui-whitespace au_gift_list_item ws_gift_tip">
        <div class="ui-col ui-col">
            <div class="au_gift_tiptitle"><i class="fa fa-lightbulb-o"></i>温馨提示</div>
            <!--内容-->
            <div class="au_credit_note">
                <p>为了保证您所兑换的礼品能够及时送到，请您仔细阅读下列内容：</p>
                <p>1.请您填写详细的联系地址：省、市、区、县、村、路（街道号）、单位，注明您的邮编，真实姓名还有联系方式。</p>
                <div class="au_credit_note">
                    <p>详细地址示例： </p>
                    <p>a.单位地址</p>
                    <p>XX省XX市XX区XX路XX号 XX办公楼XX写字楼XX房间号XX公司
                    </p>
                    <p>b.学校地址(请您一定要注明所在年级和班级)
                        XX省XX市XX区XX路XX号XX学校 XX年级XX班级
                    </p>
                    <p>c.家庭地址(请您注明所在小区的楼号及门牌号)
                        XX省XX市XX区XX路XX号XX小区XX楼XX单元XX门牌号</p>
                </div>
                <p>2.由于快递公司所到地区有限，如果您的所在地快递不能到达，请在备注中注明，我们会为您转发EMS。</p>
                <p>3.如有任何问题，请及时站长.</p>
            </div>
            <!--end-->
        </div>
    </div>
   <!--兑换公告-->
                    <div class="au_side_box au_gift_rightside">

                        <div class="au_box_title">

                            <div>
                                <i class="fa fa-bell-o hong"></i>兑换公告

                            </div>

                        </div>
                        <div class="au_side_box_content">
                              <div class="au_gift_note_info">
                                 {$setting['gift_note']}
                              </div>
                        </div>
                    </div>

                    <!--兑换日志-->
                    <div class="au_side_box au_gift_rightside">

                        <div class="au_box_title">

                            <div>
                                <i class="fa fa-handshake-o lan"></i>兑换日志

                            </div>

                        </div>
                        <div class="au_side_box_content">
                            <ul>
                              <!--{if $loglist}-->
                <!--{loop $loglist $index $giftlog}-->
              
                 <li class="au_gift_duihuanlogitem">
                                    <div class="au_gift_duihuanlogitem_item">$index</div><div class="au_gift_duihuanlogitem_item"><a href="{url user/space/$giftlog['uid']}" target="_blank">{$giftlog['username']}</a></div><div class="au_gift_duihuanlogitem_item au_gift_duihuanlog_text">刚刚兑换了礼品"{$giftlog['giftname']}" </div>

                                </li>
                               
               
                <!--{/loop}-->
                <!--{/if}-->
                              

                            </ul>
                        </div>
                    </div>


                    <!--财富榜-->
                    <div class="au_side_box au_gift_rightside">

                        <div class="au_box_title">

                            <div>
                                <img src="{SITE_URL}static/css/aozhou/dist/images/sj.png">财富榜

                            </div>

                        </div>
                        <div class="au_side_box_content">
                            <ul>
                              <!--{eval $weekuserlist=$this->fromcache('alluserlist');}-->
                <!--{loop $weekuserlist $index $alluser}-->
                <!--{eval $index++;}-->
           
                 <li class="au_gift_duihuanlogitem">
                                    <div class="au_gift_duihuanlogitem_item"> 
                                    <a href="{url user/space/$alluser['uid']}" target="_blank" onmouseover="pop_user_on(this, '{$alluser[uid]}', 'text');"  onmouseout="pop_user_out();">
                                    {$alluser['username']}</a>
                                    </div><div class="au_gift_duihuanlogitem_item au_gift_duihuanlog_text">{$alluser['credit2']}金币 </div>

                                </li>
                <!--{/loop}-->
                               
                               

                            </ul>
                        </div>
                    </div>


<div class="modal fade" id="dialogadopt">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" onclick="closemodal()" class="close" data-dismiss="modal"><span aria-hidden="true"  >×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">兑换信息填写</h4>
    </div>
    <div class="modal-body">
    
    <div id="exchangeform" title="兑换礼品" >
    <form class="ui-form ui-border-t" name="loginform"  action="{url gift/add}" method="post">
        <input type="hidden" name="gid"  id="gid" value="" />
     
        
         <div class="ui-form-item ui-form-item-show  ui-border-b">
          <label  for="#">真实姓名</label>
          <div class="col-md-14">
             <input type="text" id="realname" name="realname" value="" placeholder="请务必写上真实姓名,此项必填" class="form-control">
          </div>
       
          
        </div>
        
         <div class="ui-form-item ui-form-item-show  ui-border-b">
          <label class="col-md-4 control-label">电子邮箱</label>
          <div class="col-md-14">
             <input type="text" id="email" name="email" value="" placeholder="常用邮箱地址,此项必填" class="form-control">
          </div>
         
          
        </div>
        
            <div class="ui-form-item ui-form-item-show  ui-border-b">
          <label class="col-md-4 control-label">手机号码</label>
          <div class="col-md-14">
             <input type="text" id="phone" name="phone" value="" placeholder="您的手机号码,此项必填" class="form-control">
          </div>
       
          
        </div>
        
       <div class="ui-form-item ui-form-item-show  ui-border-b">
          <label class="col-md-4 control-label">邮寄地址</label>
          <div class="col-md-14">
             <input type="text" id="addr" name="addr"   placeholder="您的联系地址,此项必填" class="form-control">
          </div>
          
          
        </div>
          <div class="ui-form-item ui-form-item-show  ui-border-b">
          <label class="col-md-4 control-label">邮政编码</label>
          <div class="col-md-14">
             <input type="text" id="postcode" name="postcode"  placeholder="邮政编码" class="form-control">
          </div>
           
          
        </div>
        
            <div class="ui-form-item ui-form-item-show  ui-border-b">
          <label class="col-md-4 control-label">QQ</label>
          <div class="col-md-14">
             <input type="text" id="qq" name="qq"  placeholder="qq" class="form-control">
          </div>
           
          
        </div>
      <div class="ui-form-item ui-form-item-show  ui-border-b">
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
      <button type="button" onclick="closemodal()" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
      <h4 class="modal-title">礼品详情描述</h4>
    </div>
    <div class="modal-body gift_content">
    
    </div>
   
  </div>
</div>
</div>
<script src="{SITE_URL}static/js/jquery-1.11.3.min.js"></script>
<script>$.noConflict();</script>
<script type="text/javascript">
jQuery(document).ready(function(){
        	if(jQuery("#exchange_detail").height()>250){
        		jQuery("#exchange_detail").height(250);
        		jQuery("#exchange_detail").css("overflow","hidden");
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
                    if (jQuery("#exchange_detail p").length == this.p_length){
            this.firstp = jQuery("#exchange_detail p:first-child");
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
                    var firstp =jQuery("#exchange_detail p:first-child");
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
    function closemodal(){
    	 jQuery(".modal").hide();
    	
    }
    function show_desc(title, gid) {
    	jQuery("#gift_desc .modal-title").html(title + "详情");
    	jQuery("#gift_desc .gift_content").html($("#" + gid + "_desc").html());
 
    	jQuery("#gift_desc").show();
    }
    function exchange(id, credit) {
    var uid = "{$user['uid']}";
            var usercredit = "{$user['credit2']}";
            if (uid == 0) {
   window.location.href="{url user/login}";
            return false;
    }
    if (credit > usercredit){
            alert("抱歉!您的财富值不够!");
            return false;
    }
    if(!confirm("确定兑换该礼品？完成兑换后会消耗您"+credit+"财富值!")){
        return false;
    }
    jQuery("#gid").val(id);

    jQuery("#dialogadopt").show();
    }
</script>
<!--{template footer}-->