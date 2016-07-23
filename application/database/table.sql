CREATE TABLE prefix_user (
id integer NOT NULL PRIMARY KEY auto_increment,
userid text NOT NULL,
password text NOT NULL,
password_default text NOT NULL,
realname text NOT NULL,
authority text NOT NULL,
user_group integer,
user_groupname text,
user_email text,
user_skype text,
user_ruby text,
user_postcode text,
user_address text,
user_addressruby text,
user_phone text,
user_mobile text,
user_order integer,
edit_level integer,
edit_group text,
edit_user text,
owner text NOT NULL,
editor text,
created text NOT NULL,
updated text);
CREATE UNIQUE INDEX prefix_index_userid ON prefix_user (userid(255));
CREATE INDEX prefix_index_user_group ON prefix_user (user_group);

CREATE TABLE prefix_group (
id integer NOT NULL PRIMARY KEY auto_increment,
group_name text NOT NULL,
group_order integer,
add_level integer NOT NULL,
add_group text,
add_user text,
edit_level integer,
edit_group text,
edit_user text,
owner text NOT NULL,
editor text,
created text NOT NULL,
updated text);

CREATE TABLE prefix_folder (
id integer NOT NULL PRIMARY KEY auto_increment,
folder_type text NOT NULL,
folder_id integer NOT NULL,
folder_caption text NOT NULL,
folder_name text,
folder_date text,
folder_order integer,
add_level integer,
add_group text,
add_user text,
public_level integer,
public_group text,
public_user text,
edit_level integer,
edit_group text,
edit_user text,
owner text NOT NULL,
editor text,
created text NOT NULL,
updated text);
CREATE INDEX prefix_index_folder_type ON prefix_folder (folder_type(255));
CREATE INDEX prefix_index_folder_id ON prefix_folder (folder_id);
CREATE INDEX prefix_index_folder_owner ON prefix_folder (owner(255));

CREATE TABLE prefix_schedule (
id integer NOT NULL PRIMARY KEY auto_increment,
schedule_type integer NOT NULL,
schedule_title text,
schedule_name text,
schedule_comment text,
schedule_year integer,
schedule_month integer,
schedule_day integer,
schedule_date text,
schedule_time text,
schedule_endtime text,
schedule_allday text,
schedule_repeat text,
schedule_everyweek text,
schedule_everymonth text,
schedule_begin text,
schedule_end text,
schedule_facility integer,
schedule_level integer NOT NULL,
schedule_group text,
schedule_user text,
public_level integer NOT NULL,
public_group text,
public_user text,
edit_level integer,
edit_group text,
edit_user text,
owner text NOT NULL,
editor text,
created text NOT NULL,
updated text);
CREATE INDEX prefix_index_schedule_type ON prefix_schedule (schedule_type);
CREATE INDEX prefix_index_schedule_date ON prefix_schedule (schedule_date(255));
CREATE INDEX prefix_index_schedule_repeat ON prefix_schedule (schedule_repeat(255));
CREATE INDEX prefix_index_schedule_begin ON prefix_schedule (schedule_begin(255));
CREATE INDEX prefix_index_schedule_end ON prefix_schedule (schedule_end(255));
CREATE INDEX prefix_index_schedule_level ON prefix_schedule (schedule_level);
CREATE INDEX prefix_index_schedule_owner ON prefix_schedule (owner(255));

CREATE TABLE prefix_message (
id integer NOT NULL PRIMARY KEY auto_increment,
folder_id integer NOT NULL,
message_type text NOT NULL,
message_to text NOT NULL,
message_from text NOT NULL,
message_toname text,
message_fromname text,
message_title text,
message_comment text,
message_date text,
message_file text,
owner text NOT NULL,
editor text,
created text NOT NULL,
updated text);
CREATE INDEX prefix_index_message_folder_id ON prefix_message (folder_id);
CREATE INDEX prefix_index_message_type ON prefix_message (message_type(255));
CREATE INDEX prefix_index_message_owner ON prefix_message (owner(255));

CREATE TABLE prefix_forum (
id integer NOT NULL PRIMARY KEY auto_increment,
folder_id integer NOT NULL,
forum_parent integer NOT NULL,
forum_title text,
forum_name text,
forum_comment text,
forum_date text,
forum_file text,
forum_lastupdate text,
forum_node integer,
public_level integer NOT NULL,
public_group text,
public_user text,
edit_level integer,
edit_group text,
edit_user text,
owner text NOT NULL,
editor text,
created text NOT NULL,
updated text);
CREATE INDEX prefix_index_forum_folder_id ON prefix_forum (folder_id);
CREATE INDEX prefix_index_forum_parent ON prefix_forum (forum_parent);

CREATE TABLE prefix_storage (
id integer NOT NULL PRIMARY KEY auto_increment,
storage_type text NOT NULL,
storage_folder integer NOT NULL,
storage_title text,
storage_name text,
storage_comment text,
storage_date text,
storage_file text,
storage_size text,
add_level integer,
add_group text,
add_user text,
public_level integer NOT NULL,
public_group text,
public_user text,
edit_level integer,
edit_group text,
edit_user text,
owner text NOT NULL,
editor text,
created text NOT NULL,
updated text);
CREATE INDEX prefix_index_storage_type ON prefix_storage (storage_type(255));
CREATE INDEX prefix_index_storage_folder ON prefix_storage (storage_folder);

CREATE TABLE prefix_bookmark (
id integer NOT NULL PRIMARY KEY auto_increment,
folder_id integer NOT NULL,
bookmark_title text,
bookmark_name text,
bookmark_url text,
bookmark_date text,
bookmark_comment text,
bookmark_order integer,
public_level integer NOT NULL,
public_group text,
public_user text,
edit_level integer,
edit_group text,
edit_user text,
owner text NOT NULL,
editor text,
created text NOT NULL,
updated text);
CREATE INDEX prefix_index_bookmark_folder_id ON prefix_bookmark (folder_id);

CREATE TABLE prefix_project (
id integer NOT NULL PRIMARY KEY auto_increment,
folder_id integer NOT NULL,
project_parent integer NOT NULL,
project_title text,
project_begin text,
project_end text,
project_name text,
project_progress integer,
project_comment text,
project_date text,
project_file text,
public_level integer NOT NULL,
public_group text,
public_user text,
edit_level integer,
edit_group text,
edit_user text,
owner text NOT NULL,
editor text,
created text NOT NULL,
updated text);
CREATE INDEX prefix_index_project_folder_id ON prefix_project (folder_id);
CREATE INDEX prefix_index_project_parent ON prefix_project (project_parent);

CREATE TABLE prefix_addressbook (
id integer NOT NULL PRIMARY KEY auto_increment,
folder_id integer NOT NULL,
addressbook_type integer NOT NULL,
addressbook_name text,
addressbook_ruby text,
addressbook_company text,
addressbook_companyruby text,
addressbook_department text,
addressbook_position text,
addressbook_postcode text,
addressbook_address text,
addressbook_addressruby text,
addressbook_phone text,
addressbook_fax text,
addressbook_mobile text,
addressbook_email text,
addressbook_url text,
addressbook_comment text,
addressbook_parent integer,
public_level integer NOT NULL,
public_group text,
public_user text,
edit_level integer,
edit_group text,
edit_user text,
owner text NOT NULL,
editor text,
created text NOT NULL,
updated text);
CREATE INDEX prefix_index_addressbook_folder_id ON prefix_addressbook (folder_id);
CREATE INDEX prefix_index_addressbook_type ON prefix_addressbook (addressbook_type);

CREATE TABLE prefix_todo (
id integer NOT NULL PRIMARY KEY auto_increment,
folder_id integer NOT NULL,
todo_parent integer,
todo_title text,
todo_name text,
todo_term text,
todo_noterm text,
todo_priority integer,
todo_comment text,
todo_complete integer,
todo_completedate text,
todo_user text,
owner text NOT NULL,
editor text,
created text NOT NULL,
updated text);
CREATE INDEX prefix_index_todo_folder_id ON prefix_todo (folder_id);
CREATE INDEX prefix_index_todo_owner ON prefix_todo (owner(255));

CREATE TABLE prefix_timecard (
id integer NOT NULL PRIMARY KEY auto_increment,
timecard_year integer,
timecard_month integer,
timecard_day integer,
timecard_date text,
timecard_open text,
timecard_close text,
timecard_interval text,
timecard_originalopen text,
timecard_originalclose text,
timecard_originalinterval text,
timecard_time text,
timecard_timeinterval text,
timecard_comment text,
owner text NOT NULL,
editor text,
created text NOT NULL,
updated text);
CREATE INDEX prefix_index_timecard_year ON prefix_timecard (timecard_year);
CREATE INDEX prefix_index_timecard_month ON prefix_timecard (timecard_month);
CREATE INDEX prefix_index_timecard_owner ON prefix_timecard (owner(255));

CREATE TABLE prefix_config (
id integer NOT NULL PRIMARY KEY auto_increment,
config_type text NOT NULL,
config_key text NOT NULL,
config_value text,
owner text NOT NULL,
editor text,
created text NOT NULL,
updated text);
CREATE INDEX prefix_index_config_type ON prefix_config (config_type(255));