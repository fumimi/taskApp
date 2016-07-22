mysql

root password
k2SPp7Wg

mysql -u root -p k2SPp7Wg


# mysql -u root

mysql> update mysql.user set password=password('root用の任意パスワード') where user = 'root';
mysql> update mysql.user set password=password('k2SPp7Wg') where user = 'root';


mysql> flush privileges; ← 変更を反映
mysql> exit;
