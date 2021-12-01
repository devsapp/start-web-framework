
<form method="POST" action="{$url.own_name}c=admin_user&a=doAddUser" class="user-add-form" data-submit-ajax='1'>
	<div class="metadmin-fmbx">
		<dl>
			<dt>
				<label class="form-control-label">{$word.loginusename}</label>
			</dt>
			<dd>
				<div class="form-group clearfix">
					<input type="text" name="username" class="form-control" autocomplete="new-password" data-fv-remote="true"
					data-fv-remote-url="{$url.own_name}c=admin_user&a=doCheckUsername">
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class="form-control-label">{$word.loginpassword}</label>
			</dt>
			<dd>
				<div class="form-group clearfix">
					<input type="password" name="password" class="form-control" required autocomplete="new-password"/>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class="form-control-label">{$word.admintips5}</label>
			</dt>
			<dd>
				<div class="form-group clearfix">
					<select name="groupid" class="form-control d-inline-block w-a ">
					</select>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class="form-control-label">{$word.memberCheck}</label>
			</dt>
			<dd>
				<div class="form-group clearfix">
            <select name="valid" class="form-control d-inline-block w-a ">
                <option value="1">{$word.yes}</option>
                <option value="0">{$word.no}</option>
              </select>
				</div>
			</dd>
		</dl>
		<dl>
			<button type="submit" hidden class="btn"></button>
		</dl>
	</div>
</form>
