create table stations
(
    id        integer not null
        constraint stations_pk
            primary key autoincrement,
    title     text    not null,
    server_id integer default 1
);

create unique index stations_id_uindex
    on stations (id);

INSERT INTO stations (id, title, server_id) VALUES (1, 'Olympus', 1);