/* Create the purchased_items table */

CREATE TABLE purchased_items (
    PRIMARY KEY  (purchased_id),
    purchased_id INT unsigned NOT NULL AUTO_INCREMENT,
    item_id      INT unsigned NOT NULL,
    trainer_id   INT unsigned NOT NULL,
    FOREIGN KEY  (item_id)
                 REFERENCES items (item_id),
    FOREIGN KEY  (trainer_id)
                 REFERENCES trainers (trainer_id)
);