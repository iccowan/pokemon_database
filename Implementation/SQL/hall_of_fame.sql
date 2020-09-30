/* Creates Hall of Fame table*/

CREATE TABLE hall_of_fame (
    PRIMARY KEY(hof_id),
    hof_id      INT unsigned    NOT NULL AUTO_INCREMENT,
    trainer_id  INT unsigned    NOT NULL,
    pokemon_id  INT unsigned    NOT NULL,
    FOREIGN KEY(trainer_id) REFERENCES trainers(trainer_id),
    FOREIGN KEY(pokemon_id) REFERENCES pokemon(pokemon_id)
);