<!--{template header}-->


    <div class="container person">

        <div class="row " style="margin-top: 20px;">
        <div class="col-md-6">
           <!--{template side_useritem}-->
        </div>
        <div class="col-md-16">
         <h4>编辑个人资料</h4>
     <hr>
                    <form class="form-horizontal"  method="POST" name="upinfoForm"  action="{url user/profile}" >
 <div class="form-group">
          <p class="col-md-4 text-left">用户名:</p>
          <div class="col-md-8">
             {$user['username']}
          </div>
        </div>

     <div class="form-group">
          <p class="col-md-4 text-left ">真实姓名：</p>
          <div class="col-md-12">
             <input type="text" name="truename" id="truename"  value="{$user['truename']}" placeholder="" class="form-control">
          </div>
        </div>
             <div class="form-group">
          <p class="col-md-4 text-left ">工作单位：</p>
          <div class="col-md-12">
             <input type="text" name="conpanyname" id="conpanyname"  value="{$user['conpanyname']}" placeholder="" class="form-control">
          </div>
        </div>
        
         <div class="form-group">
          <p class="col-md-4 text-left">消息设置:</p>
          <div class="col-md-14">
             <span><input class="normal_checkbox" type="checkbox" <!--{if 1 & $user['isnotify']}-->checked<!--{/if}--> value="1" name="messagenotify" />站内消息&nbsp;&nbsp;</span>
                        <span><input class="normal_checkbox"  type="checkbox" <!--{if 2 & $user['isnotify']}-->checked<!--{/if}--> value="2" name="mailnotify" />邮件通知</span>
          </div>
        </div>
 
         <div class="form-group">
          <p class="col-md-4 text-left ">性别:</p>
          <div class="col-md-14">
            <span><input type="radio" value="1" class="normal_radio" name="gender" <!--{if (1 == $user['gender'])}--> checked <!--{/if}--> />男&nbsp;&nbsp;</span>
                        <span><input type="radio" value="0" class="normal_radio" name="gender" <!--{if (0 == $user['gender'])}--> checked <!--{/if}-->/>女 &nbsp;&nbsp;</span>
                        <span><input type="radio" value="2" class="normal_radio" name="gender" <!--{if (2 == $user['gender'])}--> checked <!--{/if}--> />保密</span>
          </div>
        </div>

         <div class="form-group">
          <p class="col-md-4 text-left ">生日：</p>
          <div class="col-md-14">
             <!--{eval $bdate=explode("-",$user['bday']);}-->
                        <select id="birthyear" name="birthyear" onchange="showbirthday();" class="normal_select">
                            <!--{eval $curyear=date("Y");}-->
                            <!--{eval $yearlist = range(1911,$curyear);}-->
                            <!--{loop $yearlist $year}-->
                            <option value="{$year}" <!--{if $bdate[0]==$year}-->selected<!--{/if}--> >{$year}</option>
                            <!--{/loop}-->
                        </select> 年&nbsp;&nbsp;
                        <select id="birthmonth" name="birthmonth" onchange="showbirthday();" class="normal_select">
                            {eval $monthlist = range(1,12);}
                            <!--{loop $monthlist $month}-->
                            <option value="{$month}" <!--{if $bdate[1]==$month}-->selected<!--{/if}-->>{$month}</option>
                            <!--{/loop}-->
                        </select> 月&nbsp;&nbsp;
                        <select id="birthday" name="birthday" class="normal_select">
                            {eval $dayhlist = range(1,31);}
                            <!--{loop $dayhlist $day}-->
                            <option  value="{$day}" <!--{if $bdate[2]==$day}-->selected<!--{/if}-->>{$day}</option>
                            <!--{/loop}-->
                        </select>日
          </div>
        </div>
          <div class="form-group">
          <p class="col-md-4 text-left ">手机号：</p>
          <div class="col-md-12">
             <input type="text"  name="phone" id="phone"  value="{$user['phone']}"   placeholder="请输入手机号码" class="form-control">
          </div>
        </div>

         <div class="form-group">
          <p class="col-md-4 text-left ">QQ：</p>
          <div class="col-md-12">
             <input type="text"  name="qq" id="qq"   value="{$user['qq']}" placeholder="" class="form-control">
          </div>
        </div>
         <div class="form-group">
          <p class="col-md-4 text-left ">MSN：</p>
          <div class="col-md-12">
             <input type="text"  name="msn" id="msn"  value="{$user['msn']}" placeholder="" class="form-control">
          
          </div>
        </div>
             <div class="form-group">
          <p class="col-md-4 text-left ">个人签名：</p>
          <div class="col-md-12">
             <input type="text" name="signature" id="signature" maxlength="15" value="{$user['signature']}" placeholder="一句话介绍自己,最多15字" class="form-control">
          
          </div>
        </div>
        
         <div class="form-group">
          <p class="col-md-4 text-left ">身份介绍</p>
          <div class="col-md-24">
            <textarea name="introduction" id="introduction" style="margin-right:30px;height:89px;" class="form-control" placeholder="个人介绍500字内" >{$user['introduction']}</textarea>


          </div>
        </div>





        <div class="form-group">
          <div class=" col-md-10">
             <input type="submit" id="submit" name="submit" class="btn btn-success" value="保存" data-loading="稍候...">
          </div>
        </div>
 </form>
        </div>
           

                </div>


            </div>

    





<!--用户中心结束-->

<!--{template footer}-->