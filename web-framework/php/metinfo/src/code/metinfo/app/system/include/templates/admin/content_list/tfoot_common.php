<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$del_title=$del_title?$del_title:$word['delete_information'];
?>
<include file="pub/content_list/tfoot_first"/>
<button type="button" class="btn btn-default"<if value="$del_type">data-plugin="webuiPopover" data-webuipopover-component="table-del" data-placement="top"<else/>table-delete data-plugin="alertify" data-type='confirm' data-confirm-title='{$del_title}'</if>>{$word.delete}</button>