create table caratterizza
(
    id           int auto_increment
        primary key,
    id_serie     int null,
    id_film      int null,
    id_categoria int not null,
    constraint fk_caratterizza_categoria
        foreign key (id_categoria) references categoria (id)
            on update cascade,
    constraint fk_caratterizza_film
        foreign key (id_film) references film (id)
            on update cascade,
    constraint fk_caratterizza_serie
        foreign key (id_serie) references serie (id)
            on update cascade
);

INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (1, null, 1, 3);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (2, null, 1, 7);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (3, null, 2, 6);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (4, null, 2, 1);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (5, null, 3, 10);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (6, null, 3, 3);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (7, null, 4, 3);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (8, null, 4, 2);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (9, null, 5, 10);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (10, null, 5, 8);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (11, null, 6, 5);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (12, null, 6, 8);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (13, null, 7, 18);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (14, null, 7, 19);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (15, null, 8, 3);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (16, null, 8, 8);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (17, null, 9, 1);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (18, null, 9, 10);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (19, null, 10, 1);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (20, null, 10, 19);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (21, 1, null, 10);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (22, 1, null, 3);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (23, 2, null, 6);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (24, 2, null, 11);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (25, 3, null, 6);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (26, 3, null, 11);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (27, 4, null, 2);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (28, 4, null, 3);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (29, 5, null, 3);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (30, 5, null, 10);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (31, null, 11, 1);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (32, null, 11, 2);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (33, null, 11, 15);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (72, null, 13, 6);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (73, null, 13, 1);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (74, null, 13, 11);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (99, null, 14, 1);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (100, null, 14, 15);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (101, null, 14, 5);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (102, null, 12, 1);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (103, null, 12, 15);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (104, null, 12, 11);
