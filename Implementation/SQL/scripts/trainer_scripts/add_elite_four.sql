/*  This can be used to create a record in the "elite_four" table
*   For a prepared statement, the following values should be used:
*   'i,i'
*/

INSERT INTO pokemon (trainer_id, rank)
VALUES (?, ?);
