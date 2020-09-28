/*
*   Team Data Database Creator
*   This will create the database and be the "hub" to handle creating
*   all of the tables required for the database
*/

/* Create the database and drop the old version, if it exists */
DROP DATABASE IF EXISTS pokemon_league;
CREATE DATABASE pokemon_league;
USE pokemon_league;

/* Now, let's create each of the tables from their own files */

/* trainers table */
SOURCE trainers.sql;