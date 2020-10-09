<!DOCTYPE html>
<html>
<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<head>
    <title>Elite Four</title>
</head>
<body>
    <h1>The Elite Four</h1>
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

        // Function to display all of the Elite Four as a table
        function elite_four_to_table($result) {
            $qryres = $result->fetch_all(); // get array of rows from result object, so we can iterate more than once
            $n_rows = $result->num_rows; // num_rows
            $n_cols = $result->field_count; // num_col
        
            
            // Begin header ---------------------------------------------
            ?>
            <form action="eliteFour.php" method="POST">
            <?php
            echo "<table>\n<thead>\n<tr>";


            $fields = $result->fetch_fields();
            for ($i=0; $i<$n_cols; $i++){
                echo "<td><b>" . $fields[$i]->name . "</b></td>";
            }
            echo "<td><b>Update?</b></td>";
            echo "</tr>\n</thead>\n";
            
            // Begin body -----------------------------------------------
    
            for ($i=0; $i<$n_rows; $i++){
                echo "<tr>";
                $id = $qryres[$i][0];
                for($j=0; $j<$n_cols; $j++){
                    echo "<td>" . $qryres[$i][$j] . "</td>";
                }
                echo "<td><a href=\"/updateEliteFour.php?trainer_id=$id\">Update</a></td>";

                echo "</tr>\n";
                
            }
            echo "</tbody>\n</table>\n";
            ?>
            
            </form>
            <?php
    
        }

        // Get all of the items from the database
        // Safe to use a raw query, since no editable variables are involved
        $query = "SELECT * FROM elite_four";

        if(!$result = $conn->query($query)) {
            // If the query fails...
            CustomError::setError('Unable to retrieve Elite Four: ' . $conn->error);
            header("Location: http://final.cowman.xyz/eliteFour.php");
        }

        // Put all of the results into a table
        elite_four_to_table($result);

        // Close the connection
        $connection->closeConnection();
    ?>

    <br>
    

    <!-- Create a button to go back home -->
    <form action="/">
        <input type="submit" value="Return Home" />
    </form>
</body>
</html>