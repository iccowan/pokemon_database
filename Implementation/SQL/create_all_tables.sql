/*
*   Team Data Database Creator
*   This will create the database and be the "hub" to handle creating
*   all of the tables required for the database
*/

/* Create the database and drop the old version, if it exists */
DROP DATABASE IF EXISTS pokemon_league;
CREATE DATABASE pokemon_league;
USE pokemon_league;

/* Disable foreign key checks so we can properly create the tables */
SET foreign_key_checks = 0;

/* Now, let's create each of the tables from their own files */

/* trainers table */
SOURCE trainers.sql;

/* pokemon table */
SOURCE pokemon.sql;

/* pokemon_types table */
SOURCE pokemon_type.sql;

/* actual_pokemon_types table */
SOURCE actual_pokemon_types.sql;

/* elite_four table */
SOURCE elite_four.sql

/* items table */
SOURCE items.sql;

/* purchased_items table */
SOURCE purchased_items.sql;

/* items_used table */
SOURCE items_used.sql;

/* challenges table */
SOURCE challenges.sql;

/* pokemon_used_for_challenge table */
SOURCE pokemon_used_for_challenges.sql;

/* hall_of_fame table */
SOURCE hall_of_fame.sql;

/* Re-enable foreign key checks so they are checked properly */
SET foreign_key_checks = 1;
