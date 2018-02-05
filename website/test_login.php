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
                echo "You're not logged in, please log in: <a href='../modules/login/login.html'>Login</a>";
                exit;
            }
        ?>
        LOGGED IN SUCCESFULLY
</body>
</html>