<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Timecard extends ApplicationModel {
	
	function Timecard() {
		
		$this->table = DB_PREFIX.'timecard';
		$this->schema = array(
		'timecard_year'=>array(),
		'timecard_month'=>array(),
		'timecard_day'=>array(),
		'timecard_date'=>array(),
		'timecard_open'=>array(),
		'timecard_close'=>array(),
		'timecard_interval'=>array(),
		'timecard_originalopen'=>array(),
		'timecard_originalclose'=>array(),
		'timecard_originalinterval'=>array(),
		'timecard_time'=>array(),
		'timecard_timeinterval'=>array(),
		'timecard_comment'=>array());
		if ($_GET['year'] > 1900 && $_GET['year'] <= 3000) {
			$_GET['year'] = intval($_GET['year']);
		} else {
			$_GET['year'] = date('Y');
		}
		if ($_GET['month'] > 0 && $_GET['month'] <= 12) {
			$_GET['month'] = intval($_GET['month']);
		} else {
			$_GET['month'] = date('n');
		}
		if ($_GET['day'] > 0 && $_GET['day'] <= 31) {
			$_GET['day'] = intval($_GET['day']);
		} else {
			$_GET['day'] = date('j');
		}
		
	}
	
	function index() {
	
		$hash = $this->findOwner($_GET['member']);
		$this->add();
		$field = implode(',', $this->schematize());
		$query = sprintf("SELECT %s FROM %s WHERE (timecard_year = %d) AND (timecard_month = %d) AND (owner = '%s') ORDER BY timecard_date", $field, $this->table, $_GET['year'], $_GET['month'], $this->quote($hash['owner']['userid']));
		$hash['list'] = $this->fetchAll($query);
		if ($_GET['recalculate'] == 1 && $_SERVER['REQUEST_METHOD'] != 'POST') {
			$hash['list'] = $this->recalculate($hash['list']);
		}
		$config = new Config($this->handler);
		$hash['config'] = $config->configure('timecard');
		return $hash;
	
	}
	
	function add() {
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$data = $this->findRecord();
			$time = date('G:i');
			if (isset($_POST['timecard_open']) && !$data && !$data['timecard_open']) {
				$this->post['timecard_year'] = date('Y');
				$this->post['timecard_month'] = date('n');
				$this->post['timecard_day'] = date('j');
				$this->post['timecard_date'] = date('Y-m-d');
				$this->post['timecard_originalopen'] = $time;
				$this->post['timecard_open'] = $time;
				$this->insertPost();
			} elseif ($data['timecard_open'] && !$data['timecard_close']) {
				if (isset($_POST['timecard_interval'])) {
					if ($data['timecard_interval']) {
						if (preg_match('/.*-[0-9]+:[0-9]+$/', $data['timecard_interval'])) {
							$time = ' '.$time;
						} elseif (preg_match('/.*[0-9]+:[0-9]+$/', $data['timecard_interval'])) {
							$time = '-'.$time;
						}
					}
					$this->post['timecard_originalinterval'] = trim($data['timecard_originalinterval'].$time);
					$this->post['timecard_interval'] = $data['timecard_interval'].$time;
				} elseif (isset($_POST['timecard_close'])) {
					$this->post['timecard_originalclose'] = $time;
					$this->post['timecard_close'] = $time;
					$this->post += $this->sum($data['timecard_open'], $this->post['timecard_close'], $data['timecard_interval']);
				}
				$this->record($this->post);
			}
		}
	
	}

	function edit() {
	
		$hash['data'] = $this->findRecord($_GET['year'], $_GET['month'], $_GET['day']);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->validator('timecard_comment', '内容', array('length:10000', 'line:100'));
			$this->post['timecard_open'] = $this->validatetime($_POST['openhour'], $_POST['openminute']);
			$this->post['timecard_close'] = $this->validatetime($_POST['closehour'], $_POST['closeminute']);
			$array = array();
			if (is_array($_POST['intervalopenhour']) && count($_POST['intervalopenhour']) > 0) {
				for ($i = 0; $i < count($_POST['intervalopenhour']); $i++) {
					$open = $this->validatetime($_POST['intervalopenhour'][$i], $_POST['intervalopenminute'][$i]);
					$close = $this->validatetime($_POST['intervalclosehour'][$i], $_POST['intervalcloseminute'][$i]);
					if (strlen($open) > 0 && strlen($close) > 0) {
						$array[] = $open.'-'.$close;
					}
				}
			}
			$this->post['timecard_interval'] = implode(' ', $array);
			if (strlen($this->post['timecard_close']) > 0) {
				$array = $this->sum($this->post['timecard_open'], $this->post['timecard_close'], $this->post['timecard_interval']);
				$this->post['timecard_time'] = $array['timecard_time'];
				$this->post['timecard_timeinterval'] = $array['timecard_timeinterval'];
			} else {
				$this->post['timecard_time'] = '';
				$this->post['timecard_timeinterval'] = '';
			}
			$this->post['editor'] = $_SESSION['userid'];
			$this->post['updated'] = date('Y-m-d H:i:s');
			if (is_array($hash['data']) && $hash['data']['id'] > 0 && count($this->error) <= 0) {
				$this->record($this->post, $_GET['year'], $_GET['month'], $_GET['day']);
			} else {
				if (!$this->post['timecard_open']) {
					$this->error[] = '出社時間を入力してください。';
				}
				$this->schema += array('editor'=>'', 'updated'=>'');
				$this->post['timecard_year'] = $_GET['year'];
				$this->post['timecard_month'] = $_GET['month'];
				$this->post['timecard_day'] = $_GET['day'];
				$this->post['timecard_date'] = date('Y-m-d', mktime(0, 0, 0, $_GET['month'], $_GET['day'], $_GET['year']));
				$this->insertPost();
			}
			$this->redirect('index.php?year='.$_GET['year'].'&month='.$_GET['month']);
			$hash['data'] = $this->post;
		}
		return $hash;
	
	}

	function record($data, $year = null, $month = null, $day = null) {
		
		if (is_array($data) && count($data) > 0) {
			if (isset($year) && isset($month) && isset($day)) {
				$date = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
			} else {
				$date = date('Y-m-d');
			}
			foreach ($data as $key => $value) {
				$array[] = $key." = '".$this->quote($value)."'";
			}
			$query = sprintf("UPDATE %s SET %s WHERE (timecard_date = '%s') AND (owner = '%s')", $this->table, implode(",", $array), $date, $this->quote($_SESSION['userid']));
			$this->response = $this->query($query);
			return $this->response;
		}
		
	}

	function sum($open, $close, $interval = '') {
		
		$open = $this->minute($open);
		$close = $this->minute($close);
		$config = new Config($this->handler);
		$status = $config->configure('timecard');
		$status['open'] = intval($status['openhour']) * 60 + intval($status['openminute']);
		if ($open < $status['open']) {
			$open = $status['open'];
		}
		$status['close'] = intval($status['closehour']) * 60 + intval($status['closeminute']);
		if ($status['close'] > 0 && $close > $status['close']) {
			$close = $status['close'];
		}
		if ($status['timeround'] == 1) {
			$open = ceil($open / 10) * 10;
			$close = floor($close / 10) * 10;
		}
		$status['lunchopen'] = intval($status['lunchopenhour']) * 60 + intval($status['lunchopenminute']);
		$status['lunchclose'] = intval($status['lunchclosehour']) * 60 + intval($status['lunchcloseminute']);
		if ($status['intervalround'] == 1) {
			$status['lunchopen'] = floor($status['lunchopen'] / 10) * 10;
			$status['lunchclose'] = ceil($status['lunchclose'] / 10) * 10;
		}
		$intervalsum = 0;
		if (strlen($interval) > 0) {
			$array = explode(' ', $interval);
			if (is_array($array) && count($array) > 0) {
				foreach ($array as $key => $value) {
					list($intervalopen, $intervalclose) = explode('-', $value);
					$intervalopen = $this->minute($intervalopen);
					$intervalclose = $this->minute($intervalclose);
					if ($status['intervalround'] == 1) {
						$intervalopen = floor($intervalopen / 10) * 10;
						$intervalclose = ceil($intervalclose / 10) * 10;
					}
					if ($intervalclose <= $status['lunchopen'] || $intervalopen >= $status['lunchclose']) {
						if ($intervalopen < $intervalclose) {
							$intervalsum += $intervalclose - $intervalopen;
						}
					} else {
						if ($intervalopen < $status['lunchopen']) {
							$status['lunchopen'] = $intervalopen;
						}
						if ($intervalclose > $status['lunchclose']) {
							$status['lunchclose'] = $intervalclose;
						}
					}
				}
			}
		}
		if ($status['lunchopen'] < $status['lunchclose']) {
			$intervalsum += $status['lunchclose'] - $status['lunchopen'];
		}
		$sum = $close - $open - $intervalsum;
		if ($sum < 0) {
			$sum = 0;
		}
		$result['timecard_time'] = sprintf('%d:%02d', (($sum - ($sum % 60)) / 60), ($sum % 60));
		$result['timecard_timeinterval'] = sprintf('%d:%02d', (($intervalsum - ($intervalsum % 60)) / 60), ($intervalsum % 60));
		return $result;
		
	}

	function minute($time) {
		
		$array = explode(':', $time);
		return intval($array[0]) * 60 + intval($array[1]);
		
	}
	
	function findRecord($year = null, $month = null, $day = null) {
		
		if (isset($year) && isset($month) && isset($day)) {
			$date = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
		} else {
			$date = date('Y-m-d');
		}
		$field = implode(',', $this->schematize());
		$query = sprintf("SELECT %s FROM %s WHERE (timecard_date = '%s') AND (owner = '%s')", $field, $this->table, $date, $this->quote($_SESSION['userid']));
		return $this->fetchOne($query);
	
	}
	
	function validatetime($hour, $minute) {
		
		if (strlen($hour) > 0 && strlen($minute) > 0 && $hour >= 0 && $hour < 24 && $minute >= 0 && $minute < 60) {
			return sprintf('%d:%02d', intval($hour), intval($minute));
		}
		
	}
	
	function recalculate($data) {
		
		if (is_array($data) && count($data) > 0) {
			$this->response = true;
			foreach ($data as $key => $row) {
				if (strlen($row['timecard_close']) > 0) {
					$array = $this->sum($row['timecard_open'], $row['timecard_close'], $row['timecard_interval']);
					$this->record($array, $row['timecard_year'], $row['timecard_month'], $row['timecard_day']);
					$data[$key]['timecard_time'] = $array['timecard_time'];
					$data[$key]['timecard_timeinterval'] = $array['timecard_timeinterval'];
				}
			}
			if ($this->response) {
				$this->error[] = '勤務時間と外出時間の再計算結果を保存しました。';
			} else {
				$this->died('勤務時間と外出時間の再計算に失敗しました。');
			}
		}
		return $data;
		
	}
	
	function config() {
		
		$this->authorize('administrator');
		$config = new Config($this->handler);
		$hash['data'] = $config->edit('timecard');
		$this->error = $config->error;
		return $hash;
		
	}
	
	function csv() {
	
		$field = implode(',', $this->schematize());
		$query = sprintf("SELECT %s FROM %s WHERE (timecard_year = %d) AND (timecard_month = %d) AND (owner = '%s') ORDER BY timecard_date", $field, $this->table, $_GET['year'], $_GET['month'], $this->quote($_SESSION['userid']));
		$list = $this->fetchAll($query);
		if (is_array($list) && count($list) > 0) {
			$csv = $_GET['year'].'年'.$_GET['month'].'月'."\n";
			$csv .= '"日付","出社","外出","退社","勤務時間","外出時間","備考"'."\n";
			$timestamp = mktime(0, 0, 0, $_GET['month'], 1, $_GET['year']);
			$lastday = date('t', $timestamp);
			$weekday = date('w', $timestamp);
			$week = array('日', '月', '火', '水', '木', '金', '土');
			foreach ($list as $row) {
				$data[$row['timecard_day']] = $row;
			}
			$sum = 0;
			for ($i = 1; $i <= $lastday; $i++) {
				if (strlen($data[$i]['timecard_time']) > 0) {
					$array = explode(':', $data[$i]['timecard_time']);
					$sum += intval($array[0]) * 60 + intval($array[1]);
				}
				$csv .= '"'.$i.'('.$week[$weekday].')","';
				$csv .= $data[$i]['timecard_open'].'","';
				$csv .= $data[$i]['timecard_interval'].'","';
				$csv .= $data[$i]['timecard_close'].'","';
				$csv .= $data[$i]['timecard_time'].'","';
				$csv .= $data[$i]['timecard_timeinterval'].'","';
				$csv .= $data[$i]['timecard_comment'].'"'."\n";
				$weekday = ($weekday + 1) % 7;
			}
			$csv .= '"勤務時間合計","'.sprintf('%d:%02d', (($sum - ($sum % 60)) / 60), ($sum % 60)).'"'."\n";
			header('Content-Disposition: attachment; filename=timecard'.date('Ymd').'.csv');
			header('Content-Type: application/octet-stream; name=timecard'.date('Ymd').'.csv');
			echo mb_convert_encoding($csv, 'SJIS', 'UTF-8');
			exit();
		} else {
			$this->died('データが見つかりません。');
		}
		
	}
	
	function group() {
	
		$this->authorize('administrator', 'manager');
		if ($_GET['group'] <= 0) {
			$_GET['group'] = $_SESSION['group'];
		}
		$data = $this->fetchAll("SELECT userid, realname FROM ".DB_PREFIX."user WHERE user_group = ".intval($_GET['group'])." ORDER BY user_order,id");
		$hash['user'] = array();
		if (is_array($data) && count($data) > 0) {
			foreach ($data as $row) {
				$hash['user'][$row['userid']] = $row['realname'];
			}
			$user = implode("','", array_keys($hash['user']));
			$field = implode(',', $this->schematize());
			$query = sprintf("SELECT %s FROM %s WHERE (timecard_year = %d) AND (timecard_month = %d) AND (owner IN ('%s')) ORDER BY timecard_date", $field, $this->table, $_GET['year'], $_GET['month'], $user);
			$hash['list'] = $this->fetchAll($query);
		}
		$hash['group'] = $this->findGroup();
		$config = new Config($this->handler);
		$hash['config'] = $config->configure('timecard');
		return $hash;
	
	}
	
	function findOwner($owner) {
		
		if (strlen($owner) > 0) {
			$this->authorize('administrator', 'manager');
			$result = $this->fetchOne("SELECT userid, realname, user_group FROM ".DB_PREFIX."user WHERE userid = '".$this->quote($owner)."'");
			if (count($result) <= 0) {
				$this->died('選択されたユーザーは存在しません。');
			}
		} else {
			$result['userid'] = $_SESSION['userid'];
			$result['realname'] = $_SESSION['realname'];
			$result['user_group'] = $_SESSION['group'];
		}
		$data = $this->fetchAll("SELECT userid, realname FROM ".DB_PREFIX."user WHERE user_group = ".intval($result['user_group'])." ORDER BY user_order,id");
		$user = array();
		if (is_array($data) && count($data) > 0) {
			foreach ($data as $row) {
				$user[$row['userid']] = $row['realname'];
			}
		}
		return array('owner'=>$result, 'user'=>$user);
		
	}

}

?>