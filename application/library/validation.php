<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Validation {
	
	function notnull($field, $caption) {
	
		if (strlen($_POST[$field]) <= 0) {
			return $caption.'を入力してください。';
		}
		
	}
	
	function length($field, $caption, $min = 0, $max = 0) {
		
		if ($max <= 0) {
			$max = $min;
			$min = 0;
		}
		if ($min > 0 && (mb_strlen($_POST[$field], 'UTF-8') < $min || mb_strlen($_POST[$field], 'UTF-8') > $max)) {
			return $caption.'は'.$min.'文字以上'.$max.'文字以下で入力してください。';
		} elseif (strlen($_POST[$field]) > $max) {
			return $caption.'は'.$max.'文字以下で入力してください。';
		}
		
	}
	
	function line($field, $caption, $max = 0) {
	
		if (substr_count($_POST[$field], "\n") > $max) {
			return $caption.'は'.$max.'行以下で入力してください。';
		}
		
	}
	
	function numeric($field, $caption) {
	
		if (!preg_match('/^[0-9]*$/', $_POST[$field])) {
			return $caption.'は半角数字で入力してください。';
		}
		
	}
	
	function alpha($field, $caption) {
	
		if (!preg_match('/^[a-zA-Z]*$/', $_POST[$field])) {
			return $caption.'は半角英字で入力してください。';
		}
		
	}
	
	function alphaNumeric($field, $caption) {
	
		if (!preg_match('/^[a-zA-Z0-9]*$/', $_POST[$field])) {
			return $caption.'は半角英数字で入力してください。';
		}
		
	}
	
	function userid($field, $caption) {
	
		if (!preg_match('/^[-_\.a-zA-Z0-9]*$/', $_POST[$field])) {
			return $caption.'は半角英数字、-(ハイフン)、_(アンダーバー)、.(ドット)で入力してください。';
		}
		
	}
	
	function postcode($field, $caption) {
	
		if (!preg_match('/^[-0-9]*$/', $_POST[$field])) {
			return $caption.'は半角数字、-(ハイフン)で入力してください。';
		}
		
	}
	
	function phone($field, $caption) {
	
		if (!preg_match('/^[-0-9]*$/', $_POST[$field])) {
			return $caption.'は半角数字、-(ハイフン)で入力してください。';
		}
		
	}
	
	function email($field, $caption) {
	
		if (strlen($_POST[$field]) > 0 && !preg_match('/^[-_a-zA-Z0-9\.!#$%&()=\^~<>?]+@[-_a-zA-Z0-9\.!#$%&()=\^~<>?]+\.[a-zA-Z]+$/', $_POST[$field])) {
			return $caption.'の値が正しくありません。';
		}
		
	}
	
	function url($field, $caption) {
	
		if (strlen($_POST[$field]) > 0 && !preg_match('/^(https?):\/\/[-_a-zA-Z0-9.!~*\'();\/?:@&=+$,%#]+$/', $_POST[$field])) {
			return $caption.'の値が正しくありません。';
		}
		
	}
	
	function notsymbol($field, $caption) {
	
		if (preg_match('/[!#\$%&\?"\'~|`=+*<>\^@:;\/\\\(\)\[\]\{\}]+/', $_POST[$field])) {
			return $caption.'に使用できない記号が含まれます。';
		}
		
	}
	
	function pregmatch($field, $caption, $pattern) {
	
		if (strlen($_POST[$field]) > 0 && !preg_match($pattern, $_POST[$field])) {
			return $caption.'の値が無効です。';
		}
		
	}
	
	function range($field, $caption, $min = 0, $max = 0) {
	
		if ($_POST[$field] < $min || $_POST[$field] > $max) {
			return $caption.'は'.$min.'以上'.$max.'以下で入力してください。';
		}
		
	}

}
?>