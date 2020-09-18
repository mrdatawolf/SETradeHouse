 create table ammo
    (
    id integer not null
    primary key autoincrement,
    title varchar not null,
    se_name varchar not null,
    cobalt numeric not null,
    gold numeric not null,
    iron numeric not null,
    magnesium numeric not null,
    nickel numeric not null,
    platinum numeric not null,
    silicon numeric not null,
    silver numeric not null,
    gravel numeric not null,
    uranium numeric not null,
    naquadah numeric not null,
    trinium numeric not null,
    neutronium numeric not null,
    mass numeric not null,
    volume numeric not null
    );

    create table bottles
    (
    id integer not null
    primary key autoincrement,
    title varchar not null,
    se_name varchar not null,
    cobalt numeric not null,
    gold numeric not null,
    iron numeric not null,
    magnesium numeric not null,
    nickel numeric not null,
    platinum numeric not null,
    silicon numeric not null,
    silver numeric not null,
    gravel numeric not null,
    uranium numeric not null,
    naquadah numeric not null,
    trinium numeric not null,
    neutronium numeric not null,
    mass numeric not null,
    volume numeric not null
    );

    create table components
    (
    id integer not null
    primary key autoincrement,
    title varchar not null,
    se_name varchar not null,
    cobalt numeric default 0,
    gold numeric default 0,
    iron numeric default 0,
    magnesium numeric default 0,
    nickel numeric default 0,
    platinum numeric default 0,
    silicon numeric default 0,
    silver numeric default 0,
    gravel numeric default 0,
    uranium numeric default 0,
    naquadah numeric default 0,
    trinium numeric default 0,
    neutronium numeric default 0,
    mass numeric default 0,
    volume numeric default 0
    );

    create table failed_jobs
    (
    id integer not null
    primary key autoincrement,
    connection text not null,
    queue text not null,
    payload text not null,
    exception text not null,
    failed_at datetime default CURRENT_TIMESTAMP not null
    );

    create table good_types
    (
    id integer not null
    primary key autoincrement,
    title varchar not null
    );

    create table inactive_transactions
    (
    id integer not null
    primary key autoincrement,
    owner varchar not null,
    trade_zone_id integer not null,
    world_id integer not null,
    server_id integer not null,
    transaction_type_id integer not null,
    good_type_id integer not null,
    good_id integer not null,
    value numeric not null,
    amount numeric not null,
    created_at datetime,
    updated_at datetime
    );

    create table ingots
    (
    id integer not null
    primary key autoincrement,
    title varchar not null,
    se_name varchar not null,
    keen_crap_fix float not null
    );

    create table magic_numbers
    (
    id integer not null
    primary key autoincrement,
    server_id integer not null,
    module_base_efficiency numeric not null,
    base_multiplier_for_buy_vs_sell numeric not null,
    base_refinery_kwh numeric not null,
    base_refinery_speed numeric not null,
    base_drill_per_kw_hour numeric not null,
    markup_for_each_leg numeric not null,
    markup_total_change numeric not null,
    base_weight_for_world_stock numeric not null,
    weight_for_other_world_stock numeric not null,
    distance_weight numeric not null,
    cost_kw_hour numeric not null,
    base_labor_per_hour numeric not null,
    local_store_weight numeric not null
    );

    create table migrations
    (
    id integer not null
    primary key autoincrement,
    migration varchar not null,
    batch integer not null
    );

    create table npc_storage_values
    (
    id INTEGER not null
    primary key autoincrement,
    owner VARCHAR(255) not null,
    server_id INTEGER not null,
    world_id INTEGER not null,
    group_id INTEGER not null,
    item_id INTEGER not null,
    amount DOUBLE PRECISION not null,
    created_at DATETIME default NULL,
    updated_at DATETIME default NULL,
    origin_timestamp datetime
    );

    create table ores
    (
    id integer not null
    primary key autoincrement,
    title varchar not null,
    se_name varchar not null,
    base_processing_time_per_ore numeric not null,
    base_conversion_efficiency numeric not null,
    keen_crap_fix float not null,
    module_efficiency_modifier numeric not null,
    ore_per_ingot numeric not null
    );

    create table ingots_ores
    (
    ingots_id integer not null
    references ingots,
    ores_id integer not null
    references ores
    );

    create table password_resets
    (
    email varchar not null,
    token varchar not null,
    created_at datetime
    );

    create index password_resets_email_index
    on password_resets (email);

    create table scarcity_types
    (
    id integer not null
    primary key autoincrement,
    title varchar not null
    );

    create table servers
    (
    id integer not null
    primary key autoincrement,
    title varchar not null,
    scarcity_id integer not null,
    economy_ore_id integer not null,
    economy_stone_modifier integer not null,
    scaling_modifier integer not null,
    economy_ore_value integer not null,
    asteroid_scarcity_modifier integer not null,
    planet_scarcity_modifier integer not null,
    base_modifier integer not null
    );

    create table components_servers
    (
    components_id integer not null
    references components,
    servers_id integer not null
    references servers
    );

    create table ingots_servers
    (
    ingots_id integer not null
    references ingots,
    servers_id integer not null
    references servers
    );

    create table ores_servers
    (
    ores_id integer not null
    references ores,
    servers_id integer not null
    references servers
    );

    create table stations
    (
    id integer not null
    primary key autoincrement,
    title varchar not null,
    world_id integer not null
    );

    create table tools
    (
    id integer not null
    primary key autoincrement,
    title varchar not null,
    se_name varchar not null,
    cobalt numeric not null,
    gold numeric not null,
    iron numeric not null,
    magnesium numeric not null,
    nickel numeric not null,
    platinum numeric not null,
    silicon numeric not null,
    silver numeric not null,
    gravel numeric not null,
    uranium numeric not null,
    naquadah numeric not null,
    trinium numeric not null,
    neutronium numeric not null,
    mass numeric not null,
    volume numeric not null
    );

    create table trade_zones
    (
    id integer not null
    primary key autoincrement,
    title varchar not null,
    owner varchar not null,
    gps varchar not null,
    world_id integer not null,
    server_id integer not null,
    local_weight integer not null
    );

    create table transaction_types
    (
    id integer not null
    primary key autoincrement,
    title varchar not null
    );

    create table transactions
    (
    id INTEGER not null
    primary key autoincrement,
    owner VARCHAR(255) not null,
    trade_zone_id INTEGER not null,
    world_id INTEGER not null,
    server_id INTEGER not null,
    transaction_type_id INTEGER not null,
    good_type_id INTEGER not null,
    good_id INTEGER not null,
    value NUMERIC(10) not null,
    amount NUMERIC(10) not null,
    created_at DATETIME default NULL,
    updated_at DATETIME default NULL
    );

    create table trends
    (
    id integer not null
    primary key autoincrement,
    transaction_type_id integer not null,
    type_id integer not null,
    good_id integer not null,
    month integer not null,
    day integer not null,
    hour integer not null,
    latest_minute integer not null,
    amount float not null,
    sum float not null,
    count integer not null,
    average float not null,
    created_at datetime,
    updated_at datetime
    );

    create table user_storage_values
    (
    id INTEGER not null
    primary key autoincrement,
    owner VARCHAR(255) not null,
    server_id INTEGER not null,
    world_id INTEGER not null,
    group_id INTEGER not null,
    item_id INTEGER not null,
    amount DOUBLE PRECISION not null,
    created_at DATETIME default NULL,
    updated_at DATETIME default NULL,
    origin_timestamp datetime
    );

    create table users
    (
    id integer not null
    primary key autoincrement,
    username varchar not null,
    email varchar not null,
    email_verified_at datetime,
    password varchar not null,
    server_id integer not null,
    server_username varchar not null,
    remember_token varchar,
    created_at datetime,
    updated_at datetime
    );

    create unique index users_email_unique
    on users (email);

    create table world_types
    (
    id integer not null
    primary key autoincrement,
    title varchar not null
    );

    create table worlds
    (
    id integer not null
    primary key autoincrement,
    title varchar not null,
    server_id integer not null,
    type_id integer not null,
    system_stock_weight numeric not null
    );

    create table components_worlds
    (
    components_id integer not null
    references components,
    worlds_id integer not null
    references worlds
    );

    create table ingots_worlds
    (
    id integer not null
    primary key autoincrement,
    ingots_id integer not null
    references ingots,
    worlds_id integer not null
    references worlds
    );

    create table ores_worlds
    (
    ores_id integer not null
    references ores,
    worlds_id integer not null
    references worlds
    );

    create table worlds_links
    (
    world_id integer not null,
    remote_world_id integer not null
    );

