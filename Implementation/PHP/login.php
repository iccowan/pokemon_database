<!DOCTYPE html>
<html>
<head>
    <title>Pokemon League Login</title>
</head>

<?php
    // Require the User model and custom errors
    require_once('User.php');
    require_once('CustomError.php');

    // Make sure the current user hasn't already been authenticated
    if(User::isAuth()) {
        CustomError::setError('You are already logged in!');
        header('Location: http://final.cowman.xyz');
        exit;
    }

    if(isset($_POST['username']) || isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $redirect = false; // We'll set this as true when we're ready to redirect

        if($username == "") {
            CustomError::setError('Please enter your username');
            $redirect = true;
        }
        if($password == "") {
            CustomError::setError('Please enter your password');
            $redirect = true;
        }

        if($redirect) {
            header("Location: http://final.cowman.xyz/login.php");
            exit;
        }

        // Now, we have a username and password so let's authenticate the user
        // If we get a true return then we know the user has been authenticated
        // and we can redirect them to the website. If we get a false return,
        // we know the user has not been authenticated and redirect them with
        // an error
        if(User::login($username, $password)) {
            header('Location: http://final.cowman.xyz/');
        } else {
            CustomError::setError('Invalid username or password! If you believe
                                   this is an error, please contact a site
                                   admin.');
            header('Location: https://final.cowman.xyz/login.php');
        }
    }
?>

<body>
    <h1>Login to the Pokemon League</h1>
    <?php
        $errors = CustomError::getErrors();
        foreach($errors as $err)
            echo "<p>$err</p>\n";
    ?>
    <hr>
    <form action="/login.php" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" value="">
        <br><br>
        <label for="password">Password</label>
        <input type="password" name="password" value="">
        <br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>