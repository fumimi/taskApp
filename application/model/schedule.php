<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Schedule extends ApplicationModel {
	
	function Schedule() {
	
		$this->schema = array(
		'schedule_type'=>array('分類', 'notnull', 'numeric'),
		'schedule_title'=>array('タイトル', 'notnull', 'length:1000'),
		'schedule_name'=>array('fix'=>$_SESSION['realname']),
		'schedule_comment'=>array('内容', 'length:10000', 'line:100'),
		'schedule_year'=>array('年', 'numeric', 'range:1900:2100'),
		'schedule_month'=>array('月', 'numeric', 'range:1:12'),
		'schedule_day'=>array('日', 'numeric', 'range:1:31'),
		'schedule_time'=>array(),
		'schedule_endtime'=>array(),
		'schedule_date'=>array(),
		'schedule_allday'=>array('終日', 'numeric'),
		'schedule_repeat'=>array('繰り返し設定', 'alpha'),
		'schedule_everyweek'=>array('繰り返し設定(毎週)', 'numeric', 'range:0:6'),
		'schedule_everymonth'=>array('繰り返し設定(毎月)', 'alphaNumeric'),
		'schedule_begin'=>array(),
		'schedule_end'=>array(),
		'schedule_facility'=>array('場所', 'numeric'),
		'schedule_level'=>array('except'=>array('search')),
		'schedule_group'=>array('except'=>array('search')),
		'schedule_user'=>array('except'=>array('search')),
		'public_level'=>array('except'=>array('search')),
		'public_group'=>array('except'=>array('search')),
		'public_user'=>array('except'=>array('search')),
		'edit_level'=>array('except'=>array('search')),
		'edit_group'=>array('except'=>array('search')),
		'edit_user'=>array('except'=>array('search')));
		if ($_GET['year'] <= 0) {
			$_GET['year'] = date('Y');
		} else {
			$_GET['year'] = intval($_GET['year']);
		}
		if ($_GET['month'] <= 0) {
			$_GET['month'] = date('n');
		} else {
			$_GET['month'] = intval($_GET['month']);
		}
		if ($_GET['day'] <= 0) {
			$_GET['day'] = date('j');
		} else {
			$_GET['day'] = intval($_GET['day']);
		}
		
	}
	
	function validate() {
		
		if ($_POST['beginhour'] > 23 || $_POST['beginminute'] > 50 || $_POST['endhour'] > 23 || $_POST['endminute'] > 50) {
			$this->error[] = '時間設定が無効です。';
		} elseif ($_POST['schedule_allday'] != 1 && ($_POST['beginhour'] * 60 + $_POST['beginminute']) >= ($_POST['endhour'] * 60 + $_POST['endminute'])) {
			$this->error[] = '終了時間は開始時間より後の時間を指定してください。';
		} else {
			$this->post['schedule_time'] = sprintf('%02d:%02d', intval($_POST['beginhour']), intval($_POST['beginminute']));
			$this->post['schedule_endtime'] = sprintf('%02d:%02d', intval($_POST['endhour']), intval($_POST['endminute']));
		}
		if ($_POST['schedule_type'] == 1) {
			$begin = mktime(0, 0, 0, $_POST['beginmonth'], $_POST['beginday'], $_POST['beginyear']);
			$end = mktime(0, 0, 0, $_POST['endmonth'], $_POST['endday'], $_POST['beginyear']);
			$this->post['schedule_begin'] = date('Y-m-d', $begin);
			$this->post['schedule_end'] = date('Y-m-d', $end);
			if ($begin >= $end) {
				$this->error[] = '終了日は開始日より後の日を指定してください。';
			}
		} else {
			$this->post['schedule_type'] = 0;
			$timestamp = mktime(0, 0, 0, $_POST['schedule_month'], $_POST['schedule_day'], $_POST['schedule_year']);
			$this->post['schedule_year'] = date('Y', $timestamp);
			$this->post['schedule_month'] = date('n', $timestamp);
			$this->post['schedule_day'] = date('j', $timestamp);
			$this->post['schedule_date'] = date('Y-m-d', $timestamp);
		}
		if ($_POST['schedule_facility'] > 0) {
			$this->reserve();
		}
		$this->post['schedule_level'] = intval($_POST['schedule_level']);
		if ($_POST['schedule_level'] == 2) {
			if (count($_POST['schedule']['group']) <= 0 && count($_POST['schedule']['user']) <= 0) {
				$this->error[] = '表示先のグループ・ユーザーを選択してください。';
			} else {
				$this->post['schedule_group'] = $this->permitParse($_POST['schedule']['group']);
				$this->post['schedule_user'] = $this->permitParse($_POST['schedule']['user']);
			}
		} else {
			$this->post['schedule_group'] = '';
			$this->post['schedule_user'] = '';
		}
		if (count($this->error) <= 0) {
			if ($_POST['schedule_type'] == 1) {
				$this->post['schedule_year'] = '';
				$this->post['schedule_month'] = '';
				$this->post['schedule_day'] = '';
				if ($_POST['schedule_repeat'] == 'everyweek') {
					$this->post['schedule_everymonth'] = '';
				} elseif ($_POST['schedule_repeat'] == 'everymonth') {
					$this->post['schedule_everyweek'] = '';
				}
			} else {
				$this->post['schedule_repeat'] = '';
				$this->post['schedule_everymonth'] = '';
				$this->post['schedule_everyweek'] = '';
			}
			if ($_POST['schedule_allday'] == 1) {
				$this->post['schedule_time'] = '';
				$this->post['schedule_endtime'] = '';
			}
		}
	
	}
	
	function scheduleWhere($type = 'month', $data = null) {
	
		if ($type == 'month') {
			$where = "((schedule_type = 0 AND schedule_month = %d AND schedule_year = %d) OR ";
			$where .= "(schedule_type = 1 AND (schedule_begin <= '%04d-%02d-%02d' AND schedule_end >= '%04d-%02d-%02d')))";
			return sprintf($where, $_GET['month'], $_GET['year'], $_GET['year'], $_GET['month'], 31, $_GET['year'], $_GET['month'], 1);
		} elseif ($type == 'week') {
			$weekday = date('w', mktime(0, 0, 0, $_GET['month'], $_GET['day'], $_GET['year']));
			$begin = mktime(0, 0, 0, $_GET['month'], $_GET['day'] - $weekday, $_GET['year']);
			$end = mktime(23, 59, 59, $_GET['month'], $_GET['day'] + 6 - $weekday, $_GET['year']);
			$where = "((schedule_type = 0 AND (schedule_date >= '%s' AND schedule_date <= '%s')) OR ";
			$where .= "(schedule_type = 1 AND (schedule_begin <= '%s' AND schedule_end >= '%s')))";
			return sprintf($where, date('Y-m-d', $begin), date('Y-m-d', $end), date('Y-m-d', $end), date('Y-m-d', $begin));
		} elseif ($type == 'day') {
			$where = "((schedule_type = 0 AND schedule_day = %d AND schedule_month = %d AND schedule_year = %d) OR ";
			$where .= "(schedule_type = 1 AND (schedule_begin <= '%04d-%02d-%02d' AND schedule_end >= '%04d-%02d-%02d')))";
			return sprintf($where, $_GET['day'], $_GET['month'], $_GET['year'], $_GET['year'], $_GET['month'], $_GET['day'], $_GET['year'], $_GET['month'], $_GET['day']);
		} elseif ($type == 'owner') {
			$where = "((schedule_level = 0) OR (schedule_level = 1 AND owner = '%s') OR ";
			$where .= "(schedule_level = 2 AND (schedule_group LIKE '%%[%s]%%' OR schedule_user LIKE '%%[%s]%%')))";
			return sprintf($where, $this->quote($data['userid']), $this->quote($data['user_group']), $this->quote($data['userid']));
		}
		
	
	}
	
	function index() {
	
		$hash['owner'] = $this->findOwner($_GET['member']);
		$this->where[] = $this->scheduleWhere('month');
		$this->where[] = $this->scheduleWhere('owner', $hash['owner']);
		$this->where[] = $this->permitWhere();
		$field = implode(',', $this->schematize());
		$query = sprintf("SELECT %s FROM %s WHERE %s ORDER BY schedule_allday,schedule_time,schedule_endtime", $field, $this->table, implode(" AND ", $this->where));
		$hash['list'] = $this->fetchAll($query);
		$hash['group'] = $this->findGroup();
		return $hash;
	
	}
	
	function view() {
		
		$hash['data'] = $this->permitFind();
		if (strlen($_GET['member']) > 0) {
			$owner = $_GET['member'];
		} elseif ($hash['data']['schedule_level'] == 1) {
			$owner = $hash['data']['owner'];
		} elseif ($hash['data']['schedule_level'] == 2 && !stristr($hash['data']['schedule_group'], '['.$_SESSION['group'].']') && !stristr($hash['data']['schedule_user'], '['.$_SESSION['userid'].']')) {
			if (strlen($hash['data']['schedule_user']) > 0) {
				$array = explode(',', str_replace(array('][', '[', ']'), array(',', '', ''), $hash['data']['schedule_user']));
				$owner = $array[0];
			} elseif (strlen($hash['data']['schedule_group']) > 0) {
				$array = explode(',', str_replace(array('][', '[', ']'), array(',', '', ''), $hash['data']['schedule_group']));
				header('Location:groupday.php'.$this->parameter(array('year'=>$_GET['year'], 'month'=>$_GET['month'], 'day'=>$_GET['day'], 'group'=>$array[0])));
				exit();
			}
		} else {
			$owner = $_SESSION['userid'];
		}
		$hash['owner'] = $this->findOwner($owner);
		$this->where[] = $this->scheduleWhere('day');
		$this->where[] = $this->scheduleWhere('owner', $hash['owner']);
		$this->where[] = $this->permitWhere();
		$field = implode(',', $this->schematize());
		$query = sprintf("SELECT %s FROM %s WHERE %s ORDER BY schedule_allday,schedule_time,schedule_endtime", $field, $this->table, implode(" AND ", $this->where));
		$hash['list'] = $this->fetchAll($query);
		$hash += $this->findUser($hash['data']);
		$hash['facility'] = $this->fetchOne("SELECT folder_caption FROM ".DB_PREFIX."folder WHERE (folder_type = 'facility') AND (folder_id = ".intval($hash['data']['schedule_facility']).")");
		return $hash;

	}
	
	function add() {
		
		$hash = $this->permitCategory('facility', $_POST['facility'], 'add');
		$hash['data'] = $this->permitInsert('index.php'.$this->parameter(array('year'=>$_POST['schedule_year'], 'month'=>$_POST['schedule_month'])));
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}

	function edit() {
	
		$hash['data'] = $this->permitEdit();
		$hash += $this->permitCategory('facility', $_POST['schedule_facility'], 'add');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$hash['data'] = $this->permitUpdate('index.php'.$this->parameter(array('year'=>$_POST['schedule_year'], 'month'=>$_POST['schedule_month'])));
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}

	function delete() {
	
		$hash['data'] = $this->permitEdit();
		$this->deletePost();
		$this->redirect('index.php'.$this->parameter(array('year'=>$hash['data']['schedule_year'], 'month'=>$hash['data']['schedule_month'])));
		$hash += $this->findUser($hash['data']);
		$hash['facility'] = $this->fetchOne("SELECT folder_caption FROM ".DB_PREFIX."folder WHERE (folder_type = 'facility') AND (folder_id = ".intval($hash['data']['schedule_facility']).")");
		return $hash;

	}
	
	function permitEdit() {
		
		$data = $this->permitFind('edit');
		if ($data) {
			if ($this->permitted($data, 'schedule')) {
				return $data;
			} else {
				$this->died('編集する権限がありません。');
			}
		} else {
			$this->died('閲覧する権限がありません。');
		}

	}
	
	function groupweek() {
		
		if ($_REQUEST['group'] > 0) {
			$hash['groupid'] = intval($_REQUEST['group']);
		} else {
			$hash['groupid'] = intval($_SESSION['group']);
		}
		$this->where[] = $this->scheduleWhere('week');
		$data = $this->fetchAll("SELECT userid, realname FROM ".DB_PREFIX."user WHERE user_group = '".$hash['groupid']."' ORDER BY user_order,id");
		$hash['user'] = array();
		if (is_array($data) && count($data) > 0) {
			foreach ($data as $row) {
				$hash['user'][$row['userid']] = $row['realname'];
				$whereUser .= " OR schedule_user LIKE '%[".$this->quote($row['userid'])."]%'";
			}
		}
		$where = "((schedule_level = 0) OR (schedule_level = 1 AND owner IN ('%s')) OR ";
		$where .= "(schedule_level = 2 AND (schedule_group LIKE '%%[%s]%%'%s)))";
		$this->where[] = sprintf($where, implode("','", array_keys($hash['user'])), $hash['groupid'], $whereUser);
		$this->where[] = $this->permitWhere();
		$field = implode(',', $this->schematize());
		$query = sprintf("SELECT %s FROM %s WHERE %s ORDER BY schedule_allday,schedule_time,schedule_endtime", $field, $this->table, implode(" AND ", $this->where));
		$hash['list'] = $this->fetchAll($query);
		$hash['group'] = $this->findGroup();
		return $hash;
		
	}
	
	function groupday() {
		
		if ($_REQUEST['group'] > 0) {
			$hash['groupid'] = intval($_REQUEST['group']);
		} else {
			$hash['groupid'] = intval($_SESSION['group']);
		}
		$data = $this->fetchAll("SELECT userid, realname FROM ".DB_PREFIX."user WHERE user_group = '".$hash['groupid']."' ORDER BY user_order,id");
		$hash['user'] = array();
		if (is_array($data) && count($data) > 0) {
			foreach ($data as $row) {
				$hash['user'][$row['userid']] = $row['realname'];
				$whereUser .= " OR schedule_user LIKE '%[".$this->quote($row['userid'])."]%'";
			}
		}
		$this->where[] = $this->scheduleWhere('day');
		$where = "((schedule_level = 0) OR (schedule_level = 1 AND owner IN ('%s')) OR ";
		$where .= "(schedule_level = 2 AND (schedule_group LIKE '%%[%s]%%'%s)))";
		$this->where[] = sprintf($where, implode("','", array_keys($hash['user'])), $hash['groupid'], $whereUser);
		$this->where[] = $this->permitWhere();
		$field = implode(',', $this->schematize());
		$query = sprintf("SELECT %s FROM %s WHERE %s ORDER BY schedule_allday,schedule_time,schedule_endtime", $field, $this->table, implode(" AND ", $this->where));
		$hash['list'] = $this->fetchAll($query);
		$hash['group'] = $this->findGroup();
		return $hash;
		
	}
	
	function findOwner($owner) {
		
		if (strlen($owner) > 0) {
			$result = $this->fetchOne("SELECT userid, realname, user_group FROM ".DB_PREFIX."user WHERE userid = '".$this->quote($owner)."'");
			if (count($result) <= 0) {
				$this->died('選択されたユーザーは存在しません。');
			}
		} else {
			$result['userid'] = $_SESSION['userid'];
			$result['realname'] = $_SESSION['realname'];
			$result['user_group'] = $_SESSION['group'];
		}
		$data = $this->fetchAll("SELECT userid, realname FROM ".DB_PREFIX."user WHERE user_group = '".intval($result['user_group'])."' ORDER BY user_order,id");
		$result['groupuser'] = array();
		if (is_array($data) && count($data) > 0) {
			foreach ($data as $row) {
				$result['groupuser'][$row['userid']] = $row['realname'];
			}
		}
		return $result;
		
	}
	
	function facilityweek() {
		
		$hash = $this->permitFacility();
		$this->where[] = "(schedule_facility > 0)";
		$this->where[] = $this->scheduleWhere('week');
		$field = implode(',', $this->schematize());
		$query = sprintf("SELECT %s FROM %s WHERE %s ORDER BY schedule_allday,schedule_time,schedule_endtime", $field, $this->table, implode(" AND ", $this->where));
		$hash['list'] = $this->fetchAll($query);
		return $hash;
		
	}
	
	function facilityday() {
		
		$hash = $this->permitFacility();
		$this->where[] = "(schedule_facility > 0)";
		$this->where[] = $this->scheduleWhere('day');
		$field = implode(',', $this->schematize());
		$query = sprintf("SELECT %s FROM %s WHERE %s ORDER BY schedule_allday,schedule_time,schedule_endtime", $field, $this->table, implode(" AND ", $this->where));
		$hash['list'] = $this->fetchAll($query);
		return $hash;
		
	}
	
	function facilitymonth() {
	
		$hash = $this->permitCategory('facility', $_GET['facility']);
		if ($_GET['facility'] > 0) {
			$this->where[] = "(schedule_facility = ".intval($_GET['facility']).")";
			$this->where[] = $this->scheduleWhere('month');
			$field = implode(',', $this->schematize());
			$query = sprintf("SELECT %s FROM %s WHERE %s ORDER BY schedule_allday,schedule_time,schedule_endtime", $field, $this->table, implode(" AND ", $this->where));
			$hash['list'] = $this->fetchAll($query);
		}
		return $hash;
	
	}
	
	function permitFacility() {
		
		$query = sprintf("SELECT * FROM %sfolder WHERE (folder_type = 'facility') AND %s ORDER BY folder_order,folder_name", DB_PREFIX, $this->permitWhere('public'));
		$result['folder'] = $this->fetchAll($query);
		return $result;
		
	}
	
	function initialize() {
		
		$this->authorize('administrator', 'manager', 'editor');
		$this->table = DB_PREFIX.'folder';
		$this->schema = array(
		'folder_type'=>array('fix'=>'facility', 'except'=>array('search', 'update')),
		'folder_id'=>array('except'=>array('search', 'update')),
		'folder_caption'=>array('施設名', 'notnull', 'length:100'),
		'folder_name'=>array('fix'=>$_SESSION['realname']),
		'folder_date'=>array('fix'=>date('Y-m-d H:i:s'), 'except'=>array('search', 'update')),
		'folder_order'=>array('順序', 'numeric', 'except'=>array('search')),
		'add_level'=>array('except'=>array('search')),
		'add_group'=>array('except'=>array('search')),
		'add_user'=>array('except'=>array('search')),
		'public_level'=>array('except'=>array('search')),
		'public_group'=>array('except'=>array('search')),
		'public_user'=>array('except'=>array('search')),
		'edit_level'=>array('except'=>array('search')),
		'edit_group'=>array('except'=>array('search')),
		'edit_user'=>array('except'=>array('search')));
		
	}
	
	function facility() {
		
		$this->initialize();
		$this->where[] = "(folder_type = 'facility')";
		$hash = $this->permitList('folder_order, folder_id', 0);
		return $hash;
	
	}

	function facilityview() {
	
		$this->initialize();
		$hash['data'] = $this->permitFind();
		$hash += $this->findUser($hash['data']);
		return $hash;

	}
	
	function facilityadd() {
	
		$this->initialize();
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->validateSchema('insert');
			$this->permitValidate();
			$query = "SELECT MAX(folder_id) AS folder_id FROM ".$this->table." WHERE (folder_type = 'facility')";
			$data = $this->fetchOne($query);
			if ($data['folder_id'] > 0) {
				$this->post['folder_id'] = intval($data['folder_id']) + 1;
			} else {
				$this->post['folder_id'] = 1;
			}
			$this->insertPost();
			$this->redirect('facility.php');
		}
		$hash['data'] = $this->post;
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}
	
	function facilityedit() {
		
		$this->initialize();
		$hash['data'] = $this->permitFind('edit');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->validateSchema('update');
			$this->permitValidate();
			$this->updatePost();
			$this->redirect('facility.php');
			$hash['data'] = $this->post;
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}
	
	function facilitydelete() {
	
		$this->initialize();
		$hash['data'] = $this->permitFind('edit');
		$this->deletePost();
		$this->redirect('facility.php');
		$node = $this->fetchCount(DB_PREFIX.'schedule', "WHERE schedule_facility = ".intval($hash['data']['folder_id']), 'id');
		if ($node > 0) {
			$this->error[] = 'この施設を登録しているデータが'.$node.'件存在します。';
		}
		$hash += $this->findUser($hash['data']);
		return $hash;

	}
	
	function reserve() {
		
		if ($_POST['schedule_type'] == 1) {
			$begin = mktime(0, 0, 0, $_POST['beginmonth'], $_POST['beginday'], $_POST['beginyear']);
			$end = mktime(0, 0, 0, $_POST['endmonth'], $_POST['endday'], $_POST['beginyear']);
		} else {
			$begin = mktime(0, 0, 0, $_POST['schedule_month'], $_POST['schedule_day'], $_POST['schedule_year']);
			$end = mktime(0, 0, 0, $_POST['schedule_month'], $_POST['schedule_day'], $_POST['schedule_year']);
		}
		$where = "WHERE (schedule_facility = %d) AND (id != %d)";
		$where .= " AND ((schedule_type = 0 AND (schedule_date >= '%s' AND schedule_date <= '%s'))";
		$where .= " OR (schedule_type = 1 AND (schedule_begin <= '%s' AND schedule_end >= '%s')))";
		$where = sprintf($where, intval($_POST['schedule_facility']), intval($_POST['id']), date('Y-m-d', $begin), date('Y-m-d', $end), date('Y-m-d', $end), date('Y-m-d', $begin));
		if ($_POST['schedule_allday'] != 1) {
			$where .= sprintf(" AND ((schedule_time < '%s' AND schedule_endtime > '%s') OR schedule_allday = 1)", $this->post['schedule_endtime'], $this->post['schedule_time']);
		}
		$query = sprintf("SELECT %s FROM %s %s", implode(',', $this->schematize()), $this->table, $where);
		$data = $this->fetchAll($query);
		if (is_array($data) && count($data) > 0) {
			$calendar = new Calendar;
			if ($_POST['schedule_type'] == 1 && ($_POST['schedule_repeat'] == 'everyday' || $_POST['schedule_repeat'] == 'everyweekday')) {
				foreach ($data as $row) {
					if ($row['schedule_type'] == 1 && ($row['schedule_repeat'] == 'everyday' || $row['schedule_repeat'] == 'everyweekday')) {
						if ($row['schedule_repeat'] == 'everyday' && $_POST['schedule_repeat'] == 'everyday') {
							$result = $row;
							break;
						} elseif ($row['schedule_repeat'] == 'everyweekday' || $_POST['schedule_repeat'] == 'everyweekday') {
							if (strtotime($row['schedule_begin']) < $begin) {
								$overlapbegin = $begin;
							} else {
								$overlapbegin = strtotime($row['schedule_begin']);
							}
							if (strtotime($row['schedule_end']) > $end) {
								$overlapend = $end;
							} else {
								$overlapend = strtotime($row['schedule_end']);
							}
							if ($overlapbegin <= $overlapend) {
								$count = intval(($overlapend - $overlapbegin) / (24*60*60));
								for ($i = 0; $i <= $count; $i++) {
									$weekday = date('w', $overlapbegin);
									if ($weekday >= 1 && $weekday <= 5 && !in_array(date('Y-m-d', $overlapbegin), $calendar->holidays)) {
										$result = $row;
										break;
									}
									$overlapbegin = strtotime('+1 day', $overlapbegin);
									if ($overlapbegin > $overlapend) {
										break;
									}
								}
							}
						}
					} else {
						$array = $this->parse($row, strtotime($row['schedule_begin']), strtotime($row['schedule_end']));
						if (is_array($array) && count($array) > 0) {
							foreach ($array as $value) {
								if ($this->reserveOne($this->post, $value['year'], $value['month'], $value['day'], $calendar->holidays)) {
									$result = $row;
									break;
								}
							}
						}
					}
				}
			} else {
				$array = $this->parse($_POST, $begin, $end);
				if (is_array($array) && count($array) > 0) {
					foreach ($array as $post) {
						foreach ($data as $row) {
							if ($this->reserveOne($row, $post['year'], $post['month'], $post['day'], $calendar->holidays)) {
								$result = $row;
								break;
							}
						}
					}
				}
			}
			if ($result) {
				$string = $calendar->dated($result).'&nbsp;';
				if ($result['schedule_allday'] == 1) {
					$string .= '終日';
				} else {
					list($hour, $minute) = explode(':', $result['schedule_time']);
					$string .= intval($hour).'時'.$minute.'分から';
					list($hour, $minute) = explode(':', $result['schedule_endtime']);
					$string .= intval($hour).'時'.$minute.'分まで';
				}
				$this->error[] = 'この施設は'.$string.'予約されています。';
			}
		}
		
	}
	
	function reserveOne($data, $year, $month, $day, $holidays = null) {
	
		$timestamp = mktime(0, 0, 0, $month, $day, $year);
		if ($data['schedule_type'] == 1 && $timestamp >= strtotime($data['schedule_begin']) && $timestamp <= strtotime($data['schedule_end'])) {
			$array = $this->parse($data, $timestamp, $timestamp, $holidays);
			if (is_array($array) && count($array) > 0) {
				return true;
			}
		} elseif ($data['schedule_year'] == $year && $data['schedule_month'] == $month && $data['schedule_day'] == $day) {
			return true;
		}
	
	}
	
	function parse($data, $begin, $end, $holidays = null) {
		
		if ($data['schedule_type'] == 1) {
			$count = intval(($end - $begin) / (24*60*60));
			$timestamp = $begin;
			if ($data['schedule_repeat'] == 'everyday') {
				for ($i = 0; $i <= $count; $i++) {
					$array[] = array('year'=>date('Y', $timestamp), 'month'=>date('n', $timestamp), 'day'=>date('j', $timestamp));
					$timestamp = strtotime('+1 day', $timestamp);
					if ($timestamp > $end) {
						break;
					}
				}
			} elseif ($data['schedule_repeat'] == 'everyweekday') {
				for ($i = 0; $i <= $count; $i++) {
					$weekday = date('w', $timestamp);
					if ($weekday >= 1 && $weekday <= 5 && !in_array(date('Y-m-d', $timestamp), $holidays)) {
						$array[] = array('year'=>date('Y', $timestamp), 'month'=>date('n', $timestamp), 'day'=>date('j', $timestamp));
					}
					$timestamp = strtotime('+1 day', $timestamp);
					if ($timestamp > $end) {
						break;
					}
				}
			} elseif ($data['schedule_repeat'] == 'everyweek') {
				for ($i = 0; $i <= $count; $i++) {
					$weekday = date('w', $timestamp);
					if ($data['schedule_everyweek'] == $weekday) {
						$array[] = array('year'=>date('Y', $timestamp), 'month'=>date('n', $timestamp), 'day'=>date('j', $timestamp));
						$timestamp = strtotime('+1 week', $timestamp);
					} else {
						$timestamp = strtotime('+1 day', $timestamp);
					}
					if ($timestamp > $end) {
						break;
					}
				}
			} elseif ($data['schedule_repeat'] == 'everymonth') {
				for ($i = 0; $i <= $count; $i++) {
					if ($data['schedule_everymonth'] == 'lastday') {
						$day = date('t', $timestamp);
					} else {
						$day = intval($data['schedule_everymonth']);
					}
					$everymonth = mktime(0, 0, 0, date('n', $timestamp), $day, date('Y', $timestamp));
					if ($everymonth >= $begin && $everymonth <= $end && date('n', $everymonth) == date('n', $timestamp)) {
						$array[] = array('year'=>date('Y', $timestamp), 'month'=>date('n', $timestamp), 'day'=>$day);
					}
					$timestamp = mktime(0, 0, 0, date('n', $timestamp) + 1, 1, date('Y', $timestamp));
					if ($timestamp > $end) {
						break;
					}
				}
			}
		} else {
			$array[] = array('year'=>$data['schedule_year'], 'month'=>$data['schedule_month'], 'day'=>$data['schedule_day']);
		}
		return $array;
		
	}

}

?>