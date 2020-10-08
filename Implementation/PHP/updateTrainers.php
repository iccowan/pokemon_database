<!DOCTYPE html>
<html>
<head>
    <title>Update Item</title>
</head>

<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<body>
    <h1>Update Trainer</h1>
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
        // If not, we'll produce a form to update Trainers
        if(isset($_POST['trainer_name']) || isset($_POST['hometown']) || isset($_POST['rival'])) {
            // Make sure we alert that there's an error if either name or
            // hometown does not exist
            $trainer_id = $_POST['trainer_id'];
            $trainer_name = trim($_POST['trainer_name']);
            $trainer_hometown = trim($_POST['hometown']);
            $trainer_rival = $_POST['rival'];
            $redirect = false; // We'll set this as true when we're ready to redirect

            if($trainer_name == "") {
                CustomError::setError('Trainer name is required!');
                $redirect = true;
            } elseif($trainer_hometown == "") {
                CustomError::setError('Trainer Hometown is required!');
                $redirect = true;
            }

            if($redirect) {
                header("Location: http://final.cowman.xyz/updateTrainers.php");
                exit;
            }

            // Now, we know we have a valid name and description, so let's
            // add it to the database
            require_once('DBConnect.php');
            $connection = new DBConnect();
            $conn = $connection->getConnection();

            // Prepare the query
            if ($trainer_rival == ""){
                $stmt = $conn->prepare("UPDATE trainers
                                        SET trainer_name = ?, hometown = ?, rival_id = ?
                                        WHERE trainer_id = ?;");
                $stmt->bind_param("ssii", $trainer_name, $trainer_hometown, $rival_id, $trainer_id);
            }
            else {
                $stmt = $conn->prepare("UPDATE trainers
                                        SET trainer_name = ?, hometown = ?, rival_id = ?
                                        WHERE trainer_id = ?;");
                $stmt->bind_param("ssii", $trainer_name, $trainer_hometown, $trainer_rival, $trainer_id);
            }

            if($stmt->execute()) {
                header("Location: http://final.cowman.xyz/trainers.php");
                exit;
            } else {
                CustomError::setError('Unable to update item: ' . $conn->error);
                header("Location: http://final.cowman.xyz/updateTrainers.php");
                exit;
            }
        }
    ?>

    <?php
        // Get the item that is referenced
        require_once('DBConnect.php');

        if(! isset($_GET['trainer_id'])) {
            CustomError::setError('Must select an item to update.');
            header('Location: http://final.cowman.xyz/trainers.php');
            exit;
        }

        $connection = new DBConnect();
        $conn = $connection->getConnection();
        $stmt = $conn->prepare('SELECT trainer_name, hometown, rival_id FROM trainers WHERE trainer_id = ?');

        $trainer_id = $_GET['trainer_id'];
        $stmt->bind_param('i', $trainer_id);
        
        if(! $stmt->execute()) {
            CustomError::setError('Error getting trainer: ' . $conn->error);
            header('Location: http://final.cowman.xyz/trainers.php');
            exit;
        }

        // Now, we know the trainer result exists
        $trainer_res = $stmt->get_result()->fetch_all();
        $trainer_name = $trainer_res[0][0];
        $trainer_hometown = $trainer_res[0][1];
        $trainer_rival = $trainer_res[0][2];
    ?>
    
    <form action="/updateTrainers.php" method="POST">
        <label for="trainer_name">Trainer Name</label>
        <input type="hidden" name="trainer_id" value="<?php echo $trainer_id; ?>">
        <input type="text" name="trainer_name" value="<?php echo $trainer_name; ?>">
        <br><br>
        <label for="hometown">Trainer Hometown</label>
        <input type="text" name="hometown" value="<?php echo $trainer_hometown; ?>">
        <br><br>
        <label for="rival">Trainer Rival</label>
        <input type="text" name="rival" value="<?php echo $trainer_rival; ?>">
        <br><br>
        <input type="submit" value="Save">
    </form>
    <br>
    
    <form action="/trainers.php">
        <input type="submit" value="Cancel">
    </form>
</body>
</html>