create table ruolo
(
    id    int auto_increment
        primary key,
    ruolo varchar(255) not null
);

INSERT INTO moviemania.ruolo (id, ruolo) VALUES (1, 'Regista');
INSERT INTO moviemania.ruolo (id, ruolo) VALUES (2, 'Attore');
INSERT INTO moviemania.ruolo (id, ruolo) VALUES (3, 'Scrittore');
INSERT INTO moviemania.ruolo (id, ruolo) VALUES (4, 'Scenografo');
INSERT INTO moviemania.ruolo (id, ruolo) VALUES (5, 'Direttore artistico');
