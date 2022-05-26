<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-seo">
  <form method="POST" action="{$url.site_admin}?n=html&c=html&a=doSaveSetup" class="static-form"
    data-submit-ajax="1" data-validate_order="#static-form">
    <div class="metadmin-fmbx">
      <h3 class="example-title">{$word.unitytxt_1}</h3>
      <dl>
        <dt>
          <label class="form-control-label">{$word.sethtmok}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_webhtm" value="0" class="custom-control-input" id="met_webhtm-0" />
              <label class="custom-control-label" for="met_webhtm-0">{$word.close}</label>
            </div>
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_webhtm" value="1" class="custom-control-input" id="met_webhtm-1" />
              <label class="custom-control-label" for="met_webhtm-1">{$word.setbasicTip3}</label>
            </div>
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_webhtm" value="2" class="custom-control-input" id="met_webhtm-2" />
              <label class="custom-control-label" for="met_webhtm-2">{$word.sethtmall}</label>
            </div>
            <span class="text-help ml-2">{$word.setbasicTip4}</span>
            <div class="hide met_webhtm">
              <a class="btn btn-primary" tabindex="1" data-toggle="modal" data-target=".html-modal"
                data-modal-url="seo/html" data-modal-footerok="0" data-modal-size="xl"
                data-modal-title="{$word.indexhtm}">{$word.indexhtm}</a>
            </div>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.sethtmway}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_htmway" value="0" class="custom-control-input" id="met_htmway-0" />
              <label class="custom-control-label" for="met_htmway-0">{$word.sethtmway1}</label>
            </div>
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_htmway" value="1" class="custom-control-input" id="met_htmway-1" />
              <label class="custom-control-label" for="met_htmway-1">{$word.sethtmway2}</label>
            </div>
            <span class="text-help ml-2">{$word.sethtmway3}</span>
          </div>
        </dd>
      </dl>
      <h3 class="example-title">{$word.sethtmpage4}</h3>
      <dl>
        <dt>
          <label class="form-control-label">{$word.sethtmtype}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_htmtype" value="htm" class="custom-control-input" id="met_htmtype-htm" />
              <label class="custom-control-label" for="met_htmtype-htm">htm</label>
            </div>
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_htmtype" value="html" class="custom-control-input" id="met_htmtype-html" />
              <label class="custom-control-label" for="met_htmtype-html">html</label>
            </div>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.sethtmpage}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_htmpagename" value="3" class="custom-control-input"
                id="met_htmpagename-3" />
              <label class="custom-control-label" for="met_htmpagename-3">ID</label>
            </div>
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_htmpagename" value="0" class="custom-control-input"
                id="met_htmpagename-0" />
              <label class="custom-control-label" for="met_htmpagename-0">{$word.sethtmpage1}</label>
            </div>
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_htmpagename" value="1" class="custom-control-input"
                id="met_htmpagename-1" />
              <label class="custom-control-label" for="met_htmpagename-1">{$word.sethtmpage2}</label>
            </div>
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_htmpagename" value="2" class="custom-control-input"
                id="met_htmpagename-2" />
              <label class="custom-control-label" for="met_htmpagename-2">{$word.sethtmpage3}</label>
            </div>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.setlisthtmltype}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_listhtmltype" value="0" class="custom-control-input"
                id="met_listhtmltype-0" />
              <label class="custom-control-label" for="met_listhtmltype-0">{$word.setlisthtmltype1}</label>
            </div>
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_listhtmltype" value="1" class="custom-control-input"
                id="met_listhtmltype-1" />
              <label class="custom-control-label" for="met_listhtmltype-1">{$word.setlisthtmltype2}</label>
            </div>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.sethtmlist}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_htmlistname" value="0" class="custom-control-input"
                id="met_htmlistname-0" />
              <label class="custom-control-label" for="met_htmlistname-0">{$word.sethtmlist1}</label>
            </div>
            <div class="custom-control custom-radio ">
              <input type="radio" name="met_htmlistname" value="1" class="custom-control-input"
                id="met_htmlistname-1" />
              <label class="custom-control-label" for="met_htmlistname-1">{$word.sethtmlist2}</label>
            </div>
          </div>
        </dd>
      </dl>

      <dl>
        <dt></dt>
        <dd>
          <button type="submit" class="btn btn-primary">{$word.Submit}</button>
        </dd>
      </dl>
    </div>
  </form>
</div>