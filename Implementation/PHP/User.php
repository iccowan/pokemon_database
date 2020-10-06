<?php

/*
*   This model is used to authenticate users and ensure that they are
*   authenticated. This will use cookies and sessions to keep track
*   of everyone logged in
*/

class User {
    // Get the encryption key for the project
    private static function get_encrypt_key() {
        $env = fopen("../.env", "r") or die(".env file does not exist! Please
                                              run `php createEncKey.php first`");
        $information = array();

        while(! feof($env)) {
            $exploded = explode("=", fgets($env));
            if(count($exploded) == 2) {
                $information[$exploded[0]] = trim(trim($exploded[1]), '"');
            } else {
                $information[$exploded[0]] = "";
            }
        }

        if($information['encrypt_key'] == "") {
            echo ".env file has no encryption key! Please run `php createEncKey.php`";
            exit;
        }

        return $information['encrypt_key'];
    }

    // Add a user to the database. Should be run everytime a trainer is added

    // Login the user and return a User object
    // Return false if no user found, or if the username or password
    // was incorrect
    public static function login($username, $password) {
        $user = new self();

        // Connect to the database, and find the user
        require_once('DBConnect.php');
        $connection = new DBConnect();
        $conn = $connection->getConnection();
        $get_user = $conn->prepare("SELECT * FROM trainers WHERE trainer_name = ?");
        $get_user->bind_param("s", $name);
        $name = $username;
        
        $trainer_record = $get_user->execute();
        $get_user->close();

        // Now, make sure the user exists and the password is correct
        $user_info = $conn->prepare("SELECT password, remember_token FROM users WHERE trainer_id = ?");
        $user_info->bind_param("i", $user_id);
        $user_id = $trainer_record[0];
        
        if(! $user_record = $user_info->execute()) {
            return false;
        }

        $user_info->close();

        // Make sure we have a user that has been returned
        $user_record->fetch_all();
        if(count($user_record) == 0)
            return false;

        // Now, get the user
        $user = $user_record[0];
        $pass = $user[0];

        $enc_key = get_encrypt_key();

        // Decrypt the user's password
        $pass_decrypt = openssl_decrypt($pass, 'AES-128-CBC', $enc_key);

        if($pass_decrypt == $password) {
            // Yay! Let's log the user in
            $remember_token = md5(uniqid(rand(), true));
            $enc_remember_token = openssl_encrypt($remember_token,
                                                  'AES-128-CBC', $enc_key);
            
            // Set a cookie with the remember_token and start a session
            setcookie('remember_token', $remember_token, time() + 60 * 60 * 24);
            session_start();

            // Store the remember_token in the database
            $update_query = "UPDATE users SET remember_token = " .
                             $enc_remember_token .
                             " WHERE trainer_id = " .
                             $user_id . ";";

            if(! $conn->query($update_query)) {
                echo "Error logging in...";
                exit;
            }

            // Finished authenticating!
            return true;
        } else {
            // Uh oh, wrong password
            return false;
        }
    }

    // This function will return whether or not the current user is authenticated
    // If they are not authenticated, return false
    // If they are authenticated, return true
    public static function isAuth() {
        //
    }

    // This function will check if the current user is authenticated and
    // if they are, it will return nothing but if they are not it will
    // automatically redirect to the login page
    public static function authenticate() {
        //
    }

    // This function will get the username of the currently authenticated user
    public static function getUsername() {

    }
}

?>