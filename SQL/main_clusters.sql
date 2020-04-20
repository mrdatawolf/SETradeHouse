create table clusters
(
    id                         integer
        constraint cluster_pk
            primary key autoincrement,
    title                      text not null,
    economy_ore_id             int default 4 not null,
    economy_stone_modifier     int default 10 not null,
    scaling_modifier           int default 10 not null,
    economy_ore_value          int default 1,
    asteroid_scarcity_modifier int default 15 not null,
    planet_scarcity_modifier   int default 10 not null,
    base_modifier              int default 1
);

create unique index cluster_id_uindex
    on clusters (id);

INSERT INTO clusters (id, title, economy_ore_id, economy_stone_modifier, scaling_modifier, economy_ore_value, asteroid_scarcity_modifier, planet_scarcity_modifier, base_modifier) VALUES (1, 'Nebulon Cluster', 4, 1, 10, 1, 5, 10, 1);
INSERT INTO clusters (id, title, economy_ore_id, economy_stone_modifier, scaling_modifier, economy_ore_value, asteroid_scarcity_modifier, planet_scarcity_modifier, base_modifier) VALUES (2, 'The Expanse', 4, 10, 140, 1, 15, 10, 1);