create table ores
(
    id                           integer default 1
        constraint ores_pk
            primary key autoincrement,
    title                        TEXT not null,
    base_processing_time_per_ore DECIMAL default 0,
    base_conversion_efficiency   DECIMAL default 0,
    keen_crap_fix                DECIMAL default 1.00,
    module_efficiency_modifier   DECIMAL default .25,
    ore_per_ingot                DECIMAL default 3.33 not null
);

create unique index ores_id_uindex
    on ores (id);

create unique index ores_title_uindex
    on ores (title);

INSERT INTO ores (id, title, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) VALUES (1, 'cobalt', 4, 0.3, 45.04501198, 0.17150773735, 3.33);
INSERT INTO ores (id, title, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) VALUES (2, 'nickel', 2, 0.4, 19.99998532, 0.135, 2.5);
INSERT INTO ores (id, title, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) VALUES (3, 'iron', 0.05, 0.7, 34.9650093, 0.045, 1.43);
INSERT INTO ores (id, title, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) VALUES (4, 'platinum', 4, 0.005, 0.999999266, 10.9375, 200);
INSERT INTO ores (id, title, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) VALUES (5, 'uranium', 4, 0.007, 2.49999817, -2.90175, 100);
INSERT INTO ores (id, title, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) VALUES (6, 'magnesium', 1, 0.007, 0.6999854863, 7.81325, 142.86);
INSERT INTO ores (id, title, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) VALUES (7, 'silver', 1, 0.1, 9.99999266, 0.5395, 10);
INSERT INTO ores (id, title, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) VALUES (8, 'silicon', 0.6, 0.7, 34.9650093, 0.045, 1.43);
INSERT INTO ores (id, title, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) VALUES (9, 'gold', 0.4, 0.01, 0.999999266, 5.346, 100);
INSERT INTO ores (id, title, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) VALUES (10, 'stone', 0.1, 0.014, 0, 0.0035, 71.43);
INSERT INTO ores (id, title, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) VALUES (11, 'ice', 1, 1.05, 0, 0, 1.19);
INSERT INTO ores (id, title, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) VALUES (12, 'scrap', 0.05, 0.7, 0, 0.25125, 0.781);
INSERT INTO ores (id, title, base_processing_time_per_ore, base_conversion_efficiency, keen_crap_fix, module_efficiency_modifier, ore_per_ingot) VALUES (13, 'space credit', 1, 1, 1, 1, 1);