/*  This can be used to delete a record from the "pokemon" table
*   For a prepared statement, the following value should be used:
*   'i'
*/

DELETE FROM pokemon
 WHERE pokemon_id = ?;