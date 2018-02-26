<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="gamemanagement.css">
</head>
<body>
    <?php
        session_start();

        if (!$_SESSION["id"]) {
            echo "<span>You're not logged in. Please <a href='/modules/login/login.html'>log in.</a></span>";
            echo "\n\t</body>";
            echo "\n</html>";
            exit;

        }

        if (strcmp($_SESSION["roles"], "admin") != 0 && strcmp($_SESSION["roles"], "shopadmin") != 0) {
            echo "<span>Lo siento pero aquí pone que eres gilipollas!.";            
            // echo "<span>You are not allowed to be here.";
            echo "\n\t</body>";
            echo "\n</html>";
            exit;
        }

        $_GET["gameid"] = "3";
        if (!$_GET["gameid"]) { 

            $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

            $query = "SELECT * FROM games WHERE Match(title) AGAINST ('\"$search\"' IN BOOLEAN MODE) ORDER BY title LIMIT 5";
            $result = mysqli_query($connect, $query);

            ?>
            
            <table class="gamestable" align="center">
            <?php echo "<tr><th colspan='5'><center>FOUND GAMES IN DB MATCHING '$search'</center></th></tr>" ?>
            <tr>
                <th>Game</th>
                <th>Platform</th>
                <th>Type</th>    
            <?php
            while ($row = mysqli_fetch_array($result)) {
                echo '<tr><td>'."<a href='gamemanagement.php?gameid=$row[id]'>".$row["title"].'</a></td>';
                echo '<td>'.$row["platform"].'</td>';
                echo '<td>'.$row["type"].'</td></tr>';
            }

            echo "</table>";
            mysqli_close($connect);
        }
        else {
            $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

            $query = "SELECT * FROM games WHERE id = $_GET[gameid]";
            $result = mysqli_query($connect, $query);

            $re = mysqli_fetch_assoc($result);

            echo "\t<div class='centro'>\n";
            echo "\t\t\t<form action='#' method='POST'>\n";
            foreach ($re as $key => $value) {
                echo "\t\t\t\t<input type='text' name='$key' placeholder='$value' required><br>\n";
            }
            echo "\t\t\t\t<input type='submit' value='UPDATE' name='update'>\n";
            echo "\t\t\t\t<input type='submit' value='ABORT' name='abort'>\n";
            echo "\t\t\t</form>\n";
            echo "\t</div>\n";


            // unset($_GET["gameid"]);
        }
    ?>
</body>
</html>