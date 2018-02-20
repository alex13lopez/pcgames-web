<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="default-web.css">
</head>
<body>

    <?php

        $promotions_file = "promotions.txt";
        $lines = file($promotions_file);
        $last_week = (int) $lines[3];
        $current_week = (int) date('W');
        $promotions = (string) $lines[6];

        // if ($current_week == $last_week) {
        //     echo "It works :D";
        // }
        // else {
        //     echo "$current_week";
        //     echo "$last_week";
        // }
        
        $max_results = 10;
        $max_rows = 2;

        $link = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

        $query = "SELECT id, title FROM games WHERE id IN ($promotions)";
        $result = mysqli_query($link, $query);      

        echo "<div class='row'>";             
        while ($query_row=mysqli_fetch_array($result)) { 
            echo "<div class='column'>";
            echo "<div class='title'><span>".$query_row["title"]."</span></div>";
            echo "<div class='cover'><img src='../IMG/$query_row[id]'></div>";
            echo "</div>";        
            }     
        echo "</div>";

    ?>
</body>
</html>