<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$lang_name=$_M['user']['langok'][$_M['lang']]['name'];
?>
<include file="pub/content_list/tfoot_common"/>
					<div class="dropup navbar p-0 d-inline-block">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{$word.modistauts}</button>
						<div class="dropdown-menu contentlist-change-status">
							<if value="$data['module'] neq 'job'">
							<a href="javascript:;" class="dropdown-item" table-delete data-submit_type="comok">{$word.recom}</a>
							<a href="javascript:;" class="dropdown-item" table-delete data-submit_type="comno">{$word.unrecom}</a>
							<div class="dropdown-divider"></div>
							</if>
							<a href="javascript:;" class="dropdown-item" table-delete data-submit_type="topok">{$word.top}</a>
							<a href="javascript:;" class="dropdown-item" table-delete data-submit_type="topno">{$word.untop}</a>
							<div class="dropdown-divider"></div>
							<a href="javascript:;" class="dropdown-item" table-delete data-submit_type="displayok">{$word.displaytype}</a>
							<a href="javascript:;" class="dropdown-item" table-delete data-submit_type="displayno">{$word.displaytype2}</a>
						</div>
					</div>
					<if value="$data['module'] neq 'job'">
					<div class="dropup d-inline-block">
						<button type="button" class="btn btn-default dropdown-toggle" onClick="dropdownMenuPosition(this)" data-toggle="dropdown" data-submenu>{$word.columnmove1}</button>
						<div class="dropdown-menu contentlist-move">
							<div class="dropdown-header font-weight-normal">{$word.admin_movetocolumn_v6}</div>
							<div class="dropdown-divider"></div>
							<?php $submit_type='move'; ?>
							<include file="pub/content_list/columnlist_dropdown"/>
						</div>
					</div>
					<div class="dropup d-inline-block">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-submenu>{$word.Copy}</button>
						<div class="dropdown-menu contentlist-copy-langlist">
							<div class="dropdown-header font-weight-normal">{$word.copyotherlang6}</div>
							<div class="dropdown-divider"></div>
							<list data="$_M['user']['langok']" name="$v">
							<a href="javascript:;" class="dropdown-item px-3" data-val="{$v.mark}">{$v.name}</a>
							</list>
						</div>
					</div>
					<div class="dropup d-inline-block hide contentlist-copy-list">
						<button type="button" class="btn btn-default dropdown-toggle" onClick="dropdownMenuPosition(this)" data-toggle="dropdown" data-submenu>{$word.admin_copytocolumn_v6}</button>
						<div class="dropdown-menu contentlist-copy">
						</div>
					</div>
					<input type="hidden" name="tolang" value="{$_M['lang']}">
					<input type="hidden" name="module" value="{$data.module}">
					</if>
				</th>
			</tr>
		</tfoot>
	</table>
</form>