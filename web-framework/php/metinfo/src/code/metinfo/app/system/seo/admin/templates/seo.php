<form method="POST" action="{$url.own_name}c=seo&a=doSaveParameter" class='info-form' data-submit-ajax='1'>
  <div class="metadmin-fmbx">
    <h3 class='example-title'>{$word.columnmtitle}{$word.seting}</h3>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.setseohomeKey}</label>
      </dt>
      <dd>
        <div class='form-group clearfix'>
          <input type="text" name="met_hometitle" class="form-control">
          <span class="text-help ml-2">{$word.setseoTip10}</span>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.setseotitletype}</label>
      </dt>
      <dd>
        <div class='form-group'>
          <div class="custom-control custom-radio ">
            <input type="radio" name="met_title_type" value='0' class="custom-control-input met_title_type-0"
              id="met_title_type-0" />
            <label class="custom-control-label" for="met_title_type-0">{$word.setseotitletype1}</label>
          </div>
          <div class="custom-control custom-radio ">
            <input type="radio" name="met_title_type" value='1' class="custom-control-input met_title_type-1"
              id="met_title_type-1" />
            <label class="custom-control-label" for="met_title_type-1">{$word.setseotitletype3}</label>
          </div>
          <div class="custom-control custom-radio ">
            <input type="radio" name="met_title_type" value='2' class="custom-control-input met_title_type-2"
              id="met_title_type-2" />
            <label class="custom-control-label" for="met_title_type-2">{$word.setseotitletype2}</label>
          </div>
          <div class="custom-control custom-radio ">
            <input type="radio" name="met_title_type" value='3' class="custom-control-input met_title_type-3"
              id="met_title_type-3" />
            <label class="custom-control-label" for="met_title_type-3">{$word.setseotitletype4}</label>
          </div>
          <span class="text-help ">{$word.setseoTip14}</span>
        </div>
      </dd>
    </dl>
    <h3 class='example-title'>{$word.unitytxt_15}</h3>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.301jump}</label>
      </dt>
      <dd>
        <div class='form-group clearfix'>
          <input type="checkbox" data-plugin="switchery" name="met_301jump" value='0'>
          <span class="text-help ml-2">{$word.301jumpDescription}</span>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.gotohttps}</label>
      </dt>
      <dd>
        <div class='form-group clearfix'>
          <input type="checkbox" data-plugin="switchery" name="met_https" value='0'>
          <span class="text-help ml-2">{$word.gotohttps_tips}</span>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.copyright_nofollow}</label>
      </dt>
      <dd>
        <div class='form-group clearfix'>
          <input type="checkbox" data-plugin="switchery" name="met_copyright_nofollow" value='0'>
          <span class="text-help ml-2">{$word.copyright_nofollow_description}</span>
        </div>
      </dd>
    </dl>
    <h3 class='example-title'>{$word.unitytxt_25}</h3>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.setseoKey}</label>
      </dt>
      <dd>
        <div class='form-group'>
          <input type="text" name="met_keywords" class="form-control" />
          <span class="text-help ml-2">{$word.seotips1}</span>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.setseoTip6}</label>
      </dt>
      <dd>
        <div class='form-group'>
          <input type="text" name="met_alt" class="form-control" />
          <span class="text-help ml-2">{$word.setseoTip7}</span>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.setseoTip8}</label>
      </dt>
      <dd>
        <div class='form-group'>
          <input type="text" name="met_atitle" class="form-control" />
          <span class="text-help ml-2">{$word.setseoTip9}</span>
        </div>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.setseoLogoKeyword}</label>
      </dt>
      <dd>
        <div class='form-group'>
          <input type="text" name="met_logo_keyword" class="form-control" />
          <span class="text-help ml-2">{$word.temSupport}</span>
        </div>
      </dd>
    </dl>

    <h3 class='example-title'>{$word.admin_tag_setting1}</h3>
    <dl>
      <dt>
				<label class='form-control-label'>{$word.admin_tag_setting2}</label>
			</dt>
          <dd class="form-group">
              <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="tag_search_type_2" name="tag_search_type" value='module' class="custom-control-input" data-checked='{$c.tag_search_type}' required/>

                  <label class="custom-control-label" for="tag_search_type_2">{$word.by_module}</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="tag_search_type_3" name="tag_search_type" value='column' class="custom-control-input" />

                  <label class="custom-control-label" for="tag_search_type_3">{$word.admin_tag_setting3}</label>
              </div>
          </dd>
      </dl>
      <dl>
      <dt>
				<label class='form-control-label'>{$word.admin_tag_setting4}</label>
			</dt>
          <dd class="form-group">
              <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="tag_show_range_1" name="tag_show_range" value='0' data-checked='{$c.tag_show_range}' required class="custom-control-input" />
                  <label class="custom-control-label" for="tag_show_range_1">{$word.search}</label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="tag_show_range_2" name="tag_show_range" value='1' class="custom-control-input" />

                  <label class="custom-control-label" for="tag_show_range_2">{$word.admin_tag_setting5}</label>
              </div>
          </dd>
      </dl>
      <dl>
        <dt>
          <label class='form-control-label'>{$word.admin_tag_setting6}</label>
        </dt>
        <dd>
          <div class='form-group'>
            <input type="number" name="tag_show_number" class="form-control" value="{$c.tag_show_number}"/>
          </div>
        </dd>
      </dl>
    <h3 class='example-title'>{$word.404page}</h3>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.404page}</label>
      </dt>
      <dd>
        <div class='form-group clearfix'>
          <textarea name="met_404content" data-plugin='editor' data-editor-x='700' hidden></textarea>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.data_null}</label>
      </dt>
      <dd>
        <div class='form-group'>
          <textarea type="text" name="met_data_null" class="form-control" rows="5"></textarea>
          <span class="text-help ml-2">{$word.temSupport}</span>
        </div>
      </dd>
    </dl>
    <h3 class='example-title'>{$word.unitytxt_26}</h3>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.setseoFoot}</label>
      </dt>
      <dd>
        <div class='form-group clearfix'>
          <textarea name="met_foottext" data-plugin='editor' data-editor-x='700' hidden></textarea>
      </dd>
    </dl>
    <dl>
      <dt>
        <label class='form-control-label'>{$word.setseoTip4}</label>
      </dt>
      <dd>
        <div class='form-group clearfix'>
          <textarea name="met_seo" data-plugin='editor' data-editor-x='700' hidden></textarea>
      </dd>
    </dl>
    <dl>
      <dt></dt>
      <dd>
        <button type="submit" class='btn btn-primary'>{$word.Submit}</button>
      </dd>
    </dl>
  </div>
</form>