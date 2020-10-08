<!DOCTYPE html>
<html>
<head>
<title>Challenges</title>
</head>
<body>
<h1>Challenges</h1>
<h3>Overall attempts at the pokemon league</h3>
<hr>
    <?php
    //enable error messages
    ini_set('display_errors',1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include_once("DBConnect.php");

    $connection = new DBConnect();
    $conn = $connection->getConnection();

    if ($conn->connect_errno) {
        echo "Error: Failed to make a MySQL connection: " . "<br>";
        echo "Errno: $conn->connect_errno \n";
        echo "Error: $conn->connect_error \n";
        exit;
    }

    $query = "SELECT * FROM challenges";

    if(!$result = $conn->query($query)){
        echo "Query entered incorrectly";
        exit;
    }

    $n_cols = $result->field_count;
    $n_rows = $result->num_rows;
    $qryres = $result->fetch_all();

    ?>

    <form action="deleteChallenge.php" method="POST">
    <table>
    <thead>
    <tr>
    <?php
    $fields = $result->fetch_fields();
            for ($i=0; $i<$n_cols; $i++){
                echo "<td><b>" . $fields[$i]->name . "</b></td>";
            }
            ?>
    <td><b>Update?</b></td>
    <td><b>Delete?</b></td>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $i<$n_rows; $i++){
                echo "<tr>";
                for($j=0; $j<$n_cols; $j++){
                    echo "<td>" . $qryres[$i][$j] . "</td>";
                }
                $id = $qryres[$i][0];
                echo "<td><a href=\"/updateChallenges.php?challenge_id=$id\">Update</a></td>";
                echo "<td><input type=\"checkbox\" name=\"delete$id\" value=\"$id\">\n";
                echo "</tr>\n";
    }
    ?>
    </tbody>
    </table>
    <br>
    <input type="submit" value="Delete selected items">
    </form>
    <br>
    <form action="/addChallenge.php">
        <input type="submit" value="Enter a new Challenge" />
    </form>
    <br>
    <form action="/">
        <input type="submit" value="Return Home" />
    </form>
    <br>
    <?php
    $connection->closeConnection();
    ?>
</body>
</html>