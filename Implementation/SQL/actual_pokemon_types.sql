/* Create the actual_pokemon_types table */

CREATE TABLE actual_pokemon_types (
    PRIMARY KEY (pokemon_id, pokemon_type_id),
    pokemon_id          INT unsigned        NOT NULL,
    pokemon_type_id     INT unsigned        NOT NULL,
    FOREIGN KEY (pokemon_id) REFERENCES pokemon (pokemon_id),
    FOREIGN KEY (pokemon_type_id) REFERENCES pokemon_type (pokemon_type_id)
);