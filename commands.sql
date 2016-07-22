sqlite3 dotinstall.sqlite3
▽新規DBの作成
sqlite3 [データベース名]
create table users (name, email);
▽テーブルの作成
create table [テーブル名] ([カラム1], [カラム2]);
▽テーブルの作成
.tables
.schema users
create table lessons
▽テーブルの作成
create table lessons
(title);
.tables
.schema
drop table lessons;
▽テーブルの削除
drop table lessons;
.tables

**************************************************

sqlite3 dotinstall.sqlite3
.tables
.schema
alter table users rename to dotinstall_users;
▽テーブル名の変更
alter table [古いテーブル名] rename to [新しいテーブル名];
.tables
alter table dotinstall_users add column pwd;
▽カラムの追加
alter table [テーブル名] add column [追加するカラム名];
.schema

**************************************************

create table users (
  id integer primary key autoincrement,
  name text not null,
  email text unique,
  age integer default 20
);

**************************************************

create table lessons (
  title, count_lessons check(count_lessons>0)
);

**************************************************

create index age on users (age);

**************************************************

sqlite3 dotinstall.sqlite3
create table users (name, email, age);
insert into users (name, email, age) values ('taguchi', 'taguchi@dotinstall.com', 20);
insert into users (name, email, age) values ('it''s a pen', 'taguchi@dotinstall.com', 20);
insert into users (name, email, age) values ('it''s a pen', 'taguchi@dotinstall.com', null);

**************************************************

sqlite3 dotinstall.sqlite3
CREATE TABLE users (name, score);
insert into users (name, score) values ('taguchi', '200');
insert into users (name, score) values ('sasaki', '100');
insert into users (name, score) values ('sato', '500');
insert into users (name, score) values ('hukuyama', '400');
insert into users (name, score) values ('freeza', '8500000');

.schema
select * from users;
select score from users;
▽昇順に並べ替える
select score from users order by score;
▽降順に並べ替える
select score from users order by score desc;
▽取得する行数を指定する
select * from users order by score desc limit 3;

select * from users where score >= 200;
select * from users where name <> 'taguchi';
select * from users where name = 'taguchi';
select * from users where name like 'sa%';

**************************************************

sqlite3 dotinstall.sqlite3
select * from users;
select count(*) from users;
select max(score) from users;
select min(score) from users;
select random();
select * from users order by random() limit 1;
select name, length(name) from users;
select name, typeof(name) from users;

**************************************************

sqlite3 dotinstall.com

create table users_a(name, score, team text);
insert into users_a (name, score, team) values ('taguchi', 200, 'A');
insert into users_a (name, score, team) values ('sasaki', 100, 'B');
insert into users_a (name, score, team) values ('hiroshi', 400, 'B');
insert into users_a (name, score, team) values ('hiyano', 800, 'A');

.schema
select * from users;

select distinct team from users_a;
select team, sum(score) from users_a group by team;

**************************************************

▽日付/時刻関数(Date And Time Functions)
sqlite3 dotinstall.sqlite3
select current_time;
select current_date;
select current_timestamp;
select strftime('%Y年', current_timestamp);

**************************************************

▽データの更新
sqlite3 dotinstall.sqlite3
select * from users_a;
update users_a set name = 'dotinstall_taguchi' where name = 'taguchi';
select * from users_a;
update users_a set name = 'taguchi', score = 500 where name = 'dotinstall_taguchi';
select * from users_a;

**************************************************

▽データを削除
sqlite3 dotinstall.sqlite3
select * from users_a;
delete from users_a where score <= 100;
select * from users_a;
select ROWID, * from users_a;
delete from users_a where ROWID = 4;
select * from users_a;

**************************************************

▽複数のテーブルを扱う
sqlite3 dotinstall.sqlite3
.tables
.schema
select * from users;
select * from games;
select id, name, team, sum(score) from users, games where users.id = games.user_id group by users.id;

**************************************************

▽外部のファイルからデータを取り込む
cat users.txt
sqlite3 dotinstall.sqlite3
.tables
.schema
.show
.separator ,
.show
.import users.txt users
select * from users;
.show
.help
.header on
select * from users;
