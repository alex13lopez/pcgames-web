<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="../def-forms.css">
</head>
<body>
    <div class="center" align="center">
     <?php

        if (isset($_POST["submit"])) {
            session_start();
            
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["user"] = $_POST["user"];
            
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
                    echo "<span class='err'>Field '$field' must not start with a digit.</span>";
                    session_destroy();
                    $ERROR = TRUE;
                    break;
                }
            }
            
            $registered = CheckRegistered($_SESSION["email"], $_SESSION["user"]);
            
            if (!CheckPass($_POST["pass"], $_POST["pwcheck"])) {
                echo "<span class='err'>Passwords do not match, please make sure you typed them properly.</span>";
                session_destroy();
                $ERROR = TRUE;
            }
            else if ($registered == 1) {
                echo "<span class='err'>The email is already registered. Do you have an account already? <a href='http://www.pcgames.com/modules/login/login.php'>Login</a></span>";
                $ERROR = TRUE;
            }
            else if ($registered == 2) {
                echo "<span class='err'>Username already taken, please choose another username.</span>";
                $ERROR = TRUE;
            }
        }
        
        if (isset($_POST["submit"]) && !$ERROR) {
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
            
            echo "<script>top.window.location = 'http://www.pcgames.com'</script>";
        }
    ?>
        <form action="#" method="post">
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="text" name="user" placeholder="Username" required><br>
                <input type="password" name="pass" minlength="8" placeholder="Password" required><br>
                <input type="password" name="pwcheck" placeholder="Repeat Password" required><br>
                <input type="submit" name="submit" value="Sign Up">
        </form>
    </div>
</body>
</html>