<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$head_add_none=$head_column_none=$foot_save_no=1;
$search_right=1;
?>
<include file="pub/content_list/head"/>
				<include file="pub/content_list/checkall_all"/>
				<th width="70">{$word.messageID}</th>
				<th data-table-columnclass="text-center" width="100">{$word.memberName}</th>
				<th data-table-columnclass="text-center" width="100">{$word.messageTel}</th>
				<th data-table-columnclass="text-center" width="100">
					<select name="search_type" data-table-search class="form-control w-a d-inline-block">
						<option value="0">{$word.smstips64}</option>
						<option value="1">{$word.feedbackClass2}</option>
						<option value="2">{$word.feedbackClass3}</option>
					</select>
				</th>
				<th data-table-columnclass="text-center" width="100">Email</th>
				<th data-table-columnclass="text-center" width="140">
					<select name="checkok" data-table-search class="form-control w-a d-inline-block">
						<option value="">{$word.linkCheck}</option>
						<option value="1">{$word.yes}</option>
						<option value="0">{$word.no}</option>
					</select>
				</th>
				<th data-table-columnclass="text-center" width="130">{$word.cvAddtime}</th>
				<th data-table-columnclass="text-center" width="50">{$word.access}</th>
				<th width="200">{$word.operate}</th>
			</tr>
		</thead>
		<tbody>
			<?php $colspan=10; ?>
			<include file="pub/content_list/table_loader"/>
		</tbody>
		<?php
		$colspan=9;
		?>
		<include file="pub/content_list/tfoot_common"/>
				</th>
			</tr>
		</tfoot>
	</table>
	<input type="hidden" name="class1" value="{$data.class1}" data-table-search="#message-list">
</form>