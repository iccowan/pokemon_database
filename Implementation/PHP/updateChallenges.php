<!DOCTYPE html>
<html>
<head>
    <title>Update Challenge</title>
</head>

<body>
    <h1>Update Challenge</h1>
    <hr>
    <?php
        // Enable error reporting
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // If there are any errors, we will inform the user here
        require_once('CustomError.php');
        $errors = CustomError::getErrors();
        foreach($errors as $err)
            echo "<p>$err</p>\n";

        // If post variables are set, let's get those and add them to the DB
        // If not, we'll produce a form to create new items
        if(isset($_POST['trainer_id'])) {
            // Make sure we alert that there's an error if either name or
            // description does not exist
            $challenge_id = $_POST['challenge_id'];
            $trainer_id = trim($_POST['trainer_id']);
            $redirect = false; // We'll set this as true when we're ready to redirect

            if($trainer_id == "") {
                CustomError::setError('Trainer ID is required!');
                $redirect = true;
            }

            if($redirect) {
                header("Location: http://final.cowman.xyz/updateChallenges.php");
                exit;
            }

            // Now, we know we have a valid name and description, so let's
            // add it to the database
            require_once('DBConnect.php');
            $connection = new DBConnect();
            $conn = $connection->getConnection();

            // Prepare the query
            $stmt = $conn->prepare("UPDATE challenges SET trainer_id = ?
                                     WHERE challenge_id = ?;");
            $stmt->bind_param("ii", $trainer_id, $challenge_id);

            if($stmt->execute()) {
                header("Location: http://final.cowman.xyz/challenges.php");
                exit;
            } else {
                CustomError::setError('Unable to update challenge: ' . $conn->error);
                header("Location: http://final.cowman.xyz/updateChallenges.php");
                exit;
            }
        }

        // Get the item that is referenced
        require_once('DBConnect.php');

        if(! isset($_GET['challenge_id'])) {
            CustomError::setError('Must select an challenge to update.');
            header('Location: http://final.cowman.xyz/challenges.php');
            exit;
        }

        $connection = new DBConnect();
        $conn = $connection->getConnection();
        $stmt = $conn->prepare('SELECT trainer_id FROM challenges WHERE challenge_id = ?');

        $challenge_id = $_GET['challenge_id'];
        $stmt->bind_param('i', $challenge_id);
        
        if(! $stmt->execute()) {
            CustomError::setError('Error getting challenge: ' . $conn->error);
            header('Location: http://final.cowman.xyz/challenges.php');
            exit;
        }

        // Now, we know the item result exists
        $result = $stmt->get_result()->fetch_all();
        $trainer_id = $result[0][0];
    ?>
    
    <form action="/updateChallenges.php" method="POST">
        <label for="trainer_id">Trainer ID</label>
        <input type="hidden" name="challenge_id" value="<?php echo $challenge_id; ?>">
        <input type="text" name="trainer_id" value="<?php echo $trainer_id; ?>">
        <br><br>
        <input type="submit" value="Save">
    </form>
    <br>
    
    <form action="/challenges.php">
        <input type="submit" value="Cancel">
    </form>
</body>
</html>