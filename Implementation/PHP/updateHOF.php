<!DOCTYPE html>
<html>
<head>
    <title>Update Hall of Fame</title>
</head>

<body>
    <h1>Update Hall of Fame</h1>
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
        if(isset($_POST['trainer_id'])||isset($_POST['pokemon_id'])) {
            // Make sure we alert that there's an error if no ids exist
            $hof_id = $_POST['hof_id'];
            $trainer_id = trim($_POST['trainer_id']);
            $pokemon_id = trim($_POST['pokemon_id']);
            $redirect = false; // We'll set this as true when we're ready to redirect

            if($trainer_id == "") {
                CustomError::setError('Trainer ID is required!');
                $redirect = true;
            }

            if($redirect) {
                header("Location: http://final.cowman.xyz/updateHOF.php");
                exit;
            }

            // Add the the new details to the database
            require_once('DBConnect.php');
            $connection = new DBConnect();
            $conn = $connection->getConnection();

            // Query hall_of_fame
            $stmt = $conn->prepare("UPDATE hall_of_fame SET trainer_id = ?,pokemon_id = ?
                                     WHERE hof_id = ?;");
            $stmt->bind_param("iii", $trainer_id, $pokemon_id, $hof_id);

            if($stmt->execute()) {
                header("Location: http://final.cowman.xyz/hallOfFame.php");
                exit;
            } else {
                CustomError::setError('Unable to update record: ' . $conn->error);
                header("Location: http://final.cowman.xyz/updateHOF.php");
                exit;
            }
        }

        // Get the item that is referenced
        require_once('DBConnect.php');

        if(! isset($_GET['hof_id'])) {
            CustomError::setError('Must select a record to update.');
            header('Location: http://final.cowman.xyz/hallOfFame.php');
            exit;
        }

        $connection = new DBConnect();
        $conn = $connection->getConnection();
        $stmt = $conn->prepare('SELECT trainer_id, pokemon_id FROM hall_of_fame WHERE hof_id = ?');

        $hof_id = $_GET['hof_id'];
        $stmt->bind_param('i', $hof_id);
        
        if(! $stmt->execute()) {
            CustomError::setError('Error getting record: ' . $conn->error);
            header('Location: http://final.cowman.xyz/hallOfFame.php');
            exit;
        }

        $result = $stmt->get_result()->fetch_all();
        $trainer_id = $result[0][0];
        $pokemon_id = $result[0][1];
    ?>
    
    <form action="/updateHOF.php" method="POST">
        <label for="trainer_id">Trainer ID</label>
        <input type="hidden" name="hof_id" value="<?php echo $hof_id; ?>">
        <input type="text" name="trainer_id" value="<?php echo $trainer_id; ?>">
        <br><br>
        <label for="pokemon_id">Pokemon ID</label>
        <input type="text" name="pokemon_id" value="<?php echo $pokemon_id; ?>">
        <br><br>
        <input type="submit" value="Save">
    </form>
    <br>
    
    <form action="/hallOfFame.php">
        <input type="submit" value="Cancel">
    </form>
</body>
</html>