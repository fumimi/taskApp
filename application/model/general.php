<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class General extends ApplicationModel {
	
	function index() {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['timecard_open']) || isset($_POST['timecard_close']) || isset($_POST['timecard_interval'])) {
				require_once(DIR_MODEL.'timecard.php');
				$timecard = new Timecard;
				$timecard->handler = $this->handler;
				$timecard->add();
			} elseif (isset($_POST['folder']) && $_POST['folder'] == 'complete') {
				require_once(DIR_MODEL.'todo.php');
				$todo = new Todo;
				$todo->handler = $this->handler;
				$todo->move();
			}
		}
		$sessionuserid = $this->quote($_SESSION['userid']);
		$hash['year'] = date('Y');
		$hash['month'] = date('n');
		$hash['day'] = date('j');
		$hash['weekday'] = date('w');
		$monthly = mktime(0, 0, 0, $hash['month'] - 1, $hash['day'], $hash['year']);
		$hash['begin'] = mktime(0, 0, 0, $hash['month'], $hash['day'] - $hash['weekday'], $hash['year']);
		$hash['end'] = mktime(23, 59, 59, $hash['month'], $hash['day'] + 6 - $hash['weekday'], $hash['year']);
		$string = "((schedule_type = 0 AND (schedule_date >= '%s' AND schedule_date <= '%s')) OR ";
		$string .= "(schedule_type = 1 AND (schedule_begin <= '%s' AND schedule_end >= '%s')))";
		$where[] = sprintf($string, date('Y-m-d', $hash['begin']), date('Y-m-d', $hash['end']), date('Y-m-d', $hash['end']), date('Y-m-d', $hash['begin']));
		$string = "((schedule_level = 0) OR (schedule_level = 1 AND owner = '%s') OR ";
		$string .= "(schedule_level = 2 AND (schedule_group LIKE '%%[%s]%%' OR schedule_user LIKE '%%[%s]%%')))";
		$where[] = sprintf($string, $sessionuserid, $this->quote($_SESSION['group']), $sessionuserid);
		$where[] = $this->permitWhere();
		$field = "*";
		$query = sprintf("SELECT %s FROM %sschedule WHERE %s ORDER BY schedule_allday,schedule_time,schedule_endtime", $field, DB_PREFIX, implode(" AND ", $where));
		$hash['schedule'] = $this->fetchAll($query);
		$field = "*";
		$query = sprintf("SELECT %s FROM %stimecard WHERE (timecard_date = '%s') AND (owner = '%s')", $field, DB_PREFIX, date('Y-m-d'), $sessionuserid);
		$hash['timecard'] = $this->fetchOne($query);
		$field = "*";
		$query = sprintf("SELECT %s FROM %stodo WHERE (owner = '%s') AND (todo_complete = 0) ORDER BY todo_noterm, todo_term", $field, DB_PREFIX, $sessionuserid);
		$hash['todo'] = $this->fetchLimit($query, 0, 5);
		$field = "*";
		$query = sprintf("SELECT %s FROM %smessage WHERE (owner = '%s') AND (folder_id = 0) AND (message_type = 'received') ORDER BY message_date DESC", $field, DB_PREFIX, $sessionuserid);
		$hash['message'] = $this->fetchLimit($query, 0, 5);
		$where = array();
		$category = $this->permitCategory('forum');
		$where[] = "(forum_lastupdate > '".date('Y-m-d H:i:s', $monthly)."')";
		$where[] = $this->folderWhere($category['folder'], 'all');
		$where[] = "(forum_parent = 0)";
		$where[] = $this->permitWhere();
		$field = "*";
		$query = sprintf("SELECT %s FROM %sforum WHERE %s ORDER BY forum_lastupdate DESC", $field, DB_PREFIX, implode(" AND ", $where));
		$hash['forum'] = $this->fetchLimit($query, 0, 5);
		$where = array();
		$category = $this->permitCategory('bookmark');
		$where[] = $this->folderWhere($category['folder']);
		$where[] = $this->permitWhere();
		$field = "*";
		$query = sprintf("SELECT %s FROM %sbookmark WHERE %s ORDER BY bookmark_order, bookmark_date DESC", $field, DB_PREFIX, implode(" AND ", $where));
		$hash['bookmark'] = $this->fetchLimit($query, 0, 5);
		$where = array();
		$category = $this->permitCategory('project');
		$where[] = "(project_end >= '".date('Y-m-d')."')";
		$where[] = $this->folderWhere($category['folder'], 'all');
		$where[] = "(project_parent = '0')";
		$where[] = $this->permitWhere();
		$field = "*";
		$query = sprintf("SELECT %s FROM %sproject WHERE %s ORDER BY project_begin", $field, DB_PREFIX, implode(" AND ", $where));
		$hash['project'] = $this->fetchLimit($query, 0, 5);
		$hash['group'] = $this->findGroup();
		return $hash;
	
	}
	
	function administration() {
	
		$this->authorize('administrator', 'manager');
		if (file_exists('setup.php')) {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				if (is_writable('setup.php')) {
					if (@unlink('setup.php') == false) {
						$this->error[] = 'セットアップファイルの削除に失敗しました。';
					}
				} else {
					$this->error[] = 'セットアップファイルに書き込み権限がありません。<br />削除に失敗しました。';
				}
			} else {
				$this->error[] = 'セットアップファイル(setup.php)が存在します。<br />削除してください。';
			}
		}
	
	}

}

?>