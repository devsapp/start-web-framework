<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$colspan=2;
?>
<div class="my-3 met-copyright-package">
    <input type="hidden" name="version" value="{$data.handle.package_info.package}">
    <table class="table dtr-inline table-bordered">
        <include file="pub/content_list/table_loader"/>
    </table>
</div>