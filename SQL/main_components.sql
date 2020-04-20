create table components
(
    id        integer not null
        constraint components_pk
            primary key autoincrement,
    title     text    not null,
    cobalt    decimal default 0,
    gold      decimal default 0,
    iron      decimal default 0,
    magnesium decimal default 0,
    nickel    decimal default 0,
    platinum  decimal default 0,
    silicon   decimal default 0,
    silver    decimal default 0,
    gravel    decimal default 0,
    uranium   decimal default 0,
    mass      decimal default 0.0,
    volume    decimal default 0.0
);

create unique index components_id_uindex
    on components (id);

INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (1, '5.56x45mm NATO magazine', 0, 0, 0.8, 0.15, 0.2, 0, 0, 0, 0, 0, 0.45, 0.2);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (2, '25x184mm NATO ammo container', 0, 0, 40, 3, 5, 0, 0, 0, 0, 0, 35, 16);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (3, '200mm missile container', 0, 0, 55, 1.2, 7, 0.04, 0.2, 0, 0, 0.1, 45, 60);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (4, 'Automatic Rifle', 0, 0, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (5, 'Bulletproof Glass', 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 15, 8);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (6, 'Canvas', 0, 0, 2, 0, 0, 0, 35, 0, 0, 0, 15, 8);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (7, 'Computer', 0, 0, 0.5, 0, 0, 0, 0.2, 0, 0, 0, 0.2, 1);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (8, 'Construction Comp.', 0, 0, 8, 0, 0, 0, 0, 0, 0, 0, 8, 2);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (9, 'Detector Comp.', 0, 0, 5, 0, 15, 0, 0, 0, 0, 0, 5, 0);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (10, 'Display', 0, 0, 1, 0, 0, 0, 5, 0, 0, 0, 8, 6);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (11, 'Elite Automatic Rifle', 0, 0, 3, 0, 1, 4, 0, 0, 0, 0, 3, 6);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (12, 'Elite Grinder', 1, 0, 3, 0, 1, 2, 2, 0, 0, 0, 5, 14);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (13, 'Elite Hand Drill', 0, 0, 20, 0, 3, 2, 3, 0, 0, 0, 22, 8);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (14, 'Elite Welder', 0.2, 0, 5, 0, 1, 2, 0, 0, 0, 0, 5, 120);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (15, 'Enhanced Grinder', 2, 0, 3, 0, 1, 0, 6, 0, 0, 0, 0, 8);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (16, 'Enhanced Hand Drill', 0, 0, 20, 0, 3, 0, 5, 0, 0, 0, 0, 0);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (17, 'Enhanced Welder', 0.2, 0, 5, 0, 1, 0, 2, 0, 0, 0, 0, 0);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (18, 'Explosives', 0, 0, 0, 2, 0, 0, 0.5, 0, 0, 0, 2, 0);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (19, 'Girder', 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 6, 2);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (20, 'Gravity Comp.', 220, 10, 600, 0, 0, 0, 0, 5, 0, 0, 800, 2);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (21, 'Interior Plate', 0, 0, 3, 0, 0, 0, 0, 0, 0, 0, 3, 200);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (22, 'Hydrogen Bottle', 0, 0, 80, 0, 30, 0, 0, 10, 0, 0, 30, 5);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (23, 'Large Steel Tube', 0, 0, 30, 0, 0, 0, 0, 0, 0, 0, 25, 120);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (24, 'Medical Comp.', 0, 0, 60, 0, 70, 0, 0, 20, 0, 0, 150, 38);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (25, 'Metal Grid', 3, 0, 12, 0, 5, 0, 0, 0, 0, 0, 6, 160);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (26, 'Metal Grid', 0, 0, 20, 0, 5, 0, 0, 0, 0, 0, 24, 15);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (27, 'Oxygen Bottle', 0, 0, 80, 0, 30, 0, 0, 10, 0, 0, 30, 8);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (28, 'Power Cell', 0, 0, 10, 0, 2, 0, 0, 10, 0, 0, 25, 120);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (29, 'Radio-comm Comp.', 8, 0, 0, 0, 0, 0, 1, 0, 0, 0, 8, 45);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (30, 'Reactor Comp.', 0, 0, 15, 0, 0, 0, 0, 5, 20, 0, 25, 140);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (31, 'Small Steel tube', 0, 0, 5, 0, 0, 0, 0, 0, 0, 0, 4, 8);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (32, 'Solar Cell', 0, 0, 0, 0, 3, 0, 6, 0, 0, 0, 8, 2);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (33, 'Stargate P90', 0, 0, 30, 0, 20, 3, 0, 0, 0, 0, 0, 20);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (34, 'Steel Plate', 0, 0, 21, 0, 0, 0, 0, 0, 0, 0, 20, 0);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (35, 'Superconductor', 0, 2, 10, 0, 0, 0, 0, 0, 0, 0, 15, 3);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (36, 'Thruster Comp.', 10, 1, 30, 0, 0, 1, 0, 0, 0, 0, 40, 8);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (37, 'Grinder', 0, 0, 3, 0, 1, 0, 1, 0, 5, 0, 0, 10);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (38, 'Hand Drill', 0, 0, 20, 0, 3, 0, 3, 0, 0, 0, 0, 0);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (39, 'Precise Automatic Rifle', 5, 0, 3, 0, 1, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (40, 'Proficient Grinder', 1, 0, 3, 0, 1, 0, 2, 2, 0, 0, 0, 0);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (41, 'Proficient Hand Drill', 0, 0, 20, 0, 3, 0, 3, 2, 0, 0, 0, 0);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (42, 'Proficient Welder', 0.2, 0, 5, 0, 1, 0, 0, 2, 0, 0, 0, 0);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (43, 'Rapid-Fire Automatic Rifle', 0, 0, 3, 0, 8, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO components (id, title, cobalt, gold, iron, magnesium, nickel, platinum, silicon, silver, gravel, uranium, mass, volume) VALUES (44, 'Welder', 0, 0, 5, 0, 1, 0, 0, 0, 3, 0, 0, 0);