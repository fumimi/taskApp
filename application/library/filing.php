<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Filing {

	function puts($file, $string, $mode = 'w') {
		
		$pointer = @fopen($file, $mode);
		if (!$pointer) {
 			$pointer = fopen($file, 'w');
		}
		if ($pointer) {
			stream_set_write_buffer($pointer, 0);
			if (flock($pointer, LOCK_EX)) {
				rewind($pointer);
				fputs($pointer, $string);
				flock($pointer, LOCK_UN);
			}
			fclose($pointer);
		}
	
	}

	function parsecsv($file) {
		
		$array = array();
		$pointer = @fopen($file, 'r');
		if ($pointer) {
			if (flock($pointer, LOCK_SH)) {
				while ($row = fgetcsv($pointer, 10000, ',')) {
					$array[] = $row;
				}
				flock($pointer, LOCK_UN);
			}
			fclose($pointer);
		}
		return $array;
	
	}

	function filelist($directory) {
		
		$array = array();
		if (is_dir($directory)) {
			if ($handle = opendir($directory)) {
				while (($file = readdir($handle)) !== false) {
					if ($file != '.' && $file != '..') {
						$array[] = $file;
					}
				}
				closedir($handle);
			}
		}
		return $array;
	
	}

	function delete($array, $directory = '') {
		
		$result = true;
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $value) {
				if (file_exists($directory.$value)) {
					$result = @unlink($directory.$value);
				}
			}
		}
		return $result;
	
	}
	
	function attachment($file, $filename = '') {
	
		if (file_exists($file)) {
			if (strlen($filename) <= 0) {
				$filename = basename($file);
				if (stristr(PHP_OS, 'win')) {
					$filename = mb_convert_encoding($filename, 'UTF-8', 'UTF-8, SJIS');
				}
			}
			if (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
				$filename = mb_convert_encoding($filename, 'SJIS', 'UTF-8');
				header('Cache-Control: public');
				header('Pragma: public');
			}
			$filesize = filesize($file);
			header('Content-Disposition: attachment; filename='.$filename);
			header('Content-Type: application/octet-stream; name='.$filename);
			header('Content-Length: '.$filesize);
			@readfile($file);
			exit();
		}
	
	}
	
	function image($file, $filename = '') {
	
		if (file_exists($file)) {
			if (strlen($filename) <= 0) {
				$filename = basename($file);
			}
			$filesize = filesize($file);
			if (preg_match('/.+\.(jpeg|jpg)$/', $file)) {
				$type = 'jpeg';
			} elseif (preg_match('/.+\.(gif)$/', $file)) {
				$type = 'gif';
			} elseif (preg_match('/.+\.(png)$/', $file)) {
				$type = 'png';
			} else {
				die('ファイルの種類を取得できません。');
			}
			header('Content-type: image/'.$type);
			header('Content-Disposition: inline; filename='.$filename);
			header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
			header('Last-Modified: '. gmdate('D, d M Y H:i:s'). ' GMT');
			header('Cache-Control: no-cache, must-revalidate');
			header('Pragma: no-cache');
			header('Content-Length: '.$filesize);
			@readfile($file);
			exit();
		}
		
	}
	
	function exportcsv($array, $filename) {
	
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $row) {
				if (is_array($row) && count($row) > 0) {
					foreach ($row as $key => $value) {
						$row[$key] = str_replace('"', '""', $value);
					}
					$string .= '"'.implode('","', $row).'"';
				}
				$string .= "\n";
			}
			header('Content-Disposition: attachment; filename='.$filename);
			header('Content-Type: application/octet-stream; name='.$filename);
			if (stristr($_SERVER['HTTP_USER_AGENT'], 'win')) {
				echo mb_convert_encoding($string, 'SJIS', 'UTF-8');
			} else {
				echo $string;
			}
			exit();
		}
	
	}
	
	function rss($channelTitle, $channelLink, $channelDescription, $items) {
	
		$string = '<?xml version="1.0" encoding="UTF-8" ?>';
		$string .= '<rss version="2.0"><channel>';
		$string .= '<title>'.$channelTitle.'</title><link>'.$channelLink.'</link>';
		$string .= '<description>'.$channelDescription.'</description><language>ja</language>';
		foreach ($items as $row) {
			$row['description'] = str_replace(array("\r\n","\r","\n"), '<br />', $row['description']);
			$string .= '<item><title>'.$row['title'].'</title><link>'.$row['link'].'</link>';
			$string .= '<description><![CDATA['.$row['description'].']]></description>';
			$string .= '<pubDate>'.date('r', strtotime($row['pubDate'])).'</pubDate></item>';
		}
		$string .= '</channel></rss>';
		return $string;
	
	}

}
?>