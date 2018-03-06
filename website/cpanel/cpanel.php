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
                    echo "<span>You're not logged in. Please <a href='/modules/login/login.php'>log in.</a></span>";
                    echo "\n\t</body>";
                    echo "\n</html>";
                    exit;
                }
            
                echo "<div class='cpanel'>";
                echo "<a href='../profile/profile.php'><div class='profile'><span>Profile</span></div></a>";
                echo "<a href='../profile/wishlist.php'><div class='wishlist'><span>Wishlist</span></div></a>";
                if (strcmp($_SESSION["roles"], "admin") == 0) {
                    echo "<a href='../management/usermanagement.php'><div class='userManagement'><span>Manage Users</span></div></a>";                    
                    echo "<a href='../management/gamemanagement.php'><div class='gameManagement'><span>Manage Games</span></div></a>";                    
                }
                else if (strcmp($_SESSION["roles"], "shopadmin") == 0) {
                    echo "<a href='../management/gamemanagement.php'><div class='gameManagement2'><span>Manage Games</span></div></a>";                    
                }
                echo "</div>";
            ?>
</body>
</html>