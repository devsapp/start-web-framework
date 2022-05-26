<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<form action="{$url.own_name}c=news&a=donews_del" data-submit-ajax='1' data-submited="1">
    <table class="table table-hover dataTable w-100" id="sysnews-list" data-ajaxurl="{$url.own_name}c=news&a=donews_list" data-datatable_order="#sysnews-list">
        <thead>
            <tr>
                <th>{$word.loginmetinfo} {$word.upfiletips37}</th>
                <th data-table-columnclass="text-center text-muted">{$word.statips27}</th>
            </tr>
        </thead>
    	<tbody>
            <?php $colspan=2; ?>
            <include file="pub/content_list/table_loader"/>
    	</tbody>
    	<tfoot>
            <tr>
    			<th colspan="2" data-no_column_defs>
    				<button type="button" data-plugin="alertify" data-type="confirm" class="btn btn-primary">{$word.All_empty_message}</button>
    			</th>
            </tr>
        </tfoot>
    </table>
</form>