<!DOCTYPE html>
<html>
<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<head>
    <title>Pokemon League Item Purchases</title>
</head>
<body>
    <h1>Pokemon League Item Purchases</h1>
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
                echo "<form action=\"/removePurchase.php\" method=\"POST\">\n";
                echo "<table>\n";
                echo "<thead>\n";
                echo "<tr>\n";

                // Create the header
                echo "<th>Purchase ID</th>\n";
                echo "<th>Item Name</th>\n";
                echo "<th>Trainer Name</th>\n";
                echo "<th>Delete</th>\n";

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
                    $id = $res[$i][0];
                    echo "<td><input type=\"checkbox\" name=\"delete$id\" value=\"$id\">\n";

                    echo "</tr>\n";
                }

                echo "</tbody>\n";
                echo "</table>\n";
                echo "<br>\n";

                // End the form
                echo "<input type=\"submit\" value=\"Remove Selected Purchases\">\n";
                echo "</form>\n";
            } else {
                echo "<h3>No purchases exist!</h3>\n";
            }
        }

        // Get all of the items from the database
        // Safe to use a raw query, since no editable variables are involved
        // Use an inner join to get useful information
        $query = "SELECT purchased_id, item_name, trainer_name
                    FROM purchased_items
              INNER JOIN items    ON purchased_items.item_id = items.item_id
              INNER JOIN trainers ON purchased_items.trainer_id = trainers.trainer_id;";

        if(!$result = $conn->query($query)) {
            // If the query fails...
            CustomError::setError('Unable to retrieve purchases: ' . $conn->error);
            header("Location: http://final.cowman.xyz/purchases.php");
        }

        // Put all of the results into a table
        items_to_table($result);

        // Close the connection
        $connection->closeConnection();
    ?>

    <br>
    <!-- Create the button to go to the page to create a new item -->
    <form action="/newPurchase.php">
        <input type="submit" value="Add a new Purchase" />
    </form>
    <br>

    <!-- Create a button to go back home -->
    <form action="/">
        <input type="submit" value="Return Home" />
    </form>
</body>
</html>