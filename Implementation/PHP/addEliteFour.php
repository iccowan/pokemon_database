<!DOCTYPE html>
<html>
<head>
    <title>Elite Four</title>
</head>
<body>
    <h1>Add A New Trainer</h1>
    <hr>
    <?php

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);


        //Check if POST variables are set and add them to the database
        if(isset($_POST['trainer_id']) || isset($_POST['rank']))
        {
            $trainer_id = trim($_POST['trainer_id']);
            $rank = trim($_POST['rank']);

            require_once('DBConnect.php');
            $connection = new DBConnect();
            $conn = $connection->getConnection();

            // Prepare the query
            $stmt = $conn->prepare("INSERT INTO elite_four(trainer_id,
                                    rank) VALUES (?, ?);");
            $stmt->bind_param("ii", $trainer_id, $rank);

            if($stmt->execute()) {
                header("Location: http://final.cowman.xyz/eliteFour.php");
            } else {
                CustomError::setError('Unable to add new Trainer.');
                header("Location: http://final.cowman.xyz/addEliteFour.php");
            }
        }
    ?>

    <form action="/addEliteFour.php" method="POST">
        <label for="trainer_id">Elite Four Trainer ID</label>
        <input type="text" name="trainer_id">
        <br><br>
        <label for="rank">Elite Four Rank</label>
        <input type="text" name="rank">
        <br><br>
        <input type="submit" value="Submit">
    </form>

    <br>

    <form action="/eliteFour.php">
        <input type="submit" value="Cancel">
    </form>

</body>
</html>