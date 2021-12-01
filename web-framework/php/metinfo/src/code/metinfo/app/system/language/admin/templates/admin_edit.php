<form method="POST" action="{$url.own_name}c=language_admin&a=doEditor" class="lang-edit-form mt-3" data-submit-ajax="1">
  <div class="metadmin-fmbx">
    <dl>
      <dt>
        <label class="form-control-label">{$word.sort}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="order" class="form-control" />
          <span class="text-help ml-2">{$word.langorderinfo}</span>
        </div>
      </dd>
    </dl>

    <dl>
      <dt>
        <label class="form-control-label">{$word.langname}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="name" class="form-control" required />
        </div>
      </dd>
    </dl>


    <dl>
      <dt>
        <label class="form-control-label">{$word.langtype}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="checkbox" data-plugin="switchery" name="useok" value="0"/>
        </div>
      </dd>
    </dl>

    <dl>
      <dt>
        <label class="form-control-label">{$word.langhome}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="checkbox" data-plugin="switchery" name="met_index_type" value="0" class="type"/>
          <span class="text-help">{$word.langurlinfo}</span>
        </div>
      </dd>
    </dl>
    <dl>
			<input type="text" hidden name="mark">
      <button type="submit" hidden class="btn"></button>
    </dl>
  </div>
</form>
