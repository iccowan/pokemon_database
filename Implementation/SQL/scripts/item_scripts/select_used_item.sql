/*  This can be used to view all records from the "items_used" table
*   For a prepared statement, the following values should be used:
*   'ii'
*/

SELECT * FROM items_used
        WHERE purchased_id = ? AND
              challenge_id = ?;