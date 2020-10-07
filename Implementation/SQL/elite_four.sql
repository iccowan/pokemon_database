/* Create the elite four table */

CREATE TABLE elite_four(
    PRIMARY KEY (trainer_id),
    trainer_id              INT unsigned    NOT NULL,
    rank                    INT unsigned    NOT NULL,
    FOREIGN KEY (trainer_id) REFERENCES trainers (trainer_id)
);