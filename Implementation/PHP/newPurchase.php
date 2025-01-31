<!DOCTYPE html>
<html>
<head>
    <title>Add a New Purchase</title>
</head>

<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<body>
    <h1>Add a New Purchase</h1>
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
        if(isset($_POST['item_id']) || isset($_POST['trainer_id'])) {
            // Make sure we alert that there's an error if either name or
            // description does not exist
            $item_id = $_POST['item_id'];
            $trainer_id = $_POST['trainer_id'];
            $redirect = false; // We'll set this as true when we're ready to redirect

            if($item_id == "") {
                CustomError::setError('An item is required!');
                $redirect = true;
            } elseif($trainer_id == "") {
                CustomError::setError('A trainer is required!');
                $redirect = true;
            }

            if($redirect) {
                header("Location: http://final.cowman.xyz/newPurchase.php");
                exit;
            }

            // Now, we know we have a valid name and description, so let's
            // add it to the database
            require_once('DBConnect.php');
            $connection = new DBConnect();
            $conn = $connection->getConnection();

            // Prepare the query
            $stmt = $conn->prepare("INSERT INTO purchased_items(item_id, trainer_id)
                                    VALUES (?, ?);");
            $stmt->bind_param("ii", $item_id, $trainer_id);

            if($stmt->execute()) {
                $connection->closeConnection();
                header("Location: http://final.cowman.xyz/purchases.php");
            } else {
                CustomError::setError('Unable to add new purchase: ' . $conn->error);
                $connection->closeConnection();
                header("Location: http://final.cowman.xyz/newPurchase.php");
            }
        }
    ?>

    <?php
        // Get all the trainers and items so we can put them in a dropdown list
        require_once('DBConnect.php');
        $connection = new DBConnect();
        $conn = $connection->getConnection();

        $query_items = "SELECT item_id, item_name FROM items;";
        $query_trainers = "SELECT trainer_id, trainer_name FROM trainers;";

        if(! $res_items = $conn->query($query_items)) {
            CustomError::setError('Unable to get items: ' . $conn->error);
            $connection->closeConnection();
            header("Location: http://final.cowman.xyz/newPurchase.php");
        }

        if(! $res_trainers = $conn->query($query_trainers)) {
            CustomError::setError('Unable to get trainers: ' . $conn->error);
            $connection->closeConnection();
            header("Location: http://final.cowman.xyz/newPurchase.php");
            exit;
        }

        // Now, we should have all of the items and trainers but we need
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

        // Get the arrays of both the items and trainers
        $items = id_name_to_array($res_items);
        $trainers = id_name_to_array($res_trainers);
    ?>
    
    <form action="/newPurchase.php" method="POST">
        <label for="item_id">Item</label>
        <select name="item_id">
            <option value="">Select an Item</option>
            <?php
                foreach($items as $item) {
                    echo "<option value=\"$item[0]\">$item[1]</option>";
                }
            ?>
        </select>
        <br><br>
        <label for="trainer_id">Trainer</label>
        <select name="trainer_id">
            <option value="">Select a Trainer</option>
            <?php
                foreach($trainers as $trainer) {
                    echo "<option value=\"$trainer[0]\">$trainer[1]</option>";
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