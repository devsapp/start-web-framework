<?php defined('IN_MET') or exit('No permission'); ?>
<tag action='message.list' num="$c['met_message_list']">
<li class="list-group-item">
	<div class="media">
		<div class="media-left block pull-xs-left p-r-0">
			<i class="icon wb-user-circle blue-grey-400"></i>
		</div>
		<div class="media-body block pull-xs-left">
			<h4 class="media-heading font-weight-300 blue-grey-500">
				<small class="pull-xs-right">{$v.addtime}</small>
				{$v.name}
			</h4>
			<p class='m-b-0'>{$v.content}</p>
			<div class="content well m-t-10 m-b-0"><if value="$v['useinfo']">{$v.useinfo}<else/>{$v.met_fd_content}</if></div>
		</div>
	</div>
</li>
</tag>