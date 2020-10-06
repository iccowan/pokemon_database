<!DOCTYPE html>
<html>
<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<head>
    <title>Pokemon League Items</title>
    <style>
        table {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1>Pokemon League Items</h1>
    <?php
        // If there are any errors, we will inform the user here
        require_once('CustomError.php');
        $errors = CustomError::getErrors();
        foreach($errors as $err)
            echo "<p>$err</p>\n";
    ?>
    <hr>
    <?php
        require_once('DBConnect.php');

        // Initialize the database connection
        $connection = new DBConnect();
        $conn = $connection->getConnection();

        // Function to display all of the items as a table
        function items_to_table($items) {
            // Get all of the items and the number of rows, columns
            $res = $items->fetch_all();
            $fields = $items->fetch_fields();
            $rows = $items->num_rows;
            $cols = $items->field_count;

            if($rows > 0) {
                // Create a form to delete items
                echo "<form action=\"/deleteItems.php\" method=\"POST\">\n";
                echo "<table>\n";
                echo "<thead>\n";
                echo "<tr>\n";

                // Create the header
                echo "<th>Item ID</th>\n";
                echo "<th>Item Name</th>\n";
                echo "<th>Item Description</th>\n";
                echo "<th>Update?</th>\n";
                echo "<th>Delete?</th>\n";

                echo "</tr>\n";
                echo "</thead>\n";
                echo "<tbody>\n";

                // Create the body
                for($i = 0; $i < $rows; $i++) {
                    echo "<tr>\n";
                    for($j = 0; $j < $cols; $j++) {
                        echo "<td>" . $res[$i][$j] . "</td>\n";
                    }

                    // Add one more column at the end with checkboxes to delete items
                    // and another button to update the items
                    $id = $res[$i][0];
                    echo "<td><a href=\"/updateItem.php?item_id=$id\">Update</a></td>";
                    echo "<td><input type=\"checkbox\" name=\"delete$id\" value=\"$id\">\n";

                    echo "</tr>\n";
                }

                echo "</tbody>\n";
                echo "</table>\n";
                echo "<br>\n";

                // End the form
                echo "<input type=\"submit\" value=\"Delete Selected Items\">\n";
                echo "</form>\n";
            } else {
                echo "<h3>No items exist!</h3>\n";
            }
        }

        // Get all of the items from the database
        // Safe to use a raw query, since no editable variables are involved
        $query = "SELECT * FROM items";

        if(!$result = $conn->query($query)) {
            // If the query fails...
            CustomError::setError('Unable to retrieve items: ' . $conn->error);
            header("Location: http://final.cowman.xyz/items.php");
        }

        // Put all of the results into a table
        items_to_table($result);

        // Close the connection
        $connection->closeConnection();
    ?>

    <br>
    <!-- Create the button to go to the page to create a new item -->
    <form action="/createItem.php">
        <input type="submit" value="Create a new Item" />
    </form>
    <br>

    <!-- Create a button to go back home -->
    <form action="/">
        <input type="submit" value="Return Home" />
    </form>
</body>
</html>