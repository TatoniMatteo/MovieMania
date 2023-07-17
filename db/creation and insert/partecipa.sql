create table partecipa
(
    id             int auto_increment
        primary key,
    id_personaggio int          not null,
    id_serie       int          null,
    id_film        int          null,
    ruolo          int          not null,
    interpreta     varchar(255) null,
    star           tinyint(1)   null,
    constraint fk_partecipa_film
        foreign key (id_film) references film (id)
            on update cascade,
    constraint fk_partecipa_personaggio
        foreign key (id_personaggio) references personaggi (id)
            on update cascade,
    constraint fk_partecipa_ruolo
        foreign key (ruolo) references ruolo (id)
            on update cascade,
    constraint fk_partecipa_serie
        foreign key (id_serie) references serie (id)
            on update cascade
);

INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (3, 3, null, 2, 2, 'Frodo ', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (4, 4, null, 2, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (15, 14, null, 2, 2, 'Gandalf', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (40, 15, null, 14, 3, null, 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (41, 17, null, 14, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (42, 18, null, 14, 2, 'Tony Stark / Iron Man', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (43, 19, null, 14, 2, 'Steve Rogers / Captain America', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (44, 20, null, 14, 2, 'Bruce Banner / Hulk', 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (45, 21, null, 14, 2, 'Thor', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (46, 22, null, 14, 2, 'Natasha Romanoff / Black Widow', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (47, 23, null, 14, 2, 'Scott Lang / Ant-Man', 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (48, 24, null, 14, 2, 'Stephen Strange / Doctor Strange', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (49, 16, null, 14, 4, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (97, 34, 13, null, 3, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (98, 32, 13, null, 2, 'Lord Anthony Bridgerton ', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (99, 33, 13, null, 2, 'Daphne Basset', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (103, 36, null, 10, 1, null, 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (104, 37, null, 10, 3, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (105, 35, null, 10, 2, 'Maximus Meridius', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (106, 38, 5, null, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (107, 39, 5, null, 2, 'Profesor', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (113, 40, null, 13, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (114, 41, null, 13, 2, 'Dr. Xander \'Smolder\' Bravestone', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (115, 42, null, 13, 2, 'Franklin \'Mouse\' Finbar', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (116, 44, null, 13, 2, 'Professor Sheldon \'Shelly\' Oberon', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (117, 43, null, 13, 2, 'Ruby Roundhouse', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (124, 46, null, 12, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (125, 13, null, 12, 2, 'Shazam', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (126, 48, null, 12, 2, 'Billy Batson', 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (127, 49, null, 12, 2, 'Freddy Freeman', 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (128, 46, null, 11, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (129, 45, null, 11, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (130, 13, null, 11, 2, 'Shazam', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (131, 47, null, 11, 2, 'Doctor Thaddeus Sivana', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (132, 49, null, 11, 2, 'Billy Batson', 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (133, 48, null, 11, 2, 'Freddy Freeman', 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (134, 50, null, 6, 1, null, 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (135, 1, null, 6, 2, 'Dom Cobb', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (136, 51, null, 6, 2, 'Arthur', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (137, 52, null, 6, 2, 'Ariadne', 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (142, 50, null, 9, 1, null, 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (143, 53, null, 9, 2, 'Bruce Wayne / Batman', 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (144, 54, null, 9, 2, 'Joker', 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (145, 55, null, 9, 2, 'Alfred Pennyworth', 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (146, 56, null, 9, 4, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (147, 58, null, 1, 1, null, 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (148, 1, null, 1, 2, 'Jack Dawson', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (149, 2, null, 1, 2, 'Rose DeWitt Bukater', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (163, 59, null, 5, 3, null, 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (164, 59, null, 5, 1, null, 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (165, 60, null, 5, 2, 'Vincent Vega', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (166, 61, null, 5, 2, 'Jules Winnfield', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (167, 59, null, 5, 4, null, 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (168, 8, null, 4, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (169, 9, null, 4, 3, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (170, 7, null, 4, 2, 'Forrest Gump', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (171, 10, null, 4, 2, 'Jenny Curran', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (172, 12, null, 4, 2, 'Lieutenant Dan Taylor', 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (173, 11, null, 4, 4, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (174, 64, null, 3, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (175, 65, null, 3, 3, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (176, 62, null, 3, 2, 'Don Vito Corleone', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (177, 63, null, 3, 2, 'Michael Corleone', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (178, 65, null, 3, 4, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (179, 64, null, 3, 4, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (180, 67, 2, null, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (181, 68, 2, null, 2, '', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (182, 70, 1, null, 1, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (183, 4, 1, null, 2, 'Walter White', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (184, 69, 1, null, 2, 'Jesse Pinkman', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (185, 26, 4, null, 3, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (186, 6, 4, null, 2, 'Rachel Green', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (187, 27, 4, null, 2, 'Monica Geller', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (188, 28, 4, null, 2, 'Phoebe Buffay', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (189, 29, 4, null, 2, 'Joey Tribbiani', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (190, 30, 4, null, 2, 'Chandler Bing', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (191, 31, 4, null, 2, 'Ross Geller', 1);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (192, 71, 3, null, 3, null, 0);
INSERT INTO moviemania.partecipa (id, id_personaggio, id_serie, id_film, ruolo, interpreta, star) VALUES (193, 5, 3, null, 2, 'Eleven', 1);
