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
            <img src="LOGO/logo3.png" alt="logo.png">
        </div>
        <div class="searchbar">
            <form action="website/search.php" method="GET" target="body_frame">
                <input type="text" name="search" placeholder="Search">
            </form>
        </div>
        <div class="welcome">
            <?php
                session_start();

                if (isset($_SESSION["id"])) {
                    echo "<span> Welcome "."</span>";
                    echo "<span>".$_SESSION["user"]."</span>";
                }
            ?>
            
        </div>
        <?php 
            if (! isset($_SESSION["id"])) {
                echo "<div class=\"buttons\">";
                        echo "<a href='http://www.pcgames.com/modules/login/login.html' target=\"body_frame\"><input type=\"button\" value=\"Login\"></a>";
                        echo "<a href=\"http://www.pcgames.com/modules/registration/register.html\" target=\"body_frame\"><input type=\"button\" value=\"Sign up\"></a>";
                echo "</div>";
            }
            else {
                echo "<div class='buttons'>";
                echo "<a href='http://www.pcgames.com/modules/login/logout.php' target='_parent'><input type=\"button\" value=\"Logout\"></a>";
                echo "<a href=\"http://www.pcgames.com/website/user_panel.php\" target='body_frame'><input type=\"button\" value=\"Control Panel\"></a>";
                echo "</div>";
            }
        ?>
        
    </div>
    <div class="body">
        <!-- REMINDER: Put in 'src' the default page that will load when the user loads the site -->
        <iframe src="website/default-web.php" name="body_frame"></iframe>
    </div>
</body>
</html>