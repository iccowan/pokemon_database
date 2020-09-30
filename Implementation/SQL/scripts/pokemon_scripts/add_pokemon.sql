/*  This can be used to create a record in the "pokemon" table
*   For a prepared statement, the following values should be used:
*   's,s,i'
*/

INSERT INTO pokemon (pokemon_name, pokemon_level, trainer_id)
VALUES (?, ?, ?);