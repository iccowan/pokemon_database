<!DOCTYPE html>
<html>
<head>
    <title>Update Elite Four</title>
</head>

<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<body>
    <h1>Update Elite Four</h1>
    <?php
        // If there are any errors, we will inform the user here
        require_once('CustomError.php');
        $errors = CustomError::getErrors();
        foreach($errors as $err)
            echo "<p>$err</p>\n";
    ?>
    <hr>
    <?php
        // If post variables are set, let's get those and add them to the DB
        // If not, we'll produce a form to Update the Elite Four
        if(isset($_POST['trainer_id']) || isset($_POST['rank'])) {
            // Make sure we alert that there's an error if either id or
            // rank does not exist
            $trainer_id = $_POST['trainer_id'];
            $rank = $_POST['rank'];
            $redirect = false; // We'll set this as true when we're ready to redirect

            if($trainer_id == "") {
                CustomError::setError('Trainer ID is required!');
                $redirect = true;
            } elseif($rank == "") {
                CustomError::setError('Rank is Required!');
                $redirect = true;
            }

            if($redirect) {
                header("Location: http://final.cowman.xyz/updateEliteFour.php");
                exit;
            }

            // Now, we know we have a valid ID and Rank, so let's
            // add it to the database
            require_once('DBConnect.php');
            $connection = new DBConnect();
            $conn = $connection->getConnection();

            // Prepare the query
            $stmt = $conn->prepare("UPDATE elite_four
                                       SET trainer_id = ?, rank = ?
                                     WHERE trainer_id = ?;");
            $stmt->bind_param("iii", $trainer_id, $rank, $trainer_id);

            if($stmt->execute()) {
                header("Location: http://final.cowman.xyz/eliteFour.php");
                exit;
            } else {
                CustomError::setError('Unable to update item: ' . $conn->error);
                header("Location: http://final.cowman.xyz/updateEliteFour.php");
                exit;
            }
        }
    ?>

    <?php
        // Get the item that is referenced
        require_once('DBConnect.php');

        if(! isset($_GET['trainer_id'])) {
            CustomError::setError('Must select a trainer to update.');
            header('Location: http://final.cowman.xyz/eliteFour.php');
            exit;
        }

        $connection = new DBConnect();
        $conn = $connection->getConnection();
        $stmt = $conn->prepare('SELECT trainer_id, rank FROM elite_four WHERE trainer_id = ?');

        $trainer_id = $_GET['trainer_id'];
        $stmt->bind_param('i', $trainer_id);
        
        if(! $stmt->execute()) {
            CustomError::setError('Error getting trainer: ' . $conn->error);
            header('Location: http://final.cowman.xyz/eliteFour.php');
            exit;
        }

        // Now, we know the item result exists
        $result = $stmt->get_result()->fetch_all();
        $trainer_id = $result[0][0];
        $rank = $result[0][1];
    ?>
    
    <form action="/updateEliteFour.php" method="POST">
        <label for="trainer_id">Trainer ID</label>
        <input type="text" name="trainer_id" value="<?php echo $trainer_id; ?>">
        <br><br>
        <label for="rank">Rank</label>
        <input type="text" name="rank" value="<?php echo $rank; ?>">
        <br><br>
        <input type="submit" value="Save">
    </form>
    <br>
    
    <form action="/eliteFour.php">
        <input type="submit" value="Cancel">
    </form>
</body>
</html>