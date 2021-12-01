<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<div class="met-myapp metadmin-content-min">
  <if value="$c['met_agents_metmsg']">
  <div class="met-myapp-right position-relative float-right">
  </div>
  </if>
  <div class="search d-flex align-items-end justify-content-between mb-3">
    <div class="alert alert-primary mb-0">{$word.installCondition}</div>
    <div class="input-group">
      <input type="search" name="keyword" placeholder="{$word.search}" class="form-control">
      <div class="input-group-append">
        <div class="input-group-text btn bg-none px-2"><i class="input-search-icon fa-search" aria-hidden="true"></i></div>
      </div>
    </div>
  </div>
  <div class="met-myapp-list row px-2"></div>
  <div class="app-detail"></div>
</div>