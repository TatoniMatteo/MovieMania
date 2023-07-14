create table ruolo
(
    id        int auto_increment
        primary key,
    ruolo     varchar(255) not null,
    categoria tinyint      null
);

INSERT INTO moviemania.ruolo (id, ruolo, categoria) VALUES (1, 'Regista', 1);
INSERT INTO moviemania.ruolo (id, ruolo, categoria) VALUES (2, 'Attore', 2);
INSERT INTO moviemania.ruolo (id, ruolo, categoria) VALUES (3, 'Scrittore', 1);
INSERT INTO moviemania.ruolo (id, ruolo, categoria) VALUES (4, 'Scenografo', 3);
INSERT INTO moviemania.ruolo (id, ruolo, categoria) VALUES (5, 'Direttore artistico', 1);
INSERT INTO moviemania.ruolo (id, ruolo, categoria) VALUES (6, 'Costumista', 3);
INSERT INTO moviemania.ruolo (id, ruolo, categoria) VALUES (7, 'Cameraman', 3);
INSERT INTO moviemania.ruolo (id, ruolo, categoria) VALUES (8, 'Microfonista', 3);
