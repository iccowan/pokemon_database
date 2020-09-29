/*  This can be used to view all records from the "trainers" table
*   For a prepared statement, the following values should be used:
*   'i'
*/

SELECT * FROM trainers
        WHERE trainer_id = ?;