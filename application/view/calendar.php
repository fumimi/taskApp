<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Calendar {

	var $holidays = array('2000-01-01','2000-01-10','2000-02-11','2000-03-20','2000-04-29','2000-05-03','2000-05-04','2000-05-05','2000-07-20','2000-09-15','2000-09-23','2000-10-09','2000-11-03','2000-11-23','2000-12-23','2001-01-01','2001-01-08','2001-02-12','2001-03-20','2001-04-30','2001-05-03','2001-05-04','2001-05-05','2001-07-20','2001-09-15','2001-09-24','2001-10-08','2001-11-03','2001-11-23','2001-12-24','2002-01-01','2002-01-14','2002-02-11','2002-03-21','2002-04-29','2002-05-03','2002-05-04','2002-05-06','2002-07-20','2002-09-16','2002-09-23','2002-10-14','2002-11-04','2002-11-23','2002-12-23','2003-01-01','2003-01-13','2003-02-11','2003-03-21','2003-04-29','2003-05-03','2003-05-04','2003-05-05','2003-07-21','2003-09-15','2003-09-23','2003-10-13','2003-11-03','2003-11-24','2003-12-23','2004-01-01','2004-01-12','2004-02-11','2004-03-20','2004-04-29','2004-05-03','2004-05-04','2004-05-05','2004-07-19','2004-09-20','2004-09-23','2004-10-11','2004-11-03','2004-11-23','2004-12-23','2005-01-01','2005-01-10','2005-02-11','2005-03-21','2005-04-29','2005-05-03','2005-05-04','2005-05-05','2005-07-18','2005-09-19','2005-09-23','2005-10-10','2005-11-03','2005-11-23','2005-12-23','2006-01-02','2006-01-09','2006-02-11','2006-03-21','2006-04-29','2006-05-03','2006-05-04','2006-05-05','2006-07-17','2006-09-18','2006-09-23','2006-10-09','2006-11-03','2006-11-23','2006-12-23','2007-01-01','2007-01-08','2007-02-12','2007-03-21','2007-04-30','2007-05-03','2007-05-04','2007-05-05','2007-07-16','2007-09-17','2007-09-24','2007-10-08','2007-11-03','2007-11-23','2007-12-24','2008-01-01','2008-01-14','2008-02-11','2008-03-20','2008-04-29','2008-05-03','2008-05-05','2008-05-06','2008-07-21','2008-09-15','2008-09-23','2008-10-13','2008-11-03','2008-11-24','2008-12-23','2009-01-01','2009-01-12','2009-02-11','2009-03-20','2009-04-29','2009-05-04','2009-05-05','2009-05-06','2009-07-20','2009-09-21','2009-09-22','2009-09-23','2009-10-12','2009-11-03','2009-11-23','2009-12-23','2010-01-01','2010-01-11','2010-02-11','2010-03-22','2010-04-29','2010-05-03','2010-05-04','2010-05-05','2010-07-19','2010-09-20','2010-09-23','2010-10-11','2010-11-03','2010-11-23','2010-12-23','2011-01-01','2011-01-10','2011-02-11','2011-03-21','2011-04-29','2011-05-03','2011-05-04','2011-05-05','2011-07-18','2011-09-19','2011-09-23','2011-10-10','2011-11-03','2011-11-23','2011-12-23','2012-01-02','2012-01-09','2012-02-11','2012-03-20','2012-04-30','2012-05-03','2012-05-04','2012-05-05','2012-07-16','2012-09-17','2012-09-22','2012-10-08','2012-11-03','2012-11-23','2012-12-24','2013-01-01','2013-01-14','2013-02-11','2013-03-20','2013-04-29','2013-05-03','2013-05-04','2013-05-06','2013-07-15','2013-09-16','2013-09-23','2013-10-14','2013-11-04','2013-11-23','2013-12-23','2014-01-01','2014-01-13','2014-02-11','2014-03-21','2014-04-29','2014-05-03','2014-05-05','2014-05-06','2014-07-21','2014-09-15','2014-09-23','2014-10-13','2014-11-03','2014-11-24','2014-12-23','2015-01-01','2015-01-12','2015-02-11','2015-03-21','2015-04-29','2015-05-04','2015-05-05','2015-05-06','2015-07-20','2015-09-21','2015-09-22','2015-09-23','2015-10-12','2015-11-03','2015-11-23','2015-12-23','2016-01-01','2016-01-11','2016-02-11','2016-03-21','2016-04-29','2016-05-03','2016-05-04','2016-05-05','2016-07-18','2016-09-19','2016-09-22','2016-10-10','2016-11-03','2016-11-23','2016-12-23','2017-01-02','2017-01-09','2017-02-11','2017-03-20','2017-04-29','2017-05-03','2017-05-04','2017-05-05','2017-07-17','2017-09-18','2017-09-23','2017-10-09','2017-11-03','2017-11-23','2017-12-23','2018-01-01','2018-01-08','2018-02-12','2018-03-21','2018-04-30','2018-05-03','2018-05-04','2018-05-05','2018-07-16','2018-09-17','2018-09-24','2018-10-08','2018-11-03','2018-11-23','2018-12-24','2019-01-01','2019-01-14','2019-02-11','2019-03-21','2019-04-29','2019-05-03','2019-05-04','2019-05-06','2019-07-15','2019-09-16','2019-09-23','2019-10-14','2019-11-04','2019-11-23','2019-12-23','2020-01-01','2020-01-13','2020-02-11','2020-03-20','2020-04-29','2020-05-04','2020-05-05','2020-05-06','2020-07-20','2020-09-21','2020-09-22','2020-10-12','2020-11-03','2020-11-23','2020-12-23');
	
	function initialize($data) {
	
		if (!$data['schedule_year']) {
			$data['schedule_year'] = $_GET['year'];
		}
		if (!$data['schedule_month']) {
			$data['schedule_month'] = $_GET['month'];
		}
		if (!$data['schedule_day']) {
			$data['schedule_day'] = $_GET['day'];
		}
		if (!$data['schedule_time']) {
			$data['beginhour'] = date('G');
			$data['beginminute'] = floor(date('i')/10)*10;
		} else {
			list($data['beginhour'], $data['beginminute']) = explode(':', $data['schedule_time']);
		}
		if (!$data['schedule_endtime']) {
			if (($data['beginhour'] + 1) > 23) {
				$data['endhour'] = 23;
				$data['endminute'] = 50;
			} else {
				$data['endhour'] = $data['beginhour'] + 1;
				$data['endminute'] = floor(date('i')/10)*10;
			}
		} else {
			list($data['endhour'], $data['endminute']) = explode(':', $data['schedule_endtime']);
		}
		if (strlen($data['schedule_begin']) > 0) {
			$timestamp = strtotime($data['schedule_begin']);
		} else {
			$timestamp = time();
		}
		$data['beginyear'] = date('Y', $timestamp);
		$data['beginmonth'] = date('n', $timestamp);
		$data['beginday'] = date('j', $timestamp);
		if (strlen($data['schedule_end']) > 0) {
			$timestamp = strtotime($data['schedule_end']);
			$data['endmonth'] = date('n', $timestamp);
			$data['endday'] = date('j', $timestamp);
		} else {
			if (($data['beginmonth'] + 1) > 12) {
				$data['endmonth'] = 12;
				$data['endday'] = 31;
			} else {
				$data['endmonth'] = $data['beginmonth'] + 1;
				$data['endday'] = $data['beginday'];
			}
		}
		if (!isset($data['schedule_type'])) {
			$data['schedule_type'] = 0;
		}
		if (!$data['schedule_repeat']) {
			$data['schedule_repeat'] = 'everyweek';
			$data['schedule_everyweek'] = 1;
		}
		if (!isset($data['schedule_level'])) {
			$data['schedule_level'] = 1;
		}
		return $data;
	
	}
	
	function prepare($data, $year, $month, $day, $endyear, $endmonth, $endday) {
		
		$result = array();
		if (is_array($data) && count($data) > 0) {
			foreach ($data as $row) {
				$row['schedule_time'] = $this->tick($row['schedule_allday'], $row['schedule_time'], $row['schedule_endtime']);
				if ($row['schedule_type'] == 1) {
					if (strtotime($row["schedule_begin"]) < mktime(0, 0, 0, $month, $day, $year)) {
						$begin = mktime(0, 0, 0, $month, $day, $year);
					} else {
						$begin = strtotime($row["schedule_begin"]);
					}
					if (strtotime($row["schedule_end"]) > mktime(0, 0, 0, $endmonth, $endday, $endyear)) {
						$end = mktime(0, 0, 0, $endmonth, $endday, $endyear);
					} else {
						$end = strtotime($row["schedule_end"]);
					}
					$count = intval(($end - $begin) / (24*60*60));
					$timestamp = $begin;
					if ($row['schedule_repeat'] == 'everyday') {
						for ($i = 0; $i <= $count; $i++) {
							$result[date('j', $timestamp)][] = $row;
							$timestamp = strtotime('+1 day', $timestamp);
							if ($timestamp > $end) {
								break;
							}
						}
					} elseif ($row['schedule_repeat'] == 'everyweekday') {
						for ($i = 0; $i <= $count; $i++) {
							$weekday = date('w', $timestamp);
							if ($weekday >= 1 && $weekday <= 5 && !in_array(date('Y-m-d', $timestamp), $this->holidays)) {
								$result[date('j', $timestamp)][] = $row;
							}
							$timestamp = strtotime('+1 day', $timestamp);
							if ($timestamp > $end) {
								break;
							}
						}
					} elseif ($row['schedule_repeat'] == 'everyweek') {
						for ($i = 0; $i <= $count; $i++) {
							$weekday = date('w', $timestamp);
							if ($row['schedule_everyweek'] == $weekday) {
								$result[date('j', $timestamp)][] = $row;
								$timestamp = strtotime('+1 week', $timestamp);
							} else {
								$timestamp = strtotime('+1 day', $timestamp);
							}
							if ($timestamp > $end) {
								break;
							}
						}
					} elseif ($row['schedule_repeat'] == 'everymonth') {
						if ($row['schedule_everymonth'] == 'lastday') {
							$key = date('t', $timestamp);
						} else {
							$key = intval($row['schedule_everymonth']);
						}
						$everymonth = mktime(0, 0, 0, date('n', $timestamp), $key, date('Y', $timestamp));
						if ($everymonth >= $begin && $everymonth <= $end && date('n', $everymonth) == date('n', $timestamp)) {
							$result[$key][] = $row;
						}
					}
				} else {
					$result[$row['schedule_day']][] = $row;
				}
			}
		}
		return $result;
	
	}
	
	function timetable($data, $beginhour, $endhour, $member = '', $empty = '') {
	
		if (is_array($data) && count($data) > 0) {
			foreach ($data as $row) {
				$class = '';
				if ($_GET['id'] > 0 && $_GET['id'] == $row['id']) {
					$class = ' class="current"';
				}
				$parameter = $this->parameter($_GET['year'], $_GET['month'], $_GET['day'], array('id'=>$row['id'], 'member'=>$member));
				if ($row['schedule_allday'] == 1) {
					$colspan = ($endhour - $beginhour + 1) * 6;
					if ($this->permitted($row, 'public')) {
						$allday .= sprintf('<tr><td colspan="%s"><a%s href="view.php%s"%s>%s</a></td></tr>', $colspan, $class, $parameter, $this->share($row), $row['schedule_title']);
					} else {
						$allday .= sprintf('<tr><td colspan="%s"><div class="private">%s</div></td></tr>', $colspan, $row['schedule_name']);
					}
				} else {
					list($hour, $minute) = explode(':', $row['schedule_time']);
					$begin = $hour * 6 + floor($minute / 10);
					list($hour, $minute) = explode(':', $row['schedule_endtime']);
					$end = $hour * 6 + floor($minute / 10);
					if ($begin <= $end && $end <= 144) {
						$id = count($result);
						if (count($result) > 0) {
							foreach ($result as $key => $array) {
								if ($begin >= $array['lasttime']) {
									$id = $key;
									break;
								}
							}
						}
						if ($result[$id]['lasttime'] <= 0) {
							$result[$id]['lasttime'] = $beginhour * 6;
						}
						$colspan = $begin - $result[$id]['lasttime'];
						if ($colspan > 0) {
							$result[$id]['chart'] .= '<td colspan="'.$colspan.'">&nbsp;</td>';
						}
						$colspan = $end - $begin;
						if ($this->permitted($row, 'public')) {
							$result[$id]['chart'] .= sprintf('<td colspan="%s"><a%s href="view.php%s"%s>%s</a></td>', $colspan, $class, $parameter, $this->share($row), $row['schedule_title']);
						} else {
							$result[$id]['chart'] .= sprintf('<td colspan="%s"><div class="private">%s</div></td>', $colspan, $row['schedule_name']);
						}
						$result[$id]['lasttime'] = $end;
					}
				}
			}
		}
		for ($i = $beginhour; $i <= $endhour; $i++) {
			if ($i == $endhour) {
				$header .= '<th colspan="6" style="border-right:0px;">'.$i.'</th>';
			} else {
				$header .= '<th colspan="6">'.$i.'</th>';
			}
		}
		echo '<table class="timetable" cellspacing="0"><tr>'.$header.'</tr>';
		if (is_array($result) && count($result) > 0) {
			foreach ($result as $row) {
				if (strlen($row['chart']) > 0) {
					$colspan = ($endhour + 1) * 6 - $row['lasttime'];
					if ($colspan > 0) {
						$row['chart'] .= '<td colspan="'.$colspan.'">&nbsp;</td>';
					}
					echo '<tr>'.$row['chart'].'</tr>';
				}
			}
		} elseif (strlen($allday) <= 0) {
			echo '<tr><td colspan="'.(($endhour - $beginhour + 1) * 6).'" class="timetableempty">'.$empty.'&nbsp;</td></tr>';
		}
		echo $allday.'</table>';
	
	}
	
	function dated($data) {
	
		if ($data['schedule_type'] == 1) {
			$begin = date('Y年n月d日', strtotime($data['schedule_begin']));
			$end = date('Y年n月d日', strtotime($data['schedule_end']));
			if ($data['schedule_repeat'] == 'everyday') {
				$string = '毎日';
			} elseif ($data['schedule_repeat'] == 'everyweekday') {
				$string = '毎日(平日)';
			} elseif ($data['schedule_repeat'] == 'everyweek') {
				$week = array('日', '月', '火', '水', '木', '金', '土');
				$string = '毎週'.$week[$data['schedule_everyweek']].'曜日';
			} elseif ($data['schedule_repeat'] == 'everymonth') {
				if ($data['schedule_everymonth'] == 'lastday') {
					$string = '毎月末日';
				} else {
					$string = '毎月'.intval($data['schedule_everymonth']).'日';
				}
			}
			$string .= '&nbsp;('.$begin.'-'.$end.')';
		} else {
			$string = intval($data['schedule_year']).'年'.intval($data['schedule_month']).'月'.intval($data['schedule_day']).'日';
		}
		return $string;
	
	}
	
	function tick($allday, $time, $endtime = null, $separator = '-') {
	
		if ($allday != 1) {
			$array = explode(':', $time);
			$string = sprintf('%d:%02d', intval($array[0]), intval($array[1]));
			if ($endtime) {
				$array = explode(':', $endtime);
				$string .= sprintf($separator.'%d:%02d', intval($array[0]), intval($array[1]));
			}
			return $string.'&nbsp;';
		}
		
	}
	
	function parameter($year = 0, $month = 0, $day = 0, $parameter = null) {
		
		if ($year > 0) {
			$array['year'] = intval($year);
		}
		if ($month > 0) {
			$array['month'] = intval($month);
		}
		if ($day > 0) {
			$array['day'] = intval($day);
		}
		if ($_GET['group'] > 0) {
			$array['group'] = intval($_GET['group']);
		}
		if (strlen($_GET['member']) > 0) {
			$array['member'] = htmlspecialchars($_GET['member'], ENT_QUOTES, 'UTF-8');
		}
		if ($_GET['facility'] > 0) {
			$array['facility'] = intval($_GET['facility']);
		}
		if (is_array($parameter) && count($parameter) > 0 && is_array($array)) {
			$array = $parameter + $array;
		}
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $key => $value) {
				if (strlen($value) > 0) {
					$result[] = $key.'='.htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
				}
			}
		}
		if (is_array($result) && count($result) > 0) {
			return '?'.implode('&', $result);
		}
		
	}
	
	function style($year, $month, $day, $weekday, $lastday = 31) {
	
		$date = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
		if ($day > 0 && $day <= $lastday && $date == date('Y-m-d')) {
			$class = ' class="today"';
		} elseif ($weekday == 0 || ($day > 0 && $day <= $lastday && in_array($date, $this->holidays))) {
			$class = ' class="sunday"';
		} elseif ($weekday == 6) {
			$class = ' class="saturday"';
		} else {
			$class = '';
		}
		return $class;
	
	}
	
	function share($data) {
		
		if ($data['schedule_level'] == 1) {
			$class = '';
		} else {
			$class = ' class="share"';
		}
		return $class;
	
	}
	
	function permitted($data, $level = 'public') {
		
		$permission = false;
		if ($data[$level.'_level'] == 0) {
			$permission = true;
		} elseif (strlen($data['owner']) > 0 && $data['owner'] == $_SESSION['userid']) {
			$permission = true;
		} elseif ($data[$level.'_level'] == 2 && (stristr($data[$level.'_group'], '['.$_SESSION['group'].']') || stristr($data[$level.'_user'], '['.$_SESSION['userid'].']'))) {
			$permission = true;
		}
		return $permission;
	
	}
	
	function selector($name, $user, $group, $owner) {
	
		if (is_array($user) && count($user) > 0) {
			$string .= '<optgroup label="ユーザー">';
			foreach ($user as $key => $value) {
				if ($key == $owner) {
					$selected = ' selected="selected"';
				} else {
					$selected = '';
				}
				$string .= '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
			}
			$string .= '</optgroup>';
		}
		if (is_array($group) && count($group) > 0) {
			$string .= '<optgroup label="グループ">';
			foreach ($group as $key => $value) {
				$string .= '<option value="'.$key.'">'.$value.'</option>';
			}
			$string .= '</optgroup>';
		}
		$attribute = 'this,'.intval($_GET['year']).','.intval($_GET['month']);
		if ($_GET['day'] > 0) {
			$attribute .= ','.intval($_GET['day']);
		}
		return sprintf('<select name="%s" onchange="Schedule.redirect(%s)">%s</select>', $name, $attribute, $string);
	
	}

}

?>