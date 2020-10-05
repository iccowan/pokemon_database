<?php

class Error {
    // Retrieve errors from the errors cookie
    public static function getErrors() {
        // If the errors cookie doesn't exist, just return an empty array
        if(!isset($_COOKIE['errors']))
            return array();

        // Now, we know the errors cookie exists so we'll return that array
        return $_COOKIE['errors'];
    }

    // Set an error in the errors cookie
    public static function setError($error) {
        if(!isset($_COOKIE['errors'])) {
            // The errors cookie doesn't exist, so we need to set it
            setcookie("errors", [$error]);
        } else {
            // The errors cookie does exist, so append to the end of it
            $errors_array = $_COOKIE['errors'];
            array_push($errors_array, $error);
        }
    }
}

?>