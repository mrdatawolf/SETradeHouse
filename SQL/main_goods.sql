create table goods
(
    id         INTEGER
        constraint goods_pk
            primary key autoincrement,
    good_title TEXT not null
);

INSERT INTO goods (id, good_title) VALUES (1, 'Ore');
INSERT INTO goods (id, good_title) VALUES (2, 'Ingot');
INSERT INTO goods (id, good_title) VALUES (3, 'Component');