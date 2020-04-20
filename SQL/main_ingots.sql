create table ingots
(
    id            integer
        constraint ingots_pk
            primary key autoincrement,
    title         text not null,
    keen_crap_fix double default 1.00 not null
);

create unique index ingots_title_uindex
    on ingots (title);

INSERT INTO ingots (id, title, keen_crap_fix) VALUES (1, 'cobalt', 1.463463463);
INSERT INTO ingots (id, title, keen_crap_fix) VALUES (2, 'nickel', 1.168);
INSERT INTO ingots (id, title, keen_crap_fix) VALUES (3, 'iron', 1.0139860139);
INSERT INTO ingots (id, title, keen_crap_fix) VALUES (4, 'platinum', 1.4620875);
INSERT INTO ingots (id, title, keen_crap_fix) VALUES (5, 'uranium', 1.53646);
INSERT INTO ingots (id, title, keen_crap_fix) VALUES (6, 'magnesium', 1.1351322978);
INSERT INTO ingots (id, title, keen_crap_fix) VALUES (7, 'silver', 1.2309999999);
INSERT INTO ingots (id, title, keen_crap_fix) VALUES (8, 'silicon', 1.153846154);
INSERT INTO ingots (id, title, keen_crap_fix) VALUES (9, 'gold', 1.11215);
INSERT INTO ingots (id, title, keen_crap_fix) VALUES (10, 'gravel', 1);
INSERT INTO ingots (id, title, keen_crap_fix) VALUES (11, 'ice', 1);
INSERT INTO ingots (id, title, keen_crap_fix) VALUES (12, 'scrap', 1);