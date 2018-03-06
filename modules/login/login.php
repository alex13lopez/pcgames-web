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
            if (strcmp($_GET["err"], "yes") == 0) {
                echo "<span class='err'>Login incorrect. Please try again.</span>";
            }
        ?>
        <form action="#" method="post">
            <input type="text" name="login" placeholder="Email or Username" required><br>
            <input type="password" name="pass" placeholder="Password" required><br>
            <input type="submit" name= "submit" value="Log me in">
        </form>
    </div>

    <?php
        if (isset($_POST["submit"])) {

            session_start();
            
            $_SESSION["login"] = $_POST["login"];
            $pass = $_POST["pass"];
            
            
            $connect = mysqli_connect("localhost", "root", "Abc@1234!", "pcgames");
            
            if (!$connect) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
            
            $login = $_SESSION["login"];
            
            if (preg_match("/^.*@.*\.[[:alpha:]][[:alpha:]]+/", "$login")) {
                # Is the login an email? 
                $get_user = "SELECT user FROM users WHERE email='$login'";
                $result = mysqli_query($connect, $get_user);
                
                $user = mysqli_fetch_array($result)["user"]; 
            }
            else {
                # Nope, it's a username
                $user = "$login";
            }
            
            $query = "SELECT id, user, passwd, roles FROM users WHERE user='$user'";
            $result = mysqli_query($connect, $query);
            
            $re = mysqli_fetch_array($result);
            $pass_h = $re["passwd"];
            
            mysqli_close($connect);
            
            if (password_verify($pass, $pass_h)) {
                $_SESSION["id"] = $re["id"];
                $_SESSION["roles"] = $re["roles"];
                $_SESSION["user"] = $re["user"];
                echo "<script>top.window.location = '/index.php'</script>";
            }
            else {
                header("refresh: 0, url=login.php?err=yes");
            }
        }
    ?>
</body>
</html>