<?php

class CustomError {
    // Retrieve errors from the errors cookie
    public static function getErrors() {
        // No errors exist; return empty array
        if(!isset($_COOKIE['error0']))
            return array();

        // At least one error exists, so let's loop through all of them and
        // return an array
        $i = 0;
        $errors = array();
        while(isset($_COOKIE['error' . $i])) {
            array_push($errors, $_COOKIE['error' . $i]);
            setcookie('error' . $i, 'unset', time() - 3600);
            $i++;
        }

        return $errors;
    }

    // Set an error in the errors cookie
    public static function setError($error) {
        if(!isset($_COOKIE['error0'])) {
            // The errors cookie doesn't exist, so we need to set it
            setcookie("error0", $error);
        } else {
            // At least one error already exists, so let's find what error index we're at
            $i = 0;
            while(isset($_COOKIE['error' . $i]))
                $i++;
            
            setcookie("error" . $i, $error);
        }
    }
}

?>