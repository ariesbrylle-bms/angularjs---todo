create database myNotes;

create table todo_notes
(
    id int auto_increment,
    type varchar(25),
    title varchar(50),
    description text,
    is_active TINYINT(1) DEFAULT 1,
    date_time_added datetime,
    is_deleted TINYINT(1),
    date_time_deleted datetime,
    is_completed tinyint(1),
    date_time_completed datetime,
    primary key(id)
)
