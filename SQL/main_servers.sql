create table servers
(
    id                  integer not null
        constraint servers_pk
            primary key autoincrement,
    title               text    not null,
    system_stock_weight DECIMAL default 1,
    clusters_id         int     default 1 not null,
    types_id            int     default 0 not null
);

create unique index servers_id_uindex
    on servers (id);

INSERT INTO servers (id, title, system_stock_weight, clusters_id, types_id) VALUES (1, 'NUR4', 1, 1, 1);
INSERT INTO servers (id, title, system_stock_weight, clusters_id, types_id) VALUES (2, 'Carmenta', 1, 2, 1);
INSERT INTO servers (id, title, system_stock_weight, clusters_id, types_id) VALUES (3, 'Tellurn', 1, 2, 1);
INSERT INTO servers (id, title, system_stock_weight, clusters_id, types_id) VALUES (4, 'Kokkivo', 1, 2, 1);
INSERT INTO servers (id, title, system_stock_weight, clusters_id, types_id) VALUES (5, 'Videshee', 1, 2, 1);
INSERT INTO servers (id, title, system_stock_weight, clusters_id, types_id) VALUES (6, 'Twin Moons', 1, 2, 1);
INSERT INTO servers (id, title, system_stock_weight, clusters_id, types_id) VALUES (7, 'Nemesis', 1, 2, 1);
INSERT INTO servers (id, title, system_stock_weight, clusters_id, types_id) VALUES (8, 'Alpha', 1, 2, 2);
INSERT INTO servers (id, title, system_stock_weight, clusters_id, types_id) VALUES (9, 'Beta', 1, 2, 2);
INSERT INTO servers (id, title, system_stock_weight, clusters_id, types_id) VALUES (10, 'Gamma', 1, 2, 2);
INSERT INTO servers (id, title, system_stock_weight, clusters_id, types_id) VALUES (11, 'Omega', 1, 2, 2);