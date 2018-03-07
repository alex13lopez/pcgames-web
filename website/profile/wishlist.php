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
        if (empty($wishlist)) {
            echo "<center><span class='err'>You have no games in your wishlist!</span><center>";
        }
        else { 
            while ($row = mysqli_fetch_assoc($gresult)) {
                echo "<div class='game'>";
                echo "<a href='/website/gamepage/gamepage.php?id=$row[id]'>";
                echo "<div class='column title'><span>".$row["title"].'</span></div>';
                echo "<div class='column'><span>".$row["platform"].'</span></div>';
                echo "<div class='column'><span>".$row["price"].'€</span></div>';
                echo "</a>";
                echo "<a href='wishlist.php?r=$row[id]'><div class='column del'><img src='/IMG/delete.png'></div></a>";
                echo "</div>";
            }
    }

    echo "</div>";

    if (!empty($_GET["r"])) {
        $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

        // $new_wishlist = str_replace(",$_GET[r]",'',$wishlist);
        $new_wishlist = preg_replace("/(^$_GET[r],)|(,$_GET[r]\$)|(,$_GET[r])|(^$_GET[r]\$)/", '', $wishlist, 1); // El 1 es para indicar máximo una substitución

        $uquery = "UPDATE users SET wishlist = '$new_wishlist' WHERE id = $_SESSION[id]";

        unset($_GET["r"]);
        mysqli_query($connect, $uquery);
        mysqli_close($connect);
        header("refresh: 0, url=wishlist.php");
    }

    mysqli_close($connect);
    ?>
    
</body>
</html>