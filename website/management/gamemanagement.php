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
            echo "<span>You're not logged in. Please <a href='/modules/login/login.php'>log in.</a></span>";
            echo "\n\t</body>";
            echo "\n</html>";
            exit;

        }

        if (strcmp($_SESSION["roles"], "admin") != 0 && strcmp($_SESSION["roles"], "shopadmin") != 0) {
            echo "<span>You are not allowed to be here.</span>";
            echo "\n\t</body>";
            echo "\n</html>";
            exit;
        }

        $addgame = $_GET["addgame"];

        if (empty($addgame)) {
            echo "<div class='choose'>";
            echo "<div class='searchbar'>";
            echo "<form action='#' method='GET' target='body_frame'>";
            echo "<input type='text' name='search' placeholder='Search games to edit'>";
            echo "</form>";
            echo "</div>";
            echo "<div class='add'>";
            echo "<a href='gamemanagement.php?addgame=yes'><input type='button' value='Add game'></a>";
            echo "</div>";
            echo "</div>";

        }
        else if (strcmp("yes", $addgame) == 0) {
            ?>
                <div class="addform">
                    <form action="#" method="POST">
                        <input type="text" name="title" placeholder="TITLE" required>
                        <input type="text" name="platform" placeholder="PLATFORM">
                        <input type="text" name="price" placeholder="PRICE" required>
                        <input type="text" name="region" placeholder="REGION">
                        <input type="text" name="type" placeholder="TYPE">
                        <input type="text" name="img" placeholder="Put URL of picture here">
                        <input type="submit" name="submitgame" value="Add game">
                    </form>
                </div>
            <?php
            if (isset($_POST["submitgame"])) {
                $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

                if (empty($_POST["platform"])) {
                    $_POST["platform"] = "Steam";
                }
                if (empty($_POST["REGION"])) {
                    $_POST["region"] = "GLOBAL";
                }
                if (empty($_POST["TYPE"])) {
                    $_POST["type"] = "Key";
                }

                $query = "INSERT INTO games (title, platform, price, region, type) VALUES ('$_POST[title]', '$_POST[platform]', '$_POST[price]', '$_POST[region]', '$_POST[type]')";
                mysqli_query($connect, $query);
                
                $iquery = "SELECT id from games where title = '$_POST[title]'";
                $result = mysqli_query($connect, $iquery);        
                $gameid = mysqli_fetch_assoc($result);
                $url = "$_POST[img]";
                
                copy("$url", "../../IMG/$gameid[id]");
                
                mysqli_close($connect);
                header("refresh: 0; url=gamemanagement.php");
            }
        }

        $search = $_GET["search"];
        
        if ($search && !$_GET["gameid"]) { 

            $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

            $query = "SELECT * FROM games WHERE Match(title) AGAINST ('\"$search\"' IN BOOLEAN MODE) ORDER BY title";
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
        else if ($_GET["gameid"]) {
            $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

            $query = "SELECT * FROM games WHERE id = $_GET[gameid]";
            $result = mysqli_query($connect, $query);

            $re = mysqli_fetch_assoc($result);

            echo "\t<div class='centro'>\n";
            echo "\t\t\t<form action='#' method='POST'>\n";
            foreach ($re as $key => $value) {
                if (strcmp($key, "id") != 0) { 
                    $key = strtoupper($key);
                    echo "\t\t\t\t<input type='text' name='$key' placeholder='$key: $value'><br>\n";
                }
            }
            echo "\t\t\t\t<input type='text' name='newurl' placeholder='Update game cover'>\n";
            echo "\t\t\t\t<input type='submit' value='ABORT' name='abort'>\n";
            echo "\t\t\t\t<input type='submit' value='UPDATE' name='update'>\n";
            echo "\t\t\t</form>\n";
            echo "\t</div>\n";

            if (isset($_POST['update'])) {
                if (empty($_POST["TITLE"])) {
                    $_POST["TITLE"] = $re["title"];
                }
                if (empty($_POST["PLATFORM"])) {
                    $_POST["PLATFORM"] = $re["platform"];
                }
                if (empty($_POST["PRICE"])) {
                    $_POST["PRICE"] = $re["price"];
                }
                if (empty($_POST["REGION"])) {
                    $_POST["REGION"] = $re["region"];
                }
                if (empty($_POST["TYPE"])) {
                    $_POST["TYPE"] = $re["type"];
                }

                copy("$_POST[newurl]", "../../IMG/$re[id]");

                $uquery = "UPDATE games SET title = '$_POST[TITLE]', platform = '$_POST[PLATFORM]', price = '$_POST[PRICE]', region = '$_POST[REGION]', type = '$_POST[TYPE]' WHERE id = $re[id]";

                mysqli_query($connect, $uquery);

                unset($_GET["gameid"]);
                unset($search);
                mysqli_close($connect);

                header("refresh: 0; url=gamemanagement.php");
            }
            else if (isset($_POST['abort'])) {
                unset($_GET["gameid"]);
                unset($search);
                mysqli_close($connect);
                header("refresh: 0; url=gamemanagement.php");
            }
        }
    ?>
</body>
</html>