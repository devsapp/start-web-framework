<!--<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');
foreach($paralist as $val){
	//$wr_ok = $val['wr_ok']?'data-required="1"':'';
	$wr_ok ='';
	$value = $val['value'];
	if($val['type']==1){
echo <<<EOT
-->
		<dl>
			<dt>{$val['name']}</dt>
			<dd class="ftype_input">
				<div class="fbox">
					<input type="text" name="para-{$val['id']}" value="{$value}" {$wr_ok} />
				</div>
				<span class="tips">{$val['description']}</span>
			</dd>
		</dl>
<!--
EOT;
	}
	if($val['type']==2){
echo <<<EOT
-->
		<dl>
			<dt>{$val['name']}</dt>
			<dd class="ftype_select">
				<div class="fbox">
					<select name="para-{$val['id']}" data-checked="{$value}" {$wr_ok}>
						<option value="">{$_M['word']['please_choose']}</option>
<!--
EOT;
		foreach($val['list'] as $option){
			if($option){
				if($module == 10){
					$para_value = $option['value'];
				}else{
					$para_value = $option['id'];
				}
echo <<<EOT
-->
						<option value="{$para_value}">{$option['value']}</option>
<!--
EOT;
			}
		}
echo <<<EOT
-->
					</select>
				</div>
				<span class="tips">{$val['description']}</span>
			</dd>
		</dl>
<!--
EOT;
	}
	if($val['type']==3){
echo <<<EOT
-->
		<dl>
			<dt>{$val['name']}</dt>
			<dd class="ftype_textarea">
				<div class="fbox">
					<textarea name="para-{$val['id']}" {$wr_ok}>{$value}</textarea>
				</div>
				<span class="tips">{$val['description']}</span>
			</dd>
		</dl>
<!--
EOT;
	}
	if($val['type']==4){
echo <<<EOT
-->
		<dl>
			<dt>{$val['name']}</dt>
			<dd class="ftype_checkbox">
				<div class="fbox">
<!--
EOT;
        $check = "data-checked=\"".str_replace(array('#@met@#',','), '|', $value)."\"";
		foreach($val['list'] as $option){
			if($option){
				if($module == 10){
					##$para_value = $option['value'];
                    $para_value = $option['id'];
				}else{
					$para_value = $option['id'];
				}
echo <<<EOT
-->
					<label><input name="para-{$val['id']}" type="checkbox" value="{$para_value}" {$wr_ok} {$check}>{$option['value']}</label>
<!--
EOT;
				$wr_ok='';
				$check='';
			}
		}
echo <<<EOT
-->
				</div>
				<span class="tips">{$val['description']}</span>
			</dd>
		</dl>
<!--
EOT;
	}
	if($val['type']==5){
echo <<<EOT
-->
		<dl>
			<dt>{$val['name']}</dt>
			<dd class="ftype_upload">
				<div class="fbox">
					<input
						name="para-{$val['id']}"
						type="text"
						{$wr_ok}
						data-upload-type="doupfile"
						value="{$value}"
					/>
				</div>
				<span class="tips">{$val['description']}</span>
			</dd>
		</dl>
<!--
EOT;
	}
	if($val['type']==6){

echo <<<EOT
-->
		<dl>
			<dt>{$val['name']}</dt>
			<dd class="ftype_radio">
				<div class="fbox">
<!--
EOT;
		$value = $value ? $value : $val['list'][0]['id'];
		$check = "data-checked=\"{$value}\"";
		foreach($val['list'] as $option){
			if($option){
				if($module == 10){
					$para_value = $option['value'];
				}else{
					$para_value = $option['id'];
				}
echo <<<EOT
-->
					<label><input name="para-{$val['id']}" type="radio" value="{$para_value}" {$wr_ok} {$check}>{$option['value']}</label>
<!--
EOT;
				$wr_ok='';
				$check = '';
			}
		}
echo <<<EOT
-->
				</div>
				<span class="tips">{$val['description']}</span>
			</dd>
		</dl>
<!--
EOT;
	}
	if($val['type']==7){
		$prov = $para['info_'.$val['id'].'_1'];
		$city = $para['info_'.$val['id'].'_2'];
		$dist = $para['info_'.$val['id'].'_3'];
echo <<<EOT
-->
		<dl>
			<dt>{$val['name']}</dt>
			<dd class="ftype_select-linkage">
				<div class="fbox">
					<select name="para-{$val['id']}-1" data-checked="{$prov}" class="prov" {$wr_ok}></select>
					<select name="para-{$val['id']}-2" data-checked="{$city}" class="city"></select>
					<select name="para-{$val['id']}-3" data-checked="{$dist}" class="dist"></select>
				</div>
				<span class="tips">{$val['description']}</span>
			</dd>
		</dl>
<!--
EOT;
	}
	if($val['type']==8){
echo <<<EOT
-->
		<dl>
			<dt>{$val['name']}</dt>
			<dd class="ftype_input">
				<div class="fbox">
					<input type="text" name="para-{$val['id']}" value="{$value}" {$wr_ok} />
				</div>
				<span class="tips">{$val['description']}</span>
			</dd>
		</dl>

<!--
EOT;
	}
	if($val['type']==10){
echo <<<EOT
-->
		<dl>
			<dt>{$val['name']}</dt>
			<dd class="ftype_input">
				<div class="fbox">
					<input type="text" name="para-{$val['id']}" value="{$value}" {$wr_ok} />
				</div>
				<span class="tips">{$val['description']}</span>
			</dd>
		</dl>

<!--
EOT;
	}
}
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>