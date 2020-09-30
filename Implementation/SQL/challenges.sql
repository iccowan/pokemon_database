/*Create challenges table*/

CREATE TABLE challenges(
    PRIMARY KEY (challenge_id),
    challenge_id        INT unsigned     NOT NULL AUTO_INCREMENT,
    trainer_id          INT unsigned    NOT NULL,
    FOREIGN KEY(trainer_id) REFERENCES trainers(trainer_id)
);