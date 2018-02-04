<?php
    session_start();
    
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["user"] = $_POST["user"];
    $_SESSION["pass"] = $_POST["pass"];
    $_SESSION["pwcheck"] = $_POST["pwcheck"];


    function CheckFields($checkme) {
        if (preg_match("/^[[:digit:]]/", $checkme)) {
            return FALSE;
        }
        return TRUE;  
    }

    
    function CheckPass($pass, $pwcheck) {
        if ($pass == $pwcheck) {
            return TRUE;
        }
        return FALSE;
    }


    function CheckRegistered($email, $user) {
        $link = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");

        if (!$link) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }

        $query_email = "SELECT email, user FROM users WHERE email='$email'";
        $query_user = "SELECT email, user FROM users WHERE user='$user'";

        $result_email = mysqli_query($link, $query_email);
        $result_user = mysqli_query($link, $query_user);

        $re = mysqli_fetch_array($result_email);
        $ru = mysqli_fetch_array($result_user);
        
        if ($re) {
            return 1;
        }
        else if ($ru) {
            return 2;
        }
        else {
            return 0;
        }


    }

    
    $ERROR = FALSE;
    foreach ($_SESSION as $field => $value) {
        if (($field != 'pass' && $field != 'pwcheck') && !CheckFields($value)) {
            echo "Field '$field' must not start with a digit.    ";
            session_destroy();
            ?>
            <form action="register.html">
                <input type='submit' value='Return to Main Form'><br>
            </form>
            <?php
            $ERROR = TRUE;
            break;
        }
        else if ($field == 'pass' && !CheckPass($value, $_SESSION["pwcheck"])) {
            echo "Passwords do not match, please make sure you typed them properly.    ";
            session_destroy();
            ?>
            <form action="register.html">
                <input type='submit' value='Return to Main Form'><br>
            </form>
            <?php
            $ERROR = TRUE;
            break;
        }
    }

    $registered = CheckRegistered($_SESSION["email"], $_SESSION["user"]);

    if ($registered == 1) {
        echo "The email is already registered. Do you have an account already? <a href='http://www.pcgames.com/modules/login/login.html'>Login</a>";
        $ERROR = TRUE;
    }
    else if ($registered == 2) {
        echo "Username already taken, please choose another username.";
        $ERROR = TRUE;
        header("refresh: 2, url: register.html");
    }

    if (!$ERROR) {
        header("Location: confirm_registration.php");
    }
?>