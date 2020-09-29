/*  This can be used to create a record in the "actual_pokemon_types" table
*   For a prepared statement, the following values should be used:
*   's,s,i'
*/

INSERT INTO pokemon (pokemon_id, pokemon_type_id)
VALUES (?, ?);