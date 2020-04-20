create table inactive_transactions
(
    id               INTEGER  not null
        constraint inactive_transactions_pk
            primary key autoincrement,
    tradestation_id  int      not null,
    server_id        int      not null,
    cluster_id       int      not null,
    transaction_type int      not null,
    value            DECIMAL  not null,
    amount           DECIMAL  not null,
    created_at       DATETIME not null,
    updated_at       DATETIME not null,
    good_type        int default 1 not null,
    good_id          int default 1 not null
);

INSERT INTO inactive_transactions (id, tradestation_id, server_id, cluster_id, transaction_type, value, amount, created_at, updated_at, good_type, good_id) VALUES (2, 1, 1, 1, 1, 1, 1, '1587329388000', '1587329394000', 1, 1);