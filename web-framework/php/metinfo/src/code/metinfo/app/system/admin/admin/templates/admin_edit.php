<form method="POST" action="{$url.own_name}c=index&a=doSaveSetup" class="link-form" data-submit-ajax="1" autocomplete="new-password">
  <div class="metadmin-fmbx">
    <h3 class="example-title">{$word.admininfo}</h3>
    <dl>
      <dt>
        <label class="form-control-label">{$word.adminusername}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="admin_id" class="form-control" required autocomplete="new-password"/>
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
            placeholder="{$word.empty_not_modified}" autocomplete="new-password"/>
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
    <h3 class="example-title">{$word.admintips7}</h3>
    <dl>
      <dt>
        <label class="form-control-label">{$word.admintips7}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <div class="custom-control custom-radio ">
            <input type="radio" id="admin_group-1" name="admin_group" value="1" class="custom-control-input" />
            <label class="custom-control-label" for="admin_group-1">{$word.managertyp4}</label>
          </div>
          <div class="custom-control custom-radio ">
            <input type="radio" id="admin_group-2" name="admin_group" value="2" class="custom-control-input" />
            <label class="custom-control-label" for="admin_group-2">{$word.managertyp3}</label>
          </div>
          <div class="custom-control custom-radio ">
            <input type="radio" id="admin_group-3" name="admin_group" value="3" class="custom-control-input"
              checked="checked" />
            <label class="custom-control-label" for="admin_group-3">{$word.managertyp2}</label>
          </div>
          <div class="custom-control custom-radio ">
            <input type="radio" id="admin_group-0" name="admin_group" value="0" class="custom-control-input" />
            <label class="custom-control-label" for="admin_group-0">{$word.managertyp5}</label>
          </div>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.adminjurisd}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <div class="custom-control custom-checkbox ">
            <input type="checkbox" id="langok_1" name="langok" value="metinfo"
              class="custom-control-input lang-select-all" data-delimiter="-" checked="checked" disabled="disabled" />
            <label class="custom-control-label" for="langok_1">{$word.admintips1}</label>
          </div>
          <list data="$_M['langlist']['web']" name="$lang">
            <div class="custom-control custom-checkbox ">
              <input type="checkbox" id="checkbox-{$lang.lang}" name="langok" value="{$lang.lang}" data-delimiter="-"
                class="custom-control-input lang-select-item" checked="checked" disabled="disabled" />
              <label class="custom-control-label" for="checkbox-{$lang.lang}">{$lang.name}</label>
            </div>
          </list>
          <span class="text-help">{$word.admintips2}</span>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.admin_login_lang}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <list data="$_M['langlist']['admin']" name="$lang">
            <div class="custom-control custom-radio ">
              <input type="radio" id="radio-{$lang.lang}" name="admin_login_lang" value="{$lang.lang}"
                class="custom-control-input" <if value="$lang['id'] eq 1"> checked="checked"</if>
              disabled="disabled" />
              <label class="custom-control-label" for="radio-{$lang.lang}">{$lang.name}</label>
            </div>
          </list>
        </div>
      </dd>
    </dl>
<dl>
      <dt>
        <label class="form-control-label">{$word.veditor}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <div class="custom-control custom-checkbox ">
            <input type="checkbox" id="admin_pop-s1802" name="admin_pop" value="s1802" data-delimiter="-"
              checked="checked" class="custom-control-input" disabled="disabled" />
            <label class="custom-control-label" for="admin_pop-s1802">{$word.veditortips1}</label>
          </div>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.adminPower}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <div class="custom-control custom-checkbox ">
            <input type="checkbox" id="admin_issueok" name="admin_issueok" value="1" class="custom-control-input"
              disabled="disabled" />
            <label class="custom-control-label" for="admin_issueok">{$word.adminTip2}</label>
          </div>
          <div class="custom-control custom-checkbox ">
            <input type="checkbox" id="admin_check-{$time}" name="admin_check" value="1"
              class="custom-control-input" disabled="disabled" />
            <label class="custom-control-label" for="admin_check-{$time}">{$word.adminTip3}</label>
          </div>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.adminOperate}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <div class="custom-control custom-checkbox ">
            <input type="checkbox" id="admin_op_1" name="admin_op" value="metinfo" data-delimiter="-" checked="checked"
              class="custom-control-input admin_op_1" disabled="disabled" />
            <label class="custom-control-label" for="admin_op_1">{$word.adminOperate1}</label>
          </div>
          <div class="custom-control custom-checkbox ">
            <input type="checkbox" id="admin_op_2" name="admin_op" value="add" data-delimiter="-" checked="checked"
              class="custom-control-input admin_op_2 admin_op" disabled="disabled" />
            <label class="custom-control-label" for="admin_op_2">{$word.adminOperate2}</label>
          </div>
          <div class="custom-control custom-checkbox ">
            <input type="checkbox" id="admin_op_3" name="admin_op" value="editor" data-delimiter="-" checked="checked"
              class="custom-control-input admin_op" disabled="disabled" />
            <label class="custom-control-label" for="admin_op_3">{$word.adminOperate3}</label>
          </div>
          <div class="custom-control custom-checkbox ">
            <input type="checkbox" id="admin_op_4" name="admin_op" value="del" data-delimiter="-" checked="checked"
              class="custom-control-input admin_op" disabled="disabled" />
            <label class="custom-control-label" for="admin_op_4">{$word.adminOperate4}</label>
          </div>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.adminFunOperate}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <div class="custom-control custom-checkbox ">
            <input type="checkbox" name="admin_pop" class="custom-control-input role admin_pop_all" id="admin_pop_all"
              disabled="disabled" checked="checked" value="metinfo" data-delimiter="-" />
            <label class="custom-control-label" for="admin_pop_all">{$word.adminSelectAll}</label>
          </div>
        </div>
        <div class="admin-operate"></div>
      </dd>
    </dl>
    <input name="id" hidden />
  </div>
</form>