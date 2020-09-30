<?php

/*
*   This model is used to authenticate users and ensure that they are
*   authenticated. This will use cookies and sessions to keep track
*   of everyone logged in
*/

class User {
    private $remember_token;
    private $trainer_id;

    // Create a user object, but we aren't going to do anything initially
    // This should be used either prior to authenticating a user or
    // to check and see if a user is already authenticated
    public function __construct() {
        // Do nothing, but need to be able to create a user
    }

    // Login the user and return a User object
    // Return false if no user found, or if the username or password
    // was incorrect
    public static function login($username, $password) {
        $user = new self();

        // Connect to the database, and find the user
        $connection = new DBConnect();
        $conn = $connection->getConnection();
        $get_user = $conn->prepare("SELECT * FROM trainers WHERE ")

    }
}

?>