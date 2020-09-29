/*  This can be used to delete a record from the "actual_pokemon_types" table
*   For a prepared statement, the following value should be used:
*   'i'
*/

DELETE FROM actual_pokemon_types
 WHERE pokmon_id = ?;