/*  This can be used to update a record to the "items" table
*   For a prepared statement, the following values should be used:
*   'ssi'
*/

UPDATE items
   SET item_name = ?, item_description = ?
 WHERE item_id = ?;