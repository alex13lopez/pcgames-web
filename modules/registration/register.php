<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<style>
    body {
        background-color: #66757F;

    }
</style>

<body>
    <?php

    session_start();

    $link = mysqli_connect("127.0.0.1", "root", "Abc@1234!", "pcgames");

    if (!$link) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    $mail = $_SESSION['email'];
    $user = $_SESSION['user'];
    $pass = password_hash($_SESSION['pass'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (email, user, passwd) VALUES ('$mail', '$user', '$pass')";
    mysqli_query($link, $query);
    mysqli_close($link);
    session_destroy();

    header('refresh: 0; url=/index.php');
    ?>
</body>
</html>