<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="gamepage.css">
</head>
<body>
    <?php
        $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

        if (!$connect) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
    
        $query = "SELECT * FROM games WHERE id = $_GET[id]";
    
        $qresult = mysqli_query($connect, $query);
        $game = mysqli_fetch_array($qresult);
        mysqli_close($connect);
    ?>

    <div class="gametitle">
        <?php
            echo "<span class='title'>".$game["title"]."</span>"
        ?>
    </div>
    <div class="gamecover">
    <?php
        echo "<img src='../IMG/$_GET[id]'>"
    ?>
    </div>    
    <div class="gameinfo">
        <div class="platform">
            <?php
                echo "<span class='title'>".$game["platform"]."</span>"
            ?>
        </div>
        <div class="type">
            <?php
                echo "<span class='title'>".$game["type"]."</span>"
            ?>
        </div>
        <div class="price">
            <?php
                echo "<span class='title'>".$game["price"]."</span>"
            ?>
        </div>        
    </div>
    <div class="description">
        <?php
            echo "<span class='title'>".$game["desc"]."</span>"
        ?>
    </div>
</body>
</html>