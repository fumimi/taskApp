<?php
/**
 * アプリケーション設定
 */
//アプリケーション
define('APP_TYPE', 'taskapp');

/**
 * 制限設定
 */
//表示件数
define('APP_LIMIT', '10');
//最大表示件数
define('APP_LIMITMAX', '1000');
//アップロードファイル
define('APP_FILESIZE', '10000000');
define('APP_EXTENSION', 'exe');

/**
 * 認証設定
 */
//有効期限
define('APP_EXPIRE', '7200');
//アイドルタイム
define('APP_IDLE', '3600');

/**
 * パス設定
 */
//アプリケーションディレクトリ
define('DIR_PATH', dirname(__FILE__).'/');
// Model Directory
define('DIR_MODEL', DIR_PATH.'model/');
//ビューディレクトリ
define('DIR_VIEW', DIR_PATH.'view/');
//ライブラリディレクトリ
define('DIR_LIBRARY', DIR_PATH.'library/');
//ファイルディレクトリ
define('DIR_UPLOAD', DIR_PATH.'upload/');

/**
 * データベース設定
 */
//データベースの種類
define('DB_STORAGE', 'mysql');
//データベースのホスト名
define('DB_HOSTNAME', 'mysql426.db.sakura.ne.jp');
//データベース名
define('DB_DATABASE', 'fumimi-jp_taskapp');
//データベースユーザー名
define('DB_USERNAME', 'fumimi-jp');
//データベースパスワード
define('DB_PASSWORD', 's5YGZJWx');
//テーブル接頭辞
define('DB_PREFIX', 'groupware_');
//データベースポート番号
define('DB_PORT', '5432');
//データベース文字コード設定
define('DB_CHARSET', 'utf8');
//データベースファイル
define('DB_FILE', DIR_PATH.'database/group.sqlite2');
//郵便番号データファイル
define('DB_POSTCODE', DIR_PATH.'database/KEN_ALL.CSV');

// Application version
define('SINCE', '0.0.10');
// Application name
define('APP_NAME') or define('APP_NAME', 'Task App');
// Application version
defined('APP_VERSION') or define('APP_VERSION', '0.0.10');

?>
