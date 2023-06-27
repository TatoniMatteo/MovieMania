create table stagione
(
    id                 int auto_increment
        primary key,
    data_pubblicazione date       not null,
    copertina          mediumblob not null,
    id_serie           int        not null,
    numero_stagione    int        not null,
    constraint fk_appartiene_stagione
        foreign key (id_serie) references stagione (id)
            on update cascade
);

INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (1, '2020-01-01', 0x636F70657274696E612E6A7067, 1, 1);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (2, '2021-03-15', 0x636F70657274696E612E6A7067, 1, 2);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (3, '2019-06-30', 0x636F70657274696E612E6A7067, 2, 1);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (4, '2020-02-14', 0x636F70657274696E612E6A7067, 2, 2);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (5, '2021-07-05', 0x636F70657274696E612E6A7067, 2, 3);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (6, '2018-09-10', 0x636F70657274696E612E6A7067, 3, 1);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (7, '2019-01-15', 0x636F70657274696E612E6A7067, 3, 2);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (8, '2020-05-20', 0x636F70657274696E612E6A7067, 4, 1);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (9, '2021-09-01', 0x636F70657274696E612E6A7067, 4, 2);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (10, '2022-03-10', 0x636F70657274696E612E6A7067, 4, 3);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (11, '2017-01-20', 0x636F70657274696E612E6A7067, 5, 1);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (12, '2019-05-04', 0x636F70657274696E612E6A7067, 5, 2);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (13, '2022-03-18', 0x636F70657274696E612E6A7067, 5, 3);
