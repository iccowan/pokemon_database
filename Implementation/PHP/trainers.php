<!DOCTYPE html>
<html>
<head>
    <title>Pokemon League Items</title>
</head>
<body>
    <h1>Pokemon League Trainers</h1>
    <hr>
    <?php
        include('DBConnect.php');

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
            <form action="manageInstruments.php" method="POST">
            <?php
            echo "<table>\n<thead>\n<tr>";
            echo "<td><b> Delete? </b></td>";
            $fields = $result->fetch_fields();
            for ($i=0; $i<$n_cols; $i++){
                echo "<td><b>" . $fields[$i]->name . "</b></td>";
            }
            echo "</tr>\n</thead>\n";
            
            // Begin body -----------------------------------------------
    
            for ($i=0; $i<$n_rows; $i++){
                echo "<tr><td>";
                $id = $qryres[$i][0];
                //make a 1 checkbox for each row
                ?>
                    <input type="checkbox" 
                    name="checkbox<?php echo $id; ?>"
                    value=<?php echo $id ?>
                />
                </td>
                <?php
                for($j=0; $j<$n_cols; $j++){
                    echo "<td>" . $qryres[$i][$j] . "</td>";
                }
                echo "</tr>\n";
    
            }
            echo "</tbody>\n</table>\n";
            ?>
            <input type="submit" value="Delete Selected Records" method=POST/> 
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
    <!-- Create the button to go to the page to add a new trainer -->
    <form action="/addTainer.php">
        <input type="submit" value="Add a new Trainer" />
    </form>
</body>
</html>