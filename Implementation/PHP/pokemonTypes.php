<!DOCTYPE html>
<html>
<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<head>
    <title>Pokemon League Pokemon Types</title>
</head>
<body>
    <h1>Pokemon League Pokemon Types</h1>
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
        function pokemon_to_table($poke_types) {
            // Get all of the items and the number of rows, columns
            $res = $poke_types->fetch_all();
            $fields = $poke_types->fetch_fields();
            $rows = $poke_types->num_rows;
            $cols = $poke_types->field_count;

            if($rows > 0) {
                // Create a form to delete items
                echo "<table>\n";
                echo "<thead>\n";
                echo "<tr>\n";

                // Create the header
                echo "<th>Pokemon Type ID</th>\n";
                echo "<th>Pokemon Type Name</th>\n";
                echo "<th>Pokemon Type Description</th>\n";

                echo "</tr>\n";
                echo "</thead>\n";
                echo "<tbody>\n";

                // Create the body
                for($i = 0; $i < $rows; $i++) {
                    echo "<tr>\n";
                    for($j = 0; $j < $cols; $j++) {
                        echo "<td>" . $res[$i][$j] . "</td>\n";
                    }

                    echo "</tr>\n";
                }

                echo "</tbody>\n";
                echo "</table>\n";
                echo "<br>\n";
            } else {
                echo "<h3>No pokemon types exist!</h3>\n";
            }
        }

        // Get all of the items from the database
        // Safe to use a raw query, since no editable variables are involved
        $query = "SELECT * FROM pokemon_type;";

        if(!$result = $conn->query($query)) {
            // If the query fails...
            CustomError::setError('Unable to retrieve pokemon types: ' . $conn->error);
            header("Location: http://final.cowman.xyz/pokemonTypes.php");
        }

        // Put all of the results into a table
        pokemon_to_table($result);

        // Close the connection
        $connection->closeConnection();
    ?>

    <br>
    <!-- Create the button to go to the page to create a new item -->
    <form action="/createPokemonType.php">
        <input type="submit" value="Create a new Pokemon Type" />
    </form>
    <br>

    <!-- Create a button to go back home -->
    <form action="/">
        <input type="submit" value="Return Home" />
    </form>
</body>
</html>