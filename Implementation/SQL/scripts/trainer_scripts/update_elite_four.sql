/*  This can be used to update a record to the "elite_four" table
*   For a prepared statement, the following values should be used:
*   'ii'
*/

UPDATE elite_four
   SET trainer = ?, rank = ?
 WHERE trainer_id = ?;
