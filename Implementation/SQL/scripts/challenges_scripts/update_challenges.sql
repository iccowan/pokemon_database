/*  This can be used to update a record to the "challenges" table
*   For a prepared statement, the following values should be used:
*   'ii'
*/

UPDATE challenges SET trainer_id = ? WHERE challenge_id = ?;