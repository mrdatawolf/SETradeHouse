create table active_transactions
(
    id                  INTEGER
        constraint active_transactions_pk
            primary key autoincrement,
    trade_zones_id      int      not null,
    servers_id          int      not null,
    clusters_id         int      not null,
    value               DECIMAL  not null,
    amount              DECIMAL  not null,
    created_at          DATETIME not null,
    updated_at          DATETIME,
    transaction_type_id int default 1 not null,
    goods_type_id       int default 1 not null,
    goods_id            int default 1 not null
);

create unique index active_buys_id_uindex
    on active_transactions (id);

INSERT INTO active_transactions (id, trade_zones_id, servers_id, clusters_id, value, amount, created_at, updated_at, transaction_type_id, goods_type_id, goods_id) VALUES (12, 1, 1, 1, 300, 1000000, '1587231797000', '1587231799000', 1, 1, 1);