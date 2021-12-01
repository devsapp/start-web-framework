<!--{template header}-->
<!--用户中心-->


    <div class="container person">

        <div class="row " style="margin-top: 20px;">
        <div class="col-md-6">
         <!--{template side_useritem}-->
        </div>
          <div class="col-md-16">
              <h4>修改密码</h4>
     <hr>
            <form class="form-horizontal"  action="{url user/uppass}"  method="post" >
 <div class="form-group">
          <p class="col-md-24 ">当前密码</p>
          <div class="col-md-14">
             <input type="password" id="oldpwd" name="oldpwd"  value="" placeholder="" class="form-control">
          </div>
        </div>
         <div class="form-group">
          <p class="col-md-24 ">新密码</p>
          <div class="col-md-14">
             <input type="password" id="newpwd"  name="newpwd"  value="" placeholder="" class="form-control">
          </div>
        </div>

         <div class="form-group">
          <p class="col-md-24 ">确认密码</p>
          <div class="col-md-14">
             <input type="password" id="confirmpwd"  name="confirmpwd"  value="" placeholder="" class="form-control">
          </div>
        </div>
     <div style="margin-left: 15px;">
      <!--{template code}-->
     </div>
     

        <div class="form-group">
          <div class=" col-md-10">
             <input type="submit" name="submit" id="submit" class="btn btn-success" value="保存" data-loading="稍候...">
          </div>
        </div>
 </form>
        </div>
            

        </div>

    </div>




<!--用户中心结束-->
<script type="text/javascript">
    function check_form(){
        var money_reg = /\d{1,4}/;
        var money = $("#money").val();
        if('' == money || !money_reg.test(money) || money>20000 ||  money<=0){
            alert("输入充值金额不正确!充值金额必须为整数，且单次充值不超过20000元!");
            return false;
        }
        return true;
    }
</script>
<!--{template footer}-->