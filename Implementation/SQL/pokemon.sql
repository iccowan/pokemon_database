/* Create the pokemon table */

CREATE TABLE pokemon (
    PRIMARY KEY (pokemon_id),
    pokemon_id          INT unsigned    NOT NULL AUTO_INCREMENT,
    pokemon_name        VARCHAR(32)     NOT NULL,
    pokemon_type_id     INT             NOT NULL,
    pokemon_level       INT             NOT NULL,
    trainer_id          INT unsigned    NOT NULL,
    FOREIGN KEY (trainer_id)      REFERENCES trainers     (trainer_id),
    FOREIGN KEY (pokemon_type_id) REFERENCES pokemon_type (pokemon_type_id)
);