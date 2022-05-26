<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<list data="$data['columnlist']" name="$v" num="500">
<if value="$v['p']['value'] neq ''">
<if value="$v['c']">
<div class="dropdown dropright dropdown-submenu">
	<a href="javascript:;" class="dropdown-item px-3 dropdown-toggle" onClick="dropdownMenuPosition(this)" data-toggle="dropdown">{$v.p.name}</a>
	<div class="dropdown-menu">
		<list data="$v['c']" name="$w" num="500">
		<if value="$w['n']['value'] neq ''">
		<if value="$w['a']">
		<div class="dropdown dropdown-submenu">
			<a href="javascript:;" class="dropdown-item px-3 dropdown-toggle" onClick="dropdownMenuPosition(this)" data-toggle="dropdown">{$w.n.name}</a>
			<div class="dropdown-menu">
				<list data="$w['a']" name="$x" num="500">
				<if value="$x['s']['value'] neq ''">
				<a href="javascript:;" class="dropdown-item px-3" table-delete data-submit_type="{$submit_type}" data-val="{$v.p.value}-{$w.n.value}-{$x.s.value}">{$x.s.name}</a>
				</if>
				</list>
			</div>
		</div>
		<else/>
		<a href="javascript:;" class="dropdown-item px-3" table-delete data-submit_type="{$submit_type}" data-val="{$v.p.value}-{$w.n.value}">{$w.n.name}</a>
		</if>
		</if>
		</list>
	</div>
</div>
<else/>
<a href="javascript:;" class="dropdown-item px-3" table-delete data-submit_type="{$submit_type}" data-val="{$v.p.value}">{$v.p.name}</a>
</if>
</if>
</list>