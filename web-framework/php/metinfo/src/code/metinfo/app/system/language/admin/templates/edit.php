<form method="POST" action="{$url.own_name}c=language_web&a=doSaveEdite" class="lang-edit-form mt-3" data-submit-ajax="1">
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
        <label class="form-control-label">{$word.langflag}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <img id="langflag-edit" src="{$url.public_images}flag/cn.gif" />
          <input name="flag" type="hidden" class="text" value="cn.gif" />
          <button class="btn btn-default ml-2 btn-select-flag">{$word.selected}</button>
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
        <label class="form-control-label">{$word.langnewwindows}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="checkbox" data-plugin="switchery" name="newwindows" value="0"/>
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
      <dt>
        <label class="form-control-label">{$word.langouturl}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="link" class="form-control" />
          <span class="text-help">{$word.langouturlinfo}</span>
        </div>
      </dd>
    </dl>
    <dl>
			<input type="text" hidden name="mark">
      <button type="submit" hidden class="btn"></button>
    </dl>
  </div>
</form>
