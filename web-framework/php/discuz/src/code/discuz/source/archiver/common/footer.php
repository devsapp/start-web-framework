<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
?>
<br />
<center>
	<?php echo adshow('footerbanner//1').adshow('footerbanner//2').adshow('footerbanner//3'); ?>
	<div id="footer">
		Powered by <strong><a target="_blank" href="http://www.discuz.net">Discuz! <?php echo $_G['setting']['version']; ?> Archiver</a></strong> &nbsp; Copyright &copy 2001-2021, Tencent Cloud.
		<br />
		<br />
	</div>
</center>
</body>
</html>
<?php output(); ?>