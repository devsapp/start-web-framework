<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
if($data['handle']){
	$data=array_merge($data,$data['handle']);
	unset($data['handle']);
}
$foot_save_no=$head_column_none=$head_add_none=1;
$class_name=$data['module'].'_manage';
$table_order=$data['module'].'-list-'.$data['class1'].'-'.$data['class2'].'-'.$data['class3'];
$search_right=1;
?>
<include file="pub/content_list/head"/>
				<include file="pub/content_list/checkall_all"/>
				<th>
					{$word.cvPosition}<br>
					<select name="jobid" data-table-search class="form-control w-a d-inline-block" value="{$data.jobid}"></select>
				</th>
				<th data-table-columnclass="text-center" width="80">
					<select name="search_type" data-table-search class="form-control w-a d-inline-block">
						<option value="0">{$word.smstips64}</option>
						<option value="1">{$word.unread}</option>
						<option value="2">{$word.read}</option>
					</select>
				</th>
				<list data="$data['showcol']" name="$v">
				<th>
				{$v.name}
				<if value="in_array($v['type'], array(2,6))">
				<select name="para_{$v.id}" data-table-search class="form-control d-inline-block w-a">
					<list data="$v['options']['list']" name="$s">
					<option value="{$s.val}">{$s.name}</option>
					</list>
				</select>
				</if>
				</th>
				</list>
				<th data-table-columnclass="text-center" width="100">{$word.cvAddtime}</th>
				<th width="120">{$word.operate}</th>
			</tr>
		</thead>
		<tbody>
			<?php $colspan=5+count($data['showcol']); ?>
			<include file="pub/content_list/table_loader"/>
		</tbody>
		<input type="hidden" name="class1" value="{$data.class1}" data-table-search="#{$table_order}">
		<?php $colspan--; ?>
		<include file="pub/content_list/tfoot_common"/>
					<div class="float-right">
						<select class="form-control d-inline-block w-a select-job-export">
							<option value="0">{$word.feedbackTip4}</option>
							<option value="1">{$word.feedbackTip5}</option>
						</select>
						<a href="{$url.own_name}c={$class_name}&a=doexportList&class1={$data.class1}&class2={$data.class2}&class3={$data.class3}" data-href="{$url.own_name}c={$class_name}&a=doexportList&class1={$data.class1}&class2={$data.class2}&class3={$data.class3}" class="btn btn-primary btn-job-export">{$word.feedbackTip2}</a>
					</div>
				</th>
			</tr>
		</tfoot>
	</table>
	<input type="hidden" name="class1" value="{$data.class1}" data-table-search="#{$table_order}">
	<input type="hidden" name="class2" value="{$data.class2}" data-table-search="#{$table_order}">
	<input type="hidden" name="class3" value="{$data.class3}" data-table-search="#{$table_order}">
</form>