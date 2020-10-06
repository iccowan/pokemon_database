<!DOCTYPE html>
<html>
<head>
<title>Hall of Fame</title>
</head>
<body>
<h3>Hall of Fame</h3>
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

    $query = "SELECT * FROM hall_of_fame";

    if(!$result = $conn->query($query)){
        echo "Query entered incorrectly";
        exit;
    }

    $cols = $result->field_count;
    $rows = $result->num_rows;
    $victors = $result->fetch_all();

    $connection->closeConnection();
    ?>
</body>
</html>