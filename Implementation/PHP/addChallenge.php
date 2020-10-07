<!DOCTYPE html>
<html>
<head>
<title>Add a Challenge</title>
</head>
<body>
    <h3>Add a Challenge</h3>
    <?php
        if(isset($_POST['trainer_id'])) {

            $new_trainer = trim($_POST['trainer_id']);
            $redirect = false;

            if($new_trainer == "") {
                echo "Trainer ID is required";
                $redirect = true;
            } 

            if($redirect) {
                header("Location: http://final.cowman.xyz/addChallenge.php");
                exit;
            }

            require_once('DBConnect.php');
            $connection = new DBConnect();
            $conn = $connection->getConnection();

            $stmt = $conn->prepare("INSERT INTO (trainer_id) VALUES (?);");
            $stmt->bind_param("i", $new_trainer);

            if($stmt->execute()) {
                header("Location: http://final.cowman.xyz/challenges.php");
            } else {
                echo "Unable to create new challenge";
                header("Location: http://final.cowman.xyz/addChallenge.php");
            }
        }
    ?>
    
    <form action="/addChallenge.php" method="POST">
        <label for="trainer_id">Trainer ID</label>
        <input type="text" name="trainer_id" value="">
        <br>
        <input type="submit" value="Submit">
    </form>
    <br>
    
    <form action="/challenges.php">
        <input type="submit" value="Cancel">
    </form>
</body>
</html>