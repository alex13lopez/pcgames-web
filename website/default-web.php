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
        $lines = file($promotions_file,  FILE_IGNORE_NEW_LINES);
        $last_week = (string) $lines[1];
        $current_week = (string) date('W');

        if (strcmp($current_week, $last_week) != 0) {
            $link = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");
            $query = "SELECT id FROM games ORDER BY RAND() LIMIT 8";
            $result = mysqli_query($link, $query);
            $new_promotions = "";

            while ($row = mysqli_fetch_array($result)) {
                $new_promotions .= "$row[id],";
            }
            
            $new_promotions = substr($new_promotions, 0, -1);

            $lines[1] = $current_week;
            $lines[4] = $new_promotions;
            file_put_contents( $promotions_file , implode( "\n", $lines ) );
            mysqli_close($link);
        }
        
        $promotions = (string) $lines[4];

        $max_results = 10;
        $max_rows = 2;

        $link = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

        $query = "SELECT id, title FROM games WHERE id IN ($promotions)";
        $result = mysqli_query($link, $query);      

        echo "<div class='row'>";             
        while ($query_row = mysqli_fetch_array($result)) { 
            echo "<div class='column'>";
            echo "<div class='title'><span>".$query_row["title"]."</span></div>";
            echo "<div class='cover'><img src='../IMG/$query_row[id]'></div>";
            echo "</div>";        
            }     
        echo "</div>";
        mysqli_close($link);
        
    ?>
</body>
</html>