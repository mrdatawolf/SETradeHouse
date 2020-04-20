-- No source text available
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'sqlite_sequence', 'sqlite_sequence', 6, 'CREATE TABLE sqlite_sequence(name,seq)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'components', 'components', 12, 'CREATE TABLE "components"
(
	id integer not null
		constraint components_pk
			primary key autoincrement,
	title text not null,
	cobalt decimal default 0,
	gold decimal default 0,
	iron decimal default 0,
	magnesium decimal default 0,
	nickel decimal default 0,
	platinum decimal default 0,
	silicon decimal default 0,
	silver decimal default 0,
	gravel decimal default 0,
	uranium decimal default 0,
	mass decimal default 0.0,
	volume decimal default 0.0
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('index', 'components_id_uindex', 'components', 9, 'CREATE UNIQUE INDEX components_id_uindex
	on components (id)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'stations', 'stations', 11, 'CREATE TABLE stations
(
	id integer not null
		constraint stations_pk
			primary key autoincrement,
	title text not null,
	server_id integer default 1
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('index', 'stations_id_uindex', 'stations', 17, 'CREATE UNIQUE INDEX stations_id_uindex
	on stations (id)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'servers_links', 'servers_links', 20, 'CREATE TABLE servers_links
(
	server_id integer not null,
	remote_server_id integer not null
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'server_types', 'server_types', 8, 'CREATE TABLE "server_types"
(
	id INTEGER
		constraint system_types_pk
			primary key autoincrement,
	title text not null
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('index', 'system_types_id_uindex', 'server_types', 27, 'CREATE UNIQUE INDEX system_types_id_uindex
	on "server_types" (id)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'inactive_transactions', 'inactive_transactions', 35, 'CREATE TABLE "inactive_transactions"
(
	id INTEGER not null
		constraint inactive_transactions_pk
			primary key autoincrement,
	tradestation_id int not null,
	server_id int not null,
	cluster_id int not null,
	transaction_type int not null,
	value DECIMAL not null,
	amount DECIMAL not null,
	created_at DATETIME not null,
	updated_at DATETIME not null,
	good_type int default 1 not null,
	good_id int default 1 not null
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'transactions', 'transactions', 33, 'CREATE TABLE transactions
(
	id INTEGER not null
		constraint transactions_pk
			primary key autoincrement,
	title TEXT
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'goods', 'goods', 34, 'CREATE TABLE goods
(
	id INTEGER
		constraint goods_pk
			primary key autoincrement,
	good_title TEXT not null
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'ores_servers', 'ores_servers', 15, 'CREATE TABLE "ores_servers"
(
	ores_id int not null,
	servers_id int not null
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'servers', 'servers', 26, 'CREATE TABLE "servers"
(
	id integer not null
		constraint servers_pk
			primary key autoincrement,
	title text not null,
	system_stock_weight DECIMAL default 1,
	clusters_id int default 1 not null,
	types_id int default 0 not null
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('index', 'servers_id_uindex', 'servers', 14, 'CREATE UNIQUE INDEX servers_id_uindex
	on servers (id)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'ores', 'ores', 24, 'CREATE TABLE "ores"
(
	id integer default 1
		constraint ores_pk
			primary key autoincrement,
	title TEXT not null,
	base_processing_time_per_ore DECIMAL default 0,
	base_conversion_efficiency DECIMAL default 0,
	keen_crap_fix DECIMAL default 1.00,
	module_efficiency_modifier DECIMAL default .25
, ore_per_ingot DECIMAL default 3.33 not null)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('index', 'ores_id_uindex', 'ores', 5, 'CREATE UNIQUE INDEX ores_id_uindex
	on ores (id)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('index', 'ores_title_uindex', 'ores', 7, 'CREATE UNIQUE INDEX ores_title_uindex
	on ores (title)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'clusters_ores', 'clusters_ores', 18, 'CREATE TABLE "clusters_ores"
(
	clusters_id int not null,
	ores_id int not null
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'clusters', 'clusters', 19, 'CREATE TABLE "clusters"
(
	id integer
		constraint cluster_pk
			primary key autoincrement,
	title text not null,
	economy_ore_id int default 4 not null,
	economy_stone_modifier int default 10 not null,
	scaling_modifier int default 10 not null,
	economy_ore_value int default 1,
	asteroid_scarcity_modifier int default 15 not null,
	planet_scarcity_modifier int default 10 not null,
	base_modifier int default 1
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('index', 'cluster_id_uindex', 'clusters', 2, 'CREATE UNIQUE INDEX cluster_id_uindex
	on clusters (id)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'ingots', 'ingots', 21, 'CREATE TABLE "ingots"
(
	id integer
		constraint ingots_pk
			primary key autoincrement,
	title text not null,
	keen_crap_fix double default 1.00 not null
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('index', 'ingots_title_uindex', 'ingots', 4, 'CREATE UNIQUE INDEX ingots_title_uindex
	on ingots (title)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'clusters_ingots', 'clusters_ingots', 36, 'CREATE TABLE "clusters_ingots"
(
	clusters_id int not null,
	ingots_id int not null
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'magic_numbers', 'magic_numbers', 29, 'CREATE TABLE "magic_numbers"
(
	module_base_efficiency DECIMAL default .8,
	base_multiplier_for_buy_vs_sell DECIMAL default .75,
	base_refinery_kwh integer default 560,
	base_refinery_speed DECIMAL default 1.3,
	base_drill_per_kw_hour DECIMAL default 2,
	"markup_for_each_leg " DECIMAL default .03,
	markup_total_change DECIMAL default 1.03,
	base_weight_for_system_stock DECIMAL default 2,
	other_server_weight decimal default 1.0,
	distance_weight decimal default 0.0,
	server_id int,
	cost_kw_hour DECIMAL default 0.0012850929221,
	base_labor_per_hour DECIMAL default 7707.81
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'ingots_ores', 'ingots_ores', 16, 'CREATE TABLE "ingots_ores"
(
	ingots_id int not null,
	ores_id int not null
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'ingots_servers', 'ingots_servers', 10, 'CREATE TABLE ingots_servers
(
	ingots_id int not null,
	servers_id int not null
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'trade_zones', 'trade_zones', 25, 'CREATE TABLE "trade_zones"
(
	id integer not null
		constraint trade_zone_pk
			primary key autoincrement,
	title text not null,
	owner_id integer default 0,
	servers_id integer,
	local_weight int default 0
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('index', 'trade_zone_id_uindex', 'trade_zones', 3, 'CREATE UNIQUE INDEX trade_zone_id_uindex
	on trade_zones (id)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'active_transactions', 'active_transactions', 28, 'CREATE TABLE "active_transactions"
(
	id INTEGER
		constraint active_transactions_pk
			primary key autoincrement,
	trade_zones_id int not null,
	servers_id int not null,
	clusters_id int not null,
	value DECIMAL not null,
	amount DECIMAL not null,
	created_at DATETIME not null,
	updated_at DATETIME,
	transaction_type_id int default 1 not null,
	goods_type_id int default 1 not null,
	goods_id int default 1 not null
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('index', 'active_buys_id_uindex', 'active_transactions', 13, 'CREATE UNIQUE INDEX active_buys_id_uindex
	on active_transactions (id)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('table', 'users', 'users', 30, 'CREATE TABLE users (
                       id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT ,
                       username VARCHAR(50) NOT NULL UNIQUE,
                       password VARCHAR(255) NOT NULL,
                       created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)');
INSERT INTO sqlite_master (type, name, tbl_name, rootpage, sql) VALUES ('index', 'sqlite_autoindex_users_1', 'users', 31, null);