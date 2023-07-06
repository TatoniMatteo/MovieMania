create table recensione
(
    id              int auto_increment
        primary key,
    titolo          varchar(255)           not null,
    descrizione     text                   null,
    voto            decimal(3, 1)          not null,
    id_film         int                    null,
    id_serie        int                    null,
    id_utente       int                    not null,
    data_recensione date default curdate() null,
    constraint fk_recensione_film
        foreign key (id_film) references film (id)
            on update cascade,
    constraint fk_recensione_serie
        foreign key (id_serie) references serie (id)
            on update cascade,
    constraint fk_recensione_utente
        foreign key (id_utente) references utenti (id)
            on update cascade on delete cascade,
    check (`voto` >= 1 and `voto` <= 10)
);

INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (1, 'Ottimo film', 'Mi è piaciuto molto questo film. La trama è avvincente e gli attori sono fantastici.', 9.0, 1, null, 1, '2022-08-25');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (2, 'Deludente', 'Mi aspettavo di più da questo film. La storia è poco originale e gli effetti speciali sono mediocri.', 5.0, 1, null, 2, '2020-09-17');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (3, 'Da non perdere', 'Questa serie è semplicemente fantastica. Ogni episodio tiene incollato allo schermo.', 9.0, null, 1, 3, '2020-11-26');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (4, 'Un capolavoro', 'Ho amato ogni singola stagione di questa serie. È un mix perfetto di azione, suspense e intrighi.', 9.0, null, 1, 4, '2022-02-19');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (5, 'Consigliato', 'Un film commovente e ben interpretato. Ha saputo catturare le emozioni dello spettatore.', 8.0, 2, null, 2, '2022-10-21');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (6, 'Non all\'altezza delle aspettative', 'Mi aspettavo di più da questa serie. La trama è un po\' scontata e i personaggi poco sviluppati.', 6.0, null, 2, 3, '2022-03-04');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (7, 'Un capolavoro', 'La migliore serie che abbia mai visto. Non vedo l\'ora di scoprire cosa succederà nella prossima stagione.', 9.0, null, 2, 1, '2021-02-12');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (8, 'Film divertente', 'Una commedia leggera e divertente. Perfetta per una serata di relax.', 7.0, 3, null, 4, '2021-11-26');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (9, 'Suspense al massimo', 'Questa serie mi ha tenuto col fiato sospeso fino all\'ultima puntata. Consigliatissima!', 9.0, null, 3, 1, '2022-09-22');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (10, 'Superbo', 'Un film che ti cattura fin dal primo minuto. Grandi interpretazioni e una storia coinvolgente.', 9.0, 4, null, 2, '2021-08-09');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (11, 'Da rivedere', 'Una delle migliori serie di sempre. Ha saputo trattare tematiche complesse in modo brillante.', 9.0, null, 4, 1, '2022-04-02');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (12, 'Non mi è piaciuto', 'Questo film non è riuscito a coinvolgermi. La trama è confusa e gli attori poco convincenti.', 4.0, 5, null, 2, '2022-12-02');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (13, 'Serie eccezionale', 'Ho apprezzato molto questa serie. Personaggi ben sviluppati e una trama avvincente.', 9.0, null, 1, 2, '2023-05-11');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (14, 'Un film toccante', 'Questa pellicola mi ha emozionato profondamente. Gli attori hanno dato il massimo.', 8.0, 6, null, 4, '2023-02-17');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (15, 'Delusione totale', 'Mi aspettavo molto di più da questa serie. La storia è banale e i personaggi poco interessanti.', 5.0, null, 2, 4, '2023-01-18');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (16, 'Assolutamente da vedere', 'Una delle migliori serie degli ultimi anni. Non potrete fare a meno di innamorarvi dei personaggi.', 9.0, null, 3, 4, '2021-10-27');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (17, 'Film divertente', 'Una commedia leggera e piacevole. Perfetta per una serata di svago con gli amici.', 7.0, 7, null, 3, '2022-12-31');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (18, 'Intrigante e misteriosa', 'Questa serie mi ha catturato fin dall\'inizio. Ogni episodio ti lascia con il desiderio di scoprire di più.', 9.0, null, 4, 4, '2019-06-26');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (19, 'Capolavoro assoluto', 'Un film che rimarrà nella storia. Interpretazioni straordinarie e una trama avvincente.', 9.0, 8, null, 2, '2019-07-18');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (20, 'Una serie indimenticabile', 'Ho seguito questa serie per anni e non potrei essere più soddisfatto del suo finale.', 9.0, null, 5, 1, '2021-07-30');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (21, 'Un capolavoro che affascina e sorprende', 'Ho appena visto "Forrest Gump" e mi ha davvero colpito. È un film coinvolgente che ti terrà incollato allo schermo dall\'inizio alla fine.

La trama è piena di colpi di scena che ti terranno con il fiato sospeso. Gli attori sono incredibili, interpretano i loro personaggi in modo autentico e coinvolgente. La fotografia è stupefacente, con colori vibranti e inquadrature ben curate. La colonna sonora è emozionante e si integra perfettamente nelle scene.

Ciò che mi ha colpito di più di "Forrest Gump" è il modo in cui affronta temi universali come l\'amore e la ricerca della felicità. Mi ha fatto riflettere e mi ha emozionato.

In sintesi, se ti piacciono i film coinvolgenti e indimenticabili, ti consiglio "Forrest Gump". È un\'esperienza cinematografica da non perdere.', 10.0, 4, null, 3, '2015-02-17');
INSERT INTO moviemania.recensione (id, titolo, descrizione, voto, id_film, id_serie, id_utente, data_recensione) VALUES (23, 'Film davvero commuovente!', 'Il film mi è molto piaciuto!', 10.0, 1, null, 6, '2023-07-05');
