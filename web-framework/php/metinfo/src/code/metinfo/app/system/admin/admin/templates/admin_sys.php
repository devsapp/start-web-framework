<form method="POST" action="{$url.own_name}c=index&a=doSaveInfo" class="link-form" data-submit-ajax="1" autocomplete="new-password">
  <div class="metadmin-fmbx">
    <h3 class="example-title">{$word.admininfo}</h3>
    <dl>
      <dt>
        <label class="form-control-label">{$word.adminusername}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="admin_id" class="form-control" disabled autocomplete="new-password"/>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.adminpassword}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="password" name="admin_pass" class="form-control"
            placeholder="{$word.pass_empty}" autocomplete="new-password"/>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.adminpassword1}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="password" name="admin_pass_replay" class="form-control"
            data-fv-notEmpty-message="{$word.formerror1}" data-fv-identical="true" data-fv-identical-field="admin_pass"
            data-fv-identical-message="{$word.formerror5}" />
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.adminname}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="admin_name" class="form-control" />
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.adminmobile}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="admin_mobile" class="form-control" />
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.admin_email}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="admin_email" class="form-control" />
        </div>
      </dd>
    </dl>
    <input name="id" hidden />
  </div>
</form>