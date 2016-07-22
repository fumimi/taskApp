create database sns_php;

grant all on sns_php.* to snsuser@localhost identified by '6w7murn7';

use sns_php

create table users (
  id int not null auto_increment primary key,
  email varchar(255) unique,
  password varchar(255),
  created datetime,
  modified datetime
);

desc users;

select * from users;
