<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-safe-set">
  <form method="POST" action="{$url.own_name}c=index&a=doSaveSetup" class="info-form" data-submit-ajax="1"
    id="safe-form" data-validate_order="#safe-form">
    <div class="metadmin-fmbx">
      <h3 class="example-title">{$word.safety_efficiency}</h3>
      <dl>
        <dt>
          <label class="form-control-label">{$word.setimgrename}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="checkbox" data-plugin="switchery" name="met_img_rename" value="0" />
            <span class="text-help ml-2">{$word.setimgrename1}，{$word.setimgrename2}</span>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class='form-control-label'>{$word.disableCssJs}</label>
        </dt>
        <dd>
          <div class='form-group clearfix'>
            <input type="checkbox" data-plugin="switchery" name="disable_cssjs" value='0' >
            <span class="text-help ml-2">{$word.disableCssJsTips}</span>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.admin_log}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="checkbox" data-plugin="switchery" name="met_logs" value="0" />

          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.access_type}</label>
        </dt>
        <dd>
         <div class="form-group clearfix">
            <div class="custom-control custom-radio ">
                <input type="radio" id="access_type1" name="access_type" value="1" class="custom-control-input" data-checked="{$c['access_type']}">
                <label class="custom-control-label" for="access_type1">{$word.access_type1}</label>
            </div>
            <div class="custom-control custom-radio ">
                <input type="radio" id="access_type2" name="access_type" value="2" class="custom-control-input">
                <label class="custom-control-label" for="access_type2">{$word.access_type2}</label>
            </div>
        </div>
        </dd>
      </dl>
        <h3 class="example-title">{$word.video_switch}<span class="text-help ml-2 font-size-14 font-weight-normal">{$word.auto_play_tips}</span></h3>
        <dl>
            <dt>
                <label class="form-control-label">{$word.auto_play_pc}</label>
            </dt>
            <dd>
                <div class="form-group clearfix">
                    <input type="checkbox" data-plugin="switchery" name="met_auto_play_pc" value="0"/>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class="form-control-label">{$word.auto_play_mobile}</label>
            </dt>
            <dd>
                <div class="form-group clearfix">
                    <input type="checkbox" data-plugin="switchery" name="met_auto_play_mobile" value="0"/>
                </div>
            </dd>
        </dl>
      <div class="delete-file" style="display: none;">
        <h3 class="example-title">{$word.unitytxt_69}<span class="text-help ml-2 font-size-14 font-weight-normal">{$word.setsafeupdate1}</span></h3>
        <dl>
          <dt>
            <label class="form-control-label">{$word.setsafeinstall}</label>
          </dt>
          <dd>
            <div class="form-group clearfix">
              <button class="btn btn-primary btn-delete">{$word.delete}</button>
            </div>
          </dd>
        </dl>
      </div>
      <div class="hide">
          <!--后台目录-->
          <h3 class="example-title">{$word.setsafeadminname1c}{$site_admin}</h3>
          <dl>
              <dt>
                  <label class="form-control-label">{$word.setsafeadminname}</label>
              </dt>
              <dd>
                  <div class="form-group clearfix">
                      <input type="text" name="met_adminfile" class="form-control" />
                  </div>
              </dd>
          </dl>
      </div>
      <h3 class="example-title">{$word.logincode}</h3>
      <dl>
        <dt>
          <label class="form-control-label">{$word.setsafeadmin}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="checkbox" data-plugin="switchery" name="met_login_code" value="0" />
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.setsafemember}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="checkbox" data-plugin="switchery" name="met_memberlogin_code" value="0" />
            <span class="text-help ml-2">{$word.upfiletips24}</span>
          </div>
        </dd>
      </dl>
      <h3 class="example-title">{$word.fdincSlash}</h3>
      <dl>
        <dt>
          <label class="form-control-label">{$word.fdincSlash}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <textarea name="met_fd_word" type="text" rows="5" class="form-control mr-2"></textarea>
            <span class="text-help ml-2">{$word.setbasicTip5}</span>
          </div>
        </dd>
      </dl>
      <h3 class="example-title">{$word.unitytxt_70}</h3>
      <dl>
        <dt>
          <label class="form-control-label">{$word.setbasicUploadMax}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <input type="text" name="met_file_maxsize" class="form-control w-auto" />
            <span class="text-help ml-2">{$word.systips15}</span>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>
          <label class="form-control-label">{$word.setbasicEnableFormat}</label>
        </dt>
        <dd>
          <div class="form-group clearfix">
            <textarea name="met_file_format" type="text" rows="5" class="form-control mr-2"></textarea>
            <span class="text-help ml-2">{$word.setbasicTip5}</span>
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