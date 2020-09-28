/*  This can be used to create a record to the "items" table
*   For a prepared statement, the following values should be used:
*   'ss'
*/

INSERT INTO items (item_name, item_description)
VALUES (?, ?);