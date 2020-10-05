<!DOCTYPE html>
<html>
<head>
    <title>Pokemon League Items</title>
</head>
<body>
    <h1>Pokemon League Items</h1>
    <hr>
    <?php
        include_once('DBConnect.php');

        // Allow error reporting
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

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
                echo "<input type=\"submit\" value=\"Delete Selected Items\">\n";
                echo "</form>\n";
            } else {
                echo "<h5>No items exist!</h5>\n";
            }
        }

        // Get all of the items from the database
        // Safe to use a raw query, since no editable variables are involved
        $query = "SELECT * FROM items";

        if(!$result = $conn->query($query)) {
            // If the query fails...
            echo "Query failed!";
            exit;
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