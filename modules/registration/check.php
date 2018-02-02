<?php
    session_start();
    
    $_SESSION["mail"] = $_POST["mail"];
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
    if (!$ERROR) {
        header("Location: confirm_registration.php");
    }
?>