create database if not exists email_scheduler;

use email_scheduler;

drop table if exists email_schedule;

create table email_schedule (
	id bigint(20) unsigned not null primary key auto_increment ,
	userId int not null ,
	email_from varchar(150) not null ,
	email_from_name varchar(300) not null ,
	email_to varchar(150) not null ,
	email_to_name varchar(300) not null ,
	email_subject varchar(255) not null ,
	email_body text not null ,
	attempt_count int not null default 0 ,
	delivered_at datetime null ,
	send_at datetime null ,
	created_at datetime not null ,
	updated_at datetime null
) engine=innodb default charset=utf8;

create index idx_email_schedule_user on email_schedule (user_id);

create index idx_email_schedule_send on email_schedule (send_at asc);

create index idx_email_schedule_delivered on email_schedule (delivered_at desc);