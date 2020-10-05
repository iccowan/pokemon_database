/* Create the trainers table */

CREATE TABLE trainers (
    PRIMARY KEY (trainer_id),
    trainer_id      INT unsigned    NOT NULL AUTO_INCREMENT,
    trainer_name    VARCHAR(32)     NOT NULL,
    hometown        VARCHAR(32)     NOT NULL,
    rival_id        INT unsigned,
    FOREIGN KEY (rival_id) REFERENCES trainers (trainer_id)
);