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
                echo "<span class='pl-title'>Platform</span>";
                echo "<span class='pl-platform'>".$game["platform"]."</span>"
            ?>
        </div>
        <div class="type">
            <?php
                echo "<span class='ty-title'>Destribution type</span>";            
                echo "<span class='ty-type'>".$game["type"]."</span>"
            ?>
        </div>
        <div class="price">
            <?php
                echo "<span class='pr-title'>Price</span>";            
                echo "<span class='pr-price'>".$game["price"]."€</span>"
            ?>
        </div>        
    </div>
    <div class="description">
        <?php
            echo "<span class='descr-title'>Game Description</span>";                    
            // echo "<span class='descr'>".$game["desc"]."</span>"
            $loremipsum="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Et sollicitudin ac orci phasellus egestas tellus rutrum tellus pellentesque. Leo duis ut diam quam nulla. Proin sed libero enim sed. Aliquam purus sit amet luctus venenatis lectus magna fringilla. Dolor morbi non arcu risus quis varius quam quisque. Justo eget magna fermentum iaculis eu. Pulvinar sapien et ligula ullamcorper malesuada proin. Id donec ultrices tincidunt arcu non sodales neque sodales. Dolor sed viverra ipsum nunc. Vitae congue eu consequat ac felis donec et odio. Risus in hendrerit gravida rutrum quisque non. Fusce ut placerat orci nulla pellentesque dignissim enim sit. Faucibus purus in massa tempor nec. Fringilla phasellus faucibus scelerisque eleifend donec pretium.";
            echo "<span class='descr'>".$loremipsum."</span>";
        ?>
    </div>
</body>
</html>