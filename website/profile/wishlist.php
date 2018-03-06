<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="wishlist.css">
</head>
<body>

    <?php
        session_start();

        $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

        $wquery = "SELECT wishlist FROM users WHERE id = $_SESSION[id]";
        $wresult = mysqli_query($connect, $wquery);
        $wishlist = mysqli_fetch_assoc($wresult)["wishlist"];

        $gquery = "SELECT id, title, platform, price FROM games WHERE id IN ($wishlist)";
        $gresult = mysqli_query($connect, $gquery);

        echo "<div class='center'>";
        echo "<div class='pagetitle'><span>WISHLIST</span></div>";
        while ($row = mysqli_fetch_assoc($gresult)) {
            echo "<div class='game'>";
            echo "<a href='/website/gamepage/gamepage.php?id=$row[id]'>";
            echo "<div class='column title'><span>".$row["title"].'</span></div>';
            echo "<div class='column'><span>".$row["platform"].'</span></div>';
            echo "<div class='column'><span>".$row["price"].'€</span></div>';
            echo "</a>";
            echo "<a href='wishlist_control.php?r=$row[id]'><div class='column del'><img src='/IMG/delete.png'></div>";
            echo "</div>";
    }

    echo "</div>";
    mysqli_close($connect);
    ?>
    
</body>
</html>