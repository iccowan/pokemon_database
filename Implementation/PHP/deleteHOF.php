<?php
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
if(!$hall_records = $conn->query($query)){
    echo "Query entered incorrectly";
    exit;
}

$statement = "DELETE FROM hall_of_fame WHERE hof_id = ?;";
$stmt = $conn->prepare($statement);
$stmt->bind_param("i", $id);

$qyres = $hall_records->fetch_all();
$n_rows = $hall_records->num_rows;

for($i = 0; $i < $n_rows; $i++) {
    $id = $qyres[$i][0];
    if(isset($_POST["delete" . $id]) && !$stmt->execute()) {
        echo "Incorrect deletion!";
        exit;
    }
}

$connection->closeConnection();

header("Location: http://final.cowman.xyz/hallOfFame.php");
?>