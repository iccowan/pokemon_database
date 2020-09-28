/*  This can be used to view all records from the "items" table
*   For a prepared statement, the following values should be used:
*   'i'
*/

SELECT * FROM items
        WHERE item_id = ?;