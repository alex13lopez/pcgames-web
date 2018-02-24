<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cpanel.css">
</head>
<body>
            <?php
                session_start();
                if (!$_SESSION["id"]) {
                    session_destroy();
                    echo "You're not logged in. Please <a href='../modules/login/login.html'>log in.</a>";
                    echo "\n\t</body>";
                    echo "\n</html>";
                    exit;
                }
            
                echo "<div class='cpanel'>";
                echo "<div class='profile'><a href='../profile/profile.php?id=$_SESSION[id]'><span>Profile<span></a></div>";
                echo "<div class='more'><span>Stay Tuned! More features coming soon!</span></div>";
                if (strcmp($_SESSION["roles"], "admin") == 0) {
                    echo "<div class='userManagement'><a href='../management/usermanagement.php'><span>Manage Users<span></div>";
                    echo "<div class='gameManagement'><a href='../management/gamemanagement.php'><span>Manage Games<span></div>";                    
                }
                else if (strcmp($_SESSION["roles"], "shopadmin") == 0) {
                    echo "<div class='gameManagement2'><a href='../management/gamemanagement.php'><span>Manage Games<span></div>";                    
                }
                echo "</div>";
            ?>
</body>
</html>