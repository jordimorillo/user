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


-- Here come inserts and updates that prepare the fixtures for testing purposes