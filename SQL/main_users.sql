create table users
(
    id         INTEGER      not null
        primary key autoincrement,
    username   VARCHAR(50)  not null
        unique,
    password   VARCHAR(255) not null,
    cluster_id INTEGER      not null,
    created_at DATETIME default CURRENT_TIMESTAMP,
    updated_at DATETIME default CURRENT_TIMESTAMP
);

