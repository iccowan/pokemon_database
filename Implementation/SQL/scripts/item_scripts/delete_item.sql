/*  This can be used to delete a record to the "items" table
*   For a prepared statement, the following value should be used:
*   'i'
*/

DELETE FROM items
 WHERE item_id = ?;