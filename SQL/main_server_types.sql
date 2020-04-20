create table server_types
(
    id    INTEGER
        constraint system_types_pk
            primary key autoincrement,
    title text not null
);

create unique index system_types_id_uindex
    on server_types (id);

INSERT INTO server_types (id, title) VALUES (1, 'planet');
INSERT INTO server_types (id, title) VALUES (2, 'asteroids');