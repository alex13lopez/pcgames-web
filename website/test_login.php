<!DOCTYPE html>
<html lang="en">
<head>
    <title>Priv Web</title>
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
            ?>
            LOGGED IN SUCCESFULLY
            <?php
                session_destroy();
            ?>
    </body>
</html>