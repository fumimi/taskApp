<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Explanation {
	
	function explain($type) {
	
		switch ($type) {
			case 'public':
				$string .= '公開する範囲を設定します。';
				$array['公開'] = '全員に公開します。';
				$array['非公開'] = '登録者以外には公開されません。';
				$array['公開するグループ・<br />ユーザーを設定'] = '設定したグループ・ユーザーのみに公開します。';
				break;
			case 'edit':
				$string .= '編集する権限を設定します。';
				$array['許可'] = '全員が編集できます。';
				$array['登録者のみ'] = '登録者のみが編集できます。';
				$array['許可するグループ・<br />ユーザーを設定'] = '設定したグループ・ユーザーが編集できます。';
				break;
			case 'add':
				$string .= 'カテゴリにデータを追加する権限を設定します。';
				$array['許可'] = '全員がデータを追加できます。';
				$array['登録者のみ'] = '登録者のみがデータを追加できます。';
				$array['許可するグループ・<br />ユーザーを設定'] = '設定したグループ・ユーザーがデータを追加できます。';
				break;
			case 'categorypublic':
				$string .= '公開する範囲を設定します。';
				$array['公開'] = '全員に公開します。';
				$array['公開するグループ・<br />ユーザーを設定'] = '設定したグループ・ユーザーのみに公開します。';
				break;
			case 'categoryedit':
				$string .= 'カテゴリの設定を編集する権限を設定します。<br />';
				$string .= '許可するユーザーは「編集者」以上の権限が必要です。';
				$array['許可'] = '全員が編集できます。';
				$array['登録者のみ'] = '登録者のみが編集できます。';
				$array['許可するグループ・<br />ユーザーを設定'] = '設定したグループ・ユーザーが編集できます。';
				break;
			case 'schedulelevel':
				$string .= '表示先に設定したグループ・ユーザーのスケジュールにこの予定が表示されます。';
				$array['登録者'] = '登録者のスケジュールのみに表示します。';
				$array['全体'] = '全員のスケジュールに表示します。';
				$array['表示するグループ・<br />ユーザーを設定'] = '設定したグループ・ユーザーのスケジュールに表示します。';
				break;
			case 'scheduleedit':
				$string .= '編集する権限を設定します。';
				$array['許可'] = '表示先に設定したグループ・ユーザーが編集できます。';
				$array['登録者のみ'] = '登録者のみが編集できます。';
				$array['許可するグループ・<br />ユーザーを設定'] = '設定したグループ・ユーザーが編集できます。<br />(表示先に設定されていないグループ・ユーザーは編集できません。)';
				break;
			case 'facilityadd':
				$string .= '施設を予約する権限を設定します。';
				$array['許可'] = '全員が予約できます。';
				$array['登録者のみ'] = '登録者のみが予約できます。';
				$array['許可するグループ・<br />ユーザーを設定'] = '設定したグループ・ユーザーが予約できます。';
				break;
			case 'facilityedit':
				$string .= '施設の設定を編集する権限を設定します。<br />';
				$string .= '許可するユーザーは「編集者」以上の権限が必要です。';
				$array['許可'] = '全員が編集できます。';
				$array['登録者のみ'] = '登録者のみが編集できます。';
				$array['許可するグループ・<br />ユーザーを設定'] = '設定したグループ・ユーザーが編集できます。';
				break;
			case 'todolevel':
				$string .= '表示先に設定したユーザーにこのToDoが送信されます。<br />';
				$string .= '送信されたToDoはユーザーごとに管理され、他のユーザーの完了状況を確認できます。';
				$array['登録者'] = '登録者のみに表示します。';
				$array['表示するグループ・<br />ユーザーを設定'] = '設定したユーザーに表示します。<br />(登録者にも表示されます。)';
				break;
			case 'storageadd':
				$string .= 'フォルダにファイルをアップロードする権限を設定します。';
				$array['許可'] = '全員がファイルをアップロードできます。';
				$array['登録者のみ'] = '登録者のみがファイルをアップロードできます。';
				$array['許可するグループ・<br />ユーザーを設定'] = '設定したグループ・ユーザーがファイルをアップロードできます。';
				break;
			case 'timecardopen':
				$string .= '出社時刻を設定します。<br />';
				$string .= '出社時刻よりも前の時間は勤務時間に算入されません。';
				break;
			case 'timecardclose':
				$string .= '勤務時間に算入する最終時刻を設定します。<br />';
				$string .= '最終時刻よりも後の時間は勤務時間に算入されません。';
				break;
			case 'timecardround':
				$string .= '勤務時間を計算する単位を設定します。<br />';
				$string .= '10分単位にした場合、10分未満は切り捨てられます。<br />';
				$string .= '例) 出社8:55 → 9:00、退社18:55 → 18:50';
				break;
			case 'timecardlunch':
				$string .= '固定の外出時刻を設定します。<br />';
				$string .= '設定された時間は自動的に外出時間に算入され、勤務時間に算入されません。';
				break;
			case 'timecardlunchround':
				$string .= '外出時間を計算する単位を設定します。<br />';
				$string .= '10分単位にした場合、10分未満は切り捨てられます。<br />';
				$string .= '例) 外出12:05 → 12:00、復帰12:55 → 13:00';
				break;
			case 'groupadd':
				$string .= 'グループにユーザーを追加する権限を設定します。<br />';
				$string .= '許可するユーザーは「マネージャ」以上の権限が必要です。';
				$array['許可'] = '全員がユーザーを追加できます。';
				$array['登録者のみ'] = '登録者のみがユーザーを追加できます。';
				$array['許可するグループ・<br />ユーザーを設定'] = '設定したグループ・ユーザーがユーザーを追加できます。';
				break;
			case 'groupedit':
				$string .= '編集する権限を設定します。<br />';
				$string .= '許可するユーザーは「管理者」以上の権限が必要です。';
				$array['許可'] = '全員が編集できます。';
				$array['登録者のみ'] = '登録者のみが編集できます。';
				$array['許可するグループ・<br />ユーザーを設定'] = '設定したグループ・ユーザーが編集できます。';
				break;
			case 'useredit':
				$string .= '編集する権限を設定します。<br />';
				$string .= '許可するユーザーは「マネージャ」以上の権限が必要です。';
				$array['許可'] = '全員が編集できます。';
				$array['登録者のみ'] = '登録者のみが編集できます。';
				$array['許可するグループ・<br />ユーザーを設定'] = '設定したグループ・ユーザーが編集できます。';
				break;
			case 'userid':
				$string .= 'ユーザーIDに使用できる文字は半角英数字、-(ハイフン)、_(アンダーバー)、.(ドット)です。';
				break;
			case 'userpassword':
				$string .= 'パスワードに使用できる文字は4文字以上32文字以下の半角英数字のみです。';
				break;
			case 'userauthority':
				$string .= 'ユーザーの権限を設定します。<br />';
				$string .= '通常はメンバーに設定し、必要に応じて権限を付与します。';
				$array['メンバー'] = '一般のユーザーです。';
				$array['編集者'] = 'カテゴリと施設を管理する権限があります。';
				$array['マネージャ'] = '編集者の権限に加え、<br />・ユーザーを管理する権限<br />・タイムカードを管理する権限<br />があります。<br />(タイムカードの設定はできません。)';
				$array['管理者'] = 'マネージャの権限に加え、<br />・グループを管理する権限<br />・タイムカードを設定する権限<br />があります。';
				break;
		}
		$string .= $this->item($array);
		if (!file_exists('application')) {
			$root = '../';
		}
		$string = '<img class="explain" src="'.$root.'images/explain.gif" onclick="App.explain(this)" /><div class="explanation">'.$string.'<div class="explanationclose"><span class="operator">[閉じる]</span></div></div>';
		return $string;
	
	}
	
	function item($array) {
	
		if (is_array($array) && count($array) > 0) {
			$string = '<table cellspacing="0">';
			foreach ($array as $key => $value) {
				$string .= '<tr><th>'.$key.'：</th><td>'.$value.'</td></tr>';
			}
			$string .= '</table>';
			return $string;
		}
	
	}

}

?>