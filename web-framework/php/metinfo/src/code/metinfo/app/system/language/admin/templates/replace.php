<form method="POST" action="{$url.own_name}c=language_general&a=doBatchReplace" class="replace-form mt-3" data-submit-ajax="1">
  <div class="metadmin-fmbx">
    <dl>
      <dt>
        <label class="form-control-label">{$word.language_updatelang_v6}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <textarea name="textarea" rows="30" class="form-control mr-2 w-100" required></textarea>
        </div>
      </dd>
    </dl>
    <input name="site" hidden />
    <input name="editor" hidden />
    <dl>
      <button type="submit" hidden class="btn"></button>
    </dl>
  </div>
</form>
