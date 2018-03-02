<div class="add">
                <form action="gamemanagement.php" method="POST" target="body_frame">
                    <input type="button" name="addgame" value="Add games">
                </form>
</div>

<?php
if (isset($_POST["addgame"])) {
            ?>
                <form action="#" method="POST">
                    <input type="text" name="title" placeholder="TITLE">
                    <input type="text" name="platform" placeholder="PLATFORM">
                    <input type="text" name="price" placeholder="PRICE">
                    <input type="text" name="region" placeholder="REGION">
                    <input type="text" name="type" placeholder="TYPE">
                    <input type="submit" name="submitgame" value="Add game">
                </form>
            <?php
            if (isset($_POST["submitgame"])) {
                $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

                $query = "INSERT INTO games (title, platform, price, region, type) VALUES ($_POST[title], $_POST[platform], $_POST[price], $_POST[region], $_POST[type])";
                $result = mysqli($connect, $query);

                echo "<span class='successful>GAME ADDED SUCCESSFULLY!</span>'";
                mysqli_close($connect);
                header("refresh: 1; url=gamemanagement.php");
            }
        }
?>