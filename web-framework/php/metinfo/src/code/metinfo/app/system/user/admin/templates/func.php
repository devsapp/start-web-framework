<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-user-func">
  <form method="POST" action="{$url.own_name}c=admin_set&a=doSaveSetup" data-submit-ajax='1'
    id="user-func-form" data-validate_order="#user-func-form">
    <div class="metadmin-fmbx">
      <h3 class="example-title">{$word.user_Registratset_v6}</h3>
      <dl>
        <dt>
          <label class="form-control-label">{$word.memberlogin}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="checkbox" data-plugin="switchery" name="met_member_register" value="0" />
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.user_Regverificat_v6}</label>
        </dt>
        <dd>
          <div class="custom-control custom-radio ">
            <input type="radio" id="met_member_vecan-1" name="met_member_vecan" value="1"
              class="custom-control-input" />
            <label class="custom-control-label" for="met_member_vecan-1"><abbr
                title="{$word.user_tips23_v6}">{$word.user_Mailvalidat_v6}</abbr><span
                class="text-help m-0">{$word.user_tips24_v6}</span></label>
          </div>
          <div class="custom-control custom-radio ">
            <input type="radio" id="met_member_vecan-2" name="met_member_vecan" value="2"
              class="custom-control-input" />
            <label class="custom-control-label" for="met_member_vecan-2">{$word.user_tips25_v6}</label>
          </div>
          <div class="custom-control custom-radio ">
            <input type="radio" id="met_member_vecan-3" name="met_member_vecan" value="3"
              class="custom-control-input" />
            <label class="custom-control-label" for="met_member_vecan-3">
              <abbr title="{$word.user_tips26_v6}">{$word.user_tips27_v6}</abbr>
              <span class="text-help m-0">{$word.user_tips28_v6}</span></label>
          </div>
          <div class="custom-control custom-radio ">
            <input type="radio" id="met_member_vecan-4" name="met_member_vecan" value="4"
              class="custom-control-input" />
            <label class="custom-control-label" for="met_member_vecan-4">{$word.user_Notverifying_v6}</label>
          </div>
        </dd>
      </dl>

        <h3 class="example-title">{$word.new_regist_admin_notice}</h3>
        <dl>
            <dt>
                <label class="form-control-label">{$word.new_regist_mail_open}</label>
            </dt>
            <dd>
                <div class="form-group clearfix">
                    <input type="checkbox" data-plugin="switchery" name="met_new_registe_email_notice" value="0" />
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class="form-control-label">{$word.new_regist_mail}</label>
            </dt>
            <dd>
                <input type="text" name="met_to_admin_email" value="" class="form-control">
                <span class="text-help ml-2">{$word.fdincTip9}</span>
            </dd>
        </dl>

        <dl>
            <dt>
                <label class="form-control-label">{$word.new_regist_sms_open}</label>
            </dt>
            <dd>
                <div class="form-group clearfix">
                    <input type="checkbox" data-plugin="switchery" name="met_new_registe_sms_notice" value="0" />
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class="form-control-label">{$word.new_regist_sms}</label>
            </dt>
            <dd>
                <input type="text" name="met_to_admin_sms" value="" class="form-control">
                <span class="text-help ml-2">{$word.module_reply1}</span>
            </dd>
        </dl>

      <h3 class="example-title">{$word.displaytype}</h3>
      <dl>
        <dt>
          <label class="form-control-label">{$word.user_login_box_position}</label>
        </dt>
        <dd>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="met_login_box_position-0" name="met_login_box_position" value="0"
              class="custom-control-input" />
            <label class="custom-control-label" for="met_login_box_position-0">{$word.posleft}</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="met_login_box_position-1" name="met_login_box_position" value="1"
              class="custom-control-input" />
            <label class="custom-control-label" for="met_login_box_position-1">{$word.poscenter}</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="met_login_box_position-2" name="met_login_box_position" value="2"
              class="custom-control-input" />
            <label class="custom-control-label" for="met_login_box_position-2">{$word.posright}</label>
          </div>
          <span class="text-help">{$word.user_login_box_tips}</span>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.user_login_bg_range_set}</label>
        </dt>
        <dd>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="met_member_bg_range-0" name="met_member_bg_range" value="0"
              class="custom-control-input" />
            <label class="custom-control-label" for="met_member_bg_range-0">{$word.user_login_bg_range_all_page}</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="met_member_bg_range-1" name="met_member_bg_range" value="1"
              class="custom-control-input" />
            <label class="custom-control-label" for="met_member_bg_range-1">{$word.user_login_bg_range_login_page}</label>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.background_color}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="text" name="met_member_bgcolor" data-plugin='minicolors' class="form-control" />
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.user_Backgroundpicture_v6}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <div class="d-inline-block">
              <input type="file" name="met_member_bgimage" value="" data-plugin='fileinput' accept="image/*"></div>
            <span class="text-help ml-2">{$word.user_tips30_v6}</span>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.member_agreement}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="checkbox" data-plugin="switchery" name="met_member_agreement" value="0" />
            <div class="hide met_member_agreement mt-3">
              <textarea name="met_member_agreement_content" data-plugin="editor" data-editor-x="700"
                hidden></textarea>
            </div>
          </div>
        </dd>
      </dl>
      <dl>
        <dt></dt>
        <dd>
          <button type="submit" class="btn btn-primary">{$word.save}</button>
        </dd>
      </dl>
    </div>
  </form>
</div>