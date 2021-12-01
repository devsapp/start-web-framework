<form method="POST" action="{$url.own_name}c=admin_user&a=doSaveUser" class="user-list-form" data-submit-ajax="1">
  <div class="metadmin-fmbx">
    <dl>
      <dt>
        <label class="form-control-label">{$word.loginusename}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="username" class="form-control" required disabled="disabled" />
        </div>
      </dd>
    </dl>
    <h3 class="example-title">
      {$word.user_accsafe_v6}
    </h3>
    <dl>
      <dt>
        <label class="form-control-label">{$word.user_PasswordReset_v6}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="password" name="password" class="form-control"  />
          <span class="text-help ml-2">{$word.user_tips18_v6}</span>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.bindingmail}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="email" class="form-control" autocomplete="off" />
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.bindingmobile}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="tel" class="form-control" autocomplete="off" />
        </div>
      </dd>
    </dl>

<!--     <dl>
      <dt>
        <label class="form-control-label">{$word.memberName}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="name" class="form-control"  autocomplete="off" />
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.idcode}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="idcode" class="form-control"  autocomplete="off" />
        </div>
      </dd>
    </dl> -->
    <h3 class="example-title">
      {$word.user_Accountstatus_v6}
    </h3>
    <dl>
      <dt>
        <label class="form-control-label">{$word.admintips5}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <select name="groupid" class="form-control d-inline-block w-a "> </select>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.memberCheck}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <select name="valid" class="form-control d-inline-block w-a ">
            <option value="1">{$word.yes}</option>
            <option value="0">{$word.no}</option>
          </select>
        </div>
      </dd>
    </dl>
    <h3 class="example-title">
      {$word.memberattribute}
    </h3>
    <div class="user-attr"></div>
      <!-- 会员通知 -->
      <!-- //会员通知 -->
    <dl>
      <input name="id" hidden/>
      <button type="submit" hidden class="btn"></button>
    </dl>
  </div>
</form>
