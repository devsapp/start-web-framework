<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
$data=array_merge($data,$data['handle']);
unset($data['handle']);
?>
<p>{$word.system_check1}</p>
<fieldset class="border pb-3 px-3">
    <legend class="h6 text-primary w-auto px-1"><strong>{$word.system_check2}</strong></legend>
    <div class="row mb-0">
        <list data="$data['data']" name="$v">
        <div class='col-6 my-1'>{$v.0}<span class="float-right text-{$v.1}">{$v.2}</span></div>
        </list>
    </div>
</fieldset>
<fieldset class="border pb-3 px-3 mt-3">
    <legend class="h6 text-primary w-auto ml-2 px-1"><strong>{$word.system_check3}</strong></legend>
    <p style="text-indent:2em" class="mb-2">{$word.system_check4}</p>
    <p style="text-indent:2em">{$word.system_check5}</p>
    <div class="row mb-0"">
        <list data="$data['dirs']" name="$v">
        <?php $thisurl=explode('..',$v['dir']); ?>
        <div class='col-6 my-1'>{$thisurl.1}<span class="float-right text-{$v.status}">{$v.msg}</span></div>
        </list>
    </div>
</fieldset>