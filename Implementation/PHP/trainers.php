<!DOCTYPE html>
<html>
<head>
    <title>Pokemon League Trainers</title>
</head>
<body>
    <h1>Pokemon League Trainers</h1>
    <hr>
    <?php
        include_once('DBConnect.php');

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Initialize the database connection
        $connection = new DBConnect();
        $conn = $connection->getConnection();

        // Function to display all of the Trainers as a table
        function trainers_to_table($result) {
            $qryres = $result->fetch_all(); // get array of rows from result object, so we can iterate more than once
            $n_rows = $result->num_rows; // num_rows
            $n_cols = $result->field_count; // num_col
        
            
            // Begin header ---------------------------------------------
            ?>
            <form action="trainers.php" method="POST">
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
                echo "<td><a href=\"/updateTrainers.php?trainer_id=$id\">Update</a></td>";
                echo "</tr>\n";
    
            }
            echo "</tbody>\n</table>\n";
            ?>
            
            </form>
            <?php
    
        }

        // Get all of the trainers from the database
        // Safe to use a raw query, since no editable variables are involved
        $query = "SELECT * FROM trainers";

        if(!$result = $conn->query($query)) {
            // If the query fails...
            echo "Query failed!";
            exit;
        }
    
        // Put all of the results into a table
        trainers_to_table($result);

        // Close the connection
        $connection->closeConnection();
    ?>

    <br>
    
    <form action="/addTrainer.php">
        <input type="submit" value="Add a new Trainer" />
    </form>

    <form action="/">
        <input type="submit" value="Return Home" />
    </form>
</body>
</html>