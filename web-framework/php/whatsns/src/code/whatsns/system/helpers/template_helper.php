<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

function parse_template($tplfile, $objfile) {
	$nest = 5;

	if (! @$fp = fopen ( $tplfile, 'r' )) {
		exit ( "当前模板 '$tplfile'不存在!" );
	}

	$template = fread ( $fp, filesize ( $tplfile ) );
	fclose ( $fp );

	$var_regexp = "((\\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)(\[[a-zA-Z0-9_\-\.\"\'\[\]\$\x7f-\xff]+\])*)";
	$const_regexp = "([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)";

	$template = preg_replace ( "/([\n\r]+)\t+/s", "\\1", $template );
	$template = preg_replace ( "/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $template );

	$template = str_replace ( "{LF}", "<?=\"\\n\"?>", $template );

    $template = preg_replace_callback("/\{(\\\$[a-zA-Z0-9_\[\]\'\"\$\.\x7f-\xff]+)\}/s",

      function ($matches)
	{
		return "<?=$matches[1]?>";
	}
    , $template)
	;
    $template = preg_replace_callback("/$var_regexp/",
    function ($matches)
	{
		return addquote ( "<?=$matches[1]?>" );
	}

    , $template)
	;
    $template = preg_replace_callback("/\<\?\=\<\?\=$var_regexp\?\>\?\>/",
 function ($matches)
	{
		return addquote ( "<?=$matches[1]?>" );
	}
    , $template)
	;

    $template = preg_replace_callback("/\{url\s+(.+?)\}/",

      function ($matches)
	{
		return url ( $matches [1] );
	}
    , $template)
	;

	$template = "<? if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>\n$template";

	$template = preg_replace ( "/[\n\r\t]*\{template\s+([a-z0-9_]+)\}[\n\r\t]*/is", "\n<? include template('\\1'); ?>\n", $template );
	$template = preg_replace ( "/[\n\r\t]*\{template\s+(.+?)\}[\n\r\t]*/is", "\n<? include template(\\1); ?>\n", $template );

    $template = preg_replace_callback("/[\n\r\t]*\{eval\s+(.+?)\}[\n\r\t]*/",

        function ($matches)
	{
		return stripvtags ( "<? $matches[1] ?>", '' );

	}
    , $template)
	;



    $template = preg_replace_callback("/[\n\r\t]*\{echo\s+(.+?)\}[\n\r\t]*/",


        function ($matches)
	{
		return stripvtags ( "\n<? echo $matches[1]; ?>\n", '' );
	}
    , $template)
	;

    $template = preg_replace_callback("/[\n\r\t]*\{elseif\s+(.+?)\}[\n\r\t]*/",

        function ($matches)
	{
		return stripvtags ( "<? } elseif($matches[1]) { ?>", '' );
	}
    , $template)
	;

	$template = preg_replace ( "/[\n\r\t]*\{else\}[\n\r\t]*/is", "<? } else { ?>", $template );

	for($i = 0; $i < $nest; $i ++) {
   	$template = preg_replace_callback("/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\}[\n\r\t]*/is",     function ($matches)
		{

			return stripvtags ( '<? if(is_array(' . $matches [1] . ')) foreach(' . $matches [1] . ' as ' . $matches [2] . ') { ?>' );

		}, $template)
		;

		$template = preg_replace_callback("/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}[\n\r\t]*/is",      function ($matches)
		{
			return stripvtags ( '<? if(is_array(' . $matches [1] . ')) foreach(' . $matches [1] . ' as ' . $matches [2] . ' => ' . $matches [3] . ') { ?>' );
		}, $template)
		;
		$template = preg_replace ( "/\{\/loop\}/i", "<? } ?>", $template );
		 $template = preg_replace_callback("/[\n\r\t]*\{if\s+(.+?)\}[\n\r]*(.+?)[\n\r]*\{\/if\}[\n\r\t]*/is",
        function ($matches)
		{
			return stripvtags ( "<? if($matches[1]) { ?>", "$matches[2]<? } ?>" );
		}

        , $template)
		;
	}

	$template = preg_replace ( "/\{$const_regexp\}/s", "<?=\\1?>", $template );
	$template = preg_replace ( "/ \?\>[\n\r]*\<\? /s", " ", $template );

	if (! @$fp = fopen ( $objfile, 'w' )) {
		exit ( "Directory './data/view/' not found or have no access!" );
	}

      $template = preg_replace_callback("/\"(http)?[\w\.\/:]+\?[^\"]+?&[^\"]+?\"/",
    function ($matches)
	{
		return transamp ( "$matches[1]" );
	}

    , $template)
	;
    $template = preg_replace_callback("/\<script[^\>]*?src=\"(.+?)\".*?\>\s*\<\/script\>/",
  function ($matches)
	{
		return stripscriptamp ( "$matches[1]" );
	}

    , $template)
	;
	$template= str_replace('<?=', '<?php echo ', $template);
	$template= str_replace('<? ', '<?php ', $template);
	flock ( $fp, 2 );
	fwrite ( $fp, $template );
	fclose ( $fp );
}

function transamp($str) {
	$str = str_replace ( '&', '&amp;', $str );
	$str = str_replace ( '&amp;amp;', '&amp;', $str );
	$str = str_replace ( '\"', '"', $str );
	return $str;
}

function addquote($var) {
	return str_replace ( "\\\"", "\"", preg_replace ( "/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var ) );
}

function stripvtags($expr, $statement='') {
	$expr = str_replace ( "\\\"", "\"", preg_replace ( "/\<\?\=(\\\$.+?)\?\>/s", "\\1", $expr ) );
	$statement = str_replace ( "\\\"", "\"", $statement );
	return $expr . $statement;
}
function stripblock($var, $s) {
	$s = preg_replace ( "/<\?=\\\$(.+?)\?>/", "{\$\\1}", $s );
	preg_match_all ( "/<\?=(.+?)\?>/", $s, $constary );
	$constadd = '';
	$constary [1] = array_unique ( $constary [1] );
	foreach ( $constary [1] as $const ) {
		$constadd .= '$__' . $const . ' = ' . $const . ';';
	}
	$s = preg_replace ( "/<\?=(.+?)\?>/", "{\$__\\1}", $s );
	$s = str_replace ( '?>', "\n\$$var .= <<<EOF\n", $s );
	$s = str_replace ( '<?', "\nEOF;\n", $s );
	$s = str_replace ( "\nphp ", "\n", $s );
	return "<?\n$constadd\$$var = <<<EOF\n" . $s . "\nEOF;\n?>";
}

function stripscriptamp($s) {
	$s = str_replace ( '&amp;', '&', $s );
	return "<script src=\"$s\" type=\"text/javascript\"></script>";
}

?>