create table users
(
    id         INTEGER      not null
        primary key autoincrement,
    username   VARCHAR(50)  not null
        unique,
    password   VARCHAR(255) not null,
    created_at DATETIME default CURRENT_TIMESTAMP
);

