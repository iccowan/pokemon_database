/*  This can be used to view all records from the "purchased_items" table
*   For a prepared statement, the following values should be used:
*   'i'
*/

SELECT * FROM purchased_items
        WHERE purchased_id = ?;