<?php


/**
* Application Configuration
*/
// Application name
defined('APP_NAME') or define('APP_NAME', 'Task App');
// Application version
defined('APP_VERSION') or define('APP_VERSION', '0.0.4');




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
* Path Configuration
*/

// Application Directory(アプリケーションディレクトリ)
defined('DIR_PATH') or define('DIR_PATH', dirname(__FILE__).'/');
// Model Directory(モデル)
define('DIR_MODEL', DIR_PATH.'Model/');
// View Directory(ビュー)
define('DIR_VIEW', DIR_PATH.'View/');
// Controlloer Directory(コントローラー)
define('DIR_CONR', DIR_PATH.'Controlloer/');

//ライブラリディレクトリ
define('DIR_LIBRARY', DIR_PATH.'library/');
//ファイルディレクトリ
define('DIR_UPLOAD', DIR_PATH.'upload/');


/**
* DB authentication
*/


 // Sqlite configuration

defined('DB_PORT') or define('DB_PORT', null);



// Database driver: sqlite, mysql or postgres(データベースの種類)
defined('DB_DRIVER') or define('DB_DRIVER', 'mysql');

// Mysql/Postgres configuration (MySQL/Postgresの設定)
// Host name(ホスト名)
defined('DB_HOSTNAME') or define('DB_HOSTNAME', 'localhost');
// Database name(データベース名)
defined('DB_NAME') or define('DB_NAME', 'db_name');
// User name(ユーザー名)
defined('DB_USERNAME') or define('DB_USERNAME', 'root');
//password(パスワード)
defined('DB_PASSWORD') or define('DB_PASSWORD', '');
// Prefix(テーブル接頭辞)
defined('DB_PREFIX') or define('DB_PREFIX', 'taskapp_');


//Port number(データベースポート番号)
define('DB_PORT', '');
//データベース文字コード設定
define('DB_CHARSET', 'utf8');
//データベースファイル
define('DB_FILE') or ('DB_FILE', DIR_PATH.'database/group.sqlite2');
defined('DB_FILENAME') or define('DB_FILENAME', 'data'.DIRECTORY_SEPARATOR.'db.sqlite');

//郵便番号データファイル
define('DB_POSTCODE') or ('DB_POSTCODE', DIR_PATH.'database/KEN_ALL.CSV');



/**
* Google authentication
*/

// Google authentication
defined('GOOGLE_AUTH') or define('GOOGLE_AUTH', false);
defined('GOOGLE_CLIENT_ID') or define('GOOGLE_CLIENT_ID', '');
defined('GOOGLE_CLIENT_SECRET') or define('GOOGLE_CLIENT_SECRET', '');

?>


<?php

// Enable/disable debug
defined('DEBUG') or define('DEBUG', false);
defined('DEBUG_FILE') or define('DEBUG_FILE', __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'debug.log');

// Plugin directory
defined('PLUGINS_DIR') or define('PLUGINS_DIR', __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'plugins');




// LDAP configuration
defined('LDAP_AUTH') or define('LDAP_AUTH', false);
defined('LDAP_SERVER') or define('LDAP_SERVER', '');
defined('LDAP_PORT') or define('LDAP_PORT', 389);
defined('LDAP_SSL_VERIFY') or define('LDAP_SSL_VERIFY', true);
defined('LDAP_START_TLS') or define('LDAP_START_TLS', false);
defined('LDAP_USERNAME_CASE_SENSITIVE') or define('LDAP_USERNAME_CASE_SENSITIVE', false);

defined('LDAP_BIND_TYPE') or define('LDAP_BIND_TYPE', 'anonymous');
defined('LDAP_USERNAME') or define('LDAP_USERNAME', null);
defined('LDAP_PASSWORD') or define('LDAP_PASSWORD', null);

defined('LDAP_USER_BASE_DN') or define('LDAP_USER_BASE_DN', '');
defined('LDAP_USER_FILTER') or define('LDAP_USER_FILTER', '');
defined('LDAP_USER_ATTRIBUTE_USERNAME') or define('LDAP_USER_ATTRIBUTE_USERNAME', 'uid');
defined('LDAP_USER_ATTRIBUTE_FULLNAME') or define('LDAP_USER_ATTRIBUTE_FULLNAME', 'cn');
defined('LDAP_USER_ATTRIBUTE_EMAIL') or define('LDAP_USER_ATTRIBUTE_EMAIL', 'mail');
defined('LDAP_USER_ATTRIBUTE_GROUPS') or define('LDAP_USER_ATTRIBUTE_GROUPS', 'memberof');
defined('LDAP_USER_CREATION') or define('LDAP_USER_CREATION', true);

defined('LDAP_GROUP_ADMIN_DN') or define('LDAP_GROUP_ADMIN_DN', '');
defined('LDAP_GROUP_MANAGER_DN') or define('LDAP_GROUP_MANAGER_DN', '');

defined('LDAP_GROUP_PROVIDER') or define('LDAP_GROUP_PROVIDER', false);
defined('LDAP_GROUP_BASE_DN') or define('LDAP_GROUP_BASE_DN', '');
defined('LDAP_GROUP_FILTER') or define('LDAP_GROUP_FILTER', '');
defined('LDAP_GROUP_ATTRIBUTE_NAME') or define('LDAP_GROUP_ATTRIBUTE_NAME', 'cn');



// Proxy authentication
defined('REVERSE_PROXY_AUTH') or define('REVERSE_PROXY_AUTH', false);
defined('REVERSE_PROXY_USER_HEADER') or define('REVERSE_PROXY_USER_HEADER', 'REMOTE_USER');
defined('REVERSE_PROXY_DEFAULT_ADMIN') or define('REVERSE_PROXY_DEFAULT_ADMIN', '');
defined('REVERSE_PROXY_DEFAULT_DOMAIN') or define('REVERSE_PROXY_DEFAULT_DOMAIN', '');

// Remember me authentication
defined('REMEMBER_ME_AUTH') or define('REMEMBER_ME_AUTH', true);

// Mail configuration
defined('MAIL_FROM') or define('MAIL_FROM', 'notifications@kanboard.local');
defined('MAIL_TRANSPORT') or define('MAIL_TRANSPORT', 'mail');
defined('MAIL_SMTP_HOSTNAME') or define('MAIL_SMTP_HOSTNAME', '');
defined('MAIL_SMTP_PORT') or define('MAIL_SMTP_PORT', 25);
defined('MAIL_SMTP_USERNAME') or define('MAIL_SMTP_USERNAME', '');
defined('MAIL_SMTP_PASSWORD') or define('MAIL_SMTP_PASSWORD', '');
defined('MAIL_SMTP_ENCRYPTION') or define('MAIL_SMTP_ENCRYPTION', null);
defined('MAIL_SENDMAIL_COMMAND') or define('MAIL_SENDMAIL_COMMAND', '/usr/sbin/sendmail -bs');

// Enable or disable "Strict-Transport-Security" HTTP header
defined('ENABLE_HSTS') or define('ENABLE_HSTS', true);

// Enable or disable "X-Frame-Options: DENY" HTTP header
defined('ENABLE_XFRAME') or define('ENABLE_XFRAME', true);

// Syslog
defined('ENABLE_SYSLOG') or define('ENABLE_SYSLOG', true);

// Default files directory
defined('FILES_DIR') or define('FILES_DIR', 'data'.DIRECTORY_SEPARATOR.'files');

// Escape html inside markdown text
defined('MARKDOWN_ESCAPE_HTML') or define('MARKDOWN_ESCAPE_HTML', true);

// API alternative authentication header, the default is HTTP Basic Authentication defined in RFC2617
defined('API_AUTHENTICATION_HEADER') or define('API_AUTHENTICATION_HEADER', '');

// Enable/disable url rewrite
defined('ENABLE_URL_REWRITE') or define('ENABLE_URL_REWRITE', isset($_SERVER['HTTP_MOD_REWRITE']));

// Hide login form
defined('HIDE_LOGIN_FORM') or define('HIDE_LOGIN_FORM', false);

// Bruteforce protection
defined('BRUTEFORCE_CAPTCHA') or define('BRUTEFORCE_CAPTCHA', 3);
defined('BRUTEFORCE_LOCKDOWN') or define('BRUTEFORCE_LOCKDOWN', 6);
defined('BRUTEFORCE_LOCKDOWN_DURATION') or define('BRUTEFORCE_LOCKDOWN_DURATION', 15);

// Session duration in second (0 = until the browser is closed)
// See http://php.net/manual/en/session.configuration.php#ini.session.cookie-lifetime
defined('SESSION_DURATION') or define('SESSION_DURATION', 0);

// HTTP client proxy
defined('HTTP_PROXY_HOSTNAME') or define('HTTP_PROXY_HOSTNAME', '');
defined('HTTP_PROXY_PORT') or define('HTTP_PROXY_PORT', '3128');
defined('HTTP_PROXY_USERNAME') or define('HTTP_PROXY_USERNAME', '');
defined('HTTP_PROXY_PASSWORD') or define('HTTP_PROXY_PASSWORD', '');

?>
