<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$license_data=$data['handle'];
?>
<table class="table table-hover">
    <tbody>
		<tr>
            <td>
				<a href="https://www.metinfo.cn/metinfo/license.html" title="{$word.metinfo}最终用户授权许可协议" target="_blank">{$word.metinfo}最终用户授权许可协议</a>
            </td>
		</tr>
		<tr>
			<th>开源代码许可协议</th>
		</tr>
        <list data="$license_data">
        <tr>
            <td>
                <a href="javascript:;" <if value="substr($val['name'],-1) neq '/'">data-url="{$val.license_url}"</if>>{$val.name}</a>
            </td>
        </tr>
        </list>
    </tbody>
</table>