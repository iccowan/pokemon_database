<!DOCTYPE html>
<html>
<head>
    <title>Create New Item</title>
<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

</head>
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
            $item_name = $_POST['item_name'];
            $item_desc = $_POST['item_description'];
            $redirect = false; // We'll set this as true when we're ready to redirect

            if($item_name == "") {
                CustomError::setError('Item name is required!');
                $redirect = true;
            } elseif($item_name == "") {
                CustomError::setError('Item description is required');
                $redirect = true;
            }

            if($redirect)
                header("Location: http://final.cowman.xyz/createItem.php");

            // Now, we know we have a valid name and description, so let's
            // add it to the database
            require_once('DBConnect.php');
            $connection = new DBConnect();
            $conn = $connection->getConnection();

            // Prepare the query
            $stmt = $conn->prepare("INSERT INTO items(item_name,
                                    item_description) VALUES (?, ?);");
            $stmt->bind_param("ss", $item_name, $item_desc);

            if($stmt->execute()) {
                header("Location: http://final.cowman.xyz/items.php");
            } else {
                CustomError::setError('Unable to create new item.');
                header("Location: http://final.cowman.xyz/createItem.php");
            }
        }
    ?>
    
    <form action="/createItem.php" method="POST">
        <label for="item_name">Item Name</label>
        <input type="text" name="item_name">
        <br><br>
        <label for="item_description">Item Description</label>
        <input type="textarea" name="item_description">
        <br><br>
        <input type="submit" value="Submit">
    </form>
    <br>
    
    <form action="/items.php">
        <input type="submit" value="Cancel">
    </form>
</body>
</html>