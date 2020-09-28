/* Create the items table */

CREATE TABLE items (
    PRIMARY KEY      (item_id),
    item_id          INT          unsigned NOT NULL AUTO_INCREMENT,
    item_name        VARCHAR(10)  NOT NULL,
    item_description VARCHAR(40)  NOT NULL
);