<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
if ( ! function_exists('clearlinkref'))
{
	function clearlinkref($content){
		$cansetlink=true; //默认可以设置外链不传权重，如果改成false就可以传权重 --true改成false
		if(!$cansetlink){
			return $content;
		}
		if (! function_exists ( 'file_get_html' )) {
			require_once (BASEPATH . 'helpers/simple_html_dom_helper.php');
		}
		$html = str_get_html ( $content );
		$ret = $html->find ( 'a' );
		
		$reltxt='<span class="link-tips" title="本链接加了nofollow, 不传递权重。" data-toggle="tooltip" data-placement="right" title="" data-original-title="本链接加了nofollow, 不传递权重。">[?]</span>';
		foreach ( $ret as $a ) {
			if (is_outer ( $a->href )) {
				
				//if(strstr($a->plaintext ,'http://')||strstr($a->plaintext ,'https://')||strstr($a->plaintext ,'.com')){
				$a->ref="nofollow";
				$a->outertext = $a->outertext.$reltxt;
				
				//	}
				
			}
		}
		$content = $html->save();
		$html->clear ();
		
		return $content;
	}
}