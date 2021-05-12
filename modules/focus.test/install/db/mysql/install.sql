create table if not exists b_log
(
	ID int not null AUTO_INCREMENT,
	TIMECREATE datetime not null,
	IP varchar(250) not null,
	AGENT varchar(250) not null,
	URL varchar(250) not null,
	USER_ID int not null default '0',
	primary key (ID)
);