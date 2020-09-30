/*  This can be used to create a record in the "trainers" table
*   For a prepared statement, the following values should be used:
*   's,s,i'
*/

INSERT INTO pokemon (trainer_name, hometown, rival_id)
VALUES (?, ?, ?);