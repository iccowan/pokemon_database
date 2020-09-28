/* Create the pokemon type table */

CREATE TABLE pokemontype (
    PRIMARY KEY (pokemon_type_id),
    pokemon_type_id      INT NOT NULL AUTO_INCREMENT,
    type_name            VARCHAR(30) NOT NULL,
    description          VARCHAR(30) NOT NULL
);