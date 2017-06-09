create table files
(
	id int(10) unsigned auto_increment
		primary key,
	paste_id int(10) unsigned not null,
	filename varchar(255) null,
	content mediumblob not null
)
;

create index files_paste_id_index
	on files (paste_id)
;

create table pastes
(
	id int(10) unsigned not null
		primary key,
	title varchar(255) null,
	created_at datetime default CURRENT_TIMESTAMP not null
)
;

alter table files
	add constraint files_pastes_id_fk
		foreign key (paste_id) references code.pastes (id)
;

