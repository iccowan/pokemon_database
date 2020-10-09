/* Create the pokemon table */

CREATE TABLE pokemon (
    PRIMARY KEY (pokemon_id),
    pokemon_id          INT unsigned    NOT NULL AUTO_INCREMENT,
    pokemon_name        VARCHAR(32)     NOT NULL,
    pokemon_type_id     INT unsigned    NOT NULL,
    pokemon_level       INT             NOT NULL,
    trainer_id          INT unsigned    NOT NULL,
    FOREIGN KEY (trainer_id)      REFERENCES trainers     (trainer_id),
    FOREIGN KEY (pokemon_type_id) REFERENCES pokemon_type (pokemon_type_id),
    CHECK (pokemon_level >=1 AND pokemon_level <=100)
);

/*
*   This trigger will run every time a new record is inserted into
*   the pokemon table and confirm that the trainer doesn't already have
*   6 or more pokemon.
*/
DELIMITER $$
CREATE TRIGGER max_pokemon
    BEFORE INSERT ON pokemon
    FOR EACH ROW
BEGIN
        IF (SELECT COUNT(*)
              FROM pokemon
             WHERE pokemon.trainer_id = NEW.trainer_id) >= 6
        THEN
            SIGNAL SQLSTATE '14000'
               SET MESSAGE_TEXT='Unable to create new pokemon. This trainer already has 6 or more pokemon.';
        END IF;
END;
$$
DELIMITER ;
