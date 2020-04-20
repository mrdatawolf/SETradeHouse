create table trade_zones
(
    id           integer not null
        constraint trade_zone_pk
            primary key autoincrement,
    title        text    not null,
    owner_id     integer default 0,
    servers_id   integer,
    local_weight int     default 0
);

create unique index trade_zone_id_uindex
    on trade_zones (id);

INSERT INTO trade_zones (id, title, owner_id, servers_id, local_weight) VALUES (1, 'tz3', 1, 1, 1);
INSERT INTO trade_zones (id, title, owner_id, servers_id, local_weight) VALUES (2, 'tellurn tz6', 1, 3, 3);
INSERT INTO trade_zones (id, title, owner_id, servers_id, local_weight) VALUES (3, 'tellurn tz7', 1, 3, 3);
INSERT INTO trade_zones (id, title, owner_id, servers_id, local_weight) VALUES (4, 'carmenta tz2', 1, 2, 3);
INSERT INTO trade_zones (id, title, owner_id, servers_id, local_weight) VALUES (5, 'alpha tz2', 1, 8, 3);
INSERT INTO trade_zones (id, title, owner_id, servers_id, local_weight) VALUES (6, 'videshee tz1', 1, 5, 3);
INSERT INTO trade_zones (id, title, owner_id, servers_id, local_weight) VALUES (7, 'videshee tz4', 1, 5, 3);
INSERT INTO trade_zones (id, title, owner_id, servers_id, local_weight) VALUES (8, 'videshee tz5', 1, 5, 1);