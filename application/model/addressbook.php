<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Addressbook extends ApplicationModel {
	
	function Addressbook() {
	
		$this->schema = array(
		'folder_id'=>array('カテゴリ', 'notnull', 'numeric', 'except'=>array('search')),
		'addressbook_type'=>array('分類', 'notnull', 'numeric', 'except'=>array('search')),
		'addressbook_name'=>array('名前', 'length:100'),
		'addressbook_ruby'=>array('かな', 'length:100'),
		'addressbook_company'=>array('会社名', 'length:100'),
		'addressbook_companyruby'=>array('会社名(かな)', 'length:100'),
		'addressbook_department'=>array('部署', 'length:1000'),
		'addressbook_position'=>array('役職', 'length:1000'),
		'addressbook_postcode'=>array('郵便番号', 'length:8'),
		'addressbook_address'=>array('住所', 'length:1000'),
		'addressbook_addressruby'=>array('住所(かな)', 'length:1000'),
		'addressbook_phone'=>array('電話番号', 'length:20'),
		'addressbook_fax'=>array('FAX', 'length:20'),
		'addressbook_mobile'=>array('携帯電話', 'length:20'),
		'addressbook_email'=>array('メールアドレス', 'length:1000'),
		'addressbook_url'=>array('URL', 'length:1000'),
		'addressbook_comment'=>array('備考', 'length:10000', 'line:100'),
		'addressbook_parent'=>array('会社情報ID', 'numeric', 'except'=>array('search')),
		'public_level'=>array('except'=>array('search')),
		'public_group'=>array('except'=>array('search')),
		'public_user'=>array('except'=>array('search')),
		'edit_level'=>array('except'=>array('search')),
		'edit_group'=>array('except'=>array('search')),
		'edit_user'=>array('except'=>array('search')));
		if ($_POST['addressbook_type'] == 1) {
			$this->schema['addressbook_company'][] = 'notnull';
		} else {
			$this->schema['addressbook_name'][] = 'notnull';
		}
	
	}
	
	function index($type = 0) {
		
		$hash = $this->permitCategory('addressbook', $_GET['folder']);
		$this->where[] = $this->folderWhere($hash['folder']);
		$this->where[] = "(addressbook_type = ".intval($type).")";
		$hash += $this->permitList('id', 1);
		return $hash;
	
	}

	function view() {
	
		$hash['data'] = $this->permitFind();
		$hash += $this->permitCategory('addressbook', $hash['data']['folder_id']);
		if ($hash['data']['addressbook_parent'] > 0) {
			$field = implode(',', $this->schematize());
			$data = $this->fetchOne("SELECT ".$field." FROM ".$this->table." WHERE id = ".intval($hash['data']['addressbook_parent']));
			if (!$this->permitted($data, 'public')) {
				$hash['data']['addressbook_parent'] = '';
			}
		}
		$hash += $this->findUser($hash['data']);
		return $hash;

	}
	
	function add($redirect = 'index.php') {
		
		if ($_SERVER['REQUEST_METHOD'] != 'POST' && $_GET['id'] > 0) {
			$hash['data'] = $this->permitFind();
			$hash += $this->permitCategory('addressbook', $hash['data']['folder_id'], 'add');
		} else {
			$hash = $this->permitCategory('addressbook', $_POST['folder_id'], 'add');
			$hash['data'] = $this->permitInsert($redirect.$this->parameter(array('folder'=>$_POST['folder_id'])));
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}
	
	function edit($redirect = 'index.php') {
	
		$hash['data'] = $this->permitFind('edit');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$hash += $this->permitCategory('addressbook', $_POST['folder_id'], 'add');
			$hash['data'] = $this->permitUpdate($redirect.$this->parameter(array('folder'=>$_POST['folder_id'])));
		} else {
			$hash += $this->permitCategory('addressbook', $hash['data']['folder_id'], 'add');
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}
	
	function delete($redirect = 'index.php') {
	
		$hash['data'] = $this->permitFind('edit');
		$hash += $this->permitCategory('addressbook', $hash['data']['folder_id'], 'add');
		$this->deletePost();
		$this->redirect($redirect.$this->parameter(array('folder'=>$hash['data']['folder_id'])));
		$hash += $this->findUser($hash['data']);
		return $hash;

	}
	
	function company() {
		
		return $this->index(1);
	
	}

	function companyview() {
	
		return $this->view();

	}
	
	function companyadd() {
		
		return $this->add('company.php');
	
	}

	function companyedit() {
	
		return $this->edit('company.php');
	
	}

	function companydelete() {
	
		return $this->delete('company.php');

	}
	
	function companylist() {
		
		$hash = $this->permitCategory('addressbook');
		$this->where[] = $this->folderWhere($hash['folder']);
		$this->where[] = "(addressbook_type = 1)";
		$this->where[] = $this->permitWhere();
		$_REQUEST['limit'] = 50;
		$hash = $this->findLimit('addressbook_company', 0, array('addressbook_company'));
		return $hash;
		
	}

	function postcode() {
	
		$postcode = new Postcode;
		$hash['list'] = $postcode->feed();
		$this->error = $postcode->error;
		return $hash;
	
	}
	
	function csv() {
		
		if ($_GET['type'] == 1) {
			$field = array('addressbook_company'=>'会社名',
			'addressbook_companyruby'=>'会社名(かな)',
			'addressbook_department'=>'部署',
			'addressbook_postcode'=>'郵便番号',
			'addressbook_address'=>'住所',
			'addressbook_addressruby'=>'住所(かな)',
			'addressbook_phone'=>'電話番号',
			'addressbook_fax'=>'FAX',
			'addressbook_email'=>'メールアドレス',
			'addressbook_url'=>'URL',
			'addressbook_comment'=>'備考');
		} else {
			$field = array('addressbook_name'=>'名前',
			'addressbook_ruby'=>'かな',
			'addressbook_postcode'=>'郵便番号',
			'addressbook_address'=>'住所',
			'addressbook_addressruby'=>'住所(かな)',
			'addressbook_phone'=>'電話番号',
			'addressbook_fax'=>'FAX',
			'addressbook_mobile'=>'携帯電話',
			'addressbook_email'=>'メールアドレス',
			'addressbook_company'=>'会社名',
			'addressbook_companyruby'=>'会社名(かな)',
			'addressbook_department'=>'部署',
			'addressbook_position'=>'役職',
			'addressbook_url'=>'URL',
			'addressbook_comment'=>'備考');
		}
		$hash = $this->permitCategory('addressbook', $_GET['folder']);
		$where[] = $this->folderWhere($hash['folder']);
		$where[] = "(addressbook_type = ".intval($_GET['type']).")";
		$where[] = $this->permitWhere();
		$searchWhere = $this->searchWhere();
		if (strlen($searchWhere) > 0) {
			$where[] = $searchWhere;
		}
		$string = implode(',', array_keys($field));
		$query = "SELECT ".$string." FROM ".$this->table." WHERE ".implode(" AND ", $where);
		if (isset($_REQUEST['sort']) && strlen($_REQUEST['sort']) > 0) {
			$query .= " ORDER BY ".$this->quote($_REQUEST['sort']);
		} else {
			$query .= " ORDER BY id";
		}
		if (!isset($_REQUEST['desc']) || $_REQUEST['desc'] > 0) {
			$query .= " DESC";
		}
		$array = $this->fetchAll($query);
		if (is_array($array) && count($array) > 0) {
			$csv = '"'.implode('","', $field).'"'."\n";
			foreach ($array as $row) {
				foreach ($row as $key => $value) {
					$row[$key] = str_replace('"', '""', $value);
				}
				$csv .= '"'.implode('","', $row).'"'."\n";
			}
			header('Content-Disposition: attachment; filename=addressbook'.date('Ymd').'.csv');
			header('Content-Type: application/octet-stream; name=addressbook'.date('Ymd').'.csv');
			if (stristr($_SERVER['HTTP_USER_AGENT'], 'win')) {
				echo mb_convert_encoding($csv, 'SJIS', 'UTF-8');
			} else {
				echo $csv;
			}
			exit();
		} else {
			$this->died('データが見つかりません。');
		}
		
	}

}

?>