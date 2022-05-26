<!--{template header}-->
<link rel="stylesheet" media="all"
	href="{SITE_URL}static/css/bianping/css/login.css" />
<!--内容部分--->
<div class="sign">

<div class="main"></div>

</div>

<script>

	function success(result) {
		if (result.code == 200) {
			var datalist = JSON.parse(result.data);
			console.log(result.data)
		} else {
			alert(result.msg)
		}
		console.log(JSON.stringify(result))

	}
	//{SITE_URL}/app/?user/center
	// var url="{SITE_URL}/app/?query/xuanshang";
	ajaxpost("{SITE_URL}/app/?query/getzhuanjiabycid", {
		accesstoken : localStorage.getItem('accesstoken')
	}, success);
</script>
<!--{template footer}-->