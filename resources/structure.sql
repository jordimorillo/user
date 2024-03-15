drop table if exists events;
create table events
(
    eventId           varchar(255) not null,
    domainEvent       longtext     not null,
    commandHandlerFQN text         not null,
    occurredOn        datetime     not null
);

create unique index events_eventId_uindex
    on events (eventId);

alter table events
    add constraint events_pk
        primary key (eventId);

-- Here comes the initial mysql queries that build tables
drop table if exists users;
create table users
(
    user_id           varchar(255)     not null,
    email             varchar(255)     not null,
    password          varchar(255)     not null
);

create unique index users_user_id_uindex
    on users (user_id);

alter table users
    add constraint users_pk
        primary key (user_id);
