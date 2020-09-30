/*  This can be used to create a record to the "pokemon_type" table
*   For a prepared statement, the following values should be used:
*   'ss'
*/

INSERT INTO pokemon_type (type_name, description)
VALUES (?, ?);
