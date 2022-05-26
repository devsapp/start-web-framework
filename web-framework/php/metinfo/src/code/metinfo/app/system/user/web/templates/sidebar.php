<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$_M['config']['own_active']=array(
    '0_1'=>$_M['config']['app_no']==0&&$_M['config']['own_order']==1?'active':'',
    '0_2'=>$_M['config']['app_no']==0&&$_M['config']['own_order']==2?'active':''
);
?>
<include file="sys/user/web/templates/style"/>
<div class="col-lg-3">
    <div class='dropdown m-b-15 hidden-lg-up met-sidebar-nav-mobile'>
        <button type="button" class="btn btn-primary btn-block dropdown-toggle met-sidebar-nav-active-name" data-toggle="dropdown"></button>
        <div class="dropdown-menu animate animate-reverse w-full" role="menu">
            <a class="dropdown-item {$_M['config']['own_active']['0_1']}" href="{$_M['url']['profile']}" title="{$_M['word']['memberIndex9']}">{$_M['word']['memberIndex9']}</a>
            <a class="dropdown-item {$_M['config']['own_active']['0_2']}" href="{$_M['url']['profile_safety']}" title="{$_M['word']['accsafe']}">{$_M['word']['accsafe']}</a>
            <tag action="app_column">
            <a class="dropdown-item {$v['active']}" href="{$v['url']}" title="{$v['title']}" {$v['target']}>{$v['title']}</a>
            </tag>
        </div>
    </div>
	<div class="panel row m-r-0 m-b-0 hidden-md-down" boxmh-h>
        <div class="panel-body">
            <h2 class="m-l-30 font-size-18 font-weight-unset">{$_M['word']['memberIndex3']}</h2>
    		<ul class="list-group m-l-15 met-sidebar-nav">
    			<li class="list-group-item {$_M['config']['own_active']['0_1']}"><a href="{$_M['url']['profile']}" title="{$_M['word']['memberIndex9']}">{$_M['word']['memberIndex9']}</a></li>
    			<li class="list-group-item {$_M['config']['own_active']['0_2']}"><a href="{$_M['url']['profile_safety']}" title="{$_M['word']['accsafe']}">{$_M['word']['accsafe']}</a></li>
                <tag action="app_column">
                <li class="list-group-item {$v['active']}"><a href="{$v['url']}" title="{$v['title']}" {$v['target']}>{$v['title']}</a></li>
                </tag>
            </ul>
        </div>
	</div>
</div>