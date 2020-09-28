/*  This can be used to create a record to the "items_used" table
*   For a prepared statement, the following values should be used:
*   'ii'
*/

INSERT INTO items_used (purchased_id, challenge_id)
VALUES (?, ?);