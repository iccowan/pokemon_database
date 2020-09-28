/* Create the elite four table */

CREATE TABLE elite_four(
    PRIMARY KEY (trainer_id),
    trainer_id  INT unsigned    NOT NULL AUTO_INCREMENT,
    rank        INT unsigned    NOT NULL
);