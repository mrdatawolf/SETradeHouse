create table transactions
(
    id    INTEGER not null
        constraint transactions_pk
            primary key autoincrement,
    title TEXT
);

INSERT INTO transactions (id, title) VALUES (1, 'buy');
INSERT INTO transactions (id, title) VALUES (2, 'sell');