<form method="POST" action="{$url.own_name}c=language_admin&a=doAddLanguage" class="link-form mt-3" data-submit-ajax="1">
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
        <label class="form-control-label">{$word.langselect}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <select name="autor" id="met-lang" tabindex="0" class="form-control">
            <option value="0">{$word.langselect1}</option
            ><option value="">{$word.managertyp5}...</option>
            <option value="sq">{$word.lang1}</option
            ><option value="ar">{$word.lang2}</option>
            <option value="az">{$word.lang3}</option
            ><option value="ga">{$word.lang4}</option>
            <option value="et">{$word.lang5}</option
            ><option value="be">{$word.lang6}</option>
            <option value="bg">{$word.lang7}</option
            ><option value="is">{$word.lang8}</option>
            <option value="pl">{$word.lang9}</option
            ><option value="fa">{$word.lang10}</option>
            <option value="af">{$word.lang11}</option
            ><option value="da">{$word.lang12}</option>
            <option value="de">{$word.lang13}</option
            ><option value="ru">{$word.lang14}</option>
            <option value="fr">{$word.lang15}</option
            ><option value="tl">{$word.lang16}</option>
            <option value="fi">{$word.lang17}</option
            ><option value="ht">{$word.lang20}</option>
            <option value="ko">{$word.lang21}</option
            ><option value="nl">{$word.lang22}</option>
            <option value="gl">{$word.lang23}</option
            ><option value="ca">{$word.lang24}</option>
            <option value="cs">{$word.lang25}</option
            ><option value="hr">{$word.lang26}</option>
            <option value="la">{$word.lang27}</option
            ><option value="lv">{$word.lang28}</option>
            <option value="lt">{$word.lang29}</option
            ><option value="ro">{$word.lang30}</option>
            <option value="mt">{$word.lang31}</option
            ><option value="ms">{$word.lang32}</option>
            <option value="mk">{$word.lang33}</option>
            <option value="no">{$word.lang35}</option
            ><option value="pt">{$word.lang36}</option>
            <option value="ja">{$word.lang37}</option
            ><option value="sv">{$word.lang38}</option>
            <option value="sr">{$word.lang39}</option
            ><option value="sk">{$word.lang40}</option>
            <option value="sl">{$word.lang41}</option
            ><option value="sw">{$word.lang42}</option>
            <option value="th">{$word.lang43}</option
            ><option value="tr">{$word.lang44}</option>
            <option value="cy">{$word.lang45}</option
            ><option value="uk">{$word.lang46}</option>
            <option value="iw">{$word.lang47}</option
            ><option value="el">{$word.lang48}</option>
            <option value="eu">{$word.lang49}</option
            ><option value="es">{$word.lang50}</option>
            <option value="hu">{$word.lang51}</option>
            <option value="it">{$word.lang53}</option
            ><option value="yi">{$word.lang54}</option>
            <option value="ur">{$word.lang59}</option
            ><option value="id">{$word.lang60}</option>
            <option value="en">{$word.lang61}</option
            ><option value="vi">{$word.lang62}</option>
            <option value="zh">{$word.lang63}</option
            ><option value="cn">{$word.lang64}</option></select
          >
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
    <dl class="lang-mark" style="display:none;">
      <dt>
        <label class="form-control-label">{$word.langexplain2}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="text" name="mark" class="form-control" />
          <span class="text-help ml-2">{$word.langmarkinfo}</span>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.langexplain6}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <select name="file" class="form-control"></select>
          <span class="text-help ml-2">{$word.langexplain4}</span>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.langtype}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="checkbox" data-plugin="switchery" name="useok" checked="checked" value="1"/>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class="form-control-label">{$word.langhome}</label>
      </dt>
      <dd>
        <div class="form-group clearfix">
          <input type="checkbox" data-plugin="switchery" name="type" value="0"/>
          <span class="text-help ml-2">{$word.langurlinfo1}</span>
        </div>
      </dd>
    </dl>
    <dl>
      <button type="submit" hidden class="btn"></button>
    </dl>
  </div>
</form>
