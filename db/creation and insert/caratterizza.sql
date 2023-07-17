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

INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (3, null, 2, 6);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (4, null, 2, 1);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (99, null, 14, 1);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (100, null, 14, 15);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (101, null, 14, 5);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (146, 13, null, 7);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (147, 13, null, 19);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (150, null, 10, 1);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (151, null, 10, 19);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (152, 5, null, 10);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (153, 5, null, 17);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (154, 5, null, 1);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (158, null, 13, 6);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (159, null, 13, 11);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (160, null, 13, 2);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (164, null, 12, 1);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (165, null, 12, 15);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (166, null, 12, 11);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (167, null, 11, 1);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (168, null, 11, 2);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (169, null, 11, 15);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (170, null, 6, 5);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (171, null, 6, 8);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (175, null, 9, 1);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (176, null, 9, 6);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (177, null, 9, 15);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (178, null, 1, 3);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (179, null, 1, 7);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (186, null, 5, 10);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (187, null, 5, 8);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (188, null, 4, 3);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (189, null, 4, 7);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (190, null, 3, 10);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (191, null, 3, 3);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (192, 2, null, 6);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (193, 2, null, 11);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (194, 1, null, 10);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (195, 1, null, 3);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (196, 4, null, 2);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (197, 4, null, 7);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (198, 3, null, 6);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (199, 3, null, 11);
INSERT INTO moviemania.caratterizza (id, id_serie, id_film, id_categoria) VALUES (200, 3, null, 17);
