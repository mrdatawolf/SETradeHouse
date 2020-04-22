create table users
(
    id         INTEGER      not null
        primary key autoincrement,
    username   VARCHAR(50)  not null
        unique,
    password   VARCHAR(255) not null,
    created_at DATETIME default CURRENT_TIMESTAMP,
    cluster_id int      default 1 not null,
    updated_at DATETIME default CURRENT_TIMESTAMP
);

INSERT INTO users (id, username, password, created_at, cluster_id, updated_at) VALUES (3, 'testexpanse', '$2y$10$sn7Cu4jjHpp56IKA0UgBL.aNdG841Ei2R2wvk0kESTc7DqGoyOyzK', '2020-04-22 04:54:31', 2, '2020-04-22 04:54:31');
INSERT INTO users (id, username, password, created_at, cluster_id, updated_at) VALUES (4, 'testnebulon', '$2y$10$kaMxkrE8QB.TfgkzTwukh.Gbb0Pz3ac7aJeX5Unobq6MGzU2hXO5C', '2020-04-22 04:54:46', 1, '2020-04-22 04:54:46');