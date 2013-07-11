create table contents (
    id int(11) not null auto_increment primary key,
    name varchar(255) not null,
    user_id int(11) not null,
    content_id int(11) not null,
    content_type_id int(11) not null,
    created datetime,
    modified datetime
);

create table content_templates (
    id int(11) not null auto_increment primary key,
    template_id int(11) not null,
    name varchar(255) not null ,
    system_path varchar(255),
    created datetime,
    modified datetime
);

create table content_types (
    id int(11) not null auto_increment primary key,
    name varchar(255) not null,
    content_template_id int(11) not null,
    content_type_id int(11) not null,
    created datetime,
    modified datetime
);

create table content_type_properties (
    id int(11) not null auto_increment primary key,
    content_type_property_id int(11) not null,
    content_type_property_skel_id int(11) not null,
    value text,
    content_id int(11) not null,
    created datetime,
    modified datetime
);

create table content_type_property_skels (
    id int(11) not null auto_increment primary key,
    name varchar(255) not null,
    content_type_id int(11) not null,
    input_format_id int(11) not null,
    output_format_id int(11) not null,
    created datetime,
    modified datetime
);

create table groups (
    id int(11) not null auto_increment primary key,
    name varchar(255) not null,
    created datetime,
    modified datetime
);


create table input_formats (
    id int(11) not null primary key auto_increment,
    name varchar(255) not null,
    system_path varchar(255) not null,
    created datetime,
    modified datetime
);


create table output_formats(
    id int(11) not null primary key auto_increment,
    name varchar(255) not null,
    system_path varchar(255) not null,
    created datetime,
    modified datetime
);

create table users(
    id int(11) not null primary key auto_increment,
    username varchar(255) not null,
    password varchar(255) not null,
    group_id int(11) not null,
    created datetime,
    modified datetime
);

create table user_properties(
    id int(11) not null primary key auto_increment,
    value text,
    user_id int(11) not null,
    user_property_skel_id int(11) not null,
    created datetime,
    modified datetime

);

create table user_property_skels (
    id int(11) not null primary key auto_increment,
    name varchar(255) not null,
    group_id int(11) not null,
    input_format_id int(11) not null,
    output_format_id int(11) not null,
    created datetime,
    modified datetime

);