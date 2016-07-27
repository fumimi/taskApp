<?php

namespace App\View;

class View {
	private $_vars;
	function __construct(){
		$this->_vars = array();
	}
	//値のセット
	public function setValue($key, $value ){
		$this->_vars[$key] = $value;
	}
	//値の取得
	public function getValue( $key ){
		return $this->_vars[$key];
	}
	//レンダリング
	public function render($file)
	{
		ob_start();
		include $file;
		return ob_get_clean();
	}
}
