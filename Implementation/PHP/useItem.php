<!DOCTYPE html>
<html>
<head>
    <title>Set Item as Used</title>
</head>

<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<body>
    <h1>Set Item as Used</h1>
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
        // If not, we'll produce a form to create new items
        if(isset($_POST['challenge_id'])) {
            // Make sure we alert that there's an error if either name or
            // description does not exist
            $challenge_id = $_POST['challenge_id'];
            $purchase_id = $_POST['purchase_id'];
            $redirect = false; // We'll set this as true when we're ready to redirect

            if($challenge_id == "") {
                CustomError::setError('An challenge is required!');
                $redirect = true;
            }

            if($redirect) {
                header("Location: http://final.cowman.xyz/useItem.php?purchase_id=" . $purchase_id);
                exit;
            }

            // Now, we know we have a valid name and description, so let's
            // add it to the database
            require_once('DBConnect.php');
            $connection = new DBConnect();
            $conn = $connection->getConnection();

            // Prepare the query
            $stmt = $conn->prepare("INSERT INTO items_used(purchased_id, challenge_id)
                                    VALUES (?, ?);");
            $stmt->bind_param("ii", $purchase_id, $challenge_id);

            if($stmt->execute()) {
                $connection->closeConnection();
                header("Location: http://final.cowman.xyz/purchases.php");
            } else {
                CustomError::setError('Unable to use item: ' . $conn->error);
                $connection->closeConnection();
                header("Location: http://final.cowman.xyz/purchases.php");
            }
        }
    ?>

    <?php
        // Get all the trainers and items so we can put them in a dropdown list
        require_once('DBConnect.php');
        $connection = new DBConnect();
        $conn = $connection->getConnection();

        $query_challenges = "SELECT challenge_id, trainer_name FROM challenges
                                    NATURAL JOIN trainers;";

        if(! $res_challenges = $conn->query($query_challenges)) {
            CustomError::setError('Unable to get challenges: ' . $conn->error);
            $connection->closeConnection();
            header("Location: http://final.cowman.xyz/purchases.php");
        }

        // Now, we should have all of the challenges but we need
        // to put them into an array so we can pass it to a dropdown list
        function id_name_to_array($result) {
            $res = $result->fetch_all();
            $rows = $result->num_rows;

            $return_array = array();

            for($i = 0; $i < $rows; $i++) {
                $id = $res[$i][0];
                $name = $res[$i][1];
                array_push($return_array, [$id, $name]);
            }

            return $return_array;
        }

        // Get the arrays of both the challenges
        $challenges = id_name_to_array($res_challenges);
        $purchase_id = $_GET['purchase_id'];
    ?>
    
    <form action="/useItem.php" method="POST">
        <input type="hidden" name="purchase_id" value="<?php echo $purchase_id; ?>">
        <label for="challenge_id">Challenge</label>
        <select name="challenge_id">
            <option value="">Select a Challenge</option>
            <?php
                foreach($challenges as $challenge) {
                    echo "<option value=\"$challenge[0]\">Challenge #$challenge[0] - $challenge[1]</option>\n";
                }
            ?>
        </select>
        <br><br>
        <input type="submit" value="Submit">
    </form>
    <br>
    
    <form action="/purchases.php">
        <input type="submit" value="Cancel">
    </form>
</body>
</html>