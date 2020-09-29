/*  This can be used to update a record to the "trainers" table
*   For a prepared statement, the following values should be used:
*   'ii'
*/

UPDATE trainers
   SET rival_id = ?
 WHERE trainer_id = ?;
