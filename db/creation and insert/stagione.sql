create table stagione
(
    id                 int auto_increment
        primary key,
    data_pubblicazione date       not null,
    copertina          mediumblob ,
    id_serie           int        not null,
    numero_stagione    int        not null,
    constraint fk_appartiene_stagione
        foreign key (id_serie) references stagione (id)
            on update cascade
);

INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (1, '2020-01-01', null, 1, 1);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (2, '2021-03-15', null, 1, 2);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (3, '2019-06-30', null, 2, 1);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (4, '2020-02-14', null, 2, 2);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (5, '2021-07-05', null, 2, 3);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (6, '2018-09-10', null, 3, 1);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (7, '2019-01-15', null, 3, 2);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (8, '2020-05-20', null, 4, 1);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (9, '2021-09-01', null, 4, 2);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (10, '2022-03-10', null, 4, 3);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (11, '2017-01-20', null, 5, 1);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (12, '2019-05-04', null, 5, 2);
INSERT INTO moviemania.stagione (id, data_pubblicazione, copertina, id_serie, numero_stagione) VALUES (13, '2022-03-18', null, 5, 3);
