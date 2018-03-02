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

        ?>
        <div class='choose'>
            <div class="searchbar">
                <form action="#" method="GET" target="body_frame">
                    <input type="text" name="search" placeholder="Search games to edit">
                </form>
            </div>
            <div class="add">
                <form action="#" method="GET">
                    <input type="button" name="add" value="ADD GAMES">
                </form>
            </div>
        </div>

        <?php
       
       $search = $_GET["search"];

        if ($search && !$_GET["gameid"]) { 

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

                $uquery = "UPDATE games SET title = '$_POST[TITLE]', platform = '$_POST[PLATFORM]', price = '$_POST[PRICE]', region = '$_POST[REGION]', type = '$_POST[TYPE]' WHERE id = $re[id]";

                mysqli_query($connect, $uquery);

                unset($_GET["gameid"]);
                unset($search);
                mysqli_close($connect);

                echo "<span class='successful>GAME UPDATED SUCCESSFULLY!</span>'";
                header("refresh: 1; url=gamemanagement.php");
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