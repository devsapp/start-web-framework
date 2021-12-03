
<div class="standing">
	<div class="positions bb" id="rankScroll">
		<h3 class="title" style="float: none">站内公告</h3>
		<ul style="padding-top: 10px;">
			<!--{eval $notelist=$this->fromcache('notelist');}-->
			<!--{loop $notelist $nindex $rightnote}-->
			<li class="no-video"><a
				{if $rightnote['url']}href="{$rightnote['url']}"
				{else}href="{url note/view/$rightnote['id']}"
				{/if} title="{$rightnote['title']}">{$rightnote['title']}</a>
				<div class="num-ask">
					<a {if $rightnote['url']}href="{$rightnote['url']}"
						{else}href="{url note/view/$rightnote['id']}"
						{/if} title="{$rightnote['title']}" class="anum">
						{$rightnote['comments']} 个评论</a>
				</div></li>
			<!--{/loop}-->


		</ul>
	</div>
</div>