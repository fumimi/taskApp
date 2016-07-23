<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Bookmark extends ApplicationModel {
	
	function Bookmark() {
	
		$this->schema = array(
		'folder_id'=>array('カテゴリ', 'notnull', 'numeric', 'except'=>array('search')),
		'bookmark_title'=>array('タイトル', 'notnull', 'length:1000'),
		'bookmark_url'=>array('URL', 'notnull', 'url', 'length:1000'),
		'bookmark_name'=>array('fix'=>$_SESSION['realname']),
		'bookmark_date'=>array('fix'=>date('Y-m-d H:i:s'), 'except'=>array('search', 'update')),
		'bookmark_comment'=>array('備考', 'length:10000', 'line:100'),
		'bookmark_order'=>array('順序', 'numeric', 'length:10', 'except'=>array('search')),
		'public_level'=>array('except'=>array('search')),
		'public_group'=>array('except'=>array('search')),
		'public_user'=>array('except'=>array('search')),
		'edit_level'=>array('except'=>array('search')),
		'edit_group'=>array('except'=>array('search')),
		'edit_user'=>array('except'=>array('search')));
	
	}
	
	function index() {
		
		$hash = $this->permitCategory('bookmark', $_GET['folder']);
		$this->where[] = $this->folderWhere($hash['folder']);
		$hash += $this->permitList('bookmark_order, bookmark_date', 1);
		return $hash;
	
	}

	function view() {
	
		$hash['data'] = $this->permitFind();
		$hash += $this->permitCategory('bookmark', $hash['data']['folder_id']);
		$hash += $this->findUser($hash['data']);
		return $hash;

	}
	
	function add() {
		
		$hash = $this->permitCategory('bookmark', $_POST['folder_id'], 'add');
		$hash['data'] = $this->permitInsert('index.php'.$this->parameter(array('folder'=>$_POST['folder_id'])));
		if ($_SERVER['REQUEST_METHOD'] != 'POST' && strlen($_GET['url']) > 0) {
			if (preg_match('/^(https?):\/\/[-_a-zA-Z0-9.!~*\'();\/?:@&=+$,%#]+$/', $_GET['url'])) {
				$hash['data']['bookmark_url'] = $_GET['url'];
				if ($document = @file_get_contents($_GET['url'])) {
					$document = mb_convert_encoding($document, 'UTF-8', 'UTF-8, SJIS, EUC-JP');
					preg_match('/<title>(.+)<\/title>/i', $document, $matches);
					if (strlen($matches[1]) > 0) {
						$hash['data']['bookmark_title'] = $matches[1];
					}
				}
			} else {
				$this->error[] = 'URLが無効です。';
			}
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}
	
	function edit() {
	
		$hash['data'] = $this->permitFind('edit');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$hash += $this->permitCategory('bookmark', $_POST['folder_id'], 'add');
			$hash['data'] = $this->permitUpdate('index.php'.$this->parameter(array('folder'=>$_POST['folder_id'])));
		} else {
			$hash += $this->permitCategory('bookmark', $hash['data']['folder_id'], 'add');
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}
	
	function delete() {
	
		$hash['data'] = $this->permitFind('edit');
		$hash += $this->permitCategory('bookmark', $hash['data']['folder_id'], 'add');
		$this->deletePost();
		$this->redirect('index.php'.$this->parameter(array('folder'=>$hash['data']['folder_id'])));
		$hash += $this->findUser($hash['data']);
		return $hash;

	}

}

?>