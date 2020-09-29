/*  This can be used to view all records from the "actual_pokemon_types" table
*   For a prepared statement, the following values should be used:
*   'i'
*/

SELECT * FROM actual_pokemon_types
        WHERE pokemon_id = ?;