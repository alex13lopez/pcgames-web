<?php
    session_start();

    $_SESSION["login"] = $_POST["login"];
    $_SESSION["pass"] = $_POST["pass"];


    $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

    if (!$connect) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    $login = $_SESSION["login"];
    $pass = $_SESSION["pass"];

    if (preg_match("/^.*@.*\.[[:alpha:]][[:alpha:]]+/", $login)) {
        # Is the login an email? 
        $get_user = "SELECT user FROM users WHERE email='$login'";
        $result = mysqli_query($connect, $get_user);

        $user = mysqli_fetch_array($result)["user"]; 
    }
    else {
        # Nope, it's a username
        $user = $login;
    }

    $query = "SELECT id, passwd FROM users WHERE user='$user'";
    $result = mysqli_query($connect, $query);

    $re = mysqli_fetch_array($result);
    $pass_h = $re["passwd"];

    if (password_verify($pass, $pass_h)) {
        $_SESSION["id"] = $re["id"];
        header("Location: /website/test_login.php");
    }

?>