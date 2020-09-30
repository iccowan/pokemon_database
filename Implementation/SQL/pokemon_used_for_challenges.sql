/*Create the table that displays the pokemon used for challenges*/

CREATE TABLE pokemon_used_for_challenges(
    PRIMARY KEY (pokemon_challenge_id, pokemon_id),
    pokemon_challenge_id    INT unsigned    NOT NULL AUTO_INCREMENT,
    pokemon_id              INT unsigned    NOT NULL,
    challenge_id            INT unsigned    NOT NULL,
    UNIQUE      (pokemon_id),
    FOREIGN KEY (pokemon_id) REFERENCES pokemon (pokemon_id),
    FOREIGN KEY (challenge_id) REFERENCES challenges (challenge_id)
);