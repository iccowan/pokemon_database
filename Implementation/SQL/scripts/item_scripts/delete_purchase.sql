/*  This can be used to delete a record to the "purchased_items" table
*   For a prepared statement, the following value should be used:
*   'i'
*/

DELETE FROM purchased_items
 WHERE purchased_id = ?;