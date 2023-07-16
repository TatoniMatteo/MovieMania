create table permessi
(
    id   int auto_increment
        primary key,
    nome varchar(255) not null
);

INSERT INTO moviemania.permessi (id, nome) VALUES (1, 'utente');
INSERT INTO moviemania.permessi (id, nome) VALUES (2, 'amministratore');
INSERT INTO moviemania.permessi (id, nome) VALUES (3, 'creatore');
