/*Used to add a record to the "hall_of_fame" table
syntax for prepared statement should be:
i,i,i
*/

INSERT INTO hall_of_fame (hof_id,trainer_id,pokemon_id)
VALUES (?,?,?);