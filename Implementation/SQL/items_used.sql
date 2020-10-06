/* Create the items used table */

CREATE TABLE items_used (
    PRIMARY KEY  (purchased_id, challenge_id),
    purchased_id INT unsigned NOT NULL,
    challenge_id INT unsigned NOT NULL,
    UNIQUE       (purchased_id),
    FOREIGN KEY  (purchased_id)
                 REFERENCES purchased_items (purchased_id)
                  ON DELETE RESTRICT,
    FOREIGN KEY  (challenge_id)
                 REFERENCES challenges (challenge_id)
                  ON DELETE RESTRICT
);