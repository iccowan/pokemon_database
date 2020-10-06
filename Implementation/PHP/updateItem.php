<!DOCTYPE html>
<html>
<head>
    <title>Create New Item</title>
</head>

<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<body>
    <h1>Create New Item</h1>
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
        if(isset($_POST['item_name']) || isset($_POST['item_description'])) {
            // Make sure we alert that there's an error if either name or
            // description does not exist
            $item_id = $_POST['item_id'];
            $item_name = trim($_POST['item_name']);
            $item_desc = trim($_POST['item_description']);
            $redirect = false; // We'll set this as true when we're ready to redirect

            if($item_name == "") {
                CustomError::setError('Item name is required!');
                $redirect = true;
            } elseif($item_desc == "") {
                CustomError::setError('Item description is required!');
                $redirect = true;
            }

            if($redirect) {
                header("Location: http://final.cowman.xyz/updateItem.php");
                exit;
            }

            // Now, we know we have a valid name and description, so let's
            // add it to the database
            require_once('DBConnect.php');
            $connection = new DBConnect();
            $conn = $connection->getConnection();

            // Prepare the query
            $stmt = $conn->prepare("UPDATE items
                                       SET item_name = ?, item_description = ?,
                                     WHERE item_id = ?;");
            $stmt->bind_param("ssi", $item_name, $item_desc, $item_id);

            if($stmt->execute()) {
                header("Location: http://final.cowman.xyz/items.php");
                exit;
            } else {
                CustomError::setError('Unable to update item: ' . $conn->error);
                header("Location: http://final.cowman.xyz/updateItem.php");
                exit;
            }
        }
    ?>

    <?php
        // Get the item that is referenced
        require_once('DBConnect.php');

        if(! isset($_GET['item_id'])) {
            CustomError::setError('Must select an item to update.');
            header('Location: http://final.cowman.xyz/items.php');
            exit;
        }

        $connection = new DBConnect();
        $conn = $connection->getConnection();
        $stmt = $conn->prepare('SELECT item_name, item_description FROM items WHERE item_id = ?');

        $item_id = $_GET['item_id'];
        $stmt->bind_param('i', $item_id);
        
        if(! $stmt->execute()) {
            CustomError::setError('Error getting item: ' . $conn->error);
            header('Location: http://final.cowman.xyz/items.php');
            exit;
        }

        // Now, we know the item result exists
        $item_res = $stmt->get_result()->fetch_all();
        $item_name = $item_res[0][0];
        $item_desc = $item_res[0][1];
    ?>
    
    <form action="/updateItem.php" method="POST">
        <label for="item_name">Item Name</label>
        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
        <input type="text" name="item_name" value="<?php echo $item_name; ?>">
        <br><br>
        <label for="item_description">Item Description</label>
        <input type="text" name="item_description" value="<?php $item_desc ?>">
        <br><br>
        <input type="submit" value="Save">
    </form>
    <br>
    
    <form action="/items.php">
        <input type="submit" value="Cancel">
    </form>
</body>
</html>