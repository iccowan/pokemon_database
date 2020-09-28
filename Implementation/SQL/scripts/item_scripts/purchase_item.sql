/*  This can be used to create a record to the "purchased_items" table
*   For a prepared statement, the following values should be used:
*   'ii'
*/

INSERT INTO purchased_items (item_id, trainer_id)
VALUES (?, ?);