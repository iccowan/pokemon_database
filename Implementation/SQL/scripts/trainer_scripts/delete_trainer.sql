/*  This can be used to delete a record from the "trainers" table
*   For a prepared statement, the following value should be used:
*   'i'
*/

DELETE FROM trainers
 WHERE trainer_id = ?;