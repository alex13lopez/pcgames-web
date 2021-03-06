<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">    
    <title>Index</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <a href="/index.php"><img src="LOGO/logo.png" alt="logo.png"></a>
        </div>
        <div class="searchbar">
            <form action="website/search.php" method="GET" target="body_frame">
                <input type="text" name="search" placeholder="Search games">
            </form>
        </div>
        <div class="welcome">
            <?php
                session_start();

                if (isset($_SESSION["id"])) {
                    echo "<span> Welcome </span>";
                    echo "<span>".$_SESSION["user"]."</span>";
                }
            ?>
            
        </div>
        <?php 
            if (! isset($_SESSION["id"])) {
                echo "<div class=\"buttons\">";
                        echo "<div class='but1'><a href='/modules/login/login.php' target=\"body_frame\"><input type=\"button\" value=\"Login\"></a></div>";
                        echo "<div class='but2'><a href=\"/modules/registration/register.php\" target=\"body_frame\"><input type=\"button\" value=\"Sign up\"></a></div>";
                echo "</div>";
            }
            else {
                echo "<div class='buttons'>";
                echo "<div class='but1'><a href='/modules/login/logout.php' target='_parent'><input type=\"button\" value=\"Logout\"></a></div>";
                echo "<div class='but2'><a href=\"/website/cpanel/cpanel.php\" target='body_frame'><input type=\"button\" value=\"CPanel\"></a></div>";
                echo "</div>";
            }
        ?>
        
    </div>
    <div class="body">
        <iframe src="website/default-web/default-web.php" name="body_frame"></iframe>
    </div>
</body>
</html>