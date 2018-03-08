<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="default-web.css">
</head>
<body>
    <?php
        $link = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

        if (!isset($_GET['s'])) {
            $promotions_file = "promotions.txt";
            $lines = file($promotions_file,  FILE_IGNORE_NEW_LINES);
            $last_week = (string) $lines[1];
            $current_week = (string) date('W');

            if (strcmp($current_week, $last_week) != 0) {
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
            }
            
            $promotions = (string) $lines[4];

            $query = "SELECT id, title FROM games WHERE id IN ($promotions)";
            $result = mysqli_query($link, $query);      
            
            echo "<span class='title'> WEEKLY HIGHLIGHTS </span>";
            
            echo "<div class='row'>";             
            while ($query_row = mysqli_fetch_array($result)) { 
                echo "<div class='column'>";
                // echo "<div class='gametitle'><span>".$query_row["title"]."</span></div>";
                echo "<div class='cover'><a href='/website/gamepage/gamepage.php?id=$query_row[id]'><img src='/IMG/$query_row[id]'></a></div>";
                echo "</div>";        
                }     
            echo "</div>";
            
            echo "<div class='browse'><a href='default-web.php?s=0'><span>Browse all games >></span></a></div>";
        }
        else {
            $start = intval($_GET['s']);
            $max_results = 8;
           
            $pquery = "SELECT count(*) FROM games";
            
            $presult = mysqli_query($link, $pquery);
            $pquery = mysqli_fetch_row($presult)[0];

            $pquery = intval($pquery);
            $npages = $pquery / $max_results;


            $bquery = "SELECT id, title FROM games LIMIT $start, $max_results"; 

            $bresult = mysqli_query($link, $bquery);      

            echo "<span class='title'> BROWSING ALL GAMES </span>";

            echo "<div class='row'>";             
            while ($query_row = mysqli_fetch_array($bresult)) { 
                echo "<div class='column'>";
                // echo "<div class='gametitle'><span>".$query_row["title"]."</span></div>";
                echo "<div class='cover'><a href='/website/gamepage/gamepage.php?id=$query_row[id]'><img src='/IMG/$query_row[id]'></a></div>";
                echo "</div>";        
                }     
            echo "</div>";

            echo "<div class='pager'>";
            echo "<a href='default-web.php?s=0'><span>1 </span></a>";
            for ($i=2; $i <= $npages+1; $i++) {
                $s = $max_results * ($i-1);
                echo "<a href='default-web.php?s=$s'><span>$i </span></a>";
            }
            echo "</div>";
        }


        
        mysqli_close($link);
    ?>
</body>
</html>