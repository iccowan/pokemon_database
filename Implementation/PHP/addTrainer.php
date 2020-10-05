<!DOCTYPE html>
<html>
<head>
    <title>Pokemon League Trainers</title>
</head>
<body>
    <h1>Add A New Trainer</h1>
    <hr>
    <?php

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);


        //Check if POST variables are set and add them to the database
        if(isset($_POST['trainer_name']) || isset($_POST['hometown']) || isset($_POST['rival_id']))
        {
            $trainer_name = trim($_POST['trainer_name']);
            $trainer_hometown = trim($_POST['hometown']);
            $trainer_rival = trim($_POST['rival_id']);

            require_once('DBConnect.php');
            $connection = new DBConnect();
            $conn = $connection->getConnection();

            // Prepare the query
            $stmt = $conn->prepare("INSERT INTO trainers(trainer_name,
                                    hometown, rival_id) VALUES (?, ?, ?);");
            $stmt->bind_param("ssi", $trainer_name, $trainer_hometown, $trainer_rival);

            if($stmt->execute()) {
                header("Location: http://final.cowman.xyz/trainers.php");
            } else {
                CustomError::setError('Unable to add new Trainer.');
                header("Location: http://final.cowman.xyz/addTrainer.php");
            }
        }
    ?>

    <form action="/addTrainer.php" method="POST">
        <label for="trainer_name">Trainer Name</label>
        <input type="text" name="trainer_name">
        <br><br>
        <label for="hometown">Trainer Hometown</label>
        <input type="text" name="hometown">
        <br><br>
        <label for="rival_id">Trainer Rival ID</label>
        <input type="text" name="rival_id">
        <input type="submit" value="Submit">
    </form>

    <br>

    <form action="/trainers.php">
        <input type="submit" value="Cancel">
    </form>

</body>
</html>