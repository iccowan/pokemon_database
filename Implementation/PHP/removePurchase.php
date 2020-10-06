<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Allow error cookies
require_once('CustomError.php');

// Init the database connection
require_once('DBConnect.php');
$connection = new DBConnect();
$conn = $connection->getConnection();

// Get all of the items to check for deletion
if(! $all_items = $conn->query("SELECT * FROM purchased_items;")) {
    CustomError::setError("Unable to get all purchases: " . $conn->error);
    header("Location: http://final.cowman.xyz/purchases.php");
}

// Prepare the deletion statement
$statement = "DELETE FROM purchased_items WHERE item_id = ?;";
$stmt = $conn->prepare($statement);
$stmt->bind_param("i", $id);

// Loop through all of the items and see if any should be deleted
$res = $all_items->fetch_all();
$rows = $all_items->num_rows;

for($i = 0; $i < $rows; $i++) {
    $id = $res[$i][0];
    if(isset($_POST["delete" . $id]) && !$stmt->execute()) {
        // Set a cookie so we can let the user know
        CustomError::setError("Error Deleting: " . $conn->error);
    }
}

// Close the database connection
$connection->closeConnection();

// Now, let's return back to the main page
header("Location: http://final.cowman.xyz/purchases.php");
exit;

?>