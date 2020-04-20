create table servers_links
(
    server_id        integer not null,
    remote_server_id integer not null
);

INSERT INTO servers_links (server_id, remote_server_id) VALUES (4, 9);
INSERT INTO servers_links (server_id, remote_server_id) VALUES (4, 10);
INSERT INTO servers_links (server_id, remote_server_id) VALUES (10, 4);
INSERT INTO servers_links (server_id, remote_server_id) VALUES (9, 4);