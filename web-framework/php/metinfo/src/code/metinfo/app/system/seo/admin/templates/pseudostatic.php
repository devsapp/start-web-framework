<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-seo">
  <form method="POST" action="{$url.own_name}c=pseudo_static&a=doSavePseudoStatic" class="info-form" data-submit-ajax="1">
    <div class="metadmin-fmbx">
      <h3 class="example-title">{$word.unitytxt_1}</h3>
      <div class="alert dark alert-primary radius0">{$word.seotips3}</div>
      <dl>
        <dt>
          <label class="form-control-label">{$word.sys_static}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="checkbox" data-plugin="switchery" name="met_pseudo"  value='0'/>
            <span class="text-help ml-2">{$word.seotips26}</span>
          </div>
        </dd>
      </dl>
      <div class="alert dark alert-primary radius0">{$word.mod_rewrite_column}</div>
      <h3 class="example-title">URL{$word.structure_mode}</h3>
      <dl>
        <dt>
          <label class="form-control-label">{$word.defaultlangtag}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="checkbox" data-plugin="switchery" name="met_defult_lang"  value='0'/>
            <span class="text-help ml-2">{$word.seotips4}</span>
          </div>
        </dd>
      </dl>

      <dl>
        <dt>
          <label class="form-control-label">{$word.seotips6}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <span class="text-help ml-2">{$word.admin_seo1}</span>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.setskinListPage}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <span class="text-help ml-2">{$word.admin_seo2}</span>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.seotips9}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <span class="text-help ml-2"> {$word.admin_seo3} </span>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.pseudo_static}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
						<a tabindex="0" class="watch-rule"
						data-toggle="modal"
						data-target=".pseudostatic-modal"
						data-modal-url="seo/rule"
						data-modal-size="lg"
						data-modal-title="{$word.pseudo_static}"
						data-modal-footerok="0"
						>{$word.pseudo_static}</a>
            <span class="text-help ml-2">{$word.manually_static_rules}</span>
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
