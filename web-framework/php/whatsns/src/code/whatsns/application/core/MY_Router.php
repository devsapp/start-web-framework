<?php 
class MY_Router extends CI_Router {
	/**
	 * Set method name
	 *
	 * @param	string	$method	Method name
	 * @return	void
	 */
	public function set_method($method)
	{
		if(strpos($method, '?') !== FALSE){
			
			$method= explode('?', $method)[0];
		}
		$this->method = $method;
	}
}
?>