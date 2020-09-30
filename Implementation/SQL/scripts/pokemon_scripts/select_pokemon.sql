/*  This can be used to view all records from the "pokemon" table
*   For a prepared statement, the following values should be used:
*   'i'
*/

SELECT * FROM pokemon
        WHERE pokemon_id = ?;