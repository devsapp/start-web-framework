<div class="alert alert-primary mb-2">{$word.langexplain1}</div>
<div class="input-group bootstrap-touchspin search">
  <input class="form-control form-control-lg input" />
  <span class="input-group-btn input-group-append">
    <button class="btn btn-primary btn-lg btn-search" type="button">{$word.search}</i>
    </button></span>
</div>
<span class="text-help m-2">{$word.hotsearches}：<a class="hot-search" tabindex="0">{$word.htmHome}</a></span>
<form method="POST" action="{$url.own_name}c=language_general&a=doModifyParameter" class="lang-search-form mt-3"
  data-submit-ajax="1" data-modal-commit="0">
  <div class="metadmin-fmbx" style="display:none;">
    <div class="tips p-1"></div>
    <input name="site" hidden />
    <input name="editor" hidden />
    <button type="submit" hidden class="btn"></button>
  </div>
</form>