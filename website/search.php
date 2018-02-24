<?php

    $search = $_GET["search"];

    $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

    if (!$connect) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    $query = "SELECT id, title, platform, type FROM games WHERE Match(title) AGAINST ('\"$search\"' IN BOOLEAN MODE) ORDER BY title LIMIT 5";

    $qresult = mysqli_query($connect, $query);
    ?>

    <style>
        .gamestable {
            width: 100%;
            vertical-align: middle;
            text-align: left;
        }

        body {
            color: #d5f4e6;
        }
        
        a {
            text-decoration: none;
            color: inherit;
        }

        a:hover {
            background-color: rgb(95, 150, 231);
        }

    </style>
    
    <table class="gamestable" align="center">
        <?php echo "<tr><th colspan='5'><center>FOUND GAMES IN DB MATCHING '$search'</center></th></tr>" ?>
        <tr>
            <th>Game</th>
            <th>Platform</th>
            <th>Type</th>    
        <?php
        while ($row=mysqli_fetch_array($qresult)) {
            echo '<tr><td>'."<a href='http://www.pcgames.com/website/gamepage/gamepage.php?id=$row[id]'>".$row["title"].'</a></td>';
            echo '<td>'.$row["platform"].'</td>';
            echo '<td>'.$row["type"].'</td></tr>';
        }

        echo "</table>";
?>