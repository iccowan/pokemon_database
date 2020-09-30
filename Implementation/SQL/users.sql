/* Create the users table */

CREATE TABLE users (
    PRIMARY KEY (trainer_id),
    trainer_id      INT unsigned    NOT NULL AUTO_INCREMENT,
    password        VARCHAR(256)    NOT NULL,
    remember_token  VARCHAR(256)    NOT NULL,
    FOREIGN KEY (trainer_id) REFERENCES trainers (trainer_id)
);