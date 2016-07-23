<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Postcode {
	
	var $codefile = DB_POSTCODE;
	var $error = array();
	
	function feed() {
	
		if (file_exists($this->codefile)) {
			if (isset($_REQUEST['postcode']) && strlen($_REQUEST['postcode']) >= 3) {
				$result = $this->code();
			} elseif (isset($_REQUEST['address']) && strlen($_REQUEST['address']) >= 3) {
				$result = $this->address();
			} else {
				$this->error[] = '検索文字列が短すぎます。';
			}
		} else {
			$this->error[] = 'データファイルの取得に失敗しました。';
		}
		return $result;
	
	}
	
	function code() {
	
		if (preg_match('/^[0-9\-]+$/', $_REQUEST['postcode'])){
			$postcode = str_replace('-', '', $_REQUEST['postcode']);
			$codelist = array();
			if ($file = @fopen($this->codefile, "r")) {
				flock($file, LOCK_SH);
				while (!feof($file)) {
					$row = fgets($file, 1000);
					if (stristr($row, $postcode)) {
						$codelist[] = $row;
					}
				}
				flock($file, LOCK_UN);
				fclose($file);
			} else {
				$this->error[] = 'データファイルのオープンに失敗しました。';
			}
			$result = array();
			if (is_array($codelist) && count($codelist) > 0) {
				foreach ($codelist as $value) {
					$data = explode(',', $value);
					$datacode = str_replace(array('"', ' '), '', $data[2]);
					if (preg_match('/^'.$postcode.'/', $datacode)) {
						$array = array();
						$array[0] = $datacode;
						$array[1] = $this->encode($data[6].$data[7].$data[8]);
						$array[2] = $this->encode($data[3].$data[4].$data[5]);
						$result[] = $array;
						if (count($result) >= 50) {
							break;
						}
					}
				}
			}
			return $result;
		} else {
			$this->error[] = '郵便番号は半角数字と-(ハイフン)で入力してください。';
		}
	
	}
	
	function address() {
	
		if(!preg_match('/[-_a-zA-Z0-9!#\$%&\?"\'~|`=+*<>\^@:;\/\\\(\)\[\]\{\}]+/', $_REQUEST['address'])){
			$address = mb_convert_encoding($_REQUEST['address'], 'SJIS', 'UTF-8');
			$codelist = array();
			if ($file = @fopen($this->codefile, "r")) {
				flock($file, LOCK_SH);
				while (!feof($file)) {
					$row = fgets($file, 1000);
					$string = str_replace('","', '', $row);
					if (stristr($string, $address)) {
						$codelist[] = $row;
					}
				}
				flock($file, LOCK_UN);
				fclose($file);
			} else {
				$this->error[] = 'データファイルのオープンに失敗しました。';
			}
			$result = array();
			if (is_array($codelist) && count($codelist) > 0) {
				foreach ($codelist as $value) {
					$data = explode(',', $value);
					$dataaddress = str_replace(array('"', ' '), '', $data[6].$data[7].$data[8]);
					if (stristr($dataaddress, $address)) {
						$array = array();
						$array[0] = $this->encode($data[2]);
						$array[1] = $this->encode($dataaddress);
						$array[2] = $this->encode($data[3].$data[4].$data[5]);
						$result[] = $array;
						if (count($result) >= 50) {
							break;
						}
					}
				}
			}
			return $result;
		} else {
			$this->error[] = '住所は全角で入力してください。';
		}
		
	}
	
	function encode($string) {
	
		$string = str_replace(array('"', ' '), '', $string);
		$string = mb_convert_encoding($string, 'UTF-8', 'SJIS');
		$string = mb_convert_kana($string, 'HcV', 'UTF-8');
		return $string;
			
	}

}

?>